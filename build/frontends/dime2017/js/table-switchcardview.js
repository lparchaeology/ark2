/**
 * @author:  Mike Johnson
 * @version: v0.0.1
 *
 */

! function ($) {

    'use strict';

    var sprintf = $.fn.bootstrapTable.utils.sprintf;

    $.extend($.fn.bootstrapTable.defaults, {
        locale: lang,
        switchcardview: false,
    });

    $.extend($.fn.bootstrapTable.defaults.icons, {
        cardIcon: 'glyphicon-th-large',
        thumbIcon: 'glyphicon-th',
        listIcon: 'glyphicon-menu-hamburger',
    });

    // Overide the default Table Export settings
    // In an ideal world this would be somewhere else
    $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales[lang]);
    $.extend($.fn.bootstrapTable.defaults, {
        exportTypes: ['csv'],
        exportOptions: {
            csvEnclosure: Translator.trans('core.csv.enclosure.default'),
            csvSeparator: Translator.trans('core.csv.separator.default'),
            fileName: Translator.trans('core.csv.filename.default'),
        },
    });

    var BootstrapTable = $.fn.bootstrapTable.Constructor,
        _initToolbar = BootstrapTable.prototype.initToolbar;

    BootstrapTable.prototype.initToolbar = function () {
        _initToolbar.apply(this, Array.prototype.slice.apply(arguments));

        var cardActive = "";
        var listActive = "";
        var that = this;
        var $btnGroup = this.$toolbar.find('>.btn-group');

        var removeTextSelection = function removeTextSelection() {
            var sel = window.getSelection ? window.getSelection() : document.selection;
            if (sel) {
                if (sel.removeAllRanges) {
                    sel.removeAllRanges();
                } else if (sel.empty) {
                    sel.empty();
                }
            }
        };

        var createItemModal = function createItemModal(item, fields) {
            var html = '<div id="modalWindow" class="modal fade in" style="display:none;" data-backdrop="false">';
            html += '<div class="modal-dialog thumbmodal-container dime" tabindex="-1" >';
            // html += '<div class="modal-header">';
            html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
            html += '<span aria-hidden="true">&times;</span>';
            html += '</button>';
            html += '<div class="modal-body thumbModal">';
            for (var field in fields) {
                html += '<div class="field">';
                if (fields[field].field !== 'checked') {
                    if (fields[field].field === 'image') {
                        html += item[fields[field].field].replace('/img/thumb.', '/img/');
                        //html += item[fields[field].field];
                    } else {
                        html += item[fields[field].field];
                    }
                }
                html += '</div>';
            }
            html += '</div>';
            html += '</div>'; // modalWindow

            $("#thumbModal").html(html);
            $("#modalWindow").modal();
            /*
            $('#modalWindow').on('hidden.bs.modal', function () {
                $('tbody tr').removeClass('selected');
                mapcollection.clear();
            });
            */
        };

        var formclick = function (evt) {
            var self = '';
            var ark_id = '';

            removeTextSelection();
            if ($(evt.target).is('a')) {
                return true;
            }

            if ($(evt.target).is('tr')) {
                self = $(evt.target);
            } else {
                self = $(evt.target).closest('tr');
            }
            ark_id = self.attr('data-unique-id');

            if (self.hasClass('selected')) {
                self.removeClass('selected');
                self.find('.tablecheckbox').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
            } else {
                self.addClass('selected');
                self.find('.tablecheckbox').removeClass('glyphicon-unchecked').addClass('glyphicon-check');

            }

        };

        var mapselect = function (item, ark_id) {

            if (typeof mapcollection === 'undefined') {
                if (item.hasClass('selected')) {
                    item.removeClass('selected');
                    item.find('.tablecheckbox').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
                } else {
                    item.addClass('selected');
                    item.find('.tablecheckbox').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
                }
                return true;
            }

            map.getLayers().forEach(function (i, e, a) {
                if (i.get('name') === 'finds') {
                    if (typeof i.getSource().getFeatures === 'function') {
                        i.getSource().getFeatures().forEach(function (i, e, a) {
                            if (i.get('ark_id').toUpperCase() === ark_id) {
                                if (item.hasClass('selected')) {
                                    mapcollection.remove(i);
                                } else {
                                    mapcollection.push(i);
                                }
                            }
                        });
                    }
                }
            });
        }

        var mapclick = function (evt, row, $element) {
            var self = '';
            var ark_id = '';

            removeTextSelection();
            if ($(evt.target).is('a')) {
                return true;
            }

            if ($(evt.target).hasClass('icon-user-focus')) {
                return true;
            }

            if ($(evt.target).is('tr')) {
                self = $(evt.target);
            } else {
                self = $(evt.target).closest('tr');
            }

            ark_id = self.attr('data-unique-id');

            if (typeof window.selected === 'undefined') {
                window.selected = [];
            }

            if (self.hasClass('selected')) {
                window.selected = window.selected.filter(function (e) { return e !== ark_id; });
            } else {
                window.selected.push(ark_id);
            }
            mapselect(self, ark_id);

        };

        window.thumbclick = function (evt) {
            var self = '';

            if ($(evt.target).is('tr')) {
                self = $(evt.target);
            } else {
                self = $(evt.target).closest('tr');
            }

            var self = '';
            var ark_id = '';

            removeTextSelection();
            if ($(evt.target).is('a')) {
                return true;
            }

            if ($(evt.target).hasClass('icon-user-focus')) {
                return true;
            }

            if ($(evt.target).is('tr')) {
                self = $(evt.target);
            } else {
                self = $(evt.target).closest('tr');
            }
            ark_id = self.attr('data-unique-id');

            if (typeof window.selected === 'undefined') {
                window.selected = [];
            }

            if (self.hasClass('selected') != true) {
                window.selected.push(ark_id);
                mapselect(self, ark_id);
            } else {
                window.selected = window.selected.filter(function (e) { return e !== ark_id; });
            }
            createItemModal(that.data[self.data('index')], that.columns);

        };

        var sortSelection = function (clickfunc) {
            var ark_id = '';

            $('tbody').off("click", 'tr');
            $('tbody').on("click", 'tr', { "target": this }, clickfunc);

            if (typeof mapcollection !== 'undefined') {
                mapcollection.forEach(function (e, i, a) {
                    ark_id = e.get('ark_id');
                    $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").addClass('selected');
                });
            } else if (typeof window.selected !== 'undefined') {
                window.selected.forEach(function (ark_id) {
                    $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").addClass('selected')
                    $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").find('.tablecheckbox').removeClass('glyphicon-unchecked').addClass('glyphicon-check');

                });
            }
        };

        if (!this.options.switchcardview) {
            return;
        }

        if (that.options.cardView) {
            cardActive = " active";
        } else {
            listActive = " active";
        }

        $($btnGroup.find('[name="toggle"]')).remove();

        $([
            '<div class="export btn-group">',
            '<button class="btn'
            + sprintf(' btn-%s', this.options.buttonsClass)
            + sprintf(' btn-%s', this.options.iconSize)
            + listActive
            + '" name="tableView" '
            + 'type="button">',
            sprintf('<i class="%s %s"></i> ', this.options.iconsPrefix, this.options.icons.listIcon),
            '</button>',
            '<button class="btn'
            + sprintf(' btn-%s', this.options.buttonsClass)
            + sprintf(' btn-%s', this.options.iconSize)
            + cardActive
            + '" name="cardView" '
            + ' type="button">',
            sprintf('<i class="%s %s"></i> ', this.options.iconsPrefix, this.options.icons.cardIcon),
            '</button>',
            '<button class="btn'
            + sprintf(' btn-%s', this.options.buttonsClass)
            + sprintf(' btn-%s', this.options.iconSize)
            + cardActive
            + '" name="thumbView" '
            + ' type="button">',
            sprintf('<i class="%s %s"></i> ', this.options.iconsPrefix, this.options.icons.thumbIcon),
            '</button>',
            '</div>'
        ].join('')).prependTo($btnGroup);

        $(document).ready(function () {


            console.log($('#map').length);
            if ($('#map').length) {
                window.tableclick = mapclick;
            } else {
                window.tableclick = formclick;
            }

            sortSelection(window.tableclick);

            that.$toolbar.find('button[name="tableView"]').on('click', function () {
                $(this).blur();

                if ($(this).hasClass('disabled')) {
                    return false;
                }

                if ($($btnGroup.find('[name="tableView"]')).hasClass("active") === false) {
                    $('.dime-table').removeClass("cardViewTable");
                    $('.dime-table').removeClass("thumbViewTable");

                    if ($($btnGroup.find('[name="thumbView"]')).hasClass("active")) {
                        that.toggleView();
                    }

                    $($btnGroup.find('[name="cardView"]')).removeClass("active");
                    $($btnGroup.find('[name="thumbView"]')).removeClass("active");
                    $($btnGroup.find('[name="tableView"]')).addClass("active");

                    sortSelection(window.tableclick);
                }
            });

            that.$toolbar.find('button[name="thumbView"]').on('click', function () {
                $(this).blur();
                if ($($btnGroup.find('[name="thumbView"]')).hasClass("active") === false) {

                    that.toggleView();

                    $('.dime-table').addClass("thumbViewTable");
                    $('.dime-table').removeClass("cardViewTable");

                    $($btnGroup.find('[name="thumbView"]')).addClass("active");
                    $($btnGroup.find('[name="cardView"]')).removeClass("active");
                    $($btnGroup.find('[name="tableView"]')).removeClass("active");

                    sortSelection(window.thumbclick);

                }
            });

            that.$toolbar.find('button[name="cardView"]').on('click', function () {
                $(this).blur();
                that.$toolbar.find('button[name="tableView"]').blur();
                that.$toolbar.find('button[name="thumbView"]').blur();

                if ($($btnGroup.find('[name="cardView"]')).hasClass("active") === false) {
                    if ($($btnGroup.find('[name="thumbView"]')).hasClass("active")) {
                        that.toggleView();
                    }

                    $('.dime-table').addClass("cardViewTable");
                    $('.dime-table').removeClass("thumbViewTable");

                    $($btnGroup.find('[name="cardView"]')).addClass("active");
                    $($btnGroup.find('[name="thumbView"]')).removeClass("active");
                    $($btnGroup.find('[name="tableView"]')).removeClass("active");

                    sortSelection(window.tableclick);

                }
            });

            $('td').off("click");

            if (window.itemkey !== 'actor') {
                that.$toolbar.find('button[name="cardView"]').click();
            }

            $('th').on('click', function (e) {
                window.setTimeout(function () {
                    $('tbody').off("click", 'tr');
                    $('tbody').on("click", 'tr', { "target": this }, window.tableclick);

                    if (typeof mapcollection !== 'undefined') {
                        mapcollection.forEach(function (e, i, a) {
                            var ark_id = e.get('ark_id');
                            $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").addClass('selected');
                        });
                    } else if (typeof window.selected !== 'undefined') {
                        window.selected.forEach(function (ark_id) {
                            $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").addClass('selected');
                            $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").find('.tablecheckbox').removeClass('glyphicon-unchecked').addClass('glyphicon-check');

                        });
                    }
                }, 300);

            });

        });
    };

}(jQuery);
