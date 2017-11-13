/**
 *
 * @author: Mike Johnson
 *
 * Adapted from bootstrap-table-mobile:
 * @author: Dennis Hernández
 * @webSite: http://djhvscf.github.io/Blog
 * @version: v1.1.0
 */

! function ($) {

    'use strict';

    var conditionCardView = function (that) {
        that.$toolbar.find('button[name="cardView"]').click();
    };

    var conditionThumbView = function (that) {
        that.$toolbar.find('button[name="thumbView"]').click();
    };

    var conditionTableView = function (that) {
        that.$toolbar.find('button[name="tableView"]').click();
    };

    var showHideColumns = function (that, checked) {
        if (that.options.columnsHidden.length > 0) {
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
            setTimeout(function () {
                that.resetView.call(that);
            }, 1);
        }
    };

    var currentView = function (that) {
        if (that.$toolbar.find('button[name="tableView"]').hasClass('active')) {
            return 'tableView';
        } else if (that.$toolbar.find('button[name="cardView"]').hasClass('active')) {
            return 'cardView';
        } else {
            return 'thumbView';
        }
    };

    var changeView = function (that, width, height) {

        var oldView = currentView(that);

        if (oldView !== 'tableView') {
            $('#dime_find_table').removeClass("cardViewTable");
            $('#dime_find_home').removeClass("cardViewTable");
            $('#dime_find_table').removeClass("thumbViewTable");
            $('#dime_find_home').removeClass("thumbViewTable");
            if (oldView === 'thumbView') {
                that.toggleView();
            }
            that.$toolbar.find('button').removeClass('active');
        }

        var thatClientWidth = $('.table-wrapper-div .fixed-table-body')[0].clientWidth;
        var thatScrollWidth = $('.table-wrapper-div .fixed-table-body')[0].scrollWidth;

        var overflowWide = thatClientWidth < thatScrollWidth;

        if (that.options.minHeight) {
            if (width <= that.options.minWidth && height <= that.options.minHeight) {
                that.$toolbar.find('button[name="tableView"]').addClass('disabled');
                switch (oldView) {
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
            } else if (width > that.options.minWidth && height > that.options.minHeight) {
                that.$toolbar.find('button[name="tableView"]').removeClass('disabled');
                switch (oldView) {
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
            if (overflowWide) {
                that.$toolbar.find('button[name="tableView"]').addClass('disabled');
                switch (oldView) {
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
            } else {
                that.$toolbar.find('button[name="tableView"]').removeClass('disabled');
                switch (oldView) {
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

    $.extend($.fn.bootstrapTable.defaults, {
        locale: lang,
        mobileResponsive: false,
        minWidth: 562,
        minHeight: undefined,
        heightThreshold: 100, // just slightly larger than mobile chrome's auto-hiding toolbar
        checkOnInit: true,
        columnsHidden: [],
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
            //console.log("The minWidth when the resizable extension is active should be greater or equal than 100");
            this.options.minWidth = 100;
        }

        var that = this,
            old = {
                width: $('.bootstrap-table').width(),
                height: $('.bootstrap-table').height(),
            };

        $(window).on('resize orientationchange', debounce(function (evt) {
            // reset view if height has only changed by at least the threshold.
            var height = $('.bootstrap-table').height(),
                width = $('.bootstrap-table').width();

            if (Math.abs(old.height - height) > that.options.heightThreshold || old.width !== width) {
                changeView(that, width, height);
                old = {
                    width: width,
                    height: height,
                };
            }

        }, 200));

        if (this.options.checkOnInit) {
            var height = $('.bootstrap-table').height(),
                width = $('.bootstrap-table').width();
            changeView(this, width, height);
            old = {
                width: width,
                height: height,
            };
        }

        $('.bootstrap-table').on('column-switch.bs.table', function () {
            var height = $('.bootstrap-table').height(),
                width = $('.bootstrap-table').width();

            changeView(that, width, height);
            return true;
        });

    };
}(jQuery);
