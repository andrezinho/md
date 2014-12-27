var host=window.location.host;
host=host+'/md';
$(document).ready(function(){
//Suscripciones

//fin suscripciones
$("#recibir_ofertas").click(function(){
  $.get('http://'+host+'/view/_suscripcion.php','',function(data){    
    $("#frm-suscripcion").empty().append(data);
    $("#frm-suscripcion").dialog("open");    
    PI.onReady();
  })
   
}); 
//Eventos cambio de ciudad
$("#ciudades").change(function(){
    var c = $(this).val();
    $.get('http://'+host+'/model/change_ciudad.php','c='+c,function(data){      
      location.reload();
    });
  });
//menu lateral
$("#datos").click(function(){
	$("#datos").css({color:"#000"});
	$("#cupones").css({color:"blue"});
	$("#suscripciones").css({color:"blue"});

	$.get('http://'+host+'/cuenta/datos.php',function(datos){
		$(".formulario").show().html(datos);
	});
});

//menu lateral
$("#cupones").click(function(){
	$("#cupones").css({color:"#000"});
	$("#datos").css({color:"blue"});
	$("#suscripciones").css({color:"blue"});
	$.get('cuenta/cupones.php',function(datos){
		$(".formulario").show().html(datos);
	});
});
//menu lateral
$("#suscripciones").click(function(){
	$("#suscripciones").css({color:"#000"});
	$("#datos").css({color:"blue"});
	$("#cupones").css({color:"blue"});
	$.get('cuenta/suscripciones.php',function(datos){
		$(".formulario").show().html(datos);
	});
});

//formulario registro
$("#registrar").click(function(){//alert("hola");
$.get('http://'+host+'cuenta/datos.php',function(datos){//alert(datos);
		$(".formulario").show().html(datos);
	});

});

//menu y submenu
//window.location.protocol (http:)
//window.location.pathname (md/)

$.get('http://'+host+'/model/menu.php','&',function(data){ //alert("data");
  var menu = "";
   $.each(data,function(i,j){
   	 var idc=j.codigo;
	 menu += "<li id='categoria-"+idc+"'><a href='http://"+host+"/descuentos/"+amigable(j.texto)+"'><span class='hidden-sm'>"+j.texto+"</span><i class='fa fa-angle-down fa-fw'></i></a>";
	 menu += "<nav id='submenu-"+idc+"' class='submenu'>";
		
		$.each(j.enlaces,function(k,p){
			
			menu += "<span class='sublista'><a href='http://"+host+"/descuentos/"+amigable(j.texto)+"/"+amigable(p.texto)+"-s"+p.idsubcategoria+"'>"+p.texto+"</a></span>";
			
		});

	 menu += "</nav>";
	 menu += "</li>";
	});


   $("#listamenu").append(menu); 
   
   $('#listamenu li').hover(function(e) {

   	  var idcc=$(this).attr("id");

      if (idcc === undefined) 
      {
          
      } 
      else
      {

     	  idcc=idcc.split("-");
     	  idcc=idcc[1];//alert(idcc);

        var elemento = $(".menu-links");
        var posicion = elemento.position();//alert( "left: " + posicion.left + ", top: " + posicion.top );  	

        $('#submenu-'+idcc).show();
          $("#submenu-"+idcc).offset({left: posicion.left});
  	     $("#submenu-"+idcc).mouseover(function(){
  	     	$("#categoria-"+idcc).css({background:"#B6090C"});

  	    });        
      }

     },
     function(e) {
	     var idcc=$(this).attr("id");
       if (idcc === undefined) 
       { 
          
       } 
       else
       {
  	   	 idcc=idcc.split("-");
  	   	 idcc=idcc[1];
  	     $('#submenu-'+idcc).hide();
  		     $("#categoria-"+idcc).css({background:"#DE1215"});
       }
  	 });
       

},'json');	
$("#frm-suscripcion").dialog({ 
      modal:true,
      autoOpen:false,
      width:'auto',
      height:'auto',
      resizing:true,
      title:"Suscripcion a Descuentos",
      buttons: {
                  'Cerrar': function(){ $(this).dialog('close');},
                  'Confirmar':function(){PI.sending();}
                }
     });

});

//funcion actualizar registro
function update(){
  bval = true;        
  bval = bval && $( "#nombres" ).required();        
  bval = bval && $( "#apellidos" ).required();        
  bval = bval && $("#tipodoc").required();
  bval = bval && $("#ndoc").required();
  bval = bval && $("#telefono").required();
  
   var str = $("#frm").serialize();
                      if ( bval ) 
                      {
                          $.post('model/updateuser.php',str,function(data)
                          {
                            if(data.res==1)
                            {
                              $(".conface").css({display:"none"});
                              $("#frm").css({display:"none"});
                              $(".mdatos").css({display:"none"});
                              $(".formulario").css({display:"none"});
                              $("#bienvenido").css({display:"none"});
                              $(".micuenta").css({display:"none"});
                              $(".enlaces").css({display:"none"});
                              $("#actualizar").css({display:"block"});
                              //if(history.forward(1)){location.replace(history.forward(1));}
                            }
                            else
                            {
                              alert(data.msg);
                            }
                            
                          },'json');
                      }
}
//funcion guardar registro
function save()
{

  bval = true;        
  bval = bval && $( "#nombres" ).required();        
  bval = bval && $( "#apellidos" ).required();        
  bval = bval && $("#email").required();

  if(bval)
  {
    bval = validar_formato_email();
  }
  if(bval)
  {
      consulta = $("#email").val();
      $("#resultado").html('<img src="images/ajax-loader.gif" class="load" />');
      $.post("model/comprobar.php","b="+consulta,function(data){                                    
              if(data=="1")
              {
                  $("#resultado").empty();
                  bval = bval && $("#passw").required();
                  bval = bval && $("#rpassw").required();
                  
                  $("#resultado_contra").empty();
                  
                  if ($("#passw").val()!=$("#rpassw").val()) {
                    $("#resultado_contra").html("<span style='color:red;' id='nodisponible'>Las contraseñas no coinciden.</span>");
                    bval=false;
                  };
                  bval = bval && $("#ndoc").required();
                  
                //  bval=ndoc();
                 // if(bval){bval=true;}else{bval=false}
                  bval = bval && $("#ndoc").required();
                  bval = bval && $("#telefono").required();




                  if($("#terminos").is(':checked')) 
                  {  

                  var str = $("#frm").serialize();
                      if ( bval ) 
                      {
                          $.post('model/newuser.php',str,function(data)
                          {
                            if(data.res==1)
                            {
                              $(".conface").css({display:"none"});
                              $("#frm").css({display:"none"});
                              $(".mdatos").css({display:"none"});
                              $(".formulario").css({display:"none"});
                              $("#actualizar").css({display:"none"});
                              $("#bienvenido").css({display:"block"});
                              //if(history.forward(1)){location.replace(history.forward(1));}
                            }
                            else
                            {
                              alert(data.msg);
                            }
                            
                          },'json');
                      }
                    }
                    else{
                     $("#resultado_terminos").empty().html("<span style='color:red;' id='nodisponible'>Debe aceptar los t&eacute;rminos y condiciones.</span>");
                    }
              }
              else
              {
                  $("#resultado").empty().html("<span style='color:red;' id='nodisponible'>Este email ya existe.</span>");
                  return 0;
                  bval = false;
              }
          });
  }

  
  //var v = $("#idtipo_documento").val();
  
  return false;
}
function ndoc(v)
{
  $("#ndoc").focus();
  v = $("#tipodoc").find(':selected').val(); //alert(v);  
  if(v==1)
  {
    $("#ndoc").attr("maxlength","8");
    $("#ndoc").attr("placeholder", "12345678").placeholder();
  }
  if(v==2)
  {
    $("#ndoc").attr("maxlength","11");
    $("#ndoc").attr("placeholder", "12345678901").placeholder();
  }
  if(v==3)
  {
    $("#ndoc").attr("maxlength","12");
    $("#ndoc").attr("placeholder", "123456789012").placeholder();
  }
  if(v==4)
  {
    $("#ndoc").attr("maxlength","12");
    $("#ndoc").attr("placeholder", "123456789012").placeholder();
  }
  //return v;
}

//validar campos require
(function( $ ){
  $.fn.required = function() 
  {
    if ( $(this).val() == '' ) 
    {
        $("#pop-alert-ui").remove();
        if($(this).attr("title"))
            {
                var msg = $(this).attr("title"),   
                w = $(this).css('width'),
                xy = $(this).offset(),
                div = '';                
                if(msg!="")
                    {   
                        div = '<div id="pop-alert-ui" class="ui-state-highlight ui-corner-all" style="top:'+(xy.top-1)+'px; left:'+(parseInt(w)+xy.left + 15)+'px ;position:absolute;z-index:9999; display:none;  padding: 0em 0.3em; width:200px ">';
                        div += '<p style="margin:3px"><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>';
                        div += '<strong>Hey! </strong>';
                        div += msg;
                        div += '</p></div>';
                        
                        $('body').append(div);
                        $("#pop-alert-ui").fadeTo('slow', 0.95).delay(4000).fadeOut(500,function(){
                            $("#pop-alert-ui").remove();
                        });

                    }
                 
            }        
        $(this).addClass('ui-state-error');
        $(this).focus();
        return false;
    }
    else 
    {
        $(this).removeClass('ui-state-error')
        return true;
    }
  };
})( jQuery );

//*********************************************************************
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


///Suscripcion
var PI = {
            onReady : function() 
            {              
                //$('#email_suscripcion').focus();                                
            },            
            sending  : function()
            {
              
               var email = $("#email_suscripcion").val(),
                   mname = $("#name_suscripcion").val();
              if(mname!="")
               {
                  if(PI.validar(email))
                 {
                    $.post('model/suscripcion.php','e='+email+'&n='+mname,function(r){
                    if(r.res=="1")
                    {
                        alert("Gracias por suscribirte.\nTe estaremos enviando nuevos descuentos.");
                        $("#frm-suscripcion").dialog('close');
                    }
                    else
                    {
                        alert(r.msg);
                    }
                    },'json');
                 }
                 else
                 {
                    $("#email_suscripcion").addClass("ui-state-error");
                    $("#email_suscripcion").focus();
                 }
                    
                
               }
               else
               {
                   alert("Ingrese su nombre.");
                   $("#name_suscripcion").addClass("ui-state-error");
                   $("#name_suscripcion").focus();
               }
               
                   
            },
            validar : function(e) 
            {
                expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if ( !expr.test(e) )
                    return false
                else
                    return true;
            }
};
