$(function() 
{   $( "#tabs" ).tabs({collapsible: true });
    $( "#ruc" ).focus();
    $("#div_activo").buttonset();
    $("#idcategoria,#idsubcategoria,#idtipo_descuento").css("width","200px");
    $("#idcategoria").change(function(){
      loadSubCategorias($(this).val());
    });
    $("#precio_regular,#precio").change(function(){
       calc_descuento();
    });
});

function save()
{
  bval = true;  
  bval = bval && $( "#ruc" ).required();
  bval = bval && $( "#idcategoria" ).required();
  bval = bval && $( "#idsubcategoria" ).required();
  bval = bval && $( "#idtipo_descuento" ).required();
  bval = bval && $( "#titulo1" ).required();
  bval = bval && $( "#titulo2" ).required();
  bval = bval && $( "#precio" ).required();
  bval = bval && $( "#precio_regular" ).required();
  bval = bval && $( "#descuento" ).required();  
  
  var str = $("#frm").serialize();
  

  var cont = $("#descripcion_ifr").contents().find("#tinymce").html(),
      cont2 = $("#cc_ifr").contents().find("#tinymce").html(),
      params = {
                  'c1':cont,
                  'c2':cont2
               },
      str2 = jQuery.param(params);
  
  if ( bval )
  {
      $.post('index.php',str+'&'+str2,function(r)
      {
        if(r.res==1)
        {
          alert(r.msg);
          var idp = $("#idpublicaciones").val();
          if(idp=="")
          {
            $("#idpublicaciones").val(r.idp);
            abilitarLoadImage();
          }          
          gridReload();          
        }
        else
        {
          alert(r.msg);
        }
      },'json');
  }
  return false;
}

function loadSubCategorias(idc)
{
  if(idc!="")
  {
    $.get('index.php','controller=subcategoria&action=arraysc&idc='+idc,function(data){
        var html = '';
        $.each(data,function(i,j){
          html += '<option value="'+j[0]+'">'+j[1]+'</option>';
        });
        $("#idsubcategoria").empty().append(html);
    },'json')
  }
  else
  {
    $("#idsubcategoria").empty().append("<option value=''>...</option>");
  }
}

function abilitarLoadImage()
{
  var idp = $("#idpublicaciones").val();
  if(idp!="")
  {
    $("#link-upload-imgen").empty().append("<a style='color:blue' href='javascript:popup(\"upload/index.php?p="+idp+"\",500,300)' >Subir Imagen</a>");
  }
}

function calc_descuento()
{
  var itd = $("#idtipo_descuento").val(),
      td = $("#idtipo_descuento option:selected").html(),
        x = 0,
        p = $("#precio").val(),
       pr = $("#precio_regular").val();
  if(td=="Porcentaje")
  {
    if(p!=""&&pr!="") 
    {
      x = 100-(p*100)/pr;
      $("#descuento").val("-"+parseInt(x)+"%");
    }
    else
    {
      $("#descuento").val("");
    }    
  }
  else
  {
    $("#descuento").val(td);
  }

}