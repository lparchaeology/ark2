// A source is a json object

//A restart function uses the unfiltered results
function getAllItems(){
    path = $.data(pathdiv,"data").path;
    describeItems(getItems($.data(jsondiv,"items"), path));
}

// get items on a specific path from a given source
function getItems(source, path){
    var result = source;
    for (var node in path){
        var pathnode = path[node];
        if (pathnode != ''&& result[pathnode]){
            result = result[pathnode];
        }
    }
    return result;
}

// creates a link to the node for drawing navigation
// TODO:separate style?
function rendernode(path, node){
    var nodeElement = document.createElement('div');
    var index = path.lastIndexOf(node);
    if (index==path.length-1){
    	index=path.indexOf(node);
    }
    nodeElement.innerHTML = '<a>'+node+'</a>';
    $.data(nodeElement,"pathindex", index);
    nodeElement.style = 'display:inline';
    nodeElement.onclick = function ( e ){
        var newpath = path.slice(0,($.data(this,"pathindex")+1));
        $.data(pathdiv,"data").path = newpath;
        drawpath(pathdiv);
        getAllItems();
    }
    return nodeElement;
}

// draws a path in the div given
// TODO: is '>' markup?
// TODO: separate style
function drawpath(div){
    div.empty();
    var divpath = jQuery.data(div,"data").path;
    if (divpath.length>1){
        for (var node in divpath){
            if (divpath[node]==''){
                var response = rendernode(divpath,'root');
                div.append(response);
            } else if(String(divpath[node]).substring(0, 9)!='function ') {
                var drawnnode = rendernode(divpath,divpath[node]);
                var divider = document.createElement('div');
                divider.innerHTML = " > ";
                divider.style = 'display:inline';
                div.append(divider);
                div.append(drawnnode);
            }
        }
    }else{
        var response = rendernode(path,'root');
        div.append(response);
    }
}

// div ids can't start with numbers, so parse them out!
function numberstotext(str){
    str = str.replace("1", "one"); 
    str = str.replace("2", "two"); 
    str = str.replace("3", "three");
    str = str.replace("4", "four");  
    str = str.replace("5", "five"); 
    str = str.replace("6", "six"); 
    str = str.replace("7", "seven"); 
    str = str.replace("8", "eight"); 
    str = str.replace("9", "nine"); 
    str = str.replace("0", "zero"); 
    return str;
}

// given a source this will return all of the distinct values for that level
function getvalues(filter, source = "default"){
    if (source = "default"){
        source = $.data(jsondiv,"items");
    }
    var rootpath = $.data(rootdiv,"data").path;
    var searchtail = filter.slice(rootpath.length+1);
    var potentials = getItems(source,rootpath);
    var response = [];
    for (var term in potentials){
        var testpath = Array.concat([term],searchtail);
        var value = getItems(potentials,testpath);
        if ((typeof value)=='string'){
            if (response.indexOf(value)==-1){
                response.push(value);
            }
        }
    }
    return response;
}

// create a DD of all the avaliable values link it with a function to keep the
// filter object up to date
// TODO:id
function createFilterDD(filter){
        var currentpath = $.data(pathdiv,"data").path;
        var values = getvalues(filter.path);
        var dd = document.createElement('select');
        dd.id ='dd';
        for (var value in values){
        	if(String(values[value]).substring(0, 9)!='function ') {
        		var option = document.createElement('option');
        		option.innerHTML = values[value];
        		option.value = values[value];
        		dd.appendChild(option);
        	}
        }
        if(filter.currentvalue){
        	dd.value = filter.currentvalue;
        }
        filter.currentvalue = dd.value;
        dd.onchange = function(){
            filter.currentvalue = dd.value;
        }
        return dd;
}

// filters are a boolean is or is not, create a radio button to do this
// TODO: labels
function createFilterBoolean(filter){
    var form = document.createElement('form');
    var endnodeindex = filter.path.length-1;
    var response = filter.path[endnodeindex];
    var form = document.createElement('form');
    form.id = response+"radio";
    var is = document.createElement('input');
    is.setAttribute("type","radio");
    is.setAttribute("value","1");
    is.setAttribute("name",response+"radio");
    var isnot = document.createElement('input');
    isnot.setAttribute("value","0");
    isnot.setAttribute("name",response+"radio");
    isnot.setAttribute("type","radio");
    var islabel=document.createElement("label");
    islabel.innerHTML = markup.jsonfilteris;
    var isnotlabel=document.createElement("label");
    isnotlabel.innerHTML = markup.jsonfilterisnot;
    form.appendChild(islabel);
    form.appendChild(is);
    form.appendChild(isnotlabel);
    form.appendChild(isnot);
    if(filter.bool){
        is.checked = true;
    } else {
        isnot.checked=true;
    }
    isnot.onchange=function (){
        var selector = "input[name='"+response+"radio']:checked";
        if ($(selector).val()==0){
            filter.bool = false;
        }else{
            filter.bool = true;
        }
        console.log(filter.bool);
        updateFilterpane();
    };
    is.onchange=function (){
        var selector = "input[name='"+response+"radio']:checked";
        if ($(selector).val()==0){
            filter.bool = false;
        }else{
            filter.bool = true;
        }
        console.log(filter.bool);
        updateFilterpane();
    };
    return form;
}

function createRemoveFilterButton(filterindex){
    var button = document.createElement('button');
    button.innerHTML=markup.jsonremove;
    button.onclick=function( e ) {
        var filters = $.data(filterdiv,"data").filters;
        filters.splice(filterindex,1);
        updateFilterpane();
    }
    return button;
}

function updateFilterpane(){
    filterdiv.empty();
    var filters = $.data(filterdiv,"data").filters;
    for (var filter in filters){
        if (filters[filter]!=''&&String(filters[filter]).substring(0, 9)!='function '){
            var returnelement = document.createElement('div');
            returnelement.innerHTML = filters[filter].end+' filter:';
            returnelement.appendChild(createFilterBoolean(filters[filter]));
            returnelement.appendChild(createFilterDD(filters[filter]));
            returnelement.appendChild(createRemoveFilterButton(filter));
            filterdiv.append(returnelement);
        }
    }
    var importdata = $.data(importdiv,"result");
	if (importdata != undefined){
		console.log(importdata.result[0].caller);
		createImport(importdata.result[0].caller);
	}
}


function createFilterButton(itemid){
    var source = $.data(jsondiv,"items");
    var button = document.createElement('button');
    button.innerHTML=markup.jsonfilter;
    button.itemid = itemid;
    button.onclick=function( e ) {
        drawpath(pathdiv);
        if ($.data(rootdiv,"data").path!=""){
        	var filter = {bool:true,path:[]};
        	var filters = $.data(filterdiv,"data").filters;
        	var fp = $.data(pathdiv,"data").path.slice();
        	fp.push(itemid);
        	filter.path = fp;
        	filter.end = itemid;
        	if (itemid.length<2){
        		filter.end += " - "+fp[fp.length-2];
        	}
        	filters.push(filter);
        	updateFilterpane();
    	}else {
    		alert(markup.nojsonrootset);
    	}
    }
    return button;
}

function createImportTable(hits, caller){
    var table = document.createElement('table');
    table.setAttribute("class","importtest");
    var headrow = document.createElement('tr');
    var head1 = document.createElement('th');
    var head2 = document.createElement('th');
    head1.innerHTML="ARK ID";
    head2.innerHTML = caller.itemid;
    headrow.appendChild(head1);
    headrow.appendChild(head2)
    table.appendChild(headrow);
    var hitcount = 0;
    for (var result in hits){
        if (result!='caller'){
            if(typeof hits[result] == 'string'){
                hitcount+=1;
                var row = document.createElement('tr');
                var cell1 = document.createElement('td');
                cell1.innerHTML = result;
                var cell2 = document.createElement('td');
                cell2.innerHTML = hits[result];
                row.appendChild(cell1);
                row.appendChild(cell2);
                table.appendChild(row);
            } else if(typeof hits[result] == 'array') {
                var row = document.createElement('tr');
                var cell1 = document.createElement('td');
                cell1.innerHTML = result;
                var cell2 = document.createElement('td');
                cell2.innerHTML = markup.jsonnothingfound;
                row.appendChild(cell1);
                row.appendChild(cell2);
                table.appendChild(row);
                delete hits[result];
            }
        }
    }
    return table;
}

function mkClassTypeDd(){
	mkFieldDd();
	var classname = $("#classDropdown option:selected").text();
	$("#typeDropdown").empty();
	$.get( "api.php?req=describeClassType&class=" + classname, function( data ) {
		var option = document.createElement("option");
		option.setAttribute("value","");
		option.text="--select--";
		$("#typeDropdown").append(option);
	    for (alias in data){
			var option = document.createElement("option");
			option.setAttribute("value",data[alias]);
			option.text=data[alias];
			$("#typeDropdown").append(option);
	    }
	});
}

function mkFieldDd(){
	var itemkey = $("#itemkeyDropdown").find('option:selected').text();
	console.log(itemkey);
	mkModTypeDD();
	var classname = $("#classDropdown").find('option:selected').text();
	$("#fieldDropdown").empty();
	$.get( "api.php?req=describeFields&item_key=" + itemkey, function( data ) {
		var option = document.createElement("option");
		option.setAttribute("value","");
		option.text="--select--";
		$("#fieldDropdown").append(option);
	    for (field in data){
	    	if (classname!='---select---'){
				if (classname==data[field].dataclass){
    	    		console.log(data[field].field_id);
    	    		var option = document.createElement("option");
    	    		option.setAttribute("value",data[field].field_id);
    	    		option.text=data[field].field_id;
    	    		option.classtype = data[field].classtype;
    	    		$("#fieldDropdown").append(option);
				}
	    	} else {
	    		console.log(data[field].field_id);
	    		var option = document.createElement("option");
	    		option.setAttribute("value",data[field].field_id);
	    		option.text=data[field].field_id;
	    		option.classtype = data[field].classtype;
	    		$("#fieldDropdown").append(option);
	    	}
	    }
	});
}

function createImport(caller){
    var rootpath = $.data(rootdiv,"data").path;
    var arkid = $.data(rootdiv,"data").arkid;
    if (!rootpath){
    	alert(markup.nojsonrootset);
    }else if (!arkid && !document.getElementById("abitraryarkcodes").checked){
    	alert(markup.nojsonarkid);
    }else if (rootpath==""){
    	alert(markup.jsonrootcannotberoot)
    }else{
    	var valuetail = caller.path.slice(rootpath.length+1);
    	var arkidtail = arkid.slice(rootpath.length+1);
    	var potentials = getItems($.data(jsondiv,"items"),rootpath);
    	var filters = $.data(filterdiv,"data").filters;
    	var param1 = "";
    	testarray = {};
		$.extend(testarray,potentials);
		var result = {};
		result['caller'] = caller;
		var nofilters = true;
    	for (var filter in filters){
    		if (filters[filter]!=''&&String(filters[filter]).substring(0, 9)!='function '){
    			var nofilters = false;
    			var newtestarray = {};
    			var test = filters[filter];
    			var searchtail = test.path.slice(rootpath.length+1);
    			for (var term in testarray){
    				var resultpath = Array.concat([term],valuetail);
    				var arkidpath = Array.concat([term],arkidtail);
    				var arkid = getItems(testarray,arkidpath);
    				var testpath = Array.concat([term],searchtail);
    				var testvalue = getItems(testarray,testpath);
    				if (test.bool){
    					if (testvalue == test.currentvalue){
    						var value = getItems(potentials,resultpath);
    						console.log(value);
    						newtestarray[term] = testarray[term];
    					}
    				} else {
    					if (testvalue != test.currentvalue){
    						var value = getItems(potentials,resultpath);
    						console.log(value);
    						newtestarray[term] = testarray[term];
    					}
    				}
    			}
    			testarray = {};
    			$.extend(testarray,newtestarray);
    		}
    	}
    	var count = 0;
    	if (nofilters){
			for(term in potentials){
				count+=1;
				var resultpath = Array.concat([term],valuetail);
				var value = getItems(potentials,resultpath);
				var arkid = getItems(testarray,Array.concat([term],arkidtail));
				var uniqueid = getArkId(potentials[term],arkid,count);
				result[uniqueid] = value;
			}
    	} else {
    		for (term in testarray){
    			count+=1;
    			var resultpath = Array.concat([term],valuetail);
    			var value = getItems(testarray,resultpath);
    			var arkid = getItems(testarray,Array.concat([term],arkidtail));
    			var uniqueid = getArkId(testarray[term],arkid,count);
    			result[uniqueid] = value;
        	}
    	}
    	importdiv.empty();
    	console.log(result);
    	importdiv.append(createImportTable(result, caller));
    	$.data(importdiv,"result",{"result":[result]});
    }
}

function getArkId(jsonnode, arkid, currentnumber){
	var ste_cds = document.getElementById("dd_ste_cd");
	var ste_cd = ste_cds.value+"_";
	var splitid = String(arkid).split("_");
	if(splitid.length==2 && $("#dd_ste_cd option[value="+splitid[0]+"]").length){
		return arkid;
	}
	if (document.getElementById("no_ste_cd").checked){
		ste_cd='';
	}
	if (document.getElementById("abitraryarkcodes").checked){
		var start = document.getElementById("abitraryarkcodesstart").value;
		var abitrarynumber = parseInt(start)+parseInt(currentnumber);
		var fmtarkid = ste_cd+abitrarynumber;
	} else {
		var regex = document.getElementById("arkidregex").value;
		var fmtarkid = ste_cd+String(arkid).match(regex);
	}
	console.log(fmtarkid);
	return fmtarkid;
}


function createImportButton(itemid){
    var button = document.createElement('button');
    button.innerHTML=markup.genjsonimport;
    button.itemid = itemid;
    var buttonpath = $.data(pathdiv,"data").path.slice(0);
    buttonpath.push(itemid);
    button.path = buttonpath;
    button.onclick=function( e ) {
                createImport(this);
            }
    return button;
}

function createThisIsRootButton(){
    var button = document.createElement('button');
    button.innerHTML = markup.jsonthisisroot;
    button.onclick = function ( e ){
        var clone = path.slice(0);
        $.data(rootdiv,"data",{path:clone});
        drawpath(rootdiv);
        var undobutton = document.createElement('button');
        undobutton.innerHTML = markup.jsonremove;
        undobutton.onclick = function(e){
        	$.data(rootdiv,"data").path="";
        	drawpath(rootdiv);
            rootdiv.append(createThisIsRootButton());
        }
        rootdiv.append(undobutton);
    }
    return button;
}

function createARKIDButton(caller){
    var source = $.data(jsondiv,"items");
    var button = document.createElement('button');
    button.innerHTML=markup.jsonthisisarkid;
    button.itemid = caller;
    button.onclick=function( e ) {
                var idpath = $.data(pathdiv,"data").path.slice();
                idpath.push(this.itemid);
                $.data(rootdiv,"data").arkid = idpath;
                var arkiddiv = $("#jsonarkid");
                if(!$.data(arkiddiv,"data")){
                    $.data(arkiddiv,"data",{path:idpath})
                }else {
                	$.data(arkiddiv,"data").path = idpath;
                }
                drawpath(arkiddiv);
                
            }
    return button;
}

function drilldownfunction(caller){
    path = $.data(pathdiv,"data").path;
    path.push(caller.itemid);
    var result = getItems($.data(jsondiv,"items"), path);
    drawpath(pathdiv);
    describeItems(result);
}

function describeItems(array){
    var div = document.getElementById('currentpath');
    var oldlist = document.getElementById('list');
    var listholder = document.getElementById('listholder');    
    listholder.removeChild(oldlist);
    count = 0;
    var list = document.createElement('ul');
    list.id='list';
    if (typeof array != 'string'){
        for( var item in array){
            count = count+1;
            if (count<21){
                var itemdivname= item +'_'+ 'div';
                itemdivname = numberstotext(itemdivname);
                var object = document.createElement('li');
                object.id = itemdivname
                var drilldown = document.createElement('div');
                drilldown.itemid = item;
                drilldown.onclick = function( e ) {
                    drilldownfunction(this);
                }
                drilldown.innerHTML = '<a>'+ item+'</a>';
                //object.setAttribute('class','data');
                object.appendChild(drilldown);
                object.appendChild(createFilterButton(item));
                object.appendChild(createImportButton(item));
                object.appendChild(createARKIDButton(item));
                list.appendChild(object);
                object = false;
            }
        }
    }else{
    	count = markup.thisisleaf; 
        var object = document.createElement('div');
        object.innerHTML = array;
        list.appendChild(object);
    }
    document.getElementById('count').innerHTML = count;
    if (count>20){
        document.getElementById('output').innerHTML  += markup.first20;
    } else {
        document.getElementById('output').innerHTML ='<div id= "count"></div>'+markup.itemsfound;
    }
    listholder.appendChild(list);
}

function toParent(){
    path = $.data(pathdiv,"data").path;
    path.pop();
    drawpath(pathdiv);
    getAllItems();
}

function mkModTypeDD(){
	var modcodes = document.getElementById('itemkeyDropdown').options;
	var selectedmodcode = document.getElementById('itemkeyDropdown').value;
	for (var option in modcodes){
		var modcode = modcodes[option].text;
		if(modcode&&modcode!='---select---'){
			var modshort = modcode.split("_")[0];
			var idname = modshort+"type";
			var typerow = document.getElementById(idname);
			if(typerow){
				typerow.setAttribute("class","");
				typerow.setAttribute("style","display:none");
			}
			console.log(idname);
		}
	}
	if (selectedmodcode){
		var modshort = selectedmodcode.split("_")[0];
		var idname = modshort+"type";
		var typerow = document.getElementById(idname);
		if(typerow){
			typerow.setAttribute("class","row");
			typerow.setAttribute("style","");
		}
		console.log(idname);
	}
}

function getJsonModType(){
	var modcodes = document.getElementById('itemkeyDropdown').options;
	var selectedmodcode = document.getElementById('itemkeyDropdown').value;
	var modshort = selectedmodcode.split("_")[0];
	var idname = "dd_"+modshort+"type";
	console.log(idname);
	var typerow = document.getElementsByName(idname)[0];
	if (typerow){
		return typerow.value;
	} else {
		return 'notset';
	}
}

function importJson(){
	var itemkey = $("#itemkeyDropdown option:selected").text();
	var modtype = getJsonModType();
	var arkfield = $("#fieldDropdown option:selected").text();
	var arkclass = $("#classDropdown option:selected").text();
	var arktype = $("#fieldDropdown option:selected")[0].classtype;
	if (arkclass == "---select---" || arktype=="---select---" || !modtype){
		alert("you must select a class and field for this import"); 
	}else{
		var importdata = $.data(importdiv,"result");
		console.log($.data(importdiv,"result"));
		if (importdata == undefined){
			alert("no data selected");
		} else {
			if ($.inArray(arkclass, ['txt','attribute','xmi','number','action','date']) > -1){
				var submitform = document.getElementById("json_process");
				submitform.action = "import.php?view=json_process";
				submitform.method = "post";
				if(modtype!='notset'){
					var hiddenField = document.createElement("input");
					hiddenField.setAttribute("type", "hidden");
					hiddenField.setAttribute("name", "modtype");
					hiddenField.setAttribute("value", modtype);
					submitform.appendChild(hiddenField); 
				}
				var hiddenField1 = document.createElement("input");
	            hiddenField1.setAttribute("type", "hidden");
	            hiddenField1.setAttribute("name", "data");
	            hiddenField1.setAttribute("value", JSON.stringify(importdata.result[0]));
	            submitform.appendChild(hiddenField1);
	            submitform.submit();
			} else {
				alert("can't handle this dataclass yet"); 
			}
		}
	}
}

function getIndicesOf(searchStr, str, caseSensitive) {
    var startIndex = 0, searchStrLen = searchStr.length;
    var index, indices = [];
    if (!caseSensitive) {
        str = str.toLowerCase();
        searchStr = searchStr.toLowerCase();
    }
    while ((index = str.indexOf(searchStr, startIndex)) > -1) {
        indices.push(index);
        startIndex = index + searchStrLen;
    }
    return indices;
}

function cleanDoubleQuotes(str){
	str = str.trim();
	if(str[0]=='"'){
		str = str.substring(1);
	}
	if (str[str.length-1]=='"'){
		str = str.substring(0,str.length-1);
	}
	str = str.replace(/""/g,'"');
	return str;
}

function getNextCell(remaining){
	var term = remaining.indexOf(',');
	if (term>0){
		var cell = remaining.substring(0,term);
		var rest = remaining.substring(term+1);
		// test for quoted string
		var doublequotes = getIndicesOf('"',cell);
		// we have some quotes
		if (doublequotes.length>0){
			// if we have an odd number of quotes we are in the middle of a string
			// we _could_ check that it is escaped in a valid manner
			while (doublequotes.length%2 != 0){
				var term = rest.indexOf(',');
				if (term != -1){
					var more = rest.substring(0,term);
					var rest = rest.substring(term+1);
					cell += "," + more;
				} else {
					cell += "," + rest;
					rest = "";
				}
				doublequotes = getIndicesOf('"',cell);
			}
		}
		cell = cleanDoubleQuotes(cell);
		return {"cell":cell,"rest":rest};
	} else {
		if (term==0){
			return {"cell":"","rest":remaining.substring(1)};
		}
		return {"cell":cleanDoubleQuotes(remaining),"rest":false};
	}
}

function getRow(row,header=false){
	var retobj = {};
	var next = getNextCell(row);
	i=0;
	while (next){
		if (header){
			retobj[header[i]]=next.cell;
		} else {
			retobj[i]=next.cell;
		}
		i+=1;
		if (next.rest){
			next=getNextCell(next.rest);
		} else {
			next=false;
		}
	}
	return retobj;
}

var $=jQuery;
if (!filename[0]){
	window.location="import.php?view=json_picker";
}
$.get( filename[0], function( data ) {
	console.log(filename);
	console.log(data);
	if(filename[0].split('.')[1]=='csv'){
		var rows = data.split(/\r\n|\r|\n/g);
		var headers = getRow(rows[0]);
		console.log(headers);
		var items = {};
		var data = {items};
		for (row in rows){
			if (row!=0 && typeof rows[row] != 'function'){
				cells = getRow(rows[row],headers);
				items[cells[headers[0]]] = cells;
			}
		}
		console.log(items);
	    $.data(jsondiv,"items", data);
	} else {
	    $.data(jsondiv,"items", $.parseJSON(data));
	}
    document.getElementById('output').innerHTML ='<div id= "count"></div>'+markup.itemsfound;
    document.getElementById('parent').innerHTML =markup.jsontoparent;
    getAllItems();
});

var parent = document.getElementById('parent');
parent.onclick = function( e ) {
                toParent();
            }

var jsondiv = $("#jsondiv");
var pathdiv = $("#currentpath");
var rootdiv = $("#rootpath");
var importdiv = $('#import');
var filterdiv = $("#filters");
var rootdata = $.data(rootdiv,"data");
var filterdata = $.data(filterdiv,"data");
$.data(rootdiv,"data",{path:[""]});
$.data(pathdiv,"data",{path:[""]});
$.data(filterdiv,"data",{filters:[""]});
var path = $.data(pathdiv,"data").path;
drawpath(pathdiv);
rootdiv.append(createThisIsRootButton());