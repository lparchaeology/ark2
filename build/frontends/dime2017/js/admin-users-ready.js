$('document').ready(function () {

    $('#actor').ajaxForm({
        beforeSubmit: adminUserFormSubmit,
        success: adminUserFormSuccess,
        type: 'post',
        clearForm: false,
        dataType: 'json',
    });

    $('#password_set').ajaxForm({
        beforeSubmit: adminUserFormSubmit,
        success: adminUserFormSuccess,
        type: 'post',
        clearForm: true,
        dataType: 'json',
    });

    $('#role_add').ajaxForm({
        beforeSubmit: adminUserFormSubmit,
        success: adminUserFormSuccess,
        type: 'post',
        clearForm: true,
        dataType: 'json',
    });

    $('.icon-user-focus').on("click", { "target": this }, adminUserSelected);

});
