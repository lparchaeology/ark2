/*functions for making ajax message page */

// Return current message ID
function messageId() {
    return $('#message_id_value').val();
}

// Set the current message ID
var setMessageId = function setMessageId(id) {
    $('#message').attr('action', Router.generatePath('dime.api.message.item', { id: id }));
};

// Call API to mark message as read
var markMessageAsRead = function (id, recipient) {
    var payload = JSON.stringify({ "message": id, "recipient": recipient });
    var path = Router.generatePath('dime.api.message.read');
    $.post(path, payload, function () {});
};

// Call API to fetch message details
var fetchMessage = function (id) {
    clearPageAlert();
    $('#message').clearForm();
    var path = Router.generatePath('dime.api.message.item', { id: id });
    if (path === undefined) {
        return;
    }
    $.ajax(path).fail(function (response) {
        $('#message').clearForm();
        setPageAlert(response.status, response.message, 5000);
    }).done(function (response) {
        FormMapper.mapDataToForm(response, $('#message')[0]);
        setMessageId(id);
        markMessageAsRead(id, ark.actor);
    });
};

// AJAX Form Submission
function messageFormSubmit(data, $form, options) {
    clearPageAlert();
    return messageId() ? true : false;
}

// AJAX Form post-submit callback
function messageFormSuccess(response) {
    setPageAlert(response.status, response.message, 5000);
}

var messageSelected = function (e) {
    e.preventDefault();
    $('#message').clearForm();
    $('tr').removeClass('selected');
    var target = $(e.target).is('tr') ? $(e.target) : $(e.target).closest('tr');
    target.addClass('selected');
    fetchMessage(target.attr('data-unique-id'));
    target.addClass('read');
};
