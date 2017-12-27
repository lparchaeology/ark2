$(document).ready(function () {

    window.type_id = "find_class_term";
    window.subtype_id = "find_classification_subtype";
    window.date_start_id = "find_dating_year";

    // Initially hide the Coin-only fields
    $('#find_mint_content').closest('.form-group').hide();
    $('#find_issuer_content').closest('.form-group').hide();
    $('#find_secondary_term_looped').closest('.checkbox').hide();

    $('#find_classify').attr('data-toggle', 'false');

    var query = { "concept": "dime.find.class" };
    $.post(path + 'api/internal/vocabulary', JSON.stringify(query))
        .fail(function () {
            console.log('Error fetching class vocabulary');
        })
        .done(function (response) {
            window.typevocabulary = response.terms;
            initPeriod();
        });

});
