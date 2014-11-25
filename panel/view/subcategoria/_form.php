<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<form id="frm" >
    <input type="hidden" name="controller" value="subcategoria" />
    <input type="hidden" name="action" value="save" />    
        <label for="idsubcategoria" class="labels">Codigo:</label>
            <input id="idsubcategoria" name="idsubcategoria" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->idsubcategoria; ?>" readonly />
        <br/>        
        <label for="idcategoria" class="labels">Categoria:</label>
        <?php echo $categoria;  ?>
        <br/>
        <label for="descripcion" class="labels">Descripcion:</label>
        <input id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 300px; text-align: left;" value="<?php echo $obj->descripcion; ?>" title="Ingrese la descripcion"/>
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
