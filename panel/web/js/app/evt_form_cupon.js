$(function() 
{  
    $( "#tabs" ).tabs({collapsible: true });
    $( "#op_2" ).focus();   
    $("#confirmar").click(function(){
      if(confirm("Realmente deseas confirmar la operacion?"))
      {
        save();
      }
    });
});

function save()
{
  bval = true;        
  opciones = document.getElementsByName("op"); 
  var seleccionado = false;
  for(var i=0; i<opciones.length; i++) {    
    if(opciones[i].checked) {
      seleccionado = true;
      break;
    }
  }

  if(!seleccionado) {
    bval = false;
    alert("Elija una opcion de operacion.");
  }

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