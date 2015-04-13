<?php  
       include("../lib/helpers.php");
       include("../view/header_form.php");
?>
<div style="width:700px"></div>
<form id="frm">
    <input type="hidden" name="controller" value="cupon" />
    <input type="hidden" name="action" value="save" />
        <input type="hidden" id="idcupon" name="idcupon" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->idcupon; ?>" readonly />                
        <h3>Datos del Cliente</h3>
        <table style="width:100%">
            <tr>
                <td><b>Cliente</b></td>
                <td>:&nbsp;<?php echo $obj->nombres." ".$obj->apellidos; ?></td>                        
                <td><b>Nro de Documento</b></td>
                <td>:&nbsp;<?php echo $obj->nrodocumento; ?></td>
            </tr>
            <tr>
                <td><b>Codigo de Reserva</b></td>
                <td>:&nbsp;<?php echo $obj->numero; ?> </td>
                <td><b>Fecha Limite</b></td>
                <td>:&nbsp;<?php echo $obj->fecha_fin; ?></td>
            </tr>
        </table>
        <br/>
        <h3>Información del Cupon</h3>
        
        <table>
            <tr>
                <td colspan="3"><b>Descuento</b></td>
            </tr>
            <tr>
                <td colspan="3"><?php echo $obj->titulo2; ?></td>
            </tr>
            <tr>
                <td><b>Precio Real</b></td>
                <td><b>Descuento</b></td>
                <td><b>Precio Final</b></td>
            </tr>
            <tr>
                <td><?php echo number_format($obj->precio_regular,2); ?></td>
                <td><?php echo utf8_decode($obj->descuento); ?></td>
                <td><b><?php echo number_format($obj->precio,2); ?></b></td>
            </tr>
            <tr>
                <td colspan="3"><b>Empresa</b></td>
            </tr>
            <tr>
                <td>Nombre: <?php echo $obj->razon_social; ?></td>
                <td>Direccion: <?php echo $obj->direccion." - ".$obj->ciudad; ?></td>
                <td>Telefonos: <?php echo $obj->telefono1.", ".$obj->telefono2; ?></td>
            </tr>
        </table>
        <?php if($obj->estado==1) { ?>
        <br/>
        <h3>Operaciones</h3>
        <label class="labels">Seleccione: &nbsp;&nbsp;&nbsp;</label>
        <span>
            <input type="radio" name="op" id="op_0" value="0" style="vertical-align:middle" /> <label for="op_0">Anular</label>  &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="op" id="op_2" value="2" style="vertical-align:middle" /> <label for="op_2">Entregar</label> &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="confirmar" id="confirmar" value="Confirmar Operacion" class="btn-default"/>
        </span>
        <?php }
        else {
                echo "<br/><span style='color:green'>*** Cupon procesado.</span>";
            } ?>
</form>