/*functions for making ajax message page */

var apiurl = '../api/v2';

var padString = function (string) {
    
    if(string.length = 1) {
        return '0'+string;
    } else {
        return string
    }
    
};

var formatDate = function(datestring) {
    
    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };
    
    return new Intl.DateTimeFormat(applocale, options).format(new Date(datestring));
    
};

var getMessage = function(id) {
    
    if( typeof id == 'undefined' ) {
        return false;
    }
    
    if ( typeof sendertranslation == 'undefined' ) {
        return false;
    }
    
    var thisRow = $(".dime-table tr[data-unique-id='" + id + "']");
    
    if( thisRow.data("message") ){
        return true;
    }
    
    var button = $("<button>&#10004;</button>").addClass('dime-icon btn normal').attr('id', id).click(function(e){
            alert($(e.target).attr('id'));
        });

    var definitionlist = $("<dl><dt>"+
            sendertranslation+"</dt><dd class=\"message-from\">"+
            senderinitial+"</dd><dt>"+
            datetranslation+"</dt><dd class=\"message-date\">"+
            formatDate(dateinitial)+"</dd><dt>"+
            eventtranslation+"</dt><dd class=\"message-body\">"+
            eventinitial+"</dd></dl>").append(button);
    
    var message = $("<div></div>").append(definitionlist).append(button);
    
    thisRow.data("message", message);
    
    console.log('loading '+id);
    
        $.ajax(apiurl+'/messages/'+id)
        .fail(function() {
            $('.message-from').empty();

            $('.message-date').empty();

            $('.message-body').empty();
        })
        .done(function(data) {
          var response = data.data;
          
          $.ajax(apiurl+'/actors/'+response.attributes.sender)
          .fail(function() {
              thisRow.data("message").find('.message-from').html('error reading sender');
          })
          .done(function(response){
              var actorname = response.data.attributes.fullname;
              thisRow.data("message").find('.message-from').html(actorname[0].content);
          });
          
          var sent_at = response.attributes.sent.datetime.date;
          console.log(sent_at)
          
          thisRow.data("message").find('.message-date').html(formatDate(sent_at));
          
          $.ajax(apiurl+'/events/'+response.attributes.event)
          .fail(function() {
              thisRow.data("message").find('.message-body').html('error reading message');
          })
          .done(function(response){
              thisRow.data("message").find('.message-body').html(message_vocabulary["dime.find.event."+response.data.attributes.type]);
          });
          
        });
    
};

var showMessage = function(id){
    
    var thisRow = $(".dime-table tr[data-unique-id='" + id + "']");
    
    var message = thisRow.data("message");
    
    if(message){
        $('.dime-messages').find('div').detach();
        $('.dime-messages').append(message);
        
    } else {
        getMessage(id);
        showMessage(id);
    }
    
};

var messageclick = function(evt) {

    $('tr').removeClass('selected');
    
    if($(evt.target).is('tr')){
        var self = $(evt.target);
    } else {
        var self = $(evt.target).closest('tr');
    }

    self.addClass('selected');
    self.addClass('read');
    
    showMessage(self.attr('data-unique-id'));

};
    
$('document').ready(function(){

    $('tr').on("click", {"target":this}, messageclick );
    
    if( typeof window.message_id !== 'undefined' ){
        $(".dime-table tr[data-unique-id='" + window.message_id + "']").click();
    }
    
    $('tr').each( function(i,e){
        getMessage($(e).attr('data-unique-id'));
    })
});