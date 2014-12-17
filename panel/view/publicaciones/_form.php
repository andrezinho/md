<?php
       include("../lib/helpers.php"); 
       include("../view/header_form.php");       
?>
<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({selector:'textarea#descripcion',theme: "modern",
    height : "300",    
    browser_spellcheck : true,   
    convert_fonts_to_spans: true, 
    content_css : "css/css_editor.css",  menubar: "",toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | forecolor backcolor | print | searchreplace |"});
    tinymce.init({selector:'textarea#cc',theme: "modern",
    height : "300",    
    browser_spellcheck : true,   
    convert_fonts_to_spans: true, 
    content_css : "css/css_editor.css",  menubar: "",toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | forecolor backcolor | print | searchreplace |"});
</script>
<div style="padding:5px 5px">
<form id="frm" >    
    <div id="tabs">
    <ul>
      <li><a href="#tabs-1">Informacion General</a></li>      
      <li><a href="#tabs-2">Detalles de la Oferta</a></li>      
      <li><a href="#tabs-3">Condiciones Comerciales</a></li>      
      <li><a href="#tabs-4">Imagen</a></li>      
    </ul>
    <div id="tabs-1">
        <div style="width:700px;"></div>
        <input type="hidden" name="controller" value="publicaciones" />
        <input type="hidden" name="action" value="save" />             

        <!-- <label for="idpublicaciones" class="labels" style="width:130px;">Codigo:</label> -->
        <input type="hidden" id="idpublicaciones" name="idpublicaciones" class="text ui-widget-content ui-corner-all" style=" width: 80px; text-align: left;" value="<?php echo $obj->idpublicaciones; ?>" readonly />
        

        <label for="idcategoria" class="labels" style="width:130px;">Categoria:</label>
        <?php echo $categoria; ?> <span class="item-required">*</span> 
        <br/>

        <label for="idsubcategoria" class="labels" style="width:130px;">Sub Categoria:</label>
        <?php if($obj->idpublicaciones!="") {
            echo $subcategoria;
            }  else { ?>
        <select name="idsubcategoria" id="idsubcategoria">
            <option value="">...</option>
        </select>
        <?php } ?> <span class="item-required">*</span> 
        <br/>

        <label for="idtipo_descuento" class="labels" style="width:130px;">Tipo Descuento:</label>
        <?php echo $tipo_descuento; ?> <span class="item-required">*</span> 

        <label for="tipo" class="labels" style="width:80px;">Especial:</label>
        <?php 
        $ck = "";
         if($obj->tipo=="1")
         {
            $ck ="checked";
         }
        ?>
        <input type="checkbox" name="tipo" id="tipo" value="1" style="vertical-align:middle;" <?php echo $ck; ?>/>
        <br/>

        <label for="titulo1" class="labels" style="width:130px;">Titulo Corto:</label>
        <input type="text" id="titulo1" name="titulo1" value="<?php echo $obj->titulo1; ?>"  class="text ui-widget-content ui-corner-all" style=" width: 500px; text-align: left;" />
        <span class="item-required">*</span> 
        <br/>

        <label for="titulo2" class="labels" style="width:130px;">Titulo Largo:</label>
        <textarea name="titulo2" id="titulo2" rows="2" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style="width:500px"><?php echo $obj->titulo2; ?></textarea>               
        <span class="item-required">*</span> 
        <br/>

        <label for="precio" class="labels" style="width:130px;">Precio:</label>
        <input type="text" id="precio" name="precio" value="<?php echo $obj->precio; ?>"  class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" />
        <span class="item-required">*</span> 
        <br/>

        <label for="precio_regular" class="labels" style="width:130px;">Precio Regular:</label>
        <input type="text" id="precio_regular" name="precio_regular" value="<?php echo $obj->precio_regular; ?>"  class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" />
        <span class="item-required">*</span> 
        <br/>

        <label for="descuento" class="labels" style="width:130px;">Descuento:</label>
        <input type="text" id="descuento" name="descuento" value="<?php echo $obj->descuento; ?>"  class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" />
        <span class="item-required">*</span> 
        <br/>

        <label for="fecha_inicio" class="labels" style="width:130px;">Fecha Inicio:</label>
        <input type="text" id="fecha_inicio" name="fecha_inicio" value="<?php if($obj->fecha_inicio!="") {echo fdate($obj->fecha_inicio,"ES");} else {echo date('d/m/Y');} ?>"  class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" />
        <label for="hora_inicio" class="labels" style="width:50px;">Hora:</label>
        <input type="text" id="hora_inicio" name="hora_inicio" value="<?php if($obj->hora_inicio!="") {echo substr($obj->hora_inicio,0,5);} else {echo "00:00";} ?>"  class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" />
        <span class="item-required">*</span> 
        <br/>

        <label for="fecha_fin" class="labels" style="width:130px;">Fecha Fin:</label>
        <input type="text" id="fecha_fin" name="fecha_fin" value="<?php if($obj->fecha_fin!="") {echo fdate($obj->fecha_fin,"ES");} else {echo date('d/m/Y');} ?>"  class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" />
        <label for="hora_fin" class="labels" style="width:50px;">Hora:</label>
        <input type="text" id="hora_fin" name="hora_fin" value="<?php if($obj->hora_fin!="") {echo substr($obj->hora_fin,0,5);} else {echo "00:00";} ?>"  class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" />
        <span class="item-required">*</span> 
        <br/>

        <label for="estado" class="labels" style="width:130px;">Activo:</label>
        <?php
            if($obj->estado==true || $obj->estado==false)
            {
                if($obj->estado==true){ $rep=1; }
                   else { $rep=0; }
            }
            else { $rep = 1; }
            activo('activo',$rep);
        ?>        
    </div>  
    <div id="tabs-2">
        <div style="width:700px;"></div>
        <p>Describa todos los detalles sobre la oferta.</p>
        <textarea name="descripcion" id="descripcion" style="width:100%;"><?php echo $obj->descripcion; ?></textarea>
    </div>    
    <div id="tabs-3">
        <div style="width:700px;"></div>
        <p>Describa las condiciones comerciales que tiene la oferta.</p>
        <div style="width:700px;"></div>
        <textarea name="cc" id="cc" style="width:100%;"><?php echo $obj->cc; ?></textarea>
    </div>    
    <div id="tabs-4">
        <div style="width:700px;"></div>                
        <div>
            <div style="width:262px; height:261px; background:#dadada; float:left;" id="imagen-d">
                <?php if($obj->imagen!="") { ?>
                <img src="imagenes/home/small_<?php echo $obj->imagen; ?>.jpg" />
                <?php } ?>
            </div>
            <div style="float:left;">
                <div style="padding:10px;">
                    <h2 style="margin:2px;">Imagen Principal</h2>
                    <p style="font-size:11px;"> Recomendaciones: <br/> 
                    <b>Dimensiones: 557px X 380px </b><br/>
                    Ancho Mínimo: 262px &nbsp;&nbsp;&nbsp; Ancho Maximo: 557px<br/>
                    Alto Mínimo: 261px &nbsp;&nbsp;&nbsp; Ancho Maximo: 380px<br/>
                    Formato: jpg 
                    </p>
                    <div id="link-upload-imgen">
                    <?php 
                    if($noload!="1")
                    {


                    if($obj->idpublicaciones!="") { ?>
                    <a style="color:blue" href="javascript:popup('upload/index.php?p=<?php echo $obj->idpublicaciones; ?>',500,300)" >Subir Imagen</a>
                    <?php } 
                    else { ?>
                    <p style="color:red">Para poder subir la imagen primero debe hacer click en "Confirmar Registro"</p>
                    <?php }  }?>
                    </div>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
    </div>    
    </div>
</form>
</div>