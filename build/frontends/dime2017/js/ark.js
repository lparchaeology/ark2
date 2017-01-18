$(document).ready(function() {
    // Replace all select tags with Select2
    $("select").select2();
    // HACK To fix Select2 not being responsive
    // See https://github.com/select2/select2/issues/3278 and http://stackoverflow.com/a/41429176
    $(".select2.select2-container").css("width", "100%");
    // FIXME Hide Bootstrap Table loading animation as is a bit broken
    $('.table-bootstrap-table').bootstrapTable('hideLoading');
});

jQuery(function($) {
    $('form[data-async]').on('submit', function(event) {
        var $form = $(this);
        var $target = $($form.attr('data-target'));

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),

            success: function(data, status) {
                console.log(data);
                location.reload();
                //$target.modal('hide');
            }

        });

        event.preventDefault();
    });
});
