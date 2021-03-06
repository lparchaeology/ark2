// Alert functions

// Set the page level flash
function setPageAlert(status, message, timeout) {
    message = Translator.trans(message);
    status = (status === 'error' ? 'danger' : status);
    $('#alerts').html(
        $('<div class="alert alert-dismissable alert-fadeout fade in alert-' + status + '" role="alert">'
            + '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + message + '</div>')
    );
    if (timeout !== undefined) {
        window.setTimeout(function () {
            $(".alert-fadeout").fadeTo(1000, 0).slideUp(1000, function () {
                $(this).remove();
            });
        }, timeout);
    }
}

// Clear the page level flash
function clearPageAlert() {
    $('#alerts').html('');
}
