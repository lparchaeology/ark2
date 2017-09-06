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
        initialPreviewConfig = [];

        if (typeof $(this).attr('data-existing') == 'string'){

            var arr = $(this).attr('data-existing').split(',');

            var len = arr.length;

            for (var i = 0; i < len; i++) {
                initialPreview.push('<img class="profile-img" class="file-preview-image" src="/dime/img/'+arr[i]+'?p=preview">');
                initialPreviewConfig.push({ key: arr[i] });
            }

        }

        $("#find_image_existing").data('uploadUploaded',{});
        $("#find_image_existing").data('uploadPreview',{});

        $(this).fileinput({
            'theme': 'gly',
            'showUpload':false,
            'showRemove':true,
            //'autoReplace': true,
            'overwriteInitial': false,
            //'validateInitialCount': true,
            'allowedFileTypes': ['image'],
            'previewFileType':'image',
            'allowedFileExtensions': ["jpg", "png", "gif"],
            'initialPreview': initialPreview,
            'initialPreviewConfig': initialPreviewConfig,
            //'initialPreviewAsData': true,
            'minFileCount': 0,
            'maxFileCount': 3,
            'deleteUrl': "../true.json",
            'uploadUrl': "/api/internal/file",
            'uploadAsync': false,
        }).on("filebatchselected", function(event, files) {
            // trigger upload method immediately after files are selected
            console.log(files);
            $("input[type=file]").fileinput("upload");
        }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
            var response = data.response;
            if ( $("#find_image_existing > input[value='null']").length > 0 ){
                $("#find_image_existing > input[value='null']").first().val(response[0]);
            } else {
                var count = $("#find_image_existing > input").length;
                if (count < 3) {
                    if($("#find_image_existing_0").length == 0){
                        $("#find_image_existing").append($("<input type=\"hidden\" id=\"find_image_existing_0\" name=\"find[image][existing][0]\" value=\""+response[0]+"\">"))
                    } else if($("#find_image_existing_1").length == 0) {
                        $("#find_image_existing").append($("<input type=\"hidden\" id=\"find_image_existing_1\" name=\"find[image][existing][1]\" value=\""+response[0]+"\">"))
                    } else {
                        $("#find_image_existing").append($("<input type=\"hidden\" id=\"find_image_existing_2\" name=\"find[image][existing][2]\" value=\""+response[0]+"\">"))
                    }
                } else {
                    var removePreview = $("#find_image_existing_"+(count-1).toString()).val();
                    console.log(removePreview);
                    var uploadPreview = $("#find_image_existing").data('uploadPreview')
                    console.log(uploadPreview);
                    for (upload in uploadPreview){
                        if(removePreview==uploadPreview[upload]){
                           console.log(uploadPreview[upload]);

                            $("#"+upload).find("button.kv-file-remove").click();
                        }
                    }


                    console.log($("button.kv-file-remove[data-key="+removePreview+"]"))

                    $("button.kv-file-remove[data-key="+removePreview+"]").click();

                    $("#find_image_existing_"+(count-1).toString()).val(response[0]);
                }
            }
            var uploadUploaded = $("#find_image_existing").data('uploadUploaded');
            var thumbnails = $(".kv-preview-thumb");
            uploadUploaded[response[0]] = thumbnails.last();
        }).on('filebatchuploadcomplete', function(event, file, extra) {
            var uploadUploaded = $("#find_image_existing").data('uploadUploaded');
            var uploadPreview = $("#find_image_existing").data('uploadPreview');
            for (key in uploadUploaded){
                uploadPreview[$(uploadUploaded[key])[0].id] = key;
            }
        }).on('filesuccessremove', function(event, id) {
            var form_root_array = $(this).closest(".file-input").find("input[type=file]").attr('id').split("_");
            form_root_array.splice(-1,1);

            console.log(id);

            console.log($('#'+id));

            var existing_id_container = form_root_array.join("_")+"_existing";

            var uploadPreview = $("#find_image_existing").data('uploadPreview');

            console.log(id);
            console.log(uploadPreview);
            console.log(uploadPreview[id]);

            if ($("#"+existing_id_container).find('input[value="'+uploadPreview[id]+'"]').remove()) {
                console.log('Uploaded thumbnail successfully removed');
             } else {
                 return false; // abort the thumbnail removal
             }
         }).on('filedeleted', function(event, id) {
             var form_root_array = $(this).closest(".file-input").find("input[type=file]").attr('id').split("_");
             form_root_array.splice(-1,1);
             var existing_id_container = form_root_array.join("_")+"_existing";

             if ($("#"+existing_id_container).find('input[value="'+id+'"]').remove()) {
                 console.log('Uploaded thumbnail successfully removed');
              } else {
                  return false; // abort the thumbnail removal
              }
          });
    });

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
