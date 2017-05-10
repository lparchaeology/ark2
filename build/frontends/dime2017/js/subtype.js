$('document').ready(function(){
    
    var query = {"concept":"dime.find.type"};
    
    var buildSubtypeSelect2 = function(){

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
            },
        });
        
        $('body').on({
            mouseenter: function () {
                var item = $(this);
                var highlighted_item_id = item.attr('id');
                var highlighted_item_code = highlighted_item_id.split('-');
                var highlighted_item_concept = highlighted_item_code[highlighted_item_code.length-1];
                
                if( typeof subtypevocabulary[highlighted_item_concept].parameters == undefined ){
                    var tooltip = "undefined";
                } else {
                    var tooltip = subtypevocabulary[highlighted_item_concept].parameters.year_start.value+"\xa0\u2014\xa0"+subtypevocabulary[highlighted_item_concept].parameters.year_end.value;
                }
                
               
                var promise = new Promise(function(resolve) {
                    item.attr({"data-toggle":"tooltip","data-placement":"right","title":tooltip});
                    item.tooltip();
                    resolve(true);
                  });
                promise.then(function(result) {
                    item.tooltip('show');
                });
           }
        }, '#select2-dime_find_item_classification_subtype-results .select2-results__option.select2-results__option--highlighted');
        
    }
    
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
        buildSubtypeSelect2();
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

        buildSubtypeSelect2();
        
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
            
            buildSubtypeSelect2();
            
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