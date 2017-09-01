var initSimpleDating = function(){

    var simpledating_id = "simple_dating_input";
    
    var advanceddating_id = "find_dating_period";

    var buildSimpleDatingSelect2 = function(){

        $('#'+simpledating_id).select2({
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
                periodMouseEnter($(this));
           }
        }, '#select2-'+simpledating_id+'_span-results .select2-results__option.select2-results__option--highlighted');

    };
    
    for (var period in window.periodvocabulary) {
        periodvocabulary[period].optionelement = $('#'+advanceddating_id+' option[value="'+period+'"]').clone();
        console.log(period);
        periodvocabulary[period].optionelement.appendTo('#'+simpledating_id);
    }
    
    $('#'+simpledating_id).on("select2:select select2:unselecting", function(){

        var target = $(this).val();
        console.log(target);

        if(target == "up"){
            $('#'+simpledating_id).select2('open');
            return true;
        }

        var goupoption = $('<option value="up"> ↖</option>');
        if(target.split('.').length < 3 ){
            //$('#'+simpledating_id).empty();
            //$('#'+simpledating_id).append(goupoption);
            for (var period in periodvocabulary) {
                if( target.split('.')[0] == period.split('.')[0] && target.split('.')[1] == period.split('.')[1]) {
                    periodvocabulary[period].optionelement.appendTo('#'+simpledating_id);
                }
            }

            $('#'+simpledating_id).val(target);

            buildSimpleDatingSelect2();

            $('#'+simpledating_id).select2('open');
        }


        try {
            // set the period advanced to this period and trigger a click
            
            console.log(periodvocabulary[this.val()]);
            
            $('#find_dating_year').val(new Date(start).getFullYear(),'Y');
            $('#find_dating_year').trigger('keyup');
            $('#find_dating_year_span').val(new Date(end).getFullYear().endOf('year'),'Y');
            $('#find_dating_year_span').trigger('keyup');
            
            
        } catch (e) {
        }

    });
};
