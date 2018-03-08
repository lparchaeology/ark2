var createRegisterOptions = function createRegisterOptions() {

    var classSorter = function classSorter(data) {
        return data.sort(function (a, b) {
            if (a.text > b.text) {
                return 1;
            }
            if (a.text < b.text) {
                return -1;
            }
            return 0;
        });
    };

    // Options for the dropdowns
    var select2Options = {
        sorter: classSorter,
    };

    // clear out the classification holder
    $(".classification-register-holder").empty();

    // set the new width, and set the value to match the dropdown on the main page
    $('#find_class_term_modal').attr('style', 'width:100%');
    $('#find_class_term_modal').val($('#find_class_term').val());

    // launch it as a select2
    $('#find_class_term_modal').select2(select2Options);
    $('#find_class_term_modal').prop('disabled', false);
    $('#find_class_term_modal').prop('required', false);

    var createTimelineSelect = function (name, markup) {
        // attach and launch two empty subtype levels with hacked in labels
        var selectDiv = $("<div class=\"col-xs-12 col-sm-12 col-md-4\">");
        //selectDiv.append($('<label>' + markup + '</label>'));
        var selectSelect = $('<select id="find_subtype_' + name + '" style="width:100%">');
        selectDiv.append(selectSelect);
        $(".classification-register-holder").append(selectDiv);
        selectSelect.select2(select2Options);

        return selectSelect

    }

    var level1 = createTimelineSelect("level1");
    var level2 = createTimelineSelect("level2");
    level1.parent().hide();
    level2.parent().hide();

    // behaviour for selecting a class
    $('#find_class_term').on("select2:select select2:unselecting", function () {
        var target = $(this).val();
        var level1Default = null;
        level1.empty();
        level1.parent().hide();
        level2.empty();
        level2.parent().hide();

        var subtypevocabulary = window.typevocabulary[target].taxonomy;

        for (var term in subtypevocabulary) {
            var subtype = subtypevocabulary[term].name;
            $('#' + window.subtype_id + ' option[value="' + subtype + '"]').clone().appendTo('#find_subtype_level1');
            if (subtypevocabulary[term]['default']) {
                level1Default = subtype;
            }
        }

        console.log(Object.keys(subtypevocabulary).length);

        if(Object.keys(subtypevocabulary).length > 0){
          level1.parent().show();
        }

        // # init the level1 classification as unknowwn
        level1.val(level1Default);
        level1.select2(select2Options);
        level1.trigger('select2:select');

    });

    // Change the level2 Klassification if the Klassification1 changes
    level1.on("select2:select select2:unselecting", function () {
        var parentclass = $('#' + window.type_id).val();
        var target = $(this).val();
        level2.empty();
        level2.parent().hide();

        var parenttaxonomy = window.typevocabulary[parentclass].taxonomy;
        var level1klassification = parenttaxonomy[target];
        var level2Default = null;

        if (typeof level1klassification !== 'undefined') {
            for (var descendent in level1klassification.taxonomy) {
                var level2option = level1klassification.taxonomy[descendent];
                $('#' + window.subtype_id + ' option[value="' + level2option.name + '"]').clone().appendTo(level2);
                if (level2option['default']) {
                    level2Default = level2option.name;
                }
            }
            $('#' + window.subtype_id).val(level1klassification.name);
        }

        $('#' + window.subtype_id).select2(select2Options);
        $('#' + window.subtype_id).trigger('select2:select');

        if( Object.keys(level1klassification.taxonomy).length > 0 ){
          level2.parent().show();
        }

        level2.val(level2Default);
        level2.select2(select2Options);
    });

    // update the timeline if the Klassification2 changes
    level2.on("select2:select select2:unselecting", function () {
        var target = $(this).val();
        var parentclass = $('#' + window.type_id).val();
        var parentsubclass = $('#find_subtype_level1').val();
        var parenttaxonomy = window.typevocabulary[parentclass].taxonomy[parentsubclass].taxonomy;
        console.log(parenttaxonomy[target]);
        $('#' + window.subtype_id).val(parenttaxonomy[target].name);
        $('#' + window.subtype_id).select2(select2Options);
        $('#' + window.subtype_id).trigger('select2:select');
    });

    var parentclass = $('#find_class_term').val();

    if(parentclass != 'unassessed'){
      // set the initial values and set it up
      var subtypevocabulary = window.typevocabulary[parentclass].taxonomy;
    }

    for (var term in subtypevocabulary) {
        var subtype = subtypevocabulary[term].name;
        $('#' + window.subtype_id + ' option[value="' + subtype + '"]').clone().appendTo(level1);
    }

    var currentSubtype = $('#' + window.subtype_id).val();

    //walk the tree to find our subtype level
    var subtypeaddress = false;
    console.log("about to walk looking for " + currentSubtype);
    if (currentSubtype !== '') {
        for (var potentialsubclass in window.typevocabulary[parentclass].taxonomy) {
            if (currentSubtype === potentialsubclass) {
                level1.val(potentialsubclass);
                level1.select2(select2Options);
                level1.trigger('select2:select');
                subtypeaddress = true;
                break;
            }
            for (var potentialsubsubclass in window.typevocabulary[parentclass].taxonomy[potentialsubclass].taxonomy) {
                if (currentSubtype === potentialsubsubclass) {
                    console.log("it is " + potentialsubsubclass + " at level 2");
                    level1.val(potentialsubclass);
                    level1.select2(select2Options);
                    level1.trigger('select2:select');
                    subtypeaddress = true;
                    level2.val(potentialsubsubclass);
                    level2.select2(select2Options);
                    level2.trigger('select2:select');
                    break;
                }
            }
            if (subtypeaddress) {
                break;
            }
        }
    }
}; // createOptions()
