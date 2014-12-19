<?php 
session_start();
require_once '../lib/spdo.php';
$fecha = date('Y-m-d');
if(isset($_SESSION['idusuario'])&&isset($_POST['i']))
{	
	$stmt = $db->prepare("DELETE from deseos where idusuario = :us and idpublicaciones = :u");
	$stmt->bindParam(':u',$_POST['i'],PDO::PARAM_INT);
	$stmt->bindParam(':us',$_SESSION['idusuario'],PDO::PARAM_INT);	
	$stmt->execute();

}
?>