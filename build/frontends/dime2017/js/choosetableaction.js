$('document').ready(function () {

    /*
    $.post(path + 'api/internal/schema',window.module )
        .fail(function() {
            console.log('Error fetching ARK schema');
        })
        .done(function(response) {
            var itemSchema = response[itemkey]
            for (item in itemSchema['actions']){
                $('#chooseAction').attr('defaultavailableactions').push({
                    "keyword":itemSchema['actions'][item]['actionKeyword'],
                    "translation":itemSchema['actions'][item]['translation'][lang],
                    "available":true,
                    "visible":true
                });
            }
        });
    */
    /*
        var getavailableActions = function(itemkey, itemvalue){
            $.post(path + 'api/v2/'.itemkey, itemvalue )
            .fail(function() {
                console.log('Error fetching ARK schema');
            })
            .done(function(response) {
                var itemSchema = response[itemkey];
                var response = [];
                for (item in itemSchema['actions']){
                    if (itemSchema['actions'][item] == true ){
                        response.push(itemSchema['actions'][item].clone());
                    }
                }
                return response;
            });
        }
    */
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

});
