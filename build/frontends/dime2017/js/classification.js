$('document').ready(function(){
    
    var query = {"concept":"dime.find.type"};
    
    $.post(path + 'api/internal/vocabulary', JSON.stringify(query) )
    .fail(function() {
        console.log('Error fetching type vocabulary');
    })
    .done(function(response) {
        window.typevocabulary = response.terms;
    });

    var query = {"concept":"dime.find.classification"};

    $.post(path + 'api/internal/vocabulary', JSON.stringify(query) )
    .fail(function() {
        console.log('Error fetching classification vocabulary');
    })
    .done(function(response) {
        window.classificationvocabulary = response.terms;
    });
    
    $('#dime_find_item_dating_year').on('focusout', function(){
        console.log($(this).val());
    });
    
    $('#dime_find_item_dating_year_span').on('focusout', function(){
        console.log($(this).val());
    });
    
    $('#dime_find_item_type_term').on('change', function(){
        console.log($(this).val());
        $('#dime_find_item_classification_class').val($(this).val());
        $('#dime_find_item_classification_class').trigger('change');
    });
    
})