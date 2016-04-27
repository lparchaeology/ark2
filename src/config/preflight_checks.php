<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkdb/config/preflight_checks.php
*
* A page to run preflight checks on settings
*
* REMOVE FROM PRODUCTION PAGES
*
* PHP 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2008  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @category   base
* @package    ark
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2016 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/php/arkdb/config/preflight_checks.php
* @since      1.1
*
* NOTE: This file will expose your settings to the internet. You should remove this
* file or set it to be unreadable by your webserver after it has been used.
*
* Copy this file to your config folder, set $preflight_checks = TRUE and run page
* to check your settings. Delete the file from config afterwards.
*/


// -- ERROR REPORTING -- //
// ensure that any missing includes are fully flagged
if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}
error_reporting(E_ALL);


// -- INCLUDE SETTINGS AND FUNCTIONS -- //
include('../php/settings/settings.php');
include('../php/global_functions.php');
include('../php/validation_functions.php');


// -- LOCK DOWN -- //

// lock down preflight_checks to prevent accidental usage
$preflight_checks = FALSE;
// on servers using http_auth, you can supply credentials as follows (set FALSE if not using)
$credentials = "user:password";

if (!isset($preflight_checks)) {
    echo "Preflight Checks Not Enabled<br/>";
    break;
}
if (!$preflight_checks) {
    echo "Preflight Checks Not Enabled<br/>";
    break;
}

// {{{ chkFsDir()

/**
* checks a directory on the filesystem and returns information about it
*
* @param string $path  path to be checked
* @return array $ret  information about the directory
* @author Guy Hunt
* @since v1.1
*
*/

function chkFsDir($path)
{
    // set up
    $ret =
        array(
            'realpath' => 0,
            'exists' => 0,
            'readable' => 0,
            'writeable' => 0
    );
    // try to get a realpath for this
    if ($path = realpath($path)) {
        $ret['realpath'] = $path;
    } else {
        return $ret;
    }
    if (is_dir($path)) {
        $ret['exists'] = 1;
        if (is_readable($path)) {
            $ret['readable'] = 1;
        }
        if (is_writeable($path)) {
            $ret['writeable'] = 1;
        }
        return $ret;
    } else {
        return $ret;
    }
}

// }}}
// {{{ chkFsFile()

/**
* checks a file on the filesystem and returns information about it
*
* @param string $path  path to be checked
* @return array $ret  information about the file
* @author Guy Hunt
* @since v1.1
*
*/

function chkFsFile($path)
{
    // set up
    $ret =
        array(
            'realpath' => 0,
            'exists' => 0,
            'readable' => 0,
            'writeable' => 0
    );
    // try to get a realpath for this
    if ($path = realpath($path)) {
        $ret['realpath'] = $path;
    } else {
        return $ret;
    }
    if (is_file($path)) {
        $ret['exists'] = 1;
        if (is_readable($path)) {
            $ret['readable'] = 1;
        }
        if (is_writeable($path)) {
            $ret['writeable'] = 1;
        }
        return $ret;
    } else {
        return $ret;
    }
}

// }}}

function chkWebDir($path)
{
    // global
    global $protocol, $credentials;
    // setup
    $ret =
        array(
            'readable' => 0,
            'http_auth_required' => 0
    );
    // establish the protocol
    $ret['protocol'] = $protocol;
    // establish credentials
    if ($credentials) {
        $ret['credentialssupplied'] = 1;
        $auth_url = $protocol.$credentials.$_SERVER['HTTP_HOST'].$path;
    } else {
        $ret['credentialssupplied'] = 0;
        $auth_url = FALSE;
    }
    // establish the domain
    $ret['assumed_domain-http_host'] = $_SERVER['HTTP_HOST'];
    // establish the path to test
    $ret['tested_URL'] = $protocol.$_SERVER['HTTP_HOST'].$path;
    // first make a test without auth
    $headers = get_headers($ret['tested_URL'], 1);
    $code = substr($headers[0], 9, 3);
    if ($code == '200') {
        $ret['readable'] = 1;
        $ret['http_auth_required'] = 0;
    }
    if ($code == '401') {
        $ret['http_auth_required'] = 1;
        if ($auth_url) {
            $headers = get_headers($auth_url, 1);
            $code = substr($headers[0], 9, 3);
            // re-run the tests
            if ($code == '401') {
                $ret['readable'] = 1;
                $ret['credentialssupplied'] = 'HTTP_AUTH failed on credentials';
            }
            if ($code == '200') {
                $ret['readable'] = 1;
            }
        }
    }
    $ret['server_response'] = $headers[0];
    return $ret;
}

function chkConfigPathVar($var_name, $var_prop)
{
    // set up
    $errors = array();
    $ret = array('passorfail' => 0, 'feedback' => 0);
    // get the var
    global $$var_name;
    $var = $$var_name;
    if (!isset($var)) {
        $errors[] =
            array(
                'error' => 'missingvar',
                'msg' => "$var_name is not set",
        );
        $ret['passorfail'] = 'fail';
        $ret['feedback'] = $errors;
        return $ret;
    }
    // post process var_prop(erties)
    if ($var_prop['systemorweb'] == 'system') {
        // system
        // prevent trailing slashes for files or dirs
        $var_prop['preventtrailingslash'] = 1;
        // don't require trailing slashes
        $var_prop['requiretrailingslash'] = 0;
    } else {
        // web
        //don't prevent trailing slashes
        $var_prop['preventtrailingslash'] = 0;
        // require trailing slashes
        $var_prop['requiretrailingslash'] = 1;
        // don't test for must exist - readability test is sufficient
        $var_prop['mustexist'] = 0;
    }
    // in all cases remove colons and semicolons
    $var_prop['preventcolonsandsemicolons'] = 1;
    // get info
    if ($var_prop['systemorweb'] == 'system') {
        if ($var_prop['dirorfile'] == 'dir') {
            $info = chkFsDir($var);
        } else {
            $info = chkFsFile($var);
        }
    } else {
        $info = chkWebDir($var);
    }
    // look for trailing slashes
    if (substr($var, -1) == '/' OR substr($var, -1) == '\\') {
        $info['trailingslash'] = 1;
    } else {
        $info['trailingslash'] = 0;
    }
    // look for colons
    if (substr($var, 1) == ':' OR substr($var, 1) == ';') {
        $info['colonorsemicolon'] = 1;
    } else {
        $info['colonorsemicolon'] = 0;
    }
    // run the tests
    if ($var_prop['mustexist']) {
        if (!$info['exists']) {
            $errors[] =
                array(
                    'error' => 'mustexist',
                    'msg' => "$var_name: {$$var_name} doesn't exist",
            );
        }
    }
    if ($var_prop['mustbereadable']) {
        if (!$info['readable']) {
            $errors[] =
                array(
                    'error' => 'mustbereadable',
                    'msg' => "$var_name: {$$var_name} is not readable",
            );
        }
    }
    if ($var_prop['mustbewritable']) {
        if (!$info['writeable']) {
            $errors[] =
                array(
                    'error' => 'mustbewritable',
                    'msg' => "$var_name: {$$var_name} is not writable",
            );
        }
    }
    if ($var_prop['preventtrailingslash']) {
        if ($info['trailingslash']) {
            $errors[] =
                array(
                    'error' => 'preventtrailingslash',
                    'msg' => "$var_name: {$$var_name} has a trailing slash",
            );
        }
    }
    if ($var_prop['requiretrailingslash']) {
        if (!$info['trailingslash']) {
            $errors[] =
                array(
                    'error' => 'requiretrailingslash',
                    'msg' => "$var_name: {$$var_name} does not have a trailing slash",
            );
        }
    }
    if ($var_prop['preventcolonsandsemicolons']) {
        if ($info['colonorsemicolon']) {
            $errors[] =
                array(
                    'error' => 'preventcolonsandsemicolons',
                    'msg' => "$var_name: {$$var_name} contains a semicolon or colon",
            );
        }
    }
    // return
    if (empty($errors)) {
        $ret['passorfail'] = 'pass';
        $ret['feedback'] = "$var_name passed preflight checks";
        $ret['path_info'] = $info;
    } else {
        $ret['passorfail'] = 'fail';
        $ret['feedback'] = $errors;
        $ret['path_info'] = $info;
    }
    return $ret;
}

// -- SETUP COMMON VARIABLES -- //
// credentials if http_auth is in use
if (!isset($credentials)) {
    $credentials = FALSE;
}
// protocol
$protocol = 'http://';
// wiki
$wiki = "http://ark.lparchaeology.com/wiki/";
// pass
$pass = "<span style=\"color: green\">PASS</span>";
// fail
$fail = "<span style=\"color: red\">FAIL</span>";


// -- SESSION -- //
// Start the session
session_name($ark_name);
session_start();


// -- ENVIRONMENT SETTINGS -- //

// URL for docs for this file
$docs_url = $wiki.'index.php/Env_settings.php';

echo "<h1>Environment Settings [<a href=\"$docs_url\">docs</a>]</h1><br/>";


// SERVER TYPE
echo "Server Environment: $server</br>\n";


// GENERAL PATHS
echo "<h2>General Paths</h2><br/>";

// ark_root_dir
$var_name = 'ark_root_dir';
$var_properties =
    array(
        'dirorfile' => 'dir',
        'systemorweb' => 'system',
        'mustexist' => 1,
        'mustbereadable' => 1,
        'mustbewritable' => 0,
);
echo "<h3>$var_name [<a href=\"{$docs_url}#.24{$var_name}\">docs</a>]</h3>\n";
echo "$var_name: {$$var_name}</br>\n";
$chk = chkConfigPathVar($var_name, $var_properties);
if ($chk['passorfail'] == 'pass') {
    printPre($chk['path_info']);
    echo "$pass - $var_name is good to go<br/>";
} else {
    echo "$fail - $var_name failed preflight checks<br/>";
    printPre($chk);
}

// The path to the PEAR installation
$var_name = 'pear_path';
$var_properties =
    array(
        'dirorfile' => 'dir',
        'systemorweb' => 'system',
        'mustexist' => 1,
        'mustbereadable' => 1,
        'mustbewritable' => 0,
);
echo "<h3>$var_name [<a href=\"{$docs_url}#.24{$var_name}\">docs</a>]</h3>\n";
echo "$var_name: {$$var_name}</br>\n";
$chk = chkConfigPathVar($var_name, $var_properties);
if ($chk['passorfail'] == 'pass') {
    printPre($chk['path_info']);
    echo "$pass - $var_name is good to go<br/>";
} else {
    echo "$fail - $var_name failed preflight checks<br/>";
    printPre($chk);
}


// FILE STUFF
// registered_files_dir
$var_name = 'registered_files_dir';
$var_properties =
    array(
        'dirorfile' => 'dir',
        'systemorweb' => 'system',
        'mustexist' => 1,
        'mustbereadable' => 1,
        'mustbewritable' => 1,
);
echo "<h3>$var_name [<a href=\"{$docs_url}#.24{$var_name}\">docs</a>]</h3>\n";
echo "$var_name: {$$var_name}</br>\n";
$chk = chkConfigPathVar($var_name, $var_properties);
if ($chk['passorfail'] == 'pass') {
    printPre($chk['path_info']);
    echo "$pass - $var_name is good to go<br/>";
} else {
    echo "$fail - $var_name failed preflight checks<br/>";
    printPre($chk);
}

// registered_files_host
$var_name = 'registered_files_path';
$var_properties =
    array(
        'dirorfile' => 'dir',
        'systemorweb' => 'web',
        'mustexist' => 0, // ignored for web
        'mustbereadable' => 1,
        'mustbewritable' => 0,
);
echo "<h3>$var_name [<a href=\"{$docs_url}#.24{$var_name}\">docs</a>]</h3>\n";
echo "$var_name: {$$var_name}</br>\n";
$chk = chkConfigPathVar($var_name, $var_properties);
if ($chk['passorfail'] == 'pass') {
    printPre($chk['path_info']);
    echo "$pass - $var_name is good to go<br/>";
} else {
    echo "$fail - $var_name failed preflight checks<br/>";
    printPre($chk);
}

// default_upload_dir
$var_name = 'default_upload_dir';
$var_properties =
    array(
        'dirorfile' => 'dir',
        'systemorweb' => 'system',
        'mustexist' => 1,
        'mustbereadable' => 1,
        'mustbewritable' => 0,
);
echo "<h3>$var_name [<a href=\"{$docs_url}#.24{$var_name}\">docs</a>]</h3>\n";
echo "$var_name: {$$var_name}</br>\n";
$chk = chkConfigPathVar($var_name, $var_properties);
if ($chk['passorfail'] == 'pass') {
    printPre($chk['path_info']);
    echo "$pass - $var_name is good to go<br/>";
} else {
    echo "$fail - $var_name failed preflight checks<br/>";
    printPre($chk);
}

// export_dir
$var_name = 'export_dir';
$var_properties =
    array(
        'dirorfile' => 'dir',
        'systemorweb' => 'system',
        'mustexist' => 1,
        'mustbereadable' => 1,
        'mustbewritable' => 1,
);
echo "<h3>$var_name [<a href=\"{$docs_url}#.24{$var_name}\">docs</a>]</h3>\n";
echo "$var_name: {$$var_name}</br>\n";
$chk = chkConfigPathVar($var_name, $var_properties);
if ($chk['passorfail'] == 'pass') {
    printPre($chk['path_info']);
    echo "$pass - $var_name is good to go<br/>";
} else {
    echo "$fail - $var_name failed preflight checks<br/>";
    printPre($chk);
}

// phMagickDir
$var_name = 'phmagick_file';
$var_properties =
    array(
        'dirorfile' => 'file',
        'systemorweb' => 'system',
        'mustexist' => 1,
        'mustbereadable' => 1,
        'mustbewritable' => 0,
);
echo "<h3>$var_name [<a href=\"{$docs_url}#.24{$var_name}\">docs</a>]</h3>\n";
echo "$var_name: {$$var_name}</br>\n";
$chk = chkConfigPathVar($var_name, $var_properties);
if ($chk['passorfail'] == 'pass') {
    printPre($chk['path_info']);
    echo "$pass - $var_name is good to go<br/>";
} else {
    echo "$fail - $var_name failed preflight checks<br/>";
    printPre($chk);
}

// Testing other File Upload Matters
if (!extension_loaded('imagick')) {
    echo 'The PHP imagick extension is not installed';
} else {
    echo "imagick is installed on your PHP<br/>";
}
if (!extension_loaded('GD')) {
    echo 'The PHP GD extension is not installed';
} else {
    echo "GD is installed on your PHP<br/>";
}
echo "Testing for imageMagick's 'convert' command. System says:<br/>";
if (!$cmd_line_says = system('type -debug All convert')) {
    echo "Command line says: $cmd_line_says<br/>";
} else {
    echo "<br/>If the above response says that 'convert is [path]' then it should work<br/>";
}


// MAPPING DIRECTORIES
// Path to OpenLayers on local server
$openlayers_path = 'lib/js/openlayers/OpenLayers.js';
// You can also use OpenLayers directly if you are working online
//$openlayers_path = 'http://openlayers.org/api/OpenLayers.js';
// if you are using mapserver via the ark_wxs_server.php script then you will need to specify your mapfiles */
$ark_wms_map = '/srv/www/client-hosts/fastiadmin-vhost-docroot/admin/config/fasti.map';
// Path to WFS mapfile (server)
$ark_wfs_map = '/srv/www/client-hosts/fastiadmin-vhost-docroot/admin/config/fasti.map';

// database
echo "<h3>Database</h3><br/>";
// The mysql db name of this instance of ark
echo "ark_db: $ark_db</br>\n";
// The mysqlserver
echo "sql_server: $sql_server</br>\n";
// The mysql user who will make all the db calls
echo "sql_user: $sql_user</br>\n";
// The mysql user's password
//echo "sql_pwd: $sql_pwd</br>\n";
echo "sql_pwd: ****</br>\n";



?>