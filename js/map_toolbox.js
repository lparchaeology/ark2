$(document).ready(function() {
	$('#toolbox').data('open',false);
	$('.tools').on('click', function(evt) {
		console.log($('#toolbox').data('open'));
		if($(evt.target).parent().hasClass('tools')){
			if($('#toolbox').data('open')){
				$('#toolbox').data('open',false);
				closeToolBox();
			} else {
				$('#toolbox').data('open',true);
				distributetools();
			}
		}
	});
	
	$('.panel').on('click',function(evt) {
		var target = $( this );
		if(!target.hasClass('interaction')){
			closeOtherTools(target);
		}
		var sf_selector = '#sf_'+this.id.split("_")[0];
		console.log(target.css('left'));
		console.log(target.css('left')+16);
		$(sf_selector).css('left',(target.css('left')));
		$(sf_selector).css('bottom',(target.css('bottom')));
		$(sf_selector).toggle();
	});
	
});

function closeToolBox(){
	var tools = $('.tool');
	tools.each(function() {
		var sf_selector = '#sf_'+this.id.split("_")[0];
	    $(this).animate({
	        left: '10px',
	        bottom: '16px'
	    },500);
		//$(sf_selector).hide(400);
	});
	setTimeout(function () { 
		$('#toolbox').toggle();
    },500);
}

function closeOtherTools(target){
	var tools = $('.tool');
	tools.each(function() {
		if (!$( this ).is(target)&&!($(this).hasClass('active'))){
			var sf_selector = '#sf_'+this.id.split("_")[0];
			$(sf_selector).hide();
		}
	});
}

function distributetools() {
	$('#toolbox').toggle();
	var tools = $('.tool'),
	angle = 0;
	step = (1/2*Math.PI) / tools.length,
	radius = (32+(32*tools.length));
	angle += (1/2*step);
	tools.each(function() {
		var x = Math.round(radius * Math.cos(angle));
		var y = Math.round(radius * Math.sin(angle));
		if(window.console) {
			console.log($(this).text(), x, y);
		}
		$(this).animate({
			left: y + 'px',
			bottom: x + 'px'
		},500);
		angle += step;
	});
}