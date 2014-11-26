<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<form id="frm" >
    <input type="hidden" name="controller" value="publicador" />
    <input type="hidden" name="action" value="save" />
        <label for="idusuario" class="labels">Codigo:</label>
        <input id="idusuario" name="idusuario" class="text ui-widget-content ui-corner-all" style=" width: 80px; text-align: left;" value="<?php echo $obj->idusuario; ?>" readonly />
        <br/>
        <label for="nombres" class="labels">Empresa:</label>
        <?php echo $empresa; ?>
        <br/>
        <label for="nombres" class="labels">Local:</label>
        <?php if($obj->idusuario!="") {echo $local;} else {
            ?>
            <select name="idlocal" id="idlocal" class="ui-widget-content ui-corner-all text">
                <option value="">...</option>
            </select>
            <?php
            } ?>
        <br/>
        <label for="nombres" class="labels">Nombres:</label>
        <input id="nombres" name="nombres" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->nombres; ?>" maxlength="60" title="Ingrese el Nombre" /> <span class="item-required">*</span>
        <br>
        <label for="apellidos" class="labels">Apellidos:</label>
        <input id="apellidos" name="apellidos" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->apellidos; ?>" maxlength="100" title="Ingrese los apellidos" /> <span class="item-required">*</span>
        <br>
        <label for="idtipo_documento" class="labels">Tipo Documento:</label>
        <?php echo $tipo_documento; ?> <span class="item-required">*</span>
        <br>
        <label for="nrodocumento" class="labels">Nro Documento:</label>
        <input id="nrodocumento" name="nrodocumento" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->nrodocumento; ?>" title="Ingrese el Numero de Documento" /> <span class="item-required">*</span>
        <br>
        <label for="email" class="labels">email:</label>
        <input id="email" name="email" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->email; ?>" maxlength="100" title="Ingrese el email" placeholder="Ejm. correo@midominio.com"/> <span class="item-required">*</span>
        <div id="email-v" style="text-align:center; font-size:11px; color:red; display:none">Mensaje: Este correo ya existe</div>
        <br>
        <label for="telefono" class="labels">Telefono:</label>
        <input id="telefono" name="telefono" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->telefono; ?>" maxlength="50" /> 
        <br>
        <label for="celular" class="labels">Celular:</label>
        <input id="celular" name="celular" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->celular; ?>" maxlength="45" /> 
        <br>
        <label for="estado" class="labels">Activo:</label>
        <?php                   
            if($obj->estado==true || $obj->estado==false)
                    {
                     if($obj->estado==true){$rep=1;}
                        else {$rep=0;}
                    }
             else {$rep = 1;}                    
             activo('activo',$rep);
        ?>     

</form>
