<?php 

session_start();
require_once '../lib/spdo.php';

$stmt = $db->prepare("SELECT c.cod,u.descripcion 
					from ciudad as c inner join ubigeo as u on c.idciudad = u.idubigeo 
					where c.estado = 1 and c.cod = :c order by c.cod ");
$stmt->bindParam(':c',$_GET['c'],PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetchObject();
if($row->descripcion!="")
{
	$_SESSION['ciudad'] = $row->descripcion;
	$_SESSION['idciudad'] = $row->cod;
}

?>