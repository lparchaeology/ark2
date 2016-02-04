<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* global_functions.php
*
* Take care to consider where would be the best place for you function,
* preferably put it in the module. Only include it in here if it is 
* genuinely global.
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
* @category   base
* @package    ark
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Henriette Roued <henriette@roued.com>
* @author     Michael Johnson <m.johnson@lparchaeology.com>
* @copyright  1999-2013 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/global_functions.php
* @since      File available since Release 0.6
*
*/

include_once('db_functions.php');

require_once ('HTMLPurifier.auto.php');
$purifierconfig = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($purifierconfig);

// {{{ ARKnatSort()

/**
 * sorts stuff into natural order
 *
 * @param array $a  an array
 * @param array $b  an array
 * @return array  sorted array
 * @author Guy Hunt
 * @since 0.5
 *
 * NOTE: This function is used by the uasort() function which acts as a wrapper
 *
 */

function ARKnatSort($a, $b)
{
    return strnatcasecmp($a['sort_key'], $b['sort_key']);
}

// }}}
// {{{ ARKdateSortAsc()

/**
 * sorts dates into natural order
 *
 * @param array $a  an array
 * @param array $b  an array
 * @return array  sorted array
 * @author Guy Hunt
 * @since 0.5
 *
 * NOTE: This function is used by the uasort() function which acts as a wrapper
 *
 */

function ARKdateSortAsc($a, $b)
{
    // return values as variables to make maintanance easier
    $up = -1;
    $down = 1;

    // split the dates on spaces, commas / and -
    $date1 = preg_split("/[\s,\/\-]+/",strip_tags($a['sort_on']));
    $date2 = preg_split("/[\s,\/\-]+/",strip_tags($b['sort_on']));

    //this is currently assuming a day month year order
    // ideally we could use different orders, but different orders will
    // require different functions, or for the dates to
    // be converted higher up

    // scrap out odd stuff (make them appear equal)
    if(count($date2)!==count($date1) || count($date1)!=3){
        return 0;
    }
    //first check years if these are different we are done - return it!
    if($date1[2]<$date2[2]){
        return $down;
    } else if ($date1[2]>$date2[2]) {
        return $up;
    }
    // next check months
    if($date1[1]<$date2[1]){
        return $down;
    } else if ($date1[1]>$date2[1]) {
        return $up;
    }
    // finally days
    if($date1[0]<$date2[0]){
        return $down;
    } else if ($date1[0]>$date2[0]) {
        return $up;
    }
    // if day month and year are the same it is the same so return 0!
    return 0;
}

// }}}
// {{{ ARKdateSortDesc()

/**
 * sorts dates into natural order
 *
 * @param array $a  an array
 * @param array $b  an array
 * @return array  sorted array
 * @author Guy Hunt
 * @since 0.5
 *
 * NOTE: This function is used by the uasort() function which acts as a wrapper
 *
 */

function ARKdateSortDesc($a, $b)
{
    //these values are the only difference between ascending and descending
    // should make this easier to maintain
    $up = 1;
    $down = -1;

    $date1 = preg_split("/[\s,\/\-]+/",strip_tags($a['sort_on']));
    $date2 = preg_split("/[\s,\/\-]+/",strip_tags($b['sort_on']));
    if(count($date2)!==count($date1) || count($date1)!=3){
        return 0;
    }
    if($date1[2]<$date2[2]){
        return $down;
    } else if ($date1[2]>$date2[2]) {
        return $up;
    }
    if($date1[1]<$date2[1]){
        return $down;
    } else if ($date1[1]>$date2[1]) {
        return $up;
    }
    if($date1[0]<$date2[0]){
        return $down;
    } else if ($date1[0]>$date2[0]) {
        return $up;
    }
    return 0;
}

// }}}
// {{{ arraySetCurrent()

/**
* sets the pointer of an array to the given key
*
* @param array $array  the array to set pointer in
* @param string $key  the key to move the pointer to
* @return void
* @author (not too sure) possibly taken off the php.net manual
* @since 0.4
*
*/

function arraySetCurrent(&$array, $key)
{
    reset($array);
    while(current($array)){ 
        if(key($array) == $key){
            break;
        }
        next($array);
    }
}

// }}}
// {{{ autoRotateImage()

/** Taken from the php manual for managing rotation of thumbnails based on exif data
 * @param imagick image $image - the image to be auto rotated
 */
function autoRotateImage($image) {
    $orientation = $image->getImageOrientation();

    switch($orientation) {
        case imagick::ORIENTATION_BOTTOMRIGHT:
            $image->rotateimage("#fff", 180); // rotate 180 degrees
        break;

        case imagick::ORIENTATION_RIGHTTOP:
            $image->rotateimage("#fff", 90); // rotate 90 degrees CW
        break;

        case imagick::ORIENTATION_LEFTBOTTOM:
            $image->rotateimage("#fff", -90); // rotate 90 degrees CCW
        break;
    }

    // Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
    $image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
} 
// {{{ browserDetect()

/**
* works out which browser a user is using
*
* @param
* @return browser string  the ark standard browser name
* @author Guy Hunt
* @since 0.6
*
* Note: This used to be used as an include script from v0.1 to 0.6.
*
* Note: As of v0.7, this has been upgraded to detect old and new IE versions
* This is now a wrapper for an external browser detection class which can be
* found in the 'classes' folder.
*
*/

function browserDetect()
{
    $browser = reqQst($_SESSION, 'browser');
    include_once ('lib/php/Browser.php');
    $browser_detail = new Browser();
    if (!$browser) {
        $browser = reqQst($_SERVER, 'HTTP_USER_AGENT');
        if (stristr($browser, "MSIE") || stristr($browser, "Internet Explorer")) {
            if ($browser_detail->getVersion() > 6) {
                $browser = 'MSIE';
            } else {
                $browser = 'OLD_MSIE';
            }
        } elseif (stristr($browser, "Mozilla")) {
            $browser = 'MOZ';
        } else {
            //the default other is the msie stylesheet
            $browser = 'OTHER';
        }
    }
    return $browser;
}

// }}}
//{{{ build_sorter
/**
*
* Returns a function for sorting on the given key
*
* @param the key to sort on
* @return returns a function that compares two variables, as required by usort
* @author from the php manual http://us3.php.net/manual/en/function.usort.php
*
*/
function build_sorter($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a[$key], $b[$key]);
    };
}
// }}}
//DEV NOTE: MOVE TO MOD FUNCTIONS
// {{{ chkCxtSpanlabel

/**
 * 
 * A function to validate whether a label may be a applied to a particular span
 * 
 * @param string $ste_cd if this is set, it will assume that the beg and end are raw numbers
 * @param string $beg the full context code of the beginning of the span
 * @param string $end the full context code of the end of the span
 * @param string $spanlabelid the id of the spanlabel from cor_lut_spanlabel
 * @param array $conf_tvclab a multidim array containing the validation values
 * @return boolean
 * 
 * NOTE: If you intend to send full cxt_cd not cxt_no values set $ste_cd to FALSE
 * NOTE: The function reutrns TRUE if the label is banned
 */
function chkCxtSpanlabel($ste_cd, $beg, $end, $spanlabelid, $conf_tvclab) {

if ($ste_cd) {
$beg = $ste_cd.'_'.$beg;
$end = $ste_cd.'_'.$end;
}

$beg_cxttype = getModType('cxt', $beg);
$end_cxttype = getModType('cxt', $end);

$pair_name = $beg_cxttype.'to'.$end_cxttype;

$pair_array = $conf_tvclab[$pair_name];

// DEBUG
// printf ("Rel: %s <br>", $pair_name);
// printf ("Label: %s <br>", $spanlabelid);
// print_r ($pair_array);

if (in_array($spanlabelid, $pair_array)) {
return (TRUE);
} else {
return (FALSE);
}

}

// }}}
// {{{ chkFragInCols()

/**
*
* used by sf_chaintable to check fragments against multiple fields
*
* @param array $frag  part of an ARK chain
* @param array $field  an array of fields to check against
* @return boolean  TRUE if there is a match, FALSE otherwise
* @author Michael Johnson
* @since v1.1
*
* handles multiple calls to chFragTypeAndClass() if several fields may be matched
*
*/

function chkFragInCols($frag, $fields){
    foreach($fields as $field){
        if(chkFragTypeAndClass($frag, $field)){
            // return TRUE as soon as a match is found
            return TRUE;
        }
    }
    return FALSE;
}

// }}}
// {{{ chkFragTypeAndClass()

/**
*
* checks if a fragment from a chain matches a specified field
*
* @param array $frag part of an ARK chain
* @param array $field a field to check against
* @return boolean TRUE if there is a match, FALSE otherwise
* @author Michael Johnson
* @since v1.1
*
* ARK fragments are parts of chains, that are linked to other pieces of data
* the systems for handling these chains use these fragments
* 
* It is necessary to check both the classtype and the dataclass, as it is possible that
* a certain type name might be used for two different classes, for example numbertype:transect
* and attributetype:transect are two distinct fields that have the same classtype
*
*/

function chkFragTypeAndClass($frag, $field){
    // the classtype is a function of the class
    $classtype=$frag['dataclass']."type";
    // xmi do not have class type in the conventional sense
    if ($frag['dataclass']=='xmi'){
    	$frag["xmitype"]='xmi_list';
    }
    $useclasstype = FALSE;
    if (array_key_exists($classtype, $frag)) {
        $useclasstype = TRUE;
    }
    
    if ($useclasstype){
        // fragments may have numeric references to the classtype contained in the appropriate lut
        if (is_numeric($frag[$classtype])) {
            $frag[$classtype] = getSingle($classtype, 'cor_lut_' . $classtype, "id = \"{$frag[$classtype]}\"");
        }
    }
    // for debug
    $debug=false;
    if ($debug){
        echo "testing if frag['dataclass'](". $frag['dataclass'].") = field['dataclass'](".$field['dataclass'].")<p>";
        if ($useclasstype){
            echo "testing if frag[$classtype](". $frag[$classtype].") = field['classtype'](".$field['classtype'].")<p><p>";
        }
    }
    // the test itself
    if (!$useclasstype){
        if($frag['dataclass']==$field['dataclass'] ){
            return TRUE;
        }
        return FALSE;
    }
    
    if ($frag['dataclass'] == $field['dataclass'] && $frag[$classtype] == $field['classtype']) {
        return TRUE;
    }
    return FALSE;
}

// }}}
// {{{ chkTranslation()
        
/**
* checks if a piece of markup or an alias has translations
*
* @param string $dataclass  the type of data to check (i.e 'markup' or 'alias')
* @param int $frag_id  the id of the frag (in the alias or markup table)
* @access public
* @since 0.6
*/

function chkTranslation($dataclass, $frag_id){
    //first grab the available languages
    $langs = getMulti('cor_lut_language', "1 = 1");
    $return_val = array();
    switch ($dataclass) {
        case 'markup':
            $nname = getSingle('nname', 'cor_tbl_markup', "id = $frag_id");
            foreach ($langs as $key => $lang) {
                $result = getSingle('nname', 'cor_tbl_markup', "nname = '$nname' AND language = '{$lang['language']}'");
                if ($result == FALSE){
                    $return_val[] = $lang['language'];
                }
            }
            break;
        default:
            $return_val = "NO handler yet for $dataclass";
            break;
    }
    return $return_val;
}

// }}}
// {{{ collateFrags()

/**
* collates fragments of data from a multi-dim tree structure into flat array
*
* @param $data array  contains the data tree (see output of getChData())
* @param $repo_name string  the name of a repository that will hold the data
* @return void
* @author Guy Hunt
* @since v0.8
*
* This function puts the collated data into an array that must be set up outside
* this function. You must send the NAME of this repository to the function NOT
* the array itself.
*
* The function looks at the 'attached_frags' element of the array. If this is an
* array, the function is repeated to crawl down the chain. If it is true or false
* the function is not recalled and only the top level is collated
*
*/

function collateFrags($data, $repo_name)
{
    global $$repo_name;
    // Loops through each element. If attached frags is an array, function is recalled.
    foreach ($data as $key => $value) {
        $repo = $$repo_name;
        if (is_array($value)) {
            if (array_key_exists('attached_frags', $value)) {
                if (is_array($value['attached_frags'])) {
                    $repo[] =
                        array(
                            'table' => "cor_tbl_{$value['dataclass']}",
                            'id' => $value['id'],
                            'dataclass' => $value['dataclass'],
                            'attached_frags' => FALSE,
                    );
                    $$repo_name = $repo;
                    collateFrags($value['attached_frags'], $repo_name);
                } else {
                    $repo[] =
                        array(
                            'table' => "cor_tbl_{$value['dataclass']}",
                            'id' => $value['id'],
                            'dataclass' => $value['dataclass'],
                            'attached_frags' => TRUE,
                    );
                    $$repo_name = $repo;
                }
            }
        }
    }
}

// }}}

// {{{ compareSpans()

/**
* compares two numeric spans to see if they coincide
*
* @param array $span1  a array retrieved using getSpan()
* @param array $span2  a array retrieved using getSpan()
* @param boolean $reverse  if set this reverses the span comparisons (this is mainly
*  used in Date Ranges for comparing BPs which work from large->small instead of small->large)
* @return boolean $return  either TRUE if the spans coincide or FALSE if they don't
* @author Stuart Eve
* @since 0.6
*/
function compareSpans($span1, $span2, $reverse=FALSE)
{
    //get the beginning and ends of both spans
    $span1_beg = $span1['beg'];
    $span1_end = $span1['end'];
    $span2_beg = $span2['beg'];
    $span2_end = $span2['end'];
    if ($reverse) {
        //|__|
        //     |__|
        if ($span1_beg > $span2_beg && $span1_end > $span2_beg) {
            return FALSE;
        }
        //     |__|
        //|__|
        if ($span2_beg > $span1_beg && $span2_end > $span1_beg) {
            return FALSE;
        }
        return TRUE;
    } else {
        //|__|
        //     |__|
        if ($span1_beg < $span2_beg && $span1_end < $span2_beg) {
            return FALSE;
        }
        //     |__|
        //|__|
        if ($span2_beg < $span1_beg && $span2_end < $span1_beg) {
            return FALSE;
        }
        return TRUE;
    }
}

// }}}
// ---- CONFIG FAILSAFES ---- //
// These functions are designed to act as fallbacks. Between v0.8 and v1.0 there
// are a series of changes to core config arrays. Any changes to the arrays will
// have a failsafe function to ensure that the config is put right and the admin
// warned.

// {{{ configFailsafeFieldId()

/**
* checks to see if the field_id is correctly assigned on a field
*
* @param $field array  a standard ARK field array
* @return void
* @author Guy Hunt
* @since v0.8
*
* If field ID's are not present, all fields in the global array are fixed
*
*/

function configFailsafeFieldId($field)
{   
    if (!array_key_exists('field_id', $field)) {
        // if it ain't on this field, check them all
        foreach ($GLOBALS as $varname => $var) {
            if (preg_match('/field/i', $varname)) {
                // this var looks a bit like a field, now test it more thoroughly
                if (is_array($var)) {
                    if (array_key_exists('dataclass', $var)) {
                        $GLOBALS[$varname]['field_id'] = $varname;
                    }
                }
            }
        }
    }
}

// }}}
// {{{ createthumb()

/**
* creates thumbnails for images
*
* @param string $name  the name of the file to be thumbnailed
* @param string $filename  the name of the thumbnail
* @param string $new_w  the new width in px
* @param string $new_h  the new height in px
* @return void
* @author http://icant.co.uk/articles/phpthumbnails/
* @since 0.4
*/

function createthumb($name, $filename, $new_w, $new_h)
{
    $system = explode('.',$name);
    if (preg_match('/jpg|jpeg|JPG/', end($system))) {
        $src_img = imagecreatefromjpeg($name);
    }
    if (preg_match('/png/',end($system))) {
        $src_img = imagecreatefrompng($name);
    }
    $old_x = imageSX($src_img);
    $old_y = imageSY($src_img);
    if ($old_x > $old_y) {
        $thumb_w = $new_w;
        $thumb_h = $old_y*($new_h/$old_x);
    }
    if ($old_x < $old_y) {
        $thumb_w = $old_x*($new_w/$old_y);
        $thumb_h = $new_h;
    }
    if ($old_x == $old_y) {
        $thumb_w = $new_w;
        $thumb_h = $new_h;
    }
    $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
    imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
    if (preg_match("/png/", $system[1])) {
        imagepng($dst_img, $filename);
    } else {
        imagejpeg($dst_img, $filename);
    }
    imagedestroy($dst_img);
    imagedestroy($src_img);
}

// }}}
// {{{ dateNow()

/**
* sets blank dates to NOW()
*
* @param string $date  a date
* @return string $date  a date
* @author Guy Hunt
* @since 0.4
*/

function dateNow($date)
{
    if ($date == '0000-00-00 00:00:00') {
        $date = 'NOW()';
    } else {
        $date = "'$date'";
    }
    return ($date);
}

// }}}
// {{{ dateSelect()

/**
* makes up a date select element for forms
*
* @param string $type  sets the type of selector (eg. popup/text) //NOTE NOT IMPLEMENTED
* @param string $fields  the fields you want in the selector
* @param string $datetype  sets a prefix to the date fields when sending in forms
* @param string $date  values with which to populate the fields (if blank the fields are empty)
* @return string $var  a resolved html string
* @author Guy Hunt
* @since 0.2
*
* Current fields:
*  dd - day expressed as two digits
*  mm - month expressed as two digits
*  yr - year expressed as 4 digits
*
* Current types:
*  text - gives the fields as plain text input fields
*
*/

function dateSelect($type, $fields, $datetype, $date=FALSE)
{
    // if we have a date split it up
    if ($date) {
        $yr = splitDate($date, 'yr');
        if (!$yr) {
            $yr = 'yr';
        }
        $mm = splitDate($date, 'mm');
        if (!$mm) {
            $mm = 'mm';
        }
        $dd = splitDate($date, 'dd');
        if (!$dd) {
            $dd = 'dd';
        }
        $hr = splitDate($date, 'hr');
        if (!$hr) {
            $hr = 'hr';
        }
        $mi = splitDate($date, 'mi');
        if (!$mi) {
            $mi = 'mi';
        }
        $ss = splitDate($date, 'ss');
        if (!$ss) {
            $ss = 'ss';
        }
        // If we have no date, set the vars to false
    } else {
        $yr = FALSE;
        $mm = FALSE;
        $dd = FALSE;
        $hr = FALSE;
        $mi = FALSE;
        $ss = FALSE;
    }
    
    //---- OUTPUT ----//
    
    //NOT WORKING REALLY!! JUST A HACK
    // Ideally we would split the format field and send back these fields in the way requested
    // yr,mm,dd
    if ($fields == 'yr,mm,dd') {
        $var = "<input type=\"text\" id=\"{$datetype}_yr\" name=\"{$datetype}_yr\" value=\"$yr\" class=\"\"/>-";
        $var .= "<input type=\"text\" id=\"{$datetype}_mm\" name=\"{$datetype}_mm\" value=\"$mm\" class=\"\" />-";
        $var .= "<input type=\"text\" id=\"{$datetype}_dd\" name=\"{$datetype}_dd\" value=\"$dd\" class=\"\" />";
    }
    // yr
    if ($fields == 'yr') {
        $var = "<input type=\"text\" id=\"{$datetype}_yr\" name=\"{$datetype}_yr\" value=\"$yr\" class=\"\"/>";
    }
    // dd,mm,yr
    if ($fields == 'dd,mm,yr') {
        $var = "<input type=\"text\" id=\"{$datetype}_dd\" name=\"{$datetype}_dd\" value=\"$dd\" class=\"dd\" />-";
        $var .= "<input type=\"text\" id=\"{$datetype}_mm\" name=\"{$datetype}_mm\" value=\"$mm\" class=\"mm\" />-";
        $var .= "<input type=\"text\" id=\"{$datetype}_yr\" name=\"{$datetype}_yr\" value=\"$yr\" class=\"yr\" />";
    }
    // mm,dd,yr
    if ($fields == 'mm,dd,yr') {
        $var = "<input type=\"text\" id=\"{$datetype}_mm\" name=\"{$datetype}_mm\" value=\"$mm\" class=\"mm\" />-";
        $var .= "<input type=\"text\" id=\"{$datetype}_dd\" name=\"{$datetype}_dd\" value=\"$dd\" class=\"dd\" />-";
        $var .= "<input type=\"text\" id=\"{$datetype}_yr\" name=\"{$datetype}_yr\" value=\"$yr\" class=\"yr\" />";
    }
    // yr,mm,dd,hr,mi,ss
    if ($fields == 'yr,mm,dd,hr,mi,ss') {
        $var = "<input type=\"text\" id=\"{$datetype}_yr\" name=\"{$datetype}_yr\" value=\"$yr\" class=\"yr\" />-";
        $var .= "<input type=\"text\" id=\"{$datetype}_mm\" name=\"{$datetype}_mm\" value=\"$mm\" class=\"mm\" />-";
        $var .= "<input type=\"text\" id=\"{$datetype}_dd\" name=\"{$datetype}_dd\" value=\"$dd\" class=\"dd\" /> | ";
        $var .= "<input type=\"text\" id=\"{$datetype}_hr\" name=\"{$datetype}_hr\" value=\"$hr\" class=\"hr\" />:";
        $var .= "<input type=\"text\" id=\"{$datetype}_mi\" name=\"{$datetype}_mi\" value=\"$mi\" class=\"mi\" />:";
        $var .= "<input type=\"text\" id=\"{$datetype}_ss\" name=\"{$datetype}_ss\" value=\"$ss\" class=\"ss\" />";
    }
    return ($var);
}

// }}}
// {{{ ddActor()

/**
* returns a drop down menu of actors
*
* @param
* @return void
* @author Guy Hunt
* @since 0.6
*
* this function presupposes that you are using a module to contain your actor data
* 
*/

function ddActor($dd_name, $actor_mod, $elem, $elemclass, $top_id, $top_val, $actor_type=FALSE, $action=FALSE)
{
    global $user_id, $ste_cd;
    $actor_itemkey = $actor_mod.'_cd';
    $actor_table = $actor_mod.'_tbl_'.$actor_mod;
    $actor_lut = $actor_mod.'_lut_'.$actor_mod . 'type';
    //  for a specific modtype
    if ($actor_type) {
        //check if we need to do a lookup
        if (!is_numeric($actor_type)) {
            $old_actor_type = $actor_type;
            $actor_type = getSingle('id', $actor_mod.'_lut_'.$actor_mod.'type', $actor_mod."type = '$actor_type'");
            if (!$actor_type) {
                echo "Func: ddActor - Failed to get a numeric modtype for modtype: '$old_actor_type' in module: '$actor_mod'<br/>\n";
            }
        }
        $where = "abktype = $actor_type";
    } else {
        // '1' is always true, a blank where statement breaks get multi
        $where = '1';
    }
    // fetch the actors
    if ($action) {
        $actors = getMulti('cor_tbl_action', "actiontype = $action", 'actor_itemvalue');
        // this case ignores the $actor_type parameter (Sorry!) GH 25/11/11
        $actors = array_unique($actors);
    } else {
        $actors = getMulti($actor_table, $where, $actor_itemkey);
    }
    
    // handle results
    if ($actors) {
        $dd = "<select name=\"$dd_name\">\n";
        // set a top val
        if ($top_id && $top_val) {
            $dd .= "<option value=\"$top_id\">$top_val</option>\n";
        } else {
            $dd .= "<option value=\"\">---</option>\n";
        }
        foreach($actors as $key => $actor) {
            $actors[$key] = 
                array(
                'elem' => getActorElem($actor, $elem, $actor_itemkey, $elemclass),
                'actor' => $actor
            );
        }
        $actors = sortResArr($actors, 'SORT_ASC', 'elem');
        foreach ($actors as $actor) {
            
            $dd .= "<option value=\"{$actor['actor']}\"";
            if (!$top_id && !$top_val && $actor['actor'] == $ste_cd."_".$user_id){
            	$dd .= " selected ";
            }
            $dd .= ">{$actor['elem']}</option>\n";
        }
        $dd .= "</select>\n";
        return ($dd);
    } else {
        echo "ddActor: no actors found";
    }
}

// }}}
// {{{ ddComplex

/**
* makes a dropdown menu where the values shown to the user are frags linked to the specified item/frag
*
* @param string $top_id  the preloaded id - mainly useful when on an edit form
* @param string $top_val  the value that appears when the page is loaded
* @param string $tbl  the table (not necc an lut) from which we want to get the vars
* @param string $dd_name  the name of the select tag 
* @param string $dataclass  the dataclass of the nickname frags;
* @param string $classtype  the classtype of the nickname frags;
* @param string $sqlorder  optional sql in the format 'ORDER BY organisation';
* @param string $fragorder  NOT IMPLEMENTED will allow sorting of the dd by the nickname frags;
* @param string $order  optional sql in the format 'ORDER BY organisation';
* @param string $id_col  optional column name for the id of the
* @return string $dd  a resolved XHTML string
* @author Guy Hunt
* @since 0.7
*
* NOTE: makes a dd menu with an 'id | nickname' type of set up. The nickname is formed from a frag
* attached to the item in question
*
*/

function ddComplex($top_id, $top_val, $tbl, $dd_name, $dataclass, $classtype, $sqlorder, $fragorder=FALSE, $id_col=FALSE)
{
    global $lang;
    //Set a default if needed
    if (!$top_val) {
        $top_val = '---select---';
    }
    // Set id col if needed
    if ($id_col) {
        $id = $id_col;
    } else {
        $id = 'id';
    }
    // Set up the SQL
    $sql = "
        SELECT $id
        FROM $tbl
        $sqlorder
    ";
    $params = array();
    // For Debug
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    
    //----RETURN A STRING----
    if ($ddrow = $sql->fetch(PDO::FETCH_ASSOC)) {
        $dd = "<select name=\"$dd_name\">";
        $dd .= "<option value=\"$top_id\">$top_val</option>\n";
        do {
            // extract the nickname for this id
            if ($dataclass == 'txt') {
                $nickname = getSingleText($id, $ddrow[$id], $classtype);
            } else {
                echo "ddComplex: function can't handle dataclass = $dataclass";
            }
            if ($ddrow[$id] != $top_id) {
                $dd .= "<option value=\"$ddrow[$id]\">$nickname</option>\n";
            }
        } while ($ddrow = $sql->fetch(PDO::FETCH_ASSOC));
        $dd .= '</select>';
        return($dd);
    }
}

// }}}
// {{{ ddItemval()

/**
* produces an html <select> element containing itemvals
*
* @param string $top_id  preload a set value into the top of the menu
* @param string $top_val  preload a set value into the top of the menu
* @param string $itemkey  a valid ARK itemkey
* @return string $dd  a valid html <select> element
* @author Guy Hunt
* @since v0.7
*
* Returns all of the items in the specified module and sorts them on a natural
* sort order
*
*/

function ddItemval($top_id, $top_val, $itemkey)
{
    //Set a default if needed
    if (!$top_val) {
        $top_val = '---select---';
    }
    // set up a dd name
    $dd_name = 'select_'.$itemkey;
    $mod = splitItemkey($itemkey);
    // setup the SQL
    $sql = "
        SELECT $itemkey
        FROM {$mod}_tbl_{$mod}
    ";
    $params = array();
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Build the dd or return an error
    if ($ddrow = $sql->fetch(PDO::FETCH_ASSOC)) {
        $dd_members = FALSE;
        do {
            if ($ddrow[$itemkey] != $top_id) {
                $dd_members[] = $ddrow[$itemkey];
            }
        } while ($ddrow = $sql->fetch(PDO::FETCH_ASSOC));
        // sort into a natural sort order
        natcasesort($dd_members);
        // start the <select>
        $dd = "<select name=\"$dd_name\">\n";
        $dd .= "<option value=\"$top_id\">$top_val</option>\n";
        // put in the options
        foreach ($dd_members as $key => $val) {
            $dd .= "<option value=\"$val\">$val</option>\n";
        }
        //finish the <select>
        $dd .= "</select>\n";
        return ($dd);
    } else {
        echo "Error in ddItemval: the itemkey type '$itemkey' returned no items<br/>";
        echo "SQL: $sql<br/>";
        return FALSE;
    }
}

// }}}
// {{{ ddSelected($var, $value)

/**
* leaves selected dropdown option selected after submission
*
* @param string $var dropdown name
* @param string $value value selected from dd
* @return string $checked returns selected="selected"
* @author Hembo Pagi
* @since v0.8
*
* Mods at v1.1 by GH to prevent e_notices (Dec 2011)
*
*/

function ddSelected($var, $value)
{
    $qvar = reqQst($_REQUEST, $var);
    if ($qvar == $value) {
        return 'selected="selected"';
    }
}

// }}}
// {{{ ddSimple

/**
* makes a simple dropdown menu from the db
*
* @param string $top_val  the value that appears when the page is loaded
* @param string $top_id  the preloaded id - mainly useful when on an edit form
* @param string $lut  the table (not necc an lut) from which we want to get the vars
* @param string $nickname  the column name
* @param string $dd_name  the name of the select tag 
* @param string $order  optional sql in the format 'ORDER BY organisation';
* @param string $return_mode  either return the html code as a string or do a simple print
* @param string $id_col  optional column name for the id of the
* @return string $dd  a resolved XHTML string
* @author Guy Hunt
* @since 0.1
*
* NOTE: makes a simple dd menu with an 'id | nickname' type of set up
*
* NOTE: do NOT use print mode anymore. this method is deprecated and will soon be
* abolished
*
*/

function ddSimple($top_id, $top_val, $lut, $nickname, $dd_name, $order, $return_mode=FALSE, $id_col=FALSE)
{
    // DEPRECATED call. Will always return code from 0.7
    if (!$return_mode) {
        $return_mode = 'code';
    }
    //Set a default if needed
    if (!$top_val) {
        $top_val = '---select---';
    }
    // Set id col if needed
    if ($id_col) {
        $id = $id_col;
    } else {
        $id = 'id';
    }
    // Set up the SQL
    $sql = "
        SELECT $id, $nickname
        FROM $lut
        $order
    ";
    $params = array();
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    
    //----1 PRINT OUTPUT---- DEPRECATED
    if ($return_mode == 'html') {
        print("<select name=\"$dd_name\">\n");
        print("<option value=\"$top_id\">$top_val</option>\n");
        while ($ddrow = $sql->fetch(PDO::FETCH_ASSOC)) {
            if ($ddrow[$id] != $top_id) {
                printf("<option value=\"{$ddrow[$id]}\">{$ddrow[$nickname]}</option>\n");
            }
        }
        print('</select>');
    }
    
    //----2 RETURN A STRING----
    if ($return_mode == 'code') {
        $dd = "<select name=\"$dd_name\" id=\"dd_$dd_name\">";
        $dd .= "<option value=\"$top_id\">$top_val</option>\n";
        while ($ddrow = $sql->fetch(PDO::FETCH_ASSOC)) {
            if ($ddrow[$id] != $top_id) {
                $dd .= "<option value=\"$ddrow[$id]\">$ddrow[$nickname]</option>\n";
            }
        }
        $dd .= '</select>';
        return($dd);
    }
}

// }}}
// {{{ ddUnique

/**
* makes a dropdown of unique items menu from the db
*
* @param string $top_val  the value that appears when the page is loaded
* @param string $top_id  the preloaded id - mainly useful when on an edit form
* @param string $lut  the table (not necc an lut) from which we want to get the vars
* @param string $nickname  the column name
* @param string $dd_name  the name of the select tag 
* @param string $order  optional sql in the format 'ORDER BY organisation';
* @param string $id_col  optional column name for the id of the
* @return string $dd  a resolved XHTML string
* @author Guy Hunt
* @since 0.1
*
* NOTE: makes a simple dd menu with an 'id | nickname' type of set up
*
*
*/

function ddUnique($top_id, $top_val, $lut, $nickname, $dd_name, $order, $id_col=FALSE)
{
    //Set a default if needed
    if (!$top_val) {
        $top_val = '---select---';
    }
    // Set id col if needed
    if ($id_col) {
        $id = $id_col;
    } else {
        $id = 'id';
    }
    // Set up the SQL
    $sql = "
        SELECT DISTINCT $id, $nickname
        FROM $lut
        $order
    ";
    $params = array();
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    
    //----RETURN A STRING----
        $dd = "<select name=\"$dd_name\">";
        $dd .= "<option value=\"$top_id\">$top_val</option>\n";
        while ($ddrow = $sql->fetch(PDO::FETCH_ASSOC)) {
            if ($ddrow[$id] != $top_id) {
                $dd .= "<option value=\"$ddrow[$id]\">$ddrow[$nickname]</option>\n";
            }
        }
        $dd .= '</select>';
        return($dd);
}

// }}}
// {{{ dirList()

/**
* reads out the contents of a directory into an array
*
* @param string $directory  the directory you want to list
* @param string $extension  a file extension filter
* @return array $dir_ls containing a list of files in the directory
* @author ?not sure? from php manual?
* @since 0.4
*
* NOTE 1: This has been updated in 1.1 to read remote URL directories
*/

function dirList ($directory, $extension = FALSE)
{
    // create an array to hold directory list
    $dir_ls = array();
    //now check if this is a URI instead of a local directory - if so we need to handle it differently
    if (chkPathRemote($directory)) {
        $html = file_get_contents($directory);
        //DEV NOTE: This Regex needs to be fixed up a bit to retrieve any files and files with spaces in the names
        preg_match_all('/<a href="([-\w\d\s].+\.[a-zA-Z]{2,4})"/', $html, $uu);
        //preg_match_all('/<a href="(([a-zA-Z0-9]*))\.[a-zA-Z]{2,4}\b/i', $html, $uu);
        $dir_ls = $uu[1];
        foreach ($uu[1] as $key => $file) {
            if ($extension){
                if ($file != '.' && $file != '..' && substr($file,-3) == $extension) {
                    $dir_ls[] = $file;
                }
            } else {
                if ($file != '.' && $file != '..') {
                    $dir_ls[] = $file;
                }
            }
        }
        $dir_ls['uri_root'] = $directory;
    } else {
        // create a handler for the directory
        $handler = opendir($directory);
        // keep going until all files in directory have been read
        while ($file = readdir($handler)) {
            // if $file isn't this directory or its parent, 
            // add it to the results array
            if ($extension){
                if ($file != '.' && $file != '..' && substr($file,-3) == $extension) {
                    $dir_ls[] = $file;
                }
            }else{
                if ($file != '.' && $file != '..') {
                    $dir_ls[] = $file;
                }
            }
        }
        // tidy up: close the handler
        closedir($handler);
    }
    // return
    return $dir_ls;
}

// }}}
// {{{ dom_to_array()
        
/**
* takes a phpDOM object and converts it to an array - taken from http://php.net/manual/en/book.dom.php (sweisman)
*
* normally used for building a dynamic legend
*
* @param object $root  the dom object
* @return array $result  an array of the dom
* @access public
* @since 0.8
*/

function dom_to_array($root)
{
    $result = array();

    if ($root->hasAttributes())
    {
        $attrs = $root->attributes;

        foreach ($attrs as $i => $attr)
            $result[$attr->name] = $attr->value;
    }

    $children = $root->childNodes;
    
    if ($children) {
        if ($children->length == 1)
        {
            $child = $children->item(0);

            if ($child->nodeType == XML_TEXT_NODE)
            {
                $result['_value'] = $child->nodeValue;

                if (count($result) == 1)
                    return $result['_value'];
                else
                    return $result;
            }
        }

        $group = array();

        for($i = 0; $i < $children->length; $i++)
        {
            $child = $children->item($i);

            if (!isset($result[$child->nodeName]))
                $result[$child->nodeName] = dom_to_array($child);
            else
            {
                if (!isset($group[$child->nodeName]))
                {
                    $tmp = $result[$child->nodeName];
                    $result[$child->nodeName] = array($tmp);
                    $group[$child->nodeName] = 1;
                }

                $result[$child->nodeName][] = dom_to_array($child);
            }
        }
    }
    return $result;
}
// }}}
// {{{ doubleNeedle()

/**
*
* used to doubles a substring within a string
*
* @param string $needle  the sub string to be doubled up
* @param string $haystack  the string that might contain needles
* @return string $haystack  the altered haystack
* @author Michael Johnson
* @since v1.1
*
* Note: double quotes are doubled to escape them during import to spreadsheet
* programs. This produces a clean csv file following RFC 4180 
*
*/

function doubleNeedle($needle, $haystack)
{
    // create an array of the locations of all of the needles
    $needles = array();
    $pos = strpos($haystack,$needle);
    while($pos !== FALSE){
        $needles[] = $pos;
        $startagain = $pos+strlen($needle);
        $pos = strpos($haystack, $needle, $startagain);
    }
    $offset = 0;
    foreach ($needles as $pos) {
        // as the haystack grows with new needles adjust the pos for new needles accordingly
        $offsetpos = $pos+$offset;
        $haystack = substr($haystack, 0, $offsetpos).$needle.substr($haystack, $offsetpos);
        $offset+=strlen($needle);
    }
    return $haystack;
}

//}}}
// {{{ dynLink()

/**
* makes up those nice chevron links to move up and down records
*
* @param string $dir  the direction of the link
* @param string $name  the name of the name value pair
* @param string $value  the value of the name value pair
* @return void
* @author Guy Hunt
* @since 0.2
*
*/

function dynLink($dir, $name, $value)
{
    if ($dir == 'prev') {
        $chevrons = '&lt;&lt;';
    }
    if ($dir == 'next') {
        $chevrons = '&gt;&gt;';
    }
    $var = "<a href=\"{$_SERVER['PHP_SELF']}?item_key=$name&amp;$name=$value\" class=\"chevrons\">$chevrons</a>";
    return($var);
}

// }}}
// {{{ feedBk()

/**
* output feedback to the user
*
* @param string $type  the type of feedback to give either error or message
* @return void
* @author Guy Hunt
* @since 0.3
*
* DEV NOTE: The code from the two include files now ought to be formally brought
* in as a function. The calls should be cleaned up to pass the array to this func
* which should then unset the arrays. In the meantime, this function is basically
* just a placeholder for an idea
*
* DEV NOTE: post v1.0 release, the old inc_ files have been removed and code brought
* into this function. This hasn't really fixed the problem, but it does reduce the
* number of obsolete include files by 2.
*
* As of v1.1 this unsets messages that have been reported
*
*/

function feedBk($type)
{
    global $$type;
    // only run this if the relevant array can be found
    if ($$type) {
        // set up a blank var
        $var = FALSE;
        // handle feedback types
        switch ($type) {
            // errors
            case 'error':
                $var .= "<div id=\"error\">\n";
                foreach ($error as $key => $err) {
                    $var .= "<p class=\"error\">{$err['vars']}</p>\n";
                }
                $var .= "</div>\n";
                break;
            // messages
            case 'message':
                $var .= "<div id=\"message\">\n";
                foreach ($message as $key => $msg) {
                    $var .= "<p>$msg</p>\n";
                }
                unset($message[$key]);
                $var .= "</div>\n";
                break;
        }
        echo "$var";
    }
}

// }}}
// {{{ frmElem()

/**
* returns a form element appropriate for a given field
*
* This function does NOT go to the DB, send current values TO this func inside
* the field. Consider using resFdCurr() to pull the values
*
* In order to return relevant form element this needs to handle various options:
*  1 - The field is blank
*  2 - The field is fresh for new data, but a default is suggested
*  3 - The field is hidden but defaults values are sent hidden (force data)
*  4 - The form is an edit of existing data and therefore needs filling with the
*      current details
*
* For each datatype, there is different logic for deciding which case is in play:
*
* In the case of keys and modtypes the decision about the form elem to return is
* currently based on the presence/absence of the key/val pair
*
* For other dataclasses the decision must be based on other factors at the top of
* each class
*
* This function only returns the form element not a wrapper 
*  so it should be used to return form elements for use in html forms
*
* @param array $field  contains settings values for this field
* @param string $itemkey  the itemkey
* @param string $value  a value set to FALSE for a blank or a default
* @return string $var  a resolved form element to slip into your form
* @author Guy Hunt
* @since 0.5
*
* NOTE 1: As of v1.1, there is no longer an option to send defaults direct to
* this function (previously param #4). Defaults are carried in the field using
* the optional variable 'field_op_default') GH 20/11/11
*
*/

function frmElem($field, $itemkey, $itemvalue=FALSE)
{
    // SETUP
    global $lang, $skin_path, $registered_files_dir, $registered_files_path, $purifier;
    

    $mk_delete = getMarkup('cor_tbl_markup', $lang,'delete');
    // get the 'current' data from the field
    $current = reqQst($field, 'current');
    // handle the hidden field variable
    $hide_field = $field['hidden'];
    if (is_string($hide_field)) {
        $mk_labelforhidden = getMarkup('cor_tbl_markup', $lang, $field['hidden']);
    } else {
        $mk_labelforhidden = FALSE;
    }
    // handle default option
    if (array_key_exists('field_op_default', $field)) {
        $default = $field['field_op_default'];
        // KEYWORDS: 'this_itemvalue'
        if ($default == 'this_itemvalue') {
            global $item_key, $$item_key;
            $default = $$item_key;
            if (!$default) {
                echo "ADMIN ERROR: frmElem() 'field_op_default' failed to get 'this_itemvalue'<br/>";
            }
            unset($$item_key, $item_key);
        }
    } else {
        $default = FALSE;
    }
    // if a field is hidden it needs to have an option default set
    if ($hide_field) {
        if (!$default && !$current) {
            echo "ADMIN ERROR: hidden fields need either a 'field_op_default' or current data<br/>";
            echo "ADMIN ERROR: field info:<br/>";
            printPre($field);
        }
    }
    
    // OUTPUT - by dataclass
    // for an itemkey
    if ($field['dataclass'] == 'itemkey') {
        // 1 - Blank
        if (!$itemvalue && !$default && !$hide_field) {
            $var = "<input type=\"text\" name=\"itemval\" value=\"$itemvalue\" class=\"reg_itemval\" />";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 2 - edits
        if ($itemvalue && !$default && !$hide_field) {
            $var = "<input type=\"text\" name=\"itemval\" value=\"$itemvalue\" class=\"reg_itemval\" />\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"edt\" />\n";
        }
        // 3 - blank with default
        if (!$itemvalue && $default && !$hide_field && $default != 'next') {
            $var = "<input type=\"text\" name=\"itemval\" value=\"$default\" class=\"reg_itemval\" />";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 4 - hidden (for edits that have an itemkey)
        if ($itemvalue && $hide_field) {
            $var = "<input type=\"hidden\" name=\"itemval\" value=\"$itemvalue\" />";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"edt\" />\n";
        }
        // 5 - hidden, 'next', add - for registers, hides user input, forces 'next', may show a label
        if (!$itemvalue && $hide_field && $default == 'next') {
            $var = "<input type=\"hidden\" name=\"itemval\" value=\"next\" />";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
            $var .= $mk_labelforhidden;
        }
        // 6 - user editable, default 'next', add - for registers, shows user input, defaults to 'next'
        if (!$itemvalue && !$hide_field && $default == 'next') {
            $var = "<input type=\"text\" name=\"itemval\" value=\"next\" />";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 7 - user editable, default 'next', itemvalue already exists - for edit
        if ($itemvalue && !$hide_field && $default == 'next') {
            $var = "<input type=\"text\" name=\"itemval\" value=\"$itemvalue\" />";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
    }
    
    // for a modtype
    if ($field['dataclass'] == 'modtype') {
        // Basic info
        $modtype = $field['classtype'];
        $mod = substr($modtype, 0, 3);
        $tbl = $mod.'_lut_'.$modtype;
        // 1 - Blank
        if (!$itemvalue && !$default) {
            $var = ddAlias(FALSE, FALSE, $tbl, $lang, 'modtype', "ORDER BY $modtype", 'code');
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 1b - Blank (but where the itemkey is a 'next')
        if ($itemvalue == 'next' && !$default) {
            $var = ddAlias(FALSE, FALSE, $tbl, $lang, 'modtype', "ORDER BY $modtype", 'code');
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 2 - edits
        if ($itemvalue && !$default && $itemvalue != 'next') {
            $cur_type_id = getModType($mod, $itemvalue);
            $cur_type_alias = getAlias($tbl, $lang, 'id', $cur_type_id, 1);
            $var = ddAlias($cur_type_id, $cur_type_alias, $tbl, $lang, 'modtype', "ORDER BY $modtype", 'code');
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"edt\" />\n";
        }
        // 3 - blank with default
        if (!$itemvalue && $default) {
            $cur_type_id = $default;
            $cur_type_alias = getAlias($tbl, $lang, 'id', $cur_type_id, 1);
            $var = ddAlias($cur_type_id, $cur_type_alias, $tbl, $lang, 'modtype', "ORDER BY $modtype", 'code');
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 3b - blank (but where the itemkey is a 'next') with default
        if ($itemvalue && $default) {
            $var = "<input type=\"hidden\" name=\"modtype\" value=\"$default\" />\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
    }
    
    // for class 'txt'
    if ($field['dataclass'] == 'txt') {
        // 1 - Blank
        if (!$default && !$current) {
            $var = "<textarea id=\"{$field['classtype']}\" name=\"{$field['classtype']}\" rows=\"5\" cols=\"12\" ></textarea>";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 2 - edits
        if ($itemvalue && is_array($current)) {
            $var = "<textarea id=\"{$field['classtype']}\" name=\"{$field['classtype']}\" rows=\"5\" cols=\"12\" >";
            $var .= "{$current[0]['txt']}";
            $var .= "</textarea>\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_id\" value=\"{$current[0]['id']}\" />\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"edt\" />\n";
        }
        // 3 - blank with default
        if (!$itemvalue && $default) {
            $var = "<textarea id=\"{$field['classtype']}\" name=\"{$field['classtype']}\" rows=\"5\" cols=\"12\">$default</textarea>";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
    }
    
    // for class 'date'
    if ($field['dataclass'] == 'date') {
        // 1 - Blank
        if (!$current && !$default) {
            $var = dateSelect('text', $field['datestyle'], $field['classtype']);
            $var .= "<button type=\"button\" onclick=\"setDateNow('{$field['datestyle']}','{$field['classtype']}')\">NOW</button>";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 2 - edits
        if (is_array($current)) {
            $date = $current[0]['date'];
            $var = dateSelect('text', $field['datestyle'], $field['classtype'], $date);
            $var .= "<button type=\"button\" onclick=\"setDateNow('{$field['datestyle']}','{$field['classtype']}')\">NOW</button>";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_id\" value=\"{$current[0]['id']}\" />\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"edt\" />\n";
        }
        // 3 - blank with default
        if (!$current && $default) {
            if ($default == 'now') {
               $var = dateSelect('text', $field['datestyle'], $field['classtype'], date('Y-m-d'));
               $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
            } else {
                echo "frmElem: no handler for date edit routines (with defaults) built yet";
            }
        }
    }
    
    // for an actor - class 'action'
    if ($field['dataclass'] == 'action') {
        // 1 - Blank
        if (!$default && !$current) {
            $var =
                ddActor(
                    $field['classtype'],
                    $field['actors_mod'],
                    $field['actors_element'],
                    $field['actors_elementclass'],
                    FALSE,
                    FALSE,
                    $field['actors_type']
            );
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 2 - edits
        if (is_array($current)) {
            // if this is a single actor event
            if ($field['actors_style'] == 'single') {
                // Get the actor for this actiontype for this item
                $action = end($current);
                $elem = 
                    getActorElem(
                        $action['actor_itemvalue'],
                        $field['actors_element'],
                        $field['actors_mod'].'_cd',
                        $field['actors_elementclass']
                        
                );
                $var =
                    ddActor(
                        $field['classtype'],
                        $field['actors_mod'],
                        $field['actors_element'],
                        $field['actors_elementclass'],
                        $action['actor_itemvalue'],
                        $elem,
                        $field['actors_type']
                );
                // add on the frag id to edit
                $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_id\" value=\"{$action['id']}\" />\n";
                // add on the qtype
                $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"edt\" />\n";
            }
            // if this is a multi actor action list them first
            if ($field['actors_style'] == 'list') {
                $var = '<ul>';
                foreach ($current as $action) {
                    // Set up code for the delete button
                    $del_sw = "<a href=\"{$_SERVER['PHP_SELF']}";
                    $del_sw .= "?$itemkey=$itemvalue&amp;update_db=delfrag&amp;dclass=action";
                    $del_sw .= "&amp;delete_qtype=del&amp;frag_id={$action['id']}\"";
                    $del_sw .= " class=\"smalldelete\">";
                    $del_sw .= "<img src=\"$skin_path/images/plusminus/delete_small.png\" class=\"smalldelete\" alt=\"$mk_delete\" />";
                    $del_sw .= "</a>";
                    // and the var
                    $var .= '<li>';
                    $var .= $action['current'];
                    $var .= " $del_sw";
                    $var .= "</li>\n";
                }
                $var .= "<li>\n";
                $var .=
                    ddActor(
                        $field['classtype'],
                        $field['actors_mod'],
                        $field['actors_element'],
                        $field['actors_elementclass'],
                        'skip',
                        '---',
                        $field['actors_type']
                );
                $var .= "</li>\n";
                $var .= "</ul>\n";
                // add on the qtype (in the case of 'list style', this is actually an 'add' routine)
                $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
            }
        }
        // 3 - blank with default
        if (!$current && $default) {
            $default_id = FALSE;
            $default_text = FALSE;
            if ($default == 'user') {
                $default_id = 'pp';
                $test = $field['actors_element'];
                $default_text = "db_lookup_$test";
                
            } else {
                // check to see if the default is a valid user on the ABK
                if (!chkValid($default, 0, 0, 'abk_tbl_abk', 'abk_cd')) {
                    $default_id = $default;
                    // lookup the relevant bit of the actor to display
                    $default_text =
                        getActorElem(
                            $default,
                            $field['actors_element'],
                            'abk_cd',
                            $field['actors_elementclass']
                    );
                }
            }
            $var =
                ddActor(
                    $field['classtype'],
                    $field['actors_mod'],
                    $field['actors_element'],
                    $field['actors_elementclass'],
                    $default_id,
                    $default_text,
                    $field['actors_type']
            );
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
    }
    
    // for class 'number'
    if ($field['dataclass'] == 'number') {
        // 1 - Blank
        if (!$default && !$current) {
            $var = "<input type=\"number\" class=\"number\" name=\"{$field['classtype']}\" />";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 2 - edits
        if (is_array($current)) {
            $val = getNumber($itemkey, $itemvalue, $field['classtype']);
            $var = "<input pattern=\"[0-9/w]*\" class=\"number\" name=\"{$field['classtype']}\" value=\"{$val[0]['number']}\" />\n";
            // Set up code for the delete button
            $del_sw = "<a href=\"{$_SERVER['PHP_SELF']}";
            $del_sw .= "?$itemkey=$itemvalue&amp;";
            $del_sw .= "update_db=delfrag&amp;dclass=number";
            $del_sw .= "&amp;delete_qtype=del&amp;";
            $del_sw .= "frag_id={$field['current']['id']}\" class=\"smalldelete\">\n";
            $del_sw .= "<img src=\"$skin_path/images/plusminus/delete_small.png\" class=\"smalldelete\"";
            $del_sw .= " alt=\"on/off_swtich\" />";
            $del_sw .= "</a>\n";
            $var .= "$del_sw\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_id\" value=\"{$field['current']['id']}\" />\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"edt\" />\n";
        }
        // 3 - blank with default
        if (!$current && $default) {
            $var = "<input type=\"number\" class=\"number\" name=\"{$field['classtype']}\" value=\"$default\" />";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
    }

    // for class 'attribute'
    // attr, handle erroneous dataclass naming
    if ($field['dataclass'] == 'attr') {
        echo "ADMIN ERROR: as of v1.0 dataclass in fields must be declared as 'attribute' not 'attr'<br/>function frmElem()<br/>";
        $field['dataclass'] = 'attribute';
    }
    if ($field['dataclass'] == 'attribute') {
        //check to see what type of attribute we are dealing with (attra(i.e. boolean) or attrb('normal'))
        if (array_key_exists('attribute', $field)) {
            $attr_type = 'attra';
            $attr_bool = $current['attr_bool'];
        } else {
            $attr_type = 'attrb';
            $attr_bool = 'na';
        }
        // 1 - Blank (attrb)
        if (!$default && !$current && $attr_type == 'attrb') {
            // the blank form needs to send a bv as a  hidden field
            // the default is to send a 1 unless specified in a field_op
            if (array_key_exists('field_op_bv', $field)) {
                // do something appropriate
                $var = "<input type=\"hidden\" name=\"{$field['classtype']}_bv\" value=\"{$field['field_op_bv']}\" />\n";
            } else {
                $var = "<input type=\"hidden\" name=\"{$field['classtype']}_bv\" value=\"1\" />\n";
            }
            $var .= ddAttr(FALSE, FALSE, $field['classtype'], 'dd');
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 2 - Edits (attrb) (a list of existing with del functionality and then the add list)
        if (is_array($current) && $attr_type == 'attrb') {
            // parse the querystring for the delete options below
            if (!empty($_SERVER['QUERY_STRING'])) {
                parse_str($_SERVER['QUERY_STRING'], $qstrvars);
                // remove any unwanted vars
                //unset ($qstrvars['unwanted']);
                // rebuild
                $cleanqstrvars = array();
                foreach ($qstrvars as $qstrvar){
                    $cleanqstrvars[] = $purifier->purify($qstrvar);
                }
                $qstr = http_build_query($cleanqstrvars, '', '&amp;');
            } else {
                $qstr = FALSE;
            }
            //make a form to allow deletion of the existing attrs
            $var = "<ul class=\"inp\">\n";
            foreach ($current as $attr_data) {
                $attr = getAlias('cor_lut_attribute', $lang, 'id', $attr_data['attribute'], 1);
                // make a delete option if appropriate
                $del_sw ="<span class=\"value\">";
                $del_sw .= "<a href=\"{$_SERVER['PHP_SELF']}";
                $del_sw .= "?$qstr";
                $del_sw .= "&amp;update_db=delfrag&amp;dclass=attribute";
                $del_sw .= "&amp;delete_qtype=del&amp;frag_id={$attr_data['id']}\">";
                $del_sw .= "<img class=\"smalldelete\" src=\"$skin_path/images/plusminus/delete_small.png\" alt=\"delete\" />";
                $del_sw .= "</a>";
                $del_sw .= "</span>";
                $var .= "<li class=\"data\"><span class=\"data\">$attr</span>$del_sw</li>\n";
            }
            $var .= "</ul>\n";
            $var .= ddAttr(FALSE, FALSE, $field['classtype']);
            // the form needs to send a bv (hidden), the default is to send a 1 unless specified in a field_op
            if (array_key_exists('field_op_bv', $field)) {
                $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_bv\" value=\"{$field['field_op_bv']}\" />\n";
            } else {
                $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_bv\" value=\"1\" />\n";
            }
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
            // the form needs to send a bv (hidden), the default is to send a 1 unless specified in a field_op
            if (array_key_exists('field_op_bv', $field)) {
                $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_bv\" value=\"{$field['field_op_bv']}\" />\n";
            } else {
                $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_bv\" value=\"1\" />\n";
            }
            
        }
        // 3 - blank with default (attrb)
        if ($default && !$current && $attr_type == 'attrb') {
            if (is_numeric($default)) {
                $top_id = $default;
                $top_val = getAlias('cor_lut_attribute', $lang, 'id', $top_id, 1);
            } else {
                $top_id = getSingle('id', 'cor_lut_attribute', "attribute = \"{$default}\"");
                $top_val = getAlias('cor_lut_attribute', $lang, 'id', $top_id, 1);
            }
            $var = ddAttr($top_id, $top_val, $field['classtype']);
            // the form needs to send a bv (hidden), the default is to send a 1 unless specified in a field_op
            if (array_key_exists('field_op_bv', $field)) {
                $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_bv\" value=\"{$field['field_op_bv']}\" />\n";
            } else {
                $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_bv\" value=\"1\" />\n";
            }
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 4 - Blank (attra)
        if (!$default && $attr_bool === FALSE && $attr_type == 'attra') {

            //get the id of the attribute we are adding
            $attr_numeric = getSingle('id','cor_lut_attribute',"attribute = '{$field['attribute']}'");
            $var = "<button class=\"bool\">";
            $var .= "<img src=\"$skin_path/images/onoff/chk_na.png\"";
            $var .= " alt=\"on/off_switch\" />";
            $var .= "{$current['alias_bool']}</button>";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_bv\" value=\"1\" />\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}\" value=\"$attr_numeric\" />\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 5 - True (attra)
        if (!$default && $attr_bool !== FALSE && $attr_type == 'attra') {

            // Set up code for the delete button
            $del_sw = "<a href=\"{$_SERVER['PHP_SELF']}";
            $del_sw .= "?$itemkey=$itemvalue&amp;";
            $del_sw .= "update_db=delfrag&amp;dclass=attribute";
            $del_sw .= "&amp;delete_qtype=del&amp;";
            $del_sw .= "frag_id={$current['frag_id']}\">";
            $del_sw .= "<img src=\"$skin_path/images/plusminus/delete_small.png\" class=\"smalldelete\" ";
            $del_sw .= " alt=\"on/off_swtich\" />";
            $del_sw .= "</a>";

            //check what state the boolean is in
            if($attr_bool == '1'){
                $bool_image = 'chk_on.png';
                $set_bv = '0';
            }else{
                $bool_image = 'chk_off.png';
                $set_bv = '1';
            }
            //get the id of the attribute we are editing
            $attr_numeric = getSingle('id','cor_lut_attribute',"attribute = '{$field['attribute']}'");
            $var = "<button class=\"bool\">";
            $var .= "<img src=\"$skin_path/images/onoff/$bool_image\"";
            $var .= " alt=\"on/off_switch\" />";
            $var .= @"{$current['alias_bool']}";
            $var .= "</button>";
            $var .= $del_sw;
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_bv\" value=\"$set_bv\" />\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}\" value=\"$attr_numeric\" />\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"edt\" />\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_id\" value=\"{$current['frag_id']}\" />\n";
            
        }
    }
    
    // for class 'span'
    if ($field['dataclass'] == 'span') {
        // All cases need this stuff
        if ($field['field_op_label']) {
            $b_label = "<label>{$field['b_label']}</label>\n";
            $e_label = "<label>{$field['e_label']}</label>\n";
        } else {
            $b_label = FALSE;
            $e_label = FALSE;    
        }
        // handle the divider option
        if (array_key_exists('field_op_divider', $field)) {
            $divider = $field['field_op_divider'];
        } else {
            $divider = FALSE;
        }
        // handle the AD/BC modifier option
        if (array_key_exists('field_op_modifier', $field)) {
            $field_op_modifier = $field['field_op_modifier'];
        } else {
            $field_op_modifier = FALSE;
        }
        if ($field_op_modifier) {
            $b_modifier = "<select name=\"{$field['classtype']}_beg_modifier\">\n";
            $b_modifier .= "<option value=\"ad\">AD</option>\n";
            $b_modifier .= "<option value=\"bc\">BC</option>\n";
            $b_modifier .= "</select>\n";
            $e_modifier = "<select name=\"{$field['classtype']}_end_modifier\">\n";
            $e_modifier .= "<option value=\"ad\">AD</option>\n";
            $e_modifier .= "<option value=\"bc\">BC</option>\n";
            $e_modifier .= "</select>\n";
        } else {
            $b_modifier = FALSE;
            $e_modifier = FALSE;
        }
        // 1 - Blank
        if (!$default && !$current) {
            $var = $b_label;
            $var .= "<input type=\"text\" name=\"{$field['classtype']}_beg\" />\n";
            $var .= $b_modifier;
            $var .= $divider;
            $var .= $e_label;
            $var .= "<input type=\"text\" name=\"{$field['classtype']}_end\" />\n";
            $var .= $e_modifier;
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        }
        // 2 - edits (a list of existing with del functionality and then the add list)
        if (is_array($current)) {
            //make a list of the existing spans
            $var = "<ul class=\"inp\">\n";
            foreach ($current AS $span) {
                // Set up code for the delete button 
                $del_sw = "<a href=\"{$_SERVER['PHP_SELF']}"; 
                $del_sw .= "?$itemkey=$itemvalue&amp;update_db=delfrag&amp;dclass=span"; 
                $del_sw .= "&amp;delete_qtype=del&amp;frag_id={$span['id']}\">"; 
                $del_sw .= "<img src=\"$skin_path/images/plusminus/delete_small.png\" class=\"smalldelete\" "; 
                $del_sw .=" alt=\"[-]\" />"; 
                $del_sw .= "</a>";
                // if a modifier is set, modify the output before it gets to the user
                // this should be abstracted to work fo other types of modifier
                if ($field_op_modifier) {
                    $start = $span['beg']-2000;
                    $end = $span['end']-2000;
                    // sort out epochs
                    if ($start > 0) {
                        $start_epoch = 'BC';
                    } else {
                        $start_epoch = 'AD';
                        $start = abs($start);
                    }
                    if ($end > 0) {
                        $end_epoch = 'BC';
                    } else {
                        $end_epoch = 'AD';
                        $end = abs($end);
                    }
                    // if the beginning and end are the same just display a single. GH 9/9/11
                    if ($start == $end) {
                        $start_epoch = FALSE;
                        $divider = FALSE;
                        $end = FALSE;
                        $end_epoch = FALSE;
                    }
                    // Set up the var 
                    $var .= "<li class=\"row\">";
                    $var .= "$start $start_epoch";
                    $var .= $divider;
                    $var .= "$end $end_epoch&nbsp;$del_sw</li>\n";
                } else {
                    // if the beginning and end are the same just display a single. GH 9/9/11
                    if ($span['beg'] == $span['end']) {
                        $divider = FALSE;
                        $span['end'] = FALSE;
                    }
                    $var .= "<li class=\"row\">{$span['beg']}";
                    $var .= $divider;
                    $var .= "{$span['end']}&nbsp;$del_sw</li>\n";
                }
            }
            $var .= "</ul>\n";
        }
        // 3 - blank with default
        if ($default) {
            $var = 'NOT IMPLEMENTED';
        }
    }
    
    // for class 'xmi'
    if ($field['dataclass'] == 'xmi') {
        //check if the xmi mod is configured properly - if not throw an error
        if(!array_key_exists('xmi_mod', $field)) {
            echo "frmElem() (dataclass xmi) - no xmi mod set!";
        }
        if(array_key_exists('op_pattern', $field)) {
            $pattern = $field['op_pattern'];
        } else {
            $pattern = "";
        }
        // 1 - Blank
        if (!$default && !$current && !$hide_field) {
            $var = "<input id=\"{$field['classtype']}_{$field['xmi_mod']}\" $pattern";
            $var .= " name=\"{$field['classtype']}_{$field['xmi_mod']}\"></input>";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_{$field['xmi_mod']}_qtype\"";
            $var .= " value=\"add\" />\n";
        }
        // 2 - edits (a list of existing with del functionality and then the add list)
        if (!$default && is_array($current)) {
            $var = "<input id=\"{$field['classtype']}_{$field['xmi_mod']}\" $pattern";
            $var .= " name=\"{$field['classtype']}_{$field['xmi_mod']}\" value =\"";
            foreach ($current as $xmi) {
                $var .= $xmi['xmi_itemvalue'].' ';
            }
            $var .= "\"/>\n";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_{$field['xmi_mod']}_qtype\"";
            $var .= " value=\"edt\" />\n";
        }
        // 3 - blank with default
        if ($default && !$hide_field) {
            $var = "<input id=\"{{$field['classtype']}_{$field['xmi_mod']}\" $pattern";
            $var .= " name=\"{$field['classtype']}_{$field['xmi_mod']}\" value=\"$default\"/>";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_{$field['xmi_mod']}_qtype\"";
            $var .= " value=\"add\" />\n";
        }
        // 4 - hidden with default
        if ($hide_field) {
            $var = "<input type=\"hidden\" name=\"{$field['classtype']}_{$field['xmi_mod']}\" value=\"$default\" />";
            $var .= "<input type=\"hidden\" name=\"{$field['classtype']}_{$field['xmi_mod']}_qtype\"";
            $var .= " value=\"add\" />\n";
            $var .= $mk_labelforhidden;
        }
    }    
    // for class 'file'
    if ($field['dataclass'] == 'file') {
        global $sf_display, $conf_media_browser;
        if (!is_numeric($field['classtype'])) {
            $filetype = getSingle('id', 'cor_lut_filetype', "filetype = \"{$field['classtype']}\"");
        }
        $var = '';
        //work out if we are on a register or not = DEV NOTE: Is there a cleaner way of doing this?
        if (!$itemvalue) {
            $link_file_val = 'register';
            $lboxreload = 0;
        } else {
            $link_file_val = 'item';
            $lboxreload = 1;
        }
       // $filesroutine = $field['routine'];
        //at this point we should grab the files currently attached
        //$files_attached = getFile($itemkey,$itemvalue);
        // 1 - Blank
        if (!$default && !$current) {
            //Add a 'no files' message
            $mk_nofiles = getMarkup('cor_tbl_markup', $lang, 'nofiles');
            //add the option for the media browser and also a hidden field to take the file_ids from the media browser
            $var = "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
            $var .= "<input type=\"hidden\" id=\"mb_fileform\" name=\"{$field['classtype']}[]\" value=\"\" />";
            $var .= "<a class=\"btn cboxlarge\" href=\"overlay_holder.php?lboxreload=$lboxreload&sf_conf=$conf_media_browser&link_file=$link_file_val&sf_val=$itemvalue&sf_key=$itemkey&filetype=$filetype\">";
            $var .= "<img src=\"$skin_path/images/recordnav/addfile.png\" alt=\"media_browser\" class=\"med\"/></a>";
            $var .= "<ul id=\"mb_file_list\"></ul>";
            $var .= $mk_nofiles;
        }
        // 2 - edits
        if (!empty($current)) {
            // make a list for edits
            $edit_list = FALSE;
            if (!$itemvalue) {
                $link_file_val = 'register';
            } else {
                $link_file_val = 'item';
            }
            $var .= "<a class=\"btn cboxlarge\" href=\"overlay_holder.php?lboxreload=$lboxreload";
            $var .= "&amp;sf_conf=conf_mac_mediabrowser&amp;link_file=$link_file_val";
            $var .= "&amp;sf_val=$itemvalue&amp;sf_key=$itemkey&amp;filetype=$filetype\">";
            $var .= "<img src=\"$skin_path/images/recordnav/addfile.png\"";
            $var .= " alt=\"media_browser\" class=\"med\"/></a>";
            $var .= "<ul id=\"mb_file_list\"></ul>";
            // list current files
            $var .= "<ul>";
            foreach ($current as $file) {
                // Set up code for the delete button
                $del_sw = "<a href=\"{$_SERVER['PHP_SELF']}";
                $del_sw .= "?$itemkey=$itemvalue&amp;";
                $del_sw .= "update_db=delfrag&amp;dclass=file";
                $del_sw .= "&amp;delete_qtype=del&amp;";
                $del_sw .= "frag_id={$file['frag_id']}\"";
                $del_sw .= "class=\"photodelete\">";
                $del_sw .= "<img src=\"$skin_path/images/plusminus/delete_small.png\"";
                $del_sw .= " alt=\"[X]\" class=\"med\"/>";
                $del_sw .= "</a>";
                if ($sf_display == 'thumbs') {
                    //check for the thumbnail - if there isn't one then just put in the default
                    if (!file_exists("{$registered_files_dir}/arkthumb_{$file['id']}.jpg")) {
                        $thumb_src = mkThumb($file,'arkthumb');
                        $webthumb_src = "<li class=\"file_thumbs\">";
                    } else {
                        $thumb = mkThumb($file,'arkthumb');
                        $thumb_src = "$thumb</a>";
                        $webthumb_src = "<li class=\"file_thumbs\">";
                        $webthumb_src .= "<a href=\"{$registered_files_path}/webthumb_{$file['id']}.jpg\"";
                        $webthumb_src .= " class=\"imagebox sketch_img_display\" title=\"{$file['filename']}\">";
                    }
                    $var .= $webthumb_src;
                    $var .= $thumb_src;
                    $var .= "$del_sw";
                    $var .= "</li>";
                } else {
                    $var .= "<li class=\"file_list\">{$file['filename']}&nbsp;$del_sw</li>\n";
                }
                unset($del_sw);
            }
            $var .= "</ul>";
        }
        // 3 - blank with default
        if (!$current && $default) {
            echo "ADMIN ERROR: File forms can't handle defaults yet<br/>\n";
        }
    }
    
    // get options
    if ($field['dataclass'] == 'op') {
        $mk_save = getMarkup('cor_tbl_markup', $lang, 'save');
        $var = "<button type=\"submit\">$mk_save</button>";
    }
    
    if (isset($var)) {
        return ($var);
    } else {
        echo "frmElem: form element '{$field['field_alias']}' not set up";
    }
}

// }}}
// {{{ fuPatternMatch($file)
/**
* checks if file matches the pattern defined in settings.php
*
* @param string $file
* @return int $result
* @author Hembo Pagi (hembo.pagi@arheovisioon.ee)
* @author Stu Eve (stuarteve@lparchaeology.com)
* @since 0.8
*
*/
function fuPatternMatch($file, $fu, $pattern_name=FALSE)
{
    if (array_key_exists('explode', $fu)) {
        //get rid of the extension for now
        $explode_file = explode('.',$file);
        $explode_file = explode($fu['explode'], $explode_file[0]);
        return $explode_file;
    } else {
        if ($pattern_name) {
            $pattern = $fu['pattern'][$pattern_name];
        } else {
            $pattern = $fu['pattern'];
        }
        // default to the first pattern if this is an array but no name was sent
        if (is_array($pattern)) {
            $pattern = reset($pattern);
        }
        preg_match($pattern, $file, $matches);
        if (array_key_exists('debug_mode', $fu)) {
            if (!empty($matches)) {
                //printPre($matches);
            } else {
                echo "No matches:<br/>";
                echo "file: $file</br>\n";
                echo "fu['pattern']: {$fu['pattern'][$pattern_name]}</br>\n";
            }
        }
        // GH 30/7/12: I have revised this selection logic to use the last match in the matches
        // Hembo had this set up to take a specific numbered position, but I don't really know what
        // is behind that reasoning. My approach isn't very logical either, but for now, it works.
        if (!empty($matches)) {
            return end($matches);
        } else {
            return FALSE;
        }
        // Commented out Hembo's Code below:
        // if (count($matches)>4) {
        //     return $matches[4]; // this is the ID the file will be linked in module tabele
        // } elseif (count($matches)<4 && !empty($matches)) {
        //     return $matches[3]; // this is the ID the file will be linked in module tabele
        // } else {
        //     return 0;
        // }
    }
}

// }}}
//{{{ getCurlData
/*
**
* retrieves data from a URL and puts it into a variable
*
* this function uses cURL to go to a URL and retrieve a response
* it then loads this response into a variable and returns it
*
*
* @param string $url  a fully resolved url
* @return string $return  the result of the curl requestcas a string
* @author Stuart Eve
* @since 1.2
*
*
*/


function getCurlData($url)
{
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}  

//}}}
// {{{ getSfState()

/**
* gets the state of subform
*
* used to put together the 'state' of a subform. This state variable can 
* then be used to inform a subform how it should render output (e.g. if 
* the return state is "p_max_edit" then the subform would know that it has
* to render the output as if the the form was in a primary column, maximised
* and being edited)
*
* for further info on the different return states see the wiki
*
* @param string $column  the column (either 'primary_col' or 'secondary_col')
* @param string $view_state  the state of the view (either 'min' or 'max')
* @param string $edit_state  the state of the view (either 'min' or 'max')
* @return string $return_state  the concatenated state string
* @author Stuart Eve
* @since 0.5
*
* NOTE 1: As of v1.1 tabbed views require other column types. For now, these
* are all treated as 'primary_col' for the purposes of sf_state
*
*/

function getSfState($column, $view_state, $edit_state)
{
    // handle v1.1 column types
    switch ($column) {
        case 'primary_col':
        case 'secondary_col':
            // do nothing
            break;
            
        default:
            $column = 'primary_col';
            break;
    }
    // debug
    // printf ("<br/>column: $column | view state: $view_state | edit state: $edit_state<br/>");
    // lets go through the options to figure out
    if (($column == 'primary_col' || $column == 'secondary_col') && $view_state == 'min') {
        $return_state = 'min_view';
        } elseif ($column == 'primary_col' && $view_state == 'max' && $edit_state == 'ent') {
            $return_state = 'p_max_ent';
            } elseif ($column == 'primary_col' && $view_state == 'max' && $edit_state == 'edit') {
                $return_state = 'p_max_edit';
                } elseif ($column == 'primary_col' && $view_state == 'max' && $edit_state == 'view') {
                    $return_state = 'p_max_view';
                    } elseif ($column == 'secondary_col' && $view_state == 'max' && $edit_state == 'edit') {
                        $return_state = 's_max_edit';
                        } elseif ($column == 'secondary_col' && $view_state == 'max' && $edit_state == 'view') {
                            $return_state = 's_max_view';
                        } else {
                            $return_state = FALSE;
    }
    return $return_state;
}

// }}}
// {{{ getStylesheet()

/**
* chooses the correct stylesheet dependent on the detected browser
*
* @param string $browser
* @return string $stylesheet  string  the path to the stylesheet
* @author Stuart Eve
* @since 0.6
*
* Note: This used to be used as an include script from v0.1 to 0.6.
*
* Note: As of v0.7 this is set up to give newer (v7 and later) versions
* of IE the main stylesheet rather than an IE specific sheet which is now
* reserved for older less compliant IE browsers.
*
* Note: As of v1.1 ARK no longer support OLD_MSIE and therefore only offers one stylesheet per skin
*/

function getStylesheet($browser)
{
    global $skin;
    $stylesheet = "skins/$skin/stylesheets/ark_main.css";
    // Return stylesheet
    return $stylesheet;
}
// }}}
// {{{ getWebHost()

/**
* returns the fully resolved web host (including port)
*
* @return string $web_host containing the webhost
* @author Stuart Eve
* @since 0.6
*
*/

function getWebHost()
{
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
    $protocol = 'http' . $s;
    $port = explode(':',$_SERVER["HTTP_HOST"]);
    if (array_key_exists(1,$port)) {
        $port = $port[1];
    } else {
        $port = FALSE;
    }
    $url = $protocol."://".$_SERVER['SERVER_NAME'].':'.$port.$_SERVER['REQUEST_URI'];
    $web_host_array = parse_url($url);
    if ($port) {
        $web_host = $web_host_array['scheme'] . "://" .  $web_host_array['host'] . ":" . $web_host_array['port'];
    } else {
        $web_host = $web_host_array['scheme'] . "://" .  $web_host_array['host'];
    }
    return $web_host;
}
// }}}
// {{{ in_array_multi()

/**
* checks for a var in a multidim array
*
* @param string $needle  the term to search for
* @param array $haystack  the multidim array to search in
* @return boolean $found  TRUE or FALSE
* @author (not too sure) possibly taken off the php.net manual
* @since 0.4
*
*/

function in_array_multi($needle, $haystack) 
{
    $found = false;
    foreach($haystack as $value) {
        if ((is_array($value) && in_array_multi($needle, $value)) || $value == $needle) {
            $found = true;
        }
    }
    return $found;
}

// }}}
// {{{ isItemkey()
        
/**
* runs a quick and dirty check on a string to see if it is in the
* format xxx_cd. Returns TRUE if it matches the pattern and FALSE
* if not
*
* @param string $key  the key to check
* @access public
* @since 0.6
*/

function isItemkey($key)
{
    // check that the key is setup properly
    if (!$key) {
        echo "the key was FALSE in isItemkey<br/>";
        return FALSE;
    }
    $keybits = explode('_', $key);
    if (count($keybits) != 2) {
        return FALSE;
    } else {
        if (strlen($keybits[0]) != 3) {
            return FALSE;
        } else {
            if ($keybits[1] != 'cd') {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
}

// }}}
// {{{ itemValNatSort()

/**
* sorts itemvals into natural order
*
* @param array $a  an array
* @param array $b  an array
* @return array  sorted array
* @author Guy Hunt
* @since 0.5
*
* NOTE: This function is used by the uasort() function which acts as a wrapper
*/

function itemValNatSort($a, $b)
{
    return strnatcasecmp($a["itemval"], $b["itemval"]);
}

// }}}
// {{{ loadFiles()

/**
* lists files in a directory and returns the information as an array
*
* @param string $dir the directory to search
* @return array $files
* @author http://webxadmin.free.fr
* @since 0.6
*
*/

function loadFiles($dir)
{
    $Files = array();
    $It =  opendir($dir);
    if (!$It) {
        die('Cannot list files for ' . $dir);
    }
    while ($Filename = readdir($It)) {
        if ($Filename == '.' || $Filename == '..')
            continue;
        if (is_file($dir . $Filename)) {
            $LastModified = filemtime($dir . $Filename);
            $Size = filesize($dir . $Filename);
            $Files[] = array($Filename,$dir .$Filename, $Size, $LastModified);
        }
    }
    return $Files;
}

// }}}
// {{{ mkArkFooter()

/**
* makes a footer
*
* @return $var string  the XHTML footer
* @author Guy Hunt
* @since v1.1
*
* Probably should make this run off a settings var GH 31-8-11
* Updated this to be contingent on whether or not there is an 
* authorised user logged in. (only displays credits on index page). JO 20-02-12
*
*/

function mkArkFooter()
{
    global $lang, $soft_name, $ark_root_path;
    if (reqQst($_SESSION, 'authorised')) {
        $mk_help = getMarkup('cor_tbl_markup', $lang, 'help');
        $mk_logout = getMarkup('cor_tbl_markup', $lang, 'logout');
        $var = FALSE;
        $var .= "<div class=\"bt-nav\">\n";
        $var .= "<span>$soft_name</span>";
        $var .= mkNavLang();
        $var .= "<span><a href=\"http://ark.lparchaeology.com/wiki\">$mk_help</a></span>";
        $var .= "<span class=\"noborder\"><a href=\"{$ark_root_path}/index.php?logout=true\">$mk_logout</a></span>";
        $var .= "</div>\n";
        $var .= "<div class=\"credits\">\n";
        $var .= "<p>Powered by</p>\n";
        $var .= "<span class=\"noborder\"><a title=\"ARK\" href=\"http://ark.lparchaeology.com\">ARK</a></span>";
        $var .= "</div>\n";
        return ($var);
    } else {
        $var = FALSE;
        $var .= "<div class=\"credits\">\n";
        $var .= "<p>Powered by</p>\n";
        $var .= "<span class=\"noborder\"><a title=\"ARK\" href=\"http://ark.lparchaeology.com\">ARK</a></span>";
        $var .= "</div>\n";
        return ($var);
    }
}

// }}}
// {{{ mkChat()

/**
* makes up the chat style output for searches
*
* @param array $snip_array  containing the snippets to make into the chat
* @return string $chat  a resolved xhtml string
* @author Guy Hunt
* @since 0.4
*/

function mkChat ($snip_array)
{
    // start the snippets cleanly
    $attribute_chat = '<p class="search_chat">';
    $txt_chat = '<p class="search_chat">';
    $action_chat = '<p class="search_chat">';
    $place_chat = '<p class="search_chat">';
    // loop over the snippets
    foreach ($snip_array AS $snip) {
        if ($snip['class'] == 'attribute') {
            $attribute_chat .= "<span class=\"search_nm\">{$snip['type']}:</span> {$snip['snip']} ";
        }
        if ($snip['class'] == 'action') {
            $action_chat .= "<span class=\"search_nm\">{$snip['type']}:</span> {$snip['snip']} ";
        }
        if ($snip['class'] == 'txt') {
            $txt_chat .= "<span class=\"search_nm\">{$snip['type']}:</span> ";
            $txt_chat .= substr($snip['snip'],0,200);
            $txt_chat .= "<br/>";
        }
        if ($snip['class'] == 'key') {
            $txt_chat .= "<span class=\"search_nm\">{$snip['type']}:</span> ";
            $txt_chat .= substr($snip['snip'],0,200);
            $txt_chat .= "<br/>";
        }
        if ($snip['class'] == 'modtype') {
            $txt_chat .= "<span class=\"search_nm\">{$snip['type']}:</span> ";
            $txt_chat .= substr($snip['snip'],0,200);
            $txt_chat .= "<br/>";
        }
        if ($snip['class'] == 'place') {
            $place_chat .= "<span class=\"search_nm\">{$snip['type']}:</span> {$snip['snip']} ";
        }
        if ($snip['class'] == 'span') {
            $place_chat .= "<span class=\"search_nm\">{$snip['type']}:</span> {$snip['snip']} ";
        }
    }
    // finish the snippets cleanly
    $attribute_chat .= '</p>';
    $place_chat .= '</p>';
    $txt_chat .= '</p>';
    $action_chat .= '</p>';
    // clean out irrelevant stuff
    if ($attribute_chat == '<p class="search_chat"></p>') {
        $attribute_chat = '';
    }
    if ($place_chat == '<p class="search_chat"></p>') {
        $place_chat = '';
    }
    if ($txt_chat == '<p class="search_chat"></p>') {
        $txt_chat = '';
    }
    if ($action_chat == '<p class="search_chat"></p>') {
        $action_chat = '';
    }
    // finish it all into a single string
    $chat = $txt_chat.$attribute_chat.$action_chat.$place_chat;
    // return
    return ($chat);
}

// }}}
// {{{ mkJsDD()
/**
 * 
 * makes a dropdown for a given field
 * 
 * @param array $field
 *
*/

function mkTablekitAttributeDD($field){
    //start the editor
    $js="TableKit.Editable.addCellEditor(";
    
    $js.="new TableKit.Editable.CellEditor('".$field['field_id']."', {";
    $js.="    element : 'select',";
    // Use field id for form name
    $js.="     attributes : {name : '".$field['field_id']."', title : '".$field['field_id']."'},";
    $js.="     selectOptions : [";
    $attrs=ddAttr("select", "0", $field['classtype'],"array");
    // an option for clearing the cell-instead of a delete button drawn in the cell
    $js.="['clear','delfrag'],";
    foreach ($attrs as $attr){
        $js.=",['".addslashes($attr['name'])."','".$attr['value']."']";
    }

    $js.="] })    );";
    
    return $js;

}   

// }}}
// {{{ mkHelpTray()
/**
 *
 * Creates the help tray for inculding on subforms 
 *
 * @param string the config array of the subform to make help for
 * @return string $return the html for the helptray
 * @author Michael Johnson
 * @since v1.2
 * 
 * Takes an sf conf and loops over the fields
 * if there is a help markup then it creates html output to include on the page 
 * 
 */
function mkHelpTray($sf_conf){
	
	global $lang, $mod_short, $sf_val;
	
	if (array_key_exists('op_modtype', $sf_conf)) {
		$modtype = $sf_conf['op_modtype'];
	} else {
		$modtype = FALSE;
	}
	
	// If modtype is FALSE the fields will only come from one list , if TRUE the
	// fields will come from different field lists.
	if (chkModType($mod_short) && $modtype) {
		$modtype = getModType($mod_short, $sf_val);
		$fields = $sf_conf["type{$modtype}_fields"];
	} else {
		$fields = $sf_conf['fields'];
	}
	
	$mk_nohelp = getMarkup('cor_tbl_markup', $lang, 'nohelp');
    
	$title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
    $helptray = "<div id={$sf_conf['sf_html_id']}_help class=\"inlinehelp\">
          <h3>$title help</h3>";

    $mk_sfhelp = getMarkup('cor_tbl_markup', $lang, 'help_' .  $sf_conf['sf_html_id'], true);
    if ($mk_sfhelp){
    	$mk_sfhelp = getMarkup('cor_tbl_markup', $lang, 'help_' .  $sf_conf['sf_html_id']);
    	$helptray .= "<p>$mk_sfhelp</p>";
    } else {
    	$helptray .= "<p>$mk_nohelp</p>";
    }
	if (! array_key_exists ( 'op_no_field_help', $sf_conf)) {
		$fields = resTblTh ( $fields, 'silent' );
		foreach ( $fields as $field_key => $field ) {
			if (! array_key_exists ( 'op_help_markup', $field )) {
				$help_text = getMarkup ( 'cor_tbl_markup', $lang, 'help_' . $field ['field_id'], true );
			} else {
				$help_text = getMarkup ( 'cor_tbl_markup', $lang, $field ['op_help_markup'], true );
			}
			if (! $help_text) {
				$help_text = $mk_nohelp;
			} else {
				$help_text = getMarkup ( 'cor_tbl_markup', $lang, 'help_' . $field ['field_id'] );
			}
			$helptray .= "<h4>{$field['field_alias']} help</h4>";
			$helptray .= "<p> $help_text </p>";
		}
	}
    $helptray .= "<a href=\"help.php\" class=\"morehelp\">Learn More in Help</a></p>
        </div>";
        
	return $helptray;
}	
	

// }}}
// {{{ mkJavaScriptSource()
/**
 * 
 * Creates Javascript Includes for inclusion on main pages
 * 
* @param string $page the $pg_settings[name] of the page requesting javascript
* @return string $return a string of html script objects
* @author Michael Johnson
* @since v1.2
 */

function mkJavaScriptSource($page){
    
    global $ark_root_path, $ark_lib_path;
    $return = "";
    
    // Helper function for adding ark dir to path
    function wrap($path){
        
        $open = '<script type="text/javascript" src="';
        $close= '"></script>';
        return $open.$path.$close;
        
    }

    $paths = array (
                    $ark_lib_path.'/js/jquery-ui.js',
                    $ark_lib_path.'/js/jquery.colorbox.js',
                    $ark_lib_path.'/js/php.js',
                    $ark_root_path.'/js/js_functions.js',
                    $ark_root_path.'/js/livesearch.js',
                    $ark_root_path.'/js/common.js',
    );
    switch ($page){
        case ('Map View'):
        case ('Map Admin'):
            $paths [] = $ark_lib_path.'/js/ol3/ol.js';
            $paths [] = $ark_root_path.'/js/map_functions.js';
            break;
        case ('Data Entry'):
            break;
        case ('Data View'):
        case ('Record View'):
            $paths [] = $ark_lib_path.'/js/ol3/ol.js';
            $paths [] = $ark_root_path.'/js/mulit_edit.js';
            break;
        default :
            break;
    }
    foreach ($paths as $path){
        $return .= wrap($path);
    }
    
    return $return;
    
}

// }}}
// {{{ mkJsVars()

/**
* makes a chunk of javascript that sets ARK PHP vars as global scope JS variables
*
* @param array $vars  an array containing the vars (name => value)
* @param string $json_name  the name of the array to be referenced in the JS
* @return string $var  a string of html containing the javascript
* @author Guy Hunt
* @since v1.1
*
*/

function mkJsVars($vars, $json_name)
{
    if (!is_array($vars) OR empty($vars)) {
        return FALSE;
    }
    $var = "\n<script>\n";
    $var .= "var $json_name = ".json_encode($vars);
    //foreach ($vars as $name => $value) {
    //    $var .= "    var $name = \"$value\";\n";
    //}
    $var .= "</script>\n";
    // return
    return $var;
}

// }}}
// {{{ mkLeftPanelLink()

/**
* takes the left panel array from the settings file and creates a link
*
* @param array $left_panel the left panel array from the settings file 
* @return $var string  the left panel link
* @author Henriette Roued
* @since v0.6
*
* Significantly rewritten at v0.9 by GH 22/2/2011
*
*
*/

function mkLeftPanelLink($link, $linktype)
{
    global $lang, $skin_path;
    // pre-flight checks
    if (!array_key_exists('css_class', $link)) {
        echo "ADMIN ERROR: as of v1.0 left panel links require parameter 'css_class' (use FALSE if not required)";
        return FALSE;
    }
    if (!array_key_exists('lightbox', $link)) {
        echo "ADMIN ERROR: as of v1.0 left panel links require parameter 'lightbox' (use FALSE if not required)";
        return FALSE;
    }
    // markup
    $mk = getMarkup('cor_tbl_markup', $lang, $link['mknname']);
    // set css class if required
    if ($link['css_class']) {
        $css_class = " class=\"{$link['css_class']}";
    } else {
        $css_class = FALSE;
    }
    // set light box if required
    if (reqQst($link,'lightbox')) {
        $css_class .= " colorbox\"";
        $lightbox = "";
    } else {
        $lightbox = FALSE;
        $css_class .= "\"";
    }
    // If the linktype is image, put in an icon-based link
    if ($linktype == 'icon') {
        $lp_href = $link['href'];
        $lp_icon = $link['img'];
        $img = "<img src=\"{$skin_path}/images/plusminus/$lp_icon\" alt=\"$mk\" class=\"med\" />";
        $var = '<li><label>';
        $var .= $mk;
        $var .= '</label>';
        $var .= "<a href=\"$lp_href\" $lightbox $css_class >";
        $var .= $img;
        $var .= '</a></li>';
    } else {
        // We will use a text-based link as default
        $lp_href = $link['href'];
        $var = "<li><h4><a href=\"$lp_href\" $lightbox $css_class >";
        $var .= $mk;
        $var .= '</a></h4></li>';
    }
    return $var;
}

// }}}
// {{{ mkMinimiser()

/**
* makes a minimiser for data entry in left panel
*
* @param array $mod_short the short mod identifier
* @return $var string  the XHTML nav
* @author Andy Dufton
* @since v0.8
*
* DEV NOTE: this will only work on the data_entry page at present. This is
* because the function relies of globalling a var called $col which is only
* found on the data entry page. This could easily be adapted to be passed
* the column of SFs to minimise.
*
*/

function mkMinimiser($mod_short)
{
    global $lang, $view, $item_key, $$item_key, $col, $cur_max, $skin_path;
        if ($view == 'detfrm' && $$item_key) {
            $var = "<ul class=\"sf_minimiser\">\n";
            foreach ($col['subforms'] as $id => $sf) {
                // this needs to evaluate whether or not we have any condition set on the sfs
                // first check if the forms have conditions
                if (array_key_exists('op_condition', $sf)) {
                    //evaluate the condition
                     if (chkSfCond($item_key, $$item_key, $sf['op_condition'])) {
                         $eval_conditions = TRUE;
                     } else {
                         $eval_conditions = FALSE;
                     }
                } else {
                    $eval_conditions = TRUE;
                }
                if (!$cur_max) {
                        $cur_max = '0';
                }
                if ($sf['sf_nav_type'] != 'none' && $eval_conditions) {
                    $title = getMarkup('cor_tbl_markup', $lang, $sf['sf_title']);
                    if (isset($cur_max) && $cur_max == $id) {
                        $class = 'cur_max';
                    } else {
                        $class = 'min';
                    }
                    $var .= "<li class=\"$class\">";
                    $var .= "<a href=\"{$_SERVER['PHP_SELF']}?";
                    $var .= "item_key=$item_key&amp;$item_key={$$item_key}";
                    $var .= "&amp;sf_id=$id&amp;nav_min=1\">";
                    $var .= "$title";
                    $var .= "</a></li>\n";
                }
                unset($class);
            }
            $var .= "</ul>\n";
            // return the code
            return ($var);
        }
}

// }}}
// {{{ mkModItem()

/**
* makes a module item with links for data entry or viewing (for left panel)
*
* @param array $mod_short the short mod identifier
* @param array $ark_page the ark page containing the subform
* @return $var string  the XHTML nav
* @author Andy Dufton
* @since v0.8
*
*/

function mkModItem($mod_short, $ark_page)
{
    global $lang, $view, $item_key, $$item_key, $col, $cur_max, $skin_path, $record_admin_grps;
    // Pull the module specific settings
    $module = 'mod_'.$mod_short;
    $modkey = $mod_short.'_cd';
    $mod_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $modkey, 1);
    $mod_id = getSingle('id', 'cor_tbl_module', "itemkey = '$modkey'");
    // ---- OUTPUT ---- //
    // assemble the code for output
    $var = "<li>\n";
    // Process the case by case behaviour
    switch ($ark_page) {
        case 'data_entry':
            // Add a label for the module (not a link in data entry)
            $var .= "<label>{$mod_alias}</label>\n";
            // Add an icon for register link
            $img = "<img src=\"$skin_path/images/plusminus/bigplus.png\" title=\"{$mod_alias} Register\" class=\"med\" />";
            $var .= "<a href=\"{$_SERVER['PHP_SELF']}?view=regist&amp;item_key={$mod_short}&#95;cd\">";
            $var .= $img;
            $var .= "</a>";
            break;
        case 'micro_view':
            $img = "<img src=\"$skin_path/images/plusminus/view.png\" title=\"View a {$mod_alias}\" class=\"med\" />";
            $var .= "<label>{$mod_alias}</label>\n";    
            $var .= "<a href=\"{$_SERVER['PHP_SELF']}?item_key={$mod_short}&#95;cd\">";        
            $var .= $img;
            $var .= "</a>";
            break;
        case 'user_home':
            $var .= "<label>{$mod_alias}</label>\n";
            // check if user has access to data_entry.php
            if(array_intersect($record_admin_grps, $_SESSION['sgrp_arr'])){  
                // Add an icon for register link
                $img = "<img src=\"$skin_path/images/plusminus/bigplus.png\" title=\"{$mod_alias} Register\" class=\"med\" />";
                $var .= "<a href=\"data_entry.php?view=regist&amp;item_key={$mod_short}&#95;cd\">";
                $var .= $img;
                $var .= "</a>";
            }
            // Add an icon for a record view
            $img = "<img src=\"$skin_path/images/plusminus/view.png\" title=\"View a {$mod_alias}\" class=\"med\" />";            
            $var .= "<a href=\"micro_view.php?item_key={$mod_short}&#95;cd\">";        
            $var .= $img;
            $var .= "</a>";
            // Add a link to a filter for all items of this type
            $img = "<img src=\"$skin_path/images/plusminus/view_mag.png\" title=\"Search {$mod_alias}s\" class=\"med\" />";
            $var .= "<a href=\"data_view.php?ftype=key&amp;key={$mod_id}&amp;ktype=all&amp;ftr_mode=standard&amp;ftr_id=new\">";    
            $var .= $img;
            $var .= "</a>";
            break;    
    }
    // close out the item
    $var .= "</li>\n";
    // return the code
    return ($var);
}

// }}}
// {{{ mkMultiResultActionNav()

/**
* makes an XHTML string of actions that can be applied to multiple records
*
* @param array $left_panel the left panel array from the settings file 
* @return $var string  the left panel link
* @author Guy Hunt
* @since v0.8
*
*
*/

function mkMultiResultActionNav()
{
    global $lang;
    $mk_multiactions = getMarkup('cor_tbl_markup', $lang, 'multiactions');
    $var = "<div id=\"multi_action_toolbar\">\n";
    $var .= "<ul>\n";
    $res = "results_mode=dl";    
    $var .= "<li><a href=\"{$_SERVER['PHP_SELF']}?$res&amp;dl_mode=csv\">group</a></li>\n";
    $var .= "<li><a href=\"{$_SERVER['PHP_SELF']}?$res&amp;dl_mode=xml\">delete</a></li>\n";
    $var .= "</ul>\n";
    $var .= "</div>\n";
    return $var;
    
}

// }}}
// {{{ mkMvTabNav()

/**
* makes up the Micro View Tab Nav
*
* @param array $cols  an ARK standard columns package
* @return return_var_type return_var_name  return_var_description
* @author Guy Hunt
* @since v1.1
*
* This function generates the navigation bar at the top of tabbed columns in
* the micro_view page (could be used elsewhere).
*
*/

function mkMvTabNav($cols)
{
    global $lang, $item_key, $$item_key, $curcol;
    // set up a return var
    $nav = FALSE;
    // loop over each column
    foreach($cols as $col_key => $col) {
        // set up the col_id
        $col_id = $col['col_id'];
        // set a flag for the active tab
        if ($col_id == $curcol) {
            $active = " class=\"active\" ";
        } else {
            $active = FALSE;
        }
        // handle each different col type
        switch ($col['col_type']) {
            case 'link':
                // look to see if this is link outside this domain
                if (preg_match('/http\:/', $col['href'])) {
                    $link = $col['href'];
                } else {
                    $link = $col['href']."&amp;$item_key={$$item_key}";
                }
                // look to see if lightbox needs to be used
                if (preg_match('/overlay_holder.php/', $link)) {
                    $overlay = ' rel="lightbox"';
                } else {
                    $overlay = FALSE;
                }
                $nav .= "<li><a href=\"{$link}\"$overlay>";
                $nav .= "{$col['tab_text']}</a></li>\n";
                break;
                
            default:
                $sf_key = $col['col_sf_key'];
                $sf_val = $col['col_sf_val'];
                // output
                $nav .= "<li{$active}><a href=\"{$_SERVER['PHP_SELF']}";
                $nav .= "?{$item_key}={$$item_key}";
                $nav .= "&amp;curcol={$col_id}\">";
                $nav .= "{$col['tab_text']}</a></li>\n";
                break;
        }
    }
    // return
    return $nav;
}

// }}}
// {{{ mkNavItem()

/**
* makes an itemvalue jumper
*
* @param string $mode  sets output to be a dd or an input type text (options, plain, dd, or live)
* @param string $button  markup nickname of the button text
* @param string $item_key  the item key
* @param string $default  whatever you want in the box
* @param string $link  if not linking to same page you can add another page to link to here. 
* @return string $nav  a fully resolved XHTML string
* @author Guy Hunt
* @author Henriette Roued Olsen
* @author Stuart Eve
* @author Andy Dufton
* @since 0.6
*
* NOTE: This has been available as a script (inc_itemkey_nav.php) since at least
* version 0.2. The original script was intended to do more that just present a
* navigation tool, it was supposed to handle the request of the itemvalue and also
* set up errors if this was missing. For this reason, calls to this function may
* need to be wrapped correctly in order to not break expected behaviour further down
* the parse order.
*
* NOTE 2: The legacy use of inc_itemkey_nav.php discussed above is deprecated as of
* v1.1. I haven't deleted the Note so that history can be preserved.
*
*/

function mkNavItem($mode, $button, $item_key, $default, $link=FALSE, $mod_label=TRUE)
{
    global $lang, $item_val;
    $mod_short = substr($item_key, 0, 3);
    $table = $mod_short . '_tbl_' . $mod_short;
    $order=$mod_short.'_no';
    $alias =
        getAlias(
            'cor_tbl_module',
            $lang,
            'itemkey',
            $item_key,
            1
    );
    // Setup up the search params for each mode
    switch ($mode) {
        case 'live': // Live Ajax search
            $search = "
                <input name=\"$item_key\" value=\"{$default}\" type=\"text\" id=\"item\" onkeyup='liveSearch(this.value, \"$table\", \"$order\", \"$item_key\")'/>\n
                <button type=\"submit\">$button</button>
            ";
            if ($link) {
                $search = "
                    <input name=\"$item_key\" value=\"{$default}\" type=\"text\" id=\"item\" onkeyup='liveSearch(this.value, \"$table\", \"$order\", \"$item_key\", \"$link\")'/>\n
                    <button type=\"submit\">$button</button>
                ";
            }
            break;
            
        case 'plain': // Plain search
            $search = "
                <input type=\"text\" name=\"$item_key\" value=\"{$default}\" />\n
                <button type=\"submit\">$button</button>
            ";
            break;
            
        case 'dd': // Drop down menu
            $search =
                ddItemval(
                    $item_val,
                    $item_val,
                    $item_key
            ).'<button type="submit">'.$button.'</button>';
            break;
        
        default: // Plain search
            $search = "
                <input type=\"text\" name=\"$item_key\" value=\"{$default}\" />\n
                <button type=\"submit\">$button</button>";
            break;
    }
    
    // ---- OUTPUT ---- //
    // assemble the code for output
    $nav = "<div id=\"itemval_jumper\">\n";
    // link may be used to change destination of the action
    if (!$link) {
        $nav .="<form method=\"get\" id=\"select_itemval\" action=\"{$_SERVER['PHP_SELF']}\">\n";
    } else {
        $nav .="<form method = \"get\" id=\"select_itemval\" action=\"$link\">\n";
    }
    // put in fieldset
    $nav .= "<fieldset>\n";
    // add module label unless otherwise set
    if ($mod_label) {
        $nav .= "<label>{$alias}</label>";
    }
    // put in the search code defined above
    $nav .= "$search\n";
    // in the case of mode=live, an additional div is needed
    if ($mode == "live") {
      $nav .= "<div id=\"hints\"><span id=\"txtHint\"></span></div>";
    }
    // hidden vars
    $nav .= "<input type=\"hidden\" name=\"item_key\" value=\"$item_key\" />";
    // close out the form and container div
    $nav .= "</fieldset></form></div>\n";
    // return the code
    return ($nav);
}

// }}}
// {{{ mkNavMain()

/**
* makes up ARK main navigation bar
*
* @param array $pages  information about the pages
* @param array $links  information about static links
* @param boolean $force_active a way to ensure forcing an active tab
* @return string $nav  a resolved xhtml string
* @author Guy Hunt
* @since 0.6
*
* NOTE 1: this function existed in script form as inc_main_nav.php since 0.1
*
* NOTE 2: this function makes up the nav bar from two arrays. The first is an array
* of pages that are authorised for this viewer. The second is a array of links
* configured by the admin and held in the settings file
*
* NOTE 3: the info arrays will be outputted in the order pages -> links. The arrays
* should be in the format array('file' => X, 'vars' => X, 'label' => X)
*
* NOTE 4: the pages array is generally created by inc_auth
*
* NOTE 5: it is possible to send this function a modified array in order to create tabs
* in other places (e.g subforms in overlays) - however you may need to use the force_active
* flag to tell the function that you want to force the active tab via the use of 'is_active' 
* in the page array
*
* FIX ME: this needs a better means of selecting the active page
*
*/

function mkNavMain($pages, $links=FALSE, $force_active=FALSE)
{
    global $ark_root_path, $lang;
    $vars = FALSE;
    // Start list
    $nav = "<ul id=\"navlist\">\n";
    // Loop over the pages
    if ($pages) {
        foreach ($pages as $page) {
            $active = FALSE;
            //check to see if the active tab has been set in the pages array
            if ($force_active == TRUE) {
                if (array_key_exists('active', $page)) {
                    $active = ' id="active"';
                } else {
                    $active = FALSE;
                }
            }
            $link = $page['file']; 
            if ($page['is_visible']) {
                $vars = $page['navlinkvars'];
                $label = getMarkup('cor_tbl_markup', $lang, $page['navname']);
                //if we are not forcing a tab then fallback on the filename
                if (($_SERVER['PHP_SELF']) == $ark_root_path.$link && $force_active == FALSE) {
                    $active = ' id="active"';
                }
                $nav .= "<li$active>";
                $nav .= "<a href=\"$ark_root_path$link$vars\">$label</a>";
                $nav .= "</li>\n";
                unset($active, $vars, $label);
            }
            unset ($link);
        }
    }
    // Loop over any extra links
    if ($links) {
        foreach ($links as $link) {
            $link = $links['file'];
            $vars = $links['vars'];
            $label = $links['label'];
        }
        $nav .= "<li><a href=\"$ark_root_path{$link}?{$vars}\">$label</a></li>\n";
    }
    // Close the list
    $nav .= "</ul>";
    // Return
    return $nav;
}

// }}}
// {{{ mkNavPage()

/**
* makes out a navigation tool for paged results
*
* @param string $page  the current page
* @param string $num_pages  the total number of pages
* @param string $perpage  the number of results to display per page
* @param string $conf_num_res_pgs  the number of pages to show at once (settings.php)
* @param string $total_results  the total number of results
* @return void
* @author Stuart Eve
* @since 0.3
*
* NOTE: Since 0.6 this function is renamed mkNavPage() from printPagingNav(). It
* also now returns a resolved XHTML string and does not print to screen
*
* As of v0.8 this has had a major rewrite. The number of params has now changed this
* will likely break older code GH 22/12/2010
*
* The v0.8 behavoir is as follows:
* 
* The list of pages is limited to an admin defined number = n. In the case of overflows,
* the user will be offered chevrons to move through the pages by 1 page or a whole block
* of n pages.
*
* While the user is on pages from 1 to n/2, the list is static. On pages above n/2, the 
* current page is always held at the centre of the list.
*
* Up and down arrows are displayed at either end of the list as needed
*
*/

function mkNavPage($page, $num_pages, $perpage, $conf_num_res_pgs, $total_results)
{
    global $lang, $form_method;
    // labels etc
    $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
    $mk_num_pages = getMarkup('cor_tbl_markup', $lang, 'num_pages');
    $mk_totalpages = getMarkup('cor_tbl_markup', $lang, 'totalpages');
    $mk_totalres = getMarkup('cor_tbl_markup', $lang, 'totalres');
    $mk_infinity = getMarkup('cor_tbl_markup', $lang, 'infinity');
    
    // find out if there are surplus pages
    if ($num_pages >= $conf_num_res_pgs) {
        // DYNAMIC LIST
        // find out what the middle page is
        $mid_pg = round($conf_num_res_pgs/2);
        // FIRST PAGE
        // set up the first page and start chevrons
        if ($page <= $mid_pg) {
            // the page num is less than the mid point - at the start
            // no start chevrons are needed
            $i = 1;
            $last_pg = $conf_num_res_pgs;
            $start_chv = FALSE;
        } else {
            // the page num is more than the mid point - in the middle part
            // start the pages off at the right number
            $i = $page - $mid_pg + 1;
            // end the pages at the right number
            $last_pg = $i + $conf_num_res_pgs - 1;
            $start_chv = TRUE;
        }
        // LAST PAGE
        // check to see if the last page is visible
        // if so, end chevrons aren't needed and the start page is restricted
        if ($last_pg >= $num_pages) {
            $last_pg = $num_pages;
            $i = $last_pg - $conf_num_res_pgs + 1;
            $end_chv = FALSE;
        } else {
            $end_chv = TRUE;
        }
    } else {
        // STATIC LIST
        // there are less pages of results than the configged max pages
        // no chevrons needed as all pages on display all the time
        $i = 1;
        $last_pg = $num_pages;
        $start_chv = FALSE;
        $end_chv = FALSE;
    }
    
    // setup the xhtml the var
    $var = "<div id=\"paging_nav\">\n";
    $var .= "<ul class=\"pag_list\">\n";
    // put in the start chevrons if needed
    if ($start_chv) {
        $chv = 1;
        $var .= "<li class=\"pag_list\"><a href=\"{$_SERVER['PHP_SELF']}?page=$chv\">&laquo;</a></li>\n";
        $chv = $page - 1;
        $var .= "<li class=\"pag_list\"><a href=\"{$_SERVER['PHP_SELF']}?page=$chv\">&lsaquo;</a></li>\n";
    }
    //loop through the pages adding links
    do {
        if ($i == $page) {
            $var .= "<li class=\"cur_pag\"><a href=\"{$_SERVER['PHP_SELF']}?page=$i\">$i</a></li>\n";
        } else {
            $var .= "<li class=\"pag_list\"><a href=\"{$_SERVER['PHP_SELF']}?page=$i\">$i</a></li>\n";
        }
        $i++;
    } while($i <= $last_pg);
    // put in the end chevrons
    if ($end_chv) {
        $chv = $page + 1;
        $var .= "<li class=\"pag_list\"><a href=\"{$_SERVER['PHP_SELF']}?page=$chv\">&rsaquo;</a></li>\n";
        $chv = $num_pages;
        $var .= "<li class=\"pag_list\"><a href=\"{$_SERVER['PHP_SELF']}?page=$chv\">&raquo;</a></li>\n";
    }
    // cleanly close out the list
    $var .= "</ul>\n";
    
    // put in some feedback on the size of the results set
    $var .= "<span class=\"info\">{$mk_totalpages}&nbsp;$num_pages</span>";
    
    // if the perpage is set to infinity... dont display the above stuff (start again)
    if ($perpage == 'inf') {
        $var = "<div id=\"paging_nav\">\n";
    }
    
    // put in some feedback on the size of the results set
    $var .= "<span class=\"info\">{$mk_totalres}&nbsp;$total_results</span>";
    
    // infinity
    $inf = FALSE;
    if ($perpage != 'inf') {
        $inf .= "<form method=\"$form_method\" id=\"perpage_inf\" action=\"{$_SERVER['PHP_SELF']}\">\n";
        $inf .= "<fieldset>\n";
        $inf .= "<input type=\"hidden\" name=\"perpage\" value=\"inf\" />\n";
        $inf .= "<button type=\"submit\">$mk_infinity</button>\n";
        $inf .= "</fieldset>\n";
        $inf .= "</form>\n";
    }
    $var .= $inf;
    
    // put in the selector to choose rows per page
    $var .= mkNavRows($perpage, $mk_num_pages, $mk_go);
    // close out the nav
    $var .= "</div>";
    // Return the var
    return $var;
}

// }}}
// {{{ mkNavRows()

/**
* makes a navigation box to select the number of rows per page in paged result sets
*
* @param
* @return void
* @author Guy Hunt
* @since 0.6
*
* This has been available as a script (inc_pagination_nav.php) from 0.3 to 0.6
*
* Since 0.8 this has had an option to handle 'infinite' pages... ie remove pagination
*
*/

function mkNavRows($perpage, $label, $go)
{
    global $form_method;
    if ($perpage == 'inf') {
        $perpage = FALSE;
    }
    $var = FALSE;
    $var .= "<form method=\"$form_method\" id=\"perpage_selector\" action=\"{$_SERVER['PHP_SELF']}\">\n";
    $var .= "<fieldset>\n";
    $var .= "<label for=\"perpage\">$label</label>\n";
    $var .= "<input type=\"text\" name=\"perpage\" value=\"$perpage\" class=\"perpage\" />\n";
    $var .= "<button type=\"submit\">$go</button>\n";
    $var .= "</fieldset>\n";
    $var .= "</form>\n";
    // return the string
    return ($var);
}

// }}}
// {{{ mkprtRecordNav
/**
* makes print nav to be printed in the record panel
*
* @param array $conf the entry nav configuration from settings.php 
* @param array $rec_page the page including the nav (micro view, data entry) 
* @param array $current_view the current page view (egs. register, detfrm, materi)
* @return $var string  the XHTML nav
* @author Jess Ogden
* @since v0.8
*
* Note: the toolbar is made up of blocks of tools. The toolbar is setup with an array
* this array contains arrays. Each of these tool group arrays contains elements. Each
* element is an array.
*
*/

function mkprtRecordNav($conf, $rec_page, $current_view)
{
    global $lang, $item_key, $$item_key, $_SESSION, $conf_br, $mod_short, $mode;
    if (!$conf or !is_array($conf)) {
        echo "ADMIN ERROR: The config for the data entry toolbar is not correctly setup";
    }
    // Get the module alias
    $mod_alias =
        getAlias(
            'cor_tbl_module',
            $lang,
            'itemkey',
            $item_key,
            1
        );
    // Split site code item number for display purposes
    if ($$item_key) {
        $rec_xpl = explode('_',$$item_key);
        $rec_ste_cd = $rec_xpl[0];
        $item_num = $rec_xpl[1];        
    } else {
        $rec_ste_cd = FALSE;
        $item_num = FALSE;
    }
    // Determine if the module is using modtypes
    // put fancy brackets on items, but only if the item is using modtypes
    if (isset($conf_br) && chkModtype($mod_short)) {
        $this_rec = modBr($item_key, $$item_key, $conf_br);
    } else {
        $this_rec = $item_num;
    }
    // Check if modtype exists and get alias
    if (chkModtype($mod_short)) {
        $modtype = getModType($mod_short, $$item_key);
        if ($modtype) {
            $modtype_alias = getAlias($mod_short.'_lut_'.$mod_short.'type', $lang, 'id', $modtype, 1);            
        } else {
            $modtype_alias = FALSE;
        }
    } else {
        $modtype_alias = FALSE;
    }
    // start the record navigation toolbar
    $var = FALSE;
    $var .= "<div id=\"record_nav\" class=\"printall\">\n";
    $var .= "<label>{$mod_alias}</label>\n";
    //start the toolbar
        if ($$item_key) {
        foreach ($conf as $key => $group) {
            // put in the start and finish blocks for this tool group
            $var .= "<ul id=\"{$key}\">\n";
            // loop over each element in this group
            foreach ($group as $key => $button) {
                // set markup if required
                if ($button['mkname']) {
                    $mk_text = getMarkup('cor_tbl_markup', $lang, $button['mkname']);
                } else {
                    $mk_text = FALSE;
                }
                // set css class if required
                if ($button['css_class']) {
                    $css_class = " class=\"{$button['css_class']}";
                } else {
                    $css_class = FALSE;
                }
                // set light box if required
                if (reqQst( $button, 'lightbox' )) {
                    $css_class .= " colorbox\"";
                    $lightbox = "";
                } else {
                    $lightbox = FALSE;
                    $css_class .= "\"";
                }
                // Change behaviour depending on link type
                switch ($button['name']) {
                    case 'current':
                        $var .= "<li class=\"current\">$this_rec</li>\n"; 
                        break;
                    case 'ste_cd':
                        $var .= "<li class=\"current\">$rec_ste_cd</li>\n"; 
                        break;
                    case 'modtype':
                    if ($modtype_alias) {
                        $var .= "<li class=\"current\">$modtype_alias</li>\n"; 
                    }
                        break;
                }
            }
            // end the group
            $var .= "</ul>\n";
        }
        }    
    $var .= "</div>\n";
    // return the var
    return $var;
}

// }}}
// {{{ mkRecordNav()

/**
* makes a nav used in the record panel
*
* @param array $conf  the entry nav configuration from settings.php 
* @param array $rec_page  the page including the nav (micro view, data entry) 
* @param array $current_view  the current page view (egs. register, detfrm, materi)
* @param string $item_key  an item_key
* @param string $$item_key  an item_val
* @return $var string  the XHTML nav
* @author Andy Dufton
* @since v0.8
*
* Note: the toolbar is made up of blocks of tools. The toolbar is setup with an array
* this array contains arrays. Each of these tool group arrays contains elements. Each
* element is an array.
*
* Note 1: As of v1.1 you can optionally send this an item_key item_val used for example
* on embedded records.
*
*/

function mkRecordNav($conf, $rec_page, $current_view, $item_key=FALSE, $item_val=FALSE)
{
    global $lang, $_SESSION, $authitems, $conf_br, $mod_short, $search_mode, $conf_micro_viewer, $ark_root_path, $record_admin_grps;
    if (!$item_key) {
        global $item_key, $$item_key;
        $item_val = $$item_key;
    }
    if (!$conf or !is_array($conf)) {
        echo "ADMIN ERROR: The config for the record toolbar is not correctly setup<br/>\n";
        echo "Documentation: http://ark.lparchaeology.com/wiki/index.php/Page_settings.php#Record_Toolbar<br/>";
    }
    // Get necessary markup
    $mk_register = getMarkup('cor_tbl_markup', $lang, 'regist');
    $mk_form = getMarkup('cor_tbl_markup', $lang, 'detfrm');
    $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
    $mk_delete = getMarkup('cor_tbl_markup', $lang, 'delete');
    $mk_chgtype = getMarkup('cor_tbl_markup', $lang, 'chgtype');
    $mk_chgkey = getMarkup('cor_tbl_markup', $lang, 'chgkey');
    $mk_file = getMarkup('cor_tbl_markup', $lang, 'files');
    $mk_viewbutton = getMarkup('cor_tbl_markup', $lang, 'viewbutton');
    $mk_help = getMarkup('cor_tbl_markup', $lang, 'help');
    // Get the module alias
    $mod_alias =
        getAlias(
            'cor_tbl_module',
            $lang,
            'itemkey',
            $item_key,
            1
        );
    // Set up variables in case we don't set them later
    $next_itemval = FALSE;
    $prev_itemval = FALSE;
    // Set up variables in case we don't set them later
    $next_itemval = FALSE;
    $prev_itemval = FALSE;
    // Set up navigation variables
    // Use the result set
    $item_loop = reqQst($_SESSION, 'results_array');
    if (is_array($item_loop) && $rec_page == 'micro_view') {
        //NEXT-PREV
        // Sort out the next and previous
        $key_of_item = $item_key.$item_val;
        // next
        arraySetCurrent($item_loop, $key_of_item);
        $next_itemval_arr = next($item_loop);
        $next_itemval = $next_itemval_arr['itemval'];
        $next_itemkey = $next_itemval_arr['itemkey'];
        // prev
        arraySetCurrent($item_loop, $key_of_item);
        $prev_itemval_arr = prev($item_loop);
        $prev_itemval = $prev_itemval_arr['itemval'];
        $prev_itemkey = $prev_itemval_arr['itemkey'];
    } else {
        // Use the authitems
        if(!is_array($authitems)){
            $authitems = array();
        }
        if (array_key_exists($item_key, $authitems)) {
            //NEXT-PREV
            // Sort out the next and previous
            $key_of_item = array_search($item_val, $authitems[$item_key]);
            // next
            arraySetCurrent($authitems[$item_key], $key_of_item);
            $next_itemval = next($authitems[$item_key]);
            // prev
            arraySetCurrent($authitems[$item_key], $key_of_item);
            $prev_itemval = prev($authitems[$item_key]);
        }
        // keys the same
        $next_itemkey = $item_key;
        $prev_itemkey = $item_key;
    }
    // Split site code item number for display purposes
    if ($item_val) {
        $rec_xpl = explode('_', $item_val);
        $rec_ste_cd = $rec_xpl[0];
        $item_num = $rec_xpl[1];        
    } else {
        $rec_ste_cd = FALSE;
        $item_num = FALSE;
    }
    // Determine if the module is using modtypes
    // put fancy brackets on items, but only if the item is using modtypes

    if (isset($conf_br) && chkModtype($mod_short)) {
        $this_rec = modBr($item_key, $item_val, $conf_br);
    } else {
        $this_rec = $item_num;
    }
    // Check if modtype exists and get alias
    if (chkModtype($mod_short)) {
        $modtype = getModType($mod_short, $item_val);
        if ($modtype) {
            $modtype_alias = getAlias($mod_short.'_lut_'.$mod_short.'type', $lang, 'id', $modtype, 1);            
        } else {
            $modtype_alias = FALSE;
        }
    } else {
        $modtype_alias = FALSE;
        $modtype = FALSE;
    }
    // Check the user permissions for admin tools
    $admin_int = array_intersect($record_admin_grps, $_SESSION['sgrp_arr']);
    if (!empty($admin_int)) {
       $is_record_admin = TRUE;
    } else {
       $is_record_admin = FALSE;
    }
    //check if jumper is on
    if (!array_key_exists('op_stecd_jumper', $conf)){
    	$op_jumper=true;
    } else {
    	$op_jumper=$conf['op_stecd_jumper'];
    }
    // start the record navigation toolbar
    $var = FALSE;
    $var .= "<div id=\"record_nav\" class=\"record_nav\">\n";
    // start the upper level data entry toolbar
    // this changes depending on the current entry view
    $var .= "<div id=\"record_upper\">\n";    
    switch ($current_view) {
        case 'regist':
            $var .= "<label>{$mk_register}{$mod_alias}</label>\n";
            if ( $op_jumper ) {
                $var .= "<div id=\"stecd_jumper\">\n";
                $var .= mkSteCdNav();
                $var .= "</div>\n";
                // Include tools to add new site codes
                // Only include this option if the user is a record admin
                if ($is_record_admin == TRUE) {
                    // start the separate tools ul
                    $var .= "<ul id=\"tools\">";
                    $regtools = "<a href=\"overlay_holder.php?";
                    $regtools .= "overlay=true&amp;";
                    $regtools .= "lboxreload=1&amp;";
                    $regtools .= "sf_conf=conf_mcd_newstecode\" rel=\"lightbox|200\"";
                    $regtools .= "class=\"gears\"";
                    $regtools .= "title=\"Admin Tools - Add Site Code\">";
                    // put in the tool
                    $var .= "<li>";
                    $var .= "$regtools";
                    $var .= "&nbsp;</a></li>\n";  
                    $var .= "</ul>";
                }
            }
            break;
        case 'detfrm':
            $var .= "<label>{$mod_alias}&nbsp;&#45;&nbsp;{$mk_form}</label>\n";
            if ($op_jumper) {
                $var .= "<div id=\"record_jumper\">\n";
                $link = $ark_root_path.'/data_entry.php';
                $var .= mkNavItem($search_mode, $mk_go, $item_key, '', $link, FALSE);
                $var .= "</div>\n";
            }
            break;
        case 'files':
            $var .= "<label>{$mk_file}</label>\n";
            break;
        case 'overlay':
            $var .= "<label>{$mod_alias}&nbsp;&#45;&nbsp;{$mk_register}</label>\n";
            $var .= "<div id=\"stecd_jumper\">\n";
            $var .= mkSteCdNav('overlay');
            $var .= "</div>\n";
            break;
        case 'micro_view':
            $var .= "<label>{$mod_alias}</label>\n";
            if ($op_jumper) {
                $var .= "<div id=\"record_jumper\">\n";
                $link = $ark_root_path.'/micro_view.php';
                $var .= mkNavItem($search_mode, $mk_go, $item_key, '', $link, FALSE);
                $var .= "</div>\n";
            }
            break;
        default:
            if ($op_jumper) {
                $var .= "<div id=\"record_jumper\">\n";
                $link = $ark_root_path.'/data_entry.php';
                $var .= mkNavItem($search_mode, $mk_go, $item_key, '', $link, $mod_alias);
                $var .= "</div>\n";
            }
            break;
    }
    //end the upper level data entry toolbar
    $var .= "</div>\n";
    //start the lower level data entry toolbar for the detfrm or micro view only
    if ($current_view == 'detfrm' OR $rec_page == 'micro_view') {
        if ($item_val) {
        $var .= "<div id=\"record_lower\">\n";
        foreach ($conf as $key => $group) {
            if (!is_array($group)){
                continue;
            }
            // put in the start and finish blocks for this tool group
            $var .= "<ul id=\"{$key}\">\n";
            // loop over each element in this group
            foreach ($group as $key => $button) {
                // set markup if required
                if ($button['mkname']) {
                    $mk_text = getMarkup('cor_tbl_markup', $lang, $button['mkname']);
                } else {
                    $mk_text = FALSE;
                }
                // set css class if required
                if ($button['css_class']) {
                    $css_class = " class=\"{$button['css_class']}";
                } else {
                    $css_class = FALSE;
                }
                // set title text if required
                if (array_key_exists('title', $button)) {
                        $title_mk = getMarkup('cor_tbl_markup', $lang, $button['title']);
                        $title = " title=\"{$title_mk}\"";
                } else {
                        $title_mk = FALSE;    
                        $title = FALSE;
                }
                // set light box if required
                if (reqQst( $button, 'lightbox' )) {
                    $css_class .= " colorbox\"";
                    $lightbox = "";
                } else {
                    $lightbox = FALSE;
                    $css_class .= "\"";
                }
               // set a reload page if required
                if (array_key_exists('reloadpage', $button)) {
                    $reloadpage = "{$button['reloadpage']}";
                } else {
                    $reloadpage = FALSE;
                }
                // Change behaviour depending on link type
                switch ($button['name']) {
                    case 'prev':
                    if ($prev_itemval) { 
                            $prev = dynLink('prev', $prev_itemkey, $prev_itemval);
                            $var .= "<li>$prev</li>\n";  
                        } 
                        break;
                    case 'current':
                        $var .= "<li class=\"current\">$this_rec</li>\n"; 
                        break;
                    case 'next':
                    if ($next_itemval) { 
                            $next = dynLink('next', $next_itemkey, $next_itemval);
                            $var .= "<li>$next</li>\n";  
                        }
                        break;
                    case 'ste_cd':
                        $var .= "<li class=\"current\">$rec_ste_cd</li>\n"; 
                        break;
                    case 'modtype':
                    if ($modtype_alias) {
                        $var .= "<li class=\"current\">$modtype_alias</li>\n"; 
                    }
                        break;
                    case 'refresh':
                    // decide if this is a text based icon or a graphic
                    if ($button['type'] == 'text') {
                        // put in the tool
                        $var .= "<li><a href=\"{$button['href']}&amp;item_key=$item_key&amp;$item_key={$item_val}\" {$css_class}{$lightbox}{$title}>$mk_text</a></li>\n";                
                        }
                        if ($button['type'] == 'img') {
                            // put in the tool
                            $var .= "<li>";
                            $var .= "<a href=\"{$button['href']}&amp;item_key=$item_key&amp;$item_key={$item_val}\" {$css_class}{$lightbox}{$title}\">";
                            $var .= "&nbsp;</a></li>\n";
                        }
                        break;
                    case 'tools':
                        // Only include this option if the user is a record admin
                        if ($is_record_admin == TRUE) {
                        // start the separate tools ul
                        $var .= "<ul id=\"tools\">";
                        // decide if this is a text based icon or a graphic
                        if ($button['type'] == 'text') {
                            // put in the tool
                                $var .= "<li><a href=\"{$button['href']}\"";
                                $var .= " {$css_class}{$lightbox}{$title}>";
                                $var .= "$mk_text</a></li>\n";                    
                            }
                            if ($button['type'] == 'img') {
                                // put in the tool
                                $var .= "<li>";
                                $var .= "<a href=\"{$button['href']}\" {$css_class}{$lightbox}{$title}\">";
                                $var .= "&nbsp;</a></li>\n";
                            }
                            $var .= "</ul>";
                        }
                        break;
                        
                    case 'delete':
                            // Only include this option if the user is a record admin
                            if ($is_record_admin == TRUE) {
                                $del = "<a href=\"overlay_holder.php?";
                                $del .= "overlay=true&amp;";
                                $del .= "delete_key={$item_key}&amp;";
                                $del .= "delete_val={$item_val}&amp;";
                                $del .= "lang=$lang&amp;";
                                $del .= "lboxreload=1&amp;";
                                $del .= "sf_conf=conf_mcd_deleterecord\" ";
                                // decide if this is a text based icon or a graphic
                                if ($button['type'] == 'text') {
                                    // put in the tool
                                    $del .= "{$css_class}";
                                    $del .= "{$title}>";
                                    $del .= "{$mk_delete}</a>";
                                    $var .= "<li>$del</li>\n";                 
                                }
                                if ($button['type'] == 'img') {
                                    // put in the tool
                                    $del .= "{$css_class}";
                                    $del .= "{$title}>";
                                    $var .= "<li>";
                                    $var .= "$del";
                                    $var .= "&nbsp;</a></li>\n";  
                                }
                            }
                        break;
                    case 'changemod':
                    // Only include this option if the user is a record admin
                    if ($is_record_admin == TRUE) {
                        // Only include this nav if the module is using types
                        if ($modtype) {
                            $chgmodtype = "<a href=\"overlay_holder.php?";
                            $chgmodtype .= "overlay=true&amp;";
                            $chgmodtype .= "item_key={$item_key}&amp;";
                            $chgmodtype .= "$item_key={$item_val}&amp;";
                            $chgmodtype .= "lang=$lang&amp;";
                            $chgmodtype .= "lboxreload=1&amp;";
                            $chgmodtype .= "sf_conf=conf_mcd_modtype\" rel=\"lightbox|200\"";
                            // decide if this is a text based icon or a graphic
                            if ($button['type'] == 'text') {
                                // put in the tool
                                $chgmodtype .= "{$css_class}";
                                $chgmodtype .= "{$title}>";
                                $chgmodtype .= "{$mk_chgtype}</a>";
                                $var .= "<li>$chgmodtype</li>\n";                 
                            }
                            if ($button['type'] == 'img') {
                                // put in the tool
                                $var .= "<li>$chgmodtype</li>\n";  
                            }
                        }
                    }
                        break;
                    case 'changeval':
                    // Only include this option if the user is a record admin
                    if ($is_record_admin == TRUE) {        
                    $chgitemval = "<a href=\"overlay_holder.php?";
                        $chgitemval .= "overlay=true&amp;";
                        $chgitemval .= "item_key={$item_key}&amp;";
                        $chgitemval .= "$item_key={$item_val}&amp;";
                        $chgitemval .= "lang=$lang&amp;";
                        $chgitemval .= "lboxreload=1&amp;";
                        $chgitemval .= "reloadpage=$reloadpage&amp;";
                        $chgitemval .= "sf_conf=conf_mcd_itemval\" rel=\"lightbox|200\"";
                        // decide if this is a text based icon or a graphic
                        if ($button['type'] == 'text') {
                             // put in the tool
                            $chgitemval .= "{$css_class}";
                            $chgitemval .= "{$title}>";
                            $chgitemval .= "{$mk_chgkey}</a>";                             
                            $var .= "<li>$chgitemval</li>\n";                 
                        }
                        if ($button['type'] == 'img') {
                            // put in the tool
                            $var .= "<li>$chgitemval</li>\n";  
                        }
                    }
                        break;
                    case 'help' :
                            // help button goes upper right if required
                            if (array_key_exists('op_help', $conf)) {
                                $helpbtn = "<a href=\"\"";
                                $helpbtn .= "{$css_class}";
                                $helpbtn .= "{$title}>";
                                if ($button['type'] == 'text') {
                                    $helpbtn .= $mk_help;
                                    $helpbtn .= "</a>";
                                }
                                if ($button['type'] == 'img') {
                                    // put in the tool
                                    $helpbtn .= "</a>";
                                }
                                $var .= "<li>$helpbtn</li>\n";
                            }
                            break;
                    case 'view' :
                        $viewbutton = "<a href=\"micro_view.php?";
                        $viewbutton .= "item_key={$item_key}&amp;";
                        $viewbutton .= "$item_key={$item_val}&amp;";
                        $viewbutton .= "\"";
                        $viewbutton .= "{$css_class}";
                        $viewbutton .= "{$title}>";
                        if ($button['type'] == 'text') {
                            $viewbutton .= $mk_viewbutton;
                            $viewbutton .= "</a>";
                        }
                        if ($button['type'] == 'img') {
                            $viewbutton .= "</a>";
                        }
                        $var .= "<li>$viewbutton</li>\n";
                        break;
                }
            }
            // end the group
            $var .= "</ul>\n";
        }
        $var .= "</div>\n";
        }
    }
    $var .= "</div>\n";
    // return the var
    return $var;
}

// }}}
// {{{ mkResMeta()

/**
* makes up the item meta for chat style output for searches
*
* @param array $item_meta  containing the meta to make into the chat
* @return string $meta  a resolved xhtml string
* @author Guy Hunt
* @since 0.6
*/

function mkResMeta($item_meta)
{
    // start the snippets cleanly
    $meta_chat = '<p class="meta_chat">';
    // loop over the snippets
    foreach ($item_meta as $key => $meta) {
        if (is_numeric($key)) {
            $meta_chat .= "<span class=\"alias\">{$meta['meta_alias']}:</span> {$meta['meta_val']} ";
            $meta_chat .= "<br/>";
        }
    }
    // finish the snippets cleanly
    $meta_chat .= '</p>';
    // return
    return ($meta_chat);
}

// }}}
// {{{ mkResultsAuto()

/**
* makes an XHTML table from a results array
*
* @param array $results_array  an ARK std results array
* @return $var string  the XHTML
* @author Mike Johnson
* @since v1.2
*
* Paging should be down outside this function
*
*/

function mkResultsAuto($results_array, $filters)
{
    global $lang, $skin_path;
    // handle sort order
    if (array_key_exists('sort_order', $filters)) {
        $sort_order = $filters['sort_order'];
        $sort_field = $sort_order['sort_field'];
        $sort_type = $sort_order['sort_type'];
    } else {
        $sort_order = FALSE;
        $sort_field = FALSE;
        $sort_type = FALSE;
    }
    // manual setup flags
    $prev_itemkey = 'false';
    $table_set = 'false';
    $var = "<div class=\"result_tbl\">\n";
    // Loop thru the results
    foreach ($results_array as $res_item) {
        // Decide whether to start a new table and put in a header row or not
        if ($res_item['itemkey'] != $prev_itemkey) {
            // We need a new table as we are on a new module
            
            // ---- MODULE SETUP ---- //
            // get a mod short
            $mod_short = substr($res_item['itemkey'], 0, 3);
            // get the 'conf_mac_table' array for this module
            $conf = reqModSetting($mod_short, 'conf_mac_table');
            // firstly establish the fields for this new module
            $fields = $conf['fields'];
            
            // ---- OUTPUT ---- //
            // if there was a previous table, end it cleanly
            if ($table_set == 'true') {
                $var .= "</table>\n";
            }
            // start a fresh table
            $var .= "<table class=\"result_tbl\">\n";
            // flag that a table was started
            $table_set = 'true';
            // process the fields array
            $fields = resTblTh($fields, 'silent');
            // make the header row
            foreach($fields as $field) {
                // DEV NOTE: config failsafe 
                if (!array_key_exists('field_id', $field)) {
                    $field['field_id'] = 'not_set';
                }
                // if this is the current field we are sorting on
                if ($field['field_id'] == $sort_field) {
                    // select the sort order icon
                    $sort_type = strtolower($sort_type);
                    if ($sort_type == 'desc' or $sort_type == 'dsc') {
                        $ico = "<a href=\"{$_SERVER['PHP_SELF']}?sort_type=asc\">";
                        $ico .= "<img src=\"$skin_path/images/results/asc.png\"";
                        $ico .= " class=\"sort\" alt=\"sort\" />";
                        $ico .= "</a>";
                    } elseif ($sort_type == 'asc') {
                        $ico = "<a href=\"{$_SERVER['PHP_SELF']}?sort_type=desc\">";
                        $ico .= "<img src=\"$skin_path/images/results/desc.png\" class=\"sort\" alt=\"sort\" />";
                        $ico .= "</a>";
                    }
                } else {
                    $ico = FALSE;
                }
                // make the val
                $th_val = $field['field_alias'];
                // print the header
                if ($ico) {
                    $var .= "<th>$ico$th_val</th>";
                } elseif ($field['field_id'] != 'not_set') {
                    $href = "{$_SERVER['PHP_SELF']}?sort_type=asc&amp;sort_field={$field['field_id']}";
                    $var .= "<th><a href=\"$href\">$th_val</a></th>";
                } else {
                    $var .= "<th>$th_val</th>";
                }
                
            }
            // print the first row as normal
            $var .= '<tr>';
            // loop thru the cols
            foreach($fields as $field) {
                // make the val
                $td_val = resTblTd($field, $res_item['itemkey'], $res_item['itemval']);
                // print the item
                $var .= "<td><span class=\"resplabel\">{$field['field_alias']}: </span>$td_val</td>";
            }
            // end the first row
            $var .= "</tr>\n";
        } else {
            // start normal row
            $var .= '<tr>';
            // loop thru the cols
            foreach($fields as $field) {
                // make an alias for the item
                $td_val = resTblTd($field, $res_item['itemkey'], $res_item['itemval']);
                // print the item
                $var .= "<td><span class=\"resplabel\">{$field['field_alias']}: </span>$td_val</td>";
            }
            // end normal row
            $var .= "</tr>\n";
        }
        // set up what the previous key was
        $prev_itemkey = $res_item['itemkey'];
    }
    // cleanly end the last table
    $var .= "</table>\n";
    // $var .= mkMultiResultActionNav(); //this will allow actions on multiple results
    $var .= "</div>\n";
    return($var);
}
// }}}
// {{{ mkResultsChat()

/**
* makes an XHTML string of results from a results array
*
* @param array $results_array  an ARK std results array
* @return $var string  the XHTML
* @author Guy Hunt
* @since v0.8
*
* As of v0.8 'chat' and text' display of results have diverged
* Chat is intended as a google style text search response.
*
*/

function mkResultsChat($results_array, $filters)
{
    global $lang, $conf_micro_viewer;
    // settings are needed to run fields properly inside this func
    include('config/settings.php');
    // markup
    $mk_score = getMarkup('cor_tbl_markup', $lang, 'score');
    $mk_viewmsg = getMarkup('cor_tbl_markup', $lang, 'viewmsg');
    // setup the var
    $var = FALSE;
    // Print the results as a paged list
    $var .= '<ul class="result_ul">';
    foreach ($results_array as $res_item) {
        // Get the mod settings for this mod
        $mod_short = $mod_short = substr($res_item['itemkey'], 0, 3);
        include('config/mod_'.$mod_short.'_settings.php');

        // ---- MODULE SETUP ---- //
        // get a mod short
        $mod_short = substr($res_item['itemkey'], 0, 3);
        // get the 'conf_mac_table' array for this module
        $conf = reqModSetting($mod_short, 'op_conf_mac_chat');
        // firstly establish the fields for this new module
        $fields = $conf['fields'];
        // make an alias for the item
        $item_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $res_item['itemkey'], 1);
        // allow an optional fancy text header
        if (isset($op_conf_mac_chat)) {
            $field = $op_conf_mac_chat['fields'][0];
            $curr = resFdCurr($field, $res_item['itemkey'], $res_item['itemval']);
            $text = $curr[0][$field['dataclass']];
        } else {
            $text = $res_item['itemval'];
        }
        // make the header bar
        $hdrbar = "<h5>$item_alias:&nbsp;";
        $hdrbar .= "<a href=\"$conf_micro_viewer?item_key={$res_item['itemkey']}";
        $hdrbar .= "&amp;{$res_item['itemkey']}={$res_item['itemval']}\">";
        $hdrbar .= "$text</a>";
        $hdrbar .= "</h5>\n";
        // make the chat
        $search_chat_string = mkChat($res_item['snippets']);
        // clean the score
        $score = round($res_item['score'], 2);
        // print the item
        $var .= "<li class=\"search_item\">";
        $var .= $hdrbar;
        $var .= "$search_chat_string<p class=\"search_foot\">$mk_score: $score</p>";
        $var .= "</li>";
    }
    $var .= '</ul>';
    return($var);
}
// }}}
// {{{ mkResultsJson()

/**
* makes a JSON object from a results array (usually used by the API)
*
* @param array $results_array  an ARK std results array
* @return $var string  the XHTML
* @author Guy Hunt
* @author Stuart Eve
* @since v1.1
*
*
*/

function mkResultsJson($results_array, $filters)
{
    global $lang, $skin_path;
    // handle sort order
    if (array_key_exists('sort_order', $filters)) {
        $sort_order = $filters['sort_order'];
        $sort_field = $sort_order['sort_field'];
        $sort_type = $sort_order['sort_type'];
    } else {
        $sort_order = FALSE;
        $sort_field = FALSE;
        $sort_type = FALSE;
    }
    // manual setup flags
    $prev_itemkey = 'false';
    $table_set = 'false';
    $output_array = array();
  //  $var = "<div class=\"result_tbl\">\n";
    // Loop thru the results
    foreach ($results_array as $res_item) {
        // Decide whether to start a new itemkey array
        if ($res_item['itemkey'] != $prev_itemkey) {
            // We need a new array
            // ---- MODULE SETUP ---- //
            // get a mod short
            $mod_short = substr($res_item['itemkey'], 0, 3);
            // get the 'conf_mac_json' array for this module - if it hasn't been set use conf_mac_table
            $conf = reqModSetting($mod_short, 'conf_mac_json');
            if ($conf == FALSE) {
                $conf = reqModSetting($mod_short, 'conf_mac_table');
            }
            // firstly establish the fields for this new module
            $fields = $conf['fields'];
            // start a fresh array
            $output_array[$res_item['itemkey']] = array();
            // process the fields array
            $fields = resTblTh($fields, 'silent');
            // loop thru the cols
            foreach($fields as $field) {
                // make the val
                $td_val = resFdCurr($field, $res_item['itemkey'], $res_item['itemval']);
                $output_array[$res_item['itemkey']][$res_item['itemval']]['fields'][$field['field_alias']] = $td_val;
            }
        } else {
            // loop thru the cols
            foreach($fields as $field) {
                // make an alias for the item
                $td_val = resFdCurr($field, $res_item['itemkey'], $res_item['itemval']);
                // print the item
                $output_array[$res_item['itemkey']][$res_item['itemval']]['fields'][$field['field_alias']] = $td_val;
            }
        }
        // set up what the previous key was
        $prev_itemkey = $res_item['itemkey'];
    }
    return($output_array);
}

// }}}
// {{{ mkResultsMap()

/**
* makes a map from a results array
*
* @param array $left_panel the left panel array from the settings file 
* @return $var string  the left panel link
* @author Stuart Eve
* @author Guy Hunt
* @author Mike Johnson (m.johnson@lparchaeology.com) 
* 
*
*
*/

function mkResultsMap($results_array, $filters)
{
    include_once('php/map/map_functions.php');
    global $lang, $disp_mode, $wxs_query_map, $wxs_qlayers, $ark_root_path, $skin;
    $var = '';
    $mk_no_spat_results = getMarkup('cor_tbl_markup', $lang, 'no_spat_results');
    $have_spat_results = FALSE;
    $skin = reqArkVar('skin', $skin);
    $skin_path = "$ark_skins_path/$skin";
    //first thing is we need to check the variables - otherwise we won't bother making the map
    //and just display the chat.
    if (!is_array($wxs_qlayers)) {
        echo 'ADMIN ERROR: In order for View Results as Map to work you need to set $wxs_qlayers in settings.php';
    }
    if (!$wxs_query_map) {
        echo 'ADMIN ERROR: In order for View Results as Map to work you need to set $wxs_query_map in settings.php';
    }
    // hop through the results_array to see if we have an queryable layers
    // (better to fall over here elegantly than later)
    if (is_array($wxs_qlayers) && is_array($results_array)) {
        $filterlayers = array();
        foreach ($wxs_qlayers as $key => $wfs_qlayer) {
            if (!array_key_exists($key,$filterlayers)){
                foreach ($results_array as $itemkey => $item) {
                    if (substr($itemkey,0,3) == $wxs_qlayers[$key]['module']) {
                        $have_spat_results = TRUE;
                        $filterlayers[$key] = $wxs_qlayers[$key];
                    }
                }
            }
        }
    }
    if ($wxs_query_map && $have_spat_results) {
        // retrieve the map
        $map = getMap($wxs_query_map);
        $script = "<script src=\"http://cdnjs.cloudflare.com/ajax/libs/proj4js/2.2.1/proj4.js\" type=\"text/javascript\"></script>";
        $script .= '<script type="text/javascript">';
        $script .= genMap('map_col', $map);
        $script .= "console.log(new Date().getTime());";
        $script .= genAddFeatureOverlay($map);
        $script .= "console.log(new Date().getTime());";

        $first=true;
        foreach($map['layers'] as $layer){
        $script .= "console.log(new Date().getTime());";
            $script .= genAddLayer($layer, $map);
        $script .= "console.log(new Date().getTime());";
            $script .= "layer{$layer['id']}.setVisible(true);";
        }
        
        foreach($filterlayers as $filterlayer){
            $script .= genAddFilter($results_array, $filterlayer, $map);
            $script .= genDataViewInteraction($map, $filterlayer);
        }
        $script .= "</script>";
        
        if ($map) {
            $var = '<script type="text/javascript" src="lib/js/ol3/ol.js"></script>';
            $var .= "<link rel=\"stylesheet\" href=\"{$ark_lib_path}/js/ol3/ol.css\" /><link rel=\"stylesheet\" href=\"{$skin_path}/stylesheets/map_view.css\" />";
            $var .= "<div class=\"result_map\">";
            $var .= "<div id=\"map_col\" class=\"map_col\">";
            $var .= '<div id="popup"></div>';
            $var .= $script;
            $var .= "</div>";
            //echo "Map Results View is not ready yet";
            $var .= "<div class=\"text_col\">";
            $disp_mode = 'text';
            $var .= mkResultsText($results_array, $filters);
            $var .= "</div>";
            $var .= "</div>";

        }
    } else {
        $var = "<div class=\"result_map_no_spat\">";
        $var .= "<div class=\"message\">";
        $var .= $mk_no_spat_results;
        $var .= "</div>";
        $var .= "</div>";
    }
    return $var;
}

// }}}
// {{{ mkResultsNav()

/**
* makes a nav used in the results panel
*
* @param array $conf  results nav conf from settings.php
* @param string $ftr_mode  the filter mode (basic|standard|advanced)
* @param string $current_ label the current results view label
* @return $var string  the XHTML nav
* @author Guy Hunt
* @since v0.8
*
* Note: the toolbar is made up of blocks of tools. The toolbar is setup with an array
* this array contains arrays. Each of these tool group arrays contains elements. Each
* element is an array.
*
*/

function mkResultsNav($conf, $ftr_mode, $current_label)
{
    global $lang;
    if (!$conf or !is_array($conf)) {
        echo "ADMIN ERROR: The config for the results toolbar is not correctly setup";
    }
    // start the toolbar
    $var = "<div id=\"results_nav\">\n";
    // the current label
    $var .= "<label>$current_label</label>\n";
    if ($ftr_mode == 'basic') {
        // close out the nav and return as is
        $var .= "</div>\n";
        return $var;
    }
    foreach ($conf as $key => $group) {
        // put in the start and finish blocks for this tool group
        $var .= "<ul id=\"{$key}\">\n";
        // loop over each element in this group
        foreach ($group as $key => $button) {
            $current =FALSE;
            // set markup if required
            if ($button['mkname']) {
                $mk_text = getMarkup('cor_tbl_markup', $lang, $button['mkname']);
            } else {
                $mk_text = FALSE;
            }
            if ($current_label==$mk_text){
                $current = TRUE;
            }
            // set css class if required
            if ($button['css_class']) {
                $css_class = " class=\"{$button['css_class']}";
            } else {
                $css_class = FALSE;
            }
            // set title text if required
            if ($button['title']) {
                $title_mk = getMarkup('cor_tbl_markup', $lang, $button['title']);
                $title = " title=\"{$title_mk}\"";
            } else {
                $title_mk = FALSE;
                $title = FALSE;
            }
            // set light box if required
            if (reqQst($button,'lightbox')) {
                $css_class .= " colorbox\""; 
                $lightbox = "";
            } else {
                $lightbox = FALSE;
                $css_class .= "\"";
            }          
            // decide if this is a text based icon or a graphic
            if ($button['type'] == 'text') {
                // put in the tool
                if ($current){
                    $var .= "<li class=\"current\">";
                } else {
                    $var .= "<li>";
                }
                $var .= "<a href=\"{$button['href']}\" {$css_class}{$lightbox}{$title}>$mk_text</a></li>\n";                
            }
            if ($button['type'] == 'img') {
                // put in the tool
                $var .= "<li>";
                $var .= "<a href=\"{$button['href']}\" {$css_class}{$lightbox}{$title}>";
                $var .= "&nbsp;</a></li>\n";
            }
            if ($button['type'] == 'newpage') {
                // put in the tool
                $var .= "<li>";
                $var .= "<a href=\"{$button['href']}\" {$css_class}{$lightbox}{$title} target=\"mywin\" \">";
                $var .= "&nbsp;</a></li>\n";
            }
            
        }
        // end the group
        $var .= "</ul>\n";
    }
    //$var .= "<a id=\"toggle\" class=\"expand\" href=\"#\" onclick=\"toggleWidth('toggle', 'wrapper', 'main');\">&#x21E5;</a>";
    $var .= "</div>\n";
    // return the var
    return $var;
}

// }}}
// {{{ mkResultsTable()

/**
* makes an XHTML table from a results array
*
* @param array $results_array  an ARK std results array
* @return $var string  the XHTML
* @author Guy Hunt
* @since v0.8
*
* Paging should be down outside this function
*
*/

function mkResultsTable($results_array, $filters)
{
    global $lang, $skin_path;
    // handle sort order
    if (array_key_exists('sort_order', $filters)) {
        $sort_order = $filters['sort_order'];
        $sort_field = $sort_order['sort_field'];
        $sort_type = $sort_order['sort_type'];
    } else {
        $sort_order = FALSE;
        $sort_field = FALSE;
        $sort_type = FALSE;
    }
    // manual setup flags
    $prev_itemkey = 'false';
    $table_set = 'false';
    $var = "<div class=\"result_tbl\">\n";
    // Loop thru the results
    foreach ($results_array as $res_item) {
        // Decide whether to start a new table and put in a header row or not
        if ($res_item['itemkey'] != $prev_itemkey) {
            // We need a new table as we are on a new module
            
            // ---- MODULE SETUP ---- //
            // get a mod short
            $mod_short = substr($res_item['itemkey'], 0, 3);
            // get the 'conf_mac_table' array for this module
            $conf = reqModSetting($mod_short, 'conf_mac_table');
            // firstly establish the fields for this new module
            $fields = $conf['fields'];
            
            // ---- OUTPUT ---- //
            // if there was a previous table, end it cleanly
            if ($table_set == 'true') {
                $var .= "</table>\n";
            }
            // start a fresh table
            $var .= "<table class=\"result_tbl\">\n";
            // flag that a table was started
            $table_set = 'true';
            // process the fields array
            $fields = resTblTh($fields, 'silent');
            // make the header row
            foreach($fields as $field) {
                // DEV NOTE: config failsafe 
                if (!array_key_exists('field_id', $field)) {
                    $field['field_id'] = 'not_set';
                }
                // if this is the current field we are sorting on
                if ($field['field_id'] == $sort_field) {
                    // select the sort order icon
                    $sort_type = strtolower($sort_type);
                    if ($sort_type == 'desc' or $sort_type == 'dsc') {
                        $ico = "<a href=\"{$_SERVER['PHP_SELF']}?sort_type=asc\">";
                        $ico .= "<img src=\"$skin_path/images/results/asc.png\"";
                        $ico .= " class=\"sort\" alt=\"sort\" />";
                        $ico .= "</a>";
                    } elseif ($sort_type == 'asc') {
                        $ico = "<a href=\"{$_SERVER['PHP_SELF']}?sort_type=desc\">";
                        $ico .= "<img src=\"$skin_path/images/results/desc.png\" class=\"sort\" alt=\"sort\" />";
                        $ico .= "</a>";
                    }
                } else {
                    $ico = FALSE;
                }
                // make the val
                $th_val = $field['field_alias'];
                // print the header
                if ($ico) {
                    $var .= "<th>$ico$th_val</th>";
                } elseif ($field['field_id'] != 'not_set') {
                    $href = "{$_SERVER['PHP_SELF']}?sort_type=asc&amp;sort_field={$field['field_id']}";
                    $var .= "<th><a href=\"$href\">$th_val</a></th>";
                } else {
                    $var .= "<th>$th_val</th>";
                }
                
            }
            // print the first row as normal
            $var .= "<tr id=\"{$res_item['itemkey']}_{$res_item['itemval']}\" class=\"search_item\">";
            // loop thru the cols
            foreach($fields as $field) {
                // make the val
                $td_val = resTblTd($field, $res_item['itemkey'], $res_item['itemval']);
                // print the item
                $var .= "<td>$td_val</td>";
            }
            // end the first row
            $var .= "</tr>\n";
        } else {
            // start normal row
            $var .= "<tr id=\"{$res_item['itemkey']}_{$res_item['itemval']}\" class=\"search_item\">";
            // loop thru the cols
            foreach($fields as $field) {
                // make an alias for the item
                $td_val = resTblTd($field, $res_item['itemkey'], $res_item['itemval']);
                // print the item
                $var .= "<td>$td_val</td>";
            }
            // end normal row
            $var .= "</tr>\n";
        }
        // set up what the previous key was
        $prev_itemkey = $res_item['itemkey'];
    }
    // cleanly end the last table
    $var .= "</table>\n";
    // $var .= mkMultiResultActionNav(); //this will allow actions on multiple results
    $var .= "</div>\n";
    return($var);
}

// }}}
// {{{ mkResultsText()

/**
* makes an XHTML string of results from a results array
*
* @param array $results_array  an ARK std results array
* @return $var string  the XHTML
* @author Guy Hunt
* @since v0.8
*
* As of v0.8 'chat' and text' display of results have diverged
* Text is intended as abstract/excerpt text style display of an item
* as would be seen on a blog. Fields are more customisable that chat.
*
*/

function mkResultsText($results_array, $filters)
{
    global $lang, $conf_micro_viewer;
    // markup
    $mk_score = getMarkup('cor_tbl_markup', $lang, 'score');
    // manual settings
    $prev_itemkey = 'false';
    // ---- OUTPUT ---- //
    // Output the results as a paged list
    $var = '<ul class="result_ul">';
    foreach ($results_array as $res_item) {
        // if this is a new mod include the settings
        if ($res_item['itemkey'] != $prev_itemkey) {
            // Get the mod settings for this mod
            // get a mod short
            $mod_short = substr($res_item['itemkey'], 0, 3);
            // get the 'conf_mac_text' array for this module
            $conf = reqModSetting($mod_short, 'conf_mac_text');
            // establish the fields for this new module
            $fields = $conf['fields'];
            // set up the $prev_itemkey
            $prev_itemkey = $res_item['itemkey'];
        }
        // DATA
        // Loop over each field for this item
        $field_list = "<ul class=\"text_fields\">";
        $fields = resTblTh($fields, 'silent');
        foreach ($fields as $key => $field) {
            if ($field['dataclass'] != 'op') {
                $field_data = resTblTd($field, $res_item['itemkey'], $res_item['itemval']);
                $field_list .= "<li><label>{$field['field_alias']}</label> $field_data</li>";
            } else {
                $options = resTblTd($field, $res_item['itemkey'], $res_item['itemval']);
            }
        }
        // HEADER
        // The header bar for the items is admin configurable
        if (isset($conf_results_text_hdrbar_type)) {
            $hdrbar_type = $conf_results_text_hdrbar_type;
        } else {
            // put in a default
            $hdrbar_type = 'link';
        }
        // make an alias for the item
        $item_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $res_item['itemkey'], 1);
        // declare the var
        $hdrbar = FALSE;
        // FULL
        if ($hdrbar_type == 'full') {
            $hdrbar .= "<h5>";
            $hdrbar .= "{$item_alias}: {$res_item['itemval']}";
            $hdrbar .= "</h5>\n";
        }
        // SHORT
        if ($hdrbar_type == 'short') {
            $hdrbar .= "<h5>{$res_item['itemval']}</h5>\n";
        }
        // LINK
        if ($hdrbar_type == 'link') {
            $hdrbar .= "<h5>$item_alias:&nbsp;";
            $hdrbar .= "<a href=\"$conf_micro_viewer?item_key={$res_item['itemkey']}";
            $hdrbar .= "&amp;{$res_item['itemkey']}={$res_item['itemval']}\">";
            $hdrbar .= "{$res_item['itemval']}</a>";
            if (!empty($options)) {
                $hdrbar .= $options;
            }
            $hdrbar .= "</h5>\n";
        }
        $field_list .= "</ul>";
        // assemble this item
        $var .= "<li id=\"{$res_item['itemkey']}_{$res_item['itemval']}\" class=\"search_item\">";
        $var .= $hdrbar;
        $var .= $field_list;
        $var .= "</li>\n";
    }
    $var .= "</ul>\n";
    return($var);
}

// }}}
// {{{ mkResultsThumb()

/**
* makes an XHTML string of thumbnails from a results array
*
* @param array $left_panel the left panel array from the settings file 
* @return $var string  the left panel link
* @author Guy Hunt
* @since v0.8
*
*
*/

function mkResultsThumb($results_array, $filters)
{
    global $lang, $conf_micro_viewer;
    // settings are needed to run fields properly inside this func
    include('config/settings.php');
    // markup
    $mk_score = getMarkup('cor_tbl_markup', $lang, 'score');
    $mk_viewmsg = getMarkup('cor_tbl_markup', $lang, 'viewmsg');
    // setup the var
    $var = FALSE;
    // Print the results as a paged list
    $var .= "<ul class=\"result_thumb_ul\">\n";
    foreach ($results_array as $res_item) {
        // ---- MODULE SETUP ---- //
        // get a mod short
        $mod_short = substr($res_item['itemkey'], 0, 3);
        // get the 'conf_mac_table' array for this module
        $conf = reqModSetting($mod_short, 'conf_mac_thumb');
        // firstly establish the fields for this new module
        $fields = $conf['fields'];
        
        // ---- OUTPUT ---- //
        // print the item
        $var .= "<li class=\"search_item\">";
        $var .= "<a class=\"thumb_overlay\" href=\"$conf_micro_viewer?item_key={$res_item['itemkey']}";
        $var .= "&amp;{$res_item['itemkey']}={$res_item['itemval']}\">";
        $var .= "&nbsp;";
        // process the fields array
        $fields = resTblTh($fields, 'silent');
        // flag
        $file = FALSE;
        foreach ($fields as $key => $field) {
            // force no links - the whole of an xmi is a link to the item
            $field['op_no_link']=TRUE;
            // process the field
            if ($field['dataclass'] != 'file') {
                $val = resTblTd($field, $res_item['itemkey'], $res_item['itemval']);
            } else {
                // turn off lightbox
                $field['op_lightbox'] = FALSE;
                $val = resTblTd($field, $res_item['itemkey'], $res_item['itemval']);
                if (!$val) {
                    $val .= "<span class=\"data\"><img src=\"{$skin_path}/images/results/thumb_default.png\" alt=\"icon\" class=\"icon\"/></span>";
                }
                $file = 'done';
            }
            $var .= $val;
        }
        if ($file != 'done') {
            $var .= "<span class=\"data\"><img src=\"{$skin_path}/images/results/thumb_default.png\" alt=\"icon\" class=\"icon\"/></span>";
        }
        // end the item
        $var .= "</a></li>\n";
    }
    $var .= "</ul>\n";
    return($var);
}

// }}}
// {{{ mkSearchBox()

/**
* makes a text based search box for any page/place in ark
*
* @param string $txttype  optional, a texttype to narrow the search
* @param string $mk_label  optional, a label to place before the box
* @param string $mk_button  optional, a label for the 'go' button
* @return $var string  the searchbox
* @author Guy Hunt
* @author Andrew Dufton
* @since v0.6
*
* Note that this existed as the script inc_search_box.php since v0.4
* use of the inc is now deprecated
*
* As of v1.1 this incorporates an ability to limit the search to a
* single text type. In addition, the call can be modified to use markup.
* This is based on code by AJD for Arcadian. Incorporated into this func
* by GH.
*
* To remove the label on the left of the box, send a piece of blank markup
*
*/

function mkSearchBox($txttype=FALSE, $mk_label=FALSE, $mk_button=FALSE, $css_class=FALSE)
{
    global $conf_search_viewer, $lang, $form_method;
    // handle search type
    if (!$txttype) {
        $ftype = 'ftx'; // use a normal freetext if not txttype is set
        $id = 'search'; // assumes only one per page
    } else {
        $ftype = 'txt';
        $id = "search_$txttype"; // assumes many per page
    }
    // handle the label
    if ($mk_label) {
        $mk_label = getMarkup('cor_tbl_markup', $lang, $mk_label);
    } else {
        $mk_label = getMarkup('cor_tbl_markup', $lang, 'search');
    }
    // handle the button
    if ($mk_button) {
        $mk_button = getMarkup('cor_tbl_markup', $lang, $mk_button);
    } else {
        $mk_button = getMarkup('cor_tbl_markup', $lang, 'go');
    }
    // handle the CSS class
    if (!$css_class) {
        $css_class = "searchbox";
    }
    // OUTPUT
    $var = "<div id=\"$id\">\n";
    $var .= "<form method=\"$form_method\" class=\"$css_class\" action=\"$conf_search_viewer\">\n";
    $var .= "    <fieldset>\n";
    $var .= "    <label>{$mk_label}&nbsp;</label>\n";
    if ($ftype == 'txt') {
        $var .= "    <input type=\"hidden\" name=\"txttype\" value=\"$txttype\" />\n";
        $var .= "    <input type=\"text\" name=\"txt\" value=\"\" />\n";
    } else {
        $var .= "    <input type=\"text\" name=\"src\" value=\"\" />\n";
    }
    $var .= "    <input type=\"hidden\" name=\"ftr_mode\" value=\"basic\" />\n";
    $var .= "    <input type=\"hidden\" name=\"disp_mode\" value=\"chat\" />\n";
    $var .= "    <input type=\"hidden\" name=\"ftype\" value=\"$ftype\" />\n";
    $var .= "    <input type=\"hidden\" name=\"ftr_id\" value=\"searchbox\" />\n";
    $var .= "    <input type=\"hidden\" name=\"reset\" value=\"1\" />\n";
    $var .= "    <button type=\"submit\">$mk_button</button>\n";
    $var .= "    </fieldset>\n";
    $var .= "</form>\n";
    $var .= "</div>\n\n";
    // RETURN
    return $var;
}

// }}}
// {{{ mkSearchSimple()

/**
* makes a simple search window
*
* @param string $msrc  the mini search criteria
* @return void
* @author Guy Hunt
* @since
*
* NOTE: This is largely a wrapper and display function
*
* NOTE: This is ideally suited to use in subforms
*
* As of v1.1 this code is really only intended to be used within sf_microsearch.php
* developers should delegate any searches of this kind into an overlay GH 9/3/12
*
*/

function mkSearchSimple($prefix, $link_vars, $mod=FALSE, $meta_display=FALSE)
{
    // Basics
    global $item_key, $$item_key, $lang, $skin_path, $form_method, $sf_conf_name, $id_to_modify, $soft_fd_id;
    global $sf_key;
    if ($sf_key) {
        global $$sf_key;
        $sf_val = $$sf_key;
    }
    if (!$sf_conf_name) {
        echo "DEV ERROR: mkSearchSimple() should only be called within an overlay (as of v1.1)<br/>";
    }
    if ($mod) {
        $mod_alias = '&nbsp;-&nbsp;'.getAlias('cor_tbl_module', $lang, 'shortform', $mod, 1);
    } else {
        $mod_alias = FALSE;
    }
    if ($soft_fd_id) {
        $softie = "<input type=\"hidden\" name=\"soft_fd_id\" value=\"{$soft_fd_id}\" />\n";
        $softie2 = "&amp;soft_fd_id={$soft_fd_id}";
    } else {
        $softie = FALSE;
        $softie2 = FALSE;
    }
    // Markup
    $mk_res = getMarkup('cor_tbl_markup', $lang, 'results');
    $mk_res = 'Results';
    $mk_search = getMarkup('cor_tbl_markup', $lang, 'search');
    // Request vars
    $msrc = reqArkVar($prefix);
    $mres = reqQst($_SESSION, 'mres');
    if ($reset_msrc = reqQst($_REQUEST, 'reset_msrc')) {
        $msrc = FALSE;
        $_SESSION["$prefix"] = FALSE;
    }
    // fetch the full qstr for use in resetting this form
    if (!empty($_SERVER['QUERY_STRING'])) {
        $params = explode("&", $_SERVER['QUERY_STRING']);
            foreach ($params as $param) {
                $var = explode("=", $param);
                if ($var[0] != 'lang' && $var[0] != 'update_db') {
                    $newParams[] = $param;
                }
            }
        if (count($newParams) != 0) {
            $qstr = htmlentities(implode("&", $newParams));
        }
    } else {
        $qstr = FALSE;
    }
    // Output
    // A header
    $frm = "<h5>$mk_search{$mod_alias}</h5>\n";
    // The form
    $frm .= "<form method=\"$form_method\" id=\"mini_search_$prefix\" action=\"{$_SERVER['PHP_SELF']}\">";
    $frm .= "<input type=\"hidden\" name=\"itemkey\" value=\"$item_key\" />\n";
    $frm .= "<input type=\"hidden\" name=\"$item_key\" value=\"{$$item_key}\" />\n";
    $frm .= "<input type=\"hidden\" name=\"sf_key\" value=\"{$sf_key}\" />\n";
    $frm .= "<input type=\"hidden\" name=\"sf_val\" value=\"{$sf_val}\" />\n";
    $frm .= "<input type=\"hidden\" name=\"id_to_modify\" value=\"{$id_to_modify}\" />\n";
    $frm .= $softie;
    $frm .= "<input type=\"hidden\" name=\"sf_conf\" value=\"{$sf_conf_name}\" />\n";
    $frm .= "<input type=\"text\" name=\"{$prefix}\" value=\"$msrc\" style=\"width:125px; padding: 2px; margin: 0 4px 4px 0\"/>\n";
    // Submit button
    $frm .= "<button type=\"submit\">&gt;&gt;</button>";
    // A reset option
    $frm .= "<a href=\"{$_SERVER['PHP_SELF']}";
    $frm .= "?$qstr&amp;reset_msrc=1\">";
    $frm .= "<img class=\"sml\" src=\"$skin_path/images/plusminus/minus.png\" alt=\"[-]\" />";
    $frm .= "</a>";
    // End the form
    $frm .= "</form>\n";
    // SEARCH
    // If we have a search criteria but no results run the search
    if (!$mres && $msrc) {
        // either we have an itemkey of we have a standard ftx
        //test for key
        $elems = explode('_', $msrc);
        if (count($elems) == 2 && is_numeric($elems[1])) {
            // looks like the msrc is an itemkey
            include_once('php/validation_functions.php');
            if (!chkValid($msrc, FALSE, FALSE, $mod.'_tbl_'.$mod, $mod.'_cd')) {
                $mres =
                    array(
                        $mod.'_cd'.$msrc => array(
                            'itemkey' => $mod.'_cd',
                            'itemval' => $msrc,
                            'score' => 20,
                            'snippets' => array(),
                                //in order to keep this global we need to populate
                                //the snippet from the XMI setup for this mod
                                /*
                                array('type' => 'Test',
                                'snip' => 'test',
                                'class' => 'txt',
                                )
                            )*/
                        )
                );
            }
        } else {
            // run a standard ARK filter
            $msrc_filter =
                array(
                    'ftype' => 'ftx',
                    'src' => $msrc
            );
            if ($mres = execFltftx($msrc_filter, TRUE)) {
                // Limit this to the required module
                if ($mod) {
                    $mres = prcsHitsMod($mres, $mod.'_cd');
                } else {
                    $mres = prcsHits($mres);
                }
            }
        }
    }
    // RESULTS
    if ($mres) {
        $mres = sortResArr($mres);
        // trim the results to the top 5 (TO DO: proper pagination)
        $mres = array_chunk($mres, 5);
        $mres = $mres[0];
        // A header
        $res = "<h5>$mk_res:</h5>\n";
        // Contain the results in a list
        $res .= "<ul class=\"mini_res\">\n";
        foreach ($mres as $result) {
            // make an alias for the item
            $item_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $result['itemkey'], 1);
            // if the module is using types put this in tidily
            $rmod = substr($result['itemkey'], 0, 3);
            if (chkModType($rmod)) {
                $modtype = getModType($rmod, $result['itemval']);
                $type_alias = getAlias('cor_tbl_col', $lang, 'dbname', $rmod.'type', 1);
                $modtype_alias = getAlias("abk_lut_{$rmod}type", $lang, 'id', $modtype, 1);
                $modtype = "<p class=\"search_chat\"><span class=\"search_nm\">$type_alias:&nbsp;</span>$modtype_alias</p>";
            } else {
                $modtype = FALSE;
            }
            // handle meta
            $meta_subtitle = FALSE;
            $meta_chat = FALSE;
            if ($meta_display && !empty($result['item_meta'])) {
                if ($meta_display == 'subtitle') {
                    $meta_subtitle = mkResMeta($result['item_meta']);
                    $meta_chat = FALSE;
                }
                if ($meta_display == 'chat') {
                    $meta_subtitle = FALSE;
                    $meta_chat = mkResMeta($result['item_meta']);
                }
            } else {
                $meta_chat = FALSE;
                $meta_subtitle = FALSE;
            }
            // make the chat
            $search_chat_string = mkChat($result['snippets']);
            $res .= "<li>";
            $res .= "<h5>";
            $res .= "<a href=\"{$_SERVER['PHP_SELF']}?";
            $res .= "item_key=$item_key";
            $res .= "&amp;sf_key=$sf_key";
            $res .= "&amp;sf_val=$sf_val";
            $res .= "&amp;$item_key={$$item_key}";
            $res .= "&amp;skey={$result['itemkey']}";
            $res .= "&amp;sf_conf={$sf_conf_name}";
            $res .= "&amp;id_to_modify={$id_to_modify}";
            $res .= $softie2;
            $res .= "&amp;sval={$result['itemval']}$link_vars\">";
            $res .= "$item_alias: {$result['itemval']} $meta_subtitle</a>";
            $res .= "</h5>\n";
            $res .= "$meta_chat";
            $res .= "$modtype";
            $res .= "$search_chat_string";
            $res .= "</li>\n";
        }
        $res .= "</ul>\n";
    } else {
        $res = FALSE;
    }
    // Put it together in a div and return
    $var = "<div id=\"mini_search_box_$prefix\" class=\"mini_src\">\n";
    $var .= $frm;
    $var .= $res;
    $var .= "</div>\n\n";
    return $var;
}

// }}}
// {{{ mkSearchType()

/**
* makes an searchbox
*
* @param string $mode  sets output to be a dd or an input type text (options, plain, dd, or live)
* @param string $button  markup nickname of the button text
* @param string $item_key  sets output to be a dd or an input type text
* @param string $default  whatever you want in the box
* @param string $link  if not linking to same page you can add another page to link to here. 
* @return string $nav  a fully resolved XHTML string
* @author Henriette Roued Olsen
* @since 0.6
*
*
*/

function mkSearchType($modes, $name, $item_key, $default, $width, $link=FALSE)
{
    global $lang, $item_val;
    $mod_short = substr($item_key, 0, 3);
    $table = $mod_short . '_tbl_' . $mod_short;
    $order = $mod_short.'_no';
    $alias =
        getAlias(
            'cor_tbl_module',
            $lang,
            'itemkey',
            $item_key,
            1
    );
    switch ($modes) {
        case 'live': // Live Ajax search
            $search = "<input name=\"{$name}\" value=\"{$default}\" type=\"text\" id=\"{$mod_short}indiv\" style=\"width:100px\" onkeyup='liveSearchType(this.value, \"{$table}\", \"{$order}\", \"{$item_key}\")'/>";
            break;
        
        case 'plain': // Plain search
            $search = "<input type=\"text\" name=\"".$name."\" value=\"{$default}\" style=\"width:".$width."px\" />";
            break;
        
        case 'dd': // Drop down manu search
            $search =
                    ddItemval(
                        $item_val,
                        $item_val,
                        $item_key
                    );
            break;
            
        default: // Plain search
            $search = "<input type=\"text\" name=\"$item_key\" value=\"{$default}\" style=\"width:75px\" />\n<button type=\"submit\">$button</button>";
            break;
    }
    
    $nav = "$search\n";
    if ($modes == "live") {
        $nav .= "<div id=\"hintsType\"><span id=\"txtHintType\"></span></div>";
    }
    // return the code
    return ($nav);
}

// }}}



// {{{ mkSteCdNav()

/**
* makes the site code navigator for use in forms
*
* @param string $overlay  switch to let this func know that it should handle overlay input vars
* @return $var string  the site code navigator
* @author Stuart Eve
* @since v0.6
*
* Note: that this existed as the script inc_ste_cd_nav.php since v0.4
* use of the inc is now deprecated
*
* Note: The old inc_script would only display the selector to the user if
* configured to do so. This function will alsways return a $var containing
* the form IF there is more than one site code. If you wish to call this
* function without displaying the form, simple DO NOT print the returned var,
* just call the function. GH 17/10/09
*
*/

function mkSteCdNav($ol = FALSE)
{
    // set up global vars
    global $ste_cd, $lang, $default_site_cd, $form_method;
    // get existing ste_cd
    $ste_cd = reqArkVar('ste_cd', $default_site_cd);
    // OFFER FEEDBACK
    if (!$ste_cd) {
        echo "ADMIN ERROR: mkSteCdNav() no ste_cd is set up (check for default failed)<br/>";
    }
    // handle overlay mode
    $ol_var = FALSE;    
    if ($ol == 'overlay') {
        global $item_key, $$item_key;
        $lboxreload = reqQst($_REQUEST, 'lboxreload');
        $sf_conf_name = reqQst($_REQUEST, 'sf_conf');
        $ol_var = "<input type=\"hidden\" name=\"sf_conf\" value=\"{$sf_conf_name}\" />\n";
        $ol_var .= "<input type=\"hidden\" name=\"lboxreload\" value=\"{$lboxreload}\" />\n";
        $ol_var .= "<input type=\"hidden\" name=\"item_key\" value=\"{$item_key}\" />\n";
        $ol_var .= "<input type=\"hidden\" name=\"$item_key\" value=\"{$$item_key}\" />\n";
    }
    // Check if there is more than one site code in the database
    // SQL
    $sql = "
        SELECT *
        FROM cor_tbl_ste
    ";
    $params = array();
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle the result
    $i = 0;
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $i++;
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    if ($i > 1) {
        $enable_select = 1;
    }
    // OUTPUT A SELECTOR
    $var = FALSE;
    if (isset($enable_select)) {
    //Draw a form with dd and submit
        $dd = ddSimple($ste_cd, $ste_cd, 'cor_tbl_ste', 'id', 'ste_cd', '', 'code');
        $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
        $mk_stecd = getMarkup('cor_tbl_markup', $lang, 'ste_cd');
        $var = "
            <form method=\"$form_method\" id=\"ste_cd_selector\" action=\"{$_SERVER['PHP_SELF']}\" class=\"row\">\n
            $ol_var
            <label>$mk_stecd</label>\n
            <span class=\"input\">$dd</span>
            <span class=\"input\"><button type=\"submit\">$mk_go</button></span>
            </form>\n\n
        ";
    }
    // return the var (or FALSE)
    return $var;
}

// }}}


// {{{ mkTblTh()

/**
* makes up table headers
*
* @param array $fields  containing information about each field in a form/table
* @return array $var  contains html
* @author Guy Hunt
* @since 1.1
*
* As of v1.1 this function takes over the output function that was previously
* done by resTblTh(). This output mode was only ever used in the register whereas
* the silent mode of resTblTh() that processes fields to get their aliases is
* actually widely used in SFs. As resTblTh() could not be modified to return both
* html output and return the processed array, this function had to be split.
*
*/

function mkTblTh($fields)
{
    global $lang;
    // admin error handling
    if (!is_array($fields) || !$fields) {
        echo "ADMIN ERROR: mkTblTh() - something went wrong with the conf array";
        return FALSE;
    }
    $var = FALSE;
    
    // Colgroup
    // make a colgroup for the columns represented
    $var .= "\n<colgroup>";
    foreach($fields as $key => $col) {
        // make the col
        $var .= "<col class=\"{$col['dataclass']}\"/>";
    }
    $var .= "</colgroup>\n";
    
    // Table Header Row
    // start a table header row
    $var .= "<thead><tr>";
    // Loop over each field
    foreach ($fields as $key => $col) {
        // Print out the the cell
        $var .= "<th id=\"".$col['field_id']."\">".$col['field_alias']."</th>";
    }
    // end the row
    $var .= "</tr></thead>\n";
    
    // return the $var for output
    return ($var);
}

// }}}
// {{{ mkThumb() 
 
/** 
* makes up a thumbnail img tag 
* 
* @param array $file  an array (usually returned from getFile()) containing the file information 
* @param string $type a string containing either 'arkthumb' or 'webthumb' 
* @return string $thumb  a resolved xhtml string 
* @author Stuart Eve 
* @since 1.1 
* 
* This function just simply makes up an img link to an appropriate thumbnail 
*/ 
 
function mkThumb($file, $type)
{ 
    global $skin_path, $registered_files_dir, $registered_files_path;
    $thumb_src = ''; 
    if (is_array($file)) { 
        // first of all we check if we have the actual thumbnail - if so we are done 
        if (file_exists("{$registered_files_dir}/{$type}_{$file['id']}.jpg")) {
            $thumb_src = "<img src=\"{$registered_files_path}/{$type}_{$file['id']}.jpg\" alt=\"file_image\"/></a>";
            return $thumb_src; 
        } 
        // next try to return an icon based on file extension
        $file_extension = strtolower(substr(strrchr($file['filename'],"."),1));
        if ($file_extension) { 
            //set up the thumb - check if we have one - if not go for the default 
            $filepath_local = $_SERVER['DOCUMENT_ROOT']."$skin_path/images/file_icons/icon_$file_extension.png";
            if (file_exists("$filepath_local")) { 
                $thumb_src = "<img src=\"$skin_path/images/file_icons/icon_$file_extension.png\" alt=\"file_image\"/>"; 
            } else { 
                $thumb_src = "<img src=\"{$skin_path}/images/results/thumb_default.png\" alt=\"icon\" class=\"icon\" title=\"{$file['filename']}\"/>";  
            }
        } else { 
            //we probably have a streaming resource 
            //check for a uri first 
            if (array_key_exists('uri',$file) && $file['uri'] != FALSE) { 
                //check if its NewbTube 
                if (strpos($file['uri'], '.youtube.') || strpos($file['uri'], '.vimeo.')) { 
                    $thumb_src = "<img src=\"$skin_path/images/file_icons/icon_video.png\" alt=\"file_image\"/>";  
                }
            } else { 
                $thumb_src = "<img src=\"{$skin_path}/images/results/thumb_default.png\" alt=\"icon\" class=\"icon\" title=\"{$file['filename']}\"/>";  
            } 
        } 
    } else { 
        return "ADMIN ERROR: mkThumb needs to be sent a file array"; 
    } 
     
    return $thumb_src; 
}
// }}}
// {{{ mkTitle()

/**
* makes up titles or citations from various elements
*
* @param string $itemkey  the itemkey
* @param string $itemval  the item value
* @param array $title_vars  containing the bits to include in the citation
* @return string $title  a resolved xhtml string
* @author Guy Hunt
* @since 0.6
*/

function mkTitle ($itemkey, $itemval, $title_vars)
{
    // SETUP
    $title = FALSE;
    global $lang;
    $mod = substr($itemkey, 0, 3);
    // loop over the vars sticking them together
    foreach ($title_vars as $titleelem) {
        // A case for each dataclass
        switch ($titleelem['dataclass']) {
            // txt
            case 'txt':
            // multi call
            if ($txts = getCh('txt', $itemkey, $itemval, $titleelem['datatype'])) {
                $elem = FALSE;
                foreach ($txts as $txt_id) {
                    $frag =
                        getSingleText(
                            $itemkey,
                            $itemval,
                            $titleelem['datatype'],
                            $titleelem['fraglang']
                    );
                    //if this is the first time thru dont append punctuation
                    if (!$elem) {
                        $elem = $frag;
                    } else {
                        $elem .= $titleelem['punct'].$frag;
                    }
                }
            }
            break;
            
            // action
            case 'action':
            // multi call
            $actors = getActor($itemkey, $itemval, $titleelem['datatype'], 'abk_cd');
            if (!empty($actors)) {
                $elem = FALSE;
                foreach ($actors as $actor_row) {
                    $frag =
                        getActorElem(
                            $actor_row['actor_itemvalue'],
                            'name',
                            'abk_cd',
                            'txt'
                    );
                    //if this is the first time thru dont append punctuation
                    if (!$elem) {
                        $elem = $frag;
                    } else {
                        $elem .= $titleelem['punct'].$frag;
                    }
                }
            }
            break;
            
            // date
            case 'date':
            $date = 
                getDateARK(
                    $itemkey,
                    $itemval,
                    $titleelem['datatype'],
                    $titleelem['datestyle']
            );
            if ($date) {
                $elem = $date;
            }
            break;
            
            // number
            case 'number':
            if ($numbers = getNumber($itemkey, $itemval, $titleelem['datatype'])) {
                $elem = FALSE;
                foreach ($numbers AS $number_row) {
                    $frag = $number_row['number'];
                    //if this is the first time thru dont append punctuation
                    if (!$elem) {
                        $elem = $frag;
                    } else {
                        $elem .= $titleelem['punct'].$frag;
                    }
                }
            }
            break;
        }
        // decide what to do with this information
        if ($titleelem['span']) {
            $title .= $titleelem['pby']."<span {$titleelem['span']}>".$elem.$titleelem['fby']."</span>";
        } else {
            $title .= $elem.$titleelem['fby'];
        }
        unset ($elem);
    }
    // RETURN
    if ($title) {
        return ($title);
    } else {
        return FALSE;
    }
}

// }}}
// {{{ mkTl()

/**
* makes an xhtml timeline out of a getSpan() result
*
* @param array $ranges  contains the results of a getSpan()
* @param int $tl_width  sets the width of the timeline in pixels
* @return void
* @author Guy Hunt
* @since 0.5
*/

function mkTl($ranges, $tl_width)
{
    // SETUP
    // globals
    global $lang;
    // manually set end of tl to 0BP
    $tl_end = '0';
    // MARKUP
    $mk_tlenddate = getMarkup('cor_tbl_markup', $lang, 'tlenddate');
    
    // FIRST we re-order the array descending on the column 'beg'
    $ranges_det = sortResArr($ranges, FALSE, 'beg');
    // SECOND - now for some fancy stuff
    //  dynamically guessing the start date
    $r_e = $ranges_det[0];
    $r_l = end($ranges_det);
    $s_e = $r_e['beg'];
    $e_l = $r_l['end'];
    $tl_dur = $s_e-$tl_end;
    $pad_start = $tl_dur/4;
    $bar_height = 10;
    if ($s_e > 6500 && $e_l < 1500) {
        $pad_end = 25;
    } elseif ($e_l <= 0) {
        $pad_end = 25;
    } else {
        $pad_end = 0;
    }
    $tl_start = round($pad_start+$s_e, -2);
    $tl_duration = abs($tl_start-$tl_end);
    $tl_pxyear = $tl_width/$tl_duration;
    $num_occs = count($ranges_det);
    $num_disoccs = $num_occs;
    $num_segs = $num_occs+$num_disoccs; //the first disocc goes in manually
    
    // the first padding segment
    $segments[] = 
        array(
            'name' => 'padding segment',
            'start' => $tl_start,
            'end' => $ranges_det[0]['beg']
    );
    // PROCESS ranges -> segments
    // set up the ids
    $r_id = 0;
    $seg_id = 0;
    while ($seg_id < $num_segs-1) {
        // if the beginning of the next range matches the end of the last segment - add it
        if ($ranges_det[$r_id]['beg'] == $segments[$seg_id]['end']) {
            $segments[] = 
                array(
                    'name' => 'occupied segment',
                    'start' => $ranges_det[$r_id]['beg'],
                    'end' => $ranges_det[$r_id]['end']
            );    
            // increment the range id
            $r_id++;
        } else {
            // if it doesnt match add a disoccupation segment
            $segments[] = 
                array(
                    'name' => 'dis-occupied segment',
                    'start' => $segments[$seg_id]['end'],
                    'end' => $ranges_det[$r_id]['beg']
            );
        }
        // increment the segment id
        $seg_id++;
    };
    // The last segment
    // - if the segs don't already end on the tl_end
    // add in a final segment to bring the line up to the tl_end
    if ($segments[$seg_id]['end'] !== $tl_end) {
        $segments[] = 
            array(
                'name' => 'final dis-occ segment',
                'start' => $segments[$seg_id]['end'],
                'end' => $tl_end
        );
    } else {
        // the tl already runs up to the tl_end
        $pad_end = 20;
    }
    // some logic to decide if the final label is displayed
    $test = FALSE; // force this to always be off until we figure out why... GH 3 Aug 12
    if ($test) {
        $end_lab = 'on';
    } else {
        $end_lab = FALSE;
    }
    // do some math on each segment
    foreach ($segments as $key => $segment) {
        $duration = abs($segment['start'] - $segment['end']);
        $segment_length = floor($duration*$tl_pxyear);
        $segments[$key]['duration'] = $duration;
        $segments[$key]['segment_length'] = $segment_length-2;
    }
    // ---- OUTPUT ---- //
    // start the list neatly
    $tl = "<ul id=\"timeline_segments\" class=\"tl_list\">\n";
    // output each segment
    $key = 0;
    $row_h = 15;
    $row_o = $row_h/2;
    $height = $num_segs*$row_o;
    if ($height < 25) {
        $height = 25;
    }
    $offset = 10;
    foreach($segments as $key => $segment) {
        unset($start);
        $start = $segment['start']-2000;
        // Fancy labelling
        if ($start > 0) {
            $start_epoch = 'BC';
        } else {
            $start_epoch = 'AD';
            $start = abs($start);
        }
        $label = "$start&nbsp;$start_epoch";
        // style according to a given factor
        if ($segment['name'] == 'occupied segment') {
            //chop border width from segment
            $width = $segment['segment_length'];
            $style1 = "height: {$height}px; width: {$width}px; border-bottom: {$bar_height}px solid #5A757B; z-index: -{$key}";
            // $labstyle1 = "padding-top: {$offset}px"; GH not using offset on the occ. sections 4 Aug 12
            $labstyle1 = FALSE;
            $key++;
            $tl .= "<li class=\"tl_seg_occupied\" style=\"$style1\"><span class=\"tl_lab_occupied\" style=\"$labstyle1\">$label</span></li>\n";
        } else {
            $style2 = "width: {$segment['segment_length']}px; height:{$height}px; border-bottom: {$bar_height}px solid lightgray; z-index: -{$key}";
            $labstyle2 = "padding-top: {$offset}px";
            $tl .= "<li class=\"tl_seg_notoccupied\" style=\"$style2\"><span class=\"tl_lab_notoccupied\" style=\"$labstyle2\">$label</span></li>\n";
        }
        
        if ($key != 0 && $segment['segment_length'] < 40) {
            $offset = $offset+$row_o;
        }
    }
    $pad_offset = $offset;
    $pad_height = $bar_height+$height;
    $style3 = "width: {$pad_end}px; height:{$pad_height}px;";
    if ($end_lab == 'on') {
        $vis = FALSE;
    } else {
        $vis = ' visibility: hidden';
    }
    $labstyle3 = "padding-top: {$pad_offset}px;$vis";
    $tl .= "<li class=\"tl_seg_present\" style=\"$style3\"><span class=\"tl_lab_present\" style=\"$labstyle3\">$mk_tlenddate</span></li>\n";
    // end the list neatly
    $tl .= "</ul>\n\n";
    // put in some jquery to fix the tl_list width to fit the segments as printed
    $script = '
        <script type="text/javascript">
            var $j = jQuery.noConflict();
            var sum=0;
            $j(".tl_list li").each( function(){ sum += $j(this).outerWidth(); });
            $j(".tl_list").width( sum );
            console.log("sum: " + sum);
        </script>
    ';
    $tl .= $script;
    return ($tl);
}

// }}}
// {{{ mkUploadResultsTable()

/** makes a feedback table from the results of a file process
*
* @param array $results_table  the array that comes as a result from the processFiles function
* @param boolean $dry  set to TRUE if this array has come from a dry run of processFiles
* @return $var  an html string containing a formatted table of results
* @author Stuart Eve
* @since 1.1
*
*/

function mkUploadResultsTable($upload_results, $dry = FALSE)
{
    global $skin_path;
    
    //the first thing we need to check if there are any fatal errors - if so then don't even bother printing out the tables
    if (array_key_exists('fatal',$upload_results)) {
        $var = "<p class=\"message\">The following fatal errors would have occurred processing these files, please rectify before trying to process them again:</p>";
        foreach ($upload_results['fatal'] as $key => $value) {
            $num = $key + 1;
            $var .= "<p class=\"error\">$num - $value</p>\n";
        }
        return $var;
    }
    //setup the table headers
    if (!$dry) {
        $var = "<table class='importtest'>";
        $var .= "<tr><th>Processing Results</th></tr>";
        $var .= "<tr><td>Total Files: {$upload_results['tot_files']}</td></tr>";
        $var .= "<tr><td>Total Files Processed: {$upload_results['tot_proc']}</td></tr>";
        $var .= "<tr><td>Upload Method: {$upload_results['upload_method']}</td></tr>";
        $var .= "</table>";
        $var .= "<table class='importtest'>";
        $var .= "<tr><td></td><th>Filename</th><th>Processed</th><th>Message</th><th>Linked to an item?</th><th>Thumbnailed?</th></tr>";
    } else {
        $var = "<table class='importtest'>";
        $var .= "<tr><th>Results of Dry Run</th></tr>";
        $var .= "<tr><td>Total Files sent for Dry Run: {$upload_results['tot_files']}</td></tr>";
        $var .= "<tr><td>Total Files which will be processed: {$upload_results['tot_proc']}</td></tr>";
        //insert some extra messages if they exist
        if (array_key_exists('messages',$upload_results)) {
            foreach ($upload_results['messages'] as $message) {
                $var .= "<tr><td>$message</td></tr>";
            }
        }
        $var .= "</table>";
        $var .= "<table class='importtest'>";
        $var .= "<tr><td></td><th>Filename</th><th>Dry Process Results</th><th>Message</th><th>Will this be linked to an item?</th><th>Will this be thumbnailed?</th><th>Metadata</th></tr>";
    }
    
    $files = $upload_results['files'];
    //now go through the results array printing out as we go
    foreach ($files as $key => $file) {
        $var .= "<tr>";
        //first find out if it has been/will be processed
        if ($dry) {
            $processedok = "Ok to Process";
            $processedfail = "Will not be processed";
            $notlinked = "Will not be linked";
        } else {
            $processedok = "Processed";
            $processedfail = "NOT processed";
            $notlinked = "Not linked";
        }
        if (array_key_exists('process', $file)) {
            $process_txt = "<td class='importtest_pos'>$processedok</td><td>{$file['process']['lut']['message']}</td>";
            $process_icon = "<img alt=\"tick\" src=\"$skin_path/images/truefalse/tick.png\""; 
            //now see if it has been linked
            if (array_key_exists('cor_tbl',$file['process'])) {
                if (is_array($file['process']['cor_tbl']) && array_key_exists('results',$file['process']['cor_tbl'])) {
                    $linked_txt = "<td class='importtest_pos'>{$file['process']['cor_tbl']['results']['linked_item']}</td>";
                } elseif (array_key_exists('cor_tbl',$file['process'])) {
                    $linked_txt = "<td class='importtest_amber'>$notlinked [{$file['process']['cor_tbl']}]</td>";
                } else {
                    $linked_txt = "<td class='importtest_amber'>$notlinked</td>";
                }
            } else {
                $linked_txt = "<td class='importtest_amber'>$notlinked</td>";
            }           
        } else {
            $process_icon = "<img alt=\"cross\" src=\"$skin_path/images/truefalse/cross.png\"";  
            $process_txt = "<td class='importtest_neg'>$processedfail</td><td>{$file['message'][0]}</td>";
            $linked_txt = "<td class='importtest_amber'></td>";
        }
        //now check the crunching
        if (array_key_exists('crunch', $file)) {
            if (!array_key_exists('arkthumb', $file['crunch'])) {
                $crunch_txt = "<td class='importtest_amber'>{$file['crunch']['convertible']}</td>";
            } else {
                $crunch_txt = "<td class='importtest_pos'>{$file['crunch']['convertible']}</td>";
            }
        } else {
            $crunch_txt = '<td></td>';
        }
        //check for metadata
        if (array_key_exists('metadata',$file) && is_array($file['metadata'])) {
            $metadata_txt = "<td class='importtest_pos'>";
            
            foreach ($file['metadata'] as $metadata_key => $metadata_value) {
                $metadata_txt .= "$metadata_key => $metadata_value\n";
            }
            
            $metadata_txt .= "</td>";
        } else {
            $metadata_txt = "<td class='importtest_neg'>";
            $metadata_txt .= "No metadata";
            $metadata_txt .= "</td>";
        }
        //now choose the 
        $var .= "<td>$process_icon</td>";
        $var .= "<td>$key</td>";
        //now insert the 'processed' response
        $var .= $process_txt;
        $var .= $linked_txt;
        $var .= $crunch_txt;
        $var .= $metadata_txt;
        $var .= "</tr>";
    }
    $var .= "</table>";
    
    return $var;
    
}
// }}}
// {{{ mkUserInfo()

/**
* makes the User Info for the header
*
* @return $var string  the XHTML User Info
* @author Jessica Ogden
* @since v1.1
*
*/

function mkUserInfo() 
{
    global $lang, $soft_name, $ark_root_path;
    if (reqQst($_SESSION, 'authorised')) {
        $mk_help = getMarkup('cor_tbl_markup', $lang, 'help');
        $mk_logout = getMarkup('cor_tbl_markup', $lang, 'logout');
        $var = FALSE;
        $var .= "<span>$soft_name</span>";
        $var .= mkNavLang();
        $var .= "<span><a href=\"http://ark.lparchaeology.com/wiki\">$mk_help</a></span>";
        $var .= "<span class=\"noborder\"><a href=\"{$ark_root_path}/index.php?logout=true\">$mk_logout</a></span>";
        return ($var);
    }
}

// }}}
// {{{ modBr()

/**
* returns a resolved xhtml string wrapping an item
*
* @param string $key  the full item key
* @param string $val  the full item value
* @param array $conf_br  an array containing the tags in which to wrap the itemkey
* @return string var  the resolved string
* @author Guy Hunt
* @since 0.6
*
* NOTE 1: This existed as a context specific function until 0.6
*
* NOTE 2: The array of wrap tags needs to be set up as follows:
* Set this up in mod_MOD_settings. This example sets rounded brackets for 
* modtype 1 and square brackets for modtype 2 
* $conf_br =
*     array(
*     'type_1_L' => '(',
*     'type_1_R' => ')',
*     'type_2_L' => '[',
*     'type_2_R' => ']',
*     'type_3_L' => '',
*     'type_3_R' => '*'
* );
*
*/

function modBr($key, $val, $conf_br) 
{
    // error handling
    if (!isset($key)) {
        echo "function: modBr<br/>";
        echo "setup error: key is not set correctly";
    }
    if (!isset($val)) {
        echo "function: modBr<br/>";
        echo "setup error: val is not set correctly";
    }
    if (!isset($conf_br)) {
        echo "function: modBr<br/>";
        echo "setup error: conf_br is not set correctly";
    }
    // Start a var
    $var = FALSE;
    // Split out the number - If we want to switch this add an op to the conf_br
    $mod_no = splitItemval($val);
    // Get the mod type for this item
    $mod = substr($key, 0, 3);
    $modtype = getModType($mod, $val);
    if (array_key_exists('type_'.$modtype.'_L',$conf_br) AND array_key_exists('type_'.$modtype.'_R',$conf_br)) {
        $var = $conf_br['type_'.$modtype.'_L'];
        $var .= $mod_no;
        $var .= $conf_br['type_'.$modtype.'_R'];
    } else {
        // Just in case there is no bracket set up
        $var = $mod_no;
    }
    if ($var != FALSE) {
        return ($var);
    } else {
        return FALSE;
    }
}

// }}}
// {{{ outpList()

/**
* returns an xhtml list from a php array
*
* @param string $list_type  either ul or ol
* @param string $list_id  optional id value for the list
* @param string $list_class  optional css class for the list
* @param string $item_class  optional css class for the items
* @param array $values  a simple array of values
* @param string $return_mode  code or html
* @return void
* @author Guy Hunt
* @since 0.4
*
* FIXME: Remove the output mode and simply return a string
*
*/

function outpList($list_type, $list_id, $list_class, $item_class, $values, $return_mode)
{
    $list_head = "<$list_type$list_id$list_class>\n";
    if ($return_mode == 'code') {
        if ($li_class) {
            $item_class = " class=\"$li_class\"";
        }
        $list_foot = "</$list_type>\n";
        $list = $list_head;
        foreach ($values AS $val) {
            // printf ("hello $val");
            $list = $list."<li$item_class>$val</li>\n";
        }
        $list = $list.$list_foot;
        return ($list);
    }
}

// }}}
// {{{ pageResults()

/**
* pages a results array for display
*
* @param array $results_array  containing the unpaged results
* @param array $page  the current page being displayed
* @param array $limit  the number of records by page
* @return array $array  containing  ['paged_results'] the relevant slice of the results
*                                   ['total'] the number of pages available
*                                   ['page'] the current page
* @author Stuart Eve
* @since 0.3
*
*/

function pageResults($results_array, $page, $limit)
{
    $fpage = $page-1;
    if ($fpage < 0) {
        $fpage = 0;
    }
    if ($total = count($results_array)) {
        // 1 - Set up the paging basics
        //  now we need to divide that total by the number of records we wish
        //  to display - to get the total number of pages
        $num_pages = ceil($total/$limit);
        // 2 - slice up the array
        //  check if we are on a specific page
        if ($fpage) {
            $start_at = $fpage*$limit;
        } else {
            //presume we are on the first page
            $start_at = 0;
        }
        // now slice the array
        $paged_results = 
            array_slice(
                $results_array,
                $start_at,
                $limit
        );
        // array slice will return a blank array if there is only one page
        if (empty($paged_results)) {
            $paged_results = $results_array;
        }
        // 3 - Set up the values to return
        $array['paged_results'] = $paged_results;
        $array['total_results'] = $total;
        $array['total'] = $num_pages;
        $array['page'] = $fpage+1;
        // 4 - Return cleanly
        return $array;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ parseXMPfile()

/**
* this function parses an XMP sidecar file and extracts the data into an array
*
* @param string $filename  the full path to the XMP file
* @return array $xmp_parsed  the array containing the XMP metadata
* @author Stuart Eve
* @since 1.1
*
* This function was adapted from http://snipplr.com/view/30063/
* 
* The list of pages is limited to an admin defined number = n. In the case of over
*
*/

function parseXMPfile($filename)
{
    global $fu;
    $file = fopen($filename, 'r');
    $source = fread($file, filesize($filename));
    $xmpdata_start = strpos($source,"<x:xmpmeta");
    $xmpdata_end = strpos($source,"</x:xmpmeta>");
    $xmplenght = $xmpdata_end-$xmpdata_start;
    $xmpdata = substr($source,$xmpdata_start,$xmplenght+12);
    fclose($file);
    
    $xmp_parsed = array();
 
    foreach ($fu['metadata_conf'] as $key => $k) {
        unset($r);
        preg_match ($k["regexp"], $xmpdata, $r);
        $xmp_item = @$r[1];
        $xmp_parsed[$k['field']] = $xmp_item;
        global $$k['field'];
        //printPre($$k['field']);
    }
    return $xmp_parsed;
}

// }}}
// {{{ prcsTabCols()

/**
* processes the columns array for use in tabbed views
*
* @param array $cols  an ARK standard columns array
* @return array $cols  a processed ARK standard columns array
* @author Guy Hunt
* @since v1.1
*
*/

function prcsTabCols($cols)
{
    if (!is_array($cols)) {
        echo "ADMIN ERROR: no column array sent to prcsTabCols()<br/>";
    }
    
    // include the main settings
    include('config/settings.php');
    // pre-process out any XMI columns as these will add in extra elements to the array and therefore mess up keys
    foreach ($cols as $key => $col) {
        switch ($col['col_type']) {
            case 'xmi':
                // include the module settings
                include("config/mod_{$col['xmi_mod']}_settings.php");
                // get the XMIed items
                global $item_key, $$item_key;
                $xmi_list = getXmi($item_key, $$item_key, $col['xmi_mod']);
                if (!$xmi_list) {
                    // if there are no XMIs, drop out of this routine
                    unset ($cols[$key]);
                    break;
                }
                foreach ($xmi_list as $xmikey => $xmi) {
                    // get the conf
                    $col_conf_name = $col['xmi_col_name'];
                    $new_col = $$col_conf_name;
                    // evaluate any conditions - otherwise assume the column can go in by default
                    // assume it is displayed
                    $displ_flag = TRUE;
                    if (array_key_exists('op_condition', $col)) {
                        // check the condition
                        if (!chkSfCond($xmi['xmi_itemkey'], $xmi['xmi_itemvalue'], $col['op_condition'])) {
                            $displ_flag = FALSE;
                        }
                    }
                    // set up the col_id dynamically
                    $new_col['col_id'] = "{$xmi['xmi_itemkey']}-{$xmi['xmi_itemvalue']}";
                    // flag this as needing an alternative sf_key to the page
                    $new_col['col_sf_key'] = $xmi['xmi_itemkey'];
                    // flag this as needing an alternative sf_val for SFs
                    $new_col['col_sf_val'] = $xmi['xmi_itemvalue'];
                    $new_col['col_type'] = 'xmi';
                    // a title for the column (either the results of a field or markup)
                    if (!is_array($new_col['col_mkname'])) {
                        $new_col['tab_text'] = getMarkup('cor_tbl_markup', $lang, $new_col['col_mkname']);
                    } else {
                        $new_col['tab_text'] = resTblTd($new_col['col_mkname'], $new_col['col_sf_key'], $new_col['col_sf_val']);
                    }
                    if ($displ_flag) {
                        // insert this into the new_cols array
                        $new_cols[] = $new_col;
                    }
                    unset ($displ_flag);
                }
                // sort the new_cols on some criteria
                if (array_key_exists('op_col_sort', $col)) {
                    if ($col['op_col_sort'] && is_array($col['op_col_sort'])) {
                        // sort on a field
                        if (is_array($col['op_col_sort']['sort_on'])) {
                            // sort by a specified field of this module - GH 6/2/2012
                            echo "ADMIN ERROR: sorting on a field is not yet working<br/>";
                            // first retrieve the sort criterion (as per results table)
                            // the sort the array on the returned data field
                            // $new_cols = sortResArr($new_cols, $col['op_col_sort']['sort_type'], 'sort_on');
                        // sort on the column name
                        } elseif ($col['op_col_sort']['sort_on'] == 'col_name') {
                            $new_cols = sortResArr($new_cols, $col['op_col_sort']['sort_type'], 'tab_text');
                        }
                    }
                }
                
                // insert the $new_cols into the cols array as a bundle
                $head = array_slice($cols, 0, $key);
                $tail = array_slice($cols, $key);
                // remove the XMI col itself from the beginning of the tail
                $trashcan = array_shift($tail);
                
                unset($cols);
                $cols = array_merge($head, $new_cols, $tail);
                
                break;
        }
    }
    // loop over each column and process as appropriate
    foreach ($cols as $key => $col) {
        // if the col is conditional
        if (array_key_exists('op_condition', $col)) {
            // check the condition
            if (chkSfCond($item_key, $$item_key, $col['op_condition'])) {
                // do nothing, leave the col alone
            } else {
                // flag this for removal (by being ignored)
                $col['col_type'] = 'junk';
                // remove the col
                unset ($cols[$key]);
            }
        }
        // switch for each col type
        switch ($col['col_type']) {
            case 'primary_col':
            case 'secondary_col':
            case 'link':
                global $item_key, $$item_key, $lang;
                // establish the sf_key and val of this column
                $cols[$key]['col_sf_key'] = $item_key;
                $cols[$key]['col_sf_val'] = $$item_key;
                // a title for the column (either the results of a field or markup)
                if (!is_array($col['col_mkname'])) {
                    $cols[$key]['tab_text'] = getMarkup('cor_tbl_markup', $lang, $col['col_mkname']);
                } else {
                    $cols[$key]['tab_text'] = resTblTd($col['col_mkname'], $item_key, $$item_key);
                }
                break;
                
            case 'embedded':
                // include the module settings
                include("config/mod_{$col['emb_mod']}_settings.php");
                // substitute the requested column in the array
                $col_conf_name = $col['emb_col_name'];
                $cols[$key] = $$col_conf_name;
                // flag this as needing an alternative sf_key to the page
                $cols[$key]['col_sf_key'] = $col['emb_mod'].'_cd';
                // probably doesnt need a specific item
                $cols[$key]['col_sf_val'] = FALSE;
                // a title for the column
                $cols[$key]['tab_text'] = getMarkup('cor_tbl_markup', $lang, $col['col_mkname']);
                break;
                
            case 'xmi':
                // do nothing... see above
                break;
                
            case 'junk':
                // do nothing... see above
                break;
                
            default:
                echo "ADMIN ERROR: 'col_type' must be set as one of:<br/>";
                echo "primary | secondary | embedded | xmi | link<br/>";
                echo "Documentation: http://ark.lparchaeology.com/wiki/index.php/ARK_columns<br/>";
                echo "Key: $key<br/>";
                echo "Col:<br/>";
                printPre($col);
                break;
        }
    }
    
    // return
    return($cols);
}

// }}}
// {{{ printError()

/**
* prints out the human readable error element ('vars')
*
* @param array $error  an array containing vars 
* @return void
* @author Stuart Eve
* @since 0.6
*
* Note: this error print function was an inc script from v0.1 to 0.6
*
* DEV NOTE: This needs renaming to the standard mkBlah() style GH 19/10/10
*
*/

function printError($error)
{
    $var = '<div id="error">';
    foreach ($error as $err) {
        $var .= "<p class=\"error\">{$err['vars']}</p>";
    }
    $var .= '</div>';
}

// }}}
// {{{ printPre()

/**
* runs print_r within <pre> tags to make it more readable to humans
*
* @param array $array  the array to print
* @return void
* @author Guy Hunt
* @since 0.4
*/

function printPre($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

// }}}
// {{{ processFiles()

/**
* processes a set of files (thumbnailing, registering and renaming) 
*
* @param string $dir  the dir containing the file
* @param string $batch  the batch to assign the file to
* @param string $mod  the module to assign the file to
* @param string $cre_by  the cre by
* @param string $cre_on  the cre on
* @param array $size  an array containing the thumbnail sizes (if you want to specify them)
* @param string $orig_file_dir  if you want to store the main files somewhere else you can specify it here
* @param array $list  if you want to overide the file browser with a user-defined list OPTIONAL
* @return int $total  the total number of files processed
* @author Stuart Eve (stuarteve@lparchaeology.com)
* @author Hembo Pagi (hembo.pagi@arheovisioon.ee)
* @author Guy Hunt (guy.hunt@lparchaeology.com)
* @since 0.6
*
* NOTE 1: MAJOR rewrite at v1.1 by GH
*
* The logic involves three big questions as follows:
* 1 - Location of the files - local or remote
* 2 - What you want to do with the files - just add them to the system, register them to items, etc
* 3 - How to make the thumbs, is conversion needed? should the file be skipped? clean up?
*
*/

function processFiles($dir, $batch, $mod, $cre_by, $cre_on, $size=FALSE, $orig_file_dir=FALSE, $list=FALSE)
{
    // this is gonna take some processor power!
    ini_set("memory_limit", "1600M");
    ini_set("max_execution_time", "36000");
    
    // globals
    global $registered_files_dir, $fu, $phmagick_file, $lang, $pdfthumbgrid;
    
    // markup
    $mk_not_accessible = getMarkup('cor_tbl_markup', $lang, 'file_not_accessible');
    
    // pre-flight checks
    // ste_cd - site code plus default (not the same as reqArkVar())
    $ste_cd = reqQst($_REQUEST, 'ste_cd');
    if (!$ste_cd) {
        global $default_site_cd;
        $ste_cd = $default_site_cd;
    }
    // filetype - file type
    $filetype = reqQst($_REQUEST, 'filetype');
    if (!$filetype) {
        $ret['setup']['err'] = 'filetype needed in qrystr';
        return $ret;
    }
    // upload_method - upload method
    $upload_method = reqQst($_REQUEST, 'upload_method');
    // registered_files_dir - check that the registered files directory is set and exists
    if (isset($registered_files_dir)) {
        if (!file_exists($registered_files_dir)) {
            $ret['setup']['err'] = "ADMIN ERROR: registered_files_dir '$registered_files_dir' does not exist<br/>";
            return $ret;
        }
    } else {
        $ret['setup']['err'] = "ADMIN ERROR: no registered_files_dir conf variable is set<br/>";
        return $ret;
    }
    
    // pattern name for pattern matching
    $pattern_name = reqQst($_REQUEST, 'pattern_name');
    
    // construct some handy variables
    $mod_tbl = $mod.'_tbl_'.$mod;
    $mod_cd = $mod.'_cd';
    
    // set up variables to hold user feedback info
    $nottobeprocessed = FALSE;
    $ret = FALSE;
    $not_reg = 0;
    $tot_proc = 0;
    $tot_files = 0;
    
    // Logic part 1 - are the files local or remote?
    // get a list of the files to be processed ($list may have been passed manually)
    if (!is_array($list)) {
        $list = dirList($dir);
    }
    // URI root, is a key that indicates that the files are remote
    if (array_key_exists('uri_root', $list)) {
        // files are not local
        // set up the source file location path
        $sflp = $list['uri_root'];
        // flag this as an import of remote files
        $file_location = 'remote';
        // remove the flag to prevent confusion
        unset($list['uri_root']);
    } else {
        // files are local
        // set up the source file location path
        $sflp = $dir;
        // flag this as an import of local files
        $file_location = 'local';
    }
    // pop a slash on if there isn't one already
    if (substr($sflp, -1) != DIRECTORY_SEPARATOR && $sflp != '') {
        $sflp = $sflp.DIRECTORY_SEPARATOR;
    }
    
    // Logic part 2 - what do we need to do with the files
    $ret['upload_method'] = $upload_method;
    switch ($upload_method) {
        case "s": // 'simple'
            $check_for_item = FALSE; // don't even look for matching items, just add the files
            // therefore set these flags up now for all files within the process loop
            $add_to_lut = TRUE; // add file to lut
            $reg_new_item = FALSE; // don't register a new item
            $add_to_cor_tbl = FALSE; // don't add anything to the cor_tbl
            break;
            
        case "a": // 'autoregister'
            $check_for_item = TRUE; // look for matching items
            // what to do if there is no existing item
            $wtditinei = 'reg_new_item';
            // the auto register may add new items to the specified module
            // this requires an additional check for modtype
            if (chkModType($mod)) {
                $modtype = reqQst($_REQUEST, 'modtype');
                if (!$modtype) {
                    $ret['setup']['err'] = 'modtype needed for this module';
                    return $ret;
                }
            } else {
                $modtype = FALSE;
            }
            break;
            
        case "c": // 'just_add_file' (previously known as 'create links')
            $check_for_item = TRUE; // look for matching items
            // what to do if there is no existing item
            $wtditinei = 'just_add_file';
            break;
            
        case "l": // only add linked files (skip over files that don't match existing items)
            $check_for_item = TRUE; // look for matching items
            // what to do if there is no existing item
            $wtditinei = 'nothing'; // skip any non matching files
            break;
    }
    
    // Logic part 3 - deal with thumbs and clean up
    
    // if size has not been set, use some defaults
    if (!$size) {
        $size =
            array(
                'arkthumb_width' => 240,
                'arkthumb_height' => 240,
                'webthumb_width' => 1000,
                'webthumb_height' => 1000,
        );
    }
    
    // test for the presence of phMagick
    if (isset($phmagick_file)) {
        if (is_file($phmagick_file)) {
            $phMagickAvailable = TRUE;
            include_once $phmagick_file;
        } else {
            $phMagickAvailable = FALSE;
        }
    } else {
        $phMagickAvailable = FALSE;
    }
    
    
    // PROCESS & CRUNCH
    // this is a 2 part process:
    // 1 - 'process' Database interactions
    // 2 - 'crunch' File handling
    
    // loop over each file in the list
    foreach ($list as $key => $file) {
        // Preliminaries, common stuff
        // flag process on for each time over the loop
        $process = TRUE;
        // flag to assume the file needs to be crunched
        $crunch_file = TRUE;
        // set up the fully resolved file path of the source file
        $frposf = $sflp . $file;
        // if it is a remote file, also set up the URI
        $uri_id = FALSE;
        if ($file_location == 'remote') {
            $uri = $frposf;
            //check that this file hasn't already been uploaded
            $uri_id = getSingle('id', 'cor_lut_file', 'uri = "' . $uri . '"');
        } else {
            $uri = FALSE;
        }
        
        // get the file extension
        $exploded_file = explode('.', $file);
        $file_ext = strtolower(end($exploded_file));
        // normalize spellings
        if ($file_ext == 'tiff') {
            $file_ext = 'tif';
        }
        if ($file_ext == 'jpeg') {
            $file_ext = 'jpg';
        }
        // check if we can access the file to actually import it
        if (is_readable($frposf)) {
            $process = TRUE;
        } elseif (@fopen($uri, 'r') != FALSE) {
            $process = TRUE;
        } else {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['err'][] = $mk_not_accessible.': '.$frposf;
        }
        
        // if it has already been uploaded then we don't want to process it again
        if ($uri_id) {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = 'already exists in database';
        }
        
        // check and skip over undesirable files like hidden stuff
        if (substr($file, 0, 1) == '.') {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = 'hidden_file';
        }
        if (count($exploded_file) < 1) {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = 'dots in filename';
        }
        if ($file_ext =='db') {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = 'windows thumb.db file';
        }
        if ($file_ext =='xmp') {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = 'XMP metadata file';
        }
        if (is_dir($frposf)) {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = 'directory';
        }
        
        // PROCESS
        if ($process == 1) {
            // -- PART 1 - DB interactions -- //
            if ($check_for_item) {
                // try to match/extract an item_key from the filename
                $matching_item = fuPatternMatch($file, $fu, $pattern_name);
                $ret['files'][$file]['matches'] = $matching_item;
                // fuPatternMatch() may return an array (if files have been named according to a
                // specific and undocumented arrangement...) in this case the module is adapted
                if (is_array($matching_item)) {
                    $mod_id_arr = $matching_item;
                    $matching_item = (int)$mod_id_arr[2];
                    $mod_cd = $mod_id_arr[0] . "_cd";
                    $mod_tbl = $mod_id_arr[0] . "_tbl_" . $mod_id_arr[0];
                    $ste_cd = $mod_id_arr[1];
                }
                // if this has resulted in a matching_item, proceed
                if ($matching_item) {
                     // try to split the site code off
                    if (!splitItemval($matching_item)) {
                        // the match has no site code yet
                        $matching_item = $ste_cd.'_'.$matching_item;
                    } else {
                        $item_explode = explode('_',$matching_item);
                        if (is_array($item_explode)) {
                            $matching_item = $item_explode[0] . '_' . (int)$item_explode[1];
                        }
                    }
                    // check if the item is already registered and valid on ARK
                    if (!chkValid($matching_item, 0, 0, $mod_tbl, $mod_cd)) {
                        $existing_item = $matching_item;
                    } else {
                        // set existing item as FALSE
                        $existing_item = FALSE;
                        // do not set matching item as false as it may be needed to register items below
                    }
                } else {
                    $existing_item = FALSE;
                }
                // if the item exists on the DB, proceed
                if ($existing_item) {
                    // order up the relevant process
                    $add_to_lut = TRUE; // add file to lut
                    $reg_new_item = FALSE; // don't register a new item
                    $add_to_cor_tbl = TRUE; // add to the cor_tbl
                } else {
                    $existing_item = FALSE;
                    // what to do if there is no existing item
                    switch ($wtditinei) {
                        case 'nothing':
                            $add_to_lut = FALSE; // don't add anything to the lut
                            $reg_new_item = FALSE; // don't register a new item
                            $add_to_cor_tbl = FALSE; // don't add anything to the cor_tbl
                            $crunch_file = FALSE; // not futz with the file
                            //$nottobeprocessed = TRUE; // let the feedback table know this is not to be processed at all
                            break;
                        case 'just_add_file':
                            $add_to_lut = TRUE; // add file to lut
                            $reg_new_item = FALSE; // don't register a new item
                            $add_to_cor_tbl = FALSE; // don't add anything to the cor_tbl
                            break;
                        case 'reg_new_item':
                            $add_to_lut = TRUE; // add file to lut
                            $reg_new_item = TRUE; // register a new item based on match
                            $add_to_cor_tbl = TRUE; // add to the cor_tbl
                            break;
                    }
                }
            } else {
                $existing_item = FALSE;
                // as there is no check for item, do not modify any flags within the foreach
                // just carry on using the variables set at the top
            }
            
            // MAKE the additions as needed
            // add to the lut
            if ($add_to_lut) {
                $results = registerFile($file, $filetype, $batch, $mod, $cre_by, $cre_on, $uri);
                $ret['files'][$file]['process']['lut']['message'] = 'file added to lut';
                $ret['files'][$file]['process']['lut']['results'] = $results;
            } else {
                // feedback the fact that nothing was added
                $ret['files'][$file]['process']['lut']['message'] = 'file NOT added to lut';
                // don't try to crunch the file
                $crunch_file = FALSE;
            }
            // register new items with the module
            if ($reg_new_item) {
                // if we want to register a new item then we need to add the item and
                // pass the id down the chain
                // register the match as a new item
                if ($matching_item) {
                    // register a new item as per the match
                    $itemval = $matching_item;
                } else {
                    // register the next available number
                    $itemval = $ste_cd . '_next';
                }
                if ($modtype) {
                    $reg_res = addItemKey($mod_cd, $itemval, $cre_by, $cre_on, $modtype);
                } else {
                    $reg_res = addItemKey($mod_cd, $itemval, $cre_by, $cre_on);
                }
                //From Brandon and Jessica re hard-coding in the text type: This is ugly, get over it
                registerFileName(177, $mod_cd, $itemval, $file, $lang, $cre_by, $cre_on);
                
                if ($reg_res['success'] == TRUE) {
                    $ret['files'][$file]['process']['reg'] = $reg_res;
                    $existing_item = $reg_res['new_itemvalue'];
                } else {
                    $ret['files'][$file]['process']['reg']['message'] = "the new item could not be created [{$reg_res['failed_sql']}]";
                    $add_to_cor_tbl = FALSE;
                }
            }
            // add file->item link into the cor_tbl
            if ($add_to_cor_tbl && $results['new_id'] != '') {
                $results_rf = addFile($mod_cd, $existing_item, $results['new_id'], $cre_by, $cre_on);
                $ret['files'][$file]['process']['cor_tbl']['results'] = $results_rf;
                $ret['files'][$file]['process']['cor_tbl']['results']['linked_item'] = "Linked to $mod_cd - $existing_item"; 
            } else {
                // feedback the fact that nothing was added
                if (empty($ret['files'][$file]['process']['cor_tbl'])) {
                    $ret['files'][$file]['process']['cor_tbl'] = 'the file will not be linked to an existing item';
                }
            }
            // add metadata
            // optionally, metadata can be extracted from the upload at this stage and added to the
            // relevant record
            if (array_key_exists('metadata_conf', $fu)) {
                // try to fetch the metadata from the specified location for this file
                //let's check for an associated XMP file first
                if (is_readable("$dir/{$exploded_file[0]}.xmp")) {
                    $xmp_array = parseXMPfile("$dir/{$exploded_file[0]}.xmp");
                    
                    //go through and add the metadata
                    
                    
                    
                    $ret['files'][$file]['metadata'] = $xmp_array;
                    
                } else {
                    $ret['files'][$file]['metadata'] = "No metadata available (No XMP file?)";
                }
                // loop over each requested field and try to add it
                
            }
            
            
            // -- PART 2 - FILE HANDLING -- //
            // Thumbs are made from .jpg files. If the original is not a jpg and thumbs are 
            // still required it must be converted, image magick is needed for this. Some
            // files do not use thumbs (eg Word docs)
            $convertible = array('tif', 'pdf', 'png');
            if ($file_ext != 'jpg') {
                // decide if this file is to be converted to jpg for thumbnail creation
                if (in_array($file_ext, $convertible)) {
                    if ($phMagickAvailable) {
                        $convert = TRUE;
                        $make_thumb = TRUE;
                        $ret['files'][$file]['crunch']['convertible'] = 'conversion requested, try to make thumb';
                    } else {
                        $convert = FALSE;
                        $make_thumb = FALSE;
                        $ret['files'][$file]['crunch']['convertible'] = "no phMagick (at: $phmagick_file), do not make thumb";
                    }
                } else {
                    $convert = FALSE;
                    $make_thumb = FALSE;
                    $ret['files'][$file]['crunch']['convertible'] = "$file_ext is not convertible, do not make thumb";
                }
            } else {
                $convert = FALSE;
                $make_thumb = TRUE;
                $ret['files'][$file]['crunch']['convertible'] = 'file is jpg, try to make thumb';
            }
            
            // skip files that are reflections or arkthumbs already exist 
            if (substr($file,0,9) == 'arkthumb_' OR substr($file,0,5) == 'refl_') {
                $skip_file = TRUE;
            } else {
                $skip_file = FALSE;
            }
            
            // if conversion is required and there is no reason to skip this file, process it
            // set up a flag to show whether a conversion took place
            $converted = FALSE;
            // do the crunching
            if ($crunch_file && $convert && !$skip_file) {
                // do the process
                $phMagick = new phMagick($frposf, $registered_files_dir.DIRECTORY_SEPARATOR.$results['new_id'].'.jpg');
                $phMagick->convert();
                // get the results
                $phMagickLog = $phMagick->getLog();
                // if the conversion was successful, make the thumbnails
                if (!$phMagickLog[0]['return']) {
                    $make_thumb = TRUE;
                    $converted = TRUE;
                    //change the name of the file_handler to be the .jpg
                    $frposf_converted = $registered_files_dir.DIRECTORY_SEPARATOR.$results['new_id'].'.jpg';
                    // test for file
                    if (!file_exists($frposf_converted)){
                        // if the file does not exist we are probably dealing with a multi page image
                        if (!isset($pdfthumbgrid)){
                            //set up a default thumbgrid array incase one is not defined in page_settings
                            $pdfthumbgrid = array(
                                   'width' => 1,
                                   'height' => 1
                            );
                        }
                        // calculate the number of pages needed in the grid
                        $thumbnailsize= $pdfthumbgrid['width']*$pdfthumbgrid['height'];
                        // For single page thumbnails
                        if ($thumbnailsize==1){
                            //delete all jpgs apart from the first page 
                            foreach ( glob($registered_files_dir.DIRECTORY_SEPARATOR.$results['new_id']."-[1-9]*.jpg") as $unwantedjpg ) {
                                unlink($unwantedjpg);
                            }
                            // set the new image path to the converted file
                            $frposf_converted = $registered_files_dir.DIRECTORY_SEPARATOR.$results['new_id'].'-0.jpg';
                        // for multi page thumbnails
                        } else {
                            //remove all the jpegs 
                            foreach ( glob($registered_files_dir.DIRECTORY_SEPARATOR.$results['new_id']."-[0-9]*.jpg") as $unwantedjpg ) {
                                unlink($unwantedjpg);
                            }
                            
                            // create png of the image, phmagick tiling function does not work with jpeg
                            $phMagick = new phMagick($frposf, $registered_files_dir.DIRECTORY_SEPARATOR.$results['new_id'].'.png');
                            $phMagick->convert();
                            // create an array to hold references to our images
                            $paths = array ();
                            // add files to the paths array until its length matches the number of images required
                            while ( $thumbnailsize > count($paths) ) {
                                $paths [] = $registered_files_dir.DIRECTORY_SEPARATOR.$results['new_id'].'-'.count($paths).'.png';
                            }
                            // do the tiling operation
                            $tiler = new phMagick();
                            $tiler->setDestination($registered_files_dir.DIRECTORY_SEPARATOR.$results['new_id'].'.jpg')->tile($paths, $pdfthumbgrid ['width'], $pdfthumbgrid ['height']);
                            $frposf_converted = $registered_files_dir.DIRECTORY_SEPARATOR.$results['new_id'].'.jpg';
                            // delete all the png files created
                            foreach ( glob($registered_files_dir.DIRECTORY_SEPARATOR.$results['new_id']."-[0-9]*.png") as $workingpng ) {
                                unlink($workingpng);
                            }
                        }
                    }
                    // feedback
                    $ret['files'][$file]['crunch']['conversion'] = 'requested conversion succeeded';
                } else {
                    $make_thumb = FALSE;
                    // feedback
                    $op = $phMagickLog[0]['output'][0];
                    $ret['files'][$file]['crunch']['conversion']['err'] = "requested conversion failed ($op)";
                }
            }
            
            // Now make the thumbs
            if ($crunch_file && $make_thumb && !$skip_file) {
                // arkthumb (for imageflow)
                $tgt_img1 = $registered_files_dir.DIRECTORY_SEPARATOR.'arkthumb_'.$results['new_id'].'.jpg';
                    // if we have converted the file then make sure we use the converted filename
                if ($converted == TRUE) {
                    $arkthumb = new imagick($frposf_converted);
                    /* create the thumbnail */
                    $arkthumb->cropThumbnailImage($size['arkthumb_width'], $size['arkthumb_height']);
                    /* Write to a file */
                    $arkthumb->writeImage($tgt_img1);
                } else {
                    $arkthumb = new imagick($frposf);
                    /* create the thumbnail */
                    $arkthumb->cropThumbnailImage($size['arkthumb_width'], $size['arkthumb_height']);
                    /* Write to a file */
                    $arkthumb->writeImage($tgt_img1);
                }
                $ret['files'][$file]['crunch']['arkthumb']['result'] = $tgt_img1;
                // webthumb (for lightbox)
                $tgt_img2 = $registered_files_dir.DIRECTORY_SEPARATOR.'webthumb_'.$results['new_id'].'.jpg';
                    // if we have converted the file then make sure we use the converted filename
                if ($converted == TRUE) {
                    $arkthumb = new imagick($frposf_converted);
                    $webthumb = new imagick($frposf_converted);
                } else {
                    $arkthumb = new imagick($frposf);
                    $webthumb = new imagick($frposf);
                }
                /* rotate the images based on its exif*/
                autoRotateImage($arkthumb);
                autoRotateImage($webthumb);
                /* create the thumbnails */
                $arkthumb->thumbnailImage($size['arkthumb_width'], $size['arkthumb_height'], TRUE, TRUE);
                $webthumb->thumbnailImage($size['webthumb_width'], $size['webthumb_height'], TRUE);
                /* Write to files */
                $arkthumb->writeImage($tgt_img1);
                $webthumb->writeImage($tgt_img2);
                /* Store the filename in the return */ 
                $ret['files'][$file]['crunch']['arkthumb']['result'] = $tgt_img1;
                $ret['files'][$file]['crunch']['webthumb']['result'] = $tgt_img2;
            } else {
                $ret['files'][$file]['crunch']['thumbs']['message'] = "thumbs not made";
            }
            // move the file itself
            if ($crunch_file && $file_location == 'local') {
                // $orig_file_dir is a specified location for files other than the $registered_files_dir default
                if ($orig_file_dir) {
                    $filestore_folder = $orig_file_dir;
                } else {
                    $filestore_folder = $registered_files_dir;
                }
                $tgt_file = "{$filestore_folder}DIRECTORY_SEPARATOR{$results['new_id']}.$file_ext";
                // move (copy and delete) the file from the original loaction to the filestore
                if ($cpres = copy($frposf, $tgt_file)) {
                    // feedback
                    $ret['files'][$file]['crunch']['copy']['result'] = $tgt_file;
                    // tidy up
                    unlink($frposf);
                } else {
                    $ret['files'][$file]['crunch']['copy']['error'] = 'file not copied to store';
                    $ret['files'][$file]['crunch']['copy']['source'] = $frposf;
                    $ret['files'][$file]['crunch']['copy']['dest'] = $tgt_file;
                }
            }
            if ($crunch_file) {
                // remove converted files
                if($converted){
                    unlink($frposf_converted);
                }
                // feedback
                $ret['files'][$file]['crunch']['cleanup'] = 'clean up done';
            }
            //wipe out the process array if we are not supposed to be doing anything with this file
            if ($nottobeprocessed) {
                $ret['files'][$file]['message'][] = 'no matching item - not to be processed';
                unset($ret['files'][$file]['process']);
            }
            // increment the total and collect feedback
            $tot_proc++;
        } // end of process
        $tot_files++;
    } // end of foreach
    $ret['tot_files'] = $tot_files;
    $ret['tot_proc'] = $tot_proc;
    
    // return
    if ($ret){
        return $ret;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ processFilesDry()
/**
* this function runs the requisite pre-flight checks to see if a list of files will process
*
* @param string $dir  the dir containing the file
* @param string $batch  the batch to assign the file to
* @param string $mod  the module to assign the file to
* @param string $cre_by  the cre by
* @param string $cre_on  the cre on
* @param array $size  an array containing the thumbnail sizes (if you want to specify them)
* @param string $orig_file_dir  if you want to store the main files somewhere else you can specify it here
* @param array $list  if you want to overide the file browser with a user-defined list OPTIONAL
* @return array $ret  an array containing the results
* @author Stuart Eve (stuarteve@lparchaeology.com)
* @since 1.1
*
* NOTE 1: This should be used as a check before running the processFiles() function
*
* The logic involves three big questions as follows:
* 1 - Location of the files - local or remote
* 2 - What you want to do with the files - just add them to the system, register them to items, etc
* 3 - How to make the thumbs, is conversion needed? should the file be skipped? clean up?
*
*/

function processFilesDry($dir, $batch, $mod, $cre_by, $cre_on, $size=FALSE, $orig_file_dir=FALSE, $list=FALSE)
{
    
    // globals
    global $registered_files_dir, $fu, $phmagick_file, $lang;
    
    ini_set("max_post_size","1000M");
    
    // markup
    $mk_not_accessible = getMarkup('cor_tbl_markup', $lang, 'file_not_accessible');
    
    // pre-flight checks
    // ste_cd - site code plus default (not the same as reqArkVar())
    $ste_cd = reqQst($_REQUEST, 'ste_cd');
    if (!$ste_cd) {
        global $default_site_cd;
        $ste_cd = $default_site_cd;
    }
    $ret['messages'][] = "Site Code to be used = $ste_cd";
    // filetype - file type
    $filetype = reqQst($_REQUEST, 'filetype');
    if (!$filetype) {
        $ret['fatal'][] = "no filetype has been specified - this will be needed";
    }
    // upload_method - upload method
    $upload_method = reqQst($_REQUEST, 'upload_method');
    // registered_files_dir - check that the registered files directory is set and exists
    if (isset($registered_files_dir)) {
        if (!file_exists($registered_files_dir)) {
            $ret['fatal'][] = "registered_files_dir '$registered_files_dir' does not exist";
        }
    } else {
        $ret['messages'][] = "no registered_files_dir was set in the conf";
    }
    
    // pattern name for pattern matching
    $pattern_name = reqQst($_REQUEST, 'pattern_name');
    
    // construct some handy variables
    $mod_tbl = $mod.'_tbl_'.$mod;
    $mod_cd = $mod.'_cd';
    
    // set up variables to hold user feedback info
    $nottobeprocessed = FALSE;
    $ret = FALSE;
    $not_reg = 0;
    $tot_proc = 0;
    $tot_files = 0;
    
    // Logic part 1 - are the files local or remote?
    // get a list of the files to be processed ($list may have been passed manually)
    if (!is_array($list)) {
        $list = dirList($dir);
    }
    // URI root, is a key that indicates that the files are remote
    if (array_key_exists('uri_root', $list)) {
        // files are not local
        // set up the source file location path
        $sflp = $list['uri_root'];
        // flag this as an import of remote files
        $file_location = 'remote';
        // remove the flag to prevent confusion
        unset($list['uri_root']);
    } else {
        // files are local
        // set up the source file location path
        $sflp = $dir;
        // flag this as an import of remote files
        $file_location = 'local';
    }
    // pop a slash on if there isn't one already
    if (substr($sflp, -1) != DIRECTORY_SEPARATOR && $sflp != '') {
        $sflp = $sflp.DIRECTORY_SEPARATOR;
    }
    $ret['messages'][] = "We will be using $file_location files at $sflp";
    
    // Logic part 2 - what do we need to do with the files
    $ret['messages'][] = "Upload Method: $upload_method";
    switch ($upload_method) {
        case "s": // 'simple'
            $check_for_item = FALSE; // don't even look for matching items, just add the files
            // therefore set these flags up now for all files within the process loop
            $add_to_lut = TRUE; // add file to lut
            $reg_new_item = FALSE; // don't register a new item
            $add_to_cor_tbl = FALSE; // don't add anything to the cor_tbl
            break;
            
        case "a": // 'autoregister'
            $check_for_item = TRUE; // look for matching items
            // what to do if there is no existing item
            $wtditinei = 'reg_new_item';
            // the auto register may add new items to the specified module
            // this requires an additional check for modtype
            if (chkModType($mod)) {
                $modtype = reqQst($_REQUEST, 'modtype');
                if (!$modtype) {
                    $ret['fatal'][] = "As this is autoregister mode, a modtype needed for this module";
                }
            }
            break;
            
        case "c": // 'just_add_file' (previously known as 'create links')
            $check_for_item = TRUE; // look for matching items
            // what to do if there is no existing item
            $wtditinei = 'just_add_file';
            break;
            
        case "l": // only add linked files (skip over files that don't match existing items)
            $check_for_item = TRUE; // look for matching items
            // what to do if there is no existing item
            $wtditinei = 'nothing'; // skip any non matching files
            break;
    }
    // Logic part 3 - deal with thumbs and clean up
    
    // if size has not been set, use some defaults
    if (!$size) {
        $size =
            array(
                'arkthumb_width' => 150,
                'arkthumb_height' => 150,
                'webthumb_width' => 500,
                'webthumb_height' => 500
        );
    }
    
    // test for the presence of phMagick
    if (isset($phmagick_file)) {
        if (is_file($phmagick_file)) {
            $phMagickAvailable = TRUE;
            include_once $phmagick_file;
        } else {
            $phMagickAvailable = FALSE;
        }
    } else {
        $phMagickAvailable = FALSE;
    }
    if ($phMagickAvailable) {
        $ret['messages'][] = "phMagick is available, therefore non-jpegs can be thumbed";
    } else {
        $ret['messages'][] = "phMagick is NOT available, therefore non-jpegs will NOT be thumbed and a default thumbnail will be used by ARK";
    }
    
    // PROCESS & CRUNCH
    // this is a 2 part process:
    // 1 - 'process' Database interactions
    // 2 - 'crunch' File handling
    
    // loop over each file in the list
    foreach ($list as $key => $file) {
        // Preliminaries, common stuff
        // flag process on for each time over the loop
        $process = TRUE;
        // flag to assume the file needs to be crunched
        $crunch_file = TRUE;
        
        // set up the fully resolved file path of the source file
        $frposf = $sflp . $file;
        // if it is a remote file, also set up the URI
        if ($file_location == 'remote') {
            $uri = $frposf;
            //check that this file hasn't already been uploaded
            $uri_id = getSingle('id', 'cor_lut_file', 'uri = "' . $uri . '"');
        } else {
            $uri_id = FALSE;
        }
        
        // get the file extension
        $exploded_file = explode('.', $file);
        $file_ext = strtolower(end($exploded_file));
        // normalize spellings
        if ($file_ext == 'tiff') {
            $file_ext = 'tif';
        }
        if ($file_ext == 'jpeg') {
            $file_ext = 'jpg';
        }
        // check if we can access the file to actually import it
        if (is_readable($frposf)) {
            $process = TRUE;
        } elseif (@fopen($uri, "r") != FALSE) {
            $process = TRUE;
        } else {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = "the file at $frposf $uri is not readable";
        }
        // if it has already been uploaded then we don't want to process it again
        if ($uri_id) {
            $process = FALSE;
            $ret['files'][$file]['message'][] = 'already exists in database';
        }
        
        // check and skip over undesirable files like hidden stuff
            if (substr($file, 0, 1) == '.') {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = 'hidden_file';
        }
        if (count($exploded_file) < 1) {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = 'dots in filename';
        }
        if ($file_ext =='db') {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = 'windows thumb.db file';
        }
        if ($file_ext =='xmp') {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = 'XMP metadata file';
        }
        if (is_dir($frposf)) {
            $process = FALSE;
            $crunch_file = FALSE;
            $ret['files'][$file]['message'][] = 'directory';
        }
        
        // PROCESS
        if ($process == 1) {
            // -- PART 1 - DB interactions -- //
            if ($check_for_item) {
                // try to match/extract an item_key from the filename
                $matching_item = fuPatternMatch($file, $fu, $pattern_name);
                $ret['files'][$file]['process']['matches'] = $matching_item;
                // fuPatternMatch() may return an array (if files have been named according to a
                // specific and undocumented arrangement...) in this case the module is adapted
                if (is_array($matching_item)) {
                    $mod_id_arr = $matching_item;
                    $matching_item = (int)$mod_id_arr[2];
                    $mod_cd = $mod_id_arr[0] . "_cd";
                    $mod_tbl = $mod_id_arr[0] . "_tbl_" . $mod_id_arr[0];
                    $ste_cd = $mod_id_arr[1];
                }
                // if this has resulted in a matching_item, proceed
                if ($matching_item) {
                    // try to split the site code off
                    if (!splitItemval($matching_item)) {
                        // the match has no site code yet
                        $matching_item = $ste_cd.'_'.$matching_item;
                    } else {
                        $item_explode = explode('_',$matching_item);
                        if (is_array($item_explode)) {
                            $matching_item = $item_explode[0] . '_' . (int)$item_explode[1];
                        }
                    }
                    // check if the item is already registered and valid on ARK
                    if (!chkValid($matching_item, 0, 0, $mod_tbl, $mod_cd)) {
                        $existing_item = $matching_item;
                    } else {
                        $ret['files'][$file]['process']['cor_tbl'] = "Trying to link to $matching_item, but this is not a valid item in ARK";
                        $existing_item = FALSE;
                    }
                } else {
                    $ret['files'][$file]['process']['cor_tbl'] = "The regex pattern match has revealed no matching items for this within ARK";
                    $existing_item = FALSE;
                }
                // if the item exists on the DB, proceed
                if ($existing_item) {
                    // order up the relevant process
                    $add_to_lut = TRUE; // add file to lut
                    $reg_new_item = FALSE; // don't register a new item
                    $add_to_cor_tbl = TRUE; // add to the cor_tbl
                    $nottobeprocessed = FALSE;
                } else {
                    $existing_item = FALSE;
                    // what to do if there is no existing item
                    switch ($wtditinei) {
                        case 'nothing':
                            $add_to_lut = FALSE; // don't add anything to the lut
                            $reg_new_item = FALSE; // don't register a new item
                            $add_to_cor_tbl = FALSE; // don't add anything to the cor_tbl
                            $crunch_file = FALSE; // not futz with the file
                            $nottobeprocessed = TRUE;
                            break;
                        case 'just_add_file':
                            $add_to_lut = TRUE; // add file to lut
                            $reg_new_item = FALSE; // don't register a new item
                            $add_to_cor_tbl = FALSE; // don't add anything to the cor_tbl
                            $nottobeprocessed = FALSE;
                            break;
                        case 'reg_new_item':
                            $add_to_lut = TRUE; // add file to lut
                            $reg_new_item = TRUE; // register a new item based on match
                            $add_to_cor_tbl = TRUE; // add to the cor_tbl
                            $nottobeprocessed = FALSE;
                            break;
                    }
                }
            } else {
                $existing_item = FALSE;
                // as there is no check for item, do not modify any flags within the foreach
                // just carry on using the variables set at the top
            }
            
            // MAKE the additions as needed
            // add to the lut
            if ($add_to_lut) {
               // $results = registerFile($file, $filetype, $batch, $mod, $cre_by, $cre_on, $uri);
                $ret['files'][$file]['process']['lut']['message'] = 'This file will be added to ARK';
            } else {
                // feedback the fact that nothing was added
                $ret['files'][$file]['process']['lut']['message'] = 'This file will NOT be added to ARK';
                // don't try to crunch the file
                $crunch_file = FALSE;
            }
            // register new items with the module
            if ($reg_new_item) {
                // if we want to register a new item then we need to add the item and
                // pass the id down the chain
                // register the match as a new item
                if ($matching_item) {
                    // register a new item matching the match
                    $itemval = $matching_item;
                    $existing_item = "a new item ($itemval)";
                } else {
                    // register a 'next'
                    $itemval = $ste_cd . '_next';
                    $existing_item = "the next $mod_cd item";
                }
                $ret['files'][$file]['process']['reg'] = "a new item ($itemval) will be created and this file linked to it";
            }
            // add file->item link into the cor_tbl
            if ($add_to_cor_tbl) {
                //$results_rf = addFile($mod_cd, $existing_item, $results['new_id'], $cre_by, $cre_on);
                $result_arr = array(
                    'results' => array(
                        'linked_item' => "a new link will be made to $existing_item"
                    )
                );
                
                $ret['files'][$file]['process']['cor_tbl'] = $result_arr;
            } else {
                // feedback the fact that nothing was added
                if (empty($ret['files'][$file]['process']['cor_tbl'])) {
                    $ret['files'][$file]['process']['cor_tbl'] = 'the file will not be linked to an existing item';
                }
            }
            // add metadata
            // optionally, metadata can be extracted from the upload at this stage and added to the
            // relevant record
            if (array_key_exists('metadata_conf', $fu)) {
                // try to fetch the metadata from the specified location for this file
                //let's check for an associated XMP file first
                if (is_readable("$dir/{$exploded_file[0]}.xmp")) {
                    $xmp_array = parseXMPfile("$dir/{$exploded_file[0]}.xmp");
                    $ret['files'][$file]['metadata'] = $xmp_array;
                    
                } else {
                    $ret['files'][$file]['metadata'] = "No metadata available (No XMP file?)";
                }
                // loop over each requested field and try to add it
                
            }
            
            
            // -- PART 2 - FILE HANDLING -- //
            // Thumbs are made from .jpg files. If the original is not a jpg and thumbs are 
            // still required it must be converted, image magick is needed for this. Some
            // files do not use thumbs (eg Word docs)
            $convertible = array('tif', 'pdf', 'png');
            if ($file_ext != 'jpg') {
                // decide if this file is to be converted to jpg for thumbnail creation
                if (in_array($file_ext, $convertible)) {
                    if ($phMagickAvailable) {
                        $convert = TRUE;
                        $make_thumb = TRUE;
                        $ret['files'][$file]['crunch']['convertible'] = 'this file can be thumbed';
                    } else {
                        $convert = FALSE;
                        $make_thumb = FALSE;
                    }
                } else {
                    $convert = FALSE;
                    $make_thumb = FALSE;
                    $ret['files'][$file]['crunch']['convertible'] = "$file_ext is not convertible by phMagick, therefore the file will not be thumbed";
                }
            } else {
                $convert = FALSE;
                $make_thumb = TRUE;
                $ret['files'][$file]['crunch']['arkthumb']= 'this file can be thumbed';
                $ret['files'][$file]['crunch']['convertible']= 'this file can be thumbed';
            }
            
            // skip files that are reflections or arktumbs already
            if (substr($file,0,9) == 'arkthumb_' OR substr($file,0,5) == 'refl_') {
                $skip_file = TRUE;
            } else {
                $skip_file = FALSE;
            }
            
            //DEV NOTE: The dry run can't deal with dry_running the actual phMagick conversion
            // - so we just presume it goes ok....
            
            // wipe out the process array if we are not supposed to be doing anything with this file
            if ($nottobeprocessed) {
                $ret['files'][$file]['message'][] = 'no matching item - not to be processed';
                unset($ret['files'][$file]['process']);
            }
            // increment the total and collect feedback
            $tot_proc++;
        } // end of process
        $tot_files++;
    } // end of foreach
    $ret['tot_files'] = $tot_files;
    $ret['tot_proc'] = $tot_proc;
    
    // return
    if ($ret){
        return $ret;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ registerFile()

/**
* registers a file 
*
* @param array $file  the file to process
* @param string $batch  the batch to assign the file to
* @param string $module  the module to assign the file to
* @param string $cre_by  the cre by
* @param string $cre_on  the cre on
* @param string $uri  OPTIONAL place to specify the URI
* @return array $results
* @author Stuart Eve (stuarteve@lparchaeology.com)
* @since 0.6
*
*/

function registerFile($file,$filetype,$batch,$module,$cre_by,$cre_on,$uri = FALSE)
{
    $table = 'cor_lut_file';
    $logtype = 'fileregister';
    if ($uri) {
        //check that this file hasn't already been uploaded
        $uri_id = getSingle('id', 'cor_lut_file', 'uri = "' . $uri . '"');
        if (!$uri_id) {
            $fields = array('id', 'filename', 'uri', 'filetype', 'module', 'batch', 'cre_by', 'cre_on');
            $values = array(NULL, $file, $uri, $filetype, $module, $batch, $cre_by, $cre_on);
        }
    } else {
        $uri_id = FALSE;
        $fields = array('id', 'filename', 'filetype', 'module', 'batch', 'cre_by', 'cre_on');
        $values = array(NULL, $file, $filetype, $module, $batch, $cre_by, $cre_on);
    }
    if (!$uri_id) {
        $results = dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
        $new_id = $results['new_id'];
    } else {
        $results['new_id'] = FALSE;
        $results['success'] = FALSE;
        $results['uri_id'] = $uri_id;
        $results['failed_sql'] = serialize($sql);
    }
    if ($new_id) {
        $results['new_id'] = $new_id;
        $results['success'] = TRUE;
        $results['sql'] = serialize("INSERT INTO cor_lut_file (id,filename,filetype,module,batch,cre_by,cre_on) 
                VALUES (NULL,$file, $filetype,$module,$batch,$cre_by,NOW());");
    } else {
        $results['new_id'] = FALSE;
        $results['success'] = FALSE;
        $results['failed_sql'] = serialize($sql);
    }
    return ($results);
}

// }}}
// {{{ reqArkVar()

/**
*
* returns an ARK variable
*
* @param string $var  the name of the var to set up
* @param string $default  an optional default setting for the var
* @access public
* @since 0.6
*
* This function handles a setup procedure for vars which is common in ARK.
* This checks for the var in the querystring, then in the session then
* for a default. The var if set is saved into the session. Returns
* FALSE if the var cant be set
*
*/

function reqArkVar($var, $default=FALSE)
{
    // check in the querystring (and set $$var FALSE if not set)
    $$var = reqQst($_REQUEST, $var);
    // check in the session
    if (!$$var) {
        $$var = reqQst($_SESSION, $var);
    }
    // check for a default
    if (!$$var && $default) {
        $$var = $default;
    }
    // save out the var to the session
    if (isset($$var)) {
        $_SESSION[$var] = $$var;
    }
    // return the var
    return($$var);
}

// }}}
// {{{ reqModSetting()

/**
* requests a module setting var (first from session second from file)
*
* @param string $mod  the mod_short of the module in question
* @param var $var  the name of the var we are looking to retrieve
* @return mixed $var  return_var_description
* @author Guy Hunt
* @since v0.8
*
*/

function reqModSetting($mod, $var)
{
    // SETUP
    // global the session
    global $_SESSION;
    // settings are needed to bring fields and vd_settings inside this func
    include('config/settings.php'); // see changeset [1227]
    // setup the name of the global settings/object for this module
    $mod_obj_name = 'mod_'.$mod;
    $mod_obj = reqQst($_SESSION, $mod_obj_name);
    
    // PROCESS
    // 1 - if the mod_obj hasn't yet been created, do so
    if (!$mod_obj) {
        $mod_obj = array();
    }
    // 2 - try to find the var in the live mod object
    if (array_key_exists($var, $mod_obj)) {
        $$var = $mod_obj[$var];
        return ($$var);
    }
    // 3 - get the var from file and add to the mod_obj
    // Get the mod settings for this mod
    include('config/mod_'.$mod.'_settings.php');
    if (!isset($$var)) {
        $$var = FALSE;
        //throw some error
        $error = "ADMIN ERROR: The function reqModSetting tried to get the config variable ";
        $error .= "'$var' from the mod settings file for the module: '$mod'. Check that ";
        $error .= "this variable is set within the mod_settings.php file.";
        echo "$error";
        return ($$var);
    }
    // 3b - save the modified mod_obj to the session
    if ($$var) {
        $mod_obj[$var] = $$var;
        $_SESSION[$mod_obj_name] = $mod_obj;
    }
    
    // 3c - return
    return($$var);
}

// }}}
// {{{ reqQst()

/**
* cleanly requests a var from an array and returns false if relevant
*
* @param array $array  the array to search in (typically $_REQUEST)
* @param string $var  the name fo the var to search for (the key in the array)
* @access public
* @since 0.4
*
* typically this is used to request from the querystring or session. Using
* this function will avoid unwanted e_notices for unset variables as it returns
* FALSE to your var thereby setting it
*
*/

function reqQst($array, $var)
{
    global $purifier;
    
    // 1 - Check that the vars are ok
    if (!$var) {
        echo "the var passed to reqQst was either FALSE or not set";
        return FALSE;
    } elseif (!isset($array)) {
        echo "the array passed to reqQst was not set";
        return FALSE;
    }
    // 2 - Perform the request
    if (array_key_exists($var, $array)) {
        $return = $array[$var];
        if ($array==$_REQUEST || $array==$_GET || $array==$_POST|| $array==$_COOKIE){
            if (is_array($array[$var])) {
               $return = $purifier->purifyArray($array[$var]);
            } else {
                $return = $purifier->purify($array[$var]);
            }
        }
        return $return;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ resFdCurr()

/**
* returns the current data for a field in an array with the frag id
*
* @param array $field  containing settings for this field
* @param string $itemkey  the itemkey
* @param string $itemvalue  the itemvalue
* @return array $curr  an array of arrays each containing 'id' the frag id and 'current' the current value
* @author Guy Hunt
* @since 0.6
*
* DEV NOTE: this function can be incorrectly used as an alternative to resTblTd but
* bear in mind that it returns the data unmarked up and in an array
*
*/

function resFdCurr($field, $itemkey, $itemvalue)
{
    // Setup
    global $lang;
    // Declare variable
    $current = FALSE;
    
    // get an itemkey
    if ($field['dataclass'] == 'itemkey') {
        if ($itemvalue) {
            $current = $itemvalue;
        } else {
            $current = FALSE;
        }
    }
    
    // get a modtype
    if ($field['dataclass'] == 'modtype') {
        $mod = substr($itemkey, 0, 3);
        $modtype = $mod.'type';
        $tbl = $mod.'_lut_'.$modtype;
        $var = getModType($mod, $itemvalue);
        if ($var) {
            $current = getAlias($tbl, $lang, 'id', $var, 1);
        } else {
            $current = FALSE;
        }
    }
    
    // get a txt
    if ($field['dataclass'] == 'txt') {
        $frags = getChData('txt', $itemkey, $itemvalue, $field['classtype']);
        if ($frags && is_array($frags)) {
            foreach ($frags as $frag) {
                $current[] =
                    array(
                        'id' => $frag['id'],
                        'current' => $frag['txt'],
                        'txt' => $frag['txt']
                );
            }
        } else {
            $current = FALSE;
        }
    }
    
    // get a date
    if ($field['dataclass'] == 'date') {
        $frags = getChData('date', $itemkey, $itemvalue, $field['classtype']);
        if ($frags && is_array($frags)) {
            foreach ($frags as $frag) {
                $current[] =
                    array(
                        'id' => $frag['id'],
                        'current' => $frag['date'],
                        'date' => $frag['date']
                );
            }
        } else {
            $current = FALSE;
        }
    }
    
    // get the actors of an action
    if ($field['dataclass'] == 'action') {
        $action_array = getActor($itemkey, $itemvalue,  $field['classtype'], 'abk_cd');
        if ($action_array && is_array($action_array)) {
            foreach ($action_array as $action) {
                $elem = getActorElem($action['actor_itemvalue'], $field['actors_element'], 'abk_cd', 'txt');
                $frag_id = $action['id'];
                $current[] =
                    array(
                        'id' => $frag_id,
                        'current' => $elem,
                        'actor_itemkey' => $action['actor_itemkey'],
                        'actor_itemvalue' => $action['actor_itemvalue']
                );
            }
        } else {
            $current = FALSE;
        }
    }
    
    // get attribute
    if ($field['dataclass'] == 'attribute') {
        $frags = getChData('attribute', $itemkey, $itemvalue, $field['classtype']);
        if ($frags && is_array($frags)) {
            foreach ($frags as $frag) {
                $current[] =
                    array(
                        'id' => $frag['id'],
                        'current' => $frag['attribute'],
                        'attribute' => $frag['attribute'],
                        'boolean' => $frag['boolean'],
                );
            }
        } else {
            $current = FALSE;
        }
    }
    
    // get files
    if ($field['dataclass'] == 'file') {
        $file_list = getFile($itemkey, $itemvalue, $filetype);
        if ($file_list) {
            foreach ($file_list as $key => $file) {
                $current[] =
                    array(
                        'id' => $file['id'],
                        'current' => $file['id'],
                );
            }
        } else {
            $current = FALSE;
        }
    }
    
    // get XMIs
    if ($field['dataclass'] == 'xmi') {
        $xmi_list = getXmi($itemkey, $itemvalue, $field['xmi_mod']);
        if ($xmi_list) {
            foreach ($xmi_list as $key => $xmi) {
                $current[] =
                    array(
                        'id' => $xmi['id'],
                        'current' => $xmi['xmi_itemkey'].'-'.$xmi['xmi_itemvalue'],
                        'xmi_itemkey' => $xmi['xmi_itemkey'],
                        'xmi_itemvalue' => $xmi['xmi_itemvalue']
                );
            }
        } else {
            $current = FALSE;
        }
    }
    
    // get a number
    if ($field['dataclass'] == 'number') {
        if (!is_numeric($field['classtype'])) {
            $field['classtype'] = getClassType('number',$field['classtype']);
        }
        $numbers = getNumber($itemkey, $itemvalue, $field['classtype']);
        if ($numbers) {
            foreach ($numbers as $key => $number) {
                $current[] =
                    array(
                        'id' => $number['id'],
                        'current' => $number['number']
                );
            }
        } else {
            $current = FALSE;
        }
    }
    
    // get options
    if ($field['dataclass'] == 'op') {
        // options don't have data per se, so return FALSE
        $current = FALSE;
    }
    
    // return the data or the FALSE response
    return ($current);
}

// }}}
// {{{ resTblTd()

/**
* returns the contents of a field in display mode
*
* @param array $field  containing settings for this field
* @param string $itemkey  the itemkey
* @param string $itemvalue  the itemvalue
* @return string $var  a resolved html string
* @author Guy Hunt
* @since 0.5
*
* DEV NOTE: this function needs to be renamed as it can handle
* any fields not just table fields. This was developed to do
* table cell contents
*
* NOTE 1: If you just want the data, use resFdCurr(). This function
* is for returning marked up data.
*
*/

function resTblTd($field, $itemkey, $itemvalue)
{
    
    global $lang, $ark_root_path, $registered_files_path, $conf_micro_viewer, $skin_path;
    
    // get an itemkey
    if ($field['dataclass'] == 'itemkey') {
        if (reqQst($field, 'op_no_link')) {
            $var = str_replace('_', ' ', $itemvalue);
        } else {
            $var = "<a href=\"{$conf_micro_viewer}?item_key={$itemkey}&amp;{$itemkey}={$itemvalue}\"";
            $var .= " class=\"itemkey_link\" >";
            $var .= "$itemvalue</a>";
        }
    }
    
    // get a modtype
    if ($field['dataclass'] == 'modtype') {
        $mod = substr($itemkey, 0, 3);
        $var = getModType($mod, $itemvalue);
        if ($var) {
            $tbl = $mod.'_lut_'.$mod.'type';
            $var = getAlias($tbl, $lang, 'id', $var, 1);
        } else {
            $var = FALSE;
        }
    }
    
    // get a txt
    if ($field['dataclass'] == 'txt') {
        // Notes: Originally this made the call without specifying a $lang and hence would
        // pull the first text the function came to. Later we added the $lang variable to
        // the function call. Sadly tho this means that it fails if there is no text of the
        // specified lang and type (This is correct and expected behavoir for getSingleText()).
        // In order to get round this, I have added a handler here to try first for the
        // specified language and then failing that to try for anything.
        // I have a suspicion that this is not the last time this call will prove problematic
        // it may be best for us to allow an op_ on the field to specify what is wanted from this
        // op_xxxx = not set would do what it always did
        // op_xxxx = TRUE would send the global $lang
        // op_xxxx = string would send a specified language
        // GH 11/10/10
        $var = getSingleText($itemkey, $itemvalue, $field['classtype'], $lang);
        if (!$var) {
            $var = getSingleText($itemkey, $itemvalue, $field['classtype']);
        }
    }
    
    // get a number
    if ($field['dataclass'] == 'number') {
        $numbers = getNumber($itemkey, $itemvalue, $field['classtype']);
        if ($numbers) {
            if (count($numbers) > 1) {
                $var = "<ul>";
                foreach ($numbers as $key => $number) {
                    $var .= "<li>{$number['number']} </li>";
                }
                $var .= "</ul>";
            } else {
                $var = $numbers[0]['number'];
            }
        } else {
            $var = FALSE;
        }
    }
    
    // get a date
    if ($field['dataclass'] == 'date') {
        $var = getDateARK($itemkey, $itemvalue, $field['classtype'], $field['datestyle']);
    }
    
    // get the actors of an action
    if ($field['dataclass'] == 'action') {
        $elem = FALSE;
        $action_array = getActor($itemkey, $itemvalue,  $field['classtype'], 'abk_cd');
        $link = false;
        if(isset($field['op_link'])){
        	if($field['op_link']){
        		$link = true;
        	}
        }
        if($action_array && is_array($action_array)) {
            // if this is a single actor event
            if ($field['actors_style'] == 'single') {
                // Get the actor for this actiontype for this item
                $action = end($action_array);
                $var =
                    getActorElem(
                        $action['actor_itemvalue'],
                        $field['actors_element'],
                        $field['actors_mod'].'_cd',
                        $field['actors_elementclass']
                );
                if($link){
                	$var = "<a href=\"{$ark_root_path}/micro_view.php?item_key=abk_cd&abk_cd={$action['actor_itemvalue']}\">".$var."</a>";
 
                }
            }
            // if this is a multi actor action list them first
            if ($field['actors_style'] == 'list') {
                // Get the actor id for this actiontype for this item
                $var = '<ul class="actor_list">';
                foreach ($action_array as $action) {
                    $var .= '<li>';
               		if($link){
                		$var .= "<a href=\"{$ark_root_path}/micro_view.php?item_key=abk_cd&abk_cd={$action['actor_itemvalue']}\">";
	                }
                    $var .= 
                        getActorElem(
                            $action['actor_itemvalue'],
                            $field['actors_element'],
                            'abk_cd',
                            'txt'
                    );
                    $var .= '</a>';
                    $var .= '</li>';
                }
                $var .= '</ul>';
            }
        } else {
            $var = FALSE;
        }
    }
    
    // attribute
    // attr, handle erroneous dataclass naming
    if ($field['dataclass'] == 'attr') {
        echo "Admin Error: as of v1.0 dataclass in fields must be declared as 'attribute' not 'attr'<br/>function resTblTd()<br/>";
        $field['dataclass'] = 'attribute';
    }
    if ($field['dataclass'] == 'attribute') {
        // if we have an attribute type we need to get all attributes of the type
        $attrs = getCh('attribute', $itemkey, $itemvalue, $field['classtype']);
        if ($attrs) {
            if (count($attrs) > 1) {
                $var = "<ul>";
                foreach ($attrs as $key => $attr) {
                    $attralias = getAttr(FALSE, $attr, 'SINGLE', 'alias', $lang);
                    //get the lut_attribute id of this attribute
                    $att_lut_id = getRow('cor_tbl_attribute',$attr);
                    $att_lut_id = $att_lut_id['attribute'];
                    //get the lut_attributetype id of this attribute
                    $att_lut_typeid = getRow('cor_lut_attribute',$att_lut_id);
                    $att_lut_typeid = $att_lut_typeid['attributetype'];
                    $var .= "<li>";
                    $var .= "<a href=\"data_view.php?ftr_mode=standard&reset=1&results_mode=disp";
                    $var .= "&disp_mode=table&ftype=atr&amp;atrtype=$att_lut_typeid&amp;";
                    $var .= "atr=$att_lut_id&bv=1&ftr_id=new\">";
                    $var .= "$attralias";
                    $var .= "</a></li>\n";
                }
                $var .= "</ul>";
            } else {
                $attralias = getAttr(FALSE, $attrs[0], 'SINGLE', 'alias', $lang);
                //get the lut_attribute id of this attribute
                $att_lut_id = getRow('cor_tbl_attribute',$attrs[0]);
                $att_lut_id = $att_lut_id['attribute'];
                //get the lut_attributetype id of this attribute
                $att_lut_typeid = getRow('cor_lut_attribute',$att_lut_id);
                $att_lut_typeid = $att_lut_typeid['attributetype'];
                $var = "<a href=\"data_view.php?ftr_mode=standard&reset=1&results_mode=disp";
                $var .= "&disp_mode=table&ftype=atr&amp;atrtype=$att_lut_typeid&amp;";
                $var .= "atr=$att_lut_id&bv=1&ftr_id=new\">";
                $var .= "$attralias";
                $var .= "</a>\n";
            }
        } else {
            $var = FALSE;
        }
    }
    
    // xmi list
    if ($field['dataclass'] == 'xmi') {
        
        $xmi_mod = $field['xmi_mod'];
        $xmi_key = $xmi_mod . '_cd';
        // Includes relevant settings file
        include ('config/settings.php');
        include ('config/mod_'.$xmi_mod.'_settings.php');
        $xmi_conf_name = $xmi_mod.'_xmiconf';
        $xmi_conf = $$xmi_conf_name;
        if (array_key_exists('op_disp_full_xmi',$xmi_conf)) {
            $xmi_fields = $xmi_conf['fields'];
            $xmi_fields = resTblTh($xmi_fields, 'silent');

            // ---- DATA ---- //
            // Gets the XMIed items linked to this item but in the specified module
            $xmi_list = getXmi($itemkey, $itemvalue, $xmi_mod);
            if ($xmi_list){
            // Process out the required fields for each XMIed item and add to the array
                foreach ($xmi_list as $key => $xmi_item) {
                    foreach ($xmi_fields as $xmi_field) {
                        $xmi_vars[] = resTblTd($xmi_field, $xmi_key, $xmi_item['xmi_itemvalue']);
                    }
                    $xmi_list[$key]['xmi_vars'] = $xmi_vars;
                    unset($xmi_vars);
                    // Optional sorting of XMIed items
                    if (array_key_exists('op_xmi_sorting', $xmi_conf)) {
                        $xmi_list[$key]['sort_key'] = resTblTd($xmi_conf['op_xmi_sort_field'], $xmi_key, $xmi_item['xmi_itemvalue']);
                    }
                }
            }
            //printPre($xmi_list);
            //echo "xmi_list: " . count($xmi_list);
            if ($xmi_list) {
                if (count($xmi_list) > 1) {
                    $var = "<ul>";
                    foreach ($xmi_list as $list_key => $list_value) {
                        if (array_key_exists('xmi_vars',$list_value) && !empty($list_value['xmi_vars'])) {
                            foreach ($list_value['xmi_vars'] as $key => $xmi) {
                                $var .= "<li>{$xmi} </li>";
                            }
                        }
                    }
                    $var .= "</ul>";
                } else {
                    $var = "<ul>";
                    if (array_key_exists('xmi_vars',$xmi_list[0]) && !empty($xmi_list[0]['xmi_vars'])) {
                        foreach ($xmi_list[0]['xmi_vars'] as $key => $xmi) {
                            $var .= "<li>{$xmi} </li>";
                        }
                    } else {
                        $var = $xmi_list[0]['xmi_itemvalue'];
                    }
                    $var .= "</ul>";
                }
            } else {
                $var = FALSE;
            }
        } else {
            $xmi_list = getXmi($itemkey, $itemvalue, $field['xmi_mod']);
            if ($xmi_list) {
                if (count($xmi_list) > 1) {
                    $var = "<ul>";
                    foreach ($xmi_list as $key => $xmi) {
                        if(array_key_exists('op_no_link', $field)){
                            $var .= "<li>{$xmi['xmi_itemvalue']}</li>";
                        } else {
                            $var .= "<li><a href=\"{$conf_micro_viewer}?item_key={$xmi['xmi_itemkey']}&amp;{$xmi['xmi_itemkey']}={$xmi['xmi_itemvalue']}\"";
                            $var .= " class=\"itemkey_link\" >";
                            $var .= $xmi['xmi_itemvalue'] . "</a></li>";
                        }
                    }
                    $var .= "</ul>";
                 } else {
                    $var = "<ul>";
                    if(array_key_exists('op_no_link', $field)){
                        $var .= "<li>{$xmi_list[0]['xmi_itemvalue']}</li>";
                    } else {
                        $var .= "<li><a href=\"{$conf_micro_viewer}?item_key={$xmi_list[0]['xmi_itemkey']}&amp;{$xmi_list[0]['xmi_itemkey']}={$xmi_list[0]['xmi_itemvalue']}\"";
                        $var .= " class=\"itemkey_link\" >";
                        $var .= $xmi_list[0]['xmi_itemvalue'] . "</a></li>";
                        $var .= "</ul>";
                    }
                 }
             } else {
                 $var = FALSE;
             }
        }
    }
    
    // files
    if ($field['dataclass'] == 'file') {
        // handle an option to only return the file
        if (array_key_exists('op_disp_meta', $field)) {
            $op_disp_meta = $field['op_disp_meta'];
        } else {
            $op_disp_meta = FALSE;
        }
        if (array_key_exists('op_lightbox', $field)) {
            $op_lightbox = $field['op_lightbox'];
        } else {
            // default is ON
            $op_lightbox = TRUE;
        }
        $file_list = getFile($itemkey, $itemvalue, $field['classtype']);
        if ($file_list) {
            // set up a var
            $var = FALSE;
            if (count($file_list) > 1) {
                // we want to display a thumbnail of the first by getting its id
                $current_key = key($file_list);
                $current_file = $file_list[$current_key];
                $id = $current_file['id'];
                $mult_files = "<img src=\"{$skin_path}/images/results/mult_files.png\"";
                $mult_files .= " alt=\"multiple\" class=\"mult_files\"/>";
            } else {
                // just use the current id
                $current_file = current($file_list);
                $id = $current_file['id'];
                $mult_files = FALSE;
            }
            $webthumb_url = "{$registered_files_path}/webthumb_{$id}.jpg";
            $arkthumb_url = "{$registered_files_path}/arkthumb_{$id}.jpg";
            // assemble the li
            if ($op_disp_meta) {
                $var .= "<span class=\"filename\">{$current_file['filename']}</span>";
            }
            if ($op_lightbox) {
                $var .= "<a href=\"$webthumb_url\" class=\"imagebox\">";
                $var .= "<img src=\"$arkthumb_url\" alt=\"file_image\"/>";
                $var .= $mult_files;
                $var .= "</a>\n";
            } else {
                $var .= "<img src=\"$arkthumb_url\" alt=\"file_image\"/>";
                $var .= $mult_files;
                $var .= "\n";
            }
        } else {
            $var = FALSE;
        }
    }
    
    // spans
    if ($field['dataclass'] == 'span') {
        $spans = getSpan($itemkey, $itemvalue, $field['classtype']);
        // labels may be needed
        $b_label = "";
        $e_label = "";
        if (array_key_exists('field_op_label', $field)) {
            if($field['field_op_label']){
                $b_label = "<label>{$field['b_label']}</label>\n";
                $e_label = "<label>{$field['e_label']}</label>\n";
            }
        }
        // handle the divider option
        if (array_key_exists('field_op_divider', $field)) {
            $divider = $field['field_op_divider'];
        } else {
            $divider = FALSE;
        }
        // handle the AD/BC modifier option
        if (array_key_exists('field_op_modifier', $field)) {
            $field_op_modifier = $field['field_op_modifier'];
        } else {
            $field_op_modifier = FALSE;
        }
        if ($spans) {
            if (count($spans) > 1) {
                $var = "<ul>";
                foreach ($spans as $key => $span) {
                    // an AD/BC modifer may be in use
                    if ($field_op_modifier) {
                        $beg = $span['beg']-2000;
                        $end = $span['end']-2000;
                        // sort out epochs
                        if ($beg > 0) {
                            $start_epoch = 'BC';
                        } else {
                            $start_epoch = 'AD';
                            $beg = abs($beg);
                        }
                        $beg .= $start_epoch;
                        if ($end > 0) {
                            $end_epoch = 'BC';
                        } else {
                            $end_epoch = 'AD';
                            $end = abs($end);
                        }
                        $end .= $end_epoch;
                    } else {
                        $beg = $span['beg'];
                        $end = $span['end'];
                    }
                    // if the beginning and end are the same just display a single. GH 9/9/11
                    if ($span['beg'] == $span['end']) {
                        $divider = FALSE;
                        $end = FALSE;
                    }
                    $var .= "<li>{$beg}{$divider}{$end}</li>";
                }
                $var .= "</ul>";
            } else {
                // an AD/BC modifer may be in use
                if ($field_op_modifier) {
                    $beg = $spans[0]['beg']-2000;
                    $end = $spans[0]['end']-2000;
                    // sort out epochs
                    if ($beg > 0) {
                        $start_epoch = 'BC';
                    } else {
                        $start_epoch = 'AD';
                        $beg = abs($beg);
                    }
                    $beg .= $start_epoch;
                    if ($end > 0) {
                        $end_epoch = 'BC';
                    } else {
                        $end_epoch = 'AD';
                        $end = abs($end);
                    }
                    $end .= $end_epoch;
                } else {
                    $beg = $spans[0]['beg'];
                    $end = $spans[0]['end'];
                }
                // if the beginning and end are the same just display a single. GH 9/9/11
                if ($spans[0]['beg'] == $spans[0]['end']) {
                    $divider = FALSE;
                    $end = FALSE;
                    $e_label = FALSE;
                    
                }
                $var = "{$beg}{$b_label}{$divider}{$end}{$e_label}";
                // if both dates are 0 treat it as undefined
                if ($spans[0]['beg'] == 0){
                    $var = '<span class="data">'.getMarkup('cor_tbl_markup','en','undefined').'</span>';
                }
            }
        } else {
            $var = FALSE;
        }
    }
    
    // get options
    if ($field['dataclass'] == 'op') {
        global  $skin_path;
        //check if there are any user specified options/order in the field setup
        if (array_key_exists('options', $field)) {
            $var = FALSE;
            //explode the entry on a comma
            $explode_array = explode(',', $field['options']);
            foreach ($explode_array as $key => $value) {
                if ($value == 'view') {
                    $label = getMarkup('cor_tbl_markup', $lang, 'view');
                    $img = "<img src=\"$skin_path/images/plusminus/view.png\"";
                    $img .= " alt=\"$label\" class=\"med\" title=\"View Record\" />";
                    $var .= "<a href=\"{$ark_root_path}/micro_view.php?";
                    $var .= "item_key=$itemkey&amp;$itemkey=$itemvalue\">$img</a>";
                }
                if ($value == 'check') {
                    $var .= "<input type=\"checkbox\" />";
                }
                if ($value == 'remove') {
                    // the key must be numeric
                    $key_id = getSingle('id', 'cor_tbl_module', "itemkey = '$itemkey'");
                    $img = "<img src=\"$skin_path/images/plusminus/bigminus.png\"";
                    $img .= " alt=\"[-]\" class=\"med\" title=\"Remove Item\" />";
                    $var .= "<a href=\"{$_SERVER['PHP_SELF']}?ftype=manual&amp;key=$key_id";
                    $var .= "&amp;val_list=$itemvalue&amp;set_op=complement\">";
                    $var .= "$img</a>";
                }
                if ($value == 'enter') {
                    $label = getMarkup('cor_tbl_markup', $lang, 'enter');
                    $img = "<img src=\"$skin_path/images/plusminus/detailed.png\"";
                    $img .= " alt=\"$label\" class=\"med\" title=\"Enter Record\" />";
                    $var .= "<a href=\"{$ark_root_path}/data_entry.php?view=detfrm&amp;";
                    $var .= "item_key=$itemkey&amp;$itemkey=$itemvalue\">$img</a>";
                }
                if ($value == 'qed') {
                    $label = getMarkup('cor_tbl_markup', $lang, 'qed');
                    $img = "<img src=\"$skin_path/images/plusminus/edit.png\"";
                    $img .= " alt=\"$label\" class=\"med\" title=\"Edit this Row\" />";
                    $var .= "<a href=\"{$_SERVER['PHP_SELF']}?quickedit=$itemvalue\">$img</a>";
                }
            }
        } else {
            // these are defaults
            $label = getMarkup('cor_tbl_markup', $lang, 'view');
            $var = "<a href=\"{$ark_root_path}/micro_view.php?item_key=$itemkey&amp;$itemkey=$itemvalue\">";
            $var .= "[$label]</a>";
            $label = getMarkup('cor_tbl_markup', $lang, 'enter');                
            $var .= "<a href=\"{$ark_root_path}/data_entry.php?view=detfrm&amp;item_key=$itemkey&amp;";
            $var .= "$itemkey=$itemvalue\">";
            $var .= "[$label]</a>";
            $label = getMarkup('cor_tbl_markup', $lang, 'qed');
            $var .= "<a href=\"{$_SERVER['PHP_SELF']}?quickedit=$itemvalue\">";
            $var .= "[$label]</a>";
        }
    }
    if (isset($var)) {
        if ($var) {
            if ($field['dataclass'] != 'op') {
                $var = "<span class=\"data\">$var</span>";
            } else {
                $var = "<span class=\"options\">$var</span>";
            }
        }
        return ($var);
    } else {
        echo "resTblTd: couldn't get a valid dataclass for {$field['dataclass']}<br/>";
        return FALSE;
    }
}

// }}}
// {{{ resTblTh()

/**
* processes a fields array to put in the field aliases
*
* @param array $fields  an ARK standard fields array
* @param string $mode  DEPRECATED
* @return array $fields  contains the modified fields array
* @author Guy Hunt
* @since 0.5
*
* NOTE 1: As of v1.1 this no longer outputs the table rows to screen. The second
* param 'mode' is now fully redundant and can be removed from all calls to this
* func.
*
* NOTE 2: The output element of this func has been moved to mkTblTh()
*
* DEV NOTE: this function name is total wrong! rename.
*
*/

function resTblTh($fields, $mode=FALSE)
{

    global $lang;
    // admin error handling
    if (!is_array($fields) OR !$fields) {
        echo "resTblTh: Something went wrong with the conf array";
        return FALSE;
    }
    // Loop through each field
    foreach ($fields as $key => $col) {
        if ($col['dataclass'] != 'op' && $col['dataclass'] != 'delete') {
            // As of v1.1 fields don't require the alias information vars
            // Handler - look for pre v1.1 conf and look for missing (post v1.1 style) conf
            if (array_key_exists('alias_src_key', $col) || !array_key_exists('aliasinfo', $col)) {
                if (array_key_exists('field_id', $col)) {
                    $field_id = $col['field_id'];
                    $msg2 = "INFO: 'field_id' $field_id<br/>\n";
                } else {
                    $msg2 = "ADMIN ERROR: no 'field_id' is set for the field<br/>\n";
                }
                $msg = "ADMIN ERROR: as of v1.1 field alias config has been changed<br/>\n";
                $msg .= $msg2;
                $msg .= "INFO: <href=\"http://ark.lparchaeology.com/wiki/index.php/Field";
                $msg .= "_settings.php\">see http://ark.lparchaeology.com/wiki/index.php/Field";
                $msg .= "_settings.php</a><br/>\n";
                echo "$msg<br/>";
                $col['aliasinfo'] = FALSE;
            }
            if ($col['aliasinfo']) {
                // take the specified info
                $alias_tbl = $col['aliasinfo']['alias_tbl'];
                $alias_col = $col['aliasinfo']['alias_col'];
                $alias_src_key = $col['aliasinfo']['alias_src_key'];
                $alias_type = $col['aliasinfo']['alias_type'];
                if (array_key_exists('alias_lang', $col['aliasinfo'])) {
                    $alias_lang = $col['aliasinfo']['alias_lang'];
                } else {
                    $alias_lang = $lang;
                }
            } else {
                // assume that the field is standard "classtype = alias_src_key" sort of field
                $alias_tbl = "cor_lut_{$col['dataclass']}type";
                $alias_col = $col['dataclass']."type";
                $alias_src_key = $col['classtype'];
                $alias_type = '1';
                $alias_lang = $lang;
            }
            // make the call
            $hdr_alias =
                getAlias(
                    $alias_tbl,
                    $alias_lang,
                    $alias_col,
                    $alias_src_key,
                    $alias_type
            );
        } else {
            // make an options column
            $hdr_alias = getMarkup('cor_tbl_markup', $lang, 'options');
        }
        // put the alias into the conf_arr
        $fields[$key]['field_alias'] = $hdr_alias;
    }
    // return the $fields
    return ($fields);
}

// }}}
// {{{ setModSetting()

/**
* sets a var in the mod setting array (overwrites or sets fresh)
*
* @param string $mod  the mod_short to identify the module
* @param string $varname  the name of the var to set
* @param mixed $var  the setting data to add in to the settings
* @return bool $ret  true/false
* @author Guy Hunt
* @since v0.8
*
*/

function setModSetting($mod, $varname, $var)
{
    // setup the name of the global settings/object for this module
    $mod_obj_name = 'mod_'.$mod;
    // global this live var
    global $_SESSION;
    $mod_obj = $_SESSION[$mod_obj_name];
    if (!isset($mod_obj) or !$mod_obj) {
        echo "ADMIN ERROR: The mod settings function can't find the settings array/object '$mod_obj_name'<br/>";
        return(FALSE);
    }
    $mod_obj[$varname] = $var;
    $_SESSION[$mod_obj_name] = $mod_obj;
    return(TRUE);
}

// }}}
// {{{ sfNav()

/**
* returns a navigation bar for a subform
*
* @param string $sf_title  the string to print into the header
* @param string $col_no  the column number
* @param string $sf_id  the id of this subform
* @param array $disp_cols  containing the columns to display
* @return $sf_nav  a fully resolved xhtml string
* @author Guy Hunt
* @author Andy Dufton
* @since 0.5
*
*/

function sfNav($sf_title, $col_no, $sf_id, $disp_cols)
{
    global $item_key, $$item_key, $skin_path, $minimiser, $pagename, $cur_max, $lang;
    // some simple error handling
    if (!is_array($disp_cols)) {
        echo "sfNav: disp cols was not an array";
        return FALSE;
    }
    if (empty($disp_cols)) {
        echo "sfNav: disp cols was empty";
        return FALSE;
    }
    if (!isset($col_no)) {
        echo "sfNav: column number not set";
        return FALSE;
    }
    if (!isset($sf_id)) {
        echo "sfNav: sf number not set";
        return FALSE;    
    }
    if (!isset($minimiser)) {
        echo "sfNav: minimiser not set";
        return FALSE;   
    }
    // set up a few strings
    $num_cols = count($disp_cols);
    $top_key = $num_cols-1;
    $subforms = $disp_cols[$col_no]['subforms'];
    $top_row_key = end(array_keys($subforms));
    $subform_id = $subforms[$sf_id]['sf_html_id'];
    // Markup
    $mk_editbtn = getMarkup('cor_tbl_markup', $lang, 'edit');
    $mk_lockbtn = getMarkup('cor_tbl_markup', $lang, 'lock');
    // check for the minimiser
    if ($minimiser) {
        $conf = TRUE;
    } else {
        $conf = FALSE;
    }
    // check this is a valid page of minimising
    if ($pagename == 'data_entry') {
        $file = TRUE;
    } else {
        $file = FALSE;
    }
    // attempt to figure out the current maximised form
    if (!isset($cur_max)) {
        $cur_max = '0';
    }
    if ($cur_max == $sf_id) {
        $curr = TRUE;
    } else {
        $curr = FALSE;
    }
    // evaluate the need for minimiser links
    if ($conf && $file && !$curr) {
        // flag the minimiser on
        $minim_switch = TRUE;
        // set up the link href
        $minimiser_link = "{$_SERVER['PHP_SELF']}?";
        $minimiser_link .= "item_key=$item_key&amp;$item_key={$$item_key}";
        $minimiser_link .= "&amp;sf_id=$sf_id&amp;nav_min=1";
    } else {
        // flag the minimiser on
        $minim_switch = FALSE;
    }
    
    // LEFT AND RIGHT
    if ($col_no == 0) {
        $chev = "<li class=\"sf_nav\">";
        $chev .= "<a href=\"{$_SERVER['PHP_SELF']}?";
        $chev .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
        $chev .= "&amp;col_id=$col_no&amp;sf_nav=mv_col_r\">";
        $chev .= "<img src=\"$skin_path/images/plusminus/right.png\" alt=\"[>]\ title=\"Right\"/>";
        $chev .= "</a></li>";
    }
    if ($col_no == $top_key) {
        $chev = "<li class=\"sf_nav\">";
        $chev .= "<a href=\"{$_SERVER['PHP_SELF']}?";
        $chev .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
        $chev .= "&amp;col_id=$col_no&amp;sf_nav=mv_col_l\">";
        $chev .= "<img src=\"$skin_path/images/plusminus/left.png\" alt=\"[<]\" title=\"Left\"/>";
        $chev .= "</a></li>";
    } elseif ($col_no > 0 AND $col_no < $top_key) {
        $chev = "<li class=\"sf_nav\">";
        $chev .= "<a href=\"{$_SERVER['PHP_SELF']}?";
        $chev .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
        $chev .= "&amp;col_id=$col_no&amp;sf_nav=mv_col_l\">";
        $chev .= "<img src=\"$skin_path/images/plusminus/left.png\" alt=\"[<]\" title=\"Left\"/>";
        $chev .= "</a>";
        $chev .= "</li>";
        $chev .= "<li class=\"sf_nav\">";
        $chev .= "<a href=\"{$_SERVER['PHP_SELF']}?";
        $chev .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
        $chev .= "&amp;col_id=$col_no&amp;sf_nav=mv_col_r\">";
        $chev .= "<img src=\"$skin_path/images/plusminus/right.png\" alt=\"[>]\" title=\"Right\"/>";
        $chev .= "</a>";
        $chev .= "</li>";
    }
    // UP AND DOWN
    if ($sf_id == 0) {
        $v_chev = "<li class=\"sf_nav\">";
        $v_chev .= "<a href=\"{$_SERVER['PHP_SELF']}?";
        $v_chev .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
        $v_chev .= "&amp;col_id=$col_no&amp;sf_nav=mv_dn\">";
        $v_chev .= "<img src=\"$skin_path/images/plusminus/down.png\" alt=\"[V]\" title=\"Down\"/>";
        $v_chev .= "</a></li>";
    }
    if ($sf_id == $top_row_key) {
        $v_chev = "<li class=\"sf_nav\">";
        $v_chev .= "<a href=\"{$_SERVER['PHP_SELF']}?";
        $v_chev .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
        $v_chev .= "&amp;col_id=$col_no&amp;sf_nav=mv_up\">";
        $v_chev .= "<img src=\"$skin_path/images/plusminus/up.png\" alt=\"[^]\" title=\"Up\"/>";
        $v_chev .= "</a></li>";
    } elseif ($sf_id > 0 AND $sf_id < $top_row_key) {
        $v_chev = "<li class=\"sf_nav\">";
        $v_chev .= "<a href=\"{$_SERVER['PHP_SELF']}?";
        $v_chev .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
        $v_chev .= "&amp;col_id=$col_no&amp;sf_nav=mv_up\">";
        $v_chev .= "<img src=\"$skin_path/images/plusminus/up.png\" alt=\"[^]\" title=\"Up\"/>";        
        $v_chev .= "</a></li>";
        $v_chev .= "<li class=\"sf_nav\">";
        $v_chev .= "<a href=\"{$_SERVER['PHP_SELF']}?";
        $v_chev .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
        $v_chev .= "&amp;col_id=$col_no&amp;sf_nav=mv_dn\">";
        $v_chev .= "<img src=\"$skin_path/images/plusminus/down.png\" alt=\"[V]\" title=\"Up\"/>";
        $v_chev .= "</a>";
        $v_chev .= "</li>";
    } else {
        $v_chev = FALSE;
    }
    // HELP
    //Build the Help button
    $help = "<li class=\"sf_nav\">";
    $help .= "<a href=\"overlay_holder.php?";
    $help .= "overlay=true&amp;";
    $help .= "help_lvl=sf&amp;";
    $help .= "help_conf={$disp_cols[$col_no]['subforms'][$sf_id]['sf_html_id']}&amp;";
    $help .= "sf_conf=conf_mcd_help\" ";
    if (@!$disp_cols[$col_no]['subforms'][$sf_id]['op_help_dropdown']){
    	$help .= "rel=\"lightbox|400\"";
    }
    $help .= "class=\"helptogl\"";
    $help .= "name=\"{$disp_cols[$col_no]['subforms'][$sf_id]['sf_html_id']}\"";
    $help .= "title=\"Help\">";
    $help .= "</a></li>";
      
    // EDIT
    // build an edit/save toggle
    switch($subforms[$sf_id]['edit_state']){
        case 'ent':
        case 'edit':
            $edtogl = "<li class=\"sf_nav\">";
            $edtogl .= "<a name =\"$subform_id\" href=\"{$_SERVER['PHP_SELF']}?";
            $edtogl .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
            $edtogl .= "&amp;col_id=$col_no&amp;sf_nav=view\"";
            $edtogl .= "class=\"btn locktogl";
            switch ($subforms[$sf_id]['script']){
                case 'php/subforms/sf_attr_bytype.php':
                    $edtogl .= "saveattr";
                    break;
                default :
                    $edtogl .= "svtogl";
            }
            $edtogl .= "\">";
            $edtogl .= $mk_lockbtn;
            $edtogl .= "</a></li>";
            break;
        case 'view':
        default:
            $edtogl = "<li class=\"sf_nav\">";
            $edtogl .= "<a name =\"$subform_id\" href=\"{$_SERVER['PHP_SELF']}?";
            $edtogl .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
            $edtogl .= "&amp;col_id=$col_no&amp;sf_nav=edit\"";
            $edtogl .= "class=\"btn greybtn edtogl\">";
            $edtogl .= $mk_editbtn;
            $edtogl .= "</a></li>";
            break;
    }
    
    // OUTPUT
    // Work out what display type is needed
    if (array_key_exists('sf_nav_type', $disp_cols[$col_no]['subforms'][$sf_id])) {
        $sf_nav_type = $disp_cols[$col_no]['subforms'][$sf_id]['sf_nav_type'];
    } else {
        echo "sfNav(): the subform '$sf_title' does not have the var sf_nav_type setup correctly<br/>";
        return FALSE;
    }
    // now produce the string
    if ($sf_nav_type == 'none') {
        return FALSE;
    } else {
        // if the minimiser is on, the header br is a link, if not it is a div
        if ($minim_switch) {
            $sf_nav = "<a class=\"minimiser_sf_nav\" href=\"$minimiser_link\">";
        } else {
            $sf_nav = "<div class=\"sf_nav\">";
        }
        switch ($sf_nav_type) {
            case 'full':
                $sf_nav .= "<h4>$sf_title</h4>";
                $sf_nav .= "<ul class=\"sf_nav\">";
                $sf_nav .= $edtogl;
                $sf_nav .= "<li class=\"sf_nav\">";
                $sf_nav .= "<a href=\"{$_SERVER['PHP_SELF']}?";
                $sf_nav .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
                $sf_nav .= "&amp;col_id=$col_no&amp;sf_nav=min\">";
                $sf_nav .= "<img src=\"$skin_path/images/plusminus/bigminus.png\" alt=\"[-]\" title=\"Expand Form\"/>";
                $sf_nav .= "</a></li>";
                $sf_nav .= "<li class=\"sf_nav\">";
                $sf_nav .= "<a href=\"{$_SERVER['PHP_SELF']}?";
                $sf_nav .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
                $sf_nav .= "&amp;col_id=$col_no&amp;sf_nav=max\">";
                $sf_nav .= "<img src=\"$skin_path/images/plusminus/bigplus.png\" alt=\"[+]\" title=\"Hide Form\"/>";
                $sf_nav .= "</a></li>";
                $sf_nav .= $help;
                $sf_nav .= $chev;
                $sf_nav .= $v_chev;
                $sf_nav .= "</ul>";
                break;
                
            case 'help':
                $sf_nav .= "<h4>$sf_title</h4>";
                $sf_nav .= "<ul class=\"sf_nav\">";
                $sf_nav .= $help;
                $sf_nav .= "</ul>";
                break;
            
            case 'name':
                $sf_nav .= "<h4>$sf_title</h4>";
                break;

            case 'nmedit':
                $sf_nav .= "<h4>$sf_title</h4>";
                $sf_nav .= "<ul class=\"sf_nav\">";
                $sf_nav .= $edtogl;
                $sf_nav .= "</ul>";
                break;
                
            case 'nmedit_help':
                $sf_nav .= "<h4>$sf_title</h4>";
                $sf_nav .= "<ul class=\"sf_nav\">";
                $sf_nav .= $edtogl;
                $sf_nav .= $help;
                $sf_nav .= "</ul>";
                break;
                
            case 'nmeditmm':
                $sf_nav .= "<h4>$sf_title</h4>";
                $sf_nav .= "<ul class=\"sf_nav\">";
                $sf_nav .= "<li class=\"sf_nav\">";
                $sf_nav .= $edtogl;
                $sf_nav .= "<li class=\"sf_nav\">";
                $sf_nav .= "<a href=\"{$_SERVER['PHP_SELF']}?";
                $sf_nav .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
                $sf_nav .= "&amp;col_id=$col_no&amp;sf_nav=min\">";
                $sf_nav .= "<img src=\"$skin_path/images/plusminus/bigminus.png\" alt=\"[-]\" title=\"Hide Form\"/>";
                $sf_nav .= "</a></li>";
                $sf_nav .= "<li class=\"sf_nav\">";
                $sf_nav .= "<a href=\"{$_SERVER['PHP_SELF']}?";
                $sf_nav .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
                $sf_nav .= "&amp;col_id=$col_no&amp;sf_nav=max\">";
                $sf_nav .= "<img src=\"$skin_path/images/plusminus/bigplus.png\" alt=\"[+]\" title=\"Expand Form\"/>";
                $sf_nav .= "</a></li>";
                $sf_nav .= $help;
                $sf_nav .= "</ul>";
                break;

            case 'nmmm':
                $sf_nav .= "<h4>$sf_title</h4>";
                $sf_nav .= "<ul class=\"sf_nav\">";
                $sf_nav .= "<li class=\"sf_nav\">";
                $sf_nav .= "<a href=\"{$_SERVER['PHP_SELF']}?";
                $sf_nav .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
                $sf_nav .= "&amp;col_id=$col_no&amp;sf_nav=min\">";
                $sf_nav .= "<img src=\"$skin_path/images/plusminus/bigminus.png\" alt=\"[-]\" title=\"Hide Form\"/>";
                $sf_nav .= "</a></li>";
                $sf_nav .= "<li class=\"sf_nav\">";
                $sf_nav .= "<a href=\"{$_SERVER['PHP_SELF']}?";
                $sf_nav .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
                $sf_nav .= "&amp;col_id=$col_no&amp;sf_nav=max\">";
                $sf_nav .= "<img src=\"$skin_path/images/plusminus/bigplus.png\" alt=\"[+]\" title=\"Expand Form\"/>";
                $sf_nav .= "</a></li>";
                $sf_nav .= "</ul>";
                break;
                
            case 'nmmm_help':
                $sf_nav .= "<h4>$sf_title</h4>";
                $sf_nav .= "<ul class=\"sf_nav\">";
                $sf_nav .= "<li class=\"sf_nav\">";
                $sf_nav .= "<a href=\"{$_SERVER['PHP_SELF']}?";
                $sf_nav .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
                $sf_nav .= "&amp;col_id=$col_no&amp;sf_nav=min\">";
                $sf_nav .= "<img src=\"$skin_path/images/plusminus/bigminus.png\" alt=\"[-]\" title=\"Hide Form\"/>";
                $sf_nav .= "</a></li>";
                $sf_nav .= "<li class=\"sf_nav\">";
                $sf_nav .= "<a href=\"{$_SERVER['PHP_SELF']}?";
                $sf_nav .= "$item_key={$$item_key}&amp;sf_id=$sf_id";
                $sf_nav .= "&amp;col_id=$col_no&amp;sf_nav=max\">";
                $sf_nav .= "<img src=\"$skin_path/images/plusminus/bigplus.png\" alt=\"[+]\" title=\"Expand Form\"/>";
                $sf_nav .= "</a></li>";
                $sf_nav .= $help;
                $sf_nav .= "</ul>";
                break;

            default:
                $sf_nav .= "<h4>$sf_title</h4>";
                break;
        }
        // close out the nav
        if ($minim_switch) {
            $sf_nav .= "</a>";
        } else {
            $sf_nav .= "</div>";
        }
        if($sf_nav_type=='help' || $sf_nav_type =='nmedit_help'){
        	if(isset($disp_cols[$col_no]['subforms'][$sf_id]['op_help_dropdown']) && $disp_cols[$col_no]['subforms'][$sf_id]['op_help_dropdown']){
        		$help_sf_conf = $disp_cols[$col_no]['subforms'][$sf_id];
        	    $sf_nav .= mkHelpTray($help_sf_conf);
        	}
        }
    }
    // Return
    return ($sf_nav);
}

// }}}
// {{{ sortResArr()

/**
* sorts multidim arrays on a given column (eg the results array by score)
*
* @param array $results_array  the results array
* @param string $type  the type of sort to run
* @param string $type  the column to sort on (default: FALSE, will use 'score')
* @return array $results_array  the sorted results array
* @author Guy Hunt
* @since 0.4
*
* NOTE: the types of sort are: default(FALSE), ITEMVAL, NATURAL and SORT_ASC
*
*/

function sortResArr($results_array, $type=FALSE, $col=FALSE, $field=FALSE)
{
    // Establish default column
    if (!$col) {
        $col = 'score';
    }
    // process some asc desc options
    if ($type == 'desc' or $type == 'dsc' or $type == 'DESC' or $type == 'DSC') {
        $type = 'SORT_DESC';
    }
    if ($type == 'asc' or $type == 'ASC') {
        $type = 'SORT_ASC';
    }
    // a default - if type isnt set
    if (!$type) {
        $type = 'SORT_DESC';
    }
    // Obtain a list of columns
    foreach ($results_array as $key => $row) {
        $col_list[$key] = $row[$col];
    }
    // Sort the array
    // 1 - Score Descending
    if ($type == 'SORT_DESC') {
        if($field['dataclass']==='date'){
            uasort($results_array, 'ARKdateSortDesc');
        } else {
            if (version_compare(phpversion(), '5.4.0', '<')) {
                array_multisort($col_list, SORT_DESC, SORT_REGULAR, $results_array);
            } else {
                array_multisort($col_list, SORT_DESC, SORT_NATURAL, $results_array);
            }
        }
    }
    // 2 - Itemvalues according to 'natural' order
    if ($type == 'ITEMVAL') {
        uasort($results_array, 'itemValNatSort');
    }
    // 3 - Stuff according to 'natural' order
    if ($type == 'NATURAL') {
        uasort($results_array, 'ARKnatSort');
    }
    // 4 - Any column ascending
    if ($type == 'SORT_ASC') {
        if($field['dataclass']==='date'){
            uasort($results_array, 'ARKdateSortAsc');
        } else {
            if (version_compare(phpversion(), '5.4.0', '<')) {
                array_multisort($col_list, SORT_ASC, SORT_REGULAR, $results_array);
            } else {
                array_multisort($col_list, SORT_ASC, SORT_NATURAL, $results_array);
            }
        }
    }
    // 4 - Any column ascending
    if ($type == 'DATE') {
        uasort($results_array, 'ARKdateSort');
    }

    return($results_array);
}

// }}}
// {{{ splitDate()

/**
* splits a date
*
* @param string $rawdate  the date to split
* @param string $datestyle  the desired format to return
* @return string $date
* @author Guy Hunt
* @since 0.3
*/

function splitDate($rawdate, $datestyle) 
{

    // rawdate
    if ($datestyle == 'rawdate') {
        $date = $rawdate;
    }
    // dateonly
    if ($datestyle == 'dateonly') {
        $split = explode(' ', $rawdate);
        $date = $split[0];
    }
    // autotime - removes the time element if its blank
    if ($datestyle == 'autotime') {
        $split = explode(' ', $rawdate);
        $date = $split[0];
        $time = $split[1];
        if ($time != '00:00:00') {
            $date = $rawdate;
        }
    }
    // dd - just the day
    if ($datestyle == 'dd') {
        $split = explode(' ', $rawdate);
        $split = explode('-', $split[0]);
        if (isset($split[2])) {
            $date = $split[2];
        }
    }
    // mm - just the month
    if ($datestyle == 'mm') {
        $split = explode(' ', $rawdate);
        $split = explode('-', $split[0]);
        if (isset($split[1])) {
            $date = $split[1];
        }
    }
    // yr - just the year
    if ($datestyle == 'yr') {
        $split = explode(' ', $rawdate);
        $split = explode('-', $split[0]);
        if (isset($split[0])) {
            $date = $split[0];
        }
    }
    // dd,mm,yr
    if ($datestyle == 'dd,mm,yr') {
        $date = date("j-n-Y", strtotime($rawdate));
    }
    // mm,dd,yr
    if ($datestyle == 'mm,dd,yr') {
        $date = date("n-j-Y", strtotime($rawdate));
    }
    //yr,mm,dd,hr,mi,ss
    if($datestyle == 'yr,mm,dd,hr,mi,ss') {   
        $date = date("j-M-Y  g:i", strtotime($rawdate));
    }
    if (!isset($date)) {
        $date = FALSE;
    }
    return($date);
}

// }}}
// {{{ splitItemkey()

/**
* splitItemkey()
* splits an itemkey and returns only the three letter mod code
*
* @param string $itemkey  the itemkey to be split
*
* @return string $mod  just the three letter mod code
* @access public
* @since 0.6
*/

function splitItemkey($itemkey)
{
    if ($itemkey) {
        $split = explode('_', $itemkey);
        if (isset($split[0])) {
            $mod = $split[0];
            return $mod;
        } else {
            return FALSE;
        }
    } else {
        echo "itemval was not set in splitItemkey";
        return FALSE;
    }
}

// }}}
// {{{ splitItemval()

/**
*
* splits an itemval and returns only the number.
*
* @param string $itemval  the itemvalue to be split
* @param string $ste_cd  an optional flag to return the site code not the number
*
* @return string $val  only the number element of the itemval
* @access public
* @since 0.6
*
* If TRUE is supplied to the $ste_cd param it will return the site code instead
* of the number
*/

function splitItemval($itemval, $ste_cd=FALSE)
{
    if (!$itemval) {
        return FALSE;
    };
    $split = explode('_', $itemval);
    if (isset($split[1])) {
        $val = $split[1];
    }
    if ($ste_cd) {
        $val = $split[0];
    }
    if (isset($val)) {
        return($val);
    } else {
        return FALSE;
    }
}

// }}}
// {{{ unsetModSetting()

/**
* unsets a var in the mod setting array (overwrites or sets fresh)
*
* @param string $mod  the mod_short to identify the module
* @param string $varname  the name of the var to unset
* @return bool $ret  true/false
* @author Guy Hunt
* @since v0.8
*
*/

function unsetModSetting($mod, $varname)
{
    // setup the name of the global settings/object for this module
    $mod_obj_name = 'mod_'.$mod;
    // global this live var
    global $_SESSION;
    $mod_obj = $_SESSION[$mod_obj_name];
    if (!isset($mod_obj) or !$mod_obj) {
        echo "ADMIN ERROR: The mod settings function can't find the settings array/object '$mod_obj_name'<br/>";
        return(FALSE);
    }
    unset($mod_obj[$varname]);
    $_SESSION[$mod_obj_name] = $mod_obj;
    return(TRUE);
}

// }}}


// THIS SECTION DEALS WITH FUNCTIONS THAT ARE USED IN ARK, BUT ARE ONLY
// COMPATABILE WITH PHP5. IF YOU FIND ANY FUNCTIONS THAT ARE NOT COMPATIABLE
// WITH PHP4 THEN ADD THEM HERE. YOU WILL FIRST NEED TO CHECK THEY ARE NOT
// ALREADY DEFINED

//array_diff_key THIS FUNCTION IS NOT COMPATIBLE WITH PHP4

if (!function_exists('array_diff_key')){

    function array_diff_key()
        {
            $arrs = func_get_args();
            $result = array_shift($arrs);
            foreach ($arrs as $array) {
                foreach ($result as $key => $v) {
                    if (array_key_exists($key, $array)) {
                        unset($result[$key]);
                    }
                }
            }
            return $result;
        }

}
?>
