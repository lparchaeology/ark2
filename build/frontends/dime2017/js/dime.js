$(document).ready(function () {

    $('.datetimepicker').datetimepicker({
        language: lang,
    });

    $('.datepicker').datetimepicker({
        language: lang,
        minView: 2,
        autoclose: true,
        clearBtn: true,
        todayBtn: true,
        todayHighlight: true,
    });

    $('.timepicker').datetimepicker({
        language: lang,
        maxView: 0,
    });

    // HACK To add columns of checkboxes
    $("#find_secondary_term").css("width", "100%");
    $(".checkbox").addClass("col-xs-4 col-sm-4 ");
    $("#edit_roles .checkbox").removeClass("col-xs-4 col-sm-4");

    $('.loginbutton').click(function () {
        $('.sidebar').removeClass('collapse');
    });

    $("input[type=file]").each(function () {

        initialPreview = [];
        initialPreviewConfig = [];

        if (typeof $(this).attr('data-existing') === 'string') {

            var arr = $(this).attr('data-existing').split(',');

            var len = arr.length;

            for (var i = 0; i < len; i++) {
                initialPreview.push('<img class="profile-img" class="file-preview-image" src="/img/' + arr[i] + '?p=preview">');
                initialPreviewConfig.push({ key: arr[i] });
            }

        }

        $("#find_image_existing").data('uploadUploaded', {});
        $("#find_image_existing").data('uploadPreview', {});

        $(this).fileinput({
            'language': lang,
            'theme': 'gly',
            'showUpload': false,
            'showRemove': true,
            //'autoReplace': true,
            'overwriteInitial': false,
            //'validateInitialCount': true,
            'allowedFileTypes': ['image'],
            'previewFileType': 'image',
            'allowedFileExtensions': ["jpg", "png", "gif"],
            'initialPreview': initialPreview,
            'initialPreviewConfig': initialPreviewConfig,
            //'initialPreviewAsData': true,
            'minFileCount': 0,
            'maxFileCount': 3,
            'deleteUrl': "../true.json",
            'uploadUrl': "../api/internal/file",
            'uploadAsync': false,
        }).on("filebatchselected", function (event, files) {
            // trigger upload method immediately after files are selected
            $("input[type=file]").fileinput("upload");
        }).on('filebatchuploadsuccess', function (event, data, previewId, index) {
            var response = data.response;
            if ($("#find_image_existing > input[value='null']").length > 0) {
                $("#find_image_existing > input[value='null']").first().val(response[0]);
            } else {
                var count = $("#find_image_existing > input").length;
                if (count < 3) {
                    if ($("#find_image_existing_0").length === 0) {
                        $("#find_image_existing").append($("<input type=\"hidden\" id=\"find_image_existing_0\" name=\"find[image][existing][0]\" value=\"" + response[0] + "\">"));
                    } else if ($("#find_image_existing_1").length === 0) {
                        $("#find_image_existing").append($("<input type=\"hidden\" id=\"find_image_existing_1\" name=\"find[image][existing][1]\" value=\"" + response[0] + "\">"));
                    } else {
                        $("#find_image_existing").append($("<input type=\"hidden\" id=\"find_image_existing_2\" name=\"find[image][existing][2]\" value=\"" + response[0] + "\">"));
                    }
                } else {
                    var removePreview = $("#find_image_existing_" + (count - 1).toString()).val();
                    var uploadPreview = $("#find_image_existing").data('uploadPreview');
                    for (var upload in uploadPreview) {
                        if (removePreview === uploadPreview[upload]) {
                            $("#" + upload).find("button.kv-file-remove").click();
                        }
                    }


                    $("button.kv-file-remove[data-key=" + removePreview + "]").click();

                    $("#find_image_existing_" + (count - 1).toString()).val(response[0]);
                }
            }
            var uploadUploaded = $("#find_image_existing").data('uploadUploaded');
            var thumbnails = $(".kv-preview-thumb");
            uploadUploaded[response[0]] = thumbnails.last();
        }).on('filebatchuploadcomplete', function (event, file, extra) {
            var uploadUploaded = $("#find_image_existing").data('uploadUploaded');
            var uploadPreview = $("#find_image_existing").data('uploadPreview');
            for (var key in uploadUploaded) {
                uploadPreview[$(uploadUploaded[key])[0].id] = key;
            }
        }).on('filesuccessremove', function (event, id) {
            var form_root_array = $(this).closest(".file-input").find("input[type=file]").attr('id').split("_");
            form_root_array.splice(-1, 1);

            var existing_id_container = form_root_array.join("_") + "_existing";

            var uploadPreview = $("#find_image_existing").data('uploadPreview');

            if ($("#" + existing_id_container).find('input[value="' + uploadPreview[id] + '"]').remove()) {
                console.log('Uploaded thumbnail successfully removed');
            } else {
                return false; // abort the thumbnail removal
            }
        }).on('filedeleted', function (event, id) {
            var form_root_array = $(this).closest(".file-input").find("input[type=file]").attr('id').split("_");
            form_root_array.splice(-1, 1);
            var existing_id_container = form_root_array.join("_") + "_existing";

            if ($("#" + existing_id_container).find('input[value="' + id + '"]').remove()) {
                console.log('Uploaded thumbnail successfully removed');
            } else {
                return false; // abort the thumbnail removal
            }
        });
    });

    $(".carouselextratext_0").show();

    $('#carousel-custom').bind('slide.bs.carousel', function (e) {
        var slideFrom = $(this).find('.active').index();
        var slideTo = $(e.relatedTarget).index();
        $(".carouselextratext_" + slideFrom.toString()).hide();
        $(".carouselextratext_" + slideTo.toString()).show();
    });

    $("span.thumbimage").hide();

    $('.sidebar').on('show.bs.collapse', function () {
        var $div = $("<div>", {
            id: "navbar-fade",
            "class": "modal-backdrop fade in",
        });
        $div.click(function () {
            $('.sidebar').collapse('toggle');
            $('.modal-backdrop').detach();
        });
        $(this).css('z-index', 9999);
        $("body").append($div);
    });

    $('[data-toggle="tooltip"]').tooltip({
        'trigger': 'manual'
    }).on('click', function (e) {
        // show this one
        $(this).tooltip('toggle');
        // if any other tooltip are visible, hide them
        $('[data-toggle="tooltip"]').not(this).tooltip('hide');
        // set them unclicked
        $('[data-toggle="tooltip"]').not(this).data("bs.tooltip").inState.click = false;
    });

});
