<?php
use LPArchaeology\ARK;

// -- INCLUDE SETTINGS AND FUNCTIONS -- //
include_once('src/settings.php');
include_once('php/global_functions.php');
include('php/validation_functions.php');

// required session init
session_name($ark_name);
session_start();

// required page setup
$page_conf = ARK\Web\PageConfig::page('chaintable');
if (!$page_conf->isValid()) {
    die ('ADMIN ERROR: No config in database for page '.$page_conf->id());
}
$psgrp = $page_conf->sgrp();

// authorisation script
require_once('php/auth/inc_auth.php');

$submiss_serial = $_SESSION['submiss_serial'];

// get the field and set it to $_REQUEST[]
$REQfield = reqQst($_REQUEST, 'field');
$field=$$REQfield;

if (key_exists('value', $_REQUEST)){
    $_REQUEST[$field['classtype']]=reqQst($_REQUEST, 'value');
}

if (key_exists($_REQUEST['field'], $_REQUEST)){
    $_REQUEST[$field['classtype']]=reqQst($_REQUEST,$_REQfield);
}

$tbl="cor_tbl_".$field['dataclass'];

// the cell id is exploded to get the fragment id
$cellidarray=explode('cell', reqQst($_REQUEST,'cellid'));
$cellid=explode("-",$cellidarray[1]);
// if there is a third part to the cellid array, this is an existing value
if (isset($cellid[2])){
    $fragid=$cellid[2];
    $_REQUEST[$field['classtype']."_qtype"] = "edt";
// otherwise it does not exist yet (so has no fragid)-we will have to add it    
} else {
    $_REQUEST[$field['classtype']."_qtype"] = "add";
    $_REQUEST[$field['dataclass']] = reqQst($_REQUEST,$field['field_id']);
}



// the itemkey and itemvalue are extracted from the root element(passed in the row id)
// these are used for adding new fragments
$rowid=explode('-', reqQst($_REQUEST,'rowid'));
if( !reqQst($_REQUEST, 'itemval')){
    $_REQUEST['itemval']=$rowid[1];
}

// Resolve itemkey
if( !reqQst($_REQUEST, 'itemkey')){
    $_REQUEST['itemkey']='cor_tbl_'.$rowid[0];
    
    // Resolve special case for itemkey (used in XMI) 
    if ($field['dataclass']=='itemkey'){
        $tbl=$field['module']."_tbl_".$field['module'];
        $_REQUEST['itemkey']=$rowid[0];
    }
    
    // if this is the root item, itemkey will be different
    // check if this is the root cell: check id first
    if ($rowid[1] == $fragid) {
        // then check the itemkey
        if ($field['dataclass'] == $rowid[0]) {
            // this is the root array, so get itemkey/itemval of the sf
            $http_referer=explode("?", $_SERVER['HTTP_REFERER']);
            $itemvalpair=explode("&", $http_referer[1]);
            $referer = explode("=", $itemvalpair[0]);
            $item_key = $referer[0];
            $_REQUEST['itemval'] = $referer[1];
        }
    }

}

$_REQUEST[$field['classtype']."_id"]=$fragid;


// for delete commands
if ($_REQUEST[$field['classtype']]=="delfrag"){
    $_REQUEST["delete_qtype"]="del";
    $update_db = 'delfrag';
    $_REQUEST['dclass']= $field['dataclass'];
    $_REQUEST["frag_id"]=$fragid;
}

//for attributes
$_REQUEST[$field['classtype']."_bv"]=1;


$update_db=TRUE;
$fields[]=$field;
include('php/update_db.php');

if (!is_numeric($fragid)){
    $fragid=$qry_results[0][0]['new_id'];
}
// check for errors
if($error['err']=="on" or !isset($message)){
    echo "<span class=\"error\"> ERROR ".$error[0]['vars']."</span>";
} else {

    switch ($field['dataclass']){
    case "attribute":
        echo "<span class=\"data\">".getAttr(FALSE, $fragid, 'SINGLE', 'alias', 'en')."</span>";
    break;
    case "span":
        $output_data = Array(
            "frag-id"=>$fragid,
        	"newSpan"=>resTblTd($field, reqQst($_REQUEST,'itemkey'), reqQst($_REQUEST,'itemval')),
        );
        $output_data = json_encode($output_data);
        header('Content-Type: application/json');;
        echo $output_data;;
    break;
    default:
    echo "<span class=\"data\">". reqQst($_REQUEST,'value')."</span>";
   }
}

?>
