<div class="div_container">
<div class="box-heading" style="background: #dadada;border-bottom: 1px solid #BDBDBD;">
    <span style="color:#000;font-weight: normal;">
        Elija una de las opciones del menú.            
    </span>    
    <script type="text/javascript">
		function inicializar() 
		{
		    if (GBrowserIsCompatible()) 
		    {
		        var map = new GMap2(document.getElementById("map"));
		        map.setCenter(new GLatLng(-6.4925805, -76.3731267), 17);

		        function informacion(ubicacion, descripcion) 
				{
					var marca = new GMarker(ubicacion);
					GEvent.addListener(marca, "click", function() {
					marca.openInfoWindowHtml(descripcion); } );
					return marca;
				}

				var ubicacion = new GLatLng(-6.4925805, -76.3731267);
				var descripcion = '<b>Texto ejemplo</b><br/>Para tutorial de CLH<br />';
				var marca = informacion(ubicacion, descripcion);

				map.addOverlay(marca);
		    }
		}

		function cargar_mapa()
		{
			inicializar();
		}
	</script>



</div>
<input type="button" name="cargar" id="cargar" value="Cargar Mapa" onclick="cargar_mapa();" />
<div id="map" style="width:400px; height:400px">	
	<script type="text/javascript"></script>
	</div>
</div>
