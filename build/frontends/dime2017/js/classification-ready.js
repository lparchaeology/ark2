$(document).ready(function () {

    $('#find_classify').attr('data-toggle', 'false');

    window.type_id = "find_class_term";

    window.subtype_id = "find_classification_subtype";

    window.date_start_id = "find_dating_year";

    var query = { "concept": "dime.find.class" };
    $.post(path + 'api/internal/vocabulary', JSON.stringify(query))
        .fail(function () {
            console.log('Error fetching class vocabulary');
        })
        .done(function (response) {
            window.typevocabulary = response.terms;

            query = { "concept": "dime.find.subtype", };

            $.post(path + 'api/internal/vocabulary', JSON.stringify(query))
                .fail(function () {
                    console.log('Error fetching subtype vocabulary');
                })
                .done(function (response) {
                    window.subtypevocabulary = response.terms;
                    for (var subtype in subtypevocabulary) {
                        if ($('#' + subtype_id).val() !== subtype) {
                            subtypevocabulary[subtype].optionelement = $('#' + subtype_id + ' option[value="' + subtype + '"]').detach();
                        }
                    }
                    initSubtype();
                    initPeriod();
                });

        });

    // Initially hide the Coin-only fields
    $('#find_mint_content').closest('.form-group').hide();
    $('#find_issuer_content').closest('.form-group').hide();
    $('#find_secondary_term_looped').closest('.checkbox').hide();

    var setSimpleButtons = function () {
        //console.log($('#find_dating_year').val());
        if ($('#find_dating_year').val() < 1067) {
            $('#oldtid-dating-button').addClass('selected');
        } else if ($('#find_dating_year').val() > 1066) {
            $('#historiktid-dating-button').addClass('selected');
        }
    }

    setSimpleButtons();

    $('#find_dating_year').on('change', setSimpleButtons());

});
