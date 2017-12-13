$('document').ready(function () {

    if (typeof window.message_id !== 'undefined') {
        $('tr').on("click", { "target": this }, messageclick);
        $(".dime-table tr[data-unique-id='" + window.message_id + "']").click();
    }

    $('tr').each(function (i, e) {
        getMessage($(e).attr('data-unique-id'));
    })
});
