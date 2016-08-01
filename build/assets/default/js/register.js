$(document).ready(function() {
    editableNewRegisterRow();
    ('#register-table').bootstrapTable('hideLoading');
});

function hideEditableRegisterRow() {
    $('#register-table').find('tbody').find('a').not('.row-view, .row-edit, .row-save, .row-cancel, .row-delete').editable('hide');
}

function editableRegisterRow(index) {
    hideEditableRegisterRow();
    $('#register-table').find('tbody').find('tr').eq(index).find('a').not('.row-view, .row-edit, .row-save, .row-cancel, .row-delete').editable('show');
}

function editableNewRegisterRow() {
    $('#register-new').find('a').not('.row-view, .row-edit, .row-save, .row-cancel, .row-delete').editable('show');
}

window.registerEvents = {
    'click .row-view': function (e, value, row, index) {
        alert('View row ' + row.id);
    },
    'click .row-edit': function (e, value, row, index) {
        editableRegisterRow(index);
    },
    'click .row-save': function (e, value, row, index) {
        alert('Save row ' + row.id);
    },
    'click .row-cancel': function (e, value, row, index) {
        alert('Cancel row ' + row.id);
    },
    'click .row-delete': function (e, value, row, index) {
        $('#register-table').bootstrapTable('remove', {
            field: 'id',
            values: [row.id]
        });
    }
};
