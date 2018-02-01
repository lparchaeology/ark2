var initTimeline = function () {

    // DOM element where the Timeline will be attached
    var container = document.getElementById('visualization');

    var getCustomYear = function getCustomYear(timeline, timeid) {
        return new Date(timeline.getCustomTime(timeid)).getFullYear();
    };

    var makeMoment = function makeMoment(year) {
        return vis.moment(year, 'Y');
    };

    var getYearsFromTarget = function getYearsFromTarget(target) {
        var target_years = { "start": null, "end": null };

        if (target.parameters.hasOwnProperty("period")) {
            try {
              target_years.start = window.periodvocabulary[target.parameters.period.value].parameters.year_start.value;
            } catch (TypeError){}
            try {
              target_years.end = window.periodvocabulary[target.parameters.period.value].parameters.year_end.value;
            } catch (TypeError){}
            console.log(target_years);
        }
        // if there is no period there are no dates, so return the whole span of default time
        return target_years;
    };

    var currentYear = new Date().getFullYear();
    // Min year is 250,000BC- the beginning of archaeology ;-)
    var minYear = -250000;
    // Max year is Current Year, unless you have a flux capacitor handy!
    var maxYear = currentYear;

    var millisPerYear = 31536000000;

    // sort alphabetically by translation
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

    container.customTimeExists = function customTimeExists(timeid) {
        var promise = new Promise(function (resolve) {
            window.setTimeout(function () {
                if ($(".vis-custom-time").filter("." + timeid).length !== 1) {
                    container.customTimeExists(timeid);
                } else {
                    resolve();
                }
            }, 100);
        });
        return promise;
    }; // customTimeExists()

    container.drawLabel = function drawLabel(timeid, timeline) {

        var span = $("#" + timeid + "-label");

        if (span.length === 0) {
            var labelinput = $("<input id=\"" + timeid + "-input\" class=\"timelinelabelinput\">");
            labelinput.val(getCustomYear(timeline, timeid));
            labelinput.on("keyup", function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    labelinput.blur();
                }
            });
            labelinput.on("blur", function () {
                timeid = $(this).attr('id').split('-')[0];
                if (timeid === 'start' ){
                  var year = getCustomYear(timeline, 'end');
                  console.log($(this).val());
                  console.log(year);
                  console.log('timeid==start');
                  if ($(this).val() > year){
                    container.makeCustomTime($(this).val(), 'end', timeline);
                    container.makeCustomTime(year, 'start', timeline);
                  } else {
                    container.makeCustomTime($(this).val(), timeid, timeline);
                  }
                } else {
                  var year = getCustomYear(timeline, 'end');
                  if ($(this).val() < year){
                  container.makeCustomTime($(this).val(), 'start', timeline);
                    container.makeCustomTime(year, 'end', timeline);
                  } else {
                    container.makeCustomTime($(this).val(), timeid, timeline);
                  }

                }
            });
            var labelform = $("<form onsubmit=\"return false;\">");
            labelform.append(labelinput);
            span = $("<span id=\"" + timeid + "-label\" class=\"timelinelabel\">");
            span.append(labelform);
            span.css("position", "absolute");
            span.css("margin-top", "-45px");
            span.css("z-index", 3);
            labelinput.css("width", "50px");
            labelinput.css("border-radius", "10px");
            labelinput.css("text-align", "center");
            $("#visualization").append(span);
        } else {
            $("#" + timeid + "-input").val(getCustomYear(timeline, timeid));
        }


        container.customTimeExists(timeid).then(function () {
            var timeid = "start";
            var year = getCustomYear(timeline, timeid);
            var leftNumber = parseInt($(".vis-custom-time." + timeid).css("left"), 10);
            $("#" + timeid + "-label").css("left", leftNumber.toString() + "px");
            $('#' + window.date_start_id).val(year);

            timeid = "end";
            year = getCustomYear(timeline, timeid);
            leftNumber = parseInt($(".vis-custom-time." + timeid).css("left"), 10);
            $("#" + timeid + "-label").css("left", leftNumber.toString() + "px");
            $('#' + window.date_start_id + "_span").val(year);
        });

        var year = getCustomYear(timeline, timeid);
        var period = window.getPeriodFromYear(year);
        if (timeid === 'start') {
            $('#' + window.date_start_period_id).val(period.name);
            $('#' + window.date_start_period_id).select2(select2Options);
        }
        if (timeid === 'end') {
            $('#' + window.date_start_period_id + '_span').val(period.name);
            $('#' + window.date_start_period_id + '_span').select2(select2Options);
        }

    }; // drawLabel()

    container.makeCustomTime = function makeCustomTime(time, name, timeline) {

        if(time>new Date()){
          time=new Date();
        }
        try {
            timeline.setCustomTime(makeMoment(time), name);
        } catch (e) {
            timeline.addCustomTime(makeMoment(time), name);
        }
        container.drawLabel(name, timeline);
    }; // makeCustomTime()

    //this adds start and end lines to the timeline
    container.updateTimelineToPeriod = function updateTimelineToPeriod(target, timeline) {
        try {
            timeline.removeCustomTime('start');
            timeline.removeCustomTime('end');
            $("#start-label").remove();
            $("#end-label").remove();
            $('#' + window.date_start_id).val('');
            $('#' + window.date_start_id + '_span').val('');
            $('#' + window.date_start_period_id).val('-');
            $('#' + window.date_start_period_id + '_span').val('-');

            $('#' + window.date_start_period_id).select2(select2Options);
            $('#' + window.date_start_period_id + '_span').select2(select2Options);

        } catch (e) {}

        if (typeof target !== 'undefined' && target !== null) {
            if (typeof target.parameters !== 'undefined') {
                var target_years = getYearsFromTarget(target);
                if ($.isNumeric(parseInt(target_years.start)) && $.isNumeric(parseInt(target_years.end))) {
                    var start = makeMoment(parseInt(target_years.start));
                    var end = makeMoment(parseInt(target_years.end));
                    if (start) {
                        container.makeCustomTime(start, 'start', timeline);
                    }
                    if (end) {
                        container.makeCustomTime(end, 'end', timeline);
                    }
                }
            }
        }

    };

    //Create a DataSet (allows two way data-binding)
    var items = new vis.DataSet();

    // window.periodvocabulary contains the apiresponse for all the periods
    // this script is initiated on the response from that
    for (var period_id in window.periodvocabulary) {
        var period = window.periodvocabulary[period_id];
        var startYear;
        var endYear;

        // get the end year
        try {
            if (isNaN(period.parameters.year_end.value)) {
                throw 'year end is NaN';
            }
            endYear = Math.min(period.parameters.year_end.value, maxYear);
        } catch (e) {
            endYear = maxYear;
        }

        // get the start year
        try {
            if (isNaN(period.parameters.year_start.value)) {
                throw 'year start is NaN';
            }
            startYear = Math.max(period.parameters.year_start.value, minYear);
        } catch (e) {
            startYear = minYear;
        }

        //items is our vis dataset - load it up with period objects
        items.add({
            id: period_id,
            // the content we get from the dropdown menu - so it is translated and marked up how we want it
            content: $("#find_dating_period").find("option[value=" + period.name + "]").html(),
            start: makeMoment(startYear),
            end: makeMoment(endYear).endOf("year"),
        });
    }

    // order by length - so longer periods go at the top
    function customOrder(a, b) {
        a.length = a.start - a.end;
        b.length = b.start - b.end;
        return b.length - a.length;
    }

    // Configuration for the Timeline
    var options = {
        order: customOrder,
        editable: false,
        margin: {
            axis: 0,
            item: {
                horizontal: -5,
                vertical: 1,
            },
        },
        zoomMin: 5 * millisPerYear, // 5 years in milliseconds
        zoomMax: 50000 * millisPerYear, // 10000 years in milliseconds
        showCurrentTime: false,
        horizontalScroll: true,
        zoomKey: 'ctrlKey',
        end: makeMoment(currentYear),
        start: makeMoment(-2000),
    };

    // Create a Timeline
    var timeline = new vis.Timeline(container, items, options);

    // this will hide pills which are either too small or too large to be comfortably shown
    $('.vis-range').each(function (i, e) {
        if ($(e).width() < 100 || $(e).width() > 5000) {
            $(e).hide();
        } else {
            $(e).show();
        }
    });

    // now that we have that all set up make the find classify trigger a modal
    $('#find_classify').attr('data-toggle', 'modal');

    $('#find_classify').removeClass("disabled").addClass("btn-default");
    // Make sure required-but-readonly Class field is populated
    $('#find').submit(function (e) {
        if ($('#find_class_term').val() === '' || $('#find_class_term').val() === undefined) {
            e.preventDefault();
            $('.readonly-select').prop('disabled', true);
            $('#find_classify').click();
        }
    });

    timeline.on("rangechange", function () {
        container.customTimeExists('start').then(function () {
            container.drawLabel('start', timeline);
        });
        container.customTimeExists('end').then(function () {
            container.drawLabel('end', timeline);
        });
    });

    timeline.on('timechanged', function (properties) {
        if (properties.id === 'start') {
            if (properties.time > timeline.getCustomTime('end')) {
                container.makeCustomTime(timeline.getCustomTime('end'), 'start', timeline);
            }
        } else {
            if (properties.time < timeline.getCustomTime('start')) {
                container.makeCustomTime(timeline.getCustomTime('start'), 'end', timeline);
            }
        }
    });

    container.createOptions = function createOptions() {

        // clear out the classification holder
        $(".classification-holder").empty();

        // attach a clone of the type dropdown - fake up a label for now
        var typediv = $("<div class=\"col-md-4\">");
        // TODO Get this markup from somewhere
        var typelabel = "Type";
        typediv.append($('<label>' + typelabel + '</label>'));

        // clone the class select, this wil get what is selected
        typediv.append($('#find_class_term').clone().attr('id', 'find_class_term_modal'));
        $(".classification-holder").append(typediv);

        // set the new width, and set the value to match the dropdown on the main page
        $('#find_class_term_modal').attr('style', 'width:100%');
        $('#find_class_term_modal').val($('#find_class_term').val());

        // launch it as a select2
        $('#find_class_term_modal').select2(select2Options);
        $('#find_class_term_modal').prop('disabled', false);
        $('#find_class_term_modal').prop('required', false);

        var createTimelineSelect = function (name, markup) {

            // attach and launch two empty subtype levels with hacked in labels
            var selectDiv = $("<div class=\"col-md-4\">");
            selectDiv.append($('<label>' + markup + '</label>'));
            var selectSelect = $('<select id="find_subtype_' + name + '" style="width:100%">');
            selectDiv.append(selectSelect);
            console.log("building " + markup);
            $(".classification-holder").append(selectDiv);
            selectSelect.select2(select2Options);

        };

        createTimelineSelect("level1", "Klassifikation 1");
        createTimelineSelect("level2", "Klassifikation 2");

        var level1 = $('#find_subtype_level1');
        var level2 = $('#find_subtype_level2');

        // behaviour for selecting a class
        $('#find_class_term_modal').on("select2:select select2:unselecting", function () {
            var target = $(this).val();
            var level1Default = null;
            level1.empty();
            level2.empty();

            var subtypevocabulary = window.typevocabulary[target].taxonomy;

            for (var term in subtypevocabulary) {
                var subtype = subtypevocabulary[term].name;
                $('#' + window.subtype_id + ' option[value="' + subtype + '"]').clone().appendTo('#find_subtype_level1');
                if (subtypevocabulary[term]['default']) {
                    level1Default = subtype;
                }
            }

            // set the main page selcet, and activate the select2
            $('#find_class_term').val(target);
            $('#find_class_term').select2(select2Options);
            $('#find_class_term').trigger('select2:select');

            if (target !== "unassessed" && target !== '') {
                container.updateTimelineToPeriod(target, timeline);
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
            console.log(parentclass);
            console.log(window.typevocabulary[parentclass]);
            var parenttaxonomy = window.typevocabulary[parentclass].taxonomy;
            var level1klassification = parenttaxonomy[target];
            var level2Default = null;
            console.log(level1klassification);
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

            if (target !== '') {
                container.updateTimelineToPeriod(level1klassification, timeline);
            } else {
              console.log("set Timeline to default");
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

            if (target !== '') {
                container.updateTimelineToPeriod(parenttaxonomy[target], timeline);
            }
        });
        var parentclass = $('#find_class_term_modal').val();

        // set the initial values and set it up
        var subtypevocabulary = window.typevocabulary[parentclass].taxonomy;

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

    // on launching the modal do the stuff to make it work
    $('#find_classify').on('click', function () {

        var parentStart = $('#' + window.date_start_id).val();
        var parentEnd = $('#' + window.date_start_id + '_span').val();
        console.log($('#' + window.date_start_id).val());
        console.log(parentStart);
        // reset the timeline dropdowns
        container.createOptions();

        console.log($('#' + window.date_start_id).val());
        console.log(parentStart);
        // after a short delay, zoomout, giving a nice span and forcing a redraw
        window.setTimeout(function () {
            $('.vis-tl-zoom-out').trigger('click');
        }, 1000);

        if ($.isNumeric(parentStart)) {
            container.makeCustomTime(parentStart, 'start', timeline);
        }
        if ($.isNumeric(parentEnd)) {
            container.makeCustomTime(parentEnd, 'end', timeline);
        }
    });

    $(timeline).attr('pannning', false);

    timeline.on('rangechange', function () {
        $(timeline).attr('pannning', true);
    });
    timeline.on('rangechanged', function () {
        console.log('rangechanged');
        $('.vis-range').each(function (i, e) {
            if ($(e).width() < 100 || $(e).width() > 5000) {
                $(e).hide();
            } else {
                $(e).show();
            }
            timeline.redraw();
        });
        window.setTimeout(function () {
            $(timeline).attr('pannning', false);
        }, 100);

        container.customTimeExists('start').then(function () {
            container.drawLabel('start', timeline);
        });
        container.customTimeExists('end').then(function () {
            container.drawLabel('end', timeline);
        });
    });

    timeline.on('click', function (event) {
        var item_start = null;
        var item_end = null;
        var existing_start = null;
        var existing_end = null;
        var start = null;
        var end = null;

        if ($(timeline).attr('pannning')) {
            return true;
        }
        try {
            existing_start = timeline.getCustomTime('start');
        } catch (err) {
            existing_start = null;
        }
        try {
            existing_end = timeline.getCustomTime('end');
        } catch (err) {
            existing_end = null;
        }

        if (existing_start !== null) {
            timeline.removeCustomTime('start');
        }
        if (existing_end !== null) {
            timeline.removeCustomTime('end');
        }

        if (event.item !== null) {
            try {
                item_start = makeMoment(window.periodvocabulary[event.item].parameters.year_start.value);
            } catch (e) {
                item_start = makeMoment(minYear);
            }
            try {
                item_end = makeMoment(window.periodvocabulary[event.item].parameters.year_end.value);
            } catch (e) {
                item_end = makeMoment(maxYear);
            }
            if (event.event.shiftKey) {
                if (existing_start < item_start) {
                    start = makeMoment(existing_start);
                } else {
                    start = item_start;
                }

                if (existing_end > item_end) {
                    end = makeMoment(existing_end);
                } else {
                    end = item_end;
                }
            } else {
                start = item_start;
                end = item_end;
            }

            var item_mid_point = (start.year() + end.year()) / 2;

            timeline.moveTo(makeMoment(Math.max(-10000,item_mid_point)));

        } else {
            if (existing_start === null) {
                start = event.time;
                end = null;
            } else if (existing_end === null) {
                start = existing_start;
                end = event.time;
            } else {
                if (event.time > existing_end) {
                    start = existing_start;
                    end = event.time;
                } else if (event.time < existing_start) {
                    start = event.time;
                    end = existing_end;
                } else if (Math.pow(event.time - existing_start, 2) > Math.pow(event.time - existing_end, 2)) {
                    start = existing_start;
                    end = event.time;
                } else {
                    start = event.time;
                    end = existing_end;
                }
            }
        }

        container.makeCustomTime(start, 'start', timeline);
        container.makeCustomTime(end, 'end', timeline);

    }); // timeline.on('click')

    $('.vis-tl-zoom-in').on('click', function () { timeline.zoomIn(0.2); });
    $('.vis-tl-zoom-out').on('click', function () { timeline.zoomOut(0.2); });

    $('#closemodal').on('click', function (e) {
        e.preventDefault();
        $('#dating-modal').modal('hide');
    });

    $('.vis-item-content').each(function () {
        $(this).attr('title', $(this).html());
    });

}; // initTimeline()
