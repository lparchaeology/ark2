/*--------------------------------------------------------------------
	Common Javascript
--------------------------------------------------------------------*/


/*--- Mobile Nav ---*/
$(document).ready(function() {

    // Toggle Nav
	var menubtn		= $('.menubtn');
		menu 			= $('nav.sidemenu');
		menuHeight		= menu.height();
	
	$(menubtn).on('click', function(e) {
		e.preventDefault();
		self = $(this).attr('id');
		$('#'+self+'_nav').slideToggle(300);
	});
	
	$('#drawer_1 h1').on('click', function(e) {
		e.preventDefault();
		$('#drawer_1').slideToggle(300);
	});
	
	$(".colorbox").colorbox({iframe:true, width:"900px", height:"50%",  onClosed:function() { location.reload(true); }});
	$(".cboxlarge").colorbox({iframe:true, width:"65%", height:"80%", onClosed:function() { location.reload(true); }});
	$(".imagebox").colorbox({rel:'group', maxWidth:'95%', maxHeight:'95%'});
	
	$('.rrssb-buttons a.popup').on('click', function(e){
		var _this = jQuery(this);
		popupCenter(_this.attr('href'), _this.find('.text').html(), 580, 470);
		e.preventDefault();
	});

});

/*--- LP Additions ---*/
$(document).ready(function() {
	qst = parseQst(String(window.location))
	col_id =reqQst('col_id',qst);
	sf_id=reqQst('sf_id',qst);
	if (col_id && sf_id){
		col = $(".main_mcrview").children().eq(col_id);
		sf = col.children().eq(sf_id);
		if(typeof sf.offset() !== 'undefined'){
			targetOffset = sf.offset().top - 70;
			$('html,body').animate({
				scrollTop: targetOffset
			});
		}
	}
    $("a.svtogl").click(function(e) {
		e.preventDefault();
    	if (confirm("Unsaved data will be lost!")){
    		window.location = $(this).attr('href');
        }
    });
    $("a.saveattr").change(function(e) {
    	e.preventDefault();
        e.submit();
    });
    $("a.helptogl").click(function(e) {
        e.preventDefault();
        var help_id = $(this).attr('name');
        helptray = $('#'+help_id+'_help');
        console.log('#'+help_id+'_help');
		helptrayHeight	= helptray.height();
		console.log(helptray);
        helptray.toggle();
    });
});
$(document).ready(function(){
    $("[name='checkedby']").change(function(){
    	$(this).parent().submit();
    });
});


