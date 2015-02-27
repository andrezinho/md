$(function() 
{   $( "#tabs" ).tabs({collapsible: true });
    $( "#ruc" ).focus();    
    $("#idbancos").css("width","auto");
    $("#div_activo").buttonset();
    $("#addBanco").click(function(){
      addBanco();
    });
    $("#t-cuentas tbody tr td").on('click','.t-delete-item',function(){
       $(this).parent().parent().remove();
    })
});

function save()
{
  bval = true;        
  bval = bval && $( "#ruc" ).required();          
  bval = bval && $( "#razon_social" ).required();          
  bval = bval && $( "#razon_comercial" ).required();          
  bval = bval && $( "#nombre_contacto" ).required();          
  bval = bval && $( "#dominio" ).required();  
  bval = bval && $( "#website" ).required();
  
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

function addBanco()
{
  var bval=true;
  bval=bval&&$("#idbancos").required();
  bval=bval&&$("#nrocuenta").required();
  if(bval)
  {
    var idb=$("#idbancos").val(),
        b=$("#idbancos option:selected").html(),
        c=$("#nrocuenta").val();
    html='';
    html+='<tr>';
    html+='<td><input type="hidden" name="idbancosd[]" value="'+idb+'"/>'+b+'</td>';
    html+='<td><input type="hidden" name="nrocuentad[]" value="'+c+'"/>'+c+'</td>';
    html+='<td align="center"><a href="javascript:" class="t-delete-item" style="color:red">[Eliminar]</a></td>';
    html+='</tr>';
    $("#t-cuentas").find('tbody').append(html);
    $("#t-cuentas tbody tr td").on('click','.t-delete-item',function(){
       $(this).parent().parent().remove();
    })
  }  
}