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

    $('.sidebar').on('show.bs.collapse', function(){
        var $div = $("<div>", {id: "navbar-fade", "class": "modal-backdrop fade in"});
        $div.click(function(){  $('.sidebar').collapse('toggle'); $('.modal-backdrop').detach(); });
        $(this).css('z-index', 9999);
        $("body").append($div);
    });
});

$('#dime_find_item_dime_fetch').on('click', function () {
    var easting = $('#dime_find_item_dime_find_findpoint_easting').val();
    var northing = $('#dime_find_item_dime_find_findpoint_northing').val();
    var wkt = 'POINT(' + easting + ' ' + northing + ')';
    $.post('/dime/api/geo/find', wkt, function(result){
        $('#dime_find_item_dime_find_kommune_kommune').val(result['kommune']).trigger("change");
        $('#dime_find_item_dime_find_museum_name').val(result['museum']).trigger("change");
    });
});

// Summernote Editor
var NoteSaveButton = function (context) {
  var ui = $.summernote.ui;

  // create button
  var button = ui.button({
    contents: '<i class="fa fa-child"/>Save',
    tooltip: 'save',
    click: function () {
      $.post(window.location.pathname, context.invoke('code'));
    }
  });

  return button.render();   // return button as jquery object
}

$('#pageedit').on('click', function () {
    if ($(this).hasClass('active'))  {
        $('.inlineedit').summernote('destroy');
    } else {
        $('.inlineedit').summernote(
            {
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
            }
        );
    }
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
