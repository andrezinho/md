<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<form id="frm" >
    <input type="hidden" name="controller" value="suscripcion" />
    <input type="hidden" name="action" value="save" />
        <label for="idsuscripcion" class="labels" style="width:120px">Codigo:</label>
        <input id="idsuscripcion" name="idsuscripcion" class="text ui-widget-content ui-corner-all" style=" width: 80px; text-align: left;" value="<?php echo $obj->idsuscripcion; ?>" readonly />
        <br/>
        <label for="fecha" class="labels" style="width:120px">Fecha Registro:</label>
        <input id="fecha" name="fecha" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php if($obj->fecha!="") {echo fdate($obj->fecha,'ES');} else { echo date('d/m/Y');} ?>" maxlength="10" title="Ingrese la fecha" disabled="disabled" /> 
        <br>
        <label for="nombres" class="labels" style="width:120px">Empresa:</label>
        <?php echo $empresa; ?> <span class="item-required">*</span> 
        <a id="info-empresa" href="#" ref="Empresa" title="Info de Empresa" class="btn">
            <span class="box-boton boton-info"></span>
        </a>
        &nbsp;
        <br/>
        <label for="nombres" class="labels" style="width:120px">Local:</label>
        <?php if($obj->idsuscripcion!="") {echo $local;} else {
            ?>
            <select name="idlocal" id="idlocal" class="ui-widget-content ui-corner-all text">
                <option value="">...</option>
            </select>
            <?php
            } ?> <span class="item-required">*</span>
        <br/>
        <label for="fecha_inicio" class="labels" style="width:120px">Fecha Inicio:</label>
        <input id="fecha_inicio" name="fecha_inicio" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php if($obj->fecha_inicio!="") {echo fdate($obj->fecha_inicio,'ES');} else { echo date('d/m/Y');} ?>" maxlength="10" title="Ingrese la fecha inicio" /> <span class="item-required">*</span>
        <br>
        <label for="fecha_fin" class="labels" style="width:120px">Fecha Fin:</label>
        <input id="fecha_fin" name="fecha_fin" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 350px; text-align: left;" value="<?php if($obj->fecha_fin!="") {echo fdate($obj->fecha_fin,'ES');} else { echo date('d/m/Y');} ?>" maxlength="10" title="Ingrese la fecha Fin" /> <span class="item-required">*</span>
        <br>        
        <label for="max_publi" class="labels" style="width:120px">Max. Publicaciones:</label>
        <input id="max_publi" name="max_publi" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php if($obj->max_publi==0) { echo "-"; } else { echo $obj->max_publi;} ?>" maxlength="8" title="Ingrese el Maximo numero de Publicaciones" /> <span class="item-required">(Por mes) *</span>
        <span style="vertical-align: middle !important;">Infinito</span> <input type="checkbox" name="infinito" id="infinito"  value="1" style="vertical-align: middle !important;" <?php if($obj->max_publi==0) { echo "checked='';"; } ?> />        
        <br>
        <label for="observacion" style="width:120px" class="labels">Observacion:</label>
        <textarea name="observacion" id="observacion" rows="4" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style="width:350px"><?php echo $obj->observacion; ?></textarea>       
        <br> 
        <?php if($_SESSION['id_perfil']=="1") { ?>
        <label for="estado" class="labels" style="width:120px">Estado:</label>
        <?php
            $s0="";$s1="";$s2="";$s3="";
            if($obj->estado=="0"){$s0="selected";$s1="";$s2="";$s3="";}
            if($obj->estado=="1"){$s0="";$s1="selected";$s2="";$s3="";}
            if($obj->estado=="2"){$s0="";$s1="";$s2="selected";$s3="";}
            if($obj->estado=="3"){$s0="";$s1="";$s2="";$s3="selected";}
         ?>
        <select name="estado" id="estado" class="ui-widget-content ui-corner-all text">
            <option value="0" <?php echo $s0; ?> >En Espera</option>
            <option value="1" <?php echo $s1; ?> >Activo</option>
            <option value="2" <?php echo $s2; ?> >Vencido</option>
            <option value="3" <?php echo $s3; ?> >Anulado</option>
        </select>
        <?php } ?>
</form>
<div id="box-frm2" class="ui-widget-content ui-corner-all" style="height:400px; width:890px; display:none; margin:5px auto">      
</div>