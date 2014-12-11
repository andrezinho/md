<?php 
require_once '../lib/spdo.php';
$db = Spdo::singleton();

$sql = "SELECT * from usuario";
//$sql = "DELETE FROM email";
$s = $db->prepare($sql);

$s->execute();
foreach ($s->fetchAll() as $r) 
{
	echo $r[0]." - ".$r[1]." ".$r[2]." ".$r[3]." - ".$r['idface']." ".$r['email']."<br/>";
}

?>