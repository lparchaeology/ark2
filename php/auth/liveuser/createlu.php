<?php

PEAR::setErrorHandling(PEAR_ERROR_RETURN);

$$liveuser = &LiveUser::singleton($lu_conf);

if (!$$liveuser->init()) {
    var_dump($$liveuser->getErrors());
die();
}

if (array_key_exists('handle', $_REQUEST)){
    $handle = reqQst($_REQUEST,'handle');
}elseif ($$liveuser->getProperty('handle') != FALSE) {
    $handle = $$liveuser->getProperty('handle');
}else {
    $handle = NULL;
}
$passwd = reqQst($_REQUEST, 'passwd');
$passwd = $passwd ? $passwd: null;
$logout = reqQst($_REQUEST, 'logout');

/*check if we have an anonymous user and password, if we have then we can use this
    *to login (if there is no handle already sent)
     */
if (isset($anonymous_login) && !isset($handle) ){
    $handle = $anonymous_login['username'];
    $passwd = $anonymous_login['password'];
}

if ($logout) {
    $$liveuser->logout(true);
} elseif(!$$liveuser->isLoggedIn() || ($handle && $$liveuser->getProperty('handle') != $handle)) {
    if (!$handle) {
        $$liveuser->login(null, null, true);
    } else {
        $$liveuser->login($handle, $passwd);
    }
}
//now let's start up the LiveUser admin package

$$liveuser_admin = LiveUser_Admin::factory($lu_conf);
$$liveuser_admin->init();

?>
