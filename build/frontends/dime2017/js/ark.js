$(document).ready(function() {
    // Replace all select tags with Select2
    $("select").select2({
        minimumResultsForSearch: 11,
        width: 'resolve'
    });
    // HACK To fix Select2 not being responsive
    // See https://github.com/select2/select2/issues/3278 and http://stackoverflow.com/a/41429176
    $(".select2.select2-container").css("width", "100%");
    //$("date").datetimepicker();
    //$("time").datetimepicker();
    //$("datetime").datetimepicker();
    $('.datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd hh:ii'
    });
    $('.datepicker').datetimepicker({
        format: 'yyyy-mm-dd',
        minView: 2
    });
    $('.timepicker').datetimepicker({
        format: 'hh:ii',
        maxView: 0
    });
    // FIXME Hide Bootstrap Table loading animation as is a bit broken
    $('.table-bootstrap-table').bootstrapTable('hideLoading');

    $(".carouselextratext_0").show();

    $('#carousel-custom').bind('slide.bs.carousel', function (e) {
        var slideFrom = $(this).find('.active').index();
        console.log(slideFrom);
        var slideTo = $(e.relatedTarget).index();
        console.log(slideTo);
        console.log(slideFrom+' => '+slideTo);
        $(".carouselextratext_"+slideFrom.toString()).hide();
        $(".carouselextratext_"+slideTo.toString()).show();
    });

    $("span.thumbimage").hide();


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
