$('document').ready(function(){

    var query = {"concept":"dime.find.type"};

    var type_id = "find_type_term";

    var subtype_id = "find_classification_subtype";

    var date_start_id = "find_dating_year";

    var buildSubtypeSelect2 = function(){

        $('#'+subtype_id).select2({
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
        }, '#select2-'+subtype_id+'-results .select2-results__option.select2-results__option--highlighted');

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
            subtypevocabulary[subtype].optionelement = $('#'+subtype_id+' option[value="'+subtype+'"]').detach();
        }
        buildSubtypeSelect2();
        $('#'+date_start_id).trigger('change');
    });

    $('#'+date_start_id).on('focusout', function(){
        console.log($(this).val());
    });

    $('#'+date_start_id+'_span').on('focusout', function(){
        console.log($(this).val());
    });

    $('#'+date_start_id).on('change', function(){

        var target = $(this).val();
        console.log(target);
        $('#'+subtype_id).empty();
        for (var subtype in subtypevocabulary) {
            if( target == subtype.split('.')[0] && subtype.split('.').length == 2 ){
                subtypevocabulary[subtype].optionelement.appendTo('#'+subtype_id);
            }
        }

        buildSubtypeSelect2();

    });

    $('#'+subtype_id).on('change', function(){

        var target = $(this).val();
        console.log(target);

        if(target == "up"){
            $('#'+date_start_id).trigger('change');
            $('#'+subtype_id).select2('open');
            return true;
        }

        var goupoption = $('<option value="up"> ↖</option>');
        if(target.split('.').length < 3 ){
            $('#'+subtype_id).empty();
            $('#'+subtype_id).append(goupoption);
            for (var subtype in subtypevocabulary) {
                if( target.split('.')[0] == subtype.split('.')[0] && target.split('.')[1] == subtype.split('.')[1]) {
                    subtypevocabulary[subtype].optionelement.appendTo('#'+subtype_id);
                }
            }

            $('#'+subtype_id).val(target);

            buildSubtypeSelect2();

            $('#'+subtype_id).select2('open');
        }

        var current_start_year = parseInt($('#'+date_start_id).val())
        var target_start_year = parseInt(subtypevocabulary[target].parameters.year_start.value);

        var current_end_year = parseInt($('#'+date_start_id+'_span').val())
        var target_end_year = parseInt(subtypevocabulary[target].parameters.year_end.value);

        console.log([target,"target",target_start_year,target_end_year,"current", current_start_year, current_end_year]);

        if ( isNaN(current_start_year) || current_start_year < target_start_year || current_start_year > target_end_year ){
            console.log('changeing start');
            $('#'+date_start_id).val(target_start_year);
        }

        if ( isNaN(current_end_year) || current_end_year > target_end_year || current_end_year < target_start_year ){
            console.log('changeing end');
            $('#'+date_start_id+'_span').val(target_end_year);
        }

        $('#'+date_start_id).attr({
            "min" : target_start_year
         });

        $('#'+date_start_id+'_span').attr({
            "max" : target_end_year
        });

        $('#'+date_start_id).trigger('keyup');
        $('#'+date_start_id+'_span').trigger('keyup');

    });

})
