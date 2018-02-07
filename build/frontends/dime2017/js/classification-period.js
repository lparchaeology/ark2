var initPeriod = function () {

    var query = { "concept": "dime.period" };

    $.post(path + 'api/internal/vocabulary', JSON.stringify(query))
        .fail(function () {
            console.log('Error fetching period vocabulary');
        })
        .done(function (response) {
            window.periodvocabulary = response.terms;
            // this function relies on the periodvocabulary response
            window.getPeriodFromYear = function (year) {
                periodvocabulary = window.periodvocabulary;
                // Null period covers all potential dates
                var period = { "name": "NULL", "parameters": { "year_start": { "value": -Infinity }, "year_end": { "value": Infinity } } };
                for (var key in periodvocabulary) {
                    try {
                        periodvocabstart = parseInt(periodvocabulary[key].parameters.year_start.value);
                    } catch (e) {
                        periodvocabstart = null;
                    }
                    try {
                        periodvocabend = parseInt(periodvocabulary[key].parameters.year_end.value);
                    } catch (e) {
                      // If a period doesn't have a defined end, it must end now
                        periodvocabend = new Date().getFullYear();
                        periodvocabulary[key].parameters.year_end = { "type": "integer", "value": new Date().getFullYear().toString() };
                    }
                    if (periodvocabend >= year && year >= periodvocabstart) {
                        //lets just get the most precise for now
                        if (periodvocabstart >= period.parameters.year_start.value
                            && periodvocabend <= period.parameters.year_end.value) {
                            var period = periodvocabulary[key];
                        }
                    }
                }
                return period;
            }

            if( $('#find_classify').length==1 && $('#modal_mapbtn').length==0 ){
                initTimeline();
            }
        });

}
