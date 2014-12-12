$(document).ready(function(){
	$.get("model/publicaciones.php","&",function(data){//alert(data);
		publi="";
		$.each(data,function(i,j){
			publi +='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" >';
			publi +='<div class="product-block">';
			publi +='<div class="image">';
			publi +='<div class="product-label product-sale"><span>-30%</span></div>';
			publi +='<a class="img" href="producto/'+amigable(j.titulo1+'-'+j.idpublicaciones)+'"><img alt="product info" src="panel/web/imagenes/home/small_'+j.imagen+'.jpg" title="'+j.titulo1+'"></a> </div>';
			publi +='<div class="product-meta">';
			publi +='<div class="name">';
			publi +='<a href="producto/'+amigable(j.titulo1+'-'+j.idpublicaciones)+'">'+j.titulo1+'</a></div>';
			publi +='<div class="big-price"><span class="price-new">';
			publi +='<span class="sym">$</span>'+j.precio+'</span>';
			publi +='<span class="price-old"><span class="sym">$</span>'+j.precio_regular+'</span></div>';
			publi +='<div class="big-btns"><a href="producto.html" class="btn btn-default btn-View pull-left" href="">Comprar</a></div>';
			publi +='<div class="small-price"><span class="price-new">';
			publi +='<span class="sym">$</span>'+j.precio+'</span>';
			publi +='<span class="price-old"><span class="sym">$</span>'+j.precio_regular+'</span></div>';
			publi +='<div class="rating">';
            publi += '<i class="fa fa-star"></i>'; 
            publi +='<i class="fa fa-star"></i>'; 
            publi +='<i class="fa fa-star"></i>'; 
            publi +='<i class="fa fa-star-half-o"></i>';
            publi +='<i class="fa fa-star-o"></i></div>';
            publi +='<div class="small-btns">';
            publi +='<button class="btn btn-default btn-wishlist pull-left" title="">';
            publi +='<i class="fa fa-heart fa-fw"></i></button>';
            publi +='<button class="btn btn-default btn-compare pull-left" title="View">';
            publi +='<a href="producto/'+amigable(j.titulo1+'-'+j.idpublicaciones)+'">VER <b>&GT;</b> </a></button></div></div>';
            publi +='<div class="meta-back"></div></div>';
            publi +='</div> ';

		});
       
       $("#publicacion").append(publi);

	},'json');
});



                           
                        
                      
                      
                       