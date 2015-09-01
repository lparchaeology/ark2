<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* markup_admin/left_panel.php
*
* Left panel in markup admin
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
* @category   markup
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/markup_admin/left_panel.php
* @since      File available since Release 0.6
*/

$alphabet = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
$current_letter = reqArkVar('current_letter', 'a');

printf("<h1>%s</h1>\n", getMarkup('cor_tbl_markup', $lang, 'markupadminoptions'));

print("<ul class=\"markuplpanel\">\n");
$var = "<li><a href=\"{$_SERVER['PHP_SELF']}?view=add_mkup\">Add New Markup</a></li>";
$var .= "<li><a href=\"" . $ark_dir . "php/markup_admin/export_mkup.php?&amp;output=XHTML\">Batch Translate Markup</a></li>";
$var .= "<li>Edit Markup (below)</li>";
echo $var;
foreach ($alphabet as $key => $letter) {
    if ($letter != $current_letter) {
        // just the letter
        print("<li><a href=\"{$_SERVER['PHP_SELF']}?view=home&amp;current_letter=$letter\">$letter</a></li>\n");
    } else {
        // the list for this letter
        print("<li>\n<ul>\n");
        //get the markup with nnames under this letter
        $mkuplist = getMulti('cor_tbl_markup', "nname LIKE '$letter%' ORDER BY nname");
        if ($mkuplist) {
            foreach ($mkuplist as $key => $mkup) {
                // print out the link
                print("<li><a href=\"{$_SERVER['PHP_SELF']}?view=view_mkup&amp;mk_id={$mkup['id']}\">$letter - {$mkup['nname']} - {$mkup['language']}</a></li>\n");
            }
        } else {
            print("<li><em>$letter</em></li>\n");
        }
        print("</ul>\n</li>\n");
    }
}
print("</ul>\n");

?>
