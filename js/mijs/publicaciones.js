var host=window.location.host;
host=host+"/md";
$(document).ready(function(){
	$.get("model/publicaciones.php","&",function(data){//alert(data);
		publi="";
		$.each(data,function(i,j){ 
			publi +='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >';
			publi +='<div class="product-block">';
			publi +='<div class="image">';

			if(j.idtipo_descuento!=1){publi +='<div class="product-label product-sale"><span>'+j.descuento+'</span></div>';}
			else{publi +='<div class="product-label product-sale"><span>'+j.descuento+'</span></div>';}

			publi +='<a class="img" href="producto/'+amigable(j.titulo1+'-'+j.idpublicaciones)+'"><img alt="'+j.titulo1+'" src="panel/web/imagenes/home/small_'+j.imagen+'.jpg" title="'+j.titulo1+'"></a> </div>';
			publi +='<div class="product-meta">';
			publi +='<div class="name">';
			publi +='<a href="producto/'+amigable(j.titulo1+'-'+j.idpublicaciones)+'">'+j.titulo1+'</a></div>';
			publi +='<div class="big-price"><span class="price-new">';
			publi +='<span class="sym">$</span>'+j.precio+'</span>';
			publi +='<span class="price-old"><span class="sym">$</span>'+j.precio_regular+'</span></div>';
			publi +='<div class="big-btns"><a href="producto/'+amigable(j.titulo1+'-'+j.idpublicaciones)+'" class="btn btn-default btn-View pull-left">Comprar</a></div>';
			publi +='<div class="small-price"><span class="price-new">';
			publi +='<span class="sym">$</span>'+j.precio+'</span>';
			publi +='<span class="price-old"><span class="sym">$</span>'+j.precio_regular+'</span></div>';
			publi +='<div class="rating">';
            publi +='<i class="fa fa-star"></i>';
            publi +='<i class="fa fa-star"></i>';
            publi +='<i class="fa fa-star"></i>';
            publi +='<i class="fa fa-star-half-o"></i>';
            publi +='<i class="fa fa-star-o"></i></div>';
            publi +='<div class="small-btns">';
            
            if(j.deseo==0)
            {                
                publi +='<button id="btn-wishlist-'+j.idpublicaciones+'" class="btn btn-default btn-wishlist pull-left" title="">';
                publi +='<i class="fa fa-heart fa-fw" id="fa-heart-'+j.idpublicaciones+'"></i></button>';
            }   
            else
            {
                publi +='<button class="btn btn-default btn-wishlist pull-left" title="">';
                publi +='<i class="fa fa-heart fa-fw" style="color:#FCD209"></i></button>';
            }         
            publi +='<button class="btn btn-default btn-compare pull-left" title="View">';
            publi +='<a href="producto/'+amigable(j.titulo1+'-'+j.idpublicaciones)+'">VER <b>&GT;</b> </a></button></div></div>';
            publi +='<div class="meta-back"></div></div>';
            publi +='</div> ';
		});
       $("#publicacion").append(publi);
       $('.small-btns').on('click','.btn-wishlist',function(){var i=$(this).attr("id"),temp=i;i=i.split("-");i=i[2];if(i!=""){addwishlist(i);}});
	},'json');



$.get("http://"+host+"/model/especial.php","&",function(data){
    publi="";
	$.each(data,function(i,j){
		if(i==0){publi +='<div class="item active">';}
		else{publi +='<div class="item">';}
        publi +='<div class="product-block">';
        publi +='<div class="image">';
        if(j.idtipo_descuento!=1){publi +='<div class="product-label product-sale"><span>-'+j.descuento+'%</span></div>';}
        else{publi +='<div class="product-label product-sale"><span>'+j.descuento+'</span></div>';}
        
        publi +='<a class="img" href="http://'+host+'/producto/'+amigable(j.titulo1+'-'+j.idpublicaciones)+'"><img alt="product info" src="http://'+host+'/panel/web/imagenes/home/small_'+j.imagen+'.jpg" title="'+j.titulo1+'"></a></div>';
        publi +='<div class="product-meta">';
        publi +='<div class="name">';
        publi +='<a href="http://'+host+'producto/'+amigable(j.titulo1+'-'+j.idpublicaciones)+'">'+j.titulo1+'</a></div>';
        publi +='<div class="big-price">'; 
        publi +='<span class="price-new">';
        publi +='<span class="sym">$</span>'+j.precio+'</span> ';
        publi +='<span class="price-old"><span class="sym">$</span>'+j.precio_regular+'</span></div>';
        publi +='<div class="big-btns">';
        publi +='<a class="btn btn-default btn-View pull-left" href="http://'+host+'producto/'+amigable(j.titulo1+'-'+j.idpublicaciones)+'">Ver</a></div></div>';
        publi +='<div class="meta-back"></div></div></div>';
		});
$("#items").append(publi);
$("#items2").append(publi);
},'json');



});


function addwishlist(i)
{
    $.post('model/addwish.php','i='+i,function(r){
        $("#fa-heart-"+i).css("color","#FCD209");
    });
}

var amigable  = (function() {
  var tildes = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç", 
    conver = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
        cuerpo  = {};
 
  for (var i=0, j=tildes.length; i<j; i++ ) { 
    cuerpo[tildes.charAt(i)] = conver.charAt(i);
  }
 
  return function(str) {
    var salida = [];
    for( var i = 0, j = str.length; i < j; i++) {
      var c = str.charAt( i );
      if(cuerpo.hasOwnProperty(str.charAt(i))) {
        salida.push(cuerpo[c]);
      } else {
        salida.push(c);
      }
    }
    return salida.join('').replace(/[^-A-Za-z0-9]+/g, '-').toLowerCase();
  }
})();