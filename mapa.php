<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Mapa</title>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAHhzikxCQyRAS8ryQoB75mRT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQiqBRnE1Iky5sZfKGxzYbUanZ0HA" type="text/javascript"></script>
<script type="text/javascript">

function inicializar() {
if (GBrowserIsCompatible()) {
var map = new GMap2(document.getElementById("map"));
map.setCenter(new GLatLng(<?php echo $_GET['latitud'] ?>,<?php echo $_GET['longitud'] ?>), 18);

function informacion(ubicacion, descripcion) {

var marca = new GMarker(ubicacion);
GEvent.addListener(marca, "click", function() {
marca.openInfoWindowHtml(descripcion); } );

return marca;

}

var ubicacion = new GLatLng(<?php echo $_GET['latitud'] ?>,<?php echo $_GET['longitud'] ?>);
var descripcion = 'Direccion del Local';
var marca = informacion(ubicacion, descripcion);

map.addOverlay(marca);

}
}

</script>

</head>
<body>
<div id="map" style="width:600px; height:600px">
<script type="text/javascript">inicializar();</script>
</div>

</body>
</html>
