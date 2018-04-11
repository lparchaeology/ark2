/*functions for making ajax user admin page */

// Return current user ID
function adminUserId() {
    return $('#actor_id_value').val();
}

// Set the current user ID
var setAdminUserId = function setAdminUserId(id) {
    $('#actor').attr('action', Router.generatePath('dime.api.actor.item', { id: id }));
    $('#actor_role').attr('action', Router.generatePath('dime.api.actor.role', { id: id }));
    $('#user_status').attr('action', Router.generatePath('dime.api.user.status', { id: id }));
    $('#password_set').attr('action', Router.generatePath('dime.api.user.password.set', { id: id }));
};

// Call API to fetch user details
var fetchAdminUserActor = function (id) {
    clearPageAlert();
    $('#actor').clearForm();
    $('#actor_role').clearForm();
    $('#user_status').clearForm();
    var path = Router.generatePath('dime.api.actor.item', { id: id });
    if (path === undefined) {
        return;
    }
    $.ajax(path).fail(function (response) {
        setPageAlert(response.status, response.message, 5000);
    }).done(function (response) {
        FormMapper.mapDataToForm(response, $('#actor')[0]);
        path = Router.generatePath('dime.api.actor.role', { id: id });
        $.ajax(path).done(function (response) {
            FormMapper.mapDataToForm(response, $('#actor_role')[0]);
        });
        path = Router.generatePath('dime.api.user.status', { id: id });
        $.ajax(path).done(function (response) {
            FormMapper.mapDataToForm(response, $('#user_status')[0]);
        });
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
    fetchAdminUserActor(adminUserId());
    setPageAlert(response.status, Translator.trans(response.message + '.' + response.status), 5000);
}

var adminUserSelected = function (e) {
    e.preventDefault();
    e.stopPropagation();
    var target = $(e.target).is('tr') ? $(e.target) : $(e.target).closest('tr');
    fetchAdminUserActor(target.attr('data-unique-id'));
};
