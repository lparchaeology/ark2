$(document).ready(function(){
    $('.dropdown-menu .markasread').click(function(e) {
        e.stopPropagation();
        alert($(e.target).attr('href'));
        /*
         * ajax to mark as read here -
         */
        //on success
        $(e.target).closest('li').remove();
        var newcount = parseInt($(".notification-dropdown-header .count").html())-1;
        $(".notification-dropdown-header .count").html(newcount);
        if( newcount ==0 ){
            $('.icon-new-notification').addClass('icon-notification').removeClass('icon-new-notification').removeClass('wide');
        }

    });
});

function markAsRead(message, recipient) {
    var read;
    read['message'] = message;
    read['recipient'] = recipient;
    $.post(path + 'api/internal/message/read', read, function(result) {
    });
}
