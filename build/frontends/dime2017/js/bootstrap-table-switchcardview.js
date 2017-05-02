/**
 * @author:  Mike Johnson
 * @version: v0.0.1
 *
 */

! function($) {
    'use strict';

    var sprintf = $.fn.bootstrapTable.utils.sprintf;

    $.extend($.fn.bootstrapTable.defaults, {
        switchcardview: false,
    });

    $.extend($.fn.bootstrapTable.defaults.icons, {
        cardIcon: 'glyphicon-th-large',
        thumbIcon: 'glyphicon-th',
        listIcon: 'glyphicon-menu-hamburger'
    });

    var BootstrapTable = $.fn.bootstrapTable.Constructor,
        _initToolbar = BootstrapTable.prototype.initToolbar;

    BootstrapTable.prototype.initToolbar = function() {
        _initToolbar.apply(this, Array.prototype.slice.apply(arguments));

        if (!this.options.switchcardview) {
            return;
        }

        var that = this,
            $btnGroup = this.$toolbar.find('>.btn-group');

        if (that.options.cardView) {
            var cardActive = " active";
            var listActive = "";
        } else {
            var cardActive = "";
            var listActive = " active";
        }

        $($btnGroup.find('[name="toggle"]')).remove();

        $([
            '<div class="export btn-group">',
            '<button class="btn' +
            sprintf(' btn-%s', this.options.buttonsClass) +
            sprintf(' btn-%s', this.options.iconSize) +
            listActive +
            '" name="tableView" ' +
            'type="button">',
            sprintf('<i class="%s %s"></i> ', this.options.iconsPrefix, this.options.icons.listIcon),
            '</button>',
            '<button class="btn' +
            sprintf(' btn-%s', this.options.buttonsClass) +
            sprintf(' btn-%s', this.options.iconSize) +
            cardActive +
            '" name="cardView" ' +
            ' type="button">',
            sprintf('<i class="%s %s"></i> ', this.options.iconsPrefix, this.options.icons.cardIcon),
            '</button>',
            '<button class="btn' +
            sprintf(' btn-%s', this.options.buttonsClass) +
            sprintf(' btn-%s', this.options.iconSize) +
            cardActive +
            '" name="thumbView" ' +
            ' type="button">',
            sprintf('<i class="%s %s"></i> ', this.options.iconsPrefix, this.options.icons.thumbIcon),
            '</button>',
            '</div>'
        ].join('')).prependTo($btnGroup);
        
        var mapclick = function(target) {
            alert("click");
                console.log(target);
                //ark_id = self.attr('data-unique-id');
                map.getLayers().forEach(function(i, e, a) {
                    if (i.get('name') == 'yours') {
                        console.log(evt.shiftKey);
                        if (!evt.shiftKey) {
                            collection.clear();
                        }
                        if (typeof i.getSource().getFeatures == 'function') {
                            i.getSource().getFeatures().forEach(function(i, e, a) {
                                if (i.get('ark_id').toUpperCase() == ark_id) {
                                    if (self.hasClass('selected')) {
                                        collection.remove(i);
                                    } else {
                                        collection.push(i);
                                    }
                                }
                            });
                        }
                    }
                });
        };
        
        var thumbclick = function(target) {
            
            console.log(target);
            self = $(target);
            console.log(self);
            //ark_id = self.attr('data-unique-id');
            map.getLayers().forEach(function(i, e, a) {
                if (i.get('name') == 'yours') {
                    console.log(evt.shiftKey);
                    if (!evt.shiftKey) {
                        collection.clear();
                    }
                    if (typeof i.getSource().getFeatures == 'function') {
                        i.getSource().getFeatures().forEach(function(i, e, a) {
                            if (i.get('ark_id').toUpperCase() == ark_id) {
                                if (self.hasClass('selected')) {
                                    collection.remove(i);
                                } else {
                                    collection.push(i);
                                }
                            }
                        });
                    }
                }
            });
    };

        that.$toolbar.find('button[name="tableView"]')
            .on('click', function() {
                $(this).blur();
                
                if($(this).hasClass('disabled')){
                    return false;
                }
                
                if ( $($btnGroup.find('[name="tableView"]')).hasClass("active") == false ) {
                    $('#dime_find_list').removeClass("cardViewTable");
                    $('#dime_find_home').removeClass("cardViewTable");
                    $('#dime_find_list').removeClass("thumbViewTable");
                    $('#dime_find_home').removeClass("thumbViewTable");

                    console.log(that.options.cardView);
                    
                    if( $($btnGroup.find('[name="thumbView"]')).hasClass("active") ){
                        that.toggleView();
                    }

                    $($btnGroup.find('[name="cardView"]')).removeClass("active");
                    $($btnGroup.find('[name="thumbView"]')).removeClass("active");
                    $($btnGroup.find('[name="tableView"]')).addClass("active");

                    $('tr').on("click", {"target":this}, mapclick );
                }
            });

        that.$toolbar.find('button[name="thumbView"]')
            .on('click', function() {
                $(this).blur();
                if( $($btnGroup.find('[name="thumbView"]')).hasClass("active") == false ){

                    that.toggleView();

                    $('#dime_find_list').addClass("thumbViewTable");
                    $('#dime_find_home').addClass("thumbViewTable");
                    $('#dime_find_list').removeClass("cardViewTable");
                    $('#dime_find_home').removeClass("cardViewTable");

                    $($btnGroup.find('[name="thumbView"]')).addClass("active");
                    $($btnGroup.find('[name="cardView"]')).removeClass("active");
                    $($btnGroup.find('[name="tableView"]')).removeClass("active");
                    
                    $('tr').on("click", {"target":this}, thumbclick );

                }
            });

        that.$toolbar.find('button[name="cardView"]')
        .on('click', function() {
            $(this).blur();
            that.$toolbar.find('button[name="tableView"]').blur();
            that.$toolbar.find('button[name="thumbView"]').blur();
            
            if( $($btnGroup.find('[name="cardView"]')).hasClass("active") == false ){

                if( $($btnGroup.find('[name="thumbView"]')).hasClass("active") ){
                    that.toggleView();
                }

                $('#dime_find_list').addClass("cardViewTable");
                $('#dime_find_home').addClass("cardViewTable");
                $('#dime_find_list').removeClass("thumbViewTable");
                $('#dime_find_home').removeClass("thumbViewTable");

                $($btnGroup.find('[name="cardView"]')).addClass("active");
                $($btnGroup.find('[name="thumbView"]')).removeClass("active");
                $($btnGroup.find('[name="tableView"]')).removeClass("active");
                

                $('tr').on("click", {"target":this}, mapclick );
                
            }
        });
        
        $(document).ready(function (){
            that.$toolbar.find('button[name="tableView"]').click();
            that.$toolbar.find('button[name="cardView"]').click();
        });
        

    };

}(jQuery);
