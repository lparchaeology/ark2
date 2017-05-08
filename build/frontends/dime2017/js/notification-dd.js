$(document).ready(function(){
    $('.dropdown-menu .markasread').click(function(e) {
        e.stopPropagation();
        
        console.log($(e.target).attr('message'));
        console.log($(e.target).attr('recipient'));
        
        var payload = JSON.stringify({"message":$(e.target).attr('message'),"recipient":$(e.target).attr('recipient')});
        
        $.post($(e.target).attr('href'), payload)
        .fail(function() {
            alert('fail');
        })
        .done(function(data) {
          var response = data.data;
          $(e.target).closest('li').remove();
          var newcount = parseInt($(".notification-dropdown-header .count").html())-1;
          $(".notification-dropdown-header .count").html(newcount);
          if( newcount ==0 ){
              $('.icon-new-notification').addClass('icon-notification').removeClass('icon-new-notification').removeClass('wide');
          }
        });
    });
});
