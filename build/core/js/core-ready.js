$(document).ready(function () {
    moment.locale(lang);
    $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales[lang]);
});
