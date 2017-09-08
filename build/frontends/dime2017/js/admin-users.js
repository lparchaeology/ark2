/*functions for making ajax user admin page */

var emptyForm = function () {
    $('.form-horizontal').each(function (i, e, a) {
        console.log('clearing out');
        console.log(e);
    });
};

var itemFormToHtml = function (data) {
    $('.form-horizontal[name=actor]').find("input[type=text], textarea").each(function (i, e, a) {
        $(e).val(data[$(e).attr('id')]['value']);
    });
    $('.form-horizontal[name=actor]').find("input[type=hidden]").each(function (i, e, a) {
        console.log(data[$(e).attr('id')]);
        $(e).val(data[$(e).attr('id')]['value']);
    });
    $('.form-horizontal[name=actor]').find("select").each(function (i, e, a) {
        var keyword = data[$(e).attr('id')]['value'].split('.');
        console.log(keyword[keyword.length - 1]);
        $(e).val(keyword[keyword.length - 1]);
        $(e).select2({
            minimumResultsForSearch: 11,
            width: 'resolve',
        });
    });

    var initialAvatarPreview = [];

    var defaultImage = 1;

    if (data['actor_avatar_item']['value']) {
        initialAvatarPreview.push('<img class="file-preview-image" src="/img/' + data['actor_avatar_item']['value'] + '?p=preview">');
    } else {
        initialAvatarPreview.push('<img class="file-preview-image" src="/img/' + defaultImage + '?p=preview">');
    }

    $('div.file-input').parent().append($('<input type="file" id="actor_avatar_file" name="actor[avatar][file]">'));

    $('div.file-input').remove();

    $('#actor_avatar_file').fileinput({
        'showUpload': false,
        'allowedFileTypes': ['image'],
        'previewFileType': 'image',
        'initialPreview': initialAvatarPreview,
        'minFileCount': 0,
        'maxFileCount': 1,
    });

};

var showItemForm = function (id) {

    var thisRow = $(".dime-table tr[data-unique-id='" + id + "']");

    var data = thisRow.data("data");

    var working = thisRow.data("working");

    if (data) {
        $('#actor_id_value').html(id);
        working = thisRow.data("working", true);
        var thisForm = $('#actor_id_value').closest('form');
        thisForm.attr('action', window.userApiUrl + id + "/actor");
        itemFormToHtml(data);
    } else if (working === true) {
        showItemForm(id);
    } else {
        getItemForm(id, true);
    }
};

var getItemForm = function (id, showImmediately) {

    if (typeof id === 'undefined') {
        return false;
    }

    var thisRow = $(".dime-table tr[data-unique-id='" + id + "']");

    if (thisRow.data("data")) {
        return true;
    } else {
        thisRow.data("working", true);
    }


    $.ajax(window.userApiUrl + id + '/actor').fail(function () {
        emptyForm();
    }).done(function (response) {
        console.log(response);
        thisRow.data("data", response);
        thisRow.data("working", false);
        if (showImmediately) {
            showItemForm(id);
        }
    });

};

var userFocusClick = function (evt) {
    evt.preventDefault();
    var self = $(evt.target).is('tr') ? $(evt.target) : $(evt.target).closest('tr');
    console.log(self.attr('data-unique-id'));
    showItemForm(self.attr('data-unique-id'));
};

// Find selected Actor
function selectedActor() {
    return $('#actor_id_value').val();
}

// Generate URL for selected actor/user
function ajaxFormUrl() {
    return window.userApiUrl + selectedActor + '/actor';
}

// AJAX Form Submission
function ajaxFormSubmit(data, $form, options) {
    return selectedActor();
}

//post-submit callback
function ajaxFormSuccess(response) {
    var msg = window.translations[response.message]
        ? window.translations[response.message]
        : response.message;
    $('#actor_id_value').closest('form').prepend(
        $('<div class="alert alert-' + response.status + '" role="alert">' + msg + '</div>')
    );
}

$('document').ready(function () {

    $('.icon-user-focus').on("click", { "target": this }, userFocusClick);

    var ajaxFormOptions = {
        beforeSubmit: ajaxFormSubmit,
        success: ajaxFormSuccess,
        url: ajaxFormUrl,
        type: 'post',
        clearForm: false,
        dataType: 'json',
    };

    $('#actor').ajaxForm(ajaxFormOptions);
    ajaxFormOptions.clearForm = true;
    $('#password_set').attr('action', 'form.php');
    $('#password_set').ajaxForm(ajaxFormOptions);
    $('#actor').ajaxForm(ajaxFormOptions);
    /*
    $('#actor').submit(function () {
        $(this).ajaxSubmit(ajaxFormOptions);
        return false;
    });
    $('#role_add').submit(function () {
        $(this).ajaxSubmit(ajaxFormOptions);
        return false;
    });
    $('#role_add').submit(function () {
        $(this).ajaxSubmit(ajaxFormOptions);
        return false;
    });
    */

    $('tr').each(function (i, e) {
        getItemForm($(e).attr('data-unique-id'), false);
    });

});
