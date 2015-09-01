$(function() {

  $("#finds_table")
    .tablesorter({
    });
  
  $(document).ready(function(){
  
	  $("td").dblclick(function () {
		  var $this = $(this),
		  header = $this.closest('table').find('th').eq($this.index()),
		  OriginalContent = $this.text();
	  
		  console.log(header.attr('id'));
      
		  $this.addClass("cellEditing");
		  $this.html("<input type='text' value='" + OriginalContent + "' />");
		  $this.children().first().focus();
      

		  $(this).children().first().keypress(function (e) {
			  if (e.which == 13) {
				  var newContent = $(this).val();
				  $(this).parent().text(newContent);
				  $(this).parent().removeClass("cellEditing");
				  console.log(newContent);
				  console.log($this.attr('id'));
				  console.log($this.closest('table').find('th').eq($this.index()));
			  }
		  });
       
		  $(this).children().first().blur(function(){
			  $(this).parent().text(OriginalContent);
			  $(this).parent().removeClass("cellEditing");
		  });
	  });
  });
});