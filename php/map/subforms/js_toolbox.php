<?php ?>
<script type\"text/javascript\">

$(document).ready(function() {
	$('#toolbox').data('open',false);
	$('.tools').on('click', function(evt) {
		console.log($('#toolbox').data('open'));
		//createFields();
		if($('#toolbox').data('open')){
			$('#toolbox').data('open',false);
			$('#toolbox').toggle("slow");
			var tools = $('.tool');
			tools.each(function() {
			    $(this).animate({
			        left: '10px',
			        bottom: '16px'
			    },500);
			});
		} else {
			$('#toolbox').toggle("slow");
			distributetools();
			console.log
			$('#toolbox').data('open',true);
		}
	})
});

function distributetools() {
	var tools = $('.tool'),
	angle = 0;
	step = (1/2*Math.PI) / tools.length,
	radius = (20+(20*tools.length));
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

</script>
