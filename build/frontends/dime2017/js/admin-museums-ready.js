$('document').ready(function () {

    $('#museum').ajaxForm({
        beforeSubmit: museumFormSubmit,
        success: museumFormSuccess,
        type: 'post',
        clearForm: false,
        dataType: 'json',
    });

    $('.icon-user-focus').on("click", { "target": this }, museumSelected);

    $('table.bootstrap-table').on('post-body.bs.table', function(){
      $('.icon-user-focus').on("click", { "target": this }, museumSelected);
    });

});
