<?php session_start();?>
<script type="text/javascript">
$(document).ready(function(){
    //solo numeros
     $('#ndoc').validanumeros('0123456789');   

    $("#tipodoc").change(function(){ ndoc();});
//################################COMPROBAR EMAIL#######################################################

var consulta;
var existe=true;
var q=false;

      $("#email").change(function(e){
             validar_email();
      });
//validar correo existente
    $("#email").click(function()
    {       
       if(existe==true&&q==true){$("#email").val(""); } 
    });
  


    }); //fin document.ready



function validar_formato_email()
{

     consulta = $("#email").val();
     if($("#email").val().indexOf('@', 0) == -1 || $("#email").val().indexOf('.', 0) == -1)
     {
        $("#resultado").empty().html("<span style='color:red;'>Email no v&aacute;lido (abc@abc.com).</span>");
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
    q = true;
    consulta = $("#email").val();
    $("#resultado").html('<img src="images/ajax-loader.gif" class="load" />');
    $.post("model/comprobar.php","b="+consulta,function(data){                                    
            if(data=="1")
            {
                $("#resultado").empty().html("<span style='font-weight:bold;color:green;' id='disponible'>Disponible.</span>");
                res = true;
                existe = false;
                return res;
            }
            else
            {
                $("#resultado").empty().html("<span style='font-weight:bold;color:red;' id='nodisponible'>Este email ya existe.</span>");
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

</script>

<style type="text/css">
.error {
    color: red;
}
.load{ 
    width: 16px !important;
    height: 16px !important;
}
.registrarse{
    width: 50% !important;
    background: #B6090C !important;
    color: #fff !important;
}
.update{
    width: 50% !important;
    background: #B6090C !important;
    color: #fff !important;
}
#tipodoc{
    width: 100%;
    background: #EEEEEE;
    border: 0px;    
}
.cterm, .term{
    display: inline-block !important;
    width: 1.3em !important;

}
.term{
    width: 70% !important;
}
</style>

   <h3 style="margin-left:5em;" class="mdatos">Mis Datos</h3>
   <form id="frm">
       
   <table id="form-datos" border="0">
    <tr> 
     <td><b>*</b>Nombres</td>
     <td>
      <input type="text" id="nombres" name="nombres" value="<?php echo $_SESSION['primer_name'];?>" placeholder="Tu nombre" autofocus="autofocus" title="Ingrese el Nombre"><span class="item-required"></span>
     </td>
     </tr>

     <tr>
     <td><b>*</b>Apellidos</td>
     <td>
    <input type="text" id="apellidos" name="apellidos" value="<?php echo $_SESSION['apellido'];?>" placeholder="Tu Apellido" autofocus="autofocus" title="Ingrese sus Apellidos"><span class="item-required"></span>
     </td>
     </tr>
    
    <?php if (!isset($_SESSION['facebook'])&&!isset($_SESSION['email'])){ ?>
     <tr>
     <td><b>*</b>Email</td>
     <td>
    <input type="text" id="email" name="email" value="" placeholder="Tu Email"  autofocus="autofocus" title="Ingrese su Email">
    <span class="item-required"></span>
    <div id="resultado"></div>
     </td>
     </tr>

     <tr>
     <td><b>*</b>Contraseña</td>
     <td>
    <input type="password" id="passw" name="passw" value="" placeholder="Tu Password"  autofocus="autofocus" title="Ingrese su Contraseña">
    <span class="item-required"></span>
     </td>
     </tr>

     <tr>
     <td><b>*</b>Repetir Contraseña</td>
     <td>
    <input type="password" id="rpassw" name="rpassw" value="" placeholder="Repetir Contraseña"  autofocus="autofocus" title="password">
    <span class="item-required"></span>
    <div id="resultado_contra"></div>
     </td>
     </tr>

     <?php } ?>

     <tr>
     <td><b>*</b>Tipo Documento</td>
     <td>
    <select id="tipodoc" name="tipodoc" >
        <option value="1" selected>DNI</option>
        <option value="2">RUC</option>
        <option value="3">PASAPORTE</option>        
        <option value="4">CARNET DE EXTRANJERIA</option>
    </select>
     </td>
     </tr>

     <tr>
     <td><b>*</b>Nro. Documento</td>
     <td>
    <input type="text" id="ndoc" name="ndoc" value="" placeholder="12345678"  autofocus="autofocus" title="Ingrese su Numero Documento">
    <span class="item-required"></span>
    <div id="resultado_doc"></div>
     </td>
     </tr>

     <tr>
     <td><b>*</b>Telefono</td>
     <td>
    <input type="text" id="telefono" name="telefono" value="" placeholder="(01)-123456"  autofocus="autofocus" title="Ingrese su Numero de Telefono">
    <span class="item-required"></span>
     </td>
     </tr>

     <tr>
     <td>Celular</td>
     <td>
    <input type="text" id="celular" name="celular" value="" placeholder="#123456789" required="required" autofocus="autofocus" title="Ingrese su Numero de Celular">
    <span class="item-required"></span>
     </td>
     </tr>

     <?php if (isset($_SESSION['facebook'])&&isset($_SESSION['email'])){ ?>
     <tr><td colspan="2"><hr></td></tr>
     <tr>
     <td>Email</td>
     <td>
        <?php echo $_SESSION['email']; ?>
         <input type="hidden" id="mail" name="mail" value="<?php echo $_SESSION['email']; ?>">
     </td>
     </tr>

      <tr>
     <td colspan="2" align="center">
    <input type="button" value="Actualizar" class="update" Onclick="update()">
     </td>
     </tr>
     <?php } 
         else{ ?>

     <tr>
     <td><b>*</b>Genero</td>
     <td>
     <input type="radio" name="sexo" value="1" checked  class="genero" /> <label class="gen">Masculino</label>
     <input type="radio" name="sexo" value="0" class="genero" /> <label class="gen">Femenino</label>
     </td>
     </tr>

     <tr>
     <td colspan="2"><hr></td>
     </tr>

     <tr>
     <td>&nbsp;</td>
     <td>
     <input type="checkbox" id="terminos" name="terminos" checked  class="cterm" title="Debes aceptar los t&eacute;rminos y condiciones" />
     <p class="term">He leído y estoy de acuerdo <br>con los <a href="#" style="color:blue"> términos y condiciones</a></p>
     <div id="resultado_terminos"></div>
     
     </td>
     </tr>

     <tr>
     <td colspan="2" align="center">
     <input type="button" value="REGISTRARSE" class="registrarse" Onclick="save()" />
     </td>
     </tr>

     <?php } ?>

       
   </table>

   </form>  