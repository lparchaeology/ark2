<?php
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Schema\Comparator;

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
    'password' => 'ark_pass',
);
$new = \Doctrine\DBAL\DriverManager::getConnection($config);
$new->connect();

$config = array(
    'driver' => 'pdo_mysql',
    'host' => '127.0.0.1',
    'port' => '8889',
    'dbname' => 'ark_config',
    'user' => 'ark_user',
    'password' => 'ark_pass',
);
$config_db = \Doctrine\DBAL\DriverManager::getConnection($config);
$config_db->connect();

// New modules to clear
$modules = array('act', 'cxt', 'grp', 'lus', 'pln', 'rgf', 'sec', 'sgr', 'smp', 'spf', 'sph', 'ste', 'tmb');
// Standard dataclass list to import
$classes = array(
    'action' => 'cor_tbl_action',
    'attribute' => 'ark_dataclass_string',
    'date' => 'ark_dataclass_date',
    'file' => 'cor_tbl_file',
    'number' => 'ark_dataclass_integer',
    'span' => 'cor_tbl_span',
    'txt' => 'ark_dataclass_text',
    'xmi' => 'ark_dataclass_xmi',
);
$dataclass_tables = array(
    'cor_tbl_action' => 'cor_tbl_action',
    'cor_tbl_attribute' => 'ark_dataclass_string',
    'cor_tbl_date' => 'ark_dataclass_date',
    'cor_tbl_file' => 'cor_tbl_file',
    'cor_tbl_number' => 'ark_dataclass_integer',
    'cor_tbl_span' => 'cor_tbl_span',
    'cor_tbl_txt' => 'ark_dataclass_text',
    'cor_tbl_xmi' => 'ark_dataclass_xmi',
);
// classtypes to map to new property names
$propertMap = array(
    'cxtsheet' => 'sheet',
    'images' => 'image',
);

// Purge new tables
print_r("===========================================================================================\n\n");
print_r("Purging Tables\n\n");
foreach ($modules as $module) {
    clearTable($new, 'ark_module_'.$module);
}
foreach ($classes as $dataclass => $new_tbl) {
    clearTable($new, $new_tbl);
}
clearTable($new, 'cor_lut_file');
clearTable($new, 'ark_dataclass_graph');

// Add temp chain fields
$schema_new = $new->getSchemaManager()->createSchema();
$schema = clone $schema_new;
foreach ($classes as $dataclass => $new_tbl) {
    if (!$schema->getTable($new_tbl)->hasColumn('old_id')) {
        $schema->getTable($new_tbl)->addColumn('old_id', 'integer');
    }
    if (!$schema->getTable($new_tbl)->hasColumn('old_itemkey')) {
        $schema->getTable($new_tbl)->addColumn('old_itemkey', 'string', array("length" => 50));
    }
    if (!$schema->getTable($new_tbl)->hasColumn('old_itemvalue')) {
        $schema->getTable($new_tbl)->addColumn('old_itemvalue', 'string', array("length" => 50));
    }
}
$changes = $schema_new->getMigrateToSql($schema, $new->getDatabasePlatform());
foreach ($changes as $sql) {
    $new->executeUpdate($sql, array());
}

// Import ARKs
importArk('ark_minories', 'MNO12', '100 Minories', 'minories', false);
importArk('ark_prescot', 'PCO06', 'Prescot Street', 'prescot', false);
importArk('ark_olaves', 'SOL13', 'St Olaves', 'olaves', false);
importArk('ark_horsegroom', 'HGI13', 'Horse and Groom', 'horse', false);

// Remove temp chain fields
$schema_new = $new->getSchemaManager()->createSchema();
$schema = clone $schema_new;
foreach ($classes as $dataclass => $new_tbl) {
    if ($schema->getTable($new_tbl)->hasColumn('old_id')) {
        $schema->getTable($new_tbl)->dropColumn('old_id');
    }
    if ($schema->getTable($new_tbl)->hasColumn('old_itemkey')) {
        $schema->getTable($new_tbl)->dropColumn('old_itemkey');
    }
    if ($schema->getTable($new_tbl)->hasColumn('old_itemvalue')) {
        $schema->getTable($new_tbl)->dropColumn('old_itemvalue');
    }
}
$changes = $schema_new->getMigrateToSql($schema, $new->getDatabasePlatform());
foreach ($changes as $sql) {
    $new->executeUpdate($sql, array());
}


function importArk($dbname, $site, $name, $schema_id, $importSchema = true)
{
    global $new, $config_db, $classes, $dataclass_tables, $update;

    print_r("===========================================================================================\n\n");
    print_r('Importing Site '.$site.' from Database '.$dbname."\n\n");

    // Get old DB
    $config = array(
        'driver' => 'pdo_mysql',
        'host' => '127.0.0.1',
        'port' => '8889',
        'dbname' => $dbname,
        'user' => 'ark_user',
        'password' => 'ark_pass',
    );
    $old = \Doctrine\DBAL\DriverManager::getConnection($config);
    $old->connect();

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
                    SELECT $old_tbl.$itemkey AS itemkey, $type_tbl.$modtype AS modtype, $old_tbl.cre_by, $old_tbl.cre_on
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
                (id, parent, idx, name, modtype, cre_by, cre_on)
                VALUES (:id, :parent, :idx, :name, :modtype, :cre_by, :cre_on)
            ";
            $updates = 0;
            foreach ($items as $item) {
                $itemkey = explode('_', $item['itemkey']);
                $parent = $itemkey[0];
                $index = $itemkey[1];
                $id = $parent.'.'.$index;
                $modtype = (isset($item['modtype']) ? strtolower($item['modtype']) : '');
                $params = array(
                    ':id' => $id,
                    ':parent' => $parent,
                    ':idx' => $index,
                    ':name' => $item['itemkey'],
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

    // Insert the Site Module entry and name
    $sql = "
        INSERT INTO ark_module_ste
        (id, idx, name, schema_id)
        VALUES (:id, :idx, :name, :schema_id)
    ";
    $params = array(
        ':id' => $site,
        ':idx' => $site,
        ':name' => $site,
        ':schema_id' => $schema_id,
    );
    if ($update) {
        $new->executeUpdate($sql, $params);
    }
    $sql = "
        INSERT INTO ark_dataclass_text
        (module, item, property, language, value)
        VALUES (:module, :item, :property, :language, :value)
    ";
    $params = array(
        ':module' => 'ste',
        ':item' => $site,
        ':property' => 'name',
        ':language' => 'en',
        ':value' => $name,
    );
    if ($update) {
        $new->executeUpdate($sql, $params);
    }

    $parents = array();
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
                print_r('Skipping map frag : '.$frag['id'].' : '.$frag['itemkey'].' : '.$frag['itemvalue']."\n");
                continue;
            }
            // Skip if parent is a lut
            if (substr($frag['itemkey'], 0, 8) == 'cor_lut_') {
                print_r('Skipping lut frag : '.$frag['id'].' : '.$frag['itemkey'].' : '.$frag['itemvalue']."\n");
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
                print_r('Skipping orphan frag : '.$frag['id'].' : '.$frag['old_itemkey'].' : '.$frag['old_itemvalue']."\n");
                continue;
            }
            if ($dataclass == 'attribute') {
                $frag['value'] = fixAttribute($frag['attribute']);
                unset($frag['attribute']);
                unset($frag['boolean']);
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
                $frag['actor_item'] = $frag['actor_itemvalue'];
                unset($frag['actor_itemkey']);
                unset($frag['actor_itemvalue']);
            }
            if (isset($frag['xmi_itemkey'])) {
                if ($frag['xmi_itemkey'] == 'abk_cd') {
                    $frag['xmi_module'] = 'act';
                } else {
                    $frag['xmi_module'] = substr($frag['xmi_itemkey'], 0, 3);
                }
                $itemvalue = explode('_', $frag['xmi_itemvalue']);
                $parent = $itemvalue[0];
                if (!isset($itemvalue[1])) {
                    print_r('Skipping XMI frag : '.$frag['old_id'].' : '.$frag['xmi_itemkey'].' : '.$frag['xmi_itemvalue']."\n");
                    continue;
                }
                $index = $itemkey[1];
                $id = $parent.'.'.$index;
                $frag['xmi_item'] = $id;
                unset($frag['xmi_itemkey']);
                unset($frag['xmi_itemvalue']);
            }
            $itemvalue = explode('_', $frag['itemvalue']);
            $parent = $itemvalue[0];
            $index = $itemvalue[1];
            $id = $parent.'.'.$index;
            $frag['item'] = $id;
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
            if ($update) {
                $new->executeUpdate($sql, $params);
                $updates = $updates + 1;
            }
        }
        print_r($new_tbl.' : '.$updates."\n\n");
    }

    // Update the fragment chain graph

    // Add children to the graph
    foreach ($classes as $dataclass => $new_tbl) {
        $updates = 0;
        $sql = "
            SELECT $new_tbl.*
            FROM $new_tbl
            WHERE NULLIF(old_itemkey, '') IS NOT NULL
        ";
        $frags = $new->fetchAll($sql, array());
        $updates = 0;
        foreach ($frags as $frag) {
            if ($frag['old_itemkey'] && $frag['old_itemvalue']) {
                $tbl = $dataclass_tables[$frag['old_itemkey']];
                $sql = "
                    SELECT $tbl.*
                    FROM $tbl
                    WHERE module = :module
                    AND item = :item
                    AND old_id = :old_id
                ";
                $params = array(
                    ':module' => $frag['module'],
                    ':item' => $frag['item'],
                    ':old_id' => $frag['old_itemvalue'],
                );
                $head = $new->fetchAssoc($sql, $params);
                $parent = $tbl.'.'.$head['fid'];
                $child = $new_tbl.'.'.$frag['fid'];
                $sql = "
                    UPDATE $new_tbl
                    SET parent = :parent, old_id = '', old_itemkey = '', old_itemvalue = ''
                    WHERE fid = :fid
                ";
                $params = array(
                    ':fid' => $frag['fid'],
                    ':parent' => $parent,
                );
                if ($update) {
                    $new->executeUpdate($sql, $params);
                    $updates = $updates + 1;
                }
                // Add parent to the graph
                try {
                    $sql = "
                        INSERT INTO ark_dataclass_graph(parent, child, depth)
                        VALUES (:self, :self, 0)
                    ";
                    $params = array(
                        'self' => $parent,
                    );
                    if ($update) {
                        $new->executeUpdate($sql, $params);
                    }
                } catch (\Exception $e) {
                }
                // Add child to the graph
                $params = array(
                    'self' => $child,
                );
                if ($update) {
                    $new->executeUpdate($sql, $params);
                }
                // Add links to the graph
                $sql = "
                    INSERT INTO ark_dataclass_graph(parent, child, depth)
                        SELECT p.parent, c.child, p.depth+c.depth+1
                        FROM ark_dataclass_graph p, ark_dataclass_graph c
                        WHERE p.child = :parent and c.parent = :child
                ";
                $params = array(
                    ':parent' => $parent,
                    ':child' => $child,
                );
                if ($update) {
                    $new->executeUpdate($sql, $params);
                }
            }
        }
        print_r($new_tbl.' : chained : '.$updates."\n\n");
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

    if ($importSchema) {
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
            $config_db->executeUpdate($sql, $params);
            print_r(" - Done\n");
        }
        print_r("\n");
        $props = array();
        $modules[] = array('shortform' => 'ste');
        foreach ($modules as $mod) {
            $module = $mod['shortform'];
            if ($module == 'cor') {
                continue;
            }
            if ($module == 'abk') {
                $module = 'act';
            }
            $tbl = 'ark_module_'.$module;
            $sql = "
                SELECT *
                FROM $tbl
            ";
            $items = $new->fetchAll($sql, array());
            foreach ($items as $item) {
                foreach ($classes as $dataclass => $new_tbl) {
                    $sql = "
                        SELECT *
                        FROM $new_tbl
                        WHERE module = :module and id = :id
                    ";
                    $params = array(
                        ':module' => $module,
                        ':id' => $item['id'],
                    );
                    $frags = $new->fetchAll($sql, $params);
                    foreach ($frags as $frag) {
                        if ($frag['property']) {
                            $props[$module][$frag['property']] = $frag['property'];
                        }
                    }
                }
            }
        }
        $sql = "
            INSERT INTO ark_model_module
            (module, schema_id, modtype, property)
            VALUES (:module, :schema_id, :modtype, :property)
        ";
        foreach ($props as $module => $props) {
            print_r('Module '.$module.' has '.count($props)." properties with values:\n");
            foreach ($props as $property => $val) {
                print_r(' - '.$property."\n");
                $params = array(
                    ':module' => $module,
                    ':schema_id' => $schema_id,
                    ':modtype' => $module,
                    ':property' => $property,
                );
                if ($update) {
                    $config_db->executeUpdate($sql, $params);
                }
            }
            print_r("\n");
        }
    }
}

function insertRow($new_db, $row, $table)
{
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

function getParent($db, $tbl, $id)
{
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

function isTable($itemkey)
{
    return (substr($itemkey, 0, 8) == 'cor_tbl_');
}

function clearTable($db, $table)
{
    global $update;
    print_r("Clear table : $table");
    $sql = "TRUNCATE TABLE $table";
    if ($update) {
        $db->executeUpdate($sql, array());
        print_r(" - Done\n");
    }
    print_r("\n");
}

function fixAttribute($attr)
{
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
