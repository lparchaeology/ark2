<!DOCTYPE html>
<!--[if IE 7 ]> <html class="ie ie7" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 8 ]> <html class="ie ie8" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 9 ]> <html class="ie ie9" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $page_title ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<link rel="shortcut icon" href="<?php echo "$skin_path" ?>/images/ark_favicon.ico" />
<link rel="apple-touch-icon-precomposed" href="<?php echo "$skin_path" ?>/images/apple-touch-icon-precomposed.png" />

<link rel="stylesheet" href="<?php echo "$skin_path" ?>/stylesheets/ark_main.css" />
<link rel="stylesheet" href="<?php echo "$skin_path" ?>/stylesheets/ark_main_responsive.css" />
<link href="<?php echo $skin_path ?>/stylesheets/colorbox.css" type="text/css" rel="stylesheet" />

<script type="text/javascript" src="//use.typekit.net/iuf7vfw.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!--[if IE]><script src="lib/js/ie.js"></script><![endif]-->
<?php echo "$javascript" ?>

</head>

<body>

<!-- THE CONTENT WRAPPER -->
<div id="wrapper" class="wrp_normal">

        <div id="hdr">
        <div class="logo"><a href="<?php echo $ark_dir;?>user_home.php"><img src="<?php echo "$skin_path" ?>/images/logo.png" alt="<?php echo "$skin_path" ?>" /></a></div>
        
        <div id="hdr-tools" class="keybtns">
        <div id="version">v<?php echo $version ?></div>
        
        <div id="user-info">
            <?php $userinfo = mkUserInfo(); echo($userinfo); ?>
        </div>
           <?php print(mkSearchBox());?>
          
        </div>
        <!-- DYNAMIC NAVIGATION -->
<div id="navcontainer" class="navcontainer">
    <?php print(mkNavMain($authorised_pages, $conf_linklist)) ?>
</div>
    
</div>
      