<?php 
require_once '../lib/spdo.php';
$email = $_GET['mail'];
if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
{
    $stmt = $db->prepare("SELECT count(*) as n,email,passw,nombres,apellidos from usuario where email = :c");
    $stmt->bindParam(':c',$email,PDO::PARAM_STR);
    $stmt->execute();
    $r = $stmt->fetchObject();
    $name=$r->nombres." ".$r->apellidos;
    if($r->n==0)
    {
         
            print_r(json_encode(array('res'=>'1','msg'=>'No encontramos su correo en nuestra Base de Datos,verifique porfavor.')));
    
    }
    else
    {
        if($r->passw!=''){


	    $email_to  = $email. '';        
	    //$email_to .= 'andres.gm15@gmail.com';
	    
	    $email_subject = "Muchos Descuentos - Recuperacion de cuenta";  
	    
	    $html = '<div style="background: #FAFAFA; padding: 30px;">
                <div>
                    <img src="http://www.muchosdescuentos.com/images/logo.png" width="150px" height="128px"/>
                </div>
                <h2 style="font-size:20px; color: #666666;">
                    &iexcl;Recuperacion de Cuenta de Muchos Descuentos!
                </h2>
                <div style="font-size:14px; color: #666">
                    <p>Hola, <b>'.utf8_encode($name).'</b></p>
                    <p>
                        Su cuenta de ingreso a Muchos Descuentos es:
                        <br><br>
                        <b>Email</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:'.$r->email.'
                        <br><b>Password</b>    :'.$r->passw.'
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
    $headers .= 'From: Recuperacion de contraseña de Muchos Descuentos <soporte@muchosdescuentos.com>' . "\r\n";
    
    mail($email_to, $email_subject, $email_messaje, $headers);
    print_r(json_encode(array('res'=>'4','msg'=>'Mensaje Enviado.')));
   }
   else{
			print_r(json_encode(array('res'=>'2','msg'=>'No encontramos su correo en nuestra Base de Datos,verifique porfavor')));    		
    	}

        //print_r(json_encode(array('res'=>'2','msg'=>'El correo ingresado ya está registrado')));
    }
}
else
{
    print_r(json_encode(array('res'=>'3','msg'=>'Correo incorrecto')));
}


?>