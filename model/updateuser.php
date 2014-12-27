<?php 
require_once '../lib/spdo.php';
$db = Spdo::singleton();
$nombres       =   $_POST['nombres'];
$apellidos     =   $_POST['apellidos'];
$email         =   $_POST['mail'];
$tipodoc       =   $_POST['tipodoc'];
$ndoc          =   $_POST['ndoc'];
$telefono      =   $_POST['telefono'];
$celular       =   $_POST['celular'];
$idface       =   $_POST['idface'];


    $stmt = $db->prepare("SELECT count(email) as n from usuario where idface=:c ");
    $stmt->bindParam(':c',$idface,PDO::PARAM_STR);
    $stmt->execute();
    $r = $stmt->fetchObject();
    if($r->n>0)
    {
        try 
        {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->beginTransaction();
            
            $stmt = $db->prepare("UPDATE usuario SET nombres=:n,apellidos=:a,idtipo_documento=:ti,nrodocumento=:nd,telefono=:t,celular=:c WHERE idface=:f");
            $stmt->bindParam(':n',utf8_decode($nombres),PDO::PARAM_STR);
            $stmt->bindParam(':a',utf8_decode($apellidos),PDO::PARAM_STR);
            //$stmt->bindParam(':e',$email,PDO::PARAM_STR);
            $stmt->bindParam(':t',$telefono,PDO::PARAM_STR);
            $stmt->bindParam(':c',$celular,PDO::PARAM_STR);
            $stmt->bindParam(':ti',$tipodoc,PDO::PARAM_STR);
            $stmt->bindParam(':nd',$ndoc,PDO::PARAM_STR);
            $stmt->bindParam(':f',$idface,PDO::PARAM_STR);
            //$stmt->bindParam(':s',$sexo,PDO::PARAM_STR);
            //$stmt->bindParam(':p',$passw,PDO::PARAM_STR);
            
            $stmt->execute();
            //sesiones

            $db->commit();

            print_r(json_encode(array('res'=>'1','msg'=>'Se ha Actualizado Correctamente.')));            
        }
        catch(PDOException $e) 
        {
            $db->rollBack();
            print_r(json_encode(array('res'=>'2','msg'=>'Ha ocurrido un error, intentelo nuevamente.')));
        }
    }
    else{
        print_r(json_encode(array('res'=>'2','msg'=>'Ha ocurrido un error, intentalo nuevamente, si el error persiste comuniquese con su administrador.')));
    }


?>