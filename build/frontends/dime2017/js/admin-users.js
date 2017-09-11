/*functions for making ajax user admin page */

// Set the page level flash
function setPageAlert(status, message, timeout) {
    var msg = window.translations[message] ? window.translations[message] : message;
    status = status === 'error' ? 'danger' : status;
    $('#alerts').html(
        $('<div class="alert alert-dismissable alert-fadeout fade in alert-' + status + '" role="alert">'
            + '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + msg + '</div>')
    );
    if (timeout !== undefined) {
        window.setTimeout(function () {
            $(".alert-fadeout").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, timeout);
    }
}

// Return current user ID
function adminUserId() {
    return $('#actor_id_value').val();
}

// Return current user admin url
function makeAdminUserUrl(id) {
    return window.userApiUrl + id;
}

// Return current user admin url
var adminUserFormUrl = function adminUserFormUrl() {
    return makeAdminUserUrl(adminUserId());
};

// Set the current user ID
var setAdminUserId = function setAdminUserId(id) {
    var url = makeAdminUserUrl(id);
    $('#actor').attr('action', url);
    $('#password_set').attr('action', url);
    $('#role_add').attr('action', url);
};

// Call API to fetch user details
var fetchAdminUserActor = function (id) {
    $.ajax(makeAdminUserUrl(id)).fail(function (response) {
        console.log(response);
        $('#actor').clearForm();
        setPageAlert(response.status, response.message);
    }).done(function (response) {
        console.log(response);
        FormMapper.mapDataToForm(response, $('#actor')[0]);
        setAdminUserId(id);
    });
};

// AJAX Form Submission
function adminUserFormSubmit(data, $form, options) {
    return adminUserId() ? true : false;
}

// AJAX Form post-submit callback
function adminUserFormSuccess(response) {
    setPageAlert(response.status, response.message);
}

var itemFormToHtml = function (data) {
    $('.form-horizontal[name=actor]').find("input[type=text], textarea").each(function (i, e, a) {
        $(e).val(data[$(e).attr('id')]['value']);
    });
    $('.form-horizontal[name=actor]').find("input[type=hidden]").each(function (i, e, a) {
        $(e).val(data[$(e).attr('id')]['value']);
    });
    $('.form-horizontal[name=actor]').find("select").each(function (i, e, a) {
        var keyword = data[$(e).attr('id')]['value'].split('.');
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

var adminUserSelected = function (e) {
    e.preventDefault();
    var target = $(e.target).is('tr') ? $(e.target) : $(e.target).closest('tr');
    console.log(target);
    fetchAdminUserActor(target.attr('data-unique-id'));
};

$('document').ready(function () {

    var ajaxFormOptions = {
        beforeSubmit: adminUserFormSubmit,
        success: adminUserFormSuccess,
        type: 'post',
        clearForm: false,
        dataType: 'json',
    };

    $('#actor').ajaxForm(ajaxFormOptions);
    ajaxFormOptions.clearForm = true;
    $('#password_set').ajaxForm(ajaxFormOptions);
    $('#role_add').ajaxForm(ajaxFormOptions);

    $('.icon-user-focus').on("click", { "target": this }, adminUserSelected);

});
