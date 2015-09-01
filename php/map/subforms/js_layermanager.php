<?php 

function singlewrap ($string){
    $string = "'{$string}'";
    return $string;
}

$class = singlewrap("btn");

$js = "
$(document).ready(function() {
        layerlist=map{$map['id']}.getLayers();
        list = document.createElement('ul');
        layers =[];
        layerlist.forEach(function(e,l,a){
            if(!e.get('hidden')){
                layer =  document.createElement('li');
                if ( e.getVisible() ){
                     layer.className = \"layer\";
                } else {
                      layer.className =  \"hiddenlayer\";
                }
                $(layer).data('layer',e);
                  var name = document.createTextNode(e.get('name'));
                  e.set('layerbutton',layer);
                layer.appendChild(name);
                layers.push(layer);
            }
        });
        layers.reverse();
        for (var i=0; i<layers.length; i++){
            list.appendChild(layers[i]);
        }
        
        $('#layer_list').html(list);
        
        $('.hiddenlayer, .layer').click(function(e) {
            var layer = $(this).data('layer');
            console.log(typeof layer.getSource().setTileLoadFunction);
            if ( layer.getVisible() ){
              this.className =  \"hiddenlayer\";
              layer.setVisible(false);
            } else {
              var layerButton = this;
              if (typeof layer.getSource().setTileLoadFunction === 'function' ){
                  layer.getSource().setTileLoadFunction((function() {
                      var numLoadingTiles = 0;
                      var tileLoadFn = layer.getSource().getTileLoadFunction();
                      return function(tile, src) {
                          if (numLoadingTiles === 0) {
                              console.log('loading');
                              layer.get('layerbutton').className =  \"loadinglayer\";
                            }
                            ++numLoadingTiles;
                            var image = tile.getImage();
                            image.onload = image.onerror = function() {
                                --numLoadingTiles;
                                if (numLoadingTiles === 0) {
                                    console.log('idle');
                                    layer.get('layerbutton').className =  \"layer\";
                                }
                            };
                            tileLoadFn(tile, src);
                        };
                    })());
              } else {
                  layer.get('layerbutton').className =  \"layer\";
              }
              layer.setVisible(true);
            }
        });
});";

echo "<script>$js</script>";

?>
