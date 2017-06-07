$('document').ready(function(){


    var date_start_id = "find_dating_year";

    var date_start_period_id = 'find_dating_period';

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

    var periodMouseEnter = function(item) {
        var highlighted_item_id = item.attr('id');
        var highlighted_item_code = highlighted_item_id.split('-');
        var highlighted_item_concept = highlighted_item_code[highlighted_item_code.length-1];

        if( typeof periodvocabulary[highlighted_item_concept].parameters == undefined ){
            var tooltip = "undefined";
        } else{
            var tooltip = periodvocabulary[highlighted_item_concept].parameters.year_start.value+"\xa0\u2014\xa0"+periodvocabulary[highlighted_item_concept].parameters.year_end.value;
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

    $('body').on({
        mouseenter: function () {
            periodMouseEnter($(this));
       }
    }, '#select2-'+date_start_period_id+'-results .select2-results__option.select2-results__option--highlighted');

    $('body').on({
        mouseenter: function () {
            periodMouseEnter($(this));
       }
    }, '#select2-'+date_start_period_id+'_span-results .select2-results__option.select2-results__option--highlighted');

    $('#'+date_start_id).on('keyup', function(){
        var year = parseInt(this.value);

        if(year<this.min){
            this.value = this.min;
            year = parseInt(this.value);
        }

        var period = getPeriodFromYear(year);

        $('#'+date_start_period_id).val(period.name);
        $('#'+date_start_period_id).trigger('change.select2');
    });

    $('#'+date_start_id+'_span').on('keyup', function(){
        var year = parseInt(this.value);

        if( this.max != '' && year>this.max){
            this.value = this.max;
            year = parseInt(this.value);
        }

        var period = getPeriodFromYear(year);

        $('#'+date_start_period_id+'_span').val(period.name);
        $('#'+date_start_period_id+'_span').trigger('change.select2');
    });

    $('#'+date_start_id).on('focusout', function(){
        var year = parseInt(this.value);
        var span_year = parseInt($('#'+date_start_id+'_span').val());
        if(isNaN(year) || isNaN(span_year)){
            return true;
        }
        if ( span_year < year){
            var endyear = span_year;
            $(this).val(endyear);
            $('#'+date_start_id+'_span').val(year);

            $('#'+date_start_id+'_span').trigger('keyup');
            $('#'+date_start_id).trigger('keyup');
        }
    });

    $('#'+date_start_id+'_span').on('focusout', function(){
        var year = parseInt(this.value);
        if(isNaN(year) || isNaN(parseInt($('#'+date_start_id).val()))){
            return true;
        }
        if (parseInt($('#'+date_start_id).val()) > year){
            var endyear = parseInt($('#'+date_start_id).val());
            $(this).val(endyear);
            $('#'+date_start_id).val(year);

            $('#'+date_start_id).trigger('keyup');
            $('#'+date_start_id+'_span').trigger('keyup');
        }
    });

    $('#'+date_start_period_id).on('change', function(){
        period = periodvocabulary[this.value];

        if ($('#'+date_start_id).val() == '') {
            var year = period.parameters.year_start.value;

        } else {
            var year = parseInt($('#'+date_start_id).val());
            if( year < parseInt(period.parameters.year_start.value) || year > parseInt(period.parameters.year_end.value) ){
                year = period.parameters.year_start.value;
            }

        }

        $('#'+date_start_id).val(year);
        $('#'+date_start_id).trigger('focusout');
    });

    $('#'+date_start_period_id+'_span').on('change', function(){
        period = periodvocabulary[this.value];

        if ($('#'+date_start_id+'_span').val() == '') {
            var year = period.parameters.year_end.value;

        } else {
            var year = parseInt($('#'+date_start_id+'_span').val());
            if( year < parseInt(period.parameters.year_start.value) || year > parseInt(period.parameters.year_end.value) ){
                year = period.parameters.year_end.value;
            }

        }

        $('#'+date_start_id+'_span').val(year);

        $('#'+date_start_id+'_span').trigger('focusout');

    });

})
