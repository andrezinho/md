<?php 
session_start();
require_once '../lib/spdo.php';
$db = Spdo::singleton();

$tk = $_POST['tk'];
$mail = $_POST['e'];


if(VerificarrDireccionCorreo($mail))
{
    send_email_completo($tk, $db, $mail);
}
else
{
    echo "Correo electronico inválido: ".$mail;
}





function send_email_completo($tk,$db,$mail)
{
    
    $sql = "SELECT c.idcupon,
                    c.token,
                    c.numero,
                    u.nombres,
                    u.apellidos,
                    u.nrodocumento,
                    u.email as email_u,
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

    $email_to  = $mail. ' ';
    

    $stmt_ = $db->prepare("SELECT b.idbancos,b.descripcion as banco,eb.nrocuenta
                                  from empresa_bancos as eb inner join bancos as b on b.idbancos=eb.idbancos
                                  where eb.idempresa =:ide");
    $stmt_->bindParam(':ide',$r->idempresa,PDO::PARAM_INT);
    $stmt_->execute();
    $html_cta = '';
    foreach ($stmt_->fetchAll() as $r_) 
    {
        $html_cta .= '<tr>
                    <td>'.$r_['banco'].'</td>
                    <td>:&nbsp;'.$r_['nrocuenta'].'</td>
                  </tr>';
    }

    //$email_to .= 'andres.gm15@gmail.com';
    
    $email_subject = "Muchos Descuentos - Cupon";
    $html = '<h2>Gracias por su preferencia, '.$r->nombres.' '.$r->apellidos.'</h2>
                <div>
                <div style="width:870px; margin:0 auto; padding:20px 15px; background:#fafafa;">
                    <a target="_blank" href="http://www.muchosdescuentos.com/cupones/print_cupon.php?token='.$tk.'" style="float:right; color:#FFF; padding:3px 10px; background:#333">Imprimir</a>
                <h2>Cupon de Pago</h2>
                <p>
                    A continuaci&oacute;n encontrar&aacute;s el cup&oacute;n para pagar tu reserva. Los p&aacute;gps se realizan mediante dep&oacute;sitos en cuenta bancaria los mismo que se muestran 
                    en este documento. Deber&aacute;s presentar este Cup&oacute;n junto al voucher de dep&oacute;sito para hacer efectivo el descuento.
                </p>
                <table class="table-cupon" style="width:100%;">
                    <tr>
                        <td bgcolor="#BFBFBF" style="width:150px"><b>Nombre</b></td><td bgcolor="#E7E7E7">'.$r->nombres.' '.$r->apellidos.'</td>
                        <td bgcolor="#BFBFBF" style="width:230px"><b>Documento de Identificacion</b></td><td bgcolor="#E7E7E7">'.$r->nrodocumento.'</td>
                    </tr>
                    <tr>
                        <td bgcolor="#BFBFBF"><b>Codigo de Reserva</b></td><td bgcolor="#E7E7E7">'.$r->numero.'</td>
                        <td bgcolor="#BFBFBF"><b>Fecha Limite de Pago</b></td><td bgcolor="#E7E7E7">'.$r->fecha_fin.'</td>
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
                    '.utf8_encode($r->titulo2).'</p>

                    <table style="width:80%;">
                        <tr>
                            <th align="left">Precio Real</th>
                            <th align="left">Descuento</th>
                            <th align="left">Precio Final</th>
                        </tr>
                        <tr>
                            <td align="left">S/. '.$r->precio_regular.'</td>
                            <td align="left">'.$r->descuento.'</td>
                            <td align="left"><span style="background:#BFBFBF;padding:1px 8px;display:inline-block; font-weight:bold;">S/. '.$r->precio.'</span></td>
                        </tr>
                    </table>

                    <p><b>Empresa:</b> <br/>
                    Nombre: '.utf8_encode($r->razon_social).'<br/>
                    Direccion: '.utf8_encode($r->direccion.' - '.$r->ciudad).'<br/>
                    Telefonos: '.utf8_encode($r->telefono1.' y '.$r->telefono2).'<br/>
                    </p>

                    <div style="background:#E7E7E7;">
                        <b>Cuentas Bancarias: </b> <br/>
                        <table>
                            '.$html_cta.'
                        </table>    
                    </div>
                    <br/>
                    <table class="table-cupon" style="width:100%;">
                    <tr>
                        <td bgcolor="#BFBFBF"><b>Condiciones Comerciales</b></td>
                    </tr>   
                    </table>
                    '.utf8_encode($r->cc).'
                </div>
                </div></div>';
    
    $email_messaje = $html;
    
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Cupon <soporte@muchosdescuentos.com>' . "\r\n";    
    mail($email_to, $email_subject, $email_messaje, $headers);
    
}

function send_email($email,$name,$tk,$host)
{
    $email_to  = $email. '';        
    //$email_to .= 'andres.gm15@gmail.com';
    
    $email_subject = "Cupon de Pago";  
    
    $html = '<div style="background: #FAFAFA; padding: 30px;">
                <div>
                    <img src="http://www.muchosdescuentos.com/images/logo.png" style="width:100px"/>
                </div>
                <h2 style="font-size:20px; color: #666666;">
                    &iexcl;Gracias por tu Preferencia!
                </h2>
                <div style="font-size:14px; color: #666">
                    <p>Hola, <b>'.utf8_decode($name).'</b></p>
                    <p>
                        Aqui está tu cupon: <a target="_blank" href="'.$host.'/cupones/print_cupon.php?token='.$tk.'">Ver el Cupon</a>
                    </p>                
                </div>
            </div>
            <div style="background: #EEEEEE; padding: 20px; text-align: center;">
                <p style="font-size:12px;">
                    Este correo fue enviado a <b>'.$email.'</b>
                </p>                
            </div>';
    
    $email_messaje = $html;
    
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Muchos Descuentos <soporte@muchosdescuentos.com>' . "\r\n";
    
    mail($email_to, $email_subject, $email_messaje, $headers);
    
    }
    
function VerificarrDireccionCorreo($direccion)
{
   $Sintaxis='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
   if(preg_match($Sintaxis,$direccion))
      return true;
   else
     return false;
}
?>