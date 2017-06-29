$(document).ready(function() {

    // Replace all select tags with Select2
    $("select").select2({
        minimumResultsForSearch: 11,
        width: 'resolve'
    });
    // HACK To fix Select2 not being responsive
    // See https://github.com/select2/select2/issues/3278 and http://stackoverflow.com/a/41429176
    //$(".select2.select2-container").css("width", "100%");
    // HACK To add columns of checkboxes
    $("#find_secondary_term").css("width", "100%");
    $(".checkbox").addClass("col-xs-4 col-sm-4 ");
    $("#edit_roles .checkbox").removeClass("col-xs-4 col-sm-4");
    // Fake readonly mode
    $('.readonly-select').prop('disabled', true);

    $('.loginbutton').click(function(){
        $('.sidebar').removeClass('collapse');
    });

    $("input[type=file]").each(function(){

        initialPreview = [];

        if (typeof $(this).attr('data-existing') == 'string'){

            var arr = $(this).attr('data-existing').split(',');

            var len = arr.length;

            for (var i = 0; i < len; i++) {
                initialPreview.push('<img class="profile-img" class="file-preview-image" src="/dime/img/'+arr[i]+'?p=preview">');
            }

        }

        $(this).fileinput({
            'theme': 'gly',
            'showUpload':false,
            //'autoReplace': true,
            //'validateInitialCount': true,
            'allowedFileTypes': ['image'],
            'previewFileType':'image',
            'allowedFileExtensions': ["jpg", "png", "gif"],
            'initialPreview': initialPreview,
            'minFileCount': 0,
            'maxFileCount': 3

        });
    })

    //$("date").datetimepicker();
    //$("time").datetimepicker();
    //$("datetime").datetimepicker();

    if(typeof applocale != 'undefined' ){
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

    // FIXME Hide Bootstrap Table loading animation as is a bit broken
    $('.table-bootstrap-table').bootstrapTable('hideLoading');

    // Bootstrap table seems to be ignoring the icons attribute so hack it here for now
    $('.btn-group[title="Columns"]').find('i.glyphicon-th').removeClass('glyphicon-th').addClass('glyphicon-th-list');

    $(".carouselextratext_0").show();

    $('#carousel-custom').bind('slide.bs.carousel', function(e) {
        var slideFrom = $(this).find('.active').index();
        console.log(slideFrom);
        var slideTo = $(e.relatedTarget).index();
        console.log(slideTo);
        console.log(slideFrom + ' => ' + slideTo);
        $(".carouselextratext_" + slideFrom.toString()).hide();
        $(".carouselextratext_" + slideTo.toString()).show();
    });

    $("span.thumbimage").hide();

    $('.sidebar').on('show.bs.collapse', function() {
        var $div = $("<div>", {
            id: "navbar-fade",
            "class": "modal-backdrop fade in"
        });
        $div.click(function() {
            $('.sidebar').collapse('toggle');
            $('.modal-backdrop').detach();
        });
        $(this).css('z-index', 9999);
        $("body").append($div);
    });

    $('[data-toggle="tooltip"]').tooltip({'trigger':'click'});

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

// Undo fake readonly mode
$('form').submit(function() {
    $('.readonly-select').prop('disabled', false);
});

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
/*
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
*/
function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
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
