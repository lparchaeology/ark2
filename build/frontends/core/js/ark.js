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
    if (typeof applocale != 'undefined') {
        $('.datetimepicker').datetimepicker({
            locale: applocale
        });

        $('.datepicker').datetimepicker({
            locale: applocale,
            minView: 2
        });

        $('.timepicker').datetimepicker({
            locale: applocale,
            format: 'hh:ii',
            maxView: 0
        });
    }

    // Fake readonly mode
    $('.readonly-select').prop('disabled', true);
});

// Undo fake readonly mode
$('form').submit(function() {
    $('.readonly-select').prop('disabled', false);
});

// Summernote Editor
var NoteSaveButton = function(context) {
    var ui = $.summernote.ui;

    // create button
    var button = ui.button({
        contents: '<i class="fa fa-child"/>Save',
        tooltip: 'save',
        click: function() {
            $.post(window.location.pathname, context.invoke('code'));
        }
    });

    return button.render(); // return button as jquery object
}

$('#pageedit').on('click', function() {
    if ($(this).hasClass('active')) {
        $('.inlineedit').summernote('destroy');
    } else {
        $('.inlineedit').summernote({
            focus: true,
            buttons: {
                save: NoteSaveButton
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['fontname', 'fontsize']],
                ['textstyle', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                ['insert', ['picture', 'link', 'video']],
                ['table', ['table']],
                ['hr', ['hr']],
                ['view', ['fullscreen', 'codeview']],
                ['edit', ['undo', 'redo']],
                ['help', ['help']],
                ['save', ['save']]
            ]
        });
    }
});

function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this,
            args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

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
