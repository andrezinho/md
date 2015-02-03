<?php 
session_start();
require_once '../lib/spdo.php';
require_once '../app/funciones.php';

echo $email = trim($_POST['mail']);
echo $idp=$_POST['idp'];
if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
{   
	$stmt = $db->prepare("SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion as desc_publi,
                             c.descripcion as categoria,p.precio,p.precio_regular, p.imagen,p.fecha_inicio,p.fecha_fin,p.hora_inicio,p.hora_fin,p.descuento,e.idempresa,e.dominio,e.razon_social as empresa,e.logo,e.facebook,e.twitter,e.youtube,e.razon_comercial,p.cc,
                             e.website,e.nombre_contacto, l.idubigeo,l.descripcion,
                             l.direccion,l.referencia,l.telefono1,l.telefono2,l.horario,
                             l.mapa_google,l.latitud,l.longitud
                      FROM publicaciones as p
                              INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                              INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                              INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion
                              INNER JOIN local as l on l.idlocal=su.idlocal
                              INNER JOIN empresa as e on e.idempresa=l.idempresa 
                       WHERE idpublicaciones=:id and l.idubigeo='".$_SESSION['idciudad']."'");
    $stmt->bindParam(':id',$idp,PDO::PARAM_STR);
    $stmt->execute();
    $r = $stmt->fetchObject();
    
    
    $email_to  = $email. '';        
	    //$email_to .= 'andres.gm15@gmail.com';
	    
	    $email_subject = "Ofertas - Muchos Descuentos";  
	    
	    $html = '<div style="background: #FAFAFA; padding: 30px;">
                <div>
                    <img src="http://www.muchosdescuentos.com/images/logo.png" width="150px" height="128px"/>
                </div>
                <h2 style="font-size:20px; color: #666666;">
                    &iexcl;Invitaci&oacute;n de oferta de un amigo!
                </h2>
                <div style="font-size:14px; color: #666">
                    <p>Hola, <b>'.$email.'</b></p>
                    <p><a href="http://www.muchosdescuentos.com/'.$r->dominio.'/producto/'.urls_amigables($r->titulo1."-".$r->idpublicaciones).'">'.$r->titulo1.'</a></p>
                <img src="http://www.muchosdescuentos.com/panel/web/imagenes/'.$r->imagen.'.jpg" /><br>
                <p><a href="http://www.muchosdescuentos.com/'.$r->dominio.'/producto/'.urls_amigables($r->titulo1."-".$r->idpublicaciones).'">'.$r->titulo2.'</a></p>
                <p><b>Precio Regula: S/.</b>'.$r->precio_regular.'</p>
                <p><b>Precio Oferta: S/.'.$r->precio.'</b></p>
                <p><b>Descuento:</b>&nbsp;'.$r->descuento.'</p>



                </div>
            </div>
            <div style="background: #EEEEEE; padding: 20px; text-align: center;">
                <p style="font-size:12px;">
                    Este correo fue enviado a <b>'.$email.'</b>
                </p>
                <p>                     
                    <a href="#" style="text-decoration: none;">T&eacute;rminos de Uso</a> |
                    <a href="#" style="text-decoration: none;">Pol&iacute;ticas de Privacidad</a> |
                    <a href="#" style="text-decoration: none;">Cont&aacute;ctenos</a>
                </p>
            </div>';
    
    $email_messaje = $html;
    
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.utf8_decode('Invitación').' de Ofertas de un amigo <soporte@muchosdescuentos.com>' . "\r\n";
    
    mail($email_to, $email_subject, $email_messaje, $headers);
    print_r(json_encode(array('res'=>'1','msg'=>'Mensaje Enviado.')));
   
        //print_r(json_encode(array('res'=>'2','msg'=>'El correo ingresado ya está registrado')));
}
else
{
    print_r(json_encode(array('res'=>'2','msg'=>'Correo incorrecto')));
}


?>