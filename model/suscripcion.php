<?php 
require_once '../lib/spdo.php';
$db = Spdo::singleton();
$email = $_POST['e'];
$name = $_POST['n'];
$idem = $_POST['em'];
if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
{
    $stmt = $db->prepare("SELECT count(*) as n from email where correo = :c");
    $stmt->bindParam(':c',$email,PDO::PARAM_STR);
    $stmt->execute();
    $r = $stmt->fetchObject();
    if($r->n==0)
    {
        try 
        {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->beginTransaction();
            $email = substr($email,0,50);
            $name = substr($name,0,100);
            
            $fecha = date('Y-m-d');
            $stmt = $db->prepare("INSERT INTO email(correo,fecha,nombre,empresa) values(:c,:f,:n,:e)");
            $stmt->bindParam(':c',$email,PDO::PARAM_STR);
            $stmt->bindParam(':f',$fecha,PDO::PARAM_STR);
            $stmt->bindParam(':n',$name,PDO::PARAM_STR);
            $stmt->bindParam(':e',$idem,PDO::PARAM_STR);
            $stmt->execute();
            send_email($email,$name);
            $db->commit();            
            print_r(json_encode(array('res'=>'1','msg'=>$email)));
        }
        catch(PDOException $e) 
        {
            $db->rollBack();
            print_r(json_encode(array('res'=>'2','msg'=>'Ha ocurrido un error, intentelo nuevamente. '.$e->getMessage())));
        }
    }
    else
    {
        print_r(json_encode(array('res'=>'2','msg'=>'El correo ingresado ya está registrado')));
    }
}
else
{
    print_r(json_encode(array('res'=>'2','msg'=>'Correo incorrecto')));
}

function send_email($email,$name)
{
    $email_to  = $email. '';        
    //$email_to .= 'andres.gm15@gmail.com';
    
    $email_subject = "Muchos Descuentos - Suscripcion";  
    
    $html = '<div style="background: #FAFAFA; padding: 30px;">
                <div>
                    <img src="http://www.muchosdescuentos.com/img/logo.png"/>
                </div>
                <h2 style="font-size:20px; color: #666666;">
                    &iexcl;Bienvenido a Muchos Descuentos!
                </h2>
                <div style="font-size:14px; color: #666">
                    <p>Hola, <b>'.utf8_decode($name).'</b></p>
                    <p>
                        Gracias por Suscribirte a Muchos Descuentos, muy pronto recibir&aacute;s los mejores descuentos que hay en tu ciudad.
                    </p>                
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
    $headers .= 'From: Suscripcion a Muchos Descuentos <soporte@muchosdescuentos.com>' . "\r\n";
    
    mail($email_to, $email_subject, $email_messaje, $headers);
    
}
?>