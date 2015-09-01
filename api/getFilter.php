<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* getFilter.php    
*
* this is a wrapper page to used within the API architecture for get functions
* this page retrieves a list of items as a result of a saved filter
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
* @category   api
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/api/getFilter.php
* @since      File available since Release 1.1
*/

//this file is included by the API wrapper page - the point of this page is to return data from the get functions
//that can be read programmtically. 

// NOTE 1 : Currently although this has potential to present all the filter functionality - we are limiting it to
// a free text search and retrieving a previously saved filter. The filter building process is multi-step and too
// complicated currently for an asynchronous API to handle

// -- REQUESTS -- //

$format = reqQst($_REQUEST, 'format');
if (!$format) {
    $format = 'json';
}

$ftype = reqQst($_REQUEST, 'ftype');
$src = reqQst($_REQUEST, 'src');
$retftrset = reqQst($_REQUEST, 'retftrset');
$retfields = reqQst($_REQUEST, 'retfields');

// -- SETUP VARS -- //
$errors = 0;
$output_data = array();

//all of the requests for filters are handled within the filter code, but we want to control what is allowed

//first make sure we reset any previous filters to prevent sessions being confused and spoof an id into the querystring

$_REQUEST['reset'] = 1;
$_REQUEST['ftr_id'] = 'getFilter';

//now do some checks to lockdown the functionality

if (!$ftype && !$src && !$retftrset) {
    echo "ADMIN ERROR: getFilter requires either ftype and src or retftrset";
    $error + 1;
}

if ($ftype) {
    
    if ($ftype != 'ftx' OR !$src) {
        echo "ADMIN ERROR: currently getFilter only works for free-text searches (ftype=ftx). If you have specifed ftype=ftx and you are still getting this message you also need to specifiy the search term src=searchterm";
        $error + 1;
    }
}

if ($retftrset && !is_numeric($retftrset)) {
    echo "ADMIN ERROR: the retftrset needs to be numeric - the id of saved filters can be obtained by using the describeFilters API method";
    $error + 1;
}

//now check we have no errors - if so run the bad boy - this is basically a wrapper for the filters.php page
if ($errors == 0) {
    
    //include the filters code - this will do all of the requesting that we need and should result in a results array
    include('php/data_view/filters.php');
    
    if ($results_array) {
        
        $output_data = $results_array;
        
        if ($retfields != FALSE) {
            // ---- PROCCESS RESULTS ---- //
            // select the function to be used to return the exported results
            $mk_func = 'mkResultsJson';
            // if there are results - run the output function
            if ($results_array) {
                $result_output = $mk_func($results_array, $filters);
            } else {
                // no results have been returned
                if ($filters_exec == 'on') {
                    $message[] = $mk_norec;
                } else {
                    // Offer a message saying to add a filter
                    $message[] = $mk_nofilters;
                    // manually send this msg to the main area (left panel will report and remove the $message[] above)
                    $result_output = "<div class=\"dv_feedback\"><div id=\"message\"><p>$mk_nofilters</p></div></div>\n";
                }
            }
            $output_data['fields'] = $result_output;
        }
    }
    if ($output_data) {
        switch ($format) {
            case 'json':
                //we need to pretty up the JSON
                $output_data = json_encode($output_data);
                header('Content-Type: application/json');;
                echo $output_data;
                break;

            default:
                printPre($output_data);
                break;
        }
    } 
}

?>
