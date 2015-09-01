/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* dyn_dd.js
*
* this is the js file that creates a dynamic dropdown (i.e more than one of sf_attr_bytype)
*
* Javascript > 1.7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with
*    archaeological data
*    Copyright (C) 2009  L - P : Partnership Ltd.
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
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2007 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/js/dyn_dd.js
* @since      File available since Release 0.7
*
*/

function dyn_dd (dropdown_name){
    
    elems = document.getElementsByName(dropdown_name);
    
    for( var x = 0; x < elems.length; x++ ) {
        
        new_dd = elems[x].cloneNode(true);
        parent = elems[x].parentNode;
        parent.appendChild(new_dd);
        break;
        
    }
    
}