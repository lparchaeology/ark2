/*functions for making ajax message page */

var padString = function (string) {

    if(string.length = 1) {
        return '0'+string;
    } else {
        return string
    }

};

var formatDate = function(datestring) {

    if( datestring == '' ){
        return '';
    }

    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };

    return new Intl.DateTimeFormat(applocale, options).format(new Date(datestring));

};

var emptyForm = function(){
    $('.form-horizontal').each(function(i,e,a){
        console.log('clearing out');
        console.log(e);
    })
}

var getItemForm = function(id, showImmediately) {

    if( typeof id == 'undefined' ) {
        return false;
    }

    var thisRow = $(".dime-table tr[data-unique-id='" + id + "']");

    if( thisRow.data("data") ){
        return true;
    }

    $.ajax('../api/internal/users/'+id+'/actor').fail(function() {
        emptyForm();
    }).done(function(response) {
        console.log(response);
        thisRow.data("data",response);
        if(showImmediately){
            showItemForm(id);
        }
    });

};

var itemFieldToHtml = function(data){
    console.log(data);
}

var itemFormToHtml = function(data){
    $('.form-horizontal[name=actor]').find("input[type=text], textarea").each(function(i,e,a){
        $(e).val(data[$(e).attr('id')]['value']);
    });
    $('.form-horizontal[name=actor]').find("select").each(function(i,e,a){
        $(e).val(data[$(e).attr('id')]['value']);
        $(e).select2({
            minimumResultsForSearch: 11,
            width: 'resolve'
        });
    });

    initialAvatarPreview = [];
    
    if(data['actor_avatar_item']['value']){
        
        initialAvatarPreview.push('<img class="file-preview-image" src="/dime/img/'+data['actor_avatar_item']['value']+'?p=preview">');
        
    }
    
    $('div.file-input').parent().append($('<input type="file" id="actor_avatar_file" name="actor[avatar][file]">'));
    
    $('div.file-input').remove();
    
    $('#actor_avatar_file').fileinput({
        'showUpload':false,
        'previewFileType':'any',
        'initialPreview': initialAvatarPreview
    });

}

var showItemForm = function(id){

    var thisRow = $(".dime-table tr[data-unique-id='" + id + "']");

    var data = thisRow.data("data");

    if(data){
        $('#actor_id_value').html(id);
        $('#actor_id_content').remove();
        $('#actor_id_value').closest('form').append($('<input type="hidden" id="actor_id_content" name="actor[id][content]" value="'+id+'"></input>'));
        itemFormToHtml(data);
    } else {
        getItemForm(id, true);
    }
};

var userFocusClick = function(evt) {
    evt.preventDefault();

    if($(evt.target).is('tr')){
        var self = $(evt.target);
    } else {
        var self = $(evt.target).closest('tr');
    }

    console.log(self.attr('data-unique-id'));

    showItemForm(self.attr('data-unique-id'));

};
//post-submit callback 
function showResponse(responseText, statusText, xhr, $form) { 
    alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
        '\n\nThe output div should have already been updated with the responseText.'); 
} 

$('document').ready(function(){

    $('.icon-user-focus').on("click", {"target":this}, userFocusClick );

    $('tr').each( function(i, e){
        getItemForm($(e).attr('data-unique-id'), false);
    });
    
    $('#actor_save').on("click", function(e){
        var options = {
                success: showResponse
            }; 
        var valid = $(e.target).closest('form')[0].checkValidity();
        if(valid){
            e.preventDefault();
            $(e.target).closest('form').ajaxSubmit(options);
        }
    });

});
