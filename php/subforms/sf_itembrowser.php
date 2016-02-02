<?php 

if (array_key_exists('op_num_rows', $sf_conf)) {
    $num_reg_rows = $sf_conf['op_num_rows'];
} else {
    $num_reg_rows = '10'; // a default cranked up to allow navigation for DV - will change when data view comes online
}

if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $class = $sf_conf['op_sf_cssclass'];
} else {
    $class = 'itemcard';
}

if (array_key_exists('op_truncate', $sf_conf)) {
    $truncate = $sf_conf['op_truncate'];
} else {
    $truncate = TRUE;
}

$recentitems = getRegisterRows($mod_short, $sf_key, $ste_cd, $num_reg_rows);

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
        while(count($trenchitems) < $sf_conf['op_no_rows']) {
            foreach ( $recentitems as $item ) {
                $testkey = $item[$sf_key];
                if (substr($testkey, 3, strlen($trenchno)) == $trenchno && (strlen($testkey) - strlen($trenchno)) == $testlength) {
                    $trenchitems[] = $item;
                }
            }
            $recentitems = $trenchitems;
        }
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
$sf_conf=array();

if ($recentitems) {
    if (!array_key_exists('noreverse', $sf_conf)){
	    $recentitems = array_reverse ( $recentitems );
    }
	$cardgrid = '<div class="cardgrid">';
	
	foreach ( $recentitems as $item ) {
	    $attributes = getCh('attribute', $sf_key, $item [$sf_key], $fields[1]['classtype']);
	    if ($attributes) {
	        foreach ($attributes AS $att) {
	            $identity = getAttr(FALSE, $att, 'SINGLE', 'alias', $lang);
	        }
	    }
	    if (!isset($identity)){
	        $identity = "Unknown";
	    }
	    $firsth5 = TRUE;
	    $firstp = TRUE;
		$card = '<div class="'.$class.'">';
        foreach ( $fields as $field ) {
            switch($field['dataclass']) {
                case 'itemkey' :
                    $card .= '<div class="carddesc">';
                    $card .= '<h3>' . str_replace('_', ' ', $item[$sf_key]) . '</h3>';
                    break;
                case 'attribute' :
                    if ($field['classtype'] == 'identity') {
                        $card .= '<div class="carddesc">';
                        $card .= '<h3>' . $identity . '</h3>';
                    } else {
                        $attributes = getCh('attribute', $sf_key, $item[$sf_key], $field['classtype']);
                        if ($attributes) {
                            foreach ( $attributes as $att ) {
                                if ($attributes) {
                                    $current = getAttr(FALSE, $att, 'SINGLE', 'alias', $lang);
                                    $card .= '<h4>' . $current . '</h4>';
                                }
                            }
                        }
                    }
                    break;
                case 'file' :
                    $files = getFile($sf_key, $item[$sf_key], $field['classtype']);
                    if ($files) {
                        $file = array_pop($files);
                        $alt = $file['filename'];
                        if (file_exists("{$registered_files_dir}/arkthumb_{$file['id']}.jpg")) {
                            $src = $registered_files_host . 'arkthumb_' . $file['id'] . '.jpg';
                        }
                    } else {
                        $src = $skin_path."/_images/common/placeholder-find-photo.png";
                        $alt = "No Photo";
                    }
                    $card .= '<div class="cardphoto"><img src="' . $src . '" alt="' . $alt . '" /></div>';
                    break;
                case 'txt':
                    $text = getSingleText($sf_key, $item[$sf_key], $field['classtype']);
                    if ($text) {
                        if (reqQst($field, 'op_input')) {
                            if ($firsth5) {
                                $card .= '<h5>';
                                $firsth5 = FALSE;
                            }
                            $card .= '<span><strong>';
                            $card .= ucfirst($field['classtype']);
                            $card .= ':</strong> ';
                            $card .= $text;
                            $card .= ' </span>';
                        } else {
                            if ($firstp) {
                                $card .= '</h5>';
                                $firstp = FALSE;
                            }
                            if (strlen($text) > 30 && $truncate) {
                                $words = split(' ', $text);
                                $words = array_reverse($words);
                                $text = '';
                                do {
                                    $text .= array_pop($words) . ' ';
                                } while(strlen($text) < 30);
                                $text .= '&hellip;';
                            }
                            $card .= '<p>' . $text . '</p>';
                        }
                    }
                    break;
            }
        }
        $query = 'itemkey='.$sf_key.'&'.$sf_key.'='.$item [$sf_key];
		$card .= '<a href="micro_view.php?'.$query.'" class="btn">View / Edit</a>';
		$card .= '</div></div>';
		$cardgrid .= $card;
	}
	$cardgrid .= "</div>";
	echo $cardgrid;
} else {
	echo "<div class=\"message\">Nothing has been added yet, please check back later</div>";
}
?>
