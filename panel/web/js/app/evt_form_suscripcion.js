$(function() 
{   
    $("#idtipo_documento,#idempresa,#idlocal").css("width","350px");
    $("#idempresa").focus();
    $("#idempresa").change(function(){loadlocal($(this).val());});
    $("#infinito").click(function(){valInfinito($(this));});
    $("#fecha_inicio,#fecha_fin").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});

    $("#box-frm2").dialog({
      modal:true,
      autoOpen:false,
      width:'auto',
      height:'auto',
      resizing:true,      
      title:'Informacion de Empresa'      
    });

    $("#info-empresa").click(function(){
      var idemp = $("#idempresa").val();
      if(idemp!="")
      {
        info(idemp);
      }
      else
      {
        alert("Seleccione un empresa");
      }
    });
});

function loadlocal($ide)
{
  if($ide!="")
  {
    $.get('index.php','controller=local&action=arrayLocal&ide='+$ide,function(data){
        var html = '';
        $.each(data,function(i,j){
          html += '<option value="'+j[0]+'">'+j[1]+'</option>';
        });
        $("#idlocal").empty().append(html);
    },'json')
  }
}

function save()
{
  bval = true;
  bval = bval && $("#idempresa").required();
  bval = bval && $("#idlocal").required();
  bval = bval && $("#fecha_inicio").required();
  var fech1 = $("#fecha_inicio").val();
  if(!validarFormatoFecha(fech1))
  {
    bval=false;
    alert("El formato de Fecha de Inicio es incorrecto: dd/mm/yyyy");
    return 0;
  }  
  bval = bval && $("#fecha_fin").required();
  var fech2 = $("#fecha_fin").val();

  if(!validarFormatoFecha(fech2))
  {
    bval=false;
    alert("El formato de Fecha de Fin es incorrecto: dd/mm/yyyy");
    return 0;
  }

  fech1=ffecha(fech1);
  fech2=ffecha(fech2);

  if((Date.parse(fech1)) > (Date.parse(fech2)))
  {
    bval = false;
    alert("La fecha inicial no puede ser mayor que la fecha final");
    return 0;
  }

  if(!$("#infinito").is(':checked'))
  {
      bval = bval && $("#max_publi").required();
  }
  var str = $("#frm").serialize();
  if ( bval ) 
  {
      $.post('index.php',str,function(res)
      {
        if(res[0]==1)
        {
          $("#box-frm").dialog("close");
          gridReload(); 
        }
        else
        {
          alert(res[1]);
        }
        
      },'json');
  }
  return false;
}
function validar_email(email)
{
  $.get('index.php?controller=asesor&action=vemail&e='+email,function(data){
    if(data[0]==0)
    {
      $("#email").addClass('ui-state-error');
      $("#email-v").show();
      $("#email").focus();

    }
    else
    {
      $("#email").removeClass('ui-state-error');
      $("#email-v").hide();
    }
  },'json')
}
function valInfinito($i)
{  
  if($i.is(':checked'))
  {
    $("#max_publi").val("-");
    $("#max_publi").attr("readonly",true);
  }
  else
  {
    $("#max_publi").val("1");
    $("#max_publi").attr("readonly",false);
    $("#max_publi").focus();
  }
}
function info($idem)
{ 
  $.get('index.php?controller=empresa&action=view&id='+$idem,function(html)
  {
     $.getScript("js/app/evt_form_empresa.js");
     $("#box-frm2").dialog({buttons: {
            'Cerrar': function(){ $(this).dialog('close');}                  
          }});
     $("#box-frm2").empty().append(html);
     $("#box-frm2").dialog("open");     
  });
}

function validarFormatoFecha(campo) {
      var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
      if ((campo.match(RegExPattern)) && (campo!='')) {
            return true;
      } else {
            return false;
      }
}

function ffecha(fecha)
{  
  f=fecha.split("/");
  return f[2]+"-"+f[1]+"-"+f[0];

}