<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_view/subforms/sf_rssfeed.php
*
* a data_view subform displaying one or more formatted RSS feeds
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
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_view/subforms/sf_rssfeed.php
* @since      File available since Release 0.8
*
* This SF is expected to run in an overlay or in the left panel. Standard states could be
* added to allow this to function as a normal SF if any reason for that became apparent.
*
* Getting the right sf_conf requires a small piece of non-standard behaviour. Typically,
* an SF will be passed an sf_conf to it in the form of $sf_conf and it is not required to
* question this. In the case of SFs displayed within the overlay_holder.php, this parent
* script must get an sf_conf based on the name of the variable passed to the querystring.
* As this form may be triggered from a non module specific page (eg data_view.php), it must
* figure out if the result set being exported is the same as the module that overlay_holder
* has selected. If not, the relevant settings file is called and the sf_conf is switched.
*
* NB: overlay_holder.php tries to figure out a module based on the sf_key it is sent. If
* it is not sent an sf_key, it will fall back on a default (as per reqArkVar()).
*
*/

// ---- SETUP ---- //

//get the rss feed document(s)

if (array_key_exists('feed_url',$sf_conf)) {
        $feed_var = '';
        foreach ($sf_conf['feed_url'] as $url) {
        $dom = new DOMDocument();
        $rss_feed = file_get_contents($url);
        //echo "rss: " . $rss_feed;
        try{
        if(!$dom->loadXML($rss_feed)){
            throw new Exception($err_markup);
            }    
        }
        catch(Exception $e){
            echo $e->getMessage();
            //exit();
        }
        $array_dom = dom_to_array($dom);
        //as of course RSS should always be to a specific standard - this array should be standardised
        //therefore print out the header of each RSS feed and then output the items one by one
        $feed_var .= '<div class="frm_subform">';
        if (array_key_exists('rss', $array_dom) && array_key_exists('channel', $array_dom['rss'])) {
            $title = $array_dom['rss']['channel']['title'];
            $link = $array_dom['rss']['channel']['link'];
            $desc = $array_dom['rss']['channel']['description'];
            $feed_var .= "<ul>";
            $feed_var .= '<li class="recordarea">';
            $feed_var .= "<h2><span><a href=\"$link\" target=\"_blank\">$title</a> - $desc</span></h2>";
            if (array_key_exists('item',$array_dom['rss']['channel'])) {
                $feed_var .= '<ul>';
                foreach ($array_dom['rss']['channel']['item'] as $item_value) {
                    $feed_var .= '<li class="row">';
                    $feed_var .= '<ul>';
                    $feed_var .= "<li><span><a target=\"_blank\" href=\"{$item_value['link']}\">{$item_value['title']}</a></span></li>";
                    //DEV NOTE: Need to update this to deal with parsing CDATA
                    if (!is_array($item_value['description'])) {
                        $feed_var .= "<li><span><p>{$item_value['description']}</p></span></li>";
                    }
                    if (array_key_exists('pubDate',$item_value)) {
                        $feed_var .= "<li><span class=\"data\">{$item_value['pubDate']}</span></li>";
                    }
                    $feed_var .= '</ul>';
                    $feed_var .= '</li>';
                }
                $feed_var .= '</ul>';
            }
            $feed_var .= '</li>';
            $feed_var .= "</ul>";
        }
        $feed_var .= "</div>";
    }
} else {
    echo "ADMIN ERROR: Please specify an array of one or more RSS feed URLs in the sf_conf";
}


// Labels and so on
$mk_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

// CSS
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// ---- STATE SPECFIC
// for each state get specific elements and then produce output
switch ($sf_state) {
    // Overlays
    case 'overlay':
        echo "This is not yet setup for overlays";
        break;
        
    case 'lpanel':
    case 'p_max_view':
    case 's_max_view':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        printf(sfNav($mk_title, $cur_col_id, $cur_sf_id, $$disp_cols));

        echo $feed_var;

        // close out the sf
        echo "</div>";
        
    break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_rssfeed\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_rssfeed was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;
// ends switch
}
// clean up
unset ($sf_conf);
unset ($sf_state);

?>
