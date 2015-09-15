<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* user_admin/global_update.php
*
* global update for user admin
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
* @category   user
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/user_admin/global_update.php
* @since      File available since Release 0.6
*/


//Markup
$mk_err_nouname = getMarkup('cor_tbl_markup', $lang, 'err_nouname');
$mk_err_dupuname = getMarkup('cor_tbl_markup', $lang, 'err_dupuname');
$mk_err_nofname = getMarkup('cor_tbl_markup', $lang, 'err_nofname');
$mk_err_nolname = getMarkup('cor_tbl_markup', $lang, 'err_nolname');
$mk_err_noinit = getMarkup('cor_tbl_markup', $lang, 'err_noinit');
$mk_err_dupinit = getMarkup('cor_tbl_markup', $lang, 'err_dupinit');
$mk_err_noemail = getMarkup('cor_tbl_markup', $lang, 'err_noemail');
$mk_err_nopw = getMarkup('cor_tbl_markup', $lang, 'err_nopw');
$mk_err_nocpw = getMarkup('cor_tbl_markup', $lang, 'err_nocpw');
$mk_err_pwmatch = getMarkup('cor_tbl_markup', $lang, 'err_pwmatch');
$mk_err_nosgrp = getMarkup('cor_tbl_markup', $lang, 'err_nosgrp');
$mk_err_nouid = getMarkup('cor_tbl_markup', $lang, 'err_nouid');
$mk_err_dupusr = getMarkup('cor_tbl_markup', $lang, 'err_dupusr');

$error = array();

//OPTION 1 - ADDUSR

if ($update_db == 'addusr') {

    // trip the query needed switch

    $query_needed = 'G1';

    // request variables
    $uname = reqQst($_REQUEST,'uname');
    $fname = reqQst($_REQUEST,'fname');
    echo $lname = reqQst($_REQUEST,'lname');
    $init = reqQst($_REQUEST,'init');
    $email = reqQst($_REQUEST,'email');

    $cre_by = reqQst($_SESSION,'user_id');
    $cre_on = 'NOW()';

    // evaluate variables

    //FNAME
    // 1 - MUST BE SET
    if (!$fname) {
        $error[] = array('field' => 'fname', 'vars' => "$mk_err_nofname");
    }

    //LNAME
    // 1 - MUST BE SET
    if (!$lname) {
        $error[] = array('field' => 'lname', 'vars' => "$mk_err_nolname");
    }

    //INIT
    // 1 - MUST BE SET
    if (!$init) {
        $init = substr($fname,0,1).substr($lname,0,1);
    }

    // KILL SPACES
    $init = str_replace (' ', '', $init);
    // FORCE UPPER
    $init = strtoupper($init);
        
        // Uncomment this script to require all users to enter valid email
        // EMAIL
        // 1 - MUST BE SET
        // if (!$email) {
        // $error[] = array('field' => 'email', 'vars' => "$mk_err_noemail");
        // }
    if (!$error) {
        if (!$uname) {
            // Create a username from the initials and surname
            $username = makeUsrname($fname, $lname, $init, 'simple');
        } else {
            $username = $uname;
        }
    }

    //Check username is unique
    if (chkDupUsr($username)) {
        $error[] = array('field' => 'username', 'vars' => "$mk_err_dupusr");
    }

}

//OPTION 2 - ADUSRL

if ($update_db == 'adusrl') {

    // trip the query needed switch

    $query_needed = 'G2';

    // request variables
    $uname = reqQst($_REQUEST,'uname');
    $fname = reqQst($_REQUEST,'fname');
    $lname = reqQst($_REQUEST,'lname');
    $init = reqQst($_REQUEST,'init');
    $email = reqQst($_REQUEST,'email');
    $pw = reqQst($_REQUEST,'pw');
    $cpw = reqQst($_REQUEST,'cpw');
    $newabk = reqQst($_REQUEST,'newabk');

    $cre_on = dbTimestamp();

    // evaluate variables

    //FNAME
    // 1 - MUST BE SET
    if (!$fname) {
        $error[] = array('field' => 'fname', 'vars' => "$mk_err_nofname");
    }

    //LNAME
    // 1 - MUST BE SET
    if (!$lname) {
        $error[] = array('field' => 'lname', 'vars' => "$mk_err_nolname");
    }

    //INIT
    // 1 - MUST BE SET
    if (!$init) {//Check the username is unique
        $init = substr($fname,0,1).substr($lname,0,1);
    }
    if (chkDupInit($init)) { 
        $error[] = array('field' => 'init', 'vars' => "$mk_err_dupinit");
        $_SESSION['init']=$init;
    }

    // KILL SPACES
    $init = str_replace (' ', '', $init);
    // FORCE UPPER
    $init = strtoupper($init);

    //Uncomment this script to require all users to enter valid email 
    //EMAIL
    // 1 - MUST BE SET
    //if (!$email) {
    //$error[] = array('field' => 'email', 'vars' => "$mk_err_noemail");
    //}

    //PW and CPW
    // 1 - MUST BE SET
    if (!$pw) {
        $error[] = array('field' => 'pw', 'vars' => "$mk_err_nopw");
    }
    if (!$cpw) {
        $error[] = array('field' => 'cpw', 'vars' => "$mk_err_nocpw");
    }
    // 2 - MUST MATCH
    if ($pw != $cpw) {
        $error[] = array('field' => 'pw', 'vars' => "$mk_err_pwmatch");
    }

    if (!$error) {
        if (!$uname) {
            // Create a username from the initials and surname
            $username = makeUsrname($fname, $lname, $init, 'simple');
        } else {
            $username = $uname;
        }
    
        //Check the username is unique
        if (chkDupUsr($username)) {
            $error[] = array('field' => 'username', 'vars' => "$mk_err_dupusr");
        }

        //md5 the password
        $password = md5($pw);
        //Crypt the password
        //$salt = substr($username, 0, 2);
        //Encrypt the password
        //$password = crypt($pw, $salt);
    }

}

//OPTION 3 - EDTUSR

if ($update_db == 'edtusr') {

    // trip the query needed switch

    $query_needed = 'G3';

    // request variables
    $uname = reqQst($_REQUEST,'uname');
    $fname = reqQst($_REQUEST,'fname');
    $lname = reqQst($_REQUEST,'lname');
    $init = reqQst($_REQUEST,'init');
    $email = reqQst($_REQUEST,'email');

    $user_id = reqQst($_REQUEST,'user_id');
    $cre_by = reqQst($_SESSION,'user_id');
    $cre_on = dbTimestamp();

    // evaluate variables

    //FNAME
    // 1 - MUST BE SET
    if (!$fname) {
        $error[] = array('field' => 'fname', 'vars' => "$mk_err_nofname");
    }

    //LNAME
    // 1 - MUST BE SET
    if (!$lname) {
        $error[] = array('field' => 'lname', 'vars' => "$mk_err_nolname");
    }

    //INIT
    // 1 - MUST BE SET
    if (!$init) {
        $error[] = array('field' => 'init', 'vars' => "$mk_err_noinit");
    }

    // KILL SPACES
    $init = str_replace (' ', '', $init);
    // FORCE UPPER
    $init = strtoupper($init);

    //Uncomment this if all users require valid email address
    //EMAIL
    // 1 - MUST BE SET
    //if (!$email) {
    //$error[] = array('field' => 'email', 'vars' => "$mk_err_noemail");
    //}

}

//OPTION 4 - EDTPWD

if ($update_db == 'edtpwd') {

    // trip the query needed switch

    $query_needed = 'G4';

    // request variables
    $pw = reqQst($_REQUEST,'pwd');
    $cpw = reqQst($_REQUEST,'cpwd');

    $user_id = reqQst($_REQUEST,'user_id');
    $cre_by = reqQst($_SESSION,'user_id');
    $cre_on = dbTimestamp();

    // evaluate variables

    //PW and CPW
    // 1 - MUST BE SET
    if (!$pw) {
    $error[] = array('field' => 'pw', 'vars' => "$mk_err_nopw");
    }
    if (!$cpw) {
    $error[] = array('field' => 'cpw', 'vars' => "$mk_err_nocpw");
    }
    // 2 - MUST MATCH
    if ($pw != $cpw) {
    $error[] = array('field' => 'pw', 'vars' => "$mk_err_pwmatch");
    }

    if (!$error) {
        //Crypt the password
        //$username = getPeopleAttr($user_id, 'username');
        //$salt = substr($username, 0, 2);
        //Encrypt the password
        //$password = crypt($pw, $salt);
        $password = md5($pw);
    }

}

//OPTION 5 - ADSGRP

if ($update_db == 'adsgrp') {

    // trip the query needed switch

    $query_needed = 'G5';

    // request variables
    $sgrp_id = reqQst($_REQUEST,'group_id');

    $user_id = reqQst($_REQUEST,'user_id');
    $cre_by = reqQst($_SESSION,'user_id');
    $cre_on = dbTimestamp();

    // evaluate variables

    //USER_ID
    // 1 - MUST BE SET
    if (!$user_id) {
        $error[] = array('field' => 'user_id', 'vars' => "$mk_err_nouid");
    }

    //SGRP_ID
    // 1 - MUST BE SET
    if (!$sgrp_id) {
        $error[] = array('field' => 'sgrp_id', 'vars' => "$mk_err_nosgrp");
    }

}

//OPTION 6 - DLSGRP

if ($update_db == 'dlsgrp') {

    // trip the query needed switch

    $query_needed = 'G6';

    // request variables
    $group_id = reqQst($_REQUEST,'sgrp_id');

    $user_id = reqQst($_REQUEST,'user_id');
    $cre_by = reqQst($_SESSION,'user_id');
    $cre_on = dbTimestamp();

    // evaluate variables

    //USER_ID
    // 1 - MUST BE SET
    if (!$user_id) {
        $error[] = array('field' => 'user_id', 'vars' => "$mk_err_nouid");
    }

    //REL_ID
    // 1 - MUST BE SET
    if (!$group_id) {
        $error[] = array('field' => 'rel_id', 'vars' => "$mk_err_nosgrp");
    }

}

//OPTION 7a - USRDIS

if ($update_db == 'usrdis') {

    // trip the query needed switch

    $query_needed = 'G7';

    // request variables
    $account_enabled = 0;

    $user_id = reqQst($_REQUEST,'user_id');
    $cre_by = reqQst($_SESSION,'user_id');
    $cre_on = dbTimestamp();

    // evaluate variables

    //USER_ID
    // 1 - MUST BE SET
    if (!$user_id) {
        $error[] = array('field' => 'user_id', 'vars' => "$mk_err_nouid");
    }

}

//OPTION 7b - USRENA

if ($update_db == 'usrena') {

    // trip the query needed switch

    $query_needed = 'G7';

    // request variables
    $account_enabled = 1;

    $user_id = reqQst($_REQUEST,'user_id');
    $cre_by = reqQst($_SESSION,'user_id');
    $cre_on = dbTimestamp();

    // evaluate variables

    //USER_ID
    // 1 - MUST BE SET
    if (!$user_id) {
        $error[] = array('field' => 'user_id', 'vars' => "$mk_err_nouid");
    }

}

if ($update_db && !isset($query_needed) ){
    $query_needed = FALSE;
    foreach ( $conf_usredt_col['subforms'] as $cur_sf_id => $sf_conf ) {
        if ( $cur_sf_id === $update_db ){
            $fields = $sf_conf['fields'];
            include_once 'php/update_db.php';
        }
    }
}

// ---------- Execution ------------

//OPTION 1 - ADDUSR

if ($query_needed == 'G1' AND !$error) {

    $sql = "
    INSERT INTO cor_tbl_people (username, firstname, lastname, initials, email1, account_enabled)
    VALUES (?, ?, ?, ?, ?, ?)
    ";
    $params = array($username, $fname, $lname, $init, $email, 0);

    $logvars = 'The sql: '. serialize($sql);
    $logvars = $logvars.' Cre_by: '.$cre_by;
    $logtype = 'addusr';

    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $affected_rows = $sql->rowCount();

    if ($affected_rows == 1) {
        $message[] = getMarkup('cor_tbl_markup', $lang, 'addusr_sucs');
    }

    if ($logvars) {
        logEvent($logtype, $logvars, $cre_by, $cre_on);
    }

}

//OPTION 2 - ADUSRL

if ($query_needed == 'G2' AND !$error) {

    $sql = "
        INSERT INTO cor_tbl_users (username, password, firstname, lastname, initials, email, account_enabled)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ";
    $params = array($username, $password, $fname, $lname, $init, $email, 1);

    $logvars = 'The sql: '. serialize($sql);
    $logtype = 'adusrl';

    $sql = dbPrepareQuery($sql,"Add user err: ");
    $sql = dbExecuteQuery($sql,$params,"Add user err: ");
    $new_uid = $db->lastInsertId();
    $affected_rows1 = $sql->rowCount();
    $cre_by = $new_uid;

    if ($logvars) {
        logEvent($logtype, $logvars, $cre_by, $cre_on);
        unset ($logvars);
    }

    if ($new_uid) {

        //Use liveUser API to add user
        $user_to_add = array();
        $user_to_add['auth_container_name'] = 'ARK_USERS';
        $user_to_add['auth_user_id'] = $new_uid;
        $$liveuser_admin->perm->addUser($user_to_add);

        // Add the sgrp (add to default USERS group)
        $perm_user_id = getPermUserId($new_uid);
        $params = array( 'filters' => array(
                         'perm_user_id' => $perm_user_id
                        ) );
        $$liveuser_admin->perm->addUserToGroup(array('group_id' => 1, 'perm_user_id' => $perm_user_id));

    }
    
    if ( $new_uid && $newabk ){
        $newrecord = addItemKey('abk_cd', $ste_cd.'_next', $user_id, 'NOW()', 1);
        if ($newrecord['new_itemvalue']){
            $sql = "
                UPDATE cor_tbl_users SET
                itemkey = ?,
                itemvalue = ?
                WHERE id = ? 
                ";
            $params = array('abk_cd',$newrecord['new_itemvalue'],$new_uid);
            $sql = dbPrepareQuery($sql,"Auto ABK err: ");
            $sql = dbExecuteQuery($sql,$params,"Auto ABK err: ");
            $inittype = getClassType('txt', 'initials');
            $nametype = getClassType('txt', 'name');
            if ($inittype){
                addTxt($inittype, 'abk_cd', $newrecord['new_itemvalue'], $init, $lang, $user_id, 'NOW()');
            }
            if($nametype){
                addTxt($nametype, 'abk_cd', $newrecord['new_itemvalue'], $fname.' '.$lname, $lang, $user_id, 'NOW()');
            }
        }
    }

    if ($affected_rows1 == 1) {
        $message[] = getMarkup('cor_tbl_markup', $lang, 'addusr_newid');
        $message[] = "<a href=\"{$_SERVER['PHP_SELF']}/user_admin.php?view=edtuser&user_id=$new_uid\">".$username."</a>";
    }
    
    unset($_SESSION['fname']);
    unset($_SESSION['lname']);
    unset($_SESSION['email']);
    unset($_SESSION['init']);
    unset($_SESSION['uname']);
    unset($_POST['fname']);
    unset($_POST['lname']);
    unset($_POST['email']);
    unset($_POST['init']);
    unset($_POST['uname']);

}

//OPTION 3 - EDTUSR

if ($query_needed == 'G3' AND empty($error)) {
    $sql = "
        UPDATE cor_tbl_users
        SET
        firstname = ?,
        lastname = ?,
        initials = ?,
        email = ?
        WHERE id = ?
    ";
    $params = array($fname, $lname, $init, $email, $user_id);
    // FIRST GET THE EXISTING DATA SO THAT IT WONT GET LOST
    $logvars = getRow('cor_tbl_users', $user_id , FALSE);
    $log_ref = 'cor_tbl_users';
    $log_refid = $logvars['id'];
    $logtype = 'edtusr';


    $sql = dbPrepareQuery($sql,"Edit User");
    $sql = dbExecuteQuery($sql,$params,"Edit User");

    if ($logvars) {
        //logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }

}

//OPTION 4 - EDTPWD

if ($query_needed == 'G4' AND empty($error)) {

    $sql = "
    UPDATE cor_tbl_users
    SET password = ?
    WHERE id = ?
    ";
    $params = array($password,$user_id);

    // FIRST GET THE EXISTING DATA SO THAT IT WONT GET LOST
    $logvars = getRow('cor_tbl_users', $user_id , FALSE);
    $log_ref = 'cor_tbl_users';
    $log_refid = $logvars['id'];
    $logtype = 'edtpwd';
    
    $sql = dbPrepareQuery($sql,"Edit password err: ");
    $sql = dbExecuteQuery($sql,$params,"Edit password err: ");

    if ($logvars) {
      //logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }

}

//OPTION 5 - ADSGRP

if ($query_needed == 'G5' AND !$error) {

    //add the group
    $perm_user_id = getPermUserId($user_id);
    $logvars = getRow('cor_tbl_users', $user_id , FALSE);

    $params = array( 'filters' => array(
                     'perm_user_id' => $perm_user_id
                    ) );

    $$liveuser_admin->perm->addUserToGroup(array('group_id' => $sgrp_id, 'perm_user_id' => $perm_user_id));

    if ($logvars) {
        //logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }

}

//OPTION 6 - DLSGRP

if ($query_needed == 'G6' AND !$error) {

    //add the group

    $perm_user_id = getPermUserId($user_id);
    $logvars = getRow('cor_tbl_users', $user_id , FALSE);
    
    $params = array( 'filters' => array(
                     'perm_user_id' => $perm_user_id
                    ) );

    $$liveuser_admin->perm->removeUserFromGroup(array('group_id' => $group_id, 'perm_user_id' => $perm_user_id));

    if ($logvars) {
        //logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }

}

//OPTION 7 - USRDIS and USRENA

if ($query_needed == 'G7' AND !$error) {

    $sql = "
        UPDATE cor_tbl_users
        SET account_enabled = ?
        WHERE id = ?
    ";
    $params = array($account_enabled,$user_id);

    $sql = dbPrepareQuery($sql,"Enable/Disable Account Error");
    $sql = dbExecuteQuery($sql,$params,"Enable/Disable Account Error");

}

?>
