<?php

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
$classes = array('action', 'attribute', 'date', 'file', 'number', 'span', 'txt', 'xmi');

// Purge new tables
if (true && $update) {
    print_r("===========================================================================================\n\n");
    print_r("Purging Tables\n\n");
    foreach ($modules as $module) {
        clearTable($new, 'ark_module_'.$module);
    }
    foreach ($classes as $dataclass) {
        clearTable($new, 'cor_tbl_'.$dataclass);
    }
    clearTable($new, 'cor_lut_file');
}

// Import ARKs
importArk('ark_minories', 'MNO12');
importArk('ark_prescot', 'PCO06');
importArk('ark_stolaves', 'SOL13');
importArk('ark_horsegroom', 'HGI13');


function importArk($dbname, $site) {
    global $new, $classes, $update;

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
            if ($module == 'abk') {
                $new_tbl = 'ark_module_act';
            } else {
                $new_tbl = 'ark_module_'.$module;
            }
            if ($mod['modtype']) {
                $modtype = $mod['modtype'];
                $type_tbl = $module.'_lut_'.$modtype;
                $sql = "
                    SELECT $old_tbl.$itemkey AS itemkey, $type_tbl.$modtype AS subtype, $old_tbl.cre_by, $old_tbl.cre_on
                    FROM $old_tbl, $type_tbl
                    WHERE $old_tbl.$modtype = $type_tbl.id
                ";
            } else {
                $sql = "
                    SELECT $old_tbl.$itemkey AS itemkey, $old_tbl.cre_by, $old_tbl.cre_on
                    FROM $old_tbl
                ";
            }
            $items = $old->fetchAll($sql, array());
            print_r($old_tbl.' : '.count($items)."\n");
            if ($module == 'abk') {
                $module = 'act';
            }
            $sql = "
                INSERT INTO $new_tbl
                (site, item, subtype, cre_by, cre_on)
                VALUES (:site, :item, :subtype, :cre_by, :cre_on)
            ";
            $updates = 0;
            foreach ($items as $item) {
                $itemkey = explode('_', $item['itemkey']);
                $site = $itemkey[0];
                $key = $itemkey[1];
                $subtype = (isset($item['subtype']) ? $item['subtype'] : '');
                $params = array(
                    ':site' => $site,
                    ':item' => $key,
                    ':subtype' => $subtype,
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
    foreach ($classes as $dataclass) {
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
        $data = $old->fetchAll($sql, array());
        print_r($old_tbl.' : '.count($data)."\n");
        $new_tbl = 'cor_tbl_'.$dataclass;
        $updates = 0;
        foreach ($data as $frag) {
            if (substr($frag['itemkey'], 0, 11) == 'cor_tbl_map') {
                continue;
            }
            if ($dataclass == 'attribute') {
                $frag['attribute'] = fixAttribute($frag['attribute']);
            }
            $frag['old_site'] = $site;
            $frag['old_id'] = $frag['id'];
            unset($frag['id']);
            unset($frag['typemod']);
            unset($frag['fragtype']);
            unset($frag['fragid']);
            if (isTable($frag['itemkey'])) {
                $frag['parent_itemkey'] = $frag['itemkey'];
                $frag['parent_itemvalue'] = $frag['itemvalue'];
                $frag = array_merge($frag, getParent($old, $frag['itemkey'], $frag['itemvalue']));
            }
            if (isset($frag['itemkey']) && $frag['itemkey'] == 'abk_cd') {
                $frag['itemkey'] = 'act_cd';
            }
            if (isset($frag['actor_itemkey']) && $frag['actor_itemkey'] == 'abk_cd') {
                $frag['actor_itemkey'] = 'act_cd';
            }
            if (isset($frag['xmi_itemkey']) && $frag['xmi_itemkey'] == 'abk_cd') {
                $frag['actor_itemkey'] = 'act_cd';
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
            // Don't insert if parent doesn't exist!
            if ($frag['itemkey'] != null && $update) {
                $new->executeUpdate($sql, $params);
                $updates = $updates + 1;
            }
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

function getParent($db, $tbl, $id) {
    $sql = "
        SELECT *
        FROM $tbl
        WHERE id = ?
    ";
    $parent = $db->fetchAssoc($sql, array($id));
    if (isTable($parent['itemkey'])) {
        return getParent($db, $parent['itemkey'], $parent['itemvalue']);
    }
    return array('itemkey' => $parent['itemkey'], 'itemvalue' => $parent['itemvalue']);
}

function isTable($itemkey) {
    return (substr($itemkey, 0, 8) == 'cor_tbl_');
}

function clearTable($db, $table) {
    global $update;
    print_r("Clear table : $table");
    $sql = "TRUNCATE TABLE $table";
    if ($update) {
        $db->executeUpdate($sql, array());
        print_r(" - Done\n");
    }
    print_r("\n");
}

function fixAttribute($attr) {
    switch ($attr) {
        case '<5%':
            return 'lt5pcnt';
        case '5-20%':
            return '5to20pcnt';
        case '20-40%':
            return '20to40pcnt';
        case '40-60%':
            return '40to60pcnt';
        case '60-80%':
            return '60to80pcnt';
        case '80-100%':
            return '80to100pcnt';
        case '1:1':
            return 'ratio1to1';
        case '1:10':
            return 'ratio1to10';
        case '1:20':
            return 'ratio1to20';
        case '0.2m':
            return '02m';
        case '0.3m':
            return '03m';
        case '0.3m0.2m':
            return '03m02m';
        case '0.2m1m':
            return '02m1m';
        case '1m0.5m':
            return '1m05m';
        case '1m0.3m':
            return '1m03m';
        case '0.5m':
            return '05m';
        case '0.5m0.2m':
            return '05m02m';
        case '0.3m1m':
            return '03m1m';
        case '0.2m0.5m':
            return '02m05m';
        case '0.3m0.5m':
            return '03m05m';
        case '0.5m0.2':
            return '05m02';
        case '0.2m0.5m1m':
            return '02m05m1m';
        case '0.2m0.2m':
            return '02m02m';
        case 'c.t.p.':
            return 'ctp';
        case 'n/a':
            return 'na';
        case 'rb??':
            return 'rbq';
        case 'n/a_1':
            return 'na_1';
        case 'n/a_2':
            return 'na_2';
        default:
            return $attr;
    }
}

