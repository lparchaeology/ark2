// Summernote Editor
var NoteSaveButton = function (context) {
    var ui = $.summernote.ui;

    // create button
    var button = ui.button({
        contents: '<i class="fa fa-child"/>Save',
        tooltip: 'save',
        click: function () {
            var response = {
                route: pageRoute,
                content: context.invoke('code')
            };
            var path = Router.generatePath('dime.api.page.content', {});
            $.post(path, JSON.stringify(response), function(result) {});
        }
    });

    return button.render(); // return button as jquery object
};

$('#pageedit').on('click', function () {
    if ($(this).hasClass('active')) {
        $('.inlineedit').summernote('destroy');
    } else {
        $('.inlineedit').summernote({
            lang: lang,
            focus: true,
            buttons: {
                save: NoteSaveButton,
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
                ['save', ['save']],
            ],
        });
    }
});
