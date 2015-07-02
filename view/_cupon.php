<?php 
session_start();

require('../lib/spdo.php');
$tk = $_GET['token'];
$sql = "SELECT c.idcupon,
				c.token,
		        c.numero,
		        u.nombres,
		        u.apellidos,
		        u.nrodocumento,
		        u.email,
		        p.idpublicaciones,
		        p.fecha_fin,
		        p.precio_regular,
		        p.descuento,
		        p.precio,
		        e.razon_social,
		        l.direccion,	
		        l.telefono1,
		        l.telefono2,
		        l.email,
		        e.website,
		        e.bcp,
		        e.scotiabank,
		        e.interbank,
		        e.continental,
		        e.nacion,
		        e.otros,
		        p.titulo2,
		        p.cc,
		        ub.descripcion as ciudad,
		        e.idempresa
		FROM cupon as c inner join publicaciones as p on c.idpublicaciones = p.idpublicaciones
		inner join usuario as u on c.idcliente = u.idusuario
		inner join suscripcion as s on p.idsuscripcion = s.idsuscripcion
		inner join local as l on l.idlocal = s.idlocal
		inner join empresa as e on e.idempresa = l.idempresa
	    inner join ciudad as ci on ci.cod = l.idubigeo
		inner join ubigeo as ub on ub.idubigeo = ci.idciudad
		where c.token = :tk ";

$stmt = $db->prepare($sql);
$stmt->bindParam(':tk',$tk,PDO::PARAM_STR);
$stmt->execute();
$r = $stmt->fetchObject();

if($r->nombres!="")
{
?>
<style type="text/css">
    .table-cupon tr td { padding: 5px; border:1px solid #FFF;}
</style>
<h2>Gracias por su preferencia <b><?php echo $r->nombres." ".$r->apellidos; ?></b>. Este cup&oacute;n fue enviado a su correo electronico.</h2>
<div>
<div style="width:870px; margin:0 auto; padding:20px 15px; background:#fafafa;">
	<a target="_blank" href="<?php echo $host ?>/cupones/print_cupon.php?token=<?php echo $tk; ?>" style="float:right; color:#FFF; padding:3px 10px; background:#333"><i class="fa fa-print"></i> Imprimir</a>        
        &nbsp;&nbsp;
        <a href="javascript:" class="open-other-email" id="<?php echo $tk; ?>" style="float:right; color:#FFF; padding:3px 10px; background:#333"><i class="fa fa-mail-reply"></i> Enviar a email</a>        
        &nbsp;&nbsp;
<h2>Cupon de Pago</h2>
<p>
    A continuaci&oacute;n encontrar&aacute;s el cup&oacute;n para pagar tu reserva. Los pagos se realizan mediante dep&oacute;sitos en cuenta bancaria los mismo que se muestran 
    en este documento. Deber&aacute;s presentar este Cup&oacute;n junto al voucher de dep&oacute;sito para hacer efectivo el descuento.
</p>
<table class="table-cupon" style="width:100%;">
	<tr>
		<td bgcolor="#BFBFBF" style="width:150px"><b>Nombre</b></td><td bgcolor="#E7E7E7"><?php echo $r->nombres." ".$r->apellidos; ?></td>
		<td bgcolor="#BFBFBF" style="width:230px"><b>Documento de Identificacion</b></td><td bgcolor="#E7E7E7"><?php echo $r->nrodocumento ?></td>
	</tr>
	<tr>
		<td bgcolor="#BFBFBF"><b>Codigo de Reserva</b></td><td bgcolor="#E7E7E7"><?php echo $r->numero; ?></td>
		<td bgcolor="#BFBFBF"><b>Fecha Limite de Pago</b></td><td bgcolor="#E7E7E7"><?php echo $r->fecha_fin ?></td>
	</tr>
</table>
<br/>
<table class="table-cupon" style="width:100%;">
	<tr>
		<td bgcolor="#BFBFBF"><b>Informacion del Cupon</b></td>
	</tr>
</table>

<div style="padding:10px;">
	<p><b>Descuento:</b> <br/>
	<?php echo utf8_encode($r->titulo2); ?></p>

	<table style="width:80%;">
		<tr>
			<th align="left">Precio Real</th>
			<th align="left">Descuento</th>
			<th align="left">Precio Final</th>
		</tr>
		<tr>
			<td align="left">S/. <?php echo $r->precio_regular; ?></td>
			<td align="left"><?php echo $r->descuento; ?></td>
			<td align="left"><span style="background:#BFBFBF;padding:1px 8px;display:inline-block; font-weight:bold;">S/. <?php echo $r->precio; ?></span></td>
		</tr>
	</table>

	<p><b>Empresa:</b> <br/>
	Nombre: <?php echo utf8_encode($r->razon_social); ?><br/>
	Direccion: <?php echo utf8_encode($r->direccion." - ".$r->ciudad); ?><br/>
	Telefonos: <?php echo utf8_encode($r->telefono1." y ".$r->telefono2); ?><br/>
	</p>

	<div style="background:#E7E7E7;">
		<b>Cuentas Bancarias: </b> <br/>
		<table>
		<?php
			$stmt_ = $db->prepare("SELECT b.idbancos,b.descripcion as banco,eb.nrocuenta
                                  from empresa_bancos as eb inner join bancos as b on b.idbancos=eb.idbancos
                                  where eb.idempresa =:ide");
			$stmt_->bindParam(':ide',$r->idempresa,PDO::PARAM_INT);
			$stmt_->execute();
			$html_cta = '';
			foreach ($stmt_->fetchAll() as $r_) 
			{
            	?>
            	<tr>
            		<td><?php echo $r_['banco']; ?></td>
            		<td>:&nbsp;<?php echo $r_['nrocuenta']; ?></td>
            	</tr>
            	<?php

            	$html_cta .= '<tr>
		            		<td>'.$r_['banco'].'</td>
		            		<td>:&nbsp;'.$r_['nrocuenta'].'</td>
		            	  </tr>';
        	}
		?>
		</table>	
	</div>
	<br/>
	<table class="table-cupon" style="width:100%;">
	<tr>
		<td bgcolor="#BFBFBF"><b>Condiciones Comerciales</b></td>
	</tr>	
	</table>
	<?php echo utf8_encode($r->cc); ?>
</div>
</div>
</div>
<?php 		
} 
else
{
	echo "<h2>Error.</h2>";
}


?>