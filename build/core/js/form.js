var FormMapper = (function () {

    var translate = function translate(value) {
        var trans = Translator.trans(value);
        if (trans === value) {
            trans = Translator.trans(value + '.default');
            if (trans === value + '.default') {
                trans = value;
            }
        }
        return trans;
    };

    var mapDataToCheckboxField = function mapDataToCheckboxField(data, field) {
        if (data.value === field.value) {
            field.checked = true;
        } else {
            field.checked = field.defaultChecked;
        }
    };

    var mapDataToDateField = function mapDataToDateField(data, field) {
        var value = data.value;
        if ($.type(value) === 'undefined' || value === null) {
            value = field.defaultValue ? field.defaultValue : '';
        }
        field.value = new Date(value).toISOString().split('T')[0];
    };

    var mapDataToRadioField = function mapDataToRadioField(data, field) {
        mapDataToCheckboxField(data, field);
    };

    var clearSelectOptions = function clearSelectOptions(select) {
        while (select.options.length > 0) {
            select.remove(0);
        }
    };

    var addSelectOption = function addSelectOption(select, value, text, selected) {
        var option = document.createElement("option");
        option.value = value;
        if (selected) {
            option.selected = true;
            option.defaultSelected = true;
        }
        option.text = translate(text);
        select.add(option, null);
    }

    var setSelectOptions = function setSelectOptions(select, options) {
        clearSelectOptions(select);
        addSelectOption(select, '', 'core.placeholder', true);
        Object.keys(options).forEach(function (key) {
            addSelectOption(select, options[key].value, options[key].label, false);
        });
    };

    var mapDataToSelectMultipleField = function mapDataToSelectMultipleField(data, select) {
        if (data.hasOwnProperty('options')) {
            setSelectOptions(select, data.options);
        }
        var value = data.value;
        if ($.type(value) === 'undefined' || value === null) {
            value = select.defaultValue ? select.defaultValue : '';
        }
        value = $.isArray(value) ? data : [value];
        for (var i = 0; i < select.options.length; i++) {
            select.options[i].selected |= value.indexOf(select.options[i].value) > -1;
        }
        $(select).trigger('change');
    };

    var mapDataToSelectField = function mapDataToSelectField(data, select) {
        if (data.hasOwnProperty('options')) {
            setSelectOptions(select, data.options);
        }
        var value = data.value;
        if ($.type(value) === 'undefined' || value === null) {
            select.value = '';
        } else {
            select.value = value.toString();
        }
        $(select).trigger('change');
    };

    var mapDataToStaticField = function mapDataToStaticField(data, id) {
        var value = data.value;
        if ($.type(value) === 'undefined' || value === null || value === '') {
            value = 'core.placeholder';
        }
        $('#' + id).html(translate(value));
    };

    var mapDataToTextField = function mapDataToTextField(data, field) {
        var value = data.value;
        if ($.type(value) === 'undefined' || value === null) {
            value = '';
        }
        field.value = translate(value);
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

    };

    var mapDataToForm = function mapDataToForm(data, form) {

        for (var id in data) {

            if (!data.hasOwnProperty(id)) {
                continue;
            }

            var element = data[id];

            if ($.type(element.value) === "object") {
                mapDataToForm(element.value, form);
            } else if (element.name === 'static') {
                mapDataToStaticField(element, id);
            } else if ($.type(form) !== 'undefined' && $.type(form.elements) !== 'undefined') {
                var field = form.elements.namedItem(id);
                mapDataToField(element, field);
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
