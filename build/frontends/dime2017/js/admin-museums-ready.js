$('document').ready(function () {

    $('#museum').ajaxForm({
        beforeSubmit: museumFormSubmit,
        success: museumFormSuccess,
        type: 'post',
        clearForm: false,
        dataType: 'json',
    });

    $('.icon-user-focus').on("click", { "target": this }, museumSelected);

});
