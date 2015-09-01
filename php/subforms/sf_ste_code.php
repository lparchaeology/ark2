<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* sf_ste_code.php
*
* this is a subform for adding site codes
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2007  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <
*
* @category   user_home
* @package    ark
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2007 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/trunk/php/subforms/sf_ste_code.php
* @since      File available since Release 1.0
*
* DEV NOTE: This script works well as an sf, but it needs a companion update script
*
*/

$new_ste_cd = reqArkVar('new_ste_cd');
$reset = reqQst($_REQUEST, 'reset');

// Tidy these up
$cre_on = gmdate("Y-m-d H:i:s", time());

$mk_list = array(
                'stecdtitle',
                'addstecd',
                'resetform',
                'duplicate',
                'failure',
                'success',
                'go',
);

//loop over the list assigning mk to a variable of the same name
foreach ($mk_list as $required_mk){
    $mk_name = 'mk_'.$required_mk;
    $$mk_name =  getMarkup('cor_tbl_markup', $lang, $required_mk);
}
// Handle Resets
if ($reset == 1) {
    $_SESSION['new_ste_cd'] = FALSE;
}

// Some logic to decide which stage we are on
if ($update_db) {
    $stage = '2';
} else {
    $stage = '1';
}

// Produce a form element appropriate for the stage in hand
switch($stage) {
    case "1":
        // We have not got a new site code yet
        // A form is needed to allow new site code
        $form = "<p>$mk_addstecd</p>\n";
        $form .= "<form method=\"$form_method\" id=\"add_site_code\" action=\"{$_SERVER['PHP_SELF']}\">\n";
        $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $form .= "<input type=\"text\" name=\"new_ste_cd\" value=\"\" />";
        $form .= "<input type=\"hidden\" name=\"update_db\" value=\"1\" />";
        $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"{$sf_conf_name}\" />";
        $form .= "<button type=\"submit\">$mk_go</button>";
        $form .= "</form>\n";
        // Reset msg
        $reset_msg = FALSE;
    break;
    case "2":
        // This is the update routine
        //check to see if this site code already exists
        $unique = FALSE;
        $sql = "
            SELECT * FROM `cor_tbl_ste` WHERE id = ?
        ";
        $params = array($new_ste_cd);
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $unique = FALSE;
        } else {
                $unique = TRUE;
        }
        // second, add the attr to the lut
        if ($unique) {
            $sql = "
                INSERT INTO cor_tbl_ste (id, description, cre_by, cre_on)
                VALUES (?, ?, ?, ?)
            ";
            $params = array($new_ste_cd,'',$cre_by, $cre_on);
            $sql = dbPrepareQuery($sql,__FUNCTION__);
            $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        }
        // Measure and report success
        if ($new_ste_cd && $unique) {
            $form = "<p>$mk_success</p>";
            $form .= "<label>$new_ste_cd</label>";
            $reset_msg = "<br/><a class=\"delete\" href=\"{$_SERVER['PHP_SELF']}?reset=1&amp;sf_conf={$sf_conf_name}\">$mk_resetform</a>\n";
            //clean up
            unset($_SESSION['new_ste_cd']);
        } else {
                if (!$unique) {
                    $form = "<p>$mk_duplicate</p>\n";
                } else {
                        $form .= "<p>$mk_failure</p>\n";
                }
            $reset_msg = "<br/><a class=\"delete\" href=\"{$_SERVER['PHP_SELF']}?reset=1&amp;sf_conf={$sf_conf_name}\">$mk_resetform</a>\n";
        }
        break;
}

// Print out the Display
echo "<div class=\"mc_subform\">\n";
echo "<h4>$mk_stecdtitle</h4>\n";
echo "$form";
echo "$reset_msg";
echo "</div>\n";

?>
