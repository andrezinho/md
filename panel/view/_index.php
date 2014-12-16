<div class="div_container">
<div class="box-heading" style="background: #dadada;border-bottom: 1px solid #BDBDBD;">
    <span style="color:#000;font-weight: normal;">
    	Elija una de las opciones del menú.
    </span>
</div>
<div style="width: 920px; float:left;">
<div id="" class="cont-grid">
  <div style="padding:10px;">
    <div style="padding:10px;  min-height:400px" class="ui-widget-content ui-corner-top">
        <div class="operaciones">  
        </div>
        <div style="padding:10px 0 0px; ">
            
        </div>
    </div>
    <div>
      <table id="list"></table>
      <div id="pager"></div>
    </div>
  </div>
</div>
</div>
<div class="box-lateral">
<div class="box-lateral-option">
    <div style="padding:3px 5px; text-align: center">Bienvenido, <b><?php echo $_SESSION['name'] ?></b></div>
    <div>
        <ul class="enlaces-menu">
            <li><a href="../../index.php">Regresar a Inicio</a></li>
            <li><a id="change_passw" href="#">Cambiar Contraseña</a></li>            
            <li><a href="index.php?controller=user&action=logout" class="logout">Cerrar Session</a></li>            
        </ul>
    </div>
</div>
</div>
  <div id="box-frm" class="ui-widget-content ui-corner-all" style="height:400px; width:890px; display:none; margin:5px auto">      
  </div>
<div style="clear:both"></div>
</div>