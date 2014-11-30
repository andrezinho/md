$(document).ready(function(){

$.get('model/menu.php','&',function(data){ //alert(data);
  var menu = "";
   $.each(data,function(i,j){
   	 var idc=j.codigo;
	 menu += "<li id='categoria-"+idc+"'><a href='descuentos/"+j.texto+"'><span class='hidden-sm'>"+j.texto+"</span><i class='fa fa-angle-down fa-fw'></i></a>";
	 menu += "<nav id='submenu-"+idc+"' class='submenu'>";
		
		$.each(j.enlaces,function(k,p){
			
			menu += "<span class='sublista'><a href='#'>"+p.texto+"</a></span>";
			
		});

	 menu += "</nav>";
	 menu += "</li>";
	});


   $("#listamenu").append(menu); //alert(menu);

   $('#listamenu li').hover(function(e) {
   	  var idcc=$(this).attr("id");
   	  idcc=idcc.split("-");
   	  idcc=idcc[1];//alert(idcc);

      var elemento = $(".menu-links");
      var posicion = elemento.position();//alert( "left: " + posicion.left + ", top: " + posicion.top );  	

      $('#submenu-'+idcc).show();
        $("#submenu-"+idcc).offset({left: posicion.left});
	     $("#submenu-"+idcc).mouseover(function(){
	     	$("#categoria-"+idcc).css({background:"#B6090C"});

	    });

     },
     function(e) {
	     var idcc=$(this).attr("id");
	   	 idcc=idcc.split("-");
	   	 idcc=idcc[1];//alert(idcc);
	     $('#submenu-'+idcc).hide();

		     $("#categoria-"+idcc).css({background:"#DE1215"});

	     });

},'json');	


});