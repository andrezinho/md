<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<form id="frm" >
    <input type="hidden" name="controller" value="categoria" />
    <input type="hidden" name="action" value="save" />
    
        <label for="idcategoria" class="labels">Codigo:</label>
            <input id="idcategoria" name="idcategoria" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idcategoria; ?>" readonly />
        <br/>
        
        <label for="descripcion" class="labels">Descripcion:</label>
            <input id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" title="Ingrese la descripcion" />
            <br>
        <label for="orden" class="labels">Orden:</label>
   		<input id="orden" name="orden" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->orden; ?>" title="Ingrese el orden"/>
                <br/>
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
