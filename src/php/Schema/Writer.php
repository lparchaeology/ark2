<?php

// DB to JSON Schema
// Read from db for now, later direct from config?

namespace ARK\Schema;

require_once __DIR__.'../../../../vendor/autoload.php';

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Doctrine\DBAL\DBALException;

$writer = new Writer();
$writer->write();

class Writer
{

/*
forall fields write out definitions
* action = ??? object with date and actor?
* attributes = enum populated from lut
* date
* file = ??? object?
* geom = ??? object?
* itemkey = ??? string? object?
* modtype = string, enum from lut
* number
* span = ??? object
* txt = string
* xmi = ??? object? with href?

forall each module
  write meta
  forall each subform
  write meta
    forall fields etc
      write field definition links
*/

    public function write()
    {
        // Get the required details
        $config = array(
            'driver' => 'pdo_mysql',
            'host' => '127.0.0.1',
            'port' => '8889',
            'dbname' => 'ark_minories',
            'charset' => 'utf8',
            'user' => 'ark_user',
            'password' => 'ark_pass'
        );
        // Get the Connection
        try {
            $conn = \Doctrine\DBAL\DriverManager::getConnection($config);
        } catch (DBALException $e) {
            // DBALException: driverRequired, unknownDriver, invalidDriverClass, invalidWrapperClass(wrapperClass)
            echo 'Database configuration failed: '.$e->getCode().' - '.$e->getMessage();
            return false;
        }
        // Test the connection
        try {
            $conn->connect();
        } catch (DBALException $e) {
            // PDOException: SQL92 SQLSTATE code
            echo 'Database connection failed: '.$e->getCode().' - '.$e->getMessage();
            return false;
        }

        $fields = array();
        // ItemKey definition
        $fields['itemkey']['type'] = 'string';
        $fields['itemkey']['format'] = 'ark-itemkey';
        $fields['itemkey']['minLength'] = 6;
        $fields['itemkey']['maxLength'] = 6;
        // ItemKey definition
        $fields['itemvalue']['type'] = 'string';
        $fields['itemvalue']['format'] = 'ark-itemkey';
        // Item definition
        $field = array();
        $field['type'] = 'object';
        $field['properties'] = array();
        $field['properties']['itemkey']['$ref'] = 'itemkey';
        $field['properties']['itemvalue']['$ref'] = 'itemvalue';
        $field['required'] = array('itemkey', 'itemvalue');
        $field['additionalProperties'] = false;
        $fields['item'] = $field;
        // XMI definition
        $field = array();
        $field['type'] = 'object';
        $field['properties'] = array();
        $field['properties']['from']['$ref'] = 'item';
        $field['properties']['to']['$ref'] = 'item';
        $field['required'] = array('from', 'to');
        $field['additionalProperties'] = false;
        $fields['xmi'] = $field;
        // Span definition
        $field = array();
        $field['type'] = 'object';
        $field['properties'] = array();
        $field['properties']['from']['type'] = 'string';
        $field['properties']['to']['type'] = 'string';
        $field['required'] = array('from', 'to');
        $field['additionalProperties'] = false;
        $fields['span'] = $field;
        // Text definition
        $field = array();
        $field['type'] = 'object';
        $field['properties'] = array();
        $field['properties']['text']['type'] = 'string';
        $field['properties']['language']['type'] = 'string';
        $field['required'] = array('text', 'language');
        $field['additionalProperties'] = false;
        $fields['txt'] = $field;

        $cor_conf_field = $conn->fetchAll('SELECT * FROM cor_conf_field ORDER BY dataclass');
        foreach ($cor_conf_field as $row) {
            $field = array();
            switch ($row['dataclass']) {
                case 'action':
                    break;
                case 'attribute':
                    $field['type'] = 'string';
                    $attrtype = $conn->fetchAssoc('SELECT * FROM cor_lut_attributetype WHERE attributetype = ?', array($row['classtype']));
                    $type_id = $attrtype['id'];
                    $vals = $conn->fetchAll('SELECT * FROM cor_lut_attribute where attributetype = ?', array($type_id));
                    $field['enum'] = array();
                    foreach ($vals as $val) {
                        $field['enum'][] = $val['attribute'];
                    }
                    $fields[$row['classtype']] = $field;
                    break;
                case 'date':
                    $field['type'] = 'string';
                    $field['format'] = 'date-time';
                    $fields[$row['classtype']] = $field;
                    break;
                case 'delete':
                    break;
                case 'file':
                    $field['type'] = 'string';
                    $field['maxLength'] = 255;
                    $field['format'] = 'ark-filename';
                    $fields[$row['classtype']] = $field;
                    break;
                case 'geom':
                    break;
                case 'itemkey':
                    $field['$ref'] = "#/definitions/itemkey";
                    $fields[$row['classtype']] = $field;
                    break;
                case 'modtype':
                    $field['type'] = 'string';
                    $field['format'] = 'ark-modtype';
                    $lut = substr($row['classtype'], 0, 3).'_lut_'.$row['classtype'];
                    $vals = $conn->fetchAll("SELECT * FROM $lut");
                    $field['enum'] = array();
                    foreach ($vals as $val) {
                        $field['enum'][] = $val[$row['classtype']];
                    }
                    $fields[$row['classtype']] = $field;
                    break;
                case 'number':
                    $field['type'] = 'number';
                    $fields[$row['classtype']] = $field;
                    break;
                case 'op':
                    break;
                case 'span':
                    $field['$ref'] = "#/definitions/span";
                    $fields[$row['classtype']] = $field;
                    break;
                case 'txt':
                    $field['$ref'] = "#/definitions/txt";
                    $fields[$row['classtype']] = $field;
                    break;
                case 'xmi':
                    $field['$ref'] = "#/definitions/xmi";
                    $key = substr($row['field_id'] ,11);
                    $fields[$key] = $field;
                    break;
            }
        }
        print_r(json_encode($fields, JSON_PRETTY_PRINT));
        $conn->close();
        $conn = null;
        return true;
    }

}
