<?php 
$classtypes = array();
foreach ($fields as $field){
    $classtypes[$field['dataclass']][getClassType($field['dataclass'], $field['classtype'])]=$field['classtype'];
}
?>
<script>

$(document).ready(function() {
	$('.add_option').toggle();
	var classtypes = {
			<?php 
			foreach ($classtypes as $key => $classtype){
                echo '"'.$key.'":{';
                foreach ($classtype as $key => $val){
                    echo '"'.$key.'":"'.$val.'",';
                }
                echo '},';
            }
			?>
			};
    console.log(classtypes);
	$('#addExistingLayer').data('classtypes',classtypes);
    $('#addExistingLayer').change(function(){
        var apiquery = "api.php?req=getFrags&dataclass=all&itemkey=cor_tbl_maplayer&cor_tbl_maplayer=".concat($(this).val());
    	var vararkreq = $.get(apiquery,function() {
    		}).always(function(response) {
                for (responses in response){
                    var object = response[responses];
                    var frags = object['0'];
                    for (id in frags){
                        var frag = frags[id];
                        var dataclass = frag.dataclass;
                        console.log(dataclass);
                        var classtype =frag[dataclass+'type'];
                        console.log(classtype);
                        $('#'+($('#addExistingLayer').data('classtypes')[dataclass][classtype])).val(frag[dataclass]);
                    }
                }
    		});
    });
    $('#add_layer').click(function(){
		$('form#<?php echo $sf_conf['sf_html_id']?>').submit();
    });
});

</script>
