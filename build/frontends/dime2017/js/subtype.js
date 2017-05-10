$('document').ready(function(){
    
    var query = {"concept":"dime.find.type"};
    
    $.post(path + 'api/internal/vocabulary', JSON.stringify(query) )
    .fail(function() {
        console.log('Error fetching type vocabulary');
    })
    .done(function(response) {
        window.typevocabulary = response.terms;
    });

    var query = {"concept":"dime.find.subtype"};

    $.post(path + 'api/internal/vocabulary', JSON.stringify(query) )
    .fail(function() {
        console.log('Error fetching subtype vocabulary');
    })
    .done(function(response) {
        window.subtypevocabulary = response.terms;
        for (var subtype in subtypevocabulary) {
            subtypevocabulary[subtype].optionelement = $('#dime_find_item_classification_subtype option[value="'+subtype+'"]').detach();
        }
        $('#dime_find_item_classification_subtype').select2({
            minimumResultsForSearch: 11,
            width: 'resolve'
        });
        $('#dime_find_item_type_term').trigger('change');
    });
    
    $('#dime_find_item_dating_year').on('focusout', function(){
        console.log($(this).val());
    });
    
    $('#dime_find_item_dating_year_span').on('focusout', function(){
        console.log($(this).val());
    });
    
    $('#dime_find_item_type_term').on('change', function(){

        var target = $(this).val();
        console.log(target);
        $('#dime_find_item_classification_subtype').empty();
        for (var subtype in subtypevocabulary) {
            if( target == subtype.split('.')[0] && subtype.split('.').length == 2 ){
                subtypevocabulary[subtype].optionelement.appendTo('#dime_find_item_classification_subtype');
            }
        }

        $('#dime_find_item_classification_subtype').select2({
            minimumResultsForSearch: 11,
            width: 'resolve',
            sorter: function(data) {
                return data.sort(function (a, b) {
                    if (a.text > b.text) {
                        return 1;
                    }
                    if (a.text < b.text) {
                        return -1;
                    }
                    return 0;
                });
            }
        });
    });
    
    $('#dime_find_item_classification_subtype').on('change', function(){

        var target = $(this).val();
        console.log(target);
        
        if(target == "up"){
            $('#dime_find_item_type_term').trigger('change');
            $('#dime_find_item_classification_subtype').select2('open');
            return true;
        }
        
        var goupoption = $('<option value="up"> ↖</option>');
        if(target.split('.').length < 3 ){
            $('#dime_find_item_classification_subtype').empty();
            $('#dime_find_item_classification_subtype').append(goupoption);
            for (var subtype in subtypevocabulary) {
                if( target.split('.')[0] == subtype.split('.')[0] && target.split('.')[1] == subtype.split('.')[1]) {
                    subtypevocabulary[subtype].optionelement.appendTo('#dime_find_item_classification_subtype');
                }
            }
            
            $('#dime_find_item_classification_subtype').val(target);
            
            $('#dime_find_item_classification_subtype').select2({
                minimumResultsForSearch: 11,
                width: 'resolve',
                sorter: function(data) {
                    return data.sort(function (a, b) {
                        if (a.text > b.text) {
                            return 1;
                        }
                        if (a.text < b.text) {
                            return -1;
                        }
                        return 0;
                    });
                }
            });
            
            $('#dime_find_item_classification_subtype').select2('open');
        }
        
        var current_start_year = parseInt($('#dime_find_item_dating_year').val())
        var target_start_year = parseInt(subtypevocabulary[target].parameters.year_start.value);

        var current_end_year = parseInt($('#dime_find_item_dating_year_span').val())
        var target_end_year = parseInt(subtypevocabulary[target].parameters.year_end.value);
        
        console.log([target,"target",target_start_year,target_end_year,"current", current_start_year, current_end_year]);
        
        if ( isNaN(current_start_year) || current_start_year < target_start_year || current_start_year > target_end_year ){
            console.log('changeing start');
            $('#dime_find_item_dating_year').val(target_start_year);
        }
        
        if ( isNaN(current_end_year) || current_end_year > target_end_year || current_end_year < target_start_year ){
            console.log('changeing end');
            $('#dime_find_item_dating_year_span').val(target_end_year);
        }

        $('#dime_find_item_dating_year').attr({
            "min" : target_start_year
         });
        
        $('#dime_find_item_dating_year_span').attr({
            "max" : target_end_year
        });

        $('#dime_find_item_dating_year').trigger('keyup');
        $('#dime_find_item_dating_year_span').trigger('keyup');
        
    });
    
})