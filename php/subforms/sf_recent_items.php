<?php 
if (array_key_exists('op_num_rows', $sf_conf)) {
    $num_reg_rows = $sf_conf['op_num_rows'];
} else {
    $num_reg_rows = '10';
}
$recentitems = getRegisterRows($mod_short, $item_key, $ste_cd, $num_reg_rows);

// This is quick and horribly dirty to get things going in the field
// need a serious think about how we should handle this, embedding 
// trench numbers in cxt numbers is done, our system should be able 
// to handle that
if (isset($sf_conf['trenchno_filter'])) {
    $trenchno = reqArkVar('trenchno', 'all');
    
    if ($trenchno == 'all' || ($sf_key != 'cxt_cd' && $sf_key != 'fea_cd')) {
        $trenchno = FALSE;
    }
    
    $testlength = 6;
    if ($sf_key == 'fea_cd') {
        $testlength = 5;
    }
    
    if ($trenchno && $recentitems) {
        $trenchitems = array();
        foreach ( $recentitems as $item ) {
            $testkey = $item[$sf_key];
            if (substr($testkey, 3, strlen($trenchno)) == $trenchno && (strlen($testkey) - strlen($trenchno)) == $testlength) {
                $trenchitems[] = $item;
            }
        }
        $recentitems = $trenchitems;
    }
    
    $options = '<form class="addinventory" action="" method="get">';
    $options .= '<label  class="fieldhalf">Filter by Trench Number</label>';
    $options .= '<div  class="fieldhalf">';
    $options .= '<select name="trenchno"  onchange="$(this).parent().parent().submit()" >';
    
    $trenchnos = array(
                    1,
                    8,
                    9,
                    10,
                    11,
                    12,
                    13
    );
    $options .= '<option value="all">-</option>';
    foreach ( $trenchnos as $trench ) {
        $options .= '<option value="' . $trench;
        if ($trenchno == $trench) {
            $options .= '" selected="true';
        }
        $options .= '">' . $trench . '</option>';
    }
    
    $options .= '</select>';
    $options .= '</div>';
    $options .= '</form>';
    
    if ($sf_key == 'cxt_cd' || $sf_key == 'fea_cd') {
        echo $options;
    }
}
?>

<?php 


if ($recentitems) {
	$recentitems = array_reverse ( $recentitems );
	echo '<div class="titlerow">';
	foreach ( $fields as $field ) {
		switch ($field ['dataclass']) {
			case 'itemkey' :
				echo '<div class="col ref">';
				break;
			case 'txt' :
				echo '<div class="col colwide">';
				break;
			default :
				echo '<div class="col">';
				break;
		}
		echo $field ['field_alias'] . '</div>';
	}
	echo '</div>';
	
	foreach ( $recentitems as $item ) {
		$datarow = '<a href="' . $sf_conf ['link_root'] . 'item_key=' . $sf_key . '&amp;';
		$datarow .= $sf_key . '=' . $item [$sf_key] . '">';
		$datarow .= '<div class="datarow">';
		foreach ( $fields as $field ) {
			switch ($field ['dataclass']) {
				case 'itemkey' :
					$datarow .= '<div class="col ref">';
					break;
				case 'txt' :
					$datarow .= '<div class="col colwide">';
					break;
				default :
					$datarow .= '<div class="col">';
					break;
			}
			
			$datarow .= '<span class ="resplabel">' . $field ['field_alias'] . ': </span>';
			switch ($field ['dataclass']) {
				case 'itemkey' :
					$datarow .= $item [$sf_key];
					break;
				case 'xmi' :
					$xmis = getXmi ( $sf_key, $item [$sf_key], $field ['xmi_mod'] );
					if ($xmis) {
						foreach ( $xmis as $xmi ) {
							$datarow .= $xmi ['xmi_itemvalue'] . ' ';
						}
					} else {
						$datarow .= "<span class=\"data\">&nbsp;</span>";
					}
					break;
					/*
				case 'action';
					
					$datarow .= getSingleText('abk_cd', $item [$sf_key], 'name');
					break;
					*/
				default :
				    $data = resTblTd ( $field, $sf_key, $item [$sf_key] );
				    if ($data){
					   $datarow .= $data;
					} else {
						$datarow .= "<span class=\"data\">&nbsp;</span>";
					}
				    break;
			}
			$datarow .= '</div>';
		}
		$datarow .= '</div></a>';
		echo $datarow;
	}
} else {
	echo "<div class=\"message\">Nothing has been added yet, please check back later</div>";
}
echo '</div>';
?>
