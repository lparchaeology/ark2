
$('document').ready(function(){
  // DOM element where the Timeline will be attached
  var container = document.getElementById('visualization');

  //Create a DataSet (allows two way data-binding)
  var items = new vis.DataSet();
  
  var query = {"concept":"dime.period"};
  
  $(".classification-holder").append($('#find_item_type_term').clone().attr('id', '#find_item_type_term-modal'));

  $.post(path + 'api/internal/vocabulary', JSON.stringify(query) )
  .fail(function() {
      console.log('Error fetching period vocabulary');
  })
  .done(function(response) {
      window.periodvocabulary = response.terms;
      
      for ( period_id in window.periodvocabulary){
          var period = window.periodvocabulary[period_id];

          end = period.parameters.year_end.value;
          
          if( isNaN(period.parameters.year_end.value) ){
              end = new Date().getFullYear();
          }

          items.add({
              id:      period_id,
              content: period.name,
              start:   vis.moment(Math.max( period.parameters.year_start.value, -10000 ), 'Y'),
              end:     vis.moment(end, 'Y')
            });
      } 

      function customOrder (a, b) {
        // order by length
          a.length = a.start-a.end;
          b.length = b.start-b.end;
        return b.length - a.length;
      }

      // Configuration for the Timeline
      var options = {
        order: customOrder,
        editable: false,
        margin: {item: 0},
        zoomMin: 1576800000000,//10 years 1000*60*60*24*365*10
        zoomMax: 63120000000000, //15000 years 1000*60*60*24*365*5000
        showCurrentTime: false,
        horizontalScroll: true,
        zoomKey: 'ctrlKey'
      };

      // Create a Timeline
      var timeline = new vis.Timeline(container, items, options);
      timeline.on('click', function(event){
    	  console.log( event.type);
    	  if(event.event.type == 'panend'){
    		  return true;
    	  }
          try {
              existing_start = timeline.getCustomTime('start');
          }catch (err){
              existing_start = null;
          }
          try {
              existing_end = timeline.getCustomTime('end');
          }catch (err){
              existing_end = null;
          }

          if ( existing_start != null ) {
              timeline.removeCustomTime( 'start' );
          }
          if ( existing_end != null ) {
              timeline.removeCustomTime( 'end' );
          }

          if( event.item != null ) {
              var item_start = vis.moment(window.periodvocabulary[event.item].parameters.year_start.value, 'Y');
              var item_end = vis.moment(window.periodvocabulary[event.item].parameters.year_end.value, 'Y');
              if( event.event.shiftKey ){
                  if (existing_start < item_start) {
                      var start = existing_start;
                  } else {
                      var start = item_start;
                  }
     
                  if (existing_end > item_end) {
                      var end = existing_end;
                  } else {
                      var end = item_end;
                  }
              } else {
                  var start = item_start;
                  var end = item_end; 
              }

         } else {
        	 if ( existing_start == null ) {
                 start = event.time;
                 end = event.time;
        	 } else if ( existing_end == null ) {
                 start = existing_start;
                 end = event.time;
        	 } else {
        		 if ( Math.pow(event.time - existing_start, 2) > Math.pow(event.time - existing_end, 2) ){
                     start = existing_start;
                     end = event.time;
        		 } else {
                     start = event.time;
        			 end = existing_end;
        		 }
        	 }
         } 
         timeline.addCustomTime( start, 'start' );
         timeline.addCustomTime( end, 'end' );
         console.log(new Date().getFullYear(),'Y');
      });

      timeline.moveTo(vis.moment(new Date().getFullYear(),'Y'));
  });

});
