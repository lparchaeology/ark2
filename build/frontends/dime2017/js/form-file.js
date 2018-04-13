$(document).ready(function () {
    var fileInputPromise = new Promise(function (resolve, reject) {

        $("input[type=file]").each(function () {

            initialPreview = [];
            initialPreviewConfig = [];

            if (typeof $(this).attr('data-existing') === 'string') {

                var arr = $(this).attr('data-existing').split(',');

                var len = arr.length;

                for (var i = 0; i < len; i++) {
                    initialPreview.push('<img class="profile-img" class="file-preview-image" src="/img/file/' + arr[i] + '?p=preview">');
                    initialPreviewConfig.push({
                        key: arr[i],
                        downloadUrl: "/img/file/" + arr[i],
                    });
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
                'maxFileSize': 8192,
                'deleteUrl': "/true.json",
                'uploadUrl': "../api/internal/file",
                'uploadAsync': false,
            }).on("filebatchselected", function (event, files) {
                // trigger upload method immediately after files are selected
                $("input[type=file]").fileinput("upload");
            }).on('filebatchuploadsuccess', function (event, data, previewId, index) {
                var response = data.response.slice(0, 3);
                $("#find_image_existing").data('uploadResponse', response);
                var uploadPreview = $("#find_image_existing").data('uploadPreview');

                var find_image_existing_null = $("#find_image_existing > input[value='null']").length;
                var rawindex = 0;

                while (find_image_existing_null > 0 && rawindex in response) {
                    console.log({ "find_image_existing_null": find_image_existing_null });
                    $("#find_image_existing > input[value='null']").first(0).val(response[rawindex]);
                    rawindex += 1;
                    find_image_existing_null = $("#find_image_existing > input[value='null']").length;
                }
                if (rawindex < response.length) {
                    for (index in response) {
                        if (index < rawindex) {
                            continue;
                        }
                        var removePreview = $("#find_image_existing_" + (2 - index).toString()).val();
                        console.log(removePreview);
                        if (removePreview != null) {
                            $(uploadPreview[removePreview]).find('button.kv-file-remove').click();
                        }
                        $("#find_image_existing_" + (2 - index).toString()).val(response[index]);
                    }
                }
            }).on('filebatchuploadcomplete', function (event, file, extra) {
                var thumbnails = $('.file-preview-success');
                console.log(thumbnails);
                console.log(thumbnails.length);
                var response = $("#find_image_existing").data('uploadResponse');
                console.log(response);
                var uploadPreview = $("#find_image_existing").data('uploadPreview');
                for (index in response) {
                    var thumbnail = thumbnails.length - response.length + parseInt(index);
                    uploadPreview[response[index]] = thumbnails[thumbnail];
                }
                $('.glyphicon-camera-button-required').hide();
                $('.glyphicon-camera-button-complete').show();
                $('#photo-modal').modal('hide');
            }).on('filesuccessremove', function (event, id) {
                var form_root_array = $(this).closest(".file-input").find("input[type=file]").attr('id').split("_");
                form_root_array.splice(-1, 1);

                var existing_id_container = form_root_array.join("_") + "_existing";

                var uploadPreview = $("#find_image_existing").data('uploadPreview');

                if ($("#" + existing_id_container).find('input[value="' + uploadPreview[id] + '"]').val("null")) {
                    console.log('Uploaded thumbnail successfully removed');
                } else {
                    return false; // abort the thumbnail removal
                }
            }).on('filedeleted', function (event, id) {
                var form_root_array = $(this).closest(".file-input").find("input[type=file]").attr('id').split("_");
                form_root_array.splice(-1, 1);
                var existing_id_container = form_root_array.join("_") + "_existing";

                if ($("#" + existing_id_container).find('input[value="' + id + '"]').val("null")) {
                    console.log('Uploaded thumbnail successfully removed');
                } else {
                    return false; // abort the thumbnail removal
                }
                window.abortFileDelete = "unset";

            }).on("filepredelete", function (event) {
                if (window.abortFileDelete !== "true") { return true; }
            })
        });
        resolve("ready");
    });


    fileInputPromise.then(function (ready) {

        window.abortFileDelete = "unset";

        $('.kv-file-remove').click(function (e) {

            if (window.abortFileDelete === "false") {
                window.abortFileDelete = "unset";
            }

            if (window.abortFileDelete === "unset") {
                e.preventDefault();
                window.currentDeleteTarget = $(event.target);

                bootbox.confirm(Translator.trans("dime.confirmfiledeletion.default"), function (result) {
                    if (result) {
                        window.abortFileDelete = "true";
                        window.currentDeleteTarget.click();
                    } else {
                        window.abortFileDelete = "false";
                    }
                });
            }
        });
    });
});
