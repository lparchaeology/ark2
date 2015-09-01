<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* subforms/sf_spanmatrix.php
*
* global subform for dealing with spans in matrix format
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
* @category   subforms
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Henriette Roued <henriette@roued.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_spanmatrix.php
* @since      File available since Release 0.6
*
* NOTE 1: since 0.6 this script has been globalised by HRO to work with all modules
*
* NOTE 2: since 0.6 this script has been renamed
*
* NOTE 3: since 1.1 ARK no longer supports IE6
*
*/


// -- OPTIONS -- //
// decide whether to have fancy labelling
if (array_key_exists('op_fancylabels', $sf_conf)) {
    $conf_att = $sf_conf['op_fancylabels'];
} else {
    $conf_att = FALSE;
}
$conf_att_dir = $sf_conf['op_fancylabel_dir'];
$conf_spantype = $sf_conf['op_spantype'];
$conf_span_id = getClassType('span', $conf_spantype);

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}


// -- PROCESS -- //
// this sf uses the old 'companion script' method (deletes are handled at the page level)
if ($update_db == 'matadd') {
    include_once('php/validation_functions.php');
    include_once('php/subforms/update_spanmatrix.php');
}


// -- COMMON -- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$op_input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
$op_label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);
$mk_delete = getMarkup('cor_tbl_markup', $lang,'delete');

// -- DATA -- //

//First get all the later than relationships, work out the first for styling. Loop through each id getting further information and attributes for styling finally close the row out with the 'add' form

// Second do the same for the earlier contexts

// LATER THAN SPANS

$sql = "
    SELECT id, beg
    FROM cor_tbl_span
    WHERE itemkey = ?
    AND end = ?
    AND spantype = ?
    ORDER BY beg
";
$params = array($sf_key,$sf_val,$conf_span_id);
$sql = dbPrepareQuery($sql,__FUNCTION__);

//get the counts
$later_sql = dbExecuteQuery($sql,$params,__FUNCTION__);
$later_result = $later_sql->fetchAll(PDO::FETCH_ASSOC);
$num_later_rows = count($later_result);
unset($sql);

// Discover the span id of the first span in the array
if ($num_later_rows > 0) {
    $first_later_than = $later_result[0]['id'];
    $last_later_than = $later_result[$num_later_rows-1]['id'];
    // Sadly MSIE needs a hack
    if ($browser == 'OLD_MSIE') {
        $force_padding = 'padding-bottom: 16px; ';
    } else {
        $force_padding = FALSE;
    }
    $bg_img_lform = "{$force_padding}background-image: url($skin_path/images/matrix/later_than_last.png)";
} else {
    $bg_img_lform = FALSE;
}

if ($num_later_rows > 0) {
    foreach($later_result as $later_row) {
        $span_id = $later_row['id'];
        //Set up the image overide for the first element
        if ($span_id == $first_later_than) {
            $bg_img = " style=\"background-image: url($skin_path/images/matrix/later_than_first.png)\"";
        } else {
            $bg_img = " style=\"background-image: url($skin_path/images/matrix/later_than_middle.png)\"";
        }
        // Set up the code with brackets if requested in the configuration
        $later_mod_cd = $later_row['beg'];
        if (array_key_exists('op_brackets',$sf_conf)){
            $later_mod_no = cxtBr($later_mod_cd, $conf_br);
        } else{
            $later_mod_no = $later_mod_cd;
        }
        // Set up code for the delete button
        $del_sw = "<a class=\"delete\" href=\"{$_SERVER['PHP_SELF']}";
        $del_sw .= "?$sf_key={$sf_val}&amp;update_db=delfrag&amp;dclass=span";
        $del_sw .= "&amp;delete_qtype=del&amp;frag_id=$span_id\">";
        $del_sw .= "<img class=\"delete\"  src=\"$skin_path/images/plusminus/delete.png\" alt=\"$mk_delete\" />";
        $del_sw .= "</a>";
        // remove this del_sw for view states
        if ($sf_state == 'p_max_view' or $sf_state == 's_max_view'or $sf_state == 'transclude')  {
            $del_sw = FALSE;
        }
        // Set up the html for simple matrices
        if ($conf_att != 'on') {
            $later_than_simple = "
                <li class=\"lthn\"$bg_img>
                $del_sw
                <a class=\"ltr\" href=\"{$_SERVER['PHP_SELF']}?itemkey=$sf_key&amp;$sf_key=$later_mod_cd\">$later_mod_no</a>
                </li>
            ";
            
            if ($sf_state == 'transclude') {
                $later_than_simple = "
                    <li class=\"lthn\"$bg_img>
                    <a href=\"#\" class=\"ltr\">$later_mod_no</a>
                    </li>
                ";
            }
        }
        // Set up the html for fancy matrices
        if ($conf_att == 'on') {
            //Get the fancy value using a function
            if ($conf_att_dir == 'topdown') {
                // Get the label for this span
                $labalias = getSpanAttr($span_id, 'alias', 1);
            }
            if ($conf_att_dir == 'centric') {
                $labalias = getSpanAttr($span_id, 'alias', 2);
            }
            $later_than_simple = "
                <li class=\"lthn\"$bg_img>
                $del_sw
                <a class=\"ltr\" href=\"{$_SERVER['PHP_SELF']}?itemkey=$sf_key&amp;$sf_key=$later_mod_cd\">$later_mod_no</a>
                <p class=\"ltr\">$labalias</p>
                </li>
            ";
            if ($sf_state == 'transclude') {
                $later_than_simple = "
                       <li class=\"lthn\"$bg_img>
                    <a href=\"#\" class=\"ltr\">$later_mod_no</a>
                    <p class=\"ltr\">$labalias</p>
                    </li>
                ";
            }
        }
        // Store the html in an array for use below
        $later_than_array[] = ($later_than_simple);
    };
}

// EARLIER THAN SPANS

$sql = "
    SELECT id, end
    FROM cor_tbl_span
    WHERE itemkey = ?
    AND beg = ?
    AND spantype = ?
    ORDER BY end
";

$params = array($sf_key,$sf_val,$conf_span_id);
$sql = dbPrepareQuery($sql,__FUNCTION__);

//get the counts
$earlier_sql = dbExecuteQuery($sql,$params,__FUNCTION__);
$earlier_result = $earlier_sql->fetchAll(PDO::FETCH_ASSOC);
$num_earlier_rows = count($earlier_result);

//$sql = dbExecuteQuery($sql,$params,__FUNCTION__);

//Discover the span id of the first span in the array
if ($num_earlier_rows > 0) {
    $first_earlier_than = $earlier_result[0]['id'];
    $last_earlier_than = $earlier_result[$num_earlier_rows-1]['id'];
    // Sadly MSIE needs a hack
    if ($browser == 'OLD_MSIE') {
        $force_padding = 'padding-top: 18px; ';
    } else {
        $force_padding = FALSE;
    }
    $bg_img_eform = "{$force_padding}background-image: url($skin_path/images/matrix/earlier_than_last.png)";
} else {
    $bg_img_eform = FALSE;
}


if ($num_earlier_rows > 0) {
    foreach ($earlier_result as $earlier_row){
        $span_id = $earlier_row['id'];
        //Set up the styling for the first element
        if ($span_id == $first_earlier_than) {
            $bg_img = " style=\"background-image: url($skin_path/images/matrix/earlier_than_first.png)\"";
        } else {
            $bg_img = " style=\"background-image: url($skin_path/images/matrix/earlier_than_middle.png)\"";
        }
        // Set up the context code
        $earlier_mod_cd = $earlier_row['end'];
        if (array_key_exists('op_brackets',$sf_conf)){
            $earlier_mod_no = cxtBr($earlier_mod_cd, $conf_br);
        } else {
            $earlier_mod_no = $earlier_mod_cd;
        }
        // Set up code for the delete button
        $del_sw = "<a href=\"{$_SERVER['PHP_SELF']}";
        $del_sw .= "?$sf_key={$sf_val}&amp;update_db=delfrag&amp;dclass=span";
        $del_sw .= "&amp;delete_qtype=del&amp;frag_id=$span_id\">";
        $del_sw .= "<img class=\"smalldelete\"  src=\"$skin_path/images/plusminus/delete_small.png\" alt=\"delete\" />";
        $del_sw .= "</a>";
        // remove this del_sw for view states
        if ($sf_state == 'p_max_view' or $sf_state == 's_max_view' or $sf_state == 'transclude') {
            $del_sw = FALSE;
        }
        // Set up the html for simple matrices
        if ($conf_att != 'on') {
            $earlier_than_simple = "
                <li class=\"ethn\"$bg_img>
                <a class=\"erl\" href=\"{$_SERVER['PHP_SELF']}?itemkey=$sf_key&amp;$sf_key=$earlier_mod_cd\">$earlier_mod_no</a>
                $del_sw
                </li>
            ";

        if ($sf_state == 'transclude') {
            $earlier_than_simple = "
                    <li class=\"ethn\"$bg_img>
                  <a href=\"#\" class=\"erl\">$earlier_mod_no</a>
                  </li>
            ";
        }

        }
        // Set up the html for fancy matrices
        if ($conf_att == 'on') {
            //Get the fancy value using a function
            $labalias = getSpanAttr($span_id, 'alias', 1);
            $earlier_than_simple = "
                <li class=\"ethn\"$bg_img>
                <p class=\"erl\">$labalias</p>
                <a href=\"{$_SERVER['PHP_SELF']}?itemkey=$sf_key&amp;$sf_key=$earlier_mod_cd\" class=\"erl\">$earlier_mod_no</a>
                $del_sw
                </li>
            ";

            if ($sf_state == 'transclude') {
                  $earlier_than_simple = "
                        <li class=\"ethn\"$bg_img>
                        <p class=\"erl\">$labalias</p>
                        <a href=\"#\" class=\"erl\">$earlier_mod_no</a>
                        </li>
                    ";
            }
        }
        // Store the html in an array for use below
        $earlier_than_array[] = ($earlier_than_simple);
    };
}

// FORMS (there are 4 forms to set up shared elements first)

// SHARED ELEMENTS
$matrix_form = "
    <form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">
    <fieldset>
    <input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n
    <input type=\"hidden\" name=\"$sf_key\" value=\"{$sf_val}\" />
    <input type=\"hidden\" name=\"update_db\" value=\"matadd\" />
";

// LATER THAN FORMS
// Set up the LATER form for simple matrices
if ($sf_state == 'p_max_view' or $sf_state == 's_max_view') {
    $submit = FALSE;
} else {
    $submit = "<input type=\"submit\" class=\"clean_but\" value=\"+\" />";
}
if ($conf_att != 'on') {
    $later_than_form = "
        <li class=\"lthn\" style=\"$bg_img_lform\">
            $matrix_form
                <input type=\"hidden\" name=\"end\" value=\"{$sf_val}\" />
                <input type=\"text\" name=\"beg\" style=\"width:50px; margin:0px\" />
                $submit
                </fieldset>
            </form>
        </li>
    ";
}
// Set up the LATER form for fancy matrices
if ($conf_att == 'on') {
    // Set up the dropdown of span attributes for this spantype
    if ($conf_att_dir == 'centric') {
        $attrdd = ddAlias('', '', 'cor_lut_spanlabel', $lang, 'spanlabelid', "AND spantype = '$conf_span_id' AND aliastype=2", 'code');
    } else {
        $attrdd = ddAlias('', '', 'cor_lut_spanlabel', $lang, 'spanlabelid', "AND spantype = '$conf_span_id' AND aliastype=1", 'code');
    }
    $later_than_form = "
        <li class=\"lthn\" style=\"$bg_img_lform\">
            $matrix_form
                <input type=\"hidden\" name=\"end\" value=\"{$sf_val}\" />
                <span class=\"ltr\">
                    <input type=\"text\" name=\"beg\" style=\"width:50px; margin:0px\" />
                    <input type=\"submit\" class=\"clean_but\" value=\"+\" />
                </span>
                <span class=\"ltr\">$attrdd</span>
                </fieldset>
            </form>
        </li>
    ";
}
// EARLIER THAN FORMS
// Set up the EARLIER form for simple matrices
if ($conf_att != 'on') {
    $earlier_than_form = "
        <li class=\"ethn\" style=\"$bg_img_eform\">
            $matrix_form
                <input type=\"hidden\" name=\"beg\" value=\"{$sf_val}\" />
                <input type=\"text\" name=\"end\" style=\"width:50px; margin:0px\" />
                $submit
                </fieldset>
            </form>
        </li>
    ";
}
// Set up the EARLIER form html for fancy matrices
if ($conf_att == 'on') {
    // Set up the dropdown of span attributes for this spantype
    $attrdd = ddAlias('', '', 'cor_lut_spanlabel', $lang, 'spanlabelid', "AND spantype = '$conf_span_id' AND aliastype=1", 'code');
    $earlier_than_form = "
        <li class=\"ethn\" style=\"$bg_img_eform\">
            $matrix_form
                <input type=\"hidden\" name=\"beg\" value=\"{$sf_val}\" />
                <span class=\"erl\">$attrdd</span>
                <span class=\"erl\">
                    <input type=\"text\" name=\"end\" style=\"width:50px; margin:0px\" />
                    <input type=\"submit\" class=\"clean_but\" value=\"+\" />
                </span>
                </fieldset>
            </form>
        </li>
    ";
}



// OUTPUT

// Open the div- this is not compliant and will need to be corrected
// to comply with standard subform architecture
// Agreed GH 30/8/11

print("<div id=\"matrix\" class=\"{$sf_cssclass}\">");

switch ($sf_state) {
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        break;
        
    case 'p_max_edit':
    case 'p_max_ent':
    case 's_max_edit':
    case 's_max_ent':
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // a three item list holding the three rows of the matrix
        print("<ul class=\"matrix_rows\">\n");
    
        // first row (first <li>)
        print("<li>\n");
        // print a clean html list of the items in this row
        print("<ul id=\"later_tvects\" class=\"matrix_row\">");
        // list of the later than items
        if (isset($later_than_array)) {
            // loop over the items
            foreach ($later_than_array AS $later_mat) {
                printf($later_mat);
            }
        }
        // put in the add form
        printf($later_than_form);
        // close the list cleanly
        print("</ul>");
        // end the first row (first <li>)
        print("</li>");
        
        //middle row (second <li>)
        printf("
            <li>
                <ul class=\"matrix_row\">
                    <li class=\"middle\"><a href=\"#\">%s</a></li>
                </ul>
            </li>
        ", $sf_val);
        
        // bottom row (third <li>)
        print("<li>");
        print("<ul id=\"earlier_tvects\" class=\"matrix_row\">");
        // list the earlier items
        if (isset($earlier_than_array)) {
            foreach ($earlier_than_array as $earlier_mat) {
                printf($earlier_mat);
            }
        }
        //put in the add form
        printf($earlier_than_form);
        // close the list cleanly
        print("</ul>");
        // end the last row (third <li>)
        print("</li>");
        print("</ul>");
        break;
        
    case 'p_max_view':
    case 's_max_view':
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // a three item list holding the three rows of the matrix
        print("<ul class=\"matrix_rows\">\n");
    
        // first row (first <li>)
        print("<li>\n");
        // print list of the items in this row
        print("<ul id=\"later_tvects\" class=\"matrix_row\">");
        // loop over the the later than items
        if (isset($later_than_array)) {
            // loop over the items
            foreach ($later_than_array as $later_mat) {
                printf($later_mat);
            }
        } else {
            // In a view mode advise the user that no later than are set
            print("[not set]");
            $lthn_empty = TRUE;
        }
        // Put in a last item if this list is populated
        if (isset($later_than_array)) {
            // DEV NOTE: this should improved to just put the
            // relevant background onto the last item in the row in future.
            print("<li class=\"lthn\" style=\"$bg_img_lform\">");
            print("<a href=\"#\">Edit</a>"); // MSIE needs this to be a link (style reasons)
            print("</li>\n");
        }
        // close the list cleanly
        print("</ul>");
        // end the first row (first <li>)
        print("</li>");
        
        //middle row (second <li>)
        printf("
            <li>
                <ul class=\"matrix_row\">
                    <li class=\"middle\"><a href=\"#\">%s</a></li>
                </ul>
            </li>
        ", $sf_val);
        
        // bottom row (third <li>)
        print("<li>");
        print("<ul id=\"earlier_tvects\" class=\"matrix_row\">");
        // list the earlier items
        if (isset($earlier_than_array)) {
            foreach ($earlier_than_array as $earlier_mat) {
                printf($earlier_mat);
            }
        } else {
            print("[not set]");
        }
        // Put in a last item if this list is populated
        if (isset($earlier_than_array)) {
            // DEV NOTE: see above
            print("<li class=\"ethn\" style=\"$bg_img_eform\">");
            print("<a href=\"#\">Edit</a>"); // MSIE needs this to be a link (style reasons)
            print("</li>\n");
        }
        print("</ul>\n");
        // end the last row (third <li>)
        print("</li>\n");
        print("</ul>\n");
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_spanmatrix\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_spanmatrix was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
    } // ends switch
    echo "</div>";
?>
