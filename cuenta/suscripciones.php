<script type="text/javascript">
$(document).ready(function(){
	$("#add").click(function(){
       $("#ciudad").css({display:"inline-block"});
    });
});
</script>
<div style="margin-left:2em;">
<h3>Administra tus Suscripciones</h3>
<form method="post" action="#">
<input type="checkbox" class="check"><b class="lugar">Lima</b><br>
<label id="add">Añade otra ciudad <b>+</b></label>
<select id="ciudad">
	<option value="0">Lima</option>
	<option value="1">Trujillo</option>
	<option value="2">Arequipa</option>
</select>
<p>Al suscribirme estoy de acuerdo con los términos y condiciones de muchosdescuentos.com</p>
<hr>
<input type="button" value="Actualizar" id="update">
</form>
</div>