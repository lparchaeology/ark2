var initTimeline = function () {
    // DOM element where the Timeline will be attached
    var container = document.getElementById('visualization');

    container.customTimeExists = function(timeid) {
        var promise = new Promise(function (resolve) {
            window.setTimeout(function () {
                if ($(".vis-custom-time").filter("." + timeid).length !== 1) {
                    //console.log('looping');
                    container.customTimeExists(timeid);
                } else {
                    resolve();
                }
            }, 100 );
        });
        return promise;
    }

    container.drawLabel = function (timeid, timeline) {
        var span = $("#" + timeid + "-label");
        if (span.length === 0) {
            var labelinput = $("<input id=\"" + timeid + "-input\" class=\"timelinelabelinput\">");
            labelinput.val(new Date(start).getFullYear());
            labelinput.on("keyup", function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    labelinput.blur();
                    //timeline.updateTimeline($(this).val(), timeid);
                }
            });
            labelinput.on("blur", function () {
                container.makeCustomTime($(this).val(), timeid, timeline);
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
            $("#" + timeid + "-input").val(new Date(timeline.getCustomTime(timeid)).getFullYear());
        }
        var leftNumber = parseInt($(".vis-custom-time." + timeid).css("left"), 10);
        //var correction = window.width()/window.width();
        //leftNumber += correction;
        span.css("left", leftNumber.toString() + "px");
        if(timeid=='start'){
            $('#'+window.date_start_id).val(new Date(timeline.getCustomTime(timeid)).getFullYear());
        }
        if (timeid=='end'){
            $('#'+window.date_start_id+"_span").val(new Date(timeline.getCustomTime(timeid)).getFullYear());
        }

    }

    container.makeCustomTime = function(time, name, timeline){

        try{
            timeline.setCustomTime(time,name);
        } catch (e) {
            timeline.addCustomTime(time,name);
        }
        container.drawLabel(name,timeline);
    }

    //this adds start and end lines to the timeline
    container.updateTimelineToPeriod = function (target, timeline) {
        if (target !== 'undefined' && target !== null) {
            if (typeof target.parameters !== 'undefined') {
                var target_years = getYearsFromTarget(target);
                console.log(parseInt(target_years.start));
                console.log(parseInt(target_years.start)!=NaN);
                if($.isNumeric(parseInt(target_years.start)) && $.isNumeric(parseInt(target_years.end))){
                    start = vis.moment(parseInt(target_years.start), "Y");
                    end = vis.moment(parseInt(target_years.end), "Y");
                    if (start ){
                        container.makeCustomTime(start, 'start', timeline);
                    }
                    if (end){
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
        // get the end - or the current date
        try {
            if (isNaN(period.parameters.year_end.value)) {
                throw 'year end is NaN';
            }
            end = Math.min(period.parameters.year_end.value, (new Date()).getFullYear());
        } catch (e) {
            end = new Date().getFullYear();
        }

        // get the start - or 10,000BC- the beginning of archaeology ;-)
        try {
            if (isNaN(period.parameters.year_start.value)) {
                throw 'year start is NaN';
            }
            start = Math.max(period.parameters.year_start.value, -10000);
        } catch (e) {
            start = -10000;
        }

        //items is our vis dataset - load it up with period objects
        items.add({
            id: period_id,
            // the content we get from the dropdown menu - so it is translated and marked up how we want it
            content: $("#find_dating_period").find("option[value=" + period.name + "]").html(),
            start: vis.moment(start, "Y"),
            end: vis.moment(end, "Y").endOf("year"),
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
        zoomMin: 157680000000, //5 years (1000*60*60*24*365*5) in milliseconds
        zoomMax: 315700000000000, //10000 years (1000*60*60*24*365*10000) in milliseconds
        showCurrentTime: false,
        horizontalScroll: true,
        zoomKey: 'ctrlKey',
        end: vis.moment(new Date().getFullYear(), 'Y'),
        start: vis.moment(-2000, 'Y'),
    };

    // Create a Timeline
    var timeline = new vis.Timeline(container, items, options);

    // this will hide pills which are either too small or too large to be comfortably shown
    $('.vis-range').each(function (i, e) {
        if ($(e).width() < 100 || $(e).width() > 2000) {
            $(e).hide();
        } else {
            $(e).show();
        }
    });

    // Options for the dropdowns
    select2Options = {
        // sort alphabetically by translation
        sorter: function (data) {
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
    };

    var getYearsFromTarget = function(target){
        target_years = {"start": null, "end": null};

        if(target.parameters.hasOwnProperty("period")){
            console.log(target.parameters.period.value);
            console.log(window.periodvocabulary[target.parameters.period.value]);
            target_years.start = window.periodvocabulary[target.parameters.period.value].parameters.year_start.value,
            target_years.end =  window.periodvocabulary[target.parameters.period.value].parameters.year_end.value
        }
        // if there is no period there are no dates, so return the whole span of default time
        return target_years;
    }

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
                timeline.removeCustomTime('start');
                timeline.addCustomTime(timeline.getCustomTime('end'), 'start');
                return false;
            }
            container.customTimeExists('start').then(function () {
                container.drawLabel('start', timeline);
            });
        } else {
            if (properties.time < timeline.getCustomTime('start')) {
                timeline.removeCustomTime('end');
                timeline.addCustomTime(timeline.getCustomTime('start'), 'end');
                return false;
            }
            container.customTimeExists('end').then(function () {
                container.drawLabel('end', timeline);
            });
        }
    });

    container.createOptions = function(){

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

        var createTimelineSelect = function(name, markup){

            // attach and launch two empty subtype levels with hacked in labels
            var selectDiv = $("<div class=\"col-md-4\">");
            selectDiv.append($('<label>' + markup + '</label>'));
            var selectSelect = $('<select id="find_subtype_' + name + '" style="width:100%">');
            selectDiv.append(selectSelect);
            console.log("building " + markup);
            $(".classification-holder").append(selectDiv);
            selectSelect.select2(select2Options);

        }

        createTimelineSelect("level1", "Klassifikation 1");
        createTimelineSelect("level2", "Klassifikation 2");

        level1 = $('#find_subtype_level1');
        level2 = $('#find_subtype_level2');

        // behaviour for selecting a class
        $('#find_class_term_modal').on("select2:select select2:unselecting", function () {
            var target = $(this).val();
            level1.empty();
            level2.empty();

            subtypevocabulary = window.typevocabulary[target].taxonomy;

            for (var term in subtypevocabulary) {
                var subtype = subtypevocabulary[term]['name'];
                $('#' + window.subtype_id + ' option[value="' + subtype + '"]').clone().appendTo('#find_subtype_level1');
            }

            // set the main page selcet, and activate the select2
            $('#find_class_term').val(target);
            $('#find_class_term').select2(select2Options);
            $('#find_class_term').trigger('select2:select');

            container.updateTimelineToPeriod(target, timeline);

            // # init the level1 classification as unknowwn
            level1.val(target.split('.')[0] + '.unknown');
            level1.select2(select2Options);
            //level1.trigger('select2:select');

        });

        // Change the level2 Klassification if the Klassification1 changes
        level1.on("select2:select select2:unselecting", function () {
            var parentclass = $('#'+window.type_id).val();
            var target = $(this).val();
            level2.empty();
            parenttaxonomy = window.typevocabulary[parentclass].taxonomy;
            var level1klassification = parenttaxonomy[target];
            for (descendent in level1klassification['taxonomy']){
                level2option =  level1klassification['taxonomy'][descendent];
                $('#' + window.subtype_id + ' option[value="' + level2option['name'] + '"]').clone().appendTo(level2);
            }

            $('#'+window.subtype_id).val(level1klassification['name']);
            $('#'+window.subtype_id).select2(select2Options);
            $('#'+window.subtype_id).trigger('select2:select');

            container.updateTimelineToPeriod(level1klassification, timeline);

            level2.select2(select2Options);
        });

        // update the timeline if the Klassification2 changes
        level2.on("select2:select select2:unselecting", function () {
            var target = $(this).val();
            var parentclass = $('#'+window.type_id).val();
            var parentsubclass = $('#find_subtype_level1').val();
            parenttaxonomy = window.typevocabulary[parentclass].taxonomy[parentsubclass].taxonomy;
            console.log(parenttaxonomy[target]);
            $('#'+window.subtype_id).val(parenttaxonomy[target]['name']);
            $('#'+window.subtype_id).select2(select2Options);
            $('#'+window.subtype_id).trigger('select2:select');

            container.updateTimelineToPeriod(parenttaxonomy[target], timeline);

        });
        var parentclass = $('#find_class_term_modal').val()

        // set the initial values and set it up
        subtypevocabulary = window.typevocabulary[parentclass].taxonomy;

        for (var term in subtypevocabulary) {
            var subtype = subtypevocabulary[term]['name'];
            $('#' + window.subtype_id + ' option[value="' + subtype + '"]').clone().appendTo(level1);
        }

        var currentSubtype = $('#'+window.subtype_id).val();

        console.log(parentclass);

        splitclass = currentSubtype.split(".");

        level1name = parentclass + "." + splitclass[1];

        for (potentialsubclass in window.typevocabulary[parentclass].taxonomy) {
            if(level1name == potentialsubclass){
                level1.val(potentialsubclass);
                level1.select2(select2Options);
                level1.trigger('select2:select');
                if (level1name != currentSubtype){
                    level2.val(currentSubtype);
                    level2.select2(select2Options);
                    level2.trigger('select2:select');
                }
            }
        }
    }

    // on launching the modal do the stuff to make it work
    $('#find_classify').on('click', function () {

        // reset the timeline dropdowns
        container.createOptions();

        // after a short delay, zoomout, giving a nice span and forcing a redraw
        window.setTimeout(function () {
            $('.vis-tl-zoom-out').trigger('click');
        }, 3000);

        var start = $('#'+window.date_start_id).val();
        var end = $('#'+window.date_start_id+'_span').val();

        container.makeCustomTime(start,'start', timeline);
        container.makeCustomTime(end,'end', timeline);
    });

    $(timeline).attr('pannning', false);

    timeline.on('rangechange', function () {
        $(timeline).attr('pannning', true);
    });
    timeline.on('rangechanged', function () {
        console.log('rangechanged');
        $('.vis-range').each(function (i, e) {
            if ($(e).width() < 100 || $(e).width() > 1000) {
                $(e).hide();
            } else {
                $(e).show();
            }
            timeline.redraw();
        });
        setTimeout(function () {
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
                item_start = vis.moment(window.periodvocabulary[event.item].parameters.year_start.value, 'Y');
            } catch (e) {
                item_start = vis.moment('-10000', 'Y');
            }
            try {
                item_end = vis.moment(window.periodvocabulary[event.item].parameters.year_end.value, 'Y');
            } catch (e) {
                item_end = vis.moment(new Date(), 'Y');
            }

            if (event.event.shiftKey) {
                if (existing_start < item_start) {
                    start = vis.moment(existing_start);
                } else {
                    start = item_start;
                }

                if (existing_end > item_end) {
                    end = vis.moment(existing_end);
                } else {
                    end = item_end;
                }
            } else {
                start = item_start;
                end = item_end;
            }

            var item_mid_point = (start.year() + end.year()) / 2;

            console.log(item_mid_point);

            timeline.moveTo(vis.moment(item_mid_point, 'Y'));

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

        $('#'+window.date_start_id).val(new Date(start).getFullYear(), 'Y');
        var startperiod = window.getPeriodFromYear(new Date(start).getFullYear());
        $('#' + window.date_start_period_id).val(startperiod.name);
        $('#' + window.date_start_period_id).trigger('change.select2');
        container.makeCustomTime(start,'start', timeline);

        $('#'+window.date_start_id+'_span').val(new Date(end).getFullYear(), 'Y');
        var endperiod = window.getPeriodFromYear(new Date(end).getFullYear());
        $('#' + window.date_start_period_id+'_span').val(startperiod.name);
        $('#' + window.date_start_period_id+'_span').trigger('change.select2');
        container.makeCustomTime(end,'end',timeline);

    });

    $('.vis-tl-zoom-in').on('click', function () { timeline.zoomIn(0.2); });
    $('.vis-tl-zoom-out').on('click', function () { timeline.zoomOut(0.2); });

    $('#closemodal').on('click', function (e) {
        e.preventDefault();
        $('#dating-modal').modal('hide');
    });

    $('.vis-item-content').each(function () {
        $(this).attr('title', $(this).html());
    });

};
