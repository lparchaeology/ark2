<?php
$js ='';
if(in_array($sf_state, array('p_max_edit','p_max_ent','s_max_edit'))){
    $js.="$(document).ready(function(){";
    foreach ($fields as $field){
        if ($field['field_id']==$root_field['field_id']){
            $target = $sf_val;
        } else {
            $target = "row";
        }
        $frmElem = frmElem($field, $sf_key);
        $input = '<form class="editable-cell-form">
                '.$frmElem.'
        <input class="editor_ok_button" type="submit" value="OK">
        <a class="editor_cancel" href="#'.$sf_conf['sf_html_id'].'">Cancel</a>
        </form>';
        $input = preg_replace('/\s+/', ' ', str_replace('"','\"',$input));
        $js .= "
                var input = \"$input\";
                $(\"th#{$field['field_id']}\").data('input', input);
                $(\"th#{$field['field_id']}\").data('dataclass', \"{$field['dataclass']}\");
                $(\"th#{$field['field_id']}\").data('classtype', \"{$field['classtype']}\");
                $(\"th#{$field['field_id']}\").data('target', \"$target\");";
        
    }
    $js.="$(\"td\").dblclick(function () {
        var cell = $(this);
          if(!cell.hasClass('cellEditing')){
          header = cell.closest('table').find('th').eq(cell.index()),
          OriginalContent = cell.children();
          var edit;
          var cell_id = cell.data('CurrentId');
          classtype = header.data('classtype');
          hiddenId = cell.children(\"input\");
          cell.data('OriginalContent',OriginalContent);
          if (!cell_id){
           cell_id = cell.attr('id').split(\"-\").pop();
           if(cell_id!=='empty'){
              cell.data('CurrentId',cell_id);
            }
          }
          
          var field = header.attr('id');
            
          var input = header.data('input');
      
          cell.addClass(\"cellEditing\");
          cell.html(input);
          var suggestion = OriginalContent.text();
          if (OriginalContent.length!==0 && cell_id){
              qtype = classtype+\"_qtype\";
              $('input[name='+qtype+']').val('edt');
              edit = true;
              cell.children('form').append(hiddenId);
              console.log(header.data('dataclass'));
              switch (header.data('dataclass')) {
                case'number':
                      cell.find('input[type=number]').val(OriginalContent.text());
                      cell.find('input[type=number]').focus();
                  break;
                default:
                  cell.find('textarea[name='+classtype+']').val(decodeURI(OriginalContent.html()));
                  cell.find('textarea[name='+classtype+']').focus()
                }        
          } else {
               cell.find('input[name='+classtype+']').focus();
                  cell.find('textarea[name='+classtype+']').focus();
             edit = false;
          }
          
            $(\".editor_ok_button\").click( function (e) {
                e.preventDefault();
                cell = $(this).closest('td');
                form = $(this).closest('form');
                row = $(this).closest('tr');
                row_id = row.attr('id').split('-')[1];
                target = header.data('target');
                if (target==='row'){
                    itemkey = \"cor_tbl_{$root_field['dataclass']}\";
                    itemvalue=row_id;
                } else {
                    itemkey = \"$sf_key\";
                    itemvalue=target;
                }
                console.log(cell.data(\"CurrentId\"));
                console.log(cell_id);
                var ajaxurl = 'api.php';
                var s = form.serialize();
                s = s+'&field='+field;
                s = s+'&req=putField';
                s = s+'&item_key='+itemkey;
                s = s+'&itemval='+itemvalue;
                s = s+'&'+classtype+'_id='+cell_id;
                $.post( ajaxurl,s, function( data ) {
                    var success;
                    console.log(header.data('dataclass'));
                    switch(header.data('dataclass')){
                        case 'attribute':
                            NewContent = form.children('input').val();
                            if (edit){
                                success = data.qry_results[0].success;
                              } else {
                                success = data.qry_results[0][0].success;
                              }
                            if(success){
                                NewValue =form.children('select').children('option:selected').text();
                                cell.html(hiddenId);
                                cell.prepend(NewValue);
                                cell.removeClass('cellEditing');
                            }else{
                                cell.prepend(data.messages[0]);
                            }
                        break;
                    case 'txt':
                        NewContent = form.children('textarea').val();
                            if (edit){
                                success = data.qry_results[0].success;
                              } else {
                                success = data.qry_results[0][0].success;
                                var html_id = cell.attr('id').split(\"-\");
                                html_id.pop();
                                console.log(data.qry_results);
                                html_id.push('txt-'+data.qry_results[0][0].new_id);
                                cell.attr('id', html_id);
                              }
                            if(success){
                                cell.empty();
                                var newspan = document.createElement('span');
                                newspan.className = 'data';
                                newspan.appendChild(document.createTextNode(NewContent));
                                cell.prepend(newspan);
                                cell.removeClass('cellEditing');
                            }else{
                                cell.prepend(data.messages[0]);
                            }
                        break;
                    default :
                        NewContent = form.children('input').val();
                            if (edit){
                                try{
                                    success = data.qry_results[0].success;
                                } catch(err){
                                    success = false;
                                }
                            } else {
                                try{
                                    success = data.qry_results[0].success;
                                } catch(err){
                                    success = false;
                                }
                                if(success){
                                    var html_id = cell.attr('id').split(\"-\");
                                    html_id.pop();
                                    console.log(data.qry_results);
                                    html_id.push('txt-'+data.qry_results[0].new_id);
                                    cell.attr('id', html_id);
                                }  
                            }
                            if(success){
                                cell.empty();
                                var newspan = document.createElement('span');
                                newspan.className = 'data';
                                newspan.appendChild(document.createTextNode(NewContent));
                                cell.prepend(newspan);
                                cell.removeClass('cellEditing');
                            }else{
                                cell.prepend(data.messages[0]);
                            }
                        break;
                    }
                });
            });
            }
          $(this).children().first().keypress(function (e) {
              if (e.which == 13) {
                  var newContent = $(this).val();
                  $(this).parent().text(newContent);
                  $(this).parent().removeClass(\"cellEditing\");
                  console.log(newContent);
                  console.log(cell.attr('id'));
                  console.log(cell.closest('table').find('th').eq(cell.index()));
              }
          });
            $(\".editor_cancel\").click( function () {
                cell = $(this).closest('td');
                cell.html(cell.data(\"OriginalContent\"));
                cell.removeClass('cellEditing');
            });
      });
    });";
    
    $js.="function addNewRecord".$sf_conf['sf_html_id']."(){";
    $js.="  alert('add new what?');";
    $js.="}";
}

?>
<script>
$("#finds_table")
    .tablesorter({
    });

<?php echo $js; ?>
</script>
