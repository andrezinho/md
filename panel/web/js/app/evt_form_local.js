$(function() 
{  
    $( "#descripcion" ).focus();
    $( "#departamento,#provincia,#distrito" ).css({'width':'270px'});
    $("#div_activo").buttonset();
    $("#departamento").change(function(){
        loadProvincia();
    });
    $("#provincia").change(function(){
        loadDistrito();
    });
});
function loadProvincia()
{
    var idd = $("#departamento").val();
    $.get('index.php?controller=local&action=loadProvincia&idd='+idd,function(data){
        var html = '<option value="">...</option>';
        $.each(data,function(i,j){
            html += '<option value="'+j[0]+'">'+j[1]+'</option>';
        });
        $("#provincia").empty().append(html)
    },'json')
}
function loadDistrito()
{
    var idp = $("#provincia").val();
    $.get('index.php?controller=local&action=loadDistrito&idp='+idp,function(data){
        var html = '<option value="">...</option>';
        $.each(data,function(i,j){
            html += '<option value="'+j[0]+'">'+j[1]+'</option>';
        });
        $("#distrito").empty().append(html)
    },'json')
}
function save()
{
  bval = true;        
  bval = bval && $( "#descripcion" ).required();        
  
  var str = $("#frm").serialize();
  if ( bval ) 
  {
      $.post('index.php',str,function(res)
      {
        if(res[0]==1){
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