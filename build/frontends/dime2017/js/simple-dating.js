var initSimpleDating = function(){

    var simpledating_id = "simple_dating_input";
    
    var advanceddating_id = "find_dating_period";

    var buildSimpleDatingSelect2 = function(){

        $('#'+simpledating_id).select2({
            minimumResultsForSearch: 11,
            width: 'resolve',
            sorter: function(data) {
                return data.sort(function (a, b) {
                    if (a.val > b.val) {
                        return 1;
                    }
                    if (a.val < b.val) {
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
        if(period.substr(1,3)=="XXX"){
            periodvocabulary[period].optionelement.appendTo('#'+simpledating_id);
        }
    }
    
    buildSimpleDatingSelect2();
    
    var setAdvancedPeriod = function(period){
        try {
            // set the period advanced to this period and trigger a click
            
            console.log(periodvocabulary[period]);

            $('#'+advanceddating_id).val(period);
            return true;
        } catch (e) {
            return false;
        }
    }
    
    $('#'+simpledating_id).on("select2:select select2:unselecting", function(){

        var target = $(this).val();
        
        var previous = $('#'+advanceddating_id).val();
        
        var myRegexp = /([[A-WYZÆ]+)([X]+)\b/g;
        
        if(target == "up"){
            if (previous == null){
                previous = "XXXX";
            }
            var match = myRegexp.exec(previous);
        } else {
            var match = myRegexp.exec(target);
        }
        
        if(match){
            var level = match[1].length;
        } else {
            level = 4;
        }

        var pad = {0:"XXXX",1:"XXX",2:"XX",3:"X"};
        if(target == "up"){
            level = level - 1;
            target = previous.substr(0,level)+pad[level];
        }
        
        var goupoption = $('<option value="up"> ↖</option>');
        $('#'+simpledating_id).empty();
        if(target == "XXXX"||target==null||target==''){
            for (var period in periodvocabulary) {
                if(period.substr(1,3)=="XXX"){
                    periodvocabulary[period].optionelement.appendTo('#'+simpledating_id);
                }
            }
        } else {
            $('#'+simpledating_id).append(goupoption);
            for (var period in periodvocabulary) {
                if( target.substr(0,level) == period.substr(0,level) ) {
                    periodvocabulary[period].optionelement.appendTo('#'+simpledating_id);
                }
            }
        }


        $('#'+simpledating_id).val(target);

        buildSimpleDatingSelect2();

        $('#'+simpledating_id).select2('open');

        setAdvancedPeriod(target);

    });
};
