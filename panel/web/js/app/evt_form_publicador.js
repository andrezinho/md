$(function() 
{   $("#idtipo_documento,#idempresa,#idlocal").css("width","350px");
    $( "#idempresa" ).focus();
    $("#idtipo_documento").change(function()
    {
        cdoc();
    });
    $("#email").change(function(){
        validar_email($(this).val());
    });
    $("#idempresa").change(function(){
      loadlocal($(this).val());
    });
    $("#div_activo").buttonset();
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
  else
  {
    $("#idlocal").empty().append('<option value="">...</option>');
  }
}
function cdoc()
{
  $("#nrodocumento").focus();
  var v = $("#idtipo_documento").val();
  if(v==1)
  {
    $("#nrodocumento").attr("maxlength","8");
  }
  if(v==2)
  {
    $("#nrodocumento").attr("maxlength","11");
  }
  if(v==3)
  {
    $("#nrodocumento").attr("maxlength","10");
  }
  if(v==4)
  {
    $("#nrodocumento").attr("maxlength","15");
  }
}
function save()
{
  bval = true;        
  bval = bval && $( "#idempresa" ).required();        
  bval = bval && $( "#idlocal" ).required();        
  bval = bval && $( "#nombres" ).required();        
  bval = bval && $( "#apellidos" ).required();        
  bval = bval && $("#idtipo_documento").required();  
  bval = bval && $("#nrodocumento").required();
  bval = bval && $("#email").required();
  if(bval)
  {
    if(!validateMail("email"))
    {
        alert("Ingrese un correo electronico correctamente, (correo@dominio.com)");
        $("#email").focus();
        return false;
    }
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