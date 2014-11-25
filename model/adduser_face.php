<?php 
require_once '../lib/spdo.php';
$db = Spdo::singleton();
$nombre_face   =   $_POST['name'];
$apellido_face =   $_POST['lastname'];
$email_face    =   $_POST['email'];
$id_face       =   $_POST['id'];

    $stmt = $db->prepare("SELECT count(idface) as n from usuario where idface=:c ");
    $stmt->bindParam(':c',$id_face,PDO::PARAM_STR);
    $stmt->execute();
    $r = $stmt->fetchObject();
    if($r->n==0)
    {
        try 
        {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->beginTransaction();
            
            $stmt = $db->prepare("INSERT INTO usuario (idperfil,nombres,apellidos,direccion,idubigeo,email,telefono,celular,idtipo_documento,nrodocumento,sexo,passw,usuariocol,idface) values(4,:n,:a,'','000000',:e,'','','','','','','',:i)");
            $stmt->bindParam(':n',$nombre_face,PDO::PARAM_STR);
            $stmt->bindParam(':a',$apellido_face,PDO::PARAM_STR);
            $stmt->bindParam(':e',$email_face,PDO::PARAM_STR);
            $stmt->bindParam(':i',$id_face,PDO::PARAM_STR);
            $stmt->execute();
            //sesiones

            $db->commit();            
        }
        catch(PDOException $e) 
        {
            $db->rollBack();
            print_r(json_encode(array('res'=>'2','msg'=>'Ha ocurrido un error, intentelo nuevamente.')));
        }
    }

?>