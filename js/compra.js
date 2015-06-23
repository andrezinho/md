 $(document).ready(function(){
     $("#box-other-email").dialog();
     $(".ui-dialog-titlebar-close").html("<a style='color:#D01111; font-weight:bold;vertical-align: top !important;'></a>");
      var lh=0;
      $(".box-pay").each(function(i,j){
          var h=parseInt($(j).css("height"));
          if(h>lh) lh=h;
      });
      $('.box-pay').css("height",lh+'px');
      $("#ytc").click(function()
      {
         $("li.dropdown").toggleClass("open");
         return 0;
      });
      $('#box-msg-session-required').show("highlight",{},1000);

      $("#btn-conf-compra").click(function()
      {
          var no = $("#nombres").val();
          if(no === undefined)
          {
            sending();
          }
          else
          {
            
            bval = true;
            bval = bval && $("#nombres").required();
            bval = bval && $("#apellidos").required();
            bval = bval && $("#email").required();
            bval = bval && $("#passw").required();
            bval = bval && $("#rpassw").required();
            bval = bval && $("#ndoc").required();    

            //validar el formato al email
            if(bval)
            {
              if(!validar_formato_email())
              {
                  bval = false;          
              }
            }

            if(bval)
            {
              //Validamos si existe el email
              consulta = $("#email").val();
              $("#email-resultado").html('<img src="images/ajax-loader.gif" class="load" style="width:auto" />');
              $.post("model/comprobar.php","b="+consulta,function(data)
              {
                  if(data!="1")
                  {              
                      bval = false;
                      $("#email-resultado").empty().html("<span style='color:red;font-size:10px;' id='nodisponible'>Este email ya existe.</span>");
                      return 0;
                  }          
                  else
                  {
                      //Validamos Password iguales
                      $("#email-resultado").empty();
                      var p1 = $("#passw").val(),
                          p2 = $("#rpassw").val();
                      if(p1!=p2)
                      {
                        bval = false;
                        $("#resultado_contra").empty().append("<span style='color:red;font-size:10px;'>Las contraseñas no son iguales.</span>");
                        return false;
                      }
                      else
                      {
                        $("#resultado_contra").empty();
                        sending();
                      }
                  }
              });         
            }
            else
            {
              return false;
            }

          }
      });

      $("#email").change(function(){
         validar_email();
      });
  });

  function validar_formato_email()
  {
     consulta = $("#email").val();
     if($("#email").val().indexOf('@', 0) == -1 || $("#email").val().indexOf('.', 0) == -1)
     {
        $("#email-resultado").empty().html("<span style='color:red;font-size:10px;'>Email no v&aacute;lido (abc@abc.com).</span>");
        return false;
     }
     else
     {
        return true;
     }
  }

  function validar_existe_email()
  {
      var res = false;      
      consulta = $("#email").val();
      $("#email-resultado").html('<img src="images/ajax-loader.gif" class="load" style="width:auto" />');
      $.post("model/comprobar.php","b="+consulta,function(data){                                    
          if(data=="1")
          {
              $("#email-resultado").empty().html("<span style='color:green;font-size:10px' id='disponible'>Disponible.</span>");
              res = true;
              existe = false;
              return res;
          }
          else
          {
              $("#email-resultado").empty().html("<span style='color:red;font-size:10px;' id='nodisponible'>Este email ya existe.</span>");
              return res;
          }
      });       
  }

  function validar_email()
  {
      var r = false;
      if(validar_formato_email())
      {
          if(validar_existe_email())
          {
              r=true;
          }
      }
      return r;
  }

  function sending()
  {
      $("#btn-conf-compra").html('PROCESANDO...');
      if($("#acepto_terminos").is(':checked')) 
      {
          var str = $("#frm").serialize();          
          $.post('http://'+host+'/model/save_buy.php',str,function(data){
            if(data.tipo=="user")
            {
                $.each(data,function(i,j)
                {
                  $("#"+j.input_+"-resultado").empty().append(j.msg);
                });
            }
            else
            {
              if(data.tipo=="trans")
              {
                if(data.res==1)
                {
                    $.get('http://'+host+'/view/_cupon.php','token='+data.token,function(html_cupon){
                      $("#box-compra-all").empty().append(html_cupon);                      
                    })
                }
                else
                {
                  alert('Error: '+data.msg);
                }
              }
              else
              {
                alert(data.msg);
              }
            }
          },
        'json');
      } 
      else 
      {  
        alert("Aún no has aceptado los Terminos y Condiciones");  
        return 0;
      }  
  }