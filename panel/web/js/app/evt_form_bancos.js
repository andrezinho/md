$(function() 
{
    $( "#descripcion" ).focus();        
});

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