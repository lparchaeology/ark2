/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* js_functions.js
*
* this is a javascript file used to contain all custom ARK js functions
*
* Javascript
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with
*    archaeological data
*    Copyright (C) 2007  L - P : Partnership Ltd.
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
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2009 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/js/js_functions.js
* @since      File available since Release 0.8
*/

// {{{ js_submit()

/**
* submits a form using JS
*
* 
* @param string sf_name  the name of the form be submitted
* @return void
* @access public
* @author Stuart Eve
* @since 0.8
*
* This is in use to gather user input and send a valid URL to the update_db
* script. This is in use in forms such as the dynamic sf_attribute forms.
*
*/

function js_submit(sf_name)
{
    var url_array = {};
    var radio_groups = new Array();
    var checkbox_groups = new Array();
    var url = new String();
    
    for( var x = 0; x < document.forms.length; x++ ) {
        
        if (document.forms[x].id.search(sf_name) > 0 ) {
        
            var form = document.forms[x];
            
            //now we have the relevant forms - we need to go through the elements discovering what we need
            
            for( var i = 0; i < form.elements.length; i++ ) {
                
                switch(form.elements[i].type) {
                    case 'radio':
                        radio_name = form.elements[i].name;
                        if (!array_key_exists(radio_name,radio_groups)) {
                            //we first need to check if the selection has been changed
                            //loop through the elements in the radio group to see what needs to be done
                            for (var radio_int=0; radio_int < form.elements[radio_name].length; radio_int++) {
                                radio_groups[radio_name] = 1;
                                //check for delete           
                                if (!form.elements[radio_name][radio_int].checked && form.elements[radio_name][radio_int].id) {
                                    //looks like we might be on a delete routine
                                    delete_frag = form.elements[radio_name][radio_int].id.split('_');
                                    
                                    if (delete_frag[0] == 'delete') {
                                        //do the delete
                                        current_url = parseUri(location.href);
                                        //we need to grab the hidden values in the form to add to delete url
                                        for( var i = 0; i < form.elements.length; i++ ) {
                                             if (form.elements[i].type == 'hidden') {
                                                 async_url_hidden = 'micro_view.php?' + form.elements[i].name + '=' + form.elements[i].value;
                                             };
                                        }
                                        async_url = async_url_hidden + '&update_db=delfrag&dclass=attribute&delete_qtype=del&frag_id=' + delete_frag[1];
                                        submitAsyncURL(async_url);
                                    }
                                    
                                } else if (form.elements[radio_name][radio_int].checked) {
                                    
                                    //double check this isn;t the original
                                    orig_frag = form.elements[radio_name][radio_int].id.split('_');
                                    if (orig_frag[0] != 'original') {
                                        //we need to add this one then
                                        url_array[radio_name] = form.elements[radio_name][radio_int].value;
                                    };
                                };
                            };
                        }
                        break;
                        
                    case 'checkbox':
                        checkbox_name = form.elements[i].name;
                        if (!array_key_exists(checkbox_name,checkbox_groups)) {
                            //we first need to check if the selection has been changed
                            //loop through the elements in the checkbox group to see what needs to be done
                            for (var checkbox_int=0; checkbox_int < form.elements[checkbox_name].length; checkbox_int++) {
                                checkbox_groups[checkbox_name] = 1;
                                //check for delete           
                                if (!form.elements[checkbox_name][checkbox_int].checked && form.elements[checkbox_name][checkbox_int].id) {
                                    //looks like we might be on a delete routine
                                    delete_frag = form.elements[checkbox_name][checkbox_int].id.split('_');

                                    if (delete_frag[0] == 'delete') {
                                        //do the delete
                                        current_url = parseUri(location.href);
                                        //we need to grab the hidden values in the form to add to delete url
                                        for( var i = 0; i < form.elements.length; i++ ) {
                                             if (form.elements[i].type == 'hidden') {
                                                 async_url_hidden = 'micro_view.php?' + form.elements[i].name + '=' + form.elements[i].value;
                                             };
                                        }
                                        async_url = async_url_hidden + '&update_db=delfrag&dclass=attribute&delete_qtype=del&frag_id=' + delete_frag[1];
                                        submitAsyncURL(async_url);
                                    }

                                } else if (form.elements[checkbox_name][checkbox_int].checked) {

                                    //double check this isn;t the original
                                    orig_frag = form.elements[checkbox_name][checkbox_int].id.split('_');
                                    if (orig_frag[0] != 'original') {
                                        //we need to add this one then
                                        //first we need to check if the current form element has already been added to the url_array
                                        //if it has then we are trying to add multiple entries

                                        if (array_key_exists(checkbox_name, url_array)) {

                                           //we have an entry already - so we need to start the iteration process
                                           //first check if this is the first multi entry
                                           //if this is not the first time then just continue iterating
                                           if (url_array['multi_' + checkbox_name] >= 2) {

                                               //get the number to append
                                               n = url_array['multi_' + checkbox_name];
                                               //if we have a 2 we need to make it 3 (to prevent overwriting exising element)
                                               if (n == 2) { n++ };
                                               //append the number to the variable key and add to array
                                               url_array[checkbox_name + '-' + n] = form.elements[checkbox_name][checkbox_int].value;
                                               //increment the number
                                               url_array['multi_' + checkbox_name] = n + 1;

                                           } else {

                                               //this means its the first time, meaning we need to set the orignal to be 1 
                                               //and then continue appending
                                               //first rename the original
                                               url_array[checkbox_name + '-1'] = url_array[checkbox_name];
                                               //set the original so update_db knows that it needs to look for a multi
                                               url_array[checkbox_name] = "multi";

                                               //finally add the new one
                                               url_array[checkbox_name + '-2'] = form.elements[checkbox_name][checkbox_int].value;
                                               //and increment the iterator
                                               url_array['multi_' + checkbox_name] = 2;

                                           }
                                        };

                                        //if we are not dealing with multis - just add as normal
                                        if (!array_key_exists('multi_' + checkbox_name, url_array) && form.elements[checkbox_name][checkbox_int].value) {
                                            url_array[checkbox_name] = form.elements[checkbox_name][checkbox_int].value;
                                        }
                                        //url_array[checkbox_name] = form.elements[checkbox_name][checkbox_int].value;
                                    };
                                };
                            };
                        }

                        break;
                        
                    case 'hidden':
                        //alert ("hidden: " + form.elements[i].name + " value: " + form.elements[i].value);
                        
                        if (url_array[form.elements[i].name] == null) {
                                                        
                            url_array[form.elements[i].name] = form.elements[i].value;

                        };
                        
                        break;
                        
                    case 'select-one':
                    
                        //first we need to check if the current form element has already been added to the url_array
                        //if it has then we are trying to add multiple entries
                        
                        if (form.elements[i].value && array_key_exists(form.elements[i].name, url_array)) {
                            
                           //we have an entry already - so we need to start the iteration process
                           //first check if this is the first multi entry
                           //if this is not the first time then just continue iterating
                           if (url_array['multi_' + form.elements[i].name] >= 2) {
                               
                               //get the number to append
                               n = url_array['multi_' + form.elements[i].name];
                               //if we have a 2 we need to make it 3 (to prevent overwriting exising element)
                               if (n == 2) { n++ };
                               //append the number to the variable key and add to array
                               url_array[form.elements[i].name + '-' + n] = form.elements[i].value;
                               //increment the number
                               url_array['multi_' + form.elements[i].name] = n + 1;
                               
                           } else {
                               
                               //this means its the first time, meaning we need to set the orignal to be 1 
                               //and then continue appending
                               //first rename the original
                               url_array[form.elements[i].name + '-1'] = url_array[form.elements[i].name];
                               //set the original so update_db knows that it needs to look for a multi
                               url_array[form.elements[i].name] = "multi";
                           
                               //finally add the new one
                               url_array[form.elements[i].name + '-2'] = form.elements[i].value;
                               //and increment the iterator
                               url_array['multi_' + form.elements[i].name] = 2;
                               
                           }
                        };
                        
                        //if we are not dealing with multis - just add as normal
                        if (!array_key_exists('multi_' + form.elements[i].name, url_array) && form.elements[i].value) {
                            url_array[form.elements[i].name] = form.elements[i].value;
                        }
                        break;
                        
                }//end of switch
            }
        }
    }
    
    //after all this we can now build the url
    var add_update_db = 0;
    
    for (var key in url_array) {
        if (url_array.hasOwnProperty(key)) {
            //split = url_array[key].toString().split(",");
            value = url_array[key];
            //grab out the update_db until we have checked that we are not skipping everything
            if (key == 'update_db') {
                update_db = key + "=" + value;
            };
            //we need to correctly set the qtypes
            if (key.indexOf('_qtype') > 0 ) {
                split_qtype = key.split("_");
                if (array_key_exists(split_qtype[0],url_array)) {
                    value = 'add';
                    add_update_db = 1;
                } else {
                    value = 'skp';
                }
            };
        
            if (key != 'update_db') {
                url = url + "&" + key + "=" + value; 
            }
        }

    };
    
    if (add_update_db > 0) {
        url = url + '&' + update_db;
    };

    current_url = parseUri(location.href);
    url = current_url['path'] + '?' + url;
    window.location = url;
  
}

// }}}
// {{{ submitAsyncURL()

/**
* submits an asyncronous URL
*
* @param
* @return void
* @since
*
* this function taken from http://www.w3schools.com/XML/xml_http.asp
*
* 
*
**/

function submitAsyncURL(url)
{
    var ajaxRequest;  // The variable that makes Ajax possible!

        try{
            // Opera 8.0+, Firefox, Safari
            ajaxRequest = new XMLHttpRequest();
        } catch (e){
            // Internet Explorer Browsers
            try{
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
            try{
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e){
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        // Create a function that will receive data sent from the server
        ajaxRequest.onreadystatechange = function(){
            if(ajaxRequest.readyState == 4){
            }
        }
        ajaxRequest.open("GET", url, false);
        ajaxRequest.send(null); 
        //we now need to make sure its done its thing before loading the rest of the page
        
        //CHECK ajaxRequest return code here!
        return ajaxRequest.responseXML;
}

// }}}

///{{{ parseCMAPStruc()

/**
* this parses over a CMAP_struc_array used when building the cmap structure
* from CSV/JSON and does some checks 
*
* 
* @param object struc_array  a filled cmap_struc_array 
* @return void
* @access public
* @author Stuart Eve
* @since 1.2
*
*
*/

function parseCMAPStruc(struc_array) {
    
    var $j = jQuery.noConflict();
    
    
}
    
    
///}}}

///{{{ parseDescribeFields()

/**
* this parses a response from the ARK API describeFields
* and outputs the field names into a nice draggable div
*
* 
* @param string url  the full API request url
* @return void
* @access public
* @author Stuart Eve
* @since 1.2
*
*
*/

function parseDescribeFields(json) {
    
    var $j = jQuery.noConflict();
    
    element = document.getElementById('available_fields');
    result_element = element;
    cmap_struc_array = [];

    //lets empty it out first
    $j(result_element).empty();
    //the API should hopefully return a nice bit of JSON
    //loop over this pulling out the fieldnames
    div = document.createElement("div");
    ul = document.createElement("ul");
    ul.setAttribute("id","field_table");
    div.appendChild(ul);
    for (var key in json) {
      if (json.hasOwnProperty(key)) {
        
        //set up the field
        li = document.createElement("li");
        li.setAttribute("class","row");
        
        row_div = document.createElement("div");
        if (json[key]['dataclass'] == 'itemkey') {
            row_div.innerHTML = key + " <b>[KEY]</b>";
        }else {
            row_div.innerHTML = key;
        };
        li.appendChild(row_div);
        
        //setup the dropzone
        
        row_div = document.createElement("div");
        row_div.setAttribute("id",key);
        row_div.setAttribute("class","dropzone");
        row_div.innerHTML = "&nbsp;";
        $j(row_div).droppable({
            drop: function( event, ui ) {
                cmap_struc_array[ui.draggable.text()] = $j(this).attr('id');
                console.log(cmap_struc_array);
                this.innerHTML = "";
                $j(this).addClass("dropped")
                if (ui.draggable.parent().attr('id') != 'import_header_list') {
                    ui.draggable.parent().removeClass("dropped")
                    parent = document.getElementById(ui.draggable.parent().attr('id'))
                    parent.innerHTML = "&nbsp;";
                };
                ui.draggable.detach().appendTo($j(this));
            }
        })
        li.appendChild(row_div);
        ul.appendChild(li);
      }
    }
    element.appendChild(div)
}
    
    
///}}}
///{{{

function update_radio(radioObj) {
    //this function takes a radio group name and then updates it accordingly (to allow for frag delete)
    //grab the radio group
    group = radioObj.name;
    form_element = radioObj.form;
    
    for (var i=0; i < form_element[group].length; i++) {
        if (form_element[group][i].id && !form_element[group][i].checked) {
            //this means we have a different radio button selected - and we should set the original for delete
            delete_id = form_element[group][i].id.split('_');
            form_element[group][i].id = "delete_" + delete_id[1];
        };
    };
}

function update_checkbox(checkboxObj) {
    //this function takes a checkbox group name and then updates it accordingly (to allow for frag delete)
    //grab the checkbox group
    group = checkboxObj.name;
    form_element = checkboxObj.form;
    
    for (var i=0; i < form_element[group].length; i++) {
        if (form_element[group][i].id && !form_element[group][i].checked) {
            //this means we have unchecked the original - and we should set the original for delete
            delete_id = form_element[group][i].id.split('_');
            form_element[group][i].id = "delete_" + delete_id[1];
        };
    };
}

function array_key_exists(key, search) {
   return (typeof search[key] != 'undefined');
}


/* parseUri JS v0.1.1, by Steven Levithan <http://stevenlevithan.com>
Splits any well-formed URI into the following parts (all are optional):
----------------------
- source (since the exec method returns the entire match as key 0, we might as well use it)
- protocol (i.e., scheme)
- authority (includes both the domain and port)
- domain (i.e., host; can be an IP address)
- port
- path (includes both the directory path and filename)
- directoryPath (supports directories with periods, and without a trailing backslash)
- fileName
- query (does not include the leading question mark)
- anchor (i.e., fragment) */

function parseUri(sourceUri)
{
    var uriPartNames = ["source","protocol","authority","domain","port","path","directoryPath","fileName","query","anchor"],
    uriParts = new RegExp("^(?:([^:/?#.]+):)?(?://)?(([^:/?#]*)(?::(\\d*))?)((/(?:[^?#](?![^?#/]*\\.[^?#/.]+(?:[\\?#]|$)))*/?)?([^?#/]*))?(?:\\?([^#]*))?(?:#(.*))?").exec(sourceUri),
    uri = {};
      for(var i = 0; i < 10; i++){
          uri[uriPartNames[i]] = (uriParts[i] ? uriParts[i] : "");
      }

      /* Always end directoryPath with a trailing backslash if a path was present in the source URI
      Note that a trailing backslash is NOT automatically inserted within or appended to the "path" key */
      if(uri.directoryPath.length > 0){
          uri.directoryPath = uri.directoryPath.replace(/\/?$/, "/");
      }

      return uri;
}

// {{{ parseQst()

/**
 * parse out the name value pairs from a querystring
 *
 * @param qst string  the querystring
 * @return qstpairs array  containing the name value pairs
 * @author Guy Hunt
 * @since v0.8
 *
 **/

function parseQst (qst) {
    // try to split the qst on question mark as we only want the stuff after that
    var toplevel = qst.split('?');
    var count_tl = 0;
    for (var i = toplevel.length - 1; i >= 0; i--){
        count_tl++;
    };
    if (count_tl > 2) {alert("The query string has more than one ? in it"); return 0};
    if (count_tl > 1) {qst = toplevel[1]} else {return 0};
    pairs = unescape((qst.replace(/\+/g," "))).split("&");
    var qstpairs = new Array();
    for (i=0;i<pairs.length;i++) {
        pairs[i]=pairs[i].split("=");
        var key = pairs[i][0];
        var val = pairs[i][1];
        qstpairs[key] = val;
    }
    return qstpairs;
}
 
// }}}
// {{{ reqQst()

/**
 * request a value from an associative array and return false if not set
 *
 * @param haystack array  the array to search in
 * @return needle string   the string you wish to locate (the key in the array)
 * @author Guy Hunt
 * @since v0.8
 *
 **/

function reqQst(needle, haystack) {
    // this is dependent on php.js!!
    if (array_key_exists(needle, haystack)) {
        return haystack[needle];
    } else {
        return 0;
    }
}
 
// }}}
// {{{ submitAsyncURLDynamic()

/**
* grabs some remote XML and dynamically updates a DOM element with its contents
*
* 
* @param string url  the URL to visit
* @param object element  a DOM element to update with result of URL request
* @param message string  a string displaying the loading message
* @param method string  the method for submission (i.e. GET or POST) - OPTIONAL (default is GET)
* @return void
* @access public
* @since 0.8
*
*/

//this function is adapted from http://www.w3schools.com/XML/xml_http.asp

function submitAsyncURLDynamic(url, element, message, method)
{
    var ajaxRequest;  // The variable that makes Ajax possible!
        if (!message) {
            message = "Loading... Please Wait";
        };
        if (!method) {
            method = "GET";
        };
        result_element = element;
        result_element.innerHTML = "<div class=\"waiting\">" + message + "</div>";
        url = parseUri(url);
        //query = encodeURIComponent(url.query);
        query = url.query;
        try{
            // Opera 8.0+, Firefox, Safari
            ajaxRequest = new XMLHttpRequest();
        } catch (e){
            // Internet Explorer Browsers
            try{
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
            try{
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e){
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        // Create a function that will receive data sent from the server
        ajaxRequest.onreadystatechange = function(){
            if(ajaxRequest.readyState == 4){
            }
        }
        
        if (method == "POST") {
            //query = escape(query);
            //ajaxRequest.onreadystatechange = stateChange;
            ajaxRequest.open(method, url.source, false);
            ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            //ajaxRequest.setRequestHeader("Content-type", "multipart/form-data;");
            ajaxRequest.setRequestHeader("Content-length", query.length);
            ajaxRequest.setRequestHeader("Connection", "close");
            ajaxRequest.send(query);
            //jQuery.post(url.source,query);
            
        } else {
            url = url.source + "?" + query;
            ajaxRequest.open(method, url, false);
            ajaxRequest.send(null); 
        };
        
        //we now need to make sure its done its thing before loading the rest of the page
        
        //CHECK ajaxRequest return code here!
        result = ajaxRequest.responseText;
        result_element.innerHTML = result;
}

// }}}
// {{{ parseGetCapabilities()

/**
* parses a WxS URL and gets back a list of available layers - turning them into a select HTML object
*
* 
* @param object url  a DOM object containing the relevant url OR a STRING holding the URL
* @param int sf_id  the id of the current subform (to be passed to the next function)
* @return void
* @access public
* @since 0.8
*/

function parseGetCapabilities(url_object, sf_id, result_element)
{
    //grab the value of the url first
    if (url_object.value) {
        var url = url_object.value;
    } else {
        var url = url_object;
    };
    if (!result_element) {
        result_element=document.getElementById("GetCapabilities");
    };
    //do some checking to make sure that we have all the right params, etc.
    url = parseUri(url);
    //INSERT CHECK HERE
    
    url = encodeURIComponent(url.source);
    
    //add the get capabilites on the end
    url = url + "%26REQUEST=GetCapabilities";
    //as we can't request XML from a different domain - we need to go via the PHP parser
    submit_url="api.php?req=XMLParser&type=GetCapabilities&url=" + url + "&sf_id=" + sf_id;
    submitAsyncURLDynamic(submit_url,result_element, '', 'POST');
    
}

// }}}
// {{{ parseGetFeatureInfo()

/**
* takes a getFeatureInfo result and turns it into something nice
*
* 
* @param string gml  the gml response from a getFeatureInfo request
* @param string result_element  the id of the element in which to place the result
* @return void
* @access public
* @since 0.8
*/

function parseGetFeatureInfo(gml_object, result_element)
{
    
    result_element = document.getElementById(result_element);
    //grab the value of the url first
    if (gml_object.value) {
        var gml = gml_object.value;
    } else {
        var gml = gml_object;
    };
    if (!result_element) {
        result_element=document.getElementById("queryResults");
    };
    
    gml = escape(gml);
    //as we can't request XML from a different domain - we need to go via the PHP parser
    submit_url="api.php?req=XMLParser&type=GetFeatureInfo&gml=" + gml;
    submitAsyncURLDynamic(submit_url,result_element,"Querying","POST");
    
}

// }}}
// {{{ hideChildren()

/**
* hides the children of the specifed element
*
* 
* @param object parentElement  the element whose children need closing
* @return void
* @access public
* @since 0.8
*/

function hideChildren(parentElement)
{
    for (var i = parentElement.childNodes.length - 1; i >= 0; i--){
        child_element = parentElement.childNodes[i];
        if (child_element.tagName == 'UL') { 
            child_element.style.display='none';
            //child_element.style.height='0px';
        };
    };
}

//}}}
//{{{ showChildren()

/**
* showss the children of the specifed element
*
* 
* @param object parentElement  the element whose children need showing
* @param object element  the element that launched the event OPTIONAL
* @return void
* @access public
* @since 0.8
*/

function showChildren(parentElement)
{
    for (var i = parentElement.childNodes.length - 1; i >= 0; i--){
        child_element = parentElement.childNodes[i];
        if (child_element.tagName == 'UL') { 
            child_element.style.display='';
            //child_element.style.height='';
        };
    };
}

// }}}
// {{{ checkAll()

/**
* checks all of the checkboxes beneath the supplied element (and swaps the images)
*
* 
* @param object element the element whose children need showing
* @param string force  if we want to force a specifc state (i.e. 'on' or 'off')
* @return void
* @access public
* @since 0.8
*/

function checkAll(element, force)
{
    if (!force) {
        //get the state of the element
       src_element = element;
       filename = src_element.src;
       orig_filename = src_element.src.split('/');
       filename = orig_filename[orig_filename.length-1];
       if (filename.indexOf("off") > -1) {
          force = "off";
       }else if (filename.indexOf("on") > -1) {
           force = "on";
       };
       element = element.parentNode.parentNode;
    };
    for (var i = element.childNodes.length - 1; i >= 0; i--){
        child = element.childNodes[i];
        if (child.tagName != 'IMG') {
            checkAll(child,force);
        } else {
            if (child.className == 'img_checkbox') {
                swapImage(child,force);
            };
        };
    };
}

// }}}
// {{{ swapImage()

/**
* swaps an image (generally used in the legend panel)
*
* 
* @param object element  an img element that needs its src swapping
* @param string force  if we want to force a specifc state (i.e. 'on' or 'off')
* @return void
* @access public
* @since 0.8
*
*/

function swapImage(element, force)
{
    //grab the current src
    if (element.tagName == "IMG") {
        element.id = "test_node";
        element = document.getElementById("test_node");
        //first we need to grab the onclick of the img - incase we need to change it dynamically
        onclick_string = String(element.onclick);
        if (onclick_string.indexOf("hideChildren") > -1) {
            onclick_string = onclick_string.replace("hideChildren", "showChildren");
        } else if (onclick_string.indexOf("showChildren") > -1) {
            onclick_string = onclick_string.replace("showChildren", "hideChildren");
        } else if (onclick_string.indexOf("hideLayer") > -1) {
            onclick_string = onclick_string.replace("hideLayer", "showLayer");
            if (force == "off") {
               // alert (element.parentNode.parentNode.id);
                hideLayer(element.parentNode.parentNode.id);
            };
        } else if (onclick_string.indexOf("showLayer") > -1) {
            onclick_string = onclick_string.replace("showLayer", "hideLayer");
            if (force == 'on') {
              //  alert (element.parentNode.parentNode.id);
                showLayer(element.parentNode.parentNode.id);
            };
        };
        //scrape out the function parts
        onclick_split = onclick_string.split("{");
        onclick_split = onclick_split[1].split("}");
        onclick_string = onclick_split[0]; 
        //pop back together
        element.onclick = new Function(onclick_string);
        
        //now do the images (and hidden checkboxes if there are any)
        checkbox = getNextElem(element);
        filename = element.src;
        orig_filename = element.src.split('/');
        filename = orig_filename[orig_filename.length-1];
        if (filename.indexOf("show") > -1) {
            filename = filename.replace("show","hide");
        } else if (filename.indexOf("hide") > -1) {
            filename = filename.replace("hide","show");
        } else if (filename.indexOf("off") > -1) {
            if (force){
                filename = filename.replace("off",force);
                if (checkbox != null && checkbox.getAttribute("type") == 'checkbox') {
                    if (force == "on") {
                        checkbox.checked = true;
                        checkbox.name = checkbox.name.replace("off","on");
                    } else {
                        checkbox.checked = false;
                        checkbox.name = checkbox.name.replace("on","off");
                    };
                };
            } else {
                filename = filename.replace("off","on");
                if (checkbox != null && checkbox.getAttribute("type") == 'checkbox') {
                    checkbox.checked = true;
                };
            }
        } else if (filename.indexOf("on") > -1) {
            if (force){
                filename = filename.replace("on",force);
                if (checkbox != null && checkbox.getAttribute("type") == 'checkbox') {
                    if (force == "on") {
                        checkbox.checked = true;
                        checkbox.name = checkbox.name.replace("off","on");
                    } else {
                        checkbox.checked = false;
                        checkbox.name = checkbox.name.replace("on","off");
                    };
                };
            } else {
                filename = filename.replace("on","off");
                if (checkbox != null && checkbox.getAttribute("type") == 'checkbox') {
                    checkbox.checked = false;
                };
            }
        };
        var new_src = '';
        for (var i=0; i < orig_filename.length-1; i++) {
            if (orig_filename[i] != '') {
                new_src = new_src + orig_filename[i] + '//';
            };
        };
        new_src = new_src + "/" + filename;
        element.src = new_src;
        element.id = null;
    };
}

// }}}
// {{{ getNextElem()

/**
* gets the next element (the sibling) of an element
*
* code taken from stackoverflow.com
* 
* @param object element  the element
* @return void
* @access public
* @since 0.8
*/

function getNextElem(element)
{
    do  {
        element = element.nextSibling;
    } while (element && element.nodeType != 1);
    return element;
    
}

// }}}
// {{{ submitOverlayForm()

/**
* this submits a form that is being used in an overlay
*
* 
* 
* @param string form_name the name of the form being submitted
* @return void
* @access public
* @since 0.8
*/

function submitOverlayForm(url, form_name, extra_params)
{
    //first shut the lightbox elements
    parent.document.getElementById('lightbox').style.display='none';
    parent.document.getElementById('overlay').style.display='none';
    
    //map = parent.document.contentWindow.map;
    map = parent.map;
    //do some checking to make sure that we have all the right params, etc.
    url = parseUri(url);
    queryless_url = url.protocol + "://" + url.authority + '/' + url.path;
    //now grab the form elements
    elem = document.getElementById(form_name).elements;
    query = '?';
    for(var i = 0; i < elem.length; i++)
    {
        if (elem[i].type == 'checkbox') {
            if (elem[i].checked) {
                elem[i].value = 1;
            } else {
                elem[i].value = 0;
            };
        };
        if (elem[i].name && elem[i].value) {
            query = query + "&" + elem[i].name + "=" + elem[i].value;
        };
    }
    if (extra_params) {
        //check if we have a big query param (i.e. some large data) if so JSONify it
        if (extra_params.length > 100) {
            params = extra_params.split('&');
            for (var i=0; i < params.length; i++) {
                if (params[i].length > 100) {
                    //we need to split this 
                    //name_value = params[i].split('=',2);
                    name_index = params[i].indexOf("=");
                    name = params[i].substr(0, name_index);
                    //alert(name_value);
                    json_value = params[i].substr(name_index+1);
                    json_value = map.serialize();
                    //json_value = jQuery.toJSON(map.layers);
                    //json_value = parseXML(params[i].substr(name_index+1));
                    //json_value = xml2json(json_value,"");
                    query = query + "&" + name + "=" + json_value;
                    
                }else{
                    query = query + "&" + params[i];
                }
            };
        } else  {
            query = query + "&" + extra_params;
        };
    };
    url = queryless_url + query;
    submitAsyncURLDynamic(url,parent.document.getElementById('message'),'Working?',"POST"); 
}

// }}}
// {{{ changeDivSize()

/**
* changes the size of an element
*
* @param int width the new width
* @param int height the new height
* @param string element the id of the element to be changed
* @return void
* @access public
* @since 0.8
*/

function changeDivSize(width, height, element)
{
    element = document.getElementById(element);
    if (element) {
        element.style.width = width;
        element.style.height = height;
    };
}

// }}}
// {{{ parseXML()
//taken from http://goessner.net/download/prj/jsonxml/

function parseXML(xml)
{
    var dom = null;
    if (window.DOMParser) {
        try { 
            dom = (new DOMParser()).parseFromString(xml, "text/xml"); 
        } 
        catch (e) { dom = null; }
    }
    else if (window.ActiveXObject) {
        try {
            dom = new ActiveXObject('Microsoft.XMLDOM');
            dom.async = false;
            if (!dom.loadXML(xml)) // parse error ..
                window.alert(dom.parseError.reason + dom.parseError.srcText);
            } 
      catch (e) { dom = null; }
    }
    else
        alert("cannot parse xml string!");
        return dom;
}    
//}}}

// ---- FUNCTIONS FOR USE WITH OPENLAYERS ---- //

// {{{ zoomLayer()

/**
* zooms the map to the extent of the layer
*
* 
* 
* @param string layername  the layer to zoom to
* @return void
* @access public
* @since 0.8
*/

function zoomLayer(layername)
{
    layer = map.getLayersByName(layername);
console.log(layer);
    for (var i=0; i < layer.length; i++) {
        extent = layer[i].getMaxExtent();
    };
    map.zoomToExtent(extent);
}

// }}}
// {{{ showLayer()

/**
* shows a map layer
*
* @param string layername  the layer to show
* @return void
* @access public
* @since 0.8
*/

function showLayer(layername)
{
    layer = map.getLayersByName(layername);
    for (var i=0; i < layer.length; i++) {
        layer[i].setVisibility(true);
    };
}

// }}}
// {{{ hideLayer()

/**
* hides a map layer
*
* @param string layername  the layer to hide
* @return void
* @access public
* @since 0.8
*/

function hideLayer(layername)
{
    layer = map.getLayersByName(layername);
    for (var i=0; i < layer.length; i++) {
        layer[i].setVisibility(false);
    };
}

// }}}
// {{{ prepareMapForPrint()

/**
* prepares the map object for printing
*
* @param object map  the map object to be printed
* @param object element  the element in which to place the tile array (for later parsing)
* @return void
* @access public
* @since 0.8
*/

function printMap(map, element)
{  
    // go through all layers, and collect a list of objects
    // each object is a tile's URL and the tile's pixel location relative to the viewport
    var size  = map.getSize();
    var tiles = [];
    for (layername in map.layers) {
        // if the layer isn't visible at this range, or is turned off, skip it
        var layer = map.layers[layername];
        if (typeof(layer) != 'object') continue;
        if (!layer.getVisibility()) continue;
        if (!layer.calculateInRange()) continue;
        // iterate through their grid's tiles, collecting each tile's extent and pixel location at this moment
        for (tilerow in layer.grid) {
            for (tilei in layer.grid[tilerow]) {
                var tile     = layer.grid[tilerow][tilei];
                if (tile.bounds && tile.position) {
                    var url = layer.getURL(tile.bounds);
                    var position = tile.position;
                };
                var opacity  = layer.opacity ? parseInt(100*layer.opacity) : 100;
                tiles[tiles.length] = {url:url, x:position.x, y:position.y, opacity:opacity};
            }
        }
    }
    // hand off the list to our server-side script, which will do the heavy lifting
    var tiles_json = JSON.stringify(tiles);
    var printparams = 'width='+size.w + '&height='+size.h + '&tiles='+escape(tiles_json) ;
    element.value = tiles_json;
}

// }}}
// {{{ addslashes()

/**
* escapes slashes in a string
*
* @param string str  the string
* @return string str  the clean string
* @access public
* @author taken from : http://javascript.about.com/library/bladdslash.htm
* @since 0.8
*
*/

function addslashes(str)
{
    str=str.replace(/\\/g,'\\\\');
    str=str.replace(/\'/g,'\\\'');
    str=str.replace(/\"/g,'\\"');
    str=str.replace(/\0/g,'\\0');
    return str;
}

// }}}
// {{{ stripslashes(str)

/**
* strips slashes from a string
*
* @param string str  the string
* @return string str  the clean string
* @access public
* @author taken from : http://javascript.about.com/library/bladdslash.htm
* @since 0.8
*
*/

function stripslashes(str)
{
    str=str.replace(/\\'/g,'\'');
    str=str.replace(/\\"/g,'"');
    str=str.replace(/\\0/g,'\0');
    str=str.replace(/\\\\/g,'\\');
    return str;
}

// }}}
// {{{ toggleWidth()
    
/**
* toggles the width of the results panel
*
* @param object map  the map object to be printed
* @param object element  the element in which to place the tile array (for later parsing)
* @return void
* @access public
* @author Guy Hunt
* @author Stuart Eve
* @since 0.8
*
*/

function toggleWidth(toggle, wrapper, main)
{
    // declare stuff
    toggle = document.getElementById(toggle);
    wrapper = document.getElementById(wrapper);
    main = document.getElementById(main);
    // toggle logic
    if (main.style.width == '800px' || main.style.width == '') {
        main.style.width='1000px';
        wrapper.style.width='1201px';
        toggle.innerHTML='&#x21E4;';
    } else {
        main.style.width='800px';
        wrapper.style.width='1001px';
        toggle.innerHTML='&#x21E5;';
    }
}

// }}}
// {{{ setDateNow()

/**
* sets a user input date field to "now"
*
* @param string $format  a comma sep date format as per ARK
* @param string $classtype  the datetype of the input field
* @author Stuart Eve
* @since v1.1
*
* Note: This function existed as a stand alone script up to v1.1
*
* Note: This function was originally taken from:
* http://www.999tutorials.com/tutorial-fill-an-input-field-with-the-current-date-and-time-with-javascript.html
* Stuart Eve has undertaken a number of edits to it.
*
*/

function setDateNow(format, classtype)
{
    //first get the date
    var d = new Date();
    var yr = d.getFullYear();
    var mm = d.getMonth() + 1;
    var dd = d.getDate();
    var hh = d.getHours();
    var mi = d.getMinutes();
    
    //now explode the format so that we can set the inputs
    var format_split = format.split(",");
    
    //now loop and fill the inputs
    for (i=0;i<format_split.length;i++) {
        theInput = document.getElementById(classtype + "_" + format_split[i]);
        theInput.value = eval(format_split[i]);
    }
}

// }}}