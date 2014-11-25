<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<form id="frm" >
    <input type="hidden" name="controller" value="tipo_descuento" />
    <input type="hidden" name="action" value="save" />
    
    <label for="idtipo_descuento" class="labels">Codigo:</label>
    <input id="idtipo_descuento" name="idtipo_descuento" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idtipo_descuento; ?>" readonly />
    <br/>        
    <label for="nombre" class="labels">Nombre:</label>
    <input id="nombre" maxlength="90" name="nombre" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->nombre; ?>" title="Ingrese el nombre" />
    <br>        
    <label for="descripcion" class="labels">Descripcion:</label>
    <textarea name="descripcion" id="descripcion" rows="4" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style="width:300px"><?php echo $obj->descripcion; ?></textarea>       
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