function toArk(info){
	// unpack the data passed in the info JSON
	var field=info.field;
	var classtype=info.classtype;
	var itemkey=info.itemkey;
	var itemval=info.itemval;
    var attrid=info.attrid;
	var id=info.id;
	var ark=info.ark;
	var irods=info.irods;
	
	// set up our http request for later
	var http=new XMLHttpRequest();
	var url = "api.php";
	
	if (irods==ark){
		// if the two data values are the same, do nothing
		alert("Already the same, nothing to do.");
	}else if(irods==''){
		// if there is no value to pull to ARK, do nothing
		alert("No value sent");
	}else if (field=='no_field'){
		// if this is not a 'live' value do nothing
		// live values are things like site code or module, 
		// which exist in the ARK but not in database, so cannot
		// easily be modified
		alert("This ARK value is not live");
	}else{
		// if it isn't any of those other things, pull on!
		if (ark==''){
			// if the ark value is blank, it will be an 'add' routine
			var qtype="add";
			var message = "Do you really want to add "+classtype+"="+irods+" to item "+itemval+"?"
			// attributes use ark codes, stored as attrid in the info, rather than raw strings
			if (attrid){
				irods=attrid;
			}
			// set up the params for most cases
			var params = "req=putField&itemkey="+itemkey+"&itemval="+itemval+"&field="+field+"&"+classtype+"="+irods+"&"+classtype+"_bv=1&"+classtype+"_qtype=add";
			if (classtype=='xmi_list'){
				// xmi list are a special case, we will need different params
				var modcode = field.split("_")[2].substring(0,3);
				var xmicode = field.split("_")[2].substring(6,9);
				var params = "req=putField&item_key="+itemkey+"&itemval="+itemval+"&"+modcode+"="+itemval+"&xmi_list_"+xmicode+"="+irods+"&xmi_list_"+xmicode+"_qtype=add";
			}
		}else{
			// otherwise this is an edit
			var qtype="edt";
			var message = "Do you really want to change "+classtype+" from "+ark+" to "+irods+" for item "+itemval+"?";
			if (attrid){
				irods=attrid;
			}
			// edit params slightly different
			var params = "req=putField&itemkey="+itemkey+"&itemval="+itemval+"&field="+field+"&"+classtype+"="+irods+"&"+classtype+"_bv=1&"+classtype+"_qtype=edt&"+classtype+"_id="+id;
			// xmi handled differently as well
			if (classtype=='xmi_list'){
				var xmicode = field.split("_")[2].substring(0,3);
				var params = "req=putField&item_key="+itemkey+"&itemval="+itemval+"&"+itemkey+"="+itemval+"&xmi_list_"+xmicode+"="+irods+"&xmi_list_"+xmicode+"_qtype=edt";
			}
		}
		// get confirmation from the user
		var confirm = window.confirm(message);
		if(confirm){
			// get our http object from earlier, use post as some strings may be very long
			http.open("POST", url, true);			
			//Set the proper header information along with the request
			http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			http.setRequestHeader("Content-length", params.length);
			http.setRequestHeader("Connection", "close");

			//Create s function for when the state changes.
			http.onreadystatechange = function() {
				// if we get an OK from the ARK API
				if(http.readyState == 4 && http.status == 200) {
					// API should return JSON, but we wrote it, so parse it carefully just in case
					try{
						var response = JSON.parse(http.responseText);
					}
					catch (e){
						// no way to recover gracefully from here so e discarded
						response=false;
					}
					if(response){
						// if we did get something intelligle back it still might not have worked!
						if (response.qry_results[0].success||response.qry_results[0][0].success){ 
							// if it did, tell the user
							document.getElementById("metadatamessage").innerHTML="<span class=\"message\">"+response.messages[0]+"</span>";
							// reload the page, so they can see the result. This is a familiar response for ARK users 
							location.reload();
						}else{
							// something went wrong! Print out the error from the API
							document.getElementById("metadatamessage").innerHTML="<span class=\"message\">"+response.errors[0]+"</span>";
						}
					}else{
						// Something went terribly wrong! there are probably some PHP warnings or notices in the response
						document.getElementById("metadatamessage").innerHTML="<span class=\"message\">ERROR: API Response not recognised</span>";
					}
				}
			}
			// send our params to our http
			http.send(params);
		}	
	}
	// no return
	return false;
};

function toIrods(info){
	// unpack the data passed in the info JSON
	var term=info.term;
	var filename=info.filename;
	var ark=info.ark;
	var irods=info.irods;
	
	
	if (irods==ark){
		// if the two data values are the same, do nothing
		alert("Already the same, nothing to do.");
	}else if(ark==''){
		// if there is no value to push to iRods, do nothing
		alert("No value sent");
	}else{
		// confirm message different for add and edit
		if (irods==''){
			var message = " Do you really want to add "+term+":"+ark+" to file "+filename+"?"; 
		} else {
			var message = " Do you really want to update "+term+" from "+irods+" to "+ark+" for file "+filename+"?";
		}
		// get user feedback
		var confirm = window.confirm(message);
		if(confirm){
			// create objects for use later
			var http=new XMLHttpRequest();
			var term=encodeURIComponent(term);
			var filename=encodeURIComponent(filename);
			var ark=encodeURIComponent(ark);
			var irods=encodeURIComponent(irods);
			
			// set up http
			var url = "mod_code/irodmetasync.php";
			var params = "filename="+filename+"&value="+ark+"&term="+term+"&existingvalue="+irods;
			http.open("POST", url, true);
			
			// set the proper header information along with the request
			http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			http.setRequestHeader("Content-length", params.length);
			http.setRequestHeader("Connection", "close");
			
			// create function for handling response
			http.onreadystatechange = function() {
				if(http.readyState == 4 && http.status == 200) {
					// irodsmetasync has a code for determining what to do with responses
					var code = http.responseXML.getElementsByTagName("code")[0].childNodes[0].nodeValue;
					// and a message for informing the user
					var message = http.responseXML.getElementsByTagName("message")[0].childNodes[0].nodeValue;
					alert(message);
					// Code 1 means success! 
					if (code==1){ 
						// update the page
						document.getElementById("metadatamessage").innerHTML="<span class=\"message\">Update Successful!</span>";
						// and then reloas so that the user can see what they have done, familiar behaviour in ARK
						location.reload();
					}
				}
			}
			// send the request
			http.send(params);
		}
	}
	return false;
};

// props to http://codeimpossible.com/2010/01/13/solving-document-ready-is-not-a-function-and-other-problems/ for this handy little 'bodyguard'
(function($) {
    
	
    function swapvalues(obj1,obj2,term){
    	var temp = obj1[term];
    	obj1[term]=obj2[term];
    	obj2[term]=temp;
    }
    
    function resolvednd(event,ui, button){
        var draggedid = $(ui.draggable).attr("id");
        var draggedrownum = draggedid.split(":")[1];
        
        var draggedarkname = "arkbutton"+draggedrownum;
        var draggedark = window[draggedarkname];
        var draggedirodsname = "irodsbutton"+draggedrownum;
        var draggedirods = window[draggedirodsname];

        var droppedid = $(event.target).attr("id");
        var droppedrownum = droppedid.split(":")[1];
        
        var droppedarkname = "arkbutton"+droppedrownum;
        var droppedark = window[droppedarkname];
        var droppedirodsname = "irodsbutton"+droppedrownum;
        var droppedirods = window[droppedirodsname];

        if (droppedirods.term==draggedirods.term){            
            swapvalues(document.getElementById(draggedid),document.getElementById(droppedid), "innerHTML");

            if (button==2){
                    // ark meta has been moved
                    var changevalues= new Array("field","classtype","itemkey","itemval","id","ark");
                    for (var i=0;i<changevalues.length;i++)
                    {
                    	swapvalues(draggedark,droppedark,changevalues[i]);
                    }
                    swapvalues(draggedirods,droppedirods,"ark");
            } else if (button==3){
                    // irod meta has been moved
                var changevalues= new Array("irods","attrid");
                for (var i=0;i<changevalues.length;i++)
                {
                	swapvalues(draggedark,droppedark,changevalues[i]);
                }
                swapvalues(draggedirods,droppedirods,"irods");
            }
        }
    }
    
    $(document).ready( function() {
        $(function() {
            $( ".arkdnd" ).draggable({ revert: "invalid", helper: "clone", appendTo: "body"});
            $( ".arkdnd" ).droppable({
                accept: ".arkdnd",
                drop: function( event, ui ) {
                    resolvednd(event,ui, 2)
                }
            });
            $( ".iroddnd" ).draggable({ revert: "invalid", helper: "clone", appendto: ".iroddnd"});
            $( ".iroddnd" ).droppable({
                accept: ".iroddnd",
                drop: function( event, ui ) {
                    resolvednd(event,ui, 3)
                }
            });
    
        });
    });
} ) ( jQuery );