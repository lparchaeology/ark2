/*functions for making ajax user admin page */

// Return current user ID
function adminUserId() {
    return $('#actor_id_value').val();
}

// Set the current user ID
var setAdminUserId = function setAdminUserId(id) {
    $('#actor').attr('action', Router.generatePath('api.internal.actor', { id: id }));
    $('#password_set').attr('action', Router.generatePath('api.internal.user.password.set', { id: id }));
    $('#role_add').attr('action', Router.generatePath('api.internal.actor.role.add', { id: id }));
};

// Call API to fetch user details
var fetchAdminUserActor = function (id) {
    clearPageAlert();
    $('#actor').clearForm();
    $.ajax(Router.generatePath('api.internal.actor', { id: id })).fail(function (response) {
        $('#actor').clearForm();
        setPageAlert(response.status, response.message, 5000);
    }).done(function (response) {
        FormMapper.mapDataToForm(response, $('#actor')[0]);
        setAdminUserId(id);
    });
};

// AJAX Form Submission
function adminUserFormSubmit(data, $form, options) {
    clearPageAlert();
    return adminUserId() ? true : false;
}

// AJAX Form post-submit callback
function adminUserFormSuccess(response) {
    setPageAlert(response.status, response.message, 5000);
}

var itemFormToHtml = function (data) {
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
    fetchAdminUserActor(target.attr('data-unique-id'));
};

$('document').ready(function () {

    $('#actor').ajaxForm({
        beforeSubmit: adminUserFormSubmit,
        success: adminUserFormSuccess,
        type: 'post',
        clearForm: false,
        dataType: 'json',
    });
    $('#password_set').ajaxForm({
        beforeSubmit: adminUserFormSubmit,
        success: adminUserFormSuccess,
        type: 'post',
        clearForm: true,
        dataType: 'json',
    });
    $('#role_add').ajaxForm({
        beforeSubmit: adminUserFormSubmit,
        success: adminUserFormSuccess,
        type: 'post',
        clearForm: true,
        dataType: 'json',
    });

    $('.icon-user-focus').on("click", { "target": this }, adminUserSelected);

});
