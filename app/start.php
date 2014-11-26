<?php

session_start();
require_once '/lib/spdo.php';
require '/config/facebook.php';
require '/vendor/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\GraphUser;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;

FacebookSession::setDefaultApplication($config['app_id'], $config['app_secret']);
$helper = new FacebookRedirectLoginHelper('http://www.muchosdescuentos.com/pe/');

try {
	$session = $helper->getSessionFromRedirect();

	if ($session):
		$_SESSION['facebook'] = $session->getToken();
		header('Location: index.php');
	endif;

	if (isset($_SESSION['facebook'])):
		$session = new FacebookSession($_SESSION['facebook']);

		$request = new FacebookRequest($session, 'GET', '/me');
		$response = $request->execute();
		$graphObjectClass = $response->getGraphObject(GraphUser::className());
		$facebook_user = $graphObjectClass;



		$db = Spdo::singleton();

				$nombres       =   $facebook_user->getName();
				$nombre_face   =   $facebook_user->getFirstName();
				$apellido_face =   $facebook_user->getLastName();
				$email_face    =   $facebook_user->getProperty('email');
				$id_face       =   $facebook_user->getId();

			    $stmt = $db->prepare("SELECT count(idface) as n from usuario where idface=:c ");
			    $stmt->bindParam(':c',$id_face,PDO::PARAM_STR);
			    $stmt->execute();
			    $r = $stmt->fetchObject();
			    $nombre_face = utf8_decode($nombre_face);
			    $apellido_face = utf8_decode($apellido_face);
			    if($r->n==0)
			    {
			        try 
			        {
			            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			            $db->beginTransaction();
			            
			            $stmt = $db->prepare("INSERT INTO usuario (idperfil,nombres,apellidos,direccion,idubigeo,email,telefono,celular,idtipo_documento,nrodocumento,sexo,passw,idface) 
			            						values(4,:n,:a,'','000000',:e,'','','','','','',:i)");
			            $stmt->bindParam(':n',$nombre_face,PDO::PARAM_STR);
			            $stmt->bindParam(':a',$apellido_face,PDO::PARAM_STR);
			            $stmt->bindParam(':e',$email_face,PDO::PARAM_STR);
			            $stmt->bindParam(':i',$id_face,PDO::PARAM_STR);
			            $stmt->execute();
			            //sesiones
			            $stmt = $db->prepare("SELECT u.nrodocumento,u.idusuario,u.idperfil,
			            							 CONCAT(u.nombres, ' ', u.apellidos) As nombres,
			            							 u.email,
			            							 u.idface,
			            							 p.descripcion as perfil
			            					 from usuario as u inner join perfil as p on p.idperfil = u.idperfil where u.idface=:c ");
						$stmt->bindParam(':c',$id_face,PDO::PARAM_STR);
						$stmt->execute();
						$r = $stmt->fetchObject();

						 
						$_SESSION['idface']   =$r->idface;
						$_SESSION['idusuario'] = $r->idusuario;
			            $_SESSION['dni'] = $r->nrodocumento;
			            $_SESSION['email'] = $r->email;
			            $_SESSION['name'] = utf8_decode($r->nombres);
			            $_SESSION['id_perfil'] = $r->idperfil;
			            $_SESSION['perfil'] = $r->perfil;

			            $db->commit();            
			        }
			        catch(PDOException $e) 
			        {
			            $db->rollBack();
			            print_r(json_encode(array('res'=>'2','msg'=>'Ha ocurrido un error, intentelo nuevamente.'.$e->getMessage())));
			        }
			    }

            else
            {

			 $stmt = $db->prepare("SELECT u.nrodocumento,u.idusuario,u.idperfil,
            							 CONCAT(u.nombres, ' ', u.apellidos) As nombres,
            							 u.email,
            							 u.idface,
            							 p.descripcion as perfil
            					 from usuario as u inner join perfil as p on p.idperfil = u.idperfil where u.idface=:c");
			 $stmt->bindParam(':c',$id_face,PDO::PARAM_STR);
			 $stmt->execute();
			 $r = $stmt->fetchObject();

			 $_SESSION['idface']   =$r->idface;
			$_SESSION['idusuario'] = $r->idusuario;
            $_SESSION['dni'] = $r->nrodocumento;
            $_SESSION['email'] = $r->email;
            $_SESSION['name'] = utf8_decode($r->nombres);
            $_SESSION['id_perfil'] = $r->idperfil;
            $_SESSION['perfil'] = $r->perfil;
            }

	endif;
} catch(FacebookRequestException $ex) {
  // When Facebook returns an error
} catch(\Exception $ex) {
  // When validation fails or other local issues
}
?>