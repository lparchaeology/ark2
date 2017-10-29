/*

// dating-modal.js

var initTimeline = function () {
        console.log('initTimeline');
        // DOM element where the Timeline will be attached
        var container = document.getElementById('visualization');

        //Create a DataSet (allows two way data-binding)
        var items = new vis.DataSet();

        var start = null;
        var end = null;

        var makeYearMoment = function makeYearMoment(year) {
            return vis.moment(year, 'Y');
        };

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

            // get the start - or 10,000BC- the begining of archaeology ;-)
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
                start: makeYearMoment(start),
                end: makeYearMoment(end).endOf("year"),
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
            end: makeYearMoment(new Date().getFullYear()),
            start: makeYearMoment(-2000),
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
            // sort alphabetically be translation
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

        var setTimelineYear = function setTimelineYear(type, year) {
            try {
                timeline.setCustomTime(makeYearMoment(year), type);
            } catch (e) {
                timeline.addCustomTime(makeYearMoment(year), type);
            }
        };

        var setTimelineStart = function setTimelineStart(year) {
            setTimelineYear('start', year);
        };

        var setTimelineEnd = function setTimelineEnd(year) {
            setTimelineYear('end', year);
        };

        //this adds start and end lines to the timeline
        var setTimeline = function setTimeline(term) {
            setTimelineStart(term.year_start);
            setTimelineEnd(term.year_end);
            timeline.moveTo(makeYearMoment(term.year_end));
            $('#find_dating_year').val(term.year_start);
            $('#find_dating_year').trigger('keyup');
            $('#find_dating_year_span').val(term.year_end);
            $('#find_dating_year_span').trigger('keyup');
        };

        var updateTimeline = function updateTimeline() {
            level2 = modalClassification2Term();
            if (level2.year_start || level2.year_end || level2.period) {
                setTimeline(level2);
                return;
            }

            level1 = modalClassification1Term();
            if (level1.year_start || level1.year_end || level1.period) {
                setTimeline(level1);
                return;
            }

            type = modalClassTerm();
            if (type.year_start || type.year_end || type.period) {
                setTimeline(type);
            }
        };

        var currentClass = function currentClass() {
            return $('#find_class_term').val();
        };

        var currentClassTerm = function currentClassTerm() {
            return window.classification.taxonomy[currentClass()];
        };

        var currentClassification = function currentClassification() {
            return $('#find_classification_subtype').val();
        };

        var currentClassificationTerm = function currentClassificationTerm() {
            return currentClassTerm().taxonomy[currentClassification()];
        };

        var modalClass = function modalClass() {
            return $('#find_class_term_modal').val();
        };

        var modalClassTerm = function modalClassTerm() {
            return window.classification.taxonomy[modalClass()];
        };

        var modalClassification1 = function modalClassification1() {
            return $('#find_subtype_level1').val();
        };

        var modalClassification1Term = function modalClassification1Term() {
            return modalClassTerm().taxonomy[modalClassification1()];
        };

        var modalClassification2 = function modalClassification2() {
            return $('#find_subtype_level2').val();
        };

        var modalClassification2Term = function modalClassification2Term() {
            return modalClassTerm().taxonomy[modalClassification2()];
        };

        // Populate a dropdown from a taxonomy term descendents
        var updateTimeline = function populateSelect(term, select) {
            if (select) {
                select.empty();
                if (term) {
                    for (var child in term.taxonomy) {
                        var subterm = term.taxonomy[child];
                        var newOption = new Option(subterm.keyword, subterm.name, subterm.default, subterm.default);
                        select.append(newOption);
                    }
                }
            }
        };

        var setSelect = function setSelect(term, select, subselect) {
            if (term) {
                select.val(term.name);
                if (subselect) {
                    populateSelect(term, subselect);
                }
                select.trigger('select2:select');
            }
        };

        // Set the three dropdowns from a given type and optional subtype
        var setClassification = function setClassification(type, subtype, subsubtype) {
            if (subsubtype) {
                subtype = subsubtype;
            }

            $('#find_class_term').val(type);
            $('#find_class_term').trigger('select2:select');

            $('#find_classification_subtype').val(subtype);
            $('#find_classification_subtype').trigger('select2:select');
        };

        var updateClassification = function updateClassification() {
            setClassification(modalClass(), modalClassification1(), modalClassification2());
        };

        // Set the three dropdowns from a given type and optional subtype
        var setModalClassification = function setModalClassification(type, subtype) {
            console.log('setModal');
            console.log(type);
            console.log(subtype);
            var term = null;
            var subterm = null;
            var subsubterm = null;
            var child = null;

            if (type === undefined || type === null || type === '') {
                for (child in window.classification.taxonomy) {
                    if (window.classification.taxonomy[child].default) {
                        term = window.classification.taxonomy[child];
                        continue;
                    }
                }
            } else {
                term = window.classification.taxonomy[type];
            }

            if (subtype === undefined || subtype === null || subtype === '') {
                for (child in term.taxonomy) {
                    if (term.taxonomy[child].default) {
                        subterm = term.taxonomy[child];
                        break;
                    }
                }
            } else {
                for (child in term.taxonomy) {
                    if (child === subtype) {
                        subterm = term.taxonomy[child];
                        break;
                    } else {
                        for (var grandchild in term.taxonomy[child].taxonomy) {
                            if (grandchild === subtype) {
                                subterm = term.taxonomy[child];
                                subsubterm = term.taxonomy[child].taxonomy[grandchild];
                                break;
                            }
                        }
                    }
                }
            }
            console.log(term);
            console.log(subterm);
            console.log(subsubterm);
            setSelect(term, $('#find_class_term_modal'), $('#find_subtype_level1'));
            setSelect(subterm, $('#find_subtype_level1'), $('#find_subtype_level2'));
            setSelect(subsubterm, $('#find_subtype_level2'), null);
        };

        var updateModalClassification = function updateModalClassification() {
            setModalClassification(currentClass(), currentClassification());
        };

        // Change the level2 Klassification if the Klassification1 changes
        level1.on("select2:select select2:unselecting", function () {
            populateSelect(modalClassTerm().taxonomy[$(this).val()], $('#find_subtype_level2'));
            updateTimeline();
            updateClassification();
        });

        // now that we have that all set up make the find classify trigger a modal
        $('#find_classify').attr('data-toggle', 'modal');
        $('#find_classify').removeClass("disabled").addClass("btn-default");

        // Make sure required-but-readonly Find Class field is populated
        $('#find').submit(function (e) {
            if ($('#find_class_term').val() === '' || $('#find_class_term').val() === undefined) {
                e.preventDefault();
                $('.readonly-select').prop('disabled', true);
                $('#find_classify').click();
            }
        });

        // on launching the modal do the stuff to make it work
        $('#find_classify').on('click', function () {
            console.log('onclick');
            // clear out the classification holder
            $(".classification-holder").empty();

            // attach a clone of the type dropdown - fake up a label for now
            var typediv = $("<div class=\"col-md-4\">");
            // TODO Get this markup from somewhere
            var typelabel = "Type";
            typediv.append($('<label>' + typelabel + '</label>'));
            typediv.append($('#find_class_term').clone().attr('id', 'find_class_term_modal'));
            $(".classification-holder").append(typediv);

            // set the new width, and set the value to match the dropdown on the main page
            $('#find_class_term_modal').attr('style', 'width:100%');
            $('#find_class_term_modal').val($('#find_class_term').val());

            // launch it as a select2
            $('#find_class_term_modal').select2(select2Options);
            $('#find_class_term_modal').prop('disabled', false);
            $('#find_class_term_modal').prop('required', false);

            // attach and launch two empty subtype levels with hacked in labels
            var class1 = $("<div class=\"col-md-4\">");
            // TODO Get this markup from somewhere
            class1label = "Klassifikation 1";
            class1.append($('<label>' + class1label + '</label>'));
            var level1 = $('<select id="find_subtype_level1" style="width:100%">');
            class1.append(level1);
            $(".classification-holder").append(class1);
            level1.select2(select2Options);

            var class2 = $("<div class=\"col-md-4\">");
            // TODO Get this markup from somewhere
            class2label = "Klassifikation 2";
            class2.append($('<label>' + class2label + '</label>'));
            var level2 = $('<select id="find_subtype_level2" style="width:100%">');
            class2.append(level2);
            $(".classification-holder").append(class2);
            level2.select2(select2Options);

            // Changing the type clears the classification
            $('#find_class_term_modal').on("select2:select select2:unselecting", function () {
                var type = $(this).val();
                setModalClassification(type, null);
                updateTimeline();
                updateClassification();
            });

            // Changing the level 1 classification clears the level 2 classification
            level1.on("select2:select select2:unselecting", function () {
                populateSelect(modalClassTerm().taxonomy[$(this).val()], $('#find_subtype_level2'));
                updateTimeline();
                updateClassification();
            });

            // Changing the level 2 subclass only updates the timeline
            level2.on("select2:select select2:unselecting", function () {
                updateTimeline();
                updateClassification();
            });

            // Initialise to the current selected class
            setModalClassification(currentClassTerm(), null);

            setTimelineStart($('#find_dating_year').val());
            setTimelineEnd($('#find_dating_year_span').val());

            // after a short delay, zoomout, giving a nice span and forcing a redraw
            window.setTimeout(function () {
                $('.vis-tl-zoom-out').trigger('click');
            }, 3000);

        });

        $(timeline).attr('pannning', false);

        timeline.on('rangechange', function () {
            $(timeline).attr('pannning', true);
        });

        timeline.on('rangechanged', function () {
            setTimeout(function () {
                $(timeline).attr('pannning', false);
            }, 100);
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
                        item_start = makeYearMoment(window.periodvocabulary[event.item].parameters.year_start.value);
                    } catch (e) {
                        item_start = makeYearMoment('-10000');
                    }
                    try {
                        item_end = makeYearMoment(window.periodvocabulary[event.item].parameters.year_end.value);
                    } catch (e) {
                        item_end = makeYearMoment(new Date());
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

                    var item_mid_point = makeYearMoment((start.year() + end.year()) / 2);

                    timeline.moveTo(item_mid_point);

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

                $('#find_dating_year').val(new Date(start).getFullYear());
                $('#find_dating_year').trigger('keyup');
                $('#find_dating_year_span').val(new Date(end).getFullYear());
                $('#find_dating_year_span').trigger('keyup');

                function customTimeExists(timeid) {
                    var promise = new Promise(function (resolve) {
                        window.setTimeout(function () {
                            console.log("looping");
                            if ($(".vis-custom-time").filter("." + timeid).length !== 1) {
                                customTimeExists();
                            } else {
                                resolve();
                            }
                        }, 100);
                    });
                    return promise;
                }

                function updateTimeline(year, timeid) {
                    var formid = null;
                    var vis_year = makeYearMoment((year); timeline.setCustomTime(vis_year, timeid); drawLabel(timeid);
                        if (timeid === 'start') {
                            formid = '#find_dating_year';
                        } else {
                            formid = '#find_dating_year_span';

                        }
                        $(formid).val(new Date(year).getFullYear()); $(formid).trigger('keyup');
                    }

                    function drawLabel(timeid) {
                        var span = $("#" + timeid + "-label");
                        if (span.length === 0) {
                            var labelinput = $("<input id=\"" + timeid + "-input\" class=\"timelinelabelinput\">");
                            labelinput.val(new Date(start).getFullYear());
                            labelinput.on("keyup", function (e) {
                                if (e.keyCode === 13) {
                                    e.preventDefault();
                                    updateTimeline($(this).val(), timeid);
                                }
                            });
                            labelinput.on("blur", function () {
                                updateTimeline($(this).val(), timeid);
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
                        console.log($(".vis-custom-time." + timeid).css("left"));
                        var leftNumber = parseInt($(".vis-custom-time." + timeid).css("left"), 10);
                        //var correction = window.width()/window.width();
                        //leftNumber += correction;
                        console.log(leftNumber);
                        span.css("left", leftNumber.toString() + "px");
                    }

                    timeline.addCustomTime(start, 'start');

                    customTimeExists('start').then(function () {
                        drawLabel('start');
                    });

                    timeline.on("rangechange", function () {
                        customTimeExists('start').then(function () {
                            drawLabel('start');
                        });
                    });

                    timeline.addCustomTime(end, 'end');

                    customTimeExists('end').then(function () {
                        drawLabel('end');
                    });

                    timeline.on("rangechange", function () {
                        customTimeExists('end').then(function () {
                            drawLabel('end');
                        });
                    });


                    timeline.on('timechanged', function (properties) {

                        if (properties.id === 'start') {
                            if (properties.time > timeline.getCustomTime('end')) {
                                timeline.removeCustomTime('start');
                                timeline.addCustomTime(timeline.getCustomTime('end'), 'start');
                                return false;
                            }
                            customTimeExists('start').then(function () {
                                drawLabel('start');
                            });
                        } else {
                            if (properties.time < timeline.getCustomTime('start')) {
                                timeline.removeCustomTime('end');
                                timeline.addCustomTime(timeline.getCustomTime('start'), 'end');
                                return false;
                            }
                            customTimeExists('end').then(function () {
                                drawLabel('end');
                            });
                        }
                    });
                });

            $('.vis-tl-zoom-in').on('click', function () { timeline.zoomIn(0.2); }); $('.vis-tl-zoom-out').on('click', function () { timeline.zoomOut(0.2); });

            $('#closemodal').on('click', function (e) {
                e.preventDefault();
                $('#dating-modal').modal('hide');
            });

            $('.vis-item-content').each(function () {
                $(this).attr('title', $(this).html());
            });

            timeline.on('rangechanged', function () {
                $('.vis-range').each(function (i, e) {
                    if ($(e).width() < 100 || $(e).width() > 1800) {
                        $(e).hide();
                    } else {
                        $(e).show();
                    }
                    timeline.redraw();
                });
            });

        };

// period.js

var initPeriod = function () {
    console.log('initPeriod');
    var date_start_id = "find_dating_year";

    var date_start_period_id = 'find_dating_period';

    var query = { "concept": "dime.period" };

    $.post(path + 'api/internal/vocabulary', JSON.stringify(query))
        .fail(function () {
            console.log('Error fetching period vocabulary');
        })
        .done(function (response) {
            window.periodvocabulary = response.terms;
            initSimpleDating();
            initTimeline();
        });

    var getPeriodFromYear = function (year) {
        var periodvocabstart = null;
        var periodvocabend = null;
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
                periodvocabend = null;
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

    var periodMouseEnter = function (item) {
        var highlighted_item_id = item.attr('id');
        var highlighted_item_code = highlighted_item_id.split('-');
        var highlighted_item_concept = highlighted_item_code[highlighted_item_code.length - 1];
        //console.log(highlighted_item_concept);
        if (typeof periodvocabulary[highlighted_item_concept].parameters == "undefined") {
            var tooltip = "undefined";
        } else {

            try {
                if (isNaN(periodvocabulary[highlighted_item_concept].parameters.year_end.value)) {
                    throw 'year end is NaN';
                }
                end = periodvocabulary[highlighted_item_concept].parameters.year_end.value;
            } catch (e) {
                end = new Date().getFullYear();
            }

            try {
                if (isNaN(periodvocabulary[highlighted_item_concept].parameters.year_start.value)) {
                    throw 'year end is NaN';
                }
                start = period.parameters.year_end.value;
            } catch (e) {
                start = -10000;
            }

            var tooltip = start.toString() + "\xa0\u2014\xa0" + end.toString();
        }

        var promise = new Promise(function (resolve) {
            item.attr({ "data-toggle": "tooltip", "data-placement": "right", "title": tooltip });
            item.tooltip();
            resolve(true);
        });
        promise.then(function (result) {
            item.tooltip('show');
        });
    }

    $('body').on({
        mouseenter: function () {
            periodMouseEnter($(this));
        }
    }, '#select2-' + date_start_period_id + '-results .select2-results__option.select2-results__option--highlighted');

    $('body').on({
        mouseenter: function () {
            periodMouseEnter($(this));
        }
    }, '#select2-' + date_start_period_id + '_span-results .select2-results__option.select2-results__option--highlighted');

    $('#' + date_start_id).on('keyup', function () {
        console.log(this.value)
        var year = parseInt(this.value);

        var period = getPeriodFromYear(year);

        $('#' + date_start_period_id).val(period.name);
        $('#' + date_start_period_id).trigger('change.select2');
    });

    $('#' + date_start_id + '_span').on('keyup', function () {
        var year = parseInt(this.value);

        var period = getPeriodFromYear(year);

        $('#' + date_start_period_id + '_span').val(period.name);
        $('#' + date_start_period_id + '_span').trigger('change.select2');
    });

    $('#' + date_start_id).on('focusout', function () {
        var year = parseInt(this.value);
        var span_year = parseInt($('#' + date_start_id + '_span').val());
        if (isNaN(year) || isNaN(span_year)) {
            return true;
        }
        if (span_year < year) {
            var endyear = span_year;
            $(this).val(endyear);
            $('#' + date_start_id + '_span').val(year);

            $('#' + date_start_id + '_span').trigger('keyup');
            $('#' + date_start_id).trigger('keyup');
        }
    });

    $('#' + date_start_id + '_span').on('focusout', function () {
        var year = parseInt(this.value);
        if (isNaN(year) || isNaN(parseInt($('#' + date_start_id).val()))) {
            return true;
        }
        if (parseInt($('#' + date_start_id).val()) > year) {
            var endyear = parseInt($('#' + date_start_id).val());
            $(this).val(endyear);
            $('#' + date_start_id).val(year);

            $('#' + date_start_id).trigger('keyup');
            $('#' + date_start_id + '_span').trigger('keyup');
        }
    });

    $('#' + date_start_period_id).on("select2:select select2:unselecting", function () {
        period = periodvocabulary[this.value];

        if (typeof period == 'undefined') {
            return false;
        }

        if ($('#' + date_start_id).val() == '') {
            var year = period.parameters.year_start.value;

        } else {
            var year = parseInt($('#' + date_start_id).val());
            if (year < parseInt(period.parameters.year_start.value) || year > parseInt(period.parameters.year_end.value)) {
                year = period.parameters.year_start.value;
            }

        }

        $('#' + date_start_id).val(year);
        $('#' + date_start_id).trigger('focusout');
    });

    $('#' + date_start_period_id + '_span').on("select2:select select2:unselecting", function () {
        period = periodvocabulary[this.value];

        if (typeof period == 'undefined') {
            return false;
        }
        if ($('#' + date_start_id + '_span').val() == '') {
            var year = period.parameters.year_end.value;

        } else {
            var year = parseInt($('#' + date_start_id + '_span').val());
            if (year < parseInt(period.parameters.year_start.value) || year > parseInt(period.parameters.year_end.value)) {
                year = period.parameters.year_end.value;
            }

        }

        $('#' + date_start_id + '_span').val(year);

        $('#' + date_start_id + '_span').trigger('focusout');

    });

    $('.dating-button').removeClass('inactive');



}

$(document).ready(function () {
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

// subtype.js

var initSubtype = function () {

    var type_id = "find_class_term";
    var subtype_id = "find_classification_subtype";
    var date_start_id = "find_dating_year";

    /* Fields are now readonly, disable extra code for now
    var buildSubtypeSelect2 = function () {

        $('#' + subtype_id).select2({
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
        });

        $('body').on({
            mouseenter: function () {
                var item = $(this);
                var highlighted_item_id = item.attr('id');
                var highlighted_item_code = highlighted_item_id.split('-');
                var highlighted_item_concept = highlighted_item_code[highlighted_item_code.length - 1];
                try {
                    if (typeof subtypevocabulary[highlighted_item_concept].parameters != "undefined") {
                        var subtypeItemParams = subtypevocabulary[highlighted_item_concept].parameters;
                        if (typeof subtypeItemParams.year_start != "undefined"
                            && typeof subtypeItemParams.year_end != "undefined") {
                            var tooltip = subtypeItemParams.year_start.value + "\xa0\u2014\xa0" + subtypeItemParams.year_end.value;
                        } else if (typeof subtypevocabulary[highlighted_item_concept].parameters.period != "undefined") {
                            var tooltip = subtypevocabulary[highlighted_item_concept].parameters.period.value;
                        } else {
                            var tooltip = "Undefined";
                        }
                    } else {
                        var tooltip = "Undefined";
                    }
                } catch (e) {

                }

                var promise = new Promise(function (resolve) {
                    item.attr({ "data-toggle": "tooltip", "data-placement": "right", "title": tooltip });
                    item.tooltip();
                    resolve(true);
                });
                promise.then(function (result) {
                    item.tooltip('show');
                });
            }
        }, '#select2-' + subtype_id + '-results .select2-results__option.select2-results__option--highlighted');

    }

    $('#' + date_start_id).on('focusout', function () {
        //console.log($(this).val());
    });

    $('#' + date_start_id + '_span').on('focusout', function () {
        //console.log($(this).val());
    });
    */

$('#' + type_id).on("select2:select select2:unselecting", function () {

    var target = $(this).val();
    var type = classification.terms[target];

    // Toggle the Coin-only fields.
    if (target === 'coin') {
        $('#find_mint_content').closest('.form-group').show();
        $('#find_issuer_content').closest('.form-group').show();
        $('#find_secondary_term_looped').closest('.checkbox').show();
        $('#advanced-dating-button').click();
    } else {
        $('#find_mint_content').closest('.form-group').hide();
        $('#find_issuer_content').closest('.form-group').hide();
        $('#find_secondary_term_looped').closest('.checkbox').hide();
    }

    $('#' + subtype_id).empty();
    for (var subtype in type.terms) {
        var term = type.terms[subtype];
        var newOption = new Option(term.keyword, term.name, false, false);
        $('#' + subtype_id).append(newOption);
    }
    $('#' + subtype_id).trigger('select2:select');

    //buildSubtypeSelect2();
});

/*
$('#' + subtype_id).on("select2:select select2:unselecting", function () {

    var target = $(this).val();

    if (target === "up") {
        $('#' + type_id).trigger('select2:select');
        $('#' + subtype_id).select2('open');
        return true;
    }

    var goupoption = $('<option value="up"> ↖</option>');
    if (target.split('.').length < 3) {
        $('#' + subtype_id).empty();
        $('#' + subtype_id).append(goupoption);
        for (var subtype in subtypevocabulary) {
            if (target.split('.')[0] == subtype.split('.')[0] && target.split('.')[1] == subtype.split('.')[1]) {
                subtypevocabulary[subtype].optionelement.appendTo('#' + subtype_id);
            }
        }

        $('#' + subtype_id).val(target);

        //buildSubtypeSelect2();

        $('#' + subtype_id).select2('open');
    }

    try {
        var target_years = getYearsFromTarget(target);

        target_start_year = target_years.start;
        target_end_year = target_years.end;

        var current_start_year = parseInt($('#' + date_start_id).val());
        var current_end_year = parseInt($('#' + date_start_id + '_span').val());

        //console.log([target, "target", target_start_year, target_end_year, "current", current_start_year, current_end_year]);

        if (isNaN(current_start_year) || current_start_year < target_start_year || current_start_year > target_end_year) {
            $('#' + date_start_id).val(target_start_year);
        }

        if (isNaN(current_end_year) || current_end_year > target_end_year || current_end_year < target_start_year) {
            $('#' + date_start_id + '_span').val(target_end_year);
        }

        $('#' + date_start_id).attr({
            "min": target_start_year,
            "max": target_end_year
        });

        $('#' + date_start_id + '_span').attr({
            "max": target_end_year,
            "max": target_end_year
        });

        $('#' + date_start_id).trigger('keyup');

        $('#' + date_start_id + '_span').trigger('keyup');

    } catch (e) {
        //console.log('something was probably undefined :(');
    }

});

$('#' + date_start_id).trigger('select2:select');

};

window.getYearsFromTarget = function (target) {

    if (typeof subtypevocabulary[target].parameters.year_start !== "undefined") {

        var target_start_year = parseInt(subtypevocabulary[target].parameters.year_start.value);

        var target_end_year = parseInt(subtypevocabulary[target].parameters.year_end.value);

    } else if (typeof subtypevocabulary[target].parameters.period !== "undefined") {

        var target_start_year = parseInt(window.periodvocabulary[subtypevocabulary[target].parameters.period.value].parameters.year_start.value);

        var target_end_year = parseInt(window.periodvocabulary[subtypevocabulary[target].parameters.period.value].parameters.year_end.value);
    }

    return { "start": target_start_year, "end": target_end_year }
}

$(document).ready(function () {

    $('#find_classify').attr('data-toggle', 'false');

    window.type_id = "find_class_term";
    window.subtype_id = "find_classification_subtype";
    window.date_start_id = "find_dating_year";

    var query = { "concept": "dime.find.class" };
    $.post(path + 'api/internal/vocabulary', JSON.stringify(query))
        .fail(function (response) {
            console.log('Error fetching class vocabulary');
            console.log(response);
        })
        .done(function (response) {
            console.log('Got vocab');
            window.classification = response;
            console.log(response);
            initPeriod();
        });

    // Initially hide the Coin-only fields
    $('#find_mint_content').closest('.form-group').hide();
    $('#find_issuer_content').closest('.form-group').hide();
    $('#find_secondary_term_looped').closest('.checkbox').hide();
});

*/
