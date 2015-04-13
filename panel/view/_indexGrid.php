<script type="text/javascript">
var timeoutHnd;
var flAuto = true;
var cNames = <?php print_r(json_encode($colsNames)); ?>;
var cModel = <?php print_r(json_encode($colsModels)); ?>;
$(document).ready(function()
{
  $("#qry").focus();
  $("#list").jqGrid({
      url:'index.php?controller=<?php echo $controlador; ?>&action=indexGrid',
      datatype: "json",
      colNames:cNames,
      colModel:cModel,
      rowNum:10,
      rowList:[10,20,40],
      pager: '#pager',
      sortname: '1',
      viewrecords: true,
      width:898,
      height:300,
      sortorder: "desc",
      multiselect: false,
      rownumbers: true,
      caption:"Lista de <?php if($titulo!="") echo $titulo; else echo $controlador; ?> Registrados"
    });
    $("#fltr").change(function(){
        $("#qry").focus();
    });
    $("#box-frm").dialog({
      modal:true,
      autoOpen:false,
      width:'auto',
      height:'auto',
      resizing:true,
      // maxHeight: 600,
      title:'Formulario de <?php if($titulo!="") echo $titulo; else echo $controlador; ?>'      
    });
    $('.nuevo').click(function(){nuevo();});
    $('.editar').click(function(){editar();});
    $('.eliminar').click(function(){eliminar();});
    $('.ver').click(function(){ver();});
});
function doSearch(ev)
{
  if(!flAuto)
    return;
  if(timeoutHnd)
    clearTimeout(timeoutHnd)
  timeoutHnd = setTimeout(gridReload,500)
}
function gridReload()
{
  var fltr = $("#fltr").val();
  var qry = $("#qry").val();
  $("#list").jqGrid('setGridParam',{url:"index.php?controller=<?php echo $controlador; ?>&action=indexGrid&f="+fltr+"&q="+qry,page:1}).trigger("reloadGrid");
}
function enableAutosubmit(state)
{
  flAuto = state;
}
function editar()
{
    var gr = $("#list").jqGrid('getGridParam','selrow');
    if(gr!=null) 
    {        
        $("#loader").css("display","inline-block");
        $.get('index.php?controller=<?php echo $controlador; ?>&action=edit&id='+gr,function(html)
        {
           $.getScript("js/app/evt_form_<?php echo strtolower($controlador); ?>.js");
           $("#box-frm").dialog({buttons: {
                  'Cancelar': function(){ $(this).dialog('close');},
                  'Actualizar':function(){save();}
                }});
           $("#box-frm").empty().append(html);
           $("#box-frm").dialog("open");
           $("#loader").css("display","none");
        });
    }
    else 
    {
      alert("Seleccione un registro por favor.");
    }
}
function ver()
{
    var gr = $("#list").jqGrid('getGridParam','selrow');
    if(gr!=null) 
    {        
        $("#loader").css("display","inline-block");
        $.get('index.php?controller=<?php echo $controlador; ?>&action=view&id='+gr,function(html)
        {
           $.getScript("js/app/evt_form_<?php echo strtolower($controlador); ?>.js");
           $("#box-frm").dialog({buttons: {
                  'Cerrar': function(){ $(this).dialog('close');}                  
                }});
           $("#box-frm").empty().append(html);
           $("#box-frm").dialog("open");
           $("#loader").css("display","none");
        });
    }
    else 
    {
      alert("Seleccione un registro por favor.");
    }
}
function nuevo()
{
    $("#loader").css("display","inline-block");
    $.get('index.php?controller=<?php echo $controlador; ?>&action=create',function(html)
    {
       $.getScript("js/app/evt_form_<?php echo strtolower($controlador); ?>.js");
       $("#box-frm").dialog({buttons: {
                  'Cancelar': function(){ $(this).dialog('close');},
                  'Confirmar Registro':function(){save();}
                }});
       $("#box-frm").empty().append(html);
       $("#box-frm").dialog("open");
       $("#loader").css("display","none");
    });
}
function eliminar()
{
  var gr = $("#list").jqGrid('getGridParam','selrow');
  if(gr!=null) 
  {
    if(confirm('Deseas eliminar el registro?'))
    {
       $.get('index.php?controller=<?php echo $controlador; ?>&action=delete&id='+gr,function(data){
          if(data[0]==1) gridReload();
            else alert("Ha ocurrido un problema, por favor intentelo nuevamente.");
       },'json');
    }
  }
}
</script>
<?php 
  if(isset($script)&&$script!="")
  {
    ?>
    <script type="text/javascript" src="js/app/<?php echo $script; ?>" ></script>
    <?php
  }
?>
<div class="div_container">
<div class="box-heading" style="background: #dadada;border-bottom: 1px solid #BDBDBD;">
    <span style="color:#000;font-weight: normal;">
        
        <?php 
            if($enlace!="") {echo ucfirst($enlace);}
            else
            {
                if($titulo!="") {echo ucfirst($titulo); }
                else {echo ucfirst($controlador); }
            }
            
        ?>
            
    </span>
</div>
<div style="width: 920px; float:left;">
<div id="" class="cont-grid">
  <div style="padding:10px;">
    <div style="padding:10px; border-bottom:0 " class="ui-widget-content ui-corner-top">
        <div class="operaciones">   
          <?php if($actions[0])
          { ?>
          <a class="nuevo"  title="Nuevo Registro">            
              <span  class="box-boton boton-new"></span>
              <label>Nuevo</label>
          </a>
          <?php 
          }
          if($actions[1])
          {
          ?>
          <a class="editar"  title="Editar Registro">            
              <span  class="box-boton boton-edit"></span> 
              <label>Editar</label>
          </a>
          <?php 
          }
          if($actions[2])
          {
          ?>
          <a class="eliminar"  title="Eliminar Registro" style="color:red;">            
              <span  class="box-boton boton-delete"></span> 
              <label>Eliminar</label>
          </a>
          <?php
          }
          if($actions[3])
          {
          ?>
          <a class="ver" title="Ver Registro">            
              <span class="box-boton boton-view"></span> 
              <label>Ver</label>
          </a>

          <?php
          }
          if($actions[4])
          {
          ?>
          <a class="anular" title="Anular">            
              <span class="box-boton boton-anular"></span> 
              <label>Anular</label>
          </a>

          <?php
          }
          if($actions[5])
          {
          ?>
          <a class="print" title="Imprimir">            
              <span class="box-boton boton-print"></span> 
              <label>Imprimir</label>
          </a>
          <?php
          }
          ?>           
          <span id="loader" style="float:right; display:none"><img src="images/loader.gif" /></span>
        </div>
        <div style="padding:10px 0 0px; ">
              <label>Buscar por :</label>
              <?php echo $cmb_search; ?>
              <input type="text" name="qry" id="qry" value="" class="ui-widget-content ui-corner-all text" style="width:250px" onkeydown="doSearch(arguments[0]||event)" />
              <a href="javascript:" id="submitButton" onclick="gridReload()" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-search"></span>Buscar</a>
              <div style="vertical-align: top;display:inline-block"><input type="checkbox" id="autosearch" checked="" onclick="enableAutosubmit(this.checked)"></div>&nbsp;AutoBusqueda              
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