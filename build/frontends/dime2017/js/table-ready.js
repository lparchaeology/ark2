$('document').ready(function () {

    /* Currently unused, probably obsolete
    var getAvailableActions = function (itemkey, itemvalue) {
        return JSON.parse(JSON.stringify(window.itemAvailableActions[itemvalue]));
    };

    var generateDropdownItem = function (action) {
        var disabled = '';
        var dropdownElement = '';
        if (action.visible) {
            disabled = action.available ? '' : 'disabled="true" class="disabled"';
            dropdownElement = $('<li ' + disabled + ' value="' + action.keyword + '">' + action.translation + '</li>');
            return dropdownElement;
        }
    };

    $('#chooseAction').click(function () {
        $('#chooseActionSelectHolder').empty();
        $('tr.selected').each(function (i, e, a) {
            window.availableActions = JSON.parse(JSON.stringify(window.defaultAvailableActions));
            var itemActions = getAvailableActions(window.itemkey, $(e).attr('data-unique-id'));
            for (var action in window.availableActions) {
                if (itemActions.hasOwnProperty(window.availableActions[action].keyword)) {
                    window.availableActions[action].visible = true;
                }
                if (itemActions.hasOwnProperty(window.availableActions[action].keyword) === false) {
                    window.availableActions[action].available = false;
                }
            }
        });
        var dropdown = $('<ul class="action-select">');
        for (var action in window.availableActions) {
            dropdown.append(generateDropdownItem(window.availableActions[action]));
        }
        $('#chooseActionSelectHolder').append(dropdown);
    });
    */

});
