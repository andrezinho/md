$(function() 
{  
    $( "#tabs" ).tabs({collapsible: true });
    $( "#descripcion" ).focus();
    $( "#distrito" ).css({'width':'270px'});
    $("#div_activo").buttonset();
});

function save()
{
  bval = true;        
  bval = bval && $( "#descripcion" ).required();        
  bval = bval && $( "#distrito" ).required();        
  bval = bval && $( "#direccion" ).required();        
  
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