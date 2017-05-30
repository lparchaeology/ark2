$('document').ready(function(){
    
    $.post(path + 'api/internal/schema',itemkey )
        .fail(function() {
            console.log('Error fetching ARK schema');
        })
        .done(function(response) {
            var itemSchema = response[itemkey]
            for (item in itemSchema['actions']){
                $('#chooseAction').attr('defaultavaliableactions').push({
                    "keyword":itemSchema['actions'][item]['actionKeyword'],
                    "translation":itemSchema['actions'][item]['translation'][lang],
                    "avaliable":true,
                    "visible":true
                });
            }
        });
    
    var getAvaliableActions = function(itemkey, itemvalue){
        $.post(path + 'api/internal/'.itemkey, itemvalue )
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
    
    var generateDropdownItem = function(action){
        if (action.visible){
            action.avaiable ? disabled = '' :  disabled = 'disabled="true"';
            var dropdown = $('<option '+disabled+' value="'action.keyword.'">'.action.translation.'</li');
        }
    }
    
    $('#chooseAction').click(function(){
        var availableActions = $('#chooseAction').attr('defaultavaliableactions').clone();
        $('tr.selected').each(function(i,e,a){
            var itemAvaliableActions = getAvaliableActions(e);
            for( action in avaliableActions){
                if ( itemAvaliableActions.indexOf(avaliableActions[action].keyword) < 0 ){
                    availableActions[action]['avaliable'] = false;
                }
            }
        });
        
        var dropdown = $('<select class="action-select">');
        for(action in availableActions){
            dropdown.append(generateDropdownItem(availableActions[action]));
        }
        $('#chooseAction').append(dropdown);
        dropdown.select2('open');
    })
    
    
})