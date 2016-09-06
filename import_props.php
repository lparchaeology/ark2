<?php

// First modify cor_tbl_module table to add modtype column and populate with modtype field name, i.e. abkttype, cxttype, etc.
// Run script and correct any incorrect data reported, duplicates, etc.

require_once 'vendor/autoload.php';

// Run in update
$update = true;

// Get new DB
$config = array(
    'driver' => 'pdo_mysql',
    'host' => '127.0.0.1',
    'port' => '8889',
    'dbname' => 'ark_data',
    'user' => 'ark_user',
    'password' => 'arkpass',
);
$new = \Doctrine\DBAL\DriverManager::getConnection($config);
$new->connect();

// New modules to clear
$modules = array('act', 'cxt', 'grp', 'lus', 'pln', 'rgf', 'sec', 'sgr', 'smp', 'spf', 'sph', 'ste', 'tmb');
// Standard dataclass list to import
$classes = array(
    'action' => 'cor_tbl_action',
    'attribute' => 'cor_tbl_attribute',
    'date' => 'ark_data_date',
    'file' => 'cor_tbl_file',
    'number' => 'ark_data_number',
    'span' => 'cor_tbl_span',
    'txt' => 'ark_data_string',
    'xmi' => 'ark_data_xmi',
);

// Purge new tables
if (true && $update) {
    print_r("===========================================================================================\n\n");
    print_r("Deleting Tables\n\n");
    foreach ($modules as $module) {
        clearTable($new, 'ark_module_'.$module);
    }
    foreach ($classes as $dataclass => $new_tbl) {
        clearTable($new, $new_tbl);
    }
    clearTable($new, 'cor_lut_file');
}

// Import ARKs
importSchema('ark_prescot', 'PCO06', 'prescot');
importSchema('ark_olaves', 'SOL13', 'olaves');
importSchema('ark_horsegroom', 'HGI13', 'horse');


function importSchema($dbname, $site, $schema_id) {
    global $new, $classes, $update;

    print_r("===========================================================================================\n\n");
    print_r("Deleting Schema $schema_id");
    $sql = "
        DELETE
        FROM ark_model_module
        WHERE schema_id = :schema_id
    ";
    $params = array(
        ':schema_id' => $schema_id,
    );
    if ($update) {
        $new->executeUpdate($sql, array());
        print_r(" - Done\n");
    }
    print_r("\n");

    print_r("===========================================================================================\n\n");
    print_r('Importing Site '.$site.' from Database '.$dbname."\n\n");

    // Get old DB
    $config = array(
        'driver' => 'pdo_mysql',
        'host' => '127.0.0.1',
        'port' => '8889',
        'dbname' => $dbname,
        'user' => 'ark_user',
        'password' => 'arkpass',
    );
    $old = \Doctrine\DBAL\DriverManager::getConnection($config);
    $old->connect();

    // Get the module list to import, note table needs modification to include modtype field
    $sql = "
        SELECT *
        FROM cor_tbl_module
    ";
    $modules = $old->fetchAll($sql, array());

    foreach ($modules as $mod) {
        $module = $mod['shortform'];
        if ($module != 'cor') {
            $itemkey = $module.'_cd';
            $old_tbl = $module.'_tbl_'.$module;
            $sql = "
                SELECT $old_tbl.$itemkey AS itemkey, $old_tbl.cre_by, $old_tbl.cre_on
                FROM $old_tbl
            ";
            $items = $old->fetchAll($sql, array());
            print_r($old_tbl.' : '.count($items)."\n");
            if ($module == 'abk') {
                $module = 'act';
            }
            $sql = "
                INSERT INTO $new_tbl
                (id, parent, item, modtype, cre_by, cre_on)
                VALUES (:id, :parent, :item, :modtype, :cre_by, :cre_on)
            ";
            $updates = 0;
            foreach ($items as $item) {
                $id = $item['itemkey'];
                $itemkey = explode('_', $item['itemkey']);
                $parent = $itemkey[0];
                $index = $itemkey[1];
                $modtype = (isset($item['modtype']) ? strtolower($item['modtype']) : '');
                $params = array(
                    ':id' => $id,
                    ':parent' => $parent,
                    ':item' => $index,
                    ':modtype' => $modtype,
                    ':cre_by' => $item['cre_by'],
                    ':cre_on' => $item['cre_on'],
                );
                if ($update) {
                    $new->executeUpdate($sql, $params);
                    $updates = $updates + 1;
                }
            }
            print_r($new_tbl.' : '.$updates."\n\n");
        }
    }

    // Copy the standard data classes
    foreach ($classes as $dataclass => $new_tbl) {
        $type = $dataclass.'type';
        $old_tbl = 'cor_tbl_'.$dataclass;
        $type_tbl = 'cor_lut_'.$type;
        if ($dataclass == 'attribute') {
            $sql = "
                SELECT cor_tbl_attribute.*, cor_lut_attribute.attribute, cor_lut_attributetype.attributetype
                FROM cor_tbl_attribute, cor_lut_attribute, cor_lut_attributetype
                WHERE cor_tbl_attribute.attribute = cor_lut_attribute.id
                AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
            ";
        } elseif ($dataclass == 'file') {
            $sql = "
                SELECT cor_tbl_file.*, cor_lut_filetype.filetype
                FROM cor_tbl_file, cor_lut_file, cor_lut_filetype
                WHERE cor_tbl_file.file = cor_lut_file.id
                AND cor_lut_file.filetype = cor_lut_filetype.id
            ";
        } elseif ($dataclass == 'xmi') {
            $sql = "
                SELECT $old_tbl.*
                FROM $old_tbl
            ";
        } else {
            $sql = "
                SELECT $old_tbl.*, $type_tbl.$type AS $type
                FROM $old_tbl, $type_tbl
                WHERE $old_tbl.$type = $type_tbl.id
            ";
        }
        $frags = $old->fetchAll($sql, array());
        print_r($old_tbl.' : '.count($frags)."\n");
        $updates = 0;
        foreach ($frags as $frag) {
            if (substr($frag['itemkey'], 0, 11) == 'cor_tbl_map') {
                continue;
            }
            // If itemkey/itemvalue is a chain reference, replace with actual item
            if (isTable($frag['itemkey'])) {
                $frag['old_itemkey'] = $frag['itemkey'];
                $frag['old_itemvalue'] = $frag['itemvalue'];
                $frag = array_merge($frag, getParent($old, $frag['itemkey'], $frag['itemvalue']));
            }
            // Skip if parent doesn't exist, i.e. orphaned frag!
            if ($frag['itemkey'] == null) {
                continue;
            }
            if ($dataclass == 'attribute') {
                $frag['attribute'] = fixAttribute($frag['attribute']);
            }
            if (isset($frag[$type])) {
                $frag['property'] = $frag[$type];
                unset($frag[$type]);
            }
            $frag['old_id'] = $frag['id'];
            unset($frag['id']);
            unset($frag['typemod']);
            unset($frag['fragtype']);
            unset($frag['fragid']);
            if (isset($frag['itemkey'])) {
                if ($frag['itemkey'] == 'abk_cd') {
                    $frag['module'] = 'act';
                } else {
                    $frag['module'] = substr($frag['itemkey'], 0, 3);
                }
            }
            if (isset($frag['actor_itemkey'])) {
                if ($frag['actor_itemkey'] == 'abk_cd') {
                    $frag['actor_module'] = 'act';
                } else {
                    $frag['actor_module'] = substr($frag['actor_itemkey'], 0, 3);
                }
                $frag['actor_id'] = $frag['actor_itemvalue'];
                unset($frag['actor_itemkey']);
                unset($frag['actor_itemvalue']);
            }
            if (isset($frag['xmi_itemkey'])) {
                if ($frag['xmi_itemkey'] == 'abk_cd') {
                    $frag['xmi_module'] = 'act';
                } else {
                    $frag['xmi_module'] = substr($frag['xmi_itemkey'], 0, 3);
                }
                $frag['xmi_id'] = $frag['xmi_itemvalue'];
                unset($frag['xmi_itemkey']);
                unset($frag['xmi_itemvalue']);
            }
            $frag['id'] = $frag['itemvalue'];
            unset($frag['itemkey']);
            unset($frag['itemvalue']);
            if (isset($frag['date'])) {
                $frag['value'] = $frag['date'];
                unset($frag['date']);
            }
            if (isset($frag['number'])) {
                $frag['value'] = $frag['number'];
                unset($frag['number']);
            }
            if (isset($frag['txt'])) {
                $frag['value'] = $frag['txt'];
                unset($frag['txt']);
            }
            $fields = array_keys($frag);
            $fl = implode(', ', $fields);
            if (count($fields) > 0) {
                $vl = str_repeat('?, ', count($fields) - 1).'?';
            } else {
                $vl = '';
            }
            $sql = "
                INSERT INTO $new_tbl ($fl)
                VALUES ($vl)
            ";
            $params = array_values($frag);
            $new->executeUpdate($sql, $params);
            $updates = $updates + 1;
        }
        print_r($new_tbl.' : '.$updates."\n\n");
    }

    // TODO Update enum table with all attribute values

    // Custom file conversion
    $sql = "
        SELECT *
        FROM cor_lut_file
    ";
    $data = $old->fetchAll($sql, array());
    print_r('cor_lut_file : '.count($data)."\n");
    $updates = 0;
    foreach ($data as $row) {
        unset($row['filetype']);
        unset($row['module']);
        $row['old_site'] = $site;
        $row['old_id'] = $row['id'];
        unset($row['id']);
        if ($update) {
            insertRow($new, $row, 'cor_lut_file');
            $updates = $updates + 1;
        }
    }
    print_r('cor_lut_file : '.$updates."\n\n");

    // TODO Update file table with new file ids

    // TODO Span stuff
    $special = array('spanlabel', 'spanattr');
}

function insertRow($new_db, $row, $table) {
    global $update;
    $fields = array_keys($row);
    $values = array_values($row);
    $fl = implode(', ', $fields);
    if (count($fields) > 0) {
        $vl = str_repeat('?, ', count($fields) - 1).'?';
    } else {
        $vl = '';
    }
    $sql = "
        INSERT INTO $table ($fl)
        VALUES ($vl)
    ";
    $params = array_values($row);
    if ($update) {
        $new_db->executeUpdate($sql, $params);
    }
}


