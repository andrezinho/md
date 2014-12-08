<?php 
require_once '../lib/spdo.php';
$db = Spdo::singleton();
$nombres       =   $_POST['nombres'];
$apellidos     =   $_POST['apellidos'];
$email         =   $_POST['email'];
$passw         =   $_POST['passw'];
$tipodoc       =   $_POST['tipodoc'];
$ndoc          =   $_POST['ndoc'];
$telefono      =   $_POST['telefono'];
$celular       =   $_POST['celular'];
$sexo       =   $_POST['sexo'];

    $stmt = $db->prepare("SELECT count(email) as n from usuario where idface=:c ");
    $stmt->bindParam(':c',$email,PDO::PARAM_STR);
    $stmt->execute();
    $r = $stmt->fetchObject();
    if($r->n==0)
    {
        try 
        {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->beginTransaction();
            
            $stmt = $db->prepare("INSERT INTO usuario (idperfil,nombres,apellidos,direccion,idubigeo,email,telefono,celular,idtipo_documento,nrodocumento,sexo,passw,idface) values(4,:n,:a,'','000000',:e,:t,:c,:ti,:nd,:s,:p,'')");
            $stmt->bindParam(':n',$nombres,PDO::PARAM_STR);
            $stmt->bindParam(':a',$apellidos,PDO::PARAM_STR);
            $stmt->bindParam(':e',$email,PDO::PARAM_STR);
            $stmt->bindParam(':t',$telefono,PDO::PARAM_STR);
            $stmt->bindParam(':c',$celular,PDO::PARAM_STR);
            $stmt->bindParam(':ti',$tipodoc,PDO::PARAM_STR);
            $stmt->bindParam(':nd',$ndoc,PDO::PARAM_STR);
            $stmt->bindParam(':s',$sexo,PDO::PARAM_STR);
            $stmt->bindParam(':p',$passw,PDO::PARAM_STR);
            
            $stmt->execute();
            //sesiones

            $db->commit();

            print_r(json_encode(array('res'=>'1','msg'=>'Se ha Registrado Correctamente.')));            
        }
        catch(PDOException $e) 
        {
            $db->rollBack();
            print_r(json_encode(array('res'=>'2','msg'=>'Ha ocurrido un error, intentelo nuevamente.')));
        }
    }
    else{
        print_r(json_encode(array('res'=>'2','msg'=>'Este correo ya exite.')));
    }


?>