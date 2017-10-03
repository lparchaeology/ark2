var initTimeline = function () {
    // DOM element where the Timeline will be attached
    var container = document.getElementById('visualization');

    //Create a DataSet (allows two way data-binding)
    var items = new vis.DataSet();

    // window.periodvocabulary contains the apiresponse for all the periods
    // this script is initiated on the response from that
    for (period_id in window.periodvocabulary) {
        var period = window.periodvocabulary[period_id];

        // get the end - or the current date
        try {
            if (isNaN(period.parameters.year_end.value)) {
                throw 'year end is NaN';
            }
            end = Math.min(period.parameters.year_end.value, (new Date()).getFullYear());
        } catch (e) {
            end = new Date().getFullYear();
        }
        
        // get the start - or 10,000BC- the begining of archaeology ;-)
        try {
            if (isNaN(period.parameters.year_start.value)) {
                throw 'year start is NaN';
            }
            start = Math.max(period.parameters.year_start.value, -10000);
        } catch (e) {
            start = -10000;
        }

        //items is our vis dataset - load it up with period objects
        items.add({
            id: period_id,
            // the content we get from the dropdown menu - so it is translated and marked up how we want it
            content: $("#find_dating_period").find("option[value=" + period.name + "]").html(),
            start: vis.moment(start, "Y"),
            end: vis.moment(end, "Y").endOf("year")
        });
    }


    // order by length - so longer periods go at the top
    function customOrder(a, b) {
        a.length = a.start - a.end;
        b.length = b.start - b.end;
        return b.length - a.length;
    }

    // Configuration for the Timeline
    var options = {
        order: customOrder,
        editable: false,
        margin: {
            axis: 0,
            item: {
                horizontal: -5,
                vertical: 1
            }
        },
        zoomMin: 157680000000, //5 years (1000*60*60*24*365*5) in milliseconds
        zoomMax: 315700000000000, //10000 years (1000*60*60*24*365*10000) in milliseconds
        showCurrentTime: false,
        horizontalScroll: true,
        zoomKey: 'ctrlKey',
        end: vis.moment(new Date().getFullYear(),'Y'),
        start: vis.moment(-2000,'Y')
    };

      // Create a Timeline
      var timeline = new vis.Timeline(container, items, options);

      // this will hide pills which are either too small or too large to be comfortably shown
      $('.vis-range').each(function(i,e){
          var remove = [];
          if( $(e).width() < 100 || $(e).width() > 2000 ){
              $(e).hide();
          } else {
              $(e).show();
          }
      });

      // Options for the dropdowns
      select2Options = {
              minimumResultsForSearch: 11,
              width: 'resolve',
              // sort alphabetically be translation
              sorter: function(data) {
                  return data.sort(function (a, b) {
                      if (a.text > b.text) {
                          return 1;
                      }
                      if (a.text < b.text) {
                          return -1;
                      }
                      return 0;
                  });
              },
          };

      // now that we have that all set up make the find classify trigger a modal
      $('#find_classify').attr('data-toggle','modal');
      
      // on launching the modal do the stuff to make it work
      $('#find_classify').on('click',function(){
          
          // clear out the classification holder
          $(".classification-holder").empty();

          // attach a clone of the type dropdown - fake up a label for now
          var typediv = $("<div class=\"col-md-4\">");
          // TODO Get this markup from somewhere
          var typelabel = "Type";
          typediv.append($('<label>'+typelabel+'</label>'));
          typediv.append($('#find_class_term').clone().attr('id','find_class_term_modal'))
           $(".classification-holder").append(typediv);
          
          // set the new width, and set to match teh dropdown on the main page
          $('#find_class_term_modal').attr('style','width:100%');
          $('#find_class_term_modal').val($('#find_class_term').val());
          
          // launch it as a select2 
          $('#find_class_term_modal').select2(select2Options);

          // attach and launch two empty subtype levels with hacked in labels
          var class1 = $("<div class=\"col-md-4\">");
          // TODO Get this markup from somewhere
          class1label = "Klassifikation 1";
          class1.append($('<label>'+class1label+'</label>'));
          var level1 = $('<select id="find_subtype_level1" style="width:100%">');
          class1.append(level1);
          $(".classification-holder").append(class1);
          level1.select2(select2Options);
          
          var class2 = $("<div class=\"col-md-4\">");
          // TODO Get this markup from somewhere
          class2label = "Klassifikation 2";
          class2.append($('<label>'+class2label+'</label>'));
          var level2 = $('<select id="find_subtype_level2" style="width:100%">');
          class2.append(level2);
          $(".classification-holder").append(class2);
          level2.select2(select2Options);

          $('#find_class_term_modal').on("select2:select select2:unselecting", function(){
              var target = $(this).val()
              level1.empty();
              level1.append('<option value="undefined">'+window.translations['undef']+'</option>');
              level2.empty();
              level2.append('<option value="undefined">'+window.translations['undef']+'</option>');
              for (var subtype in window.subtypevocabulary) {
                  if( target == subtype.split('.')[0] && subtype.split('.').length == 2 ){
                      $(window.subtypevocabulary[subtype].optionelement).clone().appendTo(level1);
                  }
              }
              $('#find_class_term').val(target);
              $('#find_class_term').select2(select2Options);
              $('#find_class_term').trigger('select2:select');
          });

          var updateTimeline = function(target){
              if(target != 'undefined' && target != null){
                  console.log({"target":target});
                  console.log(window.subtypevocabulary);
                  if(typeof window.subtypevocabulary[target].parameters != 'undefined'){
                      try {
                          var target_years = getYearsFromTarget(target);
                          console.log(target_years);
                          try {
                              timeline.setCustomTime( vis.moment(target_years.start, 'Y'), 'start' );
                          } catch (e){
                              timeline.addCustomTime( vis.moment(target_years.start, 'Y'), 'start' );
                          }
                          try {
                              timeline.setCustomTime( vis.moment(target_years.end, 'Y'), 'end' );
                          }catch (e){
                              timeline.addCustomTime( vis.moment(target_years.end, 'Y'), 'end' );
                          }
                          timeline.moveTo(vis.moment(target_years.end, 'Y'));
                          $('#find_dating_year').val(target_years.start);
                          $('#find_dating_year').trigger('keyup');
                          $('#find_dating_year_span').val(target_years.end);
                          $('#find_dating_year_span').trigger('keyup');
                      } catch (e){

                      }
                  }
                  var targetSplit = target.split('.');

                  $('#find_class_term').val(targetSplit[0]);
                  $('#find_class_term').select2(select2Options);
                  $('#find_class_term').trigger('select2:select');
                  $('#find_classification_subtype').val(targetSplit[0]+'.'+targetSplit[1]);
                  $('#find_classification_subtype').select2(select2Options);
                  $('#find_classification_subtype').trigger('select2:select');
                  $('#find_classification_subtype').select2('close');
                  if( targetSplit.length = 3 ){
                      $('#find_classification_subtype').val(target);
                      $('#find_classification_subtype').select2(select2Options);
                      $('#find_classification_subtype').trigger('select2:select');
                      $('#find_classification_subtype').select2('close');
                  }
              } else {
                  if($('#find_subtype_level1').val() == 'undefined'){
                      $('#find_classification_subtype').val(null);
                      $('#find_classification_subtype').select2(select2Options);
                  } else {
                      console.log($('#find_subtype_level1').val());
                      $('#find_classification_subtype').val($('#find_subtype_level1').val());
                      $('#find_classification_subtype').select2(select2Options);
                  }
              }

          }

          level1.on("select2:select select2:unselecting", function(){
              var target = $(this).val();
              console.log(target);
              updateTimeline(target);
              level2.empty();
              level2.append('<option value="undefined">'+window.translations['undef']+'</option>');
              for (var subtype in window.subtypevocabulary) {
                  if ( target != null ) {
                  if (target.split('.')[0] == subtype.split('.')[0] &&
                          target.split('.')[1] == subtype.split('.')[1] && subtype.split('.').length == 3 ){
                          $(window.subtypevocabulary[subtype].optionelement).clone().appendTo(level2);
                  }
                      
                  }
              }
          });

          level2.on("select2:select select2:unselecting", function(){
              var target = $(this).val();
              console.log(target);
              updateTimeline(target);
          });

          var currentSubtype = $('#find_classification_subtype').val();

          level1.empty();
          level1.append('<option value="undefined">'+window.translations['undef']+'</option>');
          for (var subtype in window.subtypevocabulary) {
              if( $('#find_class_term_modal').val() == subtype.split('.')[0] && subtype.split('.').length == 2 ){
                  $(window.subtypevocabulary[subtype].optionelement).clone().appendTo(level1);
              }
          }

          if( currentSubtype != null ){
              var currentSubtypeSplit = currentSubtype.split('.');
              if( currentSubtypeSplit.length == 2 ) {
                  level1.val(currentSubtype);
                  level1.trigger('select2:select');
              } else {
                  level1.val(currentSubtypeSplit[0]+'.'+currentSubtypeSplit[1]);
                  level1.trigger('select2:select');
                  level2.val(currentSubtype);
                  level2.trigger('select2:select');
              }
          }

          var start = $('#find_dating_year').val();
          if( start ){
              try {
                  timeline.setCustomTime( vis.moment(start, 'Y'), 'start' );
              }catch (err){
                  timeline.addCustomTime( vis.moment(start, 'Y'), 'start' );
              }
          }

          var end = $('#find_dating_year_span').val();
          if(end){
              try {
                  timeline.setCustomTime( vis.moment(end, 'Y').endOf("year"), 'end' );
              }catch (err){
                  timeline.addCustomTime( vis.moment(end, 'Y').endOf("year"), 'end' );
              }
          }
          
          // after a short delay, zoomout, giving a nice span and forcing a redraw
          window.setTimeout(function(){
              $('.vis-tl-zoom-out').trigger('click');
          }, 1000);

      });

      $(timeline).attr('pannning', false);

      timeline.on('rangechange', function(event){
          $(timeline).attr('pannning', true);
      });
      timeline.on('rangechanged', function(event){
          setTimeout(function() {
              $(timeline).attr('pannning', false);
          }, 100);
      });

      timeline.on('click', function(event){
          if($(timeline).attr('pannning')){
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

          console.log("start",existing_start,"end",existing_end);
          

          console.log({"event":event.id});

          if( event.id != null ) {

              try {
                  var item_start = vis.moment(window.periodvocabulary[event.id].parameters.year_start.value, 'Y');
              } catch (e){
                  var item_start = vis.moment(date.now(), 'Y');
              }
              try {
                  var item_end = vis.moment(window.periodvocabulary[event.id].parameters.year_end.value, 'Y');
              }catch (e){
                  var item_end = vis.moment('10000', 'Y');
              }

              if( event.event.shiftKey ){
                  if (existing_start < item_start) {
                      var start = vis.moment(existing_start);
                  } else {
                      var start = item_start;
                  }

                  if (existing_end > item_end) {
                      var end = vis.moment(existing_end);
                  } else {
                      var end = item_end;
                  }
              } else {
                  var start = item_start;
                  var end = item_end;
              }

              console.log("start",start,"end",end);
              var item_mid_point = (start.year() + end.year())/2;

              console.log(item_mid_point);

              timeline.moveTo(vis.moment(item_mid_point, 'Y'));

         } else {
             if ( existing_start == null ) {
                 start = event.time;
                 end = null;
             } else if ( existing_end == null ) {
                 start = existing_start;
                 end = event.time;
             } else {
                 if( event.time > existing_end ){
                     start = existing_start;
                     end = event.time;
                 } else if  ( event.time < existing_start ) {
                     start = event.time;
                     end = existing_end;
                 } else if ( Math.pow(event.time - existing_start, 2) > Math.pow(event.time - existing_end, 2) ){
                     start = existing_start;
                     end = event.time;
                 } else {
                     start = event.time;
                     end = existing_end;
                 }
             }
         }

         $('#find_dating_year').val(new Date(start).getFullYear(),'Y');
         $('#find_dating_year').trigger('keyup');
         $('#find_dating_year_span').val(new Date(end).getFullYear(),'Y');
         $('#find_dating_year_span').trigger('keyup');

         timeline.addCustomTime( start, 'start' );
         timeline.addCustomTime( end, 'end' );

      });

      $('.vis-tl-zoom-in').on('click', function () { timeline.zoomIn( 0.2); });
      $('.vis-tl-zoom-out').on('click', function () { timeline.zoomOut( 0.2); });

      $('#closemodal').on('click',function(e){
          e.preventDefault();
          $('#dating-modal').modal('hide');
      });

      $('.vis-item-content').each(function(){
          $(this).attr('title', $(this).html());
      });

      timeline.on('rangechanged', function(){
          $('.vis-range').each(function(i,e){
              var remove = [];
              if( $(e).width() < 100 || $(e).width() > 1800 ){
                  $(e).hide();
              } else {
                  $(e).show();
              }
              timeline.redraw();
          });
      });

      timeline.on('timechanged',function(properties){
          if(properties.id == 'start'){
              if( properties.time > timeline.getCustomTime('end') ){
                  timeline.removeCustomTime('start');
                  timeline.addCustomTime(timeline.getCustomTime('end'),'start');
                  return false;
              }
          } else {
              if( properties.time < timeline.getCustomTime('start') ){
                  timeline.removeCustomTime('end');
                  timeline.addCustomTime(timeline.getCustomTime('start'),'end');
                  return false;
              }

          }
      });

};
