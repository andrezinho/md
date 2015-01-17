<?php 
session_start();
require_once '../lib/spdo.php';
$db = Spdo::singleton();
$error=false;
$errores=array();
$new_user=false;

$idpublicacion = $_POST['idp'];

if(isset($_POST['nombres'])&&isset($_POST['email']))
{
    //
    
    if(trim($_POST['nombres'])=="")
    {
        $error = true;
        $errores[] = array('input_'=>'nombres','msg'=>'Ingrese su Nombre','tipo'=>'user');
    }
    else
    {
        $nombres   =   utf8_decode($_POST['nombres']);
    }
    //
    if(trim($_POST['apellidos'])=="")
    {
        $error = true;
        $errores[] = array('input_'=>'apellidos','msg'=>'Ingrese sus apellidos','tipo'=>'user');
    }
    else
    {
        $apellidos    =   utf8_decode($_POST['apellidos']);
    }
    //
    if(trim($_POST['email'])=="")
    {
        $error = true;
        $errores[] = array('input_'=>'apellidos','msg'=>'email','tipo'=>'user');
    }
    else
    {   
        $email = $_POST['email'];
        if(VerificarrDireccionCorreo($email))
        {
            $stmt = $db->prepare("SELECT count(email) as n from usuario where email=:c ");
            $stmt->bindParam(':c',$email,PDO::PARAM_STR);
            $stmt->execute();
            $r = $stmt->fetchObject();
            if($r->n>0)
            {
                $error = true;
                $errores[] = array('input_'=>'email','msg'=>'Este email ya está registrado.','tipo'=>'user');
            }
        }
    }
    if(trim($_POST['passw'])=="")
    {
        $error = true;
        $errores[] = array('input_'=>'apellidos','msg'=>'Ingrese su contraseña','tipo'=>'user');
    }
    else
    {        
        $passw = $_POST['passw'];
        if($_POST['rpassw']!=$passw)
        {
            $error=true;
            $errores[] = array('input_'=>'rpassw','msg'=>'Las contraseñas no son iguales.','tipo'=>'user');
        }
    }

    if(trim($_POST['ndoc'])=="")
    {
        $error = true;
        $errores[] = array('input_'=>'ndoc','msg'=>'Ingrese su nro de documento','tipo'=>'user');
    }
    else
    {
        $idtipo_documento = $_POST['tipodoc'];
        $ndoc    =   $_POST['ndoc'];
        $l = strlen($ndoc);

        switch ($idtipo_documento) {
            case 1:
                    if($l!=8)
                    {
                        $error = true;
                        $errores[] = array('input_'=>'ndoc','msg'=>'Ingrese un DNI Correcto: 8 digitos.','tipo'=>'user');
                    }
                break;
            case 2:
                    if($l!=11)
                    {
                        $error = true;
                        $errores[] = array('input_'=>'ndoc','msg'=>'Ingrese un RUC Correcto: 11 digitos.','tipo'=>'user');
                    }
                break;
            case 3:
            case 4:
                    if($l>5)
                    {
                        $error = true;
                        $errores[] = array('input_'=>'ndoc','msg'=>'Ingrese un nro de documento correcto.','tipo'=>'user');
                    }
                break;
            
            default:
                    $error = true;
                    $errores[] = array('input_'=>'ndoc','msg'=>'El tipo de docuemento no existe','tipo'=>'user');
                break;
        }
        
    }

    $sexo = $_POST['sexo'];
    

    if($error)
    {
        print_r(json_encode($errores));
        die;
    }
    else
    {   
        $new_user=true;     
        //Nuevo usuraio        
    }
}
    try 
    {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->beginTransaction();

        if($new_user)
        {
            //Registramos el nuevo usuario
            $sql = "INSERT INTO usuario
                                (idperfil,
                                idtipo_documento,
                                idubigeo,
                                nombres,
                                apellidos,
                                direccion,
                                email,                            
                                nrodocumento,
                                sexo,
                                passw,
                                estado) values(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11)";
            $stmt = $db->prepare($sql);
            $idperfil = 4;
            $idubigeo="000000";
            $estado=1;$direccion="";
            $stmt->bindParam(':p1',$idperfil,PDO::PARAM_INT);
            $stmt->bindParam(':p2',$idtipo_documento,PDO::PARAM_INT);
            $stmt->bindParam(':p3',$idubigeo,PDO::PARAM_STR);
            $stmt->bindParam(':p4',$nombres,PDO::PARAM_STR);
            $stmt->bindParam(':p5',$apellidos,PDO::PARAM_STR);
            $stmt->bindParam(':p6',$direccion,PDO::PARAM_STR);
            $stmt->bindParam(':p7',$email,PDO::PARAM_STR);
            $stmt->bindParam(':p8',$ndoc,PDO::PARAM_STR);
            $stmt->bindParam(':p9',$sexo,PDO::PARAM_INT);
            $stmt->bindParam(':p10',$passw,PDO::PARAM_STR);
            $stmt->bindParam(':p11',$estado,PDO::PARAM_INT);
            $p=$stmt->execute();
            
            //Obtenemos los datos del cliente registrado
            $sql = "SELECT max(idusuario) as idu from usuario where email = :e ";
            $stmt2 = $db->prepare($sql);
            $stmt2->bindParam(':e',$email,PDO::PARAM_STR);
            $stmt2->execute();
            $r = $stmt2->fechtObject();
            $idusuario = $r->idu;    
            $name = $nombres." ".$apellidos;
        }
        else
        {
            if(isset($_SESSION['idusuario']))
            {
                $idusuario = $_SESSION['idusuario']; 
                $name = $_SESSION['name'];
                $email = $_SESSION['email'];
            }
            else
            {
                $error = true;
                $errores[] = array('input_'=>'','msg'=>'Debe iniciar sesion con su cuenta de usuario.','tipo'=>'alert');
                print_r(json_encode($errores));
                die;
            }
        }

        //Insertamos el cupon
        $sql_p = "SELECT p.precio, c.cod
                  from publicaciones as p inner join suscripcion as s on s.idsuscripcion = p.idsuscripcion
                    inner join local as l on l.idlocal = s.idlocal inner join ciudad as c on c.idciudad = l.idubigeo
                  where p.idpublicaciones = :idp";
        $stmt_p = $db->prepare($sql_p);
        $stmt_p->bindParam(':idp',$idpublicacion,PDO::PARAM_INT);
        $stmt_p->execute();
        $ar = $stmt_p->fetchObject();
        $precio = $ar->precio;
        $ciudad = str_pad($ar->cod,2,'0',0);
        $sql_cupon = "INSERT INTO cupon
                            (numero,
                            idpublicaciones,
                            idcliente,
                            fecha,
                            hora,
                            costo_descuento,
                            estado,
                            token)
                            VALUES (:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8)";
        $stmt_c = $db->prepare($sql_cupon);
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $estado = 1;

        $d = str_pad(date('d'), 2,'0',0);
        $m = str_pad(date('m'), 2,'0',0);
        $y = str_pad(substr(date('Y'),2), 2,'0',0);

        $cod = genera_cod();
        $token = genera_token($cod);

        $numero = $cod; //$d.$m.$y.$ciudad;
        /*
            Estados:
            1: Registrado y disponible
            2: Pagado
            3: Vencido
            4: Anulado
        */
        $stmt_c->bindParam(':p1',$numero,PDO::PARAM_STR);
        $stmt_c->bindParam(':p2',$idpublicacion,PDO::PARAM_INT);
        $stmt_c->bindParam(':p3',$idusuario,PDO::PARAM_INT);
        $stmt_c->bindParam(':p4',$fecha,PDO::PARAM_STR);
        $stmt_c->bindParam(':p5',$hora,PDO::PARAM_STR);
        $stmt_c->bindParam(':p6',$precio,PDO::PARAM_INT);
        $stmt_c->bindParam(':p7',$estado,PDO::PARAM_INT);
        $stmt_c->bindParam(':p8',$token,PDO::PARAM_STR);

        $stmt_c->execute();
        $db->commit();

        send_email($email,$name,$token,$host)

        print_r(json_encode(array('res'=>'1','msg'=>'Se ha Registrado Correctamente.','tipo'=>'trans','token'=>$token)));            
    }
    catch(PDOException $e) 
    {
        $db->rollBack();
        print_r(json_encode(array('res'=>'2','msg'=>'Ha ocurrido un error, intentelo nuevamente. '.$e->getMessage().' - idp '.$idpublicacion,'tipo'=>'trans')));
    }
  

function VerificarrDireccionCorreo($direccion)
{
   $Sintaxis='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
   if(preg_match($Sintaxis,$direccion))
      return true;
   else
     return false;
}

function genera_cod()
{
    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $cad = "";
    for($i=0;$i<6;$i++) 
    {
        $cad .= substr($str,rand(0,26),1);
    }
    return $cad;
}

function genera_token($cod_reserva)
{
    $key_secret = 'dfa%d_FQ{]2Ñf523scvDAgfasg';
    return md5($key_secret.$cod_reserva);
}
function send_email($email,$name,$tk,$host)
{
    $email_to  = $email. '';        
    //$email_to .= 'andres.gm15@gmail.com';
    
    $email_subject = "Cupon de Pago";  
    
    $html = '<div style="background: #FAFAFA; padding: 30px;">
                <div>
                    <img src="http://www.muchosdescuentos.com/img/logo.png"/>
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
?>