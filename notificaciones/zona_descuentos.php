<?php 
require_once '../lib/spdo.php';
require_once '../app/funciones.php';
$db = Spdo::singleton();

//Buscamos todas las ciudades que hay
$sql = "SELECT * FROM ciudad as c inner join ubigeo as u on u.idubigeo = c.idciudad order by cod";
$q = $db->prepare($sql);
$q->execute();

foreach($q->fetchAll() as $ciudad)
{
    //Obtenemos todos los locales pertenecientes a esa zona
    $sql = "SELECT idlocal from local where idubigeo = ".$ciudad['cod'];
    $ql = $db->prepare($sql);
    $ql->execute();    
    $locales="";
    foreach($ql->fetchAll() as $local)
    {
        $locales .= $local['idlocal'].",";
    }
    
    if($locales!="")
    {
        $t = strlen($locales);
        $locales = substr($locales, 0, $t-1);
        //Obetenemos todas publicaciones que hicieron esos locales la ultima semana
        $SQL = "SELECT *
            from publicaciones as p inner join suscripcion as s on s.idsuscripcion = p.idsuscripcion
                inner join local as l on l.idlocal = s.idlocal
                inner join empresa as e on e.idempresa = l.idempresa
             where s.idlocal in (".$locales.")        
                    and p.fecha_inicio >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) ";
        $Q = $db->prepare($SQL);
        $Q->execute();

        $html = '<h2>Nuevos descuentos en '.$ciudad['descripcion'].' '.$ciudad['zona'].'!</h2>';    
        foreach($Q->fetchAll() as $rr)
        {
            $img=$host."/panel/web/imagenes/".$rr['imagen'].".jpg";        
            $link = $host."/".$rr['dominio']."/producto/".urls_amigables($rr['titulo1']."-".$rr['idpublicaciones']);
            $html .= '<div style="margin:20px 0; padding:5px; background: #FAFAFA; width:400px">
                        <table>
                          <tr>
                            <td><img src="'.$img.'" width="50" ></td>
                            <td>'.$rr['titulo2'].'</td>
                          </tr>
                        </table>
                        <hr>
                        <table style="width:100%">
                          <td width="200" align="right">Precio</td>
                          <td><b>S/. '.$rr['precio'].'</b></td>
                          <td style="text-align: right;"><a target="_blank" href="'.$link.'" style="font-size:11px; color:red">Ver Descuento</a></td>
                        </table>                       
                     </div>';
        }

        //Enviar a los suscritos en esos locales
        //echo $locales;
        $sql = "SELECT distinct * from email where local in (".$locales.")";
        $qu = $db->prepare($sql);
        $qu->execute();
        foreach($qu->fetchAll() as $ru)
        {
            send_email_($ru['correo'],$ru['nombre'],$html);
        }
        
    }
    
    
    
}

echo "Se ha enviado con exito los correos";
function send_email_($email,$nombre,$html2)
{
    $email_to  = $email. ' ';        
    
    $email_subject = "Muchos Descuentos - Nuevas Ofertas";
    $html = '<div style="background: #FAFAFA; padding: 30px;">
                <div>
                    <img src="http://www.muchosdescuentos.com/images/logo.png" style="width:100px"/>
                </div>                
                <div style="font-size:14px; color: #666">
                    <p>
                        Hola '.$nombre.', <br/>
                        Estos son los nuevos descuentos y ofertas que hay.                        
                        '.$html2.'
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

