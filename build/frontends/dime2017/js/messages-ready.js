$('document').ready(function () {

    $('tr').on("click", { "target": this }, messageclick);

    if (typeof window.message_id !== 'undefined') {
        $(".dime-table tr[data-unique-id='" + window.message_id + "']").click();
    }

    $('tr').each(function (i, e) {
        getMessage($(e).attr('data-unique-id'));
    })
});
