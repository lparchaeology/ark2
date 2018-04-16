$('document').ready(function () {

    $('#museum').ajaxForm({
        beforeSubmit: museumFormSubmit,
        success: museumFormSuccess,
        type: 'post',
        clearForm: false,
        dataType: 'json',
    });

    $('#dime_museum_table .icon-user-focus').on("click", { "target": this }, museumSelected);

    $('table#dime_museum_table').on('post-body.bs.table', function () {
        $('#dime_museum_table .icon-user-focus').on("click", { "target": this }, museumSelected);
    });

});
