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
    } else {
        thisRow.data("working", true);
    }


    $.ajax(window.userApiUrl+id+'/actor').fail(function() {
        emptyForm();
    }).done(function(response) {
        console.log(response);
        thisRow.data("data",response);
        thisRow.data("working", false);
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
    $('.form-horizontal[name=actor]').find("input[type=hidden]").each(function(i,e,a){
        console.log(data[$(e).attr('id')]);
        $(e).val(data[$(e).attr('id')]['value']);
    });
    $('.form-horizontal[name=actor]').find("select").each(function(i,e,a){
        var keyword = data[$(e).attr('id')]['value'].split('.');
        console.log(keyword[keyword.length-1]);
        $(e).val(keyword[keyword.length-1])
        $(e).select2({
            minimumResultsForSearch: 11,
            width: 'resolve'
        });
    });

    initialAvatarPreview = [];

    defaultImage = 1;

    if(data['actor_avatar_item']['value']){
        initialAvatarPreview.push('<img class="file-preview-image" src="/dime/img/'+data['actor_avatar_item']['value']+'?p=preview">');
    } else {
        initialAvatarPreview.push('<img class="file-preview-image" src="/dime/img/'+defaultImage+'?p=preview">');
    }

    $('div.file-input').parent().append($('<input type="file" id="actor_avatar_file" name="actor[avatar][file]">'));

    $('div.file-input').remove();

    $('#actor_avatar_file').fileinput({
        'showUpload':false,
        'allowedFileTypes': ['image'],
        'previewFileType':'image',
        'initialPreview': initialAvatarPreview,
        'minFileCount': 0,
        'maxFileCount': 1
    });

}

var showItemForm = function(id){

    var thisRow = $(".dime-table tr[data-unique-id='" + id + "']");

    var data = thisRow.data("data");

    var working = thisRow.data("working");

    if(data){
        $('#actor_id_value').html(id);
        var working = thisRow.data("working", true);
        var thisForm = $('#actor_id_value').closest('form');
        thisForm.attr('action', window.userApiUrl+id+"/actor");
        itemFormToHtml(data);
    } else if( working == true ) {
        showItemForm(id);
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
    if(responseText.status == 'success'){
        $('#actor_id_value').closest('form').prepend($('<div class="alert alert-success" role="alert">'+window.translations[responseText.message]+'</div>'));
    } else {
        $('#actor_id_value').closest('form').prepend($('<div class="alert alert-error" role="alert">'+window.translations['dime.user.update.failure']+'</div>'));
    }
}

$('document').ready(function(){

    console.log(window.itemkey);

    if(window.itemkey == 'actor'){

        $('.icon-user-focus').on("click", {"target":this}, userFocusClick );

        $('tr').each( function(i, e){
            getItemForm($(e).attr('data-unique-id'), false);
        });
        console.log($('#dime_profile_list').length);
        if($('#dime_profile_list').length){
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
        }
    }

});
