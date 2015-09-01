<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* livesearch.php
*
* provides a URL from which live search results are returned
*
* PHP versions 4 and 5
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
* @category   tools
* @package    ark
* @author     Henriette Roued Olsen <henriette@roued.com>
* @author     Andy Dufton <a.dufton@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/livesearch.php
* @since      File available since Release 0.6
*
* Cleaned and checked at v1.x
*
*/


// INCLUDES
include_once ('../config/settings.php');
include_once ('global_functions.php');

// SESSION START
session_name($ark_name);
session_start();

// GLOBAL VARS
$db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
$lang = reqArkVar('lang', $default_lang);

// REQUEST
$q = reqQst($_REQUEST, 'q');
$table = reqQst($_REQUEST, 'table');
$order = reqQst($_REQUEST, 'order');
$id = reqQst($_REQUEST, 'id');
$type = reqQst($_REQUEST, 'type');
$link = reqQst($_REQUEST, 'link');
$mod = explode("_", $id)[0];

// MARKUP
$mk_nosuggestions = getMarkup('cor_tbl_markup', $lang, 'nosuggestions');

// if the length of the string q is more than 0
if (Strlen($q) > 0) {
    // setup a var
    $hint = FALSE;
    // set up a WHERE clause
    $where = "`$id` LIKE '%$q%' ORDER BY $order ASC";
    // run a getMulti() using the clause
    $results = getMulti($table, $where, $id);
    // loop over the results
    if ($results) {
        foreach ($results as $key => $result) {
            if ($link) {
                $hint .= "<li><a href=\"$link?item_key=$id&amp;$id={$result}\">{$result}</a></li>\n";
            } else {
                $hint .= '<li><a href="javascript:linktxt'.$type.'(\''.$result.'\',\''.$mod.'\')">'.$result.'</a></li>';
            }
        }
    }
}
// if there are no hints
if (!$results) {
    // respond with a message
    $response = "<ul><li><a href=\"$conf_data_viewer?view=standard\">$mk_nosuggestions</a></li></ul>\n";
} else {
    // respond with the list of hints
    $response = "<ul>\n$hint</ul>\n";
}

// OUTPUT
// Header
header("Cache-Control:no-cache, must-revalidate");
// echo the response
echo $response;

?>
