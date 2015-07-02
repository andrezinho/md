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
                    inner join local as l on l.idlocal = s.idlocal inner join ciudad as c on c.cod = l.idubigeo
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

        send_email_completo($token,$db);


        $db->commit();

        //send_email($email,$name,$token,$host);
        

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


function send_email_completo($tk,$db)
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

    $email_to  = $r->email_u. ' ';
    

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
?>