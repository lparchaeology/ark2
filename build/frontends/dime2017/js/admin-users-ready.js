$('document').ready(function () {

    $('#actor').ajaxForm({
        beforeSubmit: adminUserFormSubmit,
        success: adminUserFormSuccess,
        type: 'post',
        clearForm: false,
        dataType: 'json',
    });

    $('#actor_role').ajaxForm({
        beforeSubmit: adminUserFormSubmit,
        success: adminUserFormSuccess,
        type: 'post',
        clearForm: true,
        dataType: 'json',
    });

    $('#user_status').ajaxForm({
        beforeSubmit: adminUserFormSubmit,
        success: adminUserFormSuccess,
        type: 'post',
        clearForm: true,
        dataType: 'json',
    });

    $('#password_set').ajaxForm({
        beforeSubmit: adminUserFormSubmit,
        success: adminUserFormSuccess,
        type: 'post',
        clearForm: true,
        dataType: 'json',
    });

    $('#dime_profile_table .icon-user-focus').on("click", { "target": this }, adminUserSelected);

    $('table#dime_profile_table').on('post-body.bs.table', function () {
        $('#dime_profile_table .icon-user-focus').on("click", { "target": this }, adminUserSelected);
    });

});
