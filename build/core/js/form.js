var FormMapper = (function () {

    var mapDataToCheckboxField = function mapDataToCheckboxField(data, field) {
        console.log('mapDataToCheckboxField');
        console.log(data);
        console.log(field);
        if (data === field.value) {
            field.checked = true;
        } else {
            data = field.defaultChecked ? field.defaultChecked : false;
        }
        console.log(field);
    };

    var mapDataToDateField = function mapDataToDateField(data, field) {
        if ($.type(data) === 'undefined' || data === null) {
            data = field.defaultValue ? field.defaultValue : '';
        }
        field.value = new Date(data).toISOString().split('T')[0];
    };

    var mapDataToRadioField = function mapDataToRadioField(data, field) {
        mapDataToCheckboxField(data, field);
    };

    var mapDataToSelectMultipleField = function mapDataToSelectMultipleField(data, field) {
        if ($.type(data) === 'undefined' || data === null) {
            data = field.defaultValue ? field.defaultValue : '';
        }
        data = $.isArray(data) ? data : [data];
        for (var i = 0; i < field.options.length; i++) {
            field.options[i].selected |= data.indexOf(field.options[i].value) > -1;
        }
        $(field).trigger('change');
    };

    var mapDataToSelectField = function mapDataToSelectField(data, field) {
        if ($.type(data) === 'undefined' || data === null) {
            data = 'core.placeholder';
        }
        field.value = data.toString() || data;
        $(field).trigger('change');
    };

    var mapDataToStaticField = function mapDataToStaticField(data, field) {
        if ($.type(data) === 'undefined' || data === null || data === '') {
            data = 'core.placeholder';
        }
        data = Translator.trans(data);
        $('#' + field).html(data);
    };

    var mapDataToTextField = function mapDataToTextField(data, field) {
        if ($.type(data) === 'undefined' || data === null) {
            field.value = '';
        } else {
            field.value = data;
        }
    };

    var mapDataToField = function mapDataToField(data, field) {

        if (!field) {
            return;
        }

        var type = field.type || field[0].type;

        switch (type) {
            case 'radio':
                mapDataToRadioField(data, field);
                break;
            case 'checkbox':
                mapDataToCheckboxField(data, field);
                break;
            case 'select-multiple':
                mapDataToSelectMultipleField(data, field);
                break;
            case 'select':
            case 'select-one':
                mapDataToSelectField(data, field);
                break;
            case 'date':
                mapDataToDateField(data, field);
                break;
            default:
                mapDataToTextField(data, field);
                break;
        }

    }

    var mapDataToForm = function mapDataToForm(data, form) {

        for (var id in data) {

            if (!data.hasOwnProperty(id)) {
                continue;
            }

            var value = data[id].value;

            if ($.type(value) === "object") {
                mapDataToForm(value, form);
            } else if (data[id].name === 'static') {
                mapDataToStaticField(value, id);
            } else if ($.type(form) !== 'undefined' && $.type(form.elements) !== 'undefined') {
                var field = form.elements.namedItem(id);
                mapDataToField(value, field);
            }

        }
    };

    return {
        mapDataToCheckboxField: mapDataToCheckboxField,
        mapDataToDateField: mapDataToDateField,
        mapDataToRadioField: mapDataToRadioField,
        mapDataToSelectField: mapDataToSelectField,
        mapDataToSelectMultipleField: mapDataToSelectMultipleField,
        mapDataToTextField: mapDataToTextField,
        mapDataToField: mapDataToField,
        mapDataToForm: mapDataToForm,
    };

})();

// Undo fake readonly mode
$('form').submit(function () {
    $('.readonly-select').prop('disabled', false);
    $('.readonly-required').prop('required', true);
});
