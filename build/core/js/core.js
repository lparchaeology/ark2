$(document).ready(function () {

    // Replace all select tags with Select2
    $("select").select2({
        minimumResultsForSearch: 11,
        width: 'resolve',
    });
    // HACK To fix Select2 not being responsive
    // See https://github.com/select2/select2/issues/3278 and http://stackoverflow.com/a/41429176
    $(".select2.select2-container").css("width", "100%");


    //$("date").datetimepicker();
    //$("time").datetimepicker();
    //$("datetime").datetimepicker();
    if (typeof applocale !== 'undefined') {
        $('.datetimepicker').datetimepicker({
            locale: $('.datetimepicker')[0].lang,
        });

        $('.datepicker').datetimepicker({
            locale: $('.datepicker')[0].lang,
            minView: 2,
        });

        $('.timepicker').datetimepicker({
            locale: $('.timepicker')[0].lang,
            format: 'hh:ii',
            maxView: 0,
        });
    }

    // FIXME Hide Bootstrap Table loading animation as is a bit broken
    $('.table-bootstrap-table').bootstrapTable('hideLoading');

    // Bootstrap table seems to be ignoring the icons attribute so hack it here for now
    $('.btn-group[title="Columns"]').find('i.glyphicon-th').removeClass('glyphicon-th').addClass('glyphicon-th-list');


    // Fake readonly mode on select widgets
    $('.readonly-select').prop('disabled', true);
});

// Undo fake readonly mode
$('form').submit(function () {
    $('.readonly-select').prop('disabled', false);
});
