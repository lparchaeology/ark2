/**
 * @author:  Mike Johnson
 * @version: v0.0.1
 *
 */

!function($) {
    'use strict';

    var sprintf = $.fn.bootstrapTable.utils.sprintf;

    $.extend($.fn.bootstrapTable.defaults, {
        switchcardview: false,
    });

    $.extend($.fn.bootstrapTable.defaults.icons, {
       thumbIcon: 'glyphicon-th-large',
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
        
        if (that.options.cardView){
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
	                    sprintf('<i class="%s %s"></i> ', this.options.iconsPrefix, this.options.icons.thumbIcon),
	                '</button>',
	            '</div>'].join('')).prependTo($btnGroup);

	    $(window).resize(function() {

	    	  if ($(this).width() < 563) {
      			$('#dime_find_list').addClass("cardViewTable");
      			$($btnGroup.find('[name="cardView"]')).addClass("active");
      			$($btnGroup.find('[name="tableView"]')).removeClass("active");
      			
      			$('tr').click(function(evt) {
			        self = $(this);
			        console.log(self);
			        ark_id = self.attr('data-unique-id');
			        map.getLayers().forEach(function(i,e,a){
			            if (i.get('name')=='yours'){
			                console.log(evt.shiftKey);
			                if(!evt.shiftKey){
			                    collection.clear();
			                }
			                if (typeof i.getSource().getFeatures == 'function') {
			                    i.getSource().getFeatures().forEach(function(i,e,a){
			                        if(i.get('ark_id').toUpperCase()==ark_id){
			                            if(self.hasClass('selected')){
			                                collection.remove(i);
			                            } else {
			                                collection.push(i);
			                            }
			                        }
			                    });
			                }
			            }
			        });
			    });
      			
	    	  }

	    	  if ($(this).width() > 563) {
				$('#dime_find_list').removeClass("cardViewTable");
				$($btnGroup.find('[name="cardView"]')).removeClass("active");
				$($btnGroup.find('[name="tableView"]')).addClass("active");
				
				$('tr').click(function(evt) {
			        self = $(this);
			        console.log(self);
			        ark_id = self.attr('data-unique-id');
			        map.getLayers().forEach(function(i,e,a){
			            if (i.get('name')=='yours'){
			                console.log(evt.shiftKey);
			                if(!evt.shiftKey){
			                    collection.clear();
			                }
			                if (typeof i.getSource().getFeatures == 'function') {
			                    i.getSource().getFeatures().forEach(function(i,e,a){
			                        if(i.get('ark_id').toUpperCase()==ark_id){
			                            if(self.hasClass('selected')){
			                                collection.remove(i);
			                            } else {
			                                collection.push(i);
			                            }
			                        }
			                    });
			                }
			            }
			        });
			    });
				
	    	  }

	    });
        
        that.$toolbar.find('button[name="tableView"]')
            .on('click', function() {
        		if (that.options.cardView){
        			$('#dime_find_list').removeClass("cardViewTable");
        			
        			$($btnGroup.find('[name="cardView"]')).removeClass("active");
        			$($btnGroup.find('[name="tableView"]')).addClass("active");
                    that.toggleView();
                    $('tr').click(function(evt) {
                        self = $(this);
                        console.log(self);
                        ark_id = self.attr('data-unique-id');
                        map.getLayers().forEach(function(i,e,a){
                            if (i.get('name')=='yours'){
                                console.log(evt.shiftKey);
                                if(!evt.shiftKey){
                                    collection.clear();
                                }
                                if (typeof i.getSource().getFeatures == 'function') {
                                    i.getSource().getFeatures().forEach(function(i,e,a){
                                        if(i.get('ark_id').toUpperCase()==ark_id){
                                            if(self.hasClass('selected')){
                                                collection.remove(i);
                                            } else {
                                                collection.push(i);
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    });
        		}
            });
        
        that.$toolbar.find('button[name="cardView"]')
        	.on('click', function() {
        		if (! that.options.cardView){
        			$('#dime_find_list').addClass("cardViewTable");
        		    
        			$($btnGroup.find('[name="cardView"]')).addClass("active");
        			$($btnGroup.find('[name="tableView"]')).removeClass("active");
                    that.toggleView();
        		}
            });
    };

}(jQuery);
