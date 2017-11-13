$(document).ready(function () {
    // Set global defaults for all Select2 widgets
    $.fn.select2.defaults.set("language", lang);
    $.fn.select2.defaults.set("minimumResultsForSearch", 11);
    $.fn.select2.defaults.set("width", 'resolve');
    // Replace all select tags with Select2
    $("select").select2();
    // HACK To fix Select2 not being responsive
    // See https://github.com/select2/select2/issues/3278 and http://stackoverflow.com/a/41429176
    $(".select2.select2-container").css("width", "100%");

    // Replace all date/time tags with a picker
    $('.datetimepicker-input').datetimepicker({
        locale: lang,
        showClear: true,
        showClose: true,
        showTodayButton: true,
        allowInputToggle: true,
    });

    // FIXME Hide Bootstrap Table loading animation as is a bit broken
    //$('.table-bootstrap-table').bootstrapTable('hideLoading');

    // Bootstrap table seems to be ignoring the icons attribute so hack it here for now
    //$('.btn-group[title="Columns"]').find('i.glyphicon-th').removeClass('glyphicon-th').addClass('glyphicon-th-list');


    // Fake readonly mode on select widgets
    $('.readonly-required').prop('required', false);
    $('.readonly-select').prop('disabled', true);
});
