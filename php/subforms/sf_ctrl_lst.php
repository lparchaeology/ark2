<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* sf_ctrl_lst.php
*
* this is a subform for adding aliased items to a control list
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
* @link       http://ark.lparchaeology.com/svn/alias_admin/viewalias.php
* @since      File available since Release 0.8
*
* DEV NOTE: non standard
*
*/

$attr_type_edt = reqArkVar('attr_type_edt');
$new_attr = reqArkVar('new_attr');
$ali_lang = reqArkVar('ali_lang', $lang);
$reset = reqQst($_REQUEST, 'reset');
$sf_conf_name = reqQst($_REQUEST, 'sf_conf');

//$lang

// DEV NOTE: ADD THESE TO STANDARD MARKUP TABLE
$cre_on = dbTimestamp();

// this is a list of all the markup nnames to be queried from the db
$mk_list = array(
                'addterm',
                'err_attrtypedontexist',
                'choosectrllst',
                'ctrllst',
                'language',
                'ctrllsttitle',
                'newterm',
                'resetform',
                'newtermlab',
                'similar',
                'langselector',
                'ifsure',
                'tryotherterm',
                'failure',
                'ctrlsttitle',
                'attrscss',
                'attrfail',
                'aliscss',
                'alifail',
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
    $_SESSION['attr_type_edt'] = FALSE;
    $new_attr = FALSE;
    $_SESSION['new_attr'] = FALSE;
}
if ($reset == 'retry') {
    $new_attr = FALSE;
    $_SESSION['new_attr'] = FALSE;
}

// Convert numeric attr_types to textual
if (is_numeric($attr_type_edt)) {
    $sql = "
        SELECT attributetype FROM `cor_lut_attributetype` WHERE id = ?
    ";
    $params = array($attr_type_edt);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $attr_type_edt = $row['attributetype'];
    } else {
        $attr_type_edt = FALSE;
    }
}

// Safety Check and Get Some Further Info
// If we have an attr_type_edt check its validity otherwise return an err
if ($attr_type_edt) {
    //A saftey check
    $sql = "
        SELECT id, attributetype FROM `cor_lut_attributetype` WHERE attributetype = ?
    ";
    $params = array($attr_type_edt);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $attr_type_edt = $row['attributetype'];
        //Retain the numeric for later
        $attr_type_edt_id = $row['id'];
    } else {
        $form = "<h4>$mk_err_attrtypedontexist</h4>";
        $attr_type_edt = FALSE;
    }
    // Get the alias
    $type_alias = getAlias('cor_lut_attributetype', $lang, 'id', $attr_type_edt_id, 1);
}

// Some logic to decide which stage we are on
if ($attr_type_edt) {
    if ($new_attr) {
        if ($update_db) {
            $stage = '4';
        } else {
            $stage = '3';
        }
    } else {
        $stage = '2';
    }
} else {
    $stage = '1';
}

// Produce a form element appropriate for the stage in hand
switch($stage) {
    case "1":
        // We have not got an attrtype yet
        // Make a drop down menu of types
        $ddt =
            ddAlias(
                FALSE,
                FALSE,
                'cor_lut_attributetype',
                $lang,
                'attr_type_edt',
                FALSE,
                'code'
        );
        // The form
        $form = "<p>$mk_choosectrllst</p>\n";
        $form .= "<form method=\"$form_method\" id=\"edit_controlled_list\" action=\"{$_SERVER['PHP_SELF']}\">\n";
        $form .= "<fieldset>\n";
        $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"{$sf_conf_name}\" />";
        $form .= $ddt;
        $form .= "<button type=\"submit\">$mk_go</button>";
        $form .= "</fieldset>\n";
        $form .= "</form>\n";
        // Reset msg
        $reset_msg = FALSE;
    break;
    
    case "2":
        // Allow a new term to be suggested
        // A menu of languages
        $dd_lang =
            ddSimple(
                $ali_lang, 
                $ali_lang,
                'cor_lut_language',
                'language',
                'ali_lang',
                "ORDER BY language",
                FALSE,
                'language'
        ); 
        // Put a form to choose the new term
        $form = "<h5>$mk_ctrllst: '$type_alias'</h5>";
        $form .= "<p>$mk_newterm:</p>";
        $form .= "<form method=\"$form_method\" id=\"edit_controlled_list\" action=\"{$_SERVER['PHP_SELF']}\">\n";
        $form .= "<fieldset>\n";
        $form .= "<input type=\"text\" name=\"new_attr\" value=\"\" />\n";
        $form .= "<input type=\"hidden\" name=\"ali_lang\" value=\"$lang\" />\n";
        $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"{$sf_conf_name}\" />";
        // Took this dd out for now as it seems counter intuitive
        // It makes it look to the user like you can add aliases in other languages to the same term
        // Whereas it actually adds an entirely new term
        //$form .= $dd_lang;
        $form .= "<button type=\"submit\">$mk_addterm</button>";
        $form .= "</fieldset>\n";
        $form .= "</form>\n";
        // Reset msg
        $reset_msg = "<br/><a class=\"reset\" href=\"{$_SERVER['PHP_SELF']}?reset=1&amp;sf_conf={$sf_conf_name}&amp;lboxreload=0\">$mk_resetform</a>\n";
    break;
    
    case "3":
        // We have got an attrtype and a new attr - Perform final checks
        // First check if there is already a similar term
        $sql = "
            SELECT *
            FROM `cor_lut_attribute` AS a, `cor_lut_attributetype` AS b, `cor_tbl_alias` AS c
            WHERE a.attributetype = b.id
            AND c.itemkey = 'cor_lut_attribute'
            AND c.itemvalue = a.id
            AND b.attributetype = ?
            AND c.alias LIKE ?
        ";
        $params = array('$attr_type_edt',"%$new_attr%");
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        // Handle the results
        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $similar = "<p>$mk_similar:</p>\n";
            $similar .= "<ul>\n";
            do {
                $similar .= "<li>{$row['alias']} ($mk_language: {$row['language']})</li>\n";
            } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
            $similar .= "</ul>\n";
        } else {
            $similar = FALSE;
        }
        // Make up the form element
        $form = "<p>$mk_newtermlab $new_attr</p>\n";
        $form .= $similar;
        $form .= "<p>$mk_ifsure</p>\n";
        // $form .= "<p><a href=\"{$_SERVER['PHP_SELF']}?reset=1&amp;sf_conf=conf_mcd_addctrllst\">$mk_tryotherterm</a></p>\n";        
        $form .= "<form method=\"$form_method\" id=\"edit_controlled_list\" action=\"{$_SERVER['PHP_SELF']}\">\n";
        $form .= "<fieldset>\n";
        $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $form .= "<input type=\"hidden\" name=\"update_db\" value=\"edit_controlled_list\" />\n";
        $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"{$sf_conf_name}\" />";
        $form .= "<button type=\"submit\">$mk_addterm</button>";
        $form .= "</fieldset>\n";
        $form .= "</form>\n";
        // Reset msg
        $reset_msg = "<br/><a class=\"reset\" href=\"{$_SERVER['PHP_SELF']}?reset=1&amp;sf_conf={$sf_conf_name}&amp;lboxreload=0\">$mk_resetform</a>\n";
    break;
    
    case "4":
        // This is the update routine
        // first we need to create a unique name for the attr
        $remove_this = array(" ","'",",","-","(",")"); 
        $nickname = str_replace($remove_this, '', strtolower($new_attr));
        $original_nickname = $nickname;
        //check to see if this nickname already exists
        $unique = FALSE;
        $i = 1;
        do {
            //loop
            $sql = "
                SELECT * FROM `cor_lut_attribute` WHERE attribute = ?
            ";
            $params = array($nickname);
            $sql = dbPrepareQuery($sql,__FUNCTION__);
            $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
            // Handle the results
            if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $nickname = $original_nickname.'_'.$i;
            } else {
                $unique = TRUE;
            }
            $i++;
        } while (!$unique);        
        // second, add the attr to the lut
        $sql = "
            INSERT INTO cor_lut_attribute (attribute, attributetype, module, cre_by, cre_on)
            VALUES (?, ?, ?, ?, ?)
        ";
        $params = array($nickname, $attr_type_edt_id, 'cor', $cre_by, $cre_on);
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        $new_attr_id = $db->lastInsertId();
        // NOW DO THE ALIAS
        $sql = "
            INSERT INTO cor_tbl_alias (alias, aliastype, language, itemkey, itemvalue, cre_by, cre_on)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";
        $params = array($new_attr, 1, $ali_lang, 'cor_lut_attribute', $new_attr_id, $cre_by, $cre_on);
        $logvars = "A new value was added to cor_tbl_alias. The sql: ". serialize($sql);
        $logtype = 'adnali';
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        $new_ali_id = $db->lastInsertId();
        $logvars = $logvars."\nThe new alias id is: $new_ali_id";
        logEvent($logtype, $logvars, $cre_by, $cre_on);
        
        // Measure and report success
        if ($new_attr_id && $new_ali_id) {
            $form = "<h5>$mk_success</h5>\n";
            //clean up
            unset($_SESSION['attr_type_edt']);
            unset($_SESSION['new_attr']);
        } else {
            $form = "<p>$mk_failure</p>\n";
        }
        if ($new_attr_id) {
            $form .= "<p>$mk_attrscss: $nickname (id: $new_attr_id)</p>\n";
        } else {
            $form .= "<p>$mk_attrfail. $nickname - $attr_type_edt</p>\n";
        }
        if ($new_ali_id) {
            $form .= "<p>$mk_aliscss: '$new_attr' ($mk_language: $ali_lang) - '$nickname'</p>\n";
        } else {
            $form .= "<p>$mk_alifail. '$new_attr' - '$nickname'</p>\n";
        }
        //clean up
        unset($_SESSION['ali_lang']);
        // Reset msg
        $reset_msg = "<br/><a class=\"reset\" href=\"{$_SERVER['PHP_SELF']}?reset=1&amp;sf_conf={$sf_conf_name}&amp;lboxreload=0\">$mk_resetform</a>\n";
        break;
}

// Print out the Display
echo "<div class=\"itemval_home\">\n";
echo "<h4>$mk_ctrllsttitle</h4>\n";
echo "$form";
echo "$reset_msg";
echo "</div>\n";
    

?>
