<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript">
function inicializar(l1,l2) 
{
    if (GBrowserIsCompatible()) 
    {
        var map = new GMap2(document.getElementById("map"));
        map.setCenter(new GLatLng(l1, l2), 17);
        
        function informacion(ubicacion, descripcion)
        {
            var marca = new GMarker(ubicacion);
            GEvent.addListener(marca, "click", function() { marca.openInfoWindowHtml(descripcion); } );
            return marca;
        }
        
        var ubicacion = new GLatLng(l1, l2);
        var descripcion = 'Direccion del Local';
        var marca = informacion(ubicacion, descripcion);
        
        map.addOverlay(marca);
    }
}

function cargar_mapa()
{
    var l1 = $("#latitud").val();
    var l2 = $("#longitud").val();
    if(l1!=""&&l2!="")
    {
        inicializar(l1,l2);        
    }
}
</script>
<form id="frm" >
    <div id="tabs">
    <ul>
      <li><a href="#tabs-1">Informacion General</a></li>            
      <li><a href="#tabs-2">Coordenadas de Mapa</a></li>  
    </ul>
    <div id="tabs-1">
    <div style="width:700px;"></div>
    <input type="hidden" name="controller" value="local" />
    <input type="hidden" name="action" value="save" />
    
        <label for="idlocal" class="labels" style="width:130px;">Codigo:</label>
        <input type="text" id="idlocal" name="idlocal" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->idlocal; ?>" readonly />
        <input type="hidden" id="idempresa" name="idempresa"  value="<?php if($obj->idempresa!="") {echo $obj->idempresa;} else {echo $idempresa;} ?>" readonly />
        <br/>
        
        <label for="descripcion" class="labels" style="width:130px;">Descripcion:</label>
        <input id="descripcion" maxlength="200" name="descripcion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 408px; text-align: left;" value="<?php echo $obj->descripcion; ?>" /> <span class="item-required">*</span>
        <br>
        
        <label for="idciudad" class="labels" style="width:130px;">Ciudad:</label>
        <?php echo $ciudad; ?> <span class="item-required">*</span>        
        <br/>

        <label for="nombre_contacto" class="labels" style="width:130px;">Direccion:</label>
        <input type="text" id="direccion"  name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 408px; text-align: left;" value="<?php echo $obj->direccion; ?>" onkeypress="return permite(event,'num_car');" maxlength="100" /> <span class="item-required">*</span>
        
        <br/>
        <label for="horario" class="labels" style="width:130px;">Horario Atencion:</label>
        <input type="text" id="horario"  name="horario" class="text ui-widget-content ui-corner-all" style=" width: 408px; text-align: left;" value="<?php echo $obj->horario; ?>" onkeypress="return permite(event,'num_car');" maxlength="100"  /> <span class="item-required">*</span>
        
        <br/>
        <label for="pagina_web" class="labels" style="width:130px;">Pagina Web:</label>
        <input type="text" id="pagina_web"  name="pagina_web" class="text ui-widget-content ui-corner-all" style=" width: 408px; text-align: left;" value="<?php echo $obj->pagina_web; ?>" onkeypress="return permite(event,'num_car');" maxlength="100" />
        
        <br/>
        <label for="telefono1" class="labels" style="width:130px;">Telefono 1:</label>
        <input id="telefono1" name="telefono1" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->telefono1; ?>" maxlength="55" /> <span class="item-required">*</span>
                
        <label for="telefono2" class="labels" style="width:80px;">Telefono 2:</label>
        <input id="telefono2" name="telefono2" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->telefono2; ?>" maxlength="55" />
        <br>
        
        <label for="referencia" class="labels" style="width:130px;">Referencia:</label>
        <textarea name="referencia" id="referencia" rows="3" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style="width:408px"><?php echo $obj->referencia; ?></textarea>       
                
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
    <div id="tabs-2">
       <div style="width:700px;"></div> 
       <fieldset>
           <legend>Coordenadas</legend>
           <label for="latitud" class="labels" style="width:130px;">Latitud:</label>
           <input id="latitud" name="latitud" onkeypress="" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->latitud; ?>" maxlength="55" />
           <label for="longitud" class="labels" style="width:80px;">Longitud:</label>
           <input id="longitud" name="longitud" onkeypress="" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php echo $obj->longitud; ?>" maxlength="55" />
           &nbsp;&nbsp;&nbsp;
           <input type="button" name="Cargar" id="Cargar" value="Visualizar Mapa" onclick="cargar_mapa()" />
       </fieldset>
       <fieldset>
           <legend>Mapa</legend>
           <div id="map" style="width:400px; height:250px; margin:0 auto;"> 
                <script type="text/javascript"></script>
                </div>
            </div>
       </fieldset>
    </div>
</form>
