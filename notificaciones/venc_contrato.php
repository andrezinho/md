<?php 
require_once '../lib/spdo.php';
$db = Spdo::singleton();

//Suscripcion que terminan dentro de 1 semana
$sql = "SELECT  e.razon_social as empresa,
				l.descripcion as local,
				u.nombres,
		        u.apellidos,
				l.email as email_local,        
				s.fecha_inicio,
		        s.fecha_fin,
		        s.num_publi,
		        u.email as email_publicador
		from suscripcion as s inner join local as l on l.idlocal = s.idlocal
			inner join empresa as e on e.idempresa = l.idempresa
		    inner join usuario as u on u.idlocal = l.idlocal
		 where s.fecha_fin >= CURDATE() AND s.fecha_fin <= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) ";

 $s = $db->prepare($sql);
 $s->execute();
 foreach ($s->fetchAll() as $r) 
 {
 	send_email($r); 	
 }


function send_email($datos)
{
	$email_to  = $datos['email_local']. ' ';			

    //$email_to .= 'andres.gm15@gmail.com';
    
    $email_subject = "Muchos Descuentos - Notificacion de Suscripcion";
    $html = '<div style="background: #FAFAFA; padding: 30px;">
                <div>
                    <img src="http://www.muchosdescuentos.com/images/logo.png" style="width:100px"/>
                </div>
                <h2 style="font-size:20px; color: #666666;">
                    Notificaci&oacute;n de Finalizaci&oacute;n de Suscripci&oacute;n
                </h2>
                <div style="font-size:14px; color: #666">
                    <p>Empresa: <b>'.utf8_decode($datos['empresa']).'</b></p>
                    <p>Local: <b>'.utf8_decode($datos['local']).'</b></p>
                    <p>Fecha Inicio: <b>'.utf8_decode($datos['fecha_inicio']).'</b></p>
                    <p>Fecha Finalizacion: <b>'.utf8_decode($datos['fecha_fin']).'</b></p>
                    <p>
                        Estimados Señores,<br/>
						Se le informa que su contrato de suscripci&oacute;n vence el <b>'.$datos['fecha_fin'].'</b>
                    </p>                
                </div>
            </div>
            <div style="background: #EEEEEE; padding: 20px; text-align: center;">
            </div>';
    
    $email_messaje = $html;
    
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Notificacion a Muchos Descuentos <soporte@muchosdescuentos.com>' . "\r\n";
    
    mail($email_to, $email_subject, $email_messaje, $headers);
    
}
?>