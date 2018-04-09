$(document).ready(function () {

    $('.datetimepicker').datetimepicker({
        language: lang,
    });

    $('.filters-toggle').toggle(".filters");

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

    // Overide the default Table Export settings
    // In an ideal world this would be somewhere else
    bootstrapTableOptions = $(".dime-table").bootstrapTable('getOptions');

    $.extend(bootstrapTableOptions, $.fn.bootstrapTable.locales[lang]);
    $.extend(bootstrapTableOptions, {
        exportTypes: ['csv'],
        exportOptions: {
            csvEnclosure: Translator.trans('core.csv.enclosure.default'),
            csvSeparator: Translator.trans('core.csv.separator.default'),
            fileName: Translator.trans('core.csv.filename.default'),
        },
    });

    $(".dime-table").bootstrapTable('refreshOptions', bootstrapTableOptions);

    // HACK To add columns of checkboxes
    $("#find_secondary_term").css("width", "100%");
    $(".checkbox").addClass("col-xs-4 col-sm-4 ");
    $("#edit_roles .checkbox").removeClass("col-xs-4 col-sm-4");

    $('.loginbutton').click(function () {
        $('.sidebar').removeClass('collapse');
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

    //This will detect for form changes and alert the user if data will be closest
    var is_dirty = false;
    window.answer = false;

    for (id in window.watchForChanges) {
        console.log('input#' + window.watchForChanges[id] + '_value');
        $('input#' + window.watchForChanges[id] + '_value').on('change', function () {
            console.log("dirty");
            if (!is_dirty) {
                is_dirty = true;
            }
        });
        $('select#' + window.watchForChanges[id] + '_term').on('change', function () {
            console.log("dirty");
            if (!is_dirty) {
                is_dirty = true;
            }
        });
        $('textarea#' + window.watchForChanges[id] + '_content').on('change', function () {
            console.log("dirty");
            if (!is_dirty) {
                is_dirty = true;
            }
        });
    }
    $('#find_secondary_term').find(':input').on('change', function () {
        console.log("dirty");
        if (!is_dirty) {
            is_dirty = true;
        }
    });

    // sadly we can't intercept browser events because of "security", we can capture anchor clicks
    $('a').mousedown(function (e) {
        if (is_dirty) {
            // if the user navigates away from this page via an anchor link,
            //    popup a new bootbox confirmation.
            bootbox.confirm(Translator.trans("dime.confirmnavigation.default"), function (response) {
                console.log(response);
                window.answer = response;
                if (response) {
                    e.target.click();
                }
            });
        }
    });

    // if the other link doesn't activate (answer) then use the default catch - Even Facey B is stuck with this workaround
    window.onbeforeunload = function () {
        if ((is_dirty) && (!window.answer)) {
            // call this if the box wasn't shown.
            return Translator.trans("dime.confirmnavigation.default");
        }
    };

    $("#photo-modal").on('shown.bs.modal', function () {
        $('#find_image_file').click();
    });

    $("#photo-modal").on('hidden.bs.modal', function () {
        $("#find-registered-alert").alert("close");
    });

    $('#modal_photobtn').on('click', function () {
        $('.file-input').find('.glyphicon-folder-open').parent().hide();
        $('#photo-btn').on('click', function () {
            $('#find_image_file').click();
        });
    });

});
