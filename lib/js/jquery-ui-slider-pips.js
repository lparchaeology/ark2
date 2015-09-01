/*! jQuery-ui-dragslider-Pips - v1.6.2 - 2014-09-13
* Copyright (c) 2014 Simon Goellner <simey.me@gmail.com>; Licensed MIT */

// PIPS

(function($) {

    "use strict";

    var extensionMethods = {

        pips: function( settings ) {

            var dragslider = this,
                collection = "",
                pips = ( dragslider.options.max - dragslider.options.min ) / dragslider.options.step,
                options = {

                    first: "label",
                    // "label", "pip", false

                    last: "label",
                    // "label", "pip", false

                    rest: "pip",
                    // "label", "pip", false

                    labels: false,
                    // [array], false

                    prefix: "",
                    // "", string

                    suffix: "",
                    // "", string

                    step: ( pips > 100 ) ? Math.floor( pips * 0.05 ) : 1,
                    // number

                    formatLabel: function(value) {
                        return this.prefix + value + this.suffix;
                    }
                    // function
                    // must return a value to display in the pip labels

                };

            $.extend( options, settings );

            dragslider.options.pipStep = options.step;

            // get rid of all pips that might already exist.
            dragslider.element
                .addClass("ui-dragslider-pips")
                .find(".ui-dragslider-pip")
                .remove();



            // small object with functions for marking pips as selected.

            var selectPip = {

                single: function(value) {

                    var $pips = this.resetClasses();

                    $pips
                        .filter(".ui-dragslider-pip-" + value )
                        .addClass("ui-dragslider-pip-selected");

                },

                range: function(values) {

                    var $pips = this.resetClasses();

                    $pips
                        .filter(".ui-dragslider-pip-" + values[0] )
                        .addClass("ui-dragslider-pip-selected-first");

                    $pips
                        .filter(".ui-dragslider-pip-" + values[1] )
                        .addClass("ui-dragslider-pip-selected-second");


                },

                resetClasses: function() {

                    var $pips = 
                        dragslider.element
                            .find(".ui-dragslider-pip")
                            .removeClass("ui-dragslider-pip-selected ui-dragslider-pip-selected-first ui-dragslider-pip-selected-second");
                    
                    return $pips;

                }

            };




            // when we click on a label, we want to make sure the
            // dragslider's handle actually goes to that label!
            // - without this code the label is just treated like a part
            // - of the dragslider and there's no accuracy in the selected value
            function labelClick( label ) {

                var val = $(label).data("value"),
                    $thisdragslider = dragslider.element;

                if ( true === dragslider.options.range ) {

                    var dragsliderVals = $thisdragslider.dragslider("values");
                    var finalVals;

                    // If the handles are together when we click a label...
                    if (dragsliderVals[0] === dragsliderVals[1]) {

                        // ...and the label we clicked on is less,
                        // then move first handle to the label...
                        if (val < dragsliderVals[0]) {

                            finalVals = [ val , dragsliderVals[1] ];

                        // ...otherwise move the second handle to the label
                        } else {

                           finalVals = [ dragsliderVals[0] , val ];

                        }

                    // if both handles are equidistant from the label we clicked on then
                    // we bring them together at the label...
                    } else if (Math.abs(dragsliderVals[0] - val) === Math.abs(dragsliderVals[1] - val)) {

                        finalVals = [ val , val ];

                    // ...or if the second handle is closest to our label, bring second
                    // handle to the label...
                    } else if ( Math.abs( dragsliderVals[0] - val ) < Math.abs( dragsliderVals[1] - val ) ) {

                       finalVals = [ val , dragsliderVals[1] ];

                    // ...or if the first handle is closest to our label, bring that handle.
                    } else {

                         finalVals = [ dragsliderVals[0], val ];

                    }

                    $thisdragslider.dragslider("values", finalVals);
                    selectPip.range( finalVals );

                } else {

                    $thisdragslider.dragslider("value", val );
                    selectPip.single( val );

                }

            }


            function createPip( which ) {

                var label,
                    percent,
                    number = which,
                    classes = "ui-dragslider-pip",
                    css = "";

                if ( "first" === which ) { number = 0; }
                else if ( "last" === which ) { number = pips; }

                // labelValue is the actual value of the pip based on the min/step
                var labelValue = dragslider.options.min + ( dragslider.options.step * number );

                // classLabel replaces any decimals with hyphens
                var classLabel = labelValue.toString().replace(".","-");

                // the actual visible label should be based on teh array if possible
                label = ( options.labels ) ? options.labels[number] : labelValue;
                if ( "undefined" === typeof(label) ) { label = ""; }

                // First Pip on the dragslider
                if ( "first" === which ) {

                    percent = "0%";

                    classes += " ui-dragslider-pip-first";
                    classes += ( "label" === options.first ) ? " ui-dragslider-pip-label" : "";
                    classes += ( false === options.first ) ? " ui-dragslider-pip-hide" : "";

                // Last Pip on the dragslider
                } else if ( "last" === which ) {

                    percent = "100%";

                    classes += " ui-dragslider-pip-last";
                    classes += ( "label" === options.last ) ? " ui-dragslider-pip-label" : "";
                    classes += ( false === options.last ) ? " ui-dragslider-pip-hide" : "";

                // All other Pips
                } else {

                    percent = ((100/pips) * which).toFixed(4) + "%";

                    classes += ( "label" === options.rest ) ? " ui-dragslider-pip-label" : "";
                    classes += ( false === options.rest ) ? " ui-dragslider-pip-hide" : "";

                }

                classes += " ui-dragslider-pip-"+classLabel;

                css = ( dragslider.options.orientation === "horizontal" ) ?
                    "left: "+ percent :
                    "bottom: "+ percent;


                // add this current pip to the collection
                return  "<span class=\""+classes+"\" style=\""+css+"\">"+
                            "<span class=\"ui-dragslider-line\"></span>"+
                            "<span class=\"ui-dragslider-label\" data-value=\""+labelValue+"\">"+ options.formatLabel(label) +"</span>"+
                        "</span>";

            }





            // we don't want the step ever to be a decimal.
            dragslider.options.pipStep = Math.round( dragslider.options.pipStep );

            // create our first pip
            collection += createPip("first");

            // for every stop in the dragslider; we create a pip.
            for( var i = 1; i < pips; i++ ) {
                if( 0 === i % dragslider.options.pipStep ) {
                    collection += createPip( i );
                }
            }

            // create our last pip
            collection += createPip("last");






            // add special classes to the pips that were set initially.

            var oldClass, newClass;

            if( dragslider.options.values ) {

                oldClass = [
                    "ui-dragslider-pip-"+dragslider.options.values[0], 
                    "ui-dragslider-pip-"+dragslider.options.values[1]
                ];

                newClass = [
                    "ui-dragslider-pip-"+dragslider.options.values[0] + " ui-dragslider-pip-selected-initial-first", 
                    "ui-dragslider-pip-"+dragslider.options.values[1] + " ui-dragslider-pip-selected-initial-second"
                ];

                collection = 
                    collection
                        .replace( oldClass[0] , newClass[0] )
                        .replace( oldClass[1] , newClass[1] );
                

            } else {

                oldClass = "ui-dragslider-pip-"+dragslider.options.value;
                newClass = "ui-dragslider-pip-"+dragslider.options.value + " ui-dragslider-pip-selected-initial";

                collection = 
                    collection
                        .replace( oldClass , newClass );

            }


            // append the collection of pips.
            dragslider.element.append( collection );


/*
            dragslider.element.on( "mouseup", ".ui-dragslider-label", function() {
                labelClick( this );
            });


            dragslider.element.on( "slide.selectPip slidechange.selectPip", function(e,ui) {

                if( ui.values ) {

                    selectPip.range( ui.values );

                } else {

                    selectPip.single( ui.value );

                }

            });
*/

        }


    };

    $.extend(true, $.ui.dragslider.prototype, extensionMethods);

})(jQuery);










// FLOATS

(function($) {

    "use strict";

    var extensionMethods = {

        float: function( settings ) {

            var dragslider = this,
                $tip,
                vals = [],
                val;

            var options = {

                handle: true,
                // false

                pips: false,
                // true

                labels: false,
                // array

                prefix: "",
                // "", string

                suffix: "",
                // "", string

                event: "slidechange slide",
                // "slidechange", "slide", "slidechange slide"

                formatLabel: function(value) {
                    return this.prefix + value + this.suffix;
                }
                // function
                // must return a value to display in the floats

            };

            $.extend( options, settings );

            if ( dragslider.options.value < dragslider.options.min ) { dragslider.options.value = dragslider.options.min; }
            if ( dragslider.options.value > dragslider.options.max ) { dragslider.options.value = dragslider.options.max; }

            if ( dragslider.options.values ) {
                if ( dragslider.options.values[0] < dragslider.options.min ) { dragslider.options.values[0] = dragslider.options.min; }
                if ( dragslider.options.values[1] < dragslider.options.min ) { dragslider.options.values[1] = dragslider.options.min; }
                if ( dragslider.options.values[0] > dragslider.options.max ) { dragslider.options.values[0] = dragslider.options.max; }
                if ( dragslider.options.values[1] > dragslider.options.max ) { dragslider.options.values[1] = dragslider.options.max; }
            }

            // add a class for the CSS
            dragslider.element
                .addClass("ui-dragslider-float")
                .find(".ui-dragslider-tip, .ui-dragslider-tip-label")
                .remove();

            // apply handle tip if settings allows.
            if ( options.handle ) {

                // if this is a range dragslider
                if ( dragslider.options.values ) {

                    if ( options.labels ) {

                        vals[0] = options.labels[ dragslider.options.values[0] - dragslider.options.min ];
                        vals[1] = options.labels[ dragslider.options.values[1] - dragslider.options.min ];

                        if ( typeof(vals[0]) === "undefined" ) {
                            vals[0] = dragslider.options.values[0];
                        }

                        if ( typeof(vals[1]) === "undefined" ) {
                            vals[1] = dragslider.options.values[1];
                        }

                    } else {

                        vals[0] = dragslider.options.values[0];
                        vals[1] = dragslider.options.values[1];

                    }

                    $tip = [
                        $("<span class=\"ui-dragslider-tip\">"+ options.formatLabel(vals[0]) +"</span>"),
                        $("<span class=\"ui-dragslider-tip\">"+ options.formatLabel(vals[1]) +"</span>")
                    ];

                // else if its just a normal dragslider
                } else {


                    if ( options.labels ) {

                        val = options.labels[ dragslider.options.value - dragslider.options.min ];

                        if ( typeof(val) === "undefined" ) {
                            val = dragslider.options.value;
                        }

                    } else {

                        val = dragslider.options.value;

                    }


                    // create a tip element
                    $tip = $("<span class=\"ui-dragslider-tip\">"+ options.formatLabel(val) +"</span>");

                }


                // now we append it to all the handles
                dragslider.element.find(".ui-dragslider-handle").each( function(k,v) {
                    $(v).append($tip[k]);
                });

            }


            if ( options.pips ) {

                // if this dragslider also has pip-labels, we"ll make those into tips, too.
                dragslider.element.find(".ui-dragslider-label").each(function(k,v) {

                    var $this = $(v),
                        val = $this.data("value"),
                        label = $this.data("value"),
                        $tip;


                    if( typeof options.labels[ val ] !== "undefined" ) {

                        label = options.labels[ val ];

                    }

                    // create a tip element
                    $tip =
                        $("<span class=\"ui-dragslider-tip-label\">" + options.formatLabel( label ) + "</span>")
                            .insertAfter( $this );

                });

            }

            // check that the event option is actually valid against our
            // own list of the dragslider's events.
            if ( options.event !== "slide" &&
                options.event !== "slidechange" &&
                options.event !== "slide slidechange" &&
                options.event !== "slidechange slide" ) {

                options.event = "slidechange slide";

            }

            // when dragslider changes, update handle tip label.
            dragslider.element.on( options.event , function( e, ui ) {

                var val;
                if ( options.labels ) {

                    val = options.labels[ui.value-dragslider.options.min];

                    if ( typeof(val) === "undefined" ) {
                        val = ui.value;
                    }

                } else {

                    val = ui.value;

                }

                $(ui.handle).find(".ui-dragslider-tip").html( options.formatLabel(val) );

            });


        }


    };

    $.extend(true, $.ui.dragslider.prototype, extensionMethods);


})(jQuery);
