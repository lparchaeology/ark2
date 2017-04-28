/**
 * 
 * @author: Mike Johnson
 * 
 * Adapted from bootstrap-table-mobile:
 * @author: Dennis Hernández
 * @webSite: http://djhvscf.github.io/Blog
 * @version: v1.1.0
 */

!function ($) {

    'use strict';

    var showHideColumns = function (that, checked) {
        if (that.options.columnsHidden.length > 0 ) {
            $.each(that.columns, function (i, column) {
                if (that.options.columnsHidden.indexOf(column.field) !== -1) {
                    if (column.visible !== checked) {
                        that.toggleColumn($.fn.bootstrapTable.utils.getFieldIndex(that.columns, column.field), checked, true);
                    }
                }
            });
        }
    };

    var resetView = function (that) {
        if (that.options.height || that.options.showFooter) {
            setTimeout(function(){
                that.resetView.call(that);
            }, 1);
        }
    };
    
    var currentView = function ( that ) {
        if(that.$toolbar.find('button[name="tableView"]').hasClass('active')){
            return 'tableView';
        } else if(that.$toolbar.find('button[name="cardView"]').hasClass('active')){
            return 'cardView';
        } else {
            return 'thumbView';
        }
    };

    var changeView = function (that, width, height) {
        if (that.options.minHeight) {
            if ((width <= that.options.minWidth) && (height <= that.options.minHeight)) {
                that.$toolbar.find('button[name="tableView"]').addClass('disabled');
                switch (currentView( that )) {
                    case 'tableView':
                        conditionCardView(that);
                        break;
                    case 'cardView':
                        conditionCardView(that);
                        break;
                    case 'thumbView':
                        conditionThumbView(that);
                        break;
                }
            } else if ((width > that.options.minWidth) && (height > that.options.minHeight)) {
                that.$toolbar.find('button[name="tableView"]').removeClass('disabled');
                switch (currentView( that )) {
                    case 'tableView':
                        conditionTableView(that);
                        break;
                    case 'cardView':
                        conditionCardView(that);
                        break;
                    case 'thumbView':
                        conditionThumbView(that);
                        break;
                }
            }
        } else {
            if (width <= that.options.minWidth) {
                that.$toolbar.find('button[name="tableView"]').addClass('disabled');
                switch (currentView( that )) {
                    case 'tableView':
                        conditionCardView(that);
                        break;
                    case 'cardView':
                        conditionCardView(that);
                        break;
                    case 'thumbView':
                        conditionthumbView(that);
                        break;
                }
            } else if (width > that.options.minWidth) {
                that.$toolbar.find('button[name="tableView"]').removeClass('disabled');
                switch (currentView( that )) {
                    case 'tableView':
                        conditionTableView(that);
                        break;
                    case 'cardView':
                        conditionCardView(that);
                        break;
                    case 'thumbView':
                        conditionThumbView(that);
                        break;
                }
            }
        }

        resetView(that);
    };

    var conditionCardView = function (that) {
        that.$toolbar.find('button[name="cardView"]').click();
    };

    var conditionThumbView = function (that) {
        that.$toolbar.find('button[name="thumbView"]').click();
    };
    
    var conditionTableView = function (that) {
        that.$toolbar.find('button[name="tableView"]').click();
    };

    /*
    var changeTableView = function (that, cardViewState) {
        that.options.cardView = cardViewState;
        that.toggleView();
    };
    */

    var debounce = function(func,wait) {
        var timeout;
        return function() {
            var context = this,
                args = arguments;
            var later = function() {
                timeout = null;
                func.apply(context,args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

    $.extend($.fn.bootstrapTable.defaults, {
        mobileResponsive: false,
        minWidth: 562,
        minHeight: undefined,
        heightThreshold: 100, // just slightly larger than mobile chrome's auto-hiding toolbar
        checkOnInit: true,
        columnsHidden: []
    });

    var BootstrapTable = $.fn.bootstrapTable.Constructor,
        _init = BootstrapTable.prototype.init;

    BootstrapTable.prototype.init = function () {
        _init.apply(this, Array.prototype.slice.apply(arguments));

        if (!this.options.mobileResponsive) {
            return;
        }

        if (!this.options.minWidth) {
            return;
        }

        if (this.options.minWidth < 100 && this.options.resizable) {
            console.log("The minWidth when the resizable extension is active should be greater or equal than 100");
            this.options.minWidth = 100;
        }

        var that = this,
            old = {
                width: $('.bootstrap-table').width(),
                height: $('.bootstrap-table').height()
            };

        $(window).on('resize orientationchange',debounce(function (evt) {
            // reset view if height has only changed by at least the threshold.
            var height = $('.bootstrap-table').height(),
                width = $('.bootstrap-table').width();
            
            if (Math.abs(old.height - height) > that.options.heightThreshold || old.width != width) {
                changeView(that, width, height);
                old = {
                    width: width,
                    height: height
                };
            }
            
        },200));
        
        if (this.options.checkOnInit) {
            var height = $('.bootstrap-table').height(),
                width = $('.bootstrap-table').width();
            changeView(this, width, height);
            old = {
                width: width,
                height: height
            };
        }
    };
}(jQuery);
