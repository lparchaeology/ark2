<?php echo "<!DOCTYPE ".$doctype.">"?>
<!--[if IE 7 ]> <html class="ie ie7" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 8 ]> <html class="ie ie8" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 9 ]> <html class="ie ie9" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml">
<!--<![endif]-->

<head>
<!-- title -->
<title><?php echo $page_title ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $page_title ?></title>

<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1" />

<link rel="shortcut icon"
	href="<?php echo "$skin_path" ?>/images/favicon.ico" />
<link rel="apple-touch-icon-precomposed"
	href="<?php echo "$skin_path" ?>/images/apple-touch-icon-precomposed.png" />

<link rel="stylesheet"
	href="<?php echo "$skin_path" ?>/stylesheets/ark_main.css" />
<link rel="stylesheet"
	href="<?php echo "$skin_path" ?>/stylesheets/ark_main_responsive.css" />
<script type="text/javascript" src="//use.typekit.net/iuf7vfw.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900">

<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<!--[if IE]><script src="<?php echo "$ark_dir" ?>lib/js/ie.js"></script><![endif]-->

<link href="<?php echo $skin_path ?>/images/ark_favicon.ico"
	rel="shortcut icon" />
</head>

<body>

<!-- THE CONTENT WRAPPER -->
<div id="wrapper" class="wrp_normal">
<!-- HEADER -->
<div id="header-wrapper">
 
<div id="hdr-print">
    <img src="skins/<?php echo $skin ?>/images/logo.png" alt="logo" />
</div>
<div id="hdr">

    <div class="logo"><a href="<?php echo $ark_dir;?>user_home.php"><img src="<?php echo "$skin_path" ?>/images/logo.png" alt="<?php echo "$skin_path" ?>" /></a></div>
        
    <div id="hdr-tools">    
        <div id="version">v<?php echo $version ?></div>
        <!-- user info -->
        <div id="user-info">
            <?php $userinfo = mkUserInfo(); echo($userinfo); ?>
        </div>
        <?php print(mkSearchBox());?>
    </div>
    
</div>

<!-- The LEFT PANEL -->
<div id="lpanel">
    <h1><?php echo getMarkup('cor_tbl_markup', $lang, 'logintitle')?></h1>
    <?php if ($errorMessage) echo "<div id=\"message\"><p>$errorMessage</p></div>" ?>

    <div class="login_form">
        <form id="login" method="post" action="<?php echo $ark_dir ?>user_home.php">
            <ul>
                <li class="row">
                    <h5 class="login_label">User name:</h5>
                    <span class="login_inp">
                        <input class="login_inp" name="handle" type="text"  placeholder="Username" value=""/>
                    </span>
                </li>
                <li class="row">
                    <h5 class="login_label">Password:</h5>
                    <span class="login_inp">
                        <input class="login_inp" name="passwd" type="password" placeholder="Password" value=""/>
                    </span>
                </li>
                <li class="row">
                    <h5 class="login_label">&nbsp;</h5>
                    <span class="login_inp">
                        <input class="button" type="submit" value="log in" />
                    </span>
                </li>
            </ul>
        </form>
    </div>
</div>
</div>
<!-- THE MAIN AREA -->
<div id="main" class="main_normal">
    <div id="message"><?php echo $page_title ?></div>
    <div id="splash"><?php echo "$mk_splash" ?></div>
</div>


<!-- ARK FOOTER -->
<div id="ark_footer">
    <?php $footer = mkArkFooter(); echo($footer); ?>
</div>

	<!-- END sitewrapper -->

	<!-- Modernizr -->
	<script src="<?php echo "$ark_dir" ?>lib/js/modernizr.js"></script>

	<!-- CSSUA -->
	<script src="<?php echo "$ark_dir" ?>lib/js/cssua.js"></script>

	<!-- Common -->
	<script src="<?php echo "$ark_dir" ?>lib/js/common.js"></script>

</body>