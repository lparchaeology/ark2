$('document').ready(function () {

    $('#message').ajaxForm({
        beforeSubmit: messageFormSubmit,
        success: messageFormSuccess,
        type: 'post',
        clearForm: false,
        dataType: 'json',
    });

    $('.message-table > tbody  > tr').on("click", { "target": this }, messageSelected);
});
