<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* getFilter.php    
*
* this page transcludes the results of a filter or filterset into rendered HTML
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
* @category   api
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/api/getFilter.php
* @since      File available since Release 1.1
*/

//this file is included by the API wrapper page

// NOTE 1 : Currently although this has potential to present all the filter functionality - we are limiting it to
// a free text search and retrieving a previously saved filter. The filter building process is multi-step and too
// complicated currently for an asynchronous API to handle

// -- REQUESTS -- //

$ftype = reqQst($_REQUEST, 'ftype');
$src = reqQst($_REQUEST, 'src');
$retftrset = reqQst($_REQUEST, 'retftrset');
$disp_mode = reqArkVar('disp_mode', 'table');
// select the function to be used to return the exported results
$mk_func = 'mkResults'.ucfirst($disp_mode);

// -- SETUP VARS -- //
$errors = 0;
$data = array();

// -- OTHER -- // - as we are returning HTML we need to grab skins, etc.
// browser
$browser = browserDetect();
$stylesheet = getStylesheet($browser);
// textile
include_once ('lib/php/classTextile.php');
$textile = new Textile;

//all of the requests for filters are handled within the filter code, but we want to control what is allowed

//first make sure we reset any previous filters to prevent sessions being confused and spoof an id into the querystring

$_REQUEST['reset'] = 1;
$_REQUEST['ftr_id'] = 'getFilter';

//now do some checks to lockdown the functionality

if (!$ftype && !$src && !$retftrset) {
    echo "ADMIN ERROR: getFilter requires either ftype and src or retftrset";
    $error + 1;
}

if ($ftype) {
    
    if ($ftype != 'ftx' OR !$src) {
        echo "ADMIN ERROR: currently getFilter only works for free-text searches (ftype=ftx). If you have specifed ftype=ftx and you are still getting this message you also need to specifiy the search term src=searchterm";
        $error + 1;
    }
}

if ($retftrset && !is_numeric($retftrset)) {
    echo "ADMIN ERROR: the retftrset needs to be numeric - the id of saved filters can be obtained by using the describeFilters API method";
    $error + 1;
}

//now check we have no errors - if so run the bad boy - this is basically a wrapper for the filters.php page
if ($errors == 0) {
    
    //include the filters code - this will do all of the requesting that we need and should result in a results array
    include('php/data_view/filters.php');
    
    if ($results_array) {
        $data = $mk_func($results_array,$filters);
    }
       
}

?>

<?php echo "<!DOCTYPE ".$doctype.">" ?>

<html>
<head>
    <!-- title -->
    <title><?php echo $page_title ?></title>
    
    <!-- meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <!-- stylesheets -->
    <link href="<?php echo $stylesheet ?>" type="text/css" rel="stylesheet"  media="screen" />
    <link href="<?php echo $skin_path ?>/stylesheets/ark_main_print.css" type="text/css" rel="stylesheet" media="print" />
    <link href="<?php echo $skin_path ?>/stylesheets/lightbox.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo $skin_path ?>/images/ark_favicon.ico" rel="shortcut icon" />
    
    <!-- javascript libraries -->
    <script type="text/javascript" src="<?php echo $ark_lib_path ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $ark_lib_path ?>/js/php.js"></script>
    <script type="text/javascript" src="<?php echo $ark_lib_path ?>/js/prototype.js"></script>
    <script type="text/javascript" src="<?php echo $ark_lib_path ?>/js/scriptaculous.js?load=effects"></script>
    
    <!-- ARK javascript -->
    <script type="text/javascript" src="<?php echo $ark_root_path ?>/js/js_functions.js"></script>
    <script type="text/javascript" src="<?php echo $ark_root_path ?>/js/lightbox.js"></script>
    <script type="text/javascript" src="<?php echo $ark_root_path ?>/js/livesearch.js"></script>
</head>

<body>

    <!-- THE MAIN AREA -->
    <div id="main" class="">

    <?php

    // feedback
    if ($error) {
        echo "<div class=\"dv_feedback\">\n";
        feedBk('error');
        echo "</div>\n";
    }
    if ($message) {
        echo "<div class=\"dv_feedback\">\n";
        feedBk('message');
        echo "</div>\n";
    }

    // the results
    if (isset($data)) {
        echo "$data";
    }

    ?>

    </div>

    <!-- end content WRAPPER -->
    </div>


</body>
</html>
