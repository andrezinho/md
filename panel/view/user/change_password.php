<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
    $("#npassw,#rpassw").change(function(){
        var np=$("#npassw").val(),rp=$("#rpassw").val();
        if(np!=""&&rp!=""){if(np!=rp){$("#pass_d").empty().append("Las contraseñas no coinciden");$("#pass_d").show("slow");}else{$("#pass_d").hide();}}
    });
});
</script>
<form id="frm" >    
        <label for="nombres" class="labels" style="width:120px">Nombres:</label>
        <b><?php echo $_SESSION['name']; ?></b>
        <br>        
        <label for="passw" class="labels" style="width:120px">Password Actual:</label>
        <input type="password" id="passw" name="passw" onkeypress="" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="" title="Ingrese su password Actual" /> <span class="item-required">*</span>
        <br>
        <label for="npassw" class="labels" style="width:120px">Nuevo Password:</label>
        <input type="password" id="npassw" name="npassw" onkeypress="" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="" title="Ingrese su password" /> <span class="item-required">*</span>
        <br/>
        <label for="rpassw" class="labels" style="width:120px">Repetir Password:</label>
        <input type="password" id="rpassw" name="rpassw" onkeypress="" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="" title="Repita su password" /> <span class="item-required">*</span>
        <div id="pass_d" style="text-align:right; color:red; font-size:11px; padding:2px 25px; display:none"></div>
</form>