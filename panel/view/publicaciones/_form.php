<?php
       include("../lib/helpers.php"); 
       include("../view/header_form.php");       
?>
<div style="padding:5px 5px">
<form id="frm" >    
    <div id="tabs">
    <ul>
      <li><a href="#tabs-1">Informacion General</a></li>      
      <li><a href="#tabs-4">Cuentas de Pago</a></li>      
    </ul>
    <div id="tabs-1">
        <div style="width:700px;"></div>
        <input type="hidden" name="controller" value="empresa" />
        <input type="hidden" name="action" value="save" />             

        <label for="idmodulo" class="labels" style="width:130px;">Codigo:</label>
        <input type="text" id="idempresa" name="idempresa" class="text ui-widget-content ui-corner-all" style=" width: 80px; text-align: left;" value="<?php echo $obj->idempresa; ?>" readonly />

        <br/>
        <label for="idmodulo" class="labels" style="width:130px;">RUC:</label>
        <input type="text" id="ruc"  name="ruc"  class="text ui-widget-content ui-corner-all" style=" width: 120px; text-align: left;" value="<?php echo $obj->ruc; ?>" maxlength="11" onkeypress="return permite(event,'num');" /><span class="item-required">*</span>

        <br/>
        <label for="razon_social" class="labels" style="width:130px;">Razon Social:</label>
        <input type="text" id="razon_social"  name="razon_social"  class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->razon_social; ?>" maxlength="100" onkeypress="return permite(event,'num_car');" /><span class="item-required">*</span>

        <br/>
        <label for="razon_comercial" class="labels" style="width:130px;">Razon Comercial:</label>
        <input type="text" id="razon_comercial"  name="razon_comercial" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->razon_comercial; ?>" maxlength="100" /><span class="item-required">*</span>
        
        <br/>
        <label for="nombre_contacto" class="labels" style="width:130px;">Nombres de Contacto:</label>
        <input type="text" id="nombre_contacto"  name="nombre_contacto" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->nombre_contacto; ?>" onkeypress="return permite(event,'num_car');"  /><span class="item-required">*</span>
        <br/>

        <label for="telefono" class="labels" style="width:130px;">Telefonos:</label>
        <input type="text" id="telefonos"  name="telefonos" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->telefonos; ?>" onkeypress="return permite(event,'num_car');"  />
        <br/>
        <label for="email" class="labels" style="width:130px;">Pagina Web:</label>
        <input type="text" id="website"  name="website" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->website; ?>" onkeypress="return permite(event,'num_car');"  /><span class="item-required">*</span>
        <br/>

        <label for="facebook" class="labels" style="width:130px;">Facebook:</label>
        <input type="text" id="facebook"  name="facebook" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->facebook; ?>" onkeypress="return permite(event,'num_car');"  />
        <br/>

        <label for="twitter" class="labels" style="width:130px;">Twitter:</label>
        <input type="text" id="twitter"  name="twitter" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->twitter; ?>" onkeypress="return permite(event,'num_car');"  />
        <br/>
        <label for="youtube" class="labels" style="width:130px;">YouTube:</label>
        <input type="text" id="youtube"  name="youtube" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->youtube; ?>" onkeypress="return permite(event,'num_car');"  />
   
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
    </div>  
    <div id="tabs-4">
        <p>
            Número de Cuentas Bancarias con la que cuenta la empresa.
        </p>
        <div style="width:700px;"></div>
        <label for="bcp" class="labels" style="width:130px;">BCP:</label>
        <input type="text" id="bcp"  name="bcp" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->bcp; ?>" onkeypress="return permite(event,'num_car');"  />
        <br/>
        <label for="scotiabank" class="labels" style="width:130px;">ScotiaBank:</label>
        <input type="text" id="scotiabank"  name="scotiabank" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->scotiabank; ?>" onkeypress="return permite(event,'num_car');"  />
        <br/>
        <label for="interbank" class="labels" style="width:130px;">InterBank:</label>
        <input type="text" id="interbank"  name="interbank" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php echo $obj->interbank; ?>" onkeypress="return permite(event,'num_car');"  />
    </div>    
    </div>
</form>
</div>