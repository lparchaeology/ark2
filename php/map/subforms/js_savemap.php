<?php
?>
<script>
$(document).ready(function() {
    map=window.parent.map<?php echo $map['id']; ?>;
	var center = map.getView().getCenter().join(",");
	$('textarea[name=mapcenter]').val('['+center+']');
	projections = $('input[name=mapcenter]')
	$("select[name=projection] option").filter(function() {
	    return this.text == map.getView().getProjection().getCode(); 
	}).attr('selected', true);
	$('input[name=zoomlevel]').val(map.getView().getZoom());
	$('input[name=map_alias]').val($('#allMaps option:selected').text());
	$('#allMaps').on('change',function(e) {
		   $('input[name=map_alias]').val($('#allMaps option:selected').text());
		if ($('#allMaps option:selected').val()!='new'){
		    $("input[name=projection_qtype]").val('edt');
		    $("input[name=zoomlevel_qtype]").val('edt');
		    $("input[name=mapcenter_qtype]").val('edt');
		} else {
		    $("input[name=projection_qtype]").val('add');
		    $("input[name=zoomlevel_qtype]").val('add');
		    $("input[name=mapcenter_qtype]").val('add');
		}
	});
	$('.close').click(function(e) {
        e.preventDefault();
        linkurl = e.target.href;
        window.parent.location.href = linkurl;
    });
});

</script>
