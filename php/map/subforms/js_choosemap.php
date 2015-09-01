<?php
?>
<script>
$(document).ready(function() {
    $('.maplink').click(function(e) {
        e.preventDefault();
        linkurl = e.target.href;
        window.parent.location.href = linkurl;
    });
});
</script>
