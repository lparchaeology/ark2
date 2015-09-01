$(document).ready(function(){
    
    function toggleSelection(element) {
        if(element.hasClass("selected")){
            element.removeClass("selected");
        } else {
            element.addClass("selected");
        }
    }
    
    $('.search_item').click(function(e) {
        search_item = $(this);
        self = search_item.attr('id');
        var selectedElements = [];
        var elements = document.getElementsByClassName("search_item");
        if (e.metaKey || e.ctrlKey) {
                    window.getSelection().removeAllRanges();
                    toggleSelection(search_item);
            } else if (e.shiftKey) {
            for (var i = 0; i < elements.length; i++) {
                element = $(elements[i]);
                if (element.attr('id')==self){
                    thisIndex = i;
                }
                if (element.hasClass("selected")){
                    selectedElements.push(i);
                }
            }
            window.getSelection().removeAllRanges();
            selectedElements.sort(function(a, b){return a-b});
            lowestSelected = selectedElements[0];
            highestSelected = selectedElements[selectedElements.length - 1];
            console.log(lowestSelected);
            console.log(highestSelected);
            console.log(thisIndex);
            if (thisIndex < lowestSelected){
                for (var i = thisIndex; i < lowestSelected; i++) {
                    console.log(i);
                    $(elements[i]).addClass("selected");
                }
            } else if (thisIndex > highestSelected){
                for (var i = highestSelected; i < thisIndex+1; i++) {
                    console.log(i);
                    $(elements[i]).addClass("selected");
                }
            } 
        } else {
            for (var i = 0; i < elements.length; i++) {
                console.log(elements[i].className);
                elements[i].className = "search_item";
            }
            search_item.addClass("selected");
        }
    });
    
    function processItemkey(itemkey){
        var split_ids = itemkey.split('_');
        var returnString = split_ids[2]+"_"+split_ids[3];
        return returnString;
    }
    
    $("ul#result_select").click(function(e){
    	e.preventDefault();
    	$(".search_item").each(function( index, search_item ){
    		$(search_item).addClass("selected");
    	});
    	map1.getLayers().forEach(function(i,e,a){
            if (i.get('selectable')){
                i.getSource().getFeatures().forEach(function(i,e,a){
                    collection.push(i);
                });
            }
        });
    });
    

    $("ul#result_edit").click(function(e){
    	e.preventDefault();
    });
    
    $("ul#result_edit").mouseenter(function(e){
        var edit_button = $(this);
        var fieldlist = document.createElement('ul');
        $(fieldlist).addClass('result_edit_fields');
        for (var i = 0; i < fields.length; i++) {
            var listitem = document.createElement('li');
            var field = document.createElement('a');
            field.href = "#edit_field_"+fields[i];
            $(field).colorbox({
                onOpen:function(e){
                    $(".edit_field_itemkeys").empty();
                    var selected_elements = document.getElementsByClassName("search_item selected");
                    selected_ids = [];
                    selected_pairs = [];
                    var current_value = false;
                    $.each(selected_elements,
                        function( index, selected_element ) {
                            id = $(selected_element).attr('id');
                            selected_ids.push(processItemkey(id));
                            selected_pairs.push(id);
                            child = $(selected_element).children()[i];
                            if (current_value == false){
                        		current_value = $(child).children().contents().text();
                    		} else {
                    			if ($(child).children().contents().text() != current_value){
                            		current_value = 'Varying values detected';
                            	}
                    		}
                        });
                    	console.log(e);
                        field_edit_dom_id = field.href.split("#")[1];
                        console.log(field_edit_dom_id);
                        $("#"+field_edit_dom_id).find('textarea').val(current_value);
                        console.log($(".multi_edit_itemkeys"));
                        $(".multi_edit_itemkeys").val(JSON.stringify(selected_pairs));
                        $.each(selected_ids,
                            function( index, selected_id ) {
                                $.each($(".edit_field_itemkeys"),
                                    function( index, value ) {
                                        $(value).append(selected_id);
                                        $(value).append(" ");
                                    }
                                );
                            }
                        );
                     },
                inline:true,
                width:"50%"
            });
            field.appendChild(field.appendChild(document.createTextNode(fieldAlias[i])));
            listitem.appendChild(field);
            fieldlist.appendChild(listitem);
        }
        edit_button.append(fieldlist);
    });
    
    $("ul#result_edit").mouseleave(function(e){
        $(this).children("ul").remove();
    });
});