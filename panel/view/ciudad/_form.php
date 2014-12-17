<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<form id="frm" >    
    
    <input type="hidden" name="controller" value="ciudad" />
    <input type="hidden" name="action" value="save" />
    
        
        <input type="hidden" id="idciudad" name="idciudad" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->idciudad; ?>" readonly />
        <input type="hidden" id="idempresa" name="idempresa"  value="<?php if($obj->idempresa!="") {echo $obj->idempresa;} else {echo $idempresa;} ?>" readonly />
        <br/>
   
        
        <label for="departamento" class="labels" style="width:130px;">Departamento:</label>
        <?php echo $departamento; ?> <span class="item-required">*</span>
        
        <br/>
        <label for="provincia" class="labels" style="width:130px;">Provincia:</label>
        <?php 
            if($obj->idciudad!="")
            {echo $provincia; }
            else
            { echo "<select class='ui-widget-content ui-corner-all text' name='provincia' id='provincia' ><option>...</option></select>";}
        ?> 
        <span class="item-required">*</span>
        
        <br/>
        <label for="distrito" class="labels" style="width:130px;">Ciudad:</label>
        <?php
            if($obj->idciudad!="")
            {echo $distrito; }
            else
            { echo "<select class='ui-widget-content ui-corner-all text' name='distrito' id='distrito' ><option>...</option></select>";}
        ?> 
        <span class="item-required">*</span>

        
        <br/>
        <label for="estado" class="labels" style="width:130px;">Activo:</label>
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
