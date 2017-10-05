$(document).ready(function () {
    
    $(".add-module-selector").on("click",function(){
        console.log({"data":$(this).attr("data-module")});
        $(".record-add-form").hide()
        $(".record-add-form").filter("."+$(this).attr("data-module")).show();
    });
    
});