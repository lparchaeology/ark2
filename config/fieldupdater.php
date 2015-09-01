<?php

$txt_add_validation= "\$txt_add_validation";
$txt_edt_validation= "\$txt_edt_validation";
$attr_add_validation = "\$attr_add_validation";
$attr_edt_validation = "\$attr_edt_validation";
$span_add_validation = "\$span_add_validation";
$span_edt_validation = "\$span_edt_validation";
$number_add_validation = "\$number_add_validation";
$number_edt_validation = "\$number_edt_validation";
$date_add_validation = "\$date_add_validation";
$date_edt_validation = "\$date_edt_validation";
$action_add_validation = "\$action_add_validation";
$action_edt_validation = "\$action_edt_validation";
$file_add_validation = "\$file_add_validation";
$file_edt_validation = "\$file_edt_validation";
$xmi_add_validation = "\$xmi_add_validation";
$xmi_edt_validation = "\$xmi_edt_validation";
$custom_action_add_vd = "\$custom_action_add_vd";
$custom_action_edt_vd = "\$custom_action_edt_vd";
$custom_date_add_vd = "\$custom_date_add_vd";
$custom_date_edt_vd = "\$custom_date_edt_vd";
$custom_xmi_add_validation = "\$custom_xmi_add_validation";
$conf_field_compiledon = "\$conf_field_compiledon";
$conf_field_compiledby = "\$conf_field_compiledby";
$conf_field_takenon = "\$conf_field_takenon";
$conf_field_takenby = "\$conf_field_takenby";
$conf_field_checkedby = "\$conf_field_checkedby";
$conf_field_issuedon = "\$conf_field_issuedon";
$conf_field_issuedon = "\$conf_field_issuedto";

$fields = array(
/**
* COPY YOUR FIELDS HERE
*/

);

function tab($number){
    do{
        $tab.= "&nbsp;&nbsp;&nbsp;&nbsp;";
        $number --;
    }while ($number>1);
    return $tab;
}


function preserve($string,$original,$level){
    global $tab;
    return tab($level)."'$string' => '".$original[$string]."',<br>";
}

function preservefunction($string,$original,$level){
    global $tab;
    return tab($level)."'$string' => ".$original[$string].",<br>";
}

function aliasinfo($val,$level){
    $level++;
    $aliasinfo.= tab($level)."'aliasinfo' =><br>";
    $level++;    
    $aliasinfo.= tab($level)."array(<br>";
    $level++;
    $preservearray=array(
        "alias_tbl",
        "alias_col",
        "alias_src_key",
        "alias_type",
    );
    foreach($preservearray as $field){
        $aliasinfo.= preserve($field, $val,$level);
    }
    $level--;
    $aliasinfo.=tab($level)."),<br>";
    return $aliasinfo;
}

function resolvebooleans($val,$level){
    if ($val['editable']){
        $fieldstring.= tab($level)."'editable' => TRUE,<br>";
    }
    if (!$val['editable']){
        $fieldstring.= tab($level)."'editable' => FALSE,<br>";
    }
    if ($val['hidden']){
        $fieldstring.= tab($level)."'hidden' => TRUE,<br>";
    }
    if (!$val['hidden']){
        if(!array_key_exists('field_op_hidden',$val)){
            $fieldstring.= tab($level)."'hidden' => FALSE,<br>";
        }else{
            $fieldstring.= tab($level)."'field_op_hidden' => FALSE,<br>";
        }
    }
    return $fieldstring;
}

function resolvefield($val, $level){
        $fieldstring .= "$".$val['field_id']." =<br>";
        $level++;
        $fieldstring.= tab($level)."array(<br>";
        $level++;
        $preservearray=array(
            "field_id",
            "dataclass",
            "classtype",
            "module",
            "attribute",
        );
        foreach($preservearray as $v){
            if (array_key_exists($v,$val)){
                $fieldstring.= preserve($v, $val, $level);
            }
        }
        $fieldstring.= aliasinfo($val,$level);
        $fieldstring.= resolvebooleans($val,$level);
        
 
        $preservearray=array(
        'actors_mod',
        'actors_element',
        'actors_style',
        'actors_type',
        'actors_elementclass',
        'actors_grp',
        'script',
        'module',
        'xmi_mod',
        'xmi_mode',
        'datestyle',
        );
        
        foreach($preservearray as $v){
            if (array_key_exists($v,$val)){
                $fieldstring.= preserve($v, $val, $level);
            }
        }
        foreach($val as $k => $v){
             if (substr($k,0,2)=="op"){
                 $fieldstring.= preserve($k,$val,$level);
             }
         }        
        $preservearray=array(
            'add_validation',
            'edt_validation',
        );
        foreach($preservearray as $v){
            if (array_key_exists($v,$val)){
                $fieldstring.= preservefunction($v, $val, $level);
            }
        }
        $level--;
        $fieldstring.= ");<br><br>";
    
    return $fieldstring;
}

function createmodconf($mod){
    $mod_cd= $mod."_cd";
    $val=array();
    $val['field_id']="conf_field_".$mod_cd;
    $val['dataclass']="itemkey";
    $val['classtype']=$mod_cd;
    $val['module']=$mod;
    $val['alias_tbl']="cor_tbl_module";
    $val['alias_col']="itemkey";
    $val['alias_src_key']=$mod_cd;
    $val['alias_type']="1";
    $val['editable']=TRUE;
    $val['hidden']=FALSE;
    $val['add_validation'] = "\$key_add_validation";
    $val['edt_validation'] = "\$key_edt_validation";
    return $val;
}

function createmodtypeconf($mod){
    $modtype= $mod."type";
    $val=array();
    $val['field_id']="conf_field_".$modtype;
    $val['dataclass']="modtype";
    $val['classtype']=$modtype;
    $val['alias_tbl']="cor_tbl_col";
    $val['alias_col']="dbname";
    $val['alias_src_key']=$modtype;
    $val['alias_type']="1";
    $val['editable']=TRUE;
    $val['hidden']=FALSE;
    $val['add_validation'] = "'none'";
    $val['edt_validation'] = "'none'";
    return $val;
}

function addmodtypeval($val){
    $mod = substr($val['classtype'],0,3);
    $typeval.="\$conf_field_".$mod."_cd['add_validation'][] = \$key_vd_modtype;";
    $typeval.="<br>";
    $typeval.="\$conf_field_".$mod."_cd['edt_validation'][] = \$key_vd_modtype;";
    $typeval.="<br><br>";
    return $typeval;
}

$result="<html><head></head><body>";
foreach($fields as $key=> $val){
    $result.= resolvefield($val,0);
    if ($val['dataclass']=="modtype"){
        $result.= addmodtypeval($val);
    }
}
$result.= "</body>";

echo $result;

?>
