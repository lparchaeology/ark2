<?php
$fields = $sf_conf['fields'];
$mk_addnew = getMarkup('cor_tbl_markup', $lang, 'newphoto');
$fields = resTblTh($fields, 'silent');

$summary_text = getSingleText($sf_key, $sf_val, $fields['txt']['classtype'], $lang);;
$summary_textlabel = $fields['txt']['field_alias'];

$summary_date = getDateARK($sf_key, $sf_val, $fields['date']['classtype'], "rawdate");

$action_array = getActor($sf_key, $sf_val,  $fields['action']['classtype'], 'abk_cd');
$summary_eventlabel =$fields['action']['field_alias'];
if ($action_array) {
    foreach ( $action_array as $action ) {
    	$summary_actor = "<a href=\"{$ark_dir}micro_view.php?item_key=abk_cd&abk_cd={$action['actor_itemvalue']}\">";
    	
       $summary_actor .= getActorElem($action['actor_itemvalue'], 
                $fields['action']['actors_element'], 'abk_cd', 'txt');
       $summary_actor .= "</a>";
    }
} else {
    $summary_actor = "";
}
$summaryday = splitDate($summary_date,'dd');
$summarymon = splitDate($summary_date,'mm');
$summaryyear = splitDate($summary_date,'yr');

if ($summary_actor) {
    $event_summary = "<div class=\"summaryrow\">
            <div class=\"summarylabel\">$summary_eventlabel</div>
			<div class=\"summaryentry\">";
    $event_summary .= $summary_actor . " | " . $summaryday . "/" . $summarymon . "/" . $summaryyear;
    $event_summary .= "</div></div>";
} else {
    $event_summary = "";
}
$linked_files = array();
$linked_files_temp = array();
$batch = array();
$batch_files_temp = array();
// get existing data
if (array_key_exists('photo', $fields)) {
    $linked_files = getFile($sf_key, $sf_val, $fields['photo']['classtype']);
    if ($linked_files) {
        // package this up into the field so it can be sent to frmElem()
        foreach ( $linked_files as $linked_file ) {
            if (file_exists($registered_files_dir . $fs_slash . "webthumb_" . $linked_file['id'] . ".jpg")) {
                $photo_src = $registered_files_host . "webthumb_" . $linked_file['id'] . ".jpg";
                $summaryphoto = "<img src=\"$photo_src\" alt=\"{$linked_file['id']}\"/>";
            } else {
                $photo_src = "{$skin_path}/images/common/placeholder-find-photo.png";
                $summaryphoto = "<img src=\"$photo_src\"/>";
            }
            if (isset($photo_src)) {
                continue;
            }
        }
    } else {
        $photo_src = "{$skin_path}/images/common/placeholder-find-photo.png";
        $summaryphoto = "<img src=\"$photo_src\"/>";
        
        //
        $filetype = getClassType('file', $fields['photo']['classtype']);
        
        $add_new = "<a class=\"cboxlarge btn\" href=\"overlay_holder.php?&sf_conf=conf_mac_ipadonlybrowser&tab=from_ipad&link_file=item&sf_val=$sf_val&sf_key=$sf_key&filetype=$filetype\">$mk_addnew</a>";
        
        if (in_array($sf_state, array(
                        'p_max_edit',
                        's_max_edit',
                        'p_max_ent'
        ))) {
            $summaryphoto .= $add_new;
        }
    }
    $summaryphoto = "<div class=\"summaryphoto\"> $summaryphoto </div>";
} else {
    $summaryphoto = "";
}




?>
<div class='summary'>
	<div class="summarydesc">
		<div class="summaryrow">
			<div class="summarylabel"><?php echo $summary_textlabel;?>:</div>
			<div class="summaryentry"><?php echo $summary_text;?></div>
		</div>
		<?php echo $event_summary ?>
	</div>
	<?php echo $summaryphoto ?>
</div>
