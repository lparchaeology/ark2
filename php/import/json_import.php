
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * import/json_import.php
*
* a javascript heavy page for navigating and importing json
*
* PHP versions 1 and 5
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
* @category   import
* @package    ark
* @author     Mike Johnson m.johnson@lparchaeology.com>
* @copyright  1999-2014 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/import/left_panel.php
* @since      File available since Release 1.1.2
*/

// Sets a framework that will be used by the javascript to do the work

ini_set('memory_limit','1G');
$mk_list = array(
                'jsonintromsg',
                'itemsfound',
                'jsontoparent',
                'jsonremove',
                'jsonloading',
                'first20',
                'genjsonimport',
                'jsonthisisroot',
                'jsonthisisarkid',
                'jsonfilter',
                'currentpath',
                'rootpath',
                'jsonarkid',
                'notset',
                'nojsonrootset',
                'thisisleaf',
                'nojsonarkid',
                'jsonrootcannotberoot',
                'ste_cd',
                'abitraryarkcodes',
                'regex',
                'jsonfilterisnot',
                'jsonfilteris',
                'submit',
                'abitraryarkcodesstart',
                'no_ste_cd',
                'jsonnothingfound'
);
$markup = array();
//loop over the list assigning mk to a variable of the same name
foreach ($mk_list as $required_mk){
    $mk_name = 'mk_'.$required_mk;
    $$mk_name =  getMarkup('cor_tbl_markup', $lang, $required_mk);
    $markup[$required_mk]=$$mk_name;
}

$dd = ddSimple($ste_cd, $ste_cd, 'cor_tbl_ste', 'id', 'ste_cd', '', 'code');

// return and echo this javascript
$js1 = mkJsVars($markup, 'markup');
$filename[0] = reqArkVar('filename');

$js3 = mkJsVars($filename, 'filename');
$js2 = "<script src=\"lib/js/jquery-csv.js\"></script>";
$js2 .= "<script type = \"text/javascript\"";
$js2 .= ' src = "js/json.js"';
$js2 .= '></script>';
$body = '<div id="message">'.$mk_jsonintromsg.'</div>
        '.''.'
        <div id="json"></div>
        <div id="infopane" class="mc_subform">
        <ul>
        <li class="row"><label class="form_label">'.$mk_currentpath.'</label><div id="currentpath"></div></li>
        <li class="row"><label class="form_label">'.$mk_rootpath.'</label><div id="rootpath">'.$mk_notset.'</div></li>
        <li class="row"><label class="form_label">'.$mk_jsonarkid.'</label><div id="jsonarkid">'.$mk_notset.'</div></li>
        </ul>';
$body .= "
<a id= \"showadvanced\">advanced options</a>
<div id=\"advancedoptions\" style=\"display:none\">
    <h1>Advanced Options</h1><ul>
        <li class=\"row\">
            <label class=\"form_label\">$mk_ste_cd:</label>
            $dd
        </li>
        <li class \"row\">
            <label class=\"form_label\">$mk_no_ste_cd:</label>
            <input type=\"checkbox\" name=\"no_ste_cd\" id=\"no_ste_cd\">
        </li>
        <li class=\"row\">
            <label class=\"form_label\">$mk_regex</label>
            <input type=\"text\" name=\"regex\" id=\"arkidregex\" value=\"[0-9]+\">
        </li>
        <li class=\"row\">
            <label class=\"form_label\">$mk_abitraryarkcodes: </label>
            <input type=\"checkbox\" name=\"abitraryarkcodes\" id=\"abitraryarkcodes\">
        </li>
        <li class=\"row\">
            <label class=\"form_label\">$mk_abitraryarkcodesstart: </label>
            <input type=\"number\"  min=\"0\" value=\"0\" id=\"abitraryarkcodesstart\">
        </li>
    </ul>
</div></div>";
                
$body .='<div id="workingpane" class="mc_subform">
        <div id="output" class="row">'.$mk_jsonloading.'</div>
        <div id="listholder" class="row">
               <div id="list"></div>
        </div>
        <button id ="parent"></button>
        </div>
        <div id="filters" class="mc_subform"></div>
        <div id="import">
        </div>';

$body .=  $js1.$js3.$js2;
$body .= "<div id=\"import_options\" class=\"mc_subform\">
<form id=\"json_process\" action=\"\">
<ul>";

foreach ($loaded_modules as $key => $val) {
    $code = $val.'_cd';
    $import_keys[$code] = $code;
}
/*
$import_classs =
array(
                'key' => 'Itemkey',
                'modkey' => 'Itemkey (using modtypes)',
                'action' => 'Action',
                'attra' => 'Attribute (A - boolean)',
                'attrb' => 'Attribute (B)',
                'date' => 'Date',
                'num' => 'Number',
                'span' => 'Span',
                'txt' => 'Text',
                'xmi' => 'XMI',
);
*/
$dd_itemkey = "<select name=\"itemkey\" id = \"itemkeyDropdown\" onChange=\"mkFieldDd()\">\n";
$dd_itemkey .= "<option value=\"\">---select---</option>\n";
foreach ($import_keys as $key => $itemkey) {
    $modcd = explode("_", $itemkey);
    $mod = $modcd[0];
    if (chkModType($mod)) {
        $modtype = "{$mod}type";
        $ddname = "dd_$modtype";
        $tbl = "{$mod}_lut_$modtype";
        $fieldname = "conf_field_{$mod}type";
        $$ddname = ddAlias(FALSE, FALSE, $tbl, $lang, $ddname, FALSE, 'code');
        $typedropdowns[$modtype] = $$ddname;
    }
    $dd_itemkey .= "<option value=\"$itemkey\">$itemkey</option>\n";
}
/*
foreach ($import_classs as $key => $class) {
    // clean up references to attra and attrb
    if (substr($key, 0, 4) == 'attr') {
        $class = 'attribute';
        $key = 'attribute';
    }
    // sanitize
    $class = strtolower($class);
    $tbl = 'cor_tbl_'.$class;
    // exclude the key pseudo class
    if ($key != 'key' && $key != 'modkey') {
        $dd_itemkey .= "<option value=\"$tbl\">$tbl</option>\n";
    }
}
*/
$dd_itemkey .= "</select>\n";

$body.="<li class=\"row\">
<label class=\"form_label\">Itemkey:</label>
$dd_itemkey
</li>";
foreach( $typedropdowns as $modtype => $dd_modtype){
    $body.="<li class=\"row\" id=\"$modtype\">";
    $body.="<label class=\"form_label\">$modtype:</label>";
    $body.=$dd_modtype;
    $body.="<li class=\"row\">";
}
$body.="</li><li class=\"row\">

<label class=\"form_label\">Dataclass:</label>
    <select id=\"classDropdown\" name=\"dataclass\" onchange=\"mkFieldDd()\">
        <option value=\"\">---select---</option>
        <option value=\"action\">action</option>
        <option value=\"attribute\">attribute</option>
        <option value=\"date\">date</option>
        <option value=\"number\">number</option>
        <option value=\"span\">span</option>
        <option value=\"txt\">txt</option>
        <option value=\"place\">place</option>
        <option value=\"xmi\">xmi</option>
    </select>
</li>
<li class=\"row\">
    <label class=\"form_label\">Field:</label>
    <select id=\"fieldDropdown\" name=\"field\">
        <option value=\"\">---select---</option>
    </select>
</li>
<button type=\"button\" onclick=\"importJson()\">$mk_submit</button>
</form>
<script>
$( \"#showadvanced\" ).click(function() {
$( \"#advancedoptions\" ).toggle();
});

mkModTypeDD();
</script>
</div>";	
echo $body;
?>
