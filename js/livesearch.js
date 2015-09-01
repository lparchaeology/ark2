/**
* livesearch.js
*
* javascript which is called through the liveSearch function
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with *archaeological data
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
* @author     Henriette Roued Olsen <henriette@roued.com>
* @copyright  1999-2007 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @version    CVS: :
* @link       http://ark.lparchaeology.com/svn/LINK TO FILE
* @since      File available since Release 0.6
*/

/* ----- liveSearch Function ---- */

/*
* This function will call the liveSearch.php script and get it to return a set of 
* suggestions which it will add to the span with the id = txtHint
* Variables: 
* str: The string which is added by the user - must be set to this.value when this function is called
* table: The table where the script must search for suggestions
* order: The column in the table which the returned list should be ordered by ASC
* id: The column in the table where the script will search for a pattern matching the str
* sfKey: The sf_key to make the link to the value
* goto: The link to the page the form is giving access to
* view: The view of the page the form is giving access to (OPTIONAL)
*/

function liveSearch(str, table, order, id, link) {
//    alert ('link=' + link);
    if (link==undefined) {
        link='';
    }
    // If the length of the string is 0 return nothing
    if (str.length==0) {
          document.getElementById("txtHint").innerHTML="";        
        return;
    }
    // Make object
    xmlHttp=GetXmlHttpObject();
    // If the object is not created:
    if (xmlHttp==null)
      {
      alert ("Your browser does not support AJAX!");
      return;
      } 
    // Create the url variable to send to the livesearch script
    var url="php/live_search.php";
    url=url+"?q="+str;
    url=url+"&sid="+Math.random();
    url=url+"&table="+table;
    url=url+"&order="+order;
    url=url+"&id="+id;
    url=url+"&link="+link;
    url=url+"&type=nav";
    
    // Send the url if the state of the input box is changed. 
    xmlHttp.onreadystatechange=stateChanged;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
    
    
}

function liveSearchType(str, table, order, id) {
    // If the length of the string is 0 return nothing
    if (str.length==0) {
          document.getElementById("txtHintType").innerHTML="";        
        return;
    }
    mod = id.split("_")[0];
    // Make object
    xmlHttp=GetXmlHttpObject();
    // If the object is not created:
    if (xmlHttp==null)
      {
      alert ("Your browser does not support AJAX!");
      return;
      } 
    // Create the url variable to send to the livesearch script
    var url="php/live_search.php";
    url=url+"?q="+str;
    url=url+"&sid="+Math.random();
    url=url+"&table="+table;
    url=url+"&order="+order;
    url=url+"&id="+id;
    url=url+"&type=indiv";
    
    
    // Send the url if the state of the input box is changed. 
    xmlHttp.onreadystatechange=function() 
    { 
        if (xmlHttp.readyState==4)
        { 
            document.getElementById(mod+"txtHintType").innerHTML=xmlHttp.responseText;
        }
    };
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
    
    
}

/* ----- GetXmlHttpObject Function ---- */
function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}



/* ----- stateChanged Function ---- */

function stateChanged() 
{ 
    if (xmlHttp.readyState==4)
    { 
        document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
    }
}
function stateChangedType() 
{ 
    if (xmlHttp.readyState==4)
    { 
        document.getElementById("txtHintType").innerHTML=xmlHttp.responseText;
    }
}

/* ---- linktxt Function ---- */

function linktxtnav(hint)
{    
    document.getElementById("item").value=hint;
    document.getElementById("txtHint").innerHTML='';
}

//to disable the auto-complete so that it passes validation

window.onload = function() {
    for(var i = 0, l = document.getElementsByTagName('input').length; i < l; i++) {
        if(document.getElementsByTagName('input').item(i).type == 'text') {
            document.getElementsByTagName('input').item(i).setAttribute('autocomplete', 'off');
        };
    };
};
function linktxtindiv(hint,mod)
{    
    document.getElementById(mod+"indiv").value=hint;
    document.getElementById(mod+"txtHintType").innerHTML='';
}

//to disable the auto-complete so that it passes validation

window.onload = function() {
    for(var i = 0, l = document.getElementsByTagName('input').length; i < l; i++) {
        if(document.getElementsByTagName('input').item(i).type == 'text') {
            document.getElementsByTagName('input').item(i).setAttribute('autocomplete', 'off');
        };
    };
};


