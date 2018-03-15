var formFileImageDefaults = {
    'language': lang,
    'theme': 'gly',
    'showUpload': false,
    'showRemove': true,
    'overwriteInitial': false,
    'allowedFileTypes': ['image'],
    'previewFileType': 'image',
    'allowedFileExtensions': ["jpg", "png", "gif"],
    'minFileCount': 0,
    'maxFileCount': 3,
    'deleteUrl': "../true.json",
    'uploadUrl': "../api/internal/file",
    'uploadAsync': false,
}

$("input[type=file]").each(function () {

    initialPreview = [];
    initialPreviewConfig = [];

    if (typeof $(this).attr('data-existing') === 'string') {

        var arr = $(this).attr('data-existing').split(',');

        var len = arr.length;

        for (var i = 0; i < len; i++) {
            initialPreview.push('<img class="profile-img" class="file-preview-image" src="/img/file/' + arr[i] + '?p=preview">');
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
        var uploadPreview = $("#find_image_existing").data('uploadPreview');
        for (index in response) {
            var thumbnail = thumbnails.length - response.length + parseInt(index);
            uploadPreview[response[index]] = thumbnails[thumbnail];
        }
        console.log({ "uploadPreview": uploadPreview });
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
    }).on("filepredelete", function (event) {
        var abort = true;
        bootbox.confirm(Translator.trans("dime.confirmfiledeletion.default"), function (result) { abort = !result; });
        return abort;
    })
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
    e.stopPropagation();
    // show this one
    $(this).tooltip('toggle');
    // if any other tooltip are visible, hide them
    $('[data-toggle="tooltip"]').not(this).tooltip('hide');
    // set them unclicked
    $('[data-toggle="tooltip"]').not(this).data("bs.tooltip").inState.click = false;
});

$("body").on("click", function (e) {
    // unless clicking a tooptip
    if ($(e.target).hasClass("tooltip") === false && $(e.target).hasClass("help") === false) {
        $('[data-toggle="tooltip"]').tooltip('hide');
    }
})

$("#find_class_term").on("change", function () {
    window.onbeforeunload = function () {
        return true;
    };
});

$("#find_save").on("click", function () {
    if ($(this).closest("form")[0].checkValidity()) {
        window.onbeforeunload = null;
    }
});

// Apply actions to tables
$('form#action').find('#action_apply').click(function (e) {
    var table = $(this).closest('form#action').siblings('.table-wrapper-div').find('table.bootstrap-table');
    var selected = table.find('tr.selected');
    var items = [];
    selected.each(function () {
        var item = $(this).attr('data-unique-id');
        items.push(item);
    });
    $(this).closest('form#action').find('#action_selected').val(items);
});
