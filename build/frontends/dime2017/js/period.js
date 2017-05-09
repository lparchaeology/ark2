$('document').ready(function(){
    
    var query = {"concept":"dime.period"};
    
    $.post(path + 'api/internal/vocabulary', JSON.stringify(query) )
    .fail(function() {
        console.log('Error fetching period vocabulary');
    })
    .done(function(response) {
        window.periodvocabulary = response.terms;
    });
    
    var getPeriodFromYear = function(year){
        
        // Null period covers all potential dates
        var period = {"name":"NULL","parameters":{"year_start":{"value":-Infinity},"year_end":{"value":Infinity}}};
        
        for (var key in periodvocabulary) {
            periodvocabstart = parseInt(periodvocabulary[key].parameters.year_start.value);
            periodvocabend = parseInt(periodvocabulary[key].parameters.year_end.value);
            if ( periodvocabend >= year && year >= periodvocabstart ){
                //lets just get the most precise for now
                if(periodvocabstart >= period.parameters.year_start.value
                   && periodvocabend <= period.parameters.year_end.value){
                    var period = periodvocabulary[key];
                }
            }
        }
        
        return period;
        
    }
    
    $('#dime_find_item_dating_year').on('keyup', function(){
        var year = parseInt(this.value);

        var period = getPeriodFromYear(year);
        
        $('#dime_find_item_dating_period').val(period.name);
        $('#dime_find_item_dating_period').trigger('change.select2');
    });
    
    $('#dime_find_item_dating_year_span').on('keyup', function(){
        var year = parseInt(this.value);

        var period = getPeriodFromYear(year);
        
        $('#dime_find_item_dating_period_span').val(period.name);
        $('#dime_find_item_dating_period_span').trigger('change.select2');
    });
    
    $('#dime_find_item_dating_year').on('focusout', function(){
        var year = parseInt(this.value);
        if (parseInt($('#dime_find_item_dating_year_span').val()) < year){
            var endyear = parseInt($('#dime_find_item_dating_year_span').val());
            $(this).val(endyear);
            $('#dime_find_item_dating_year_span').val(year);
            
            $('#dime_find_item_dating_year_span').trigger('keyup');
            $('#dime_find_item_dating_year').trigger('keyup');
        }
    });
    
    $('#dime_find_item_dating_year_span').on('focusout', function(){
        var year = parseInt(this.value);
        if (parseInt($('#dime_find_item_dating_year').val()) > year){
            var endyear = parseInt($('#dime_find_item_dating_year').val());
            $(this).val(endyear);
            $('#dime_find_item_dating_year').val(year);
            
            $('#dime_find_item_dating_year').trigger('keyup');
            $('#dime_find_item_dating_year_span').trigger('keyup');
        }
    });
    
    $('#dime_find_item_dating_period').on('change', function(){
        period = periodvocabulary[this.value];
        
        if ($('#dime_find_item_dating_year').val() == '') {
            var year = period.parameters.year_start.value;
            
        } else {
            var year = parseInt($('#dime_find_item_dating_year').val());
            if( year < parseInt(period.parameters.year_start.value) || year > parseInt(period.parameters.year_end.value) ){
                year = period.parameters.year_start.value;
            }
            
        }

        $('#dime_find_item_dating_year').val(year);
    });
    
    $('#dime_find_item_dating_period_span').on('change', function(){
        period = periodvocabulary[this.value];
        
        if ($('#dime_find_item_dating_year_span').val() == '') {
            var year = period.parameters.year_end.value;
            
        } else {
            var year = parseInt($('#dime_find_item_dating_year_span').val());
            if( year < parseInt(period.parameters.year_start.value) || year > parseInt(period.parameters.year_end.value) ){
                year = period.parameters.year_end.value;
            }
            
        }

        $('#dime_find_item_dating_year_span').val(year);
    });
    
})