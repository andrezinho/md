<?php 
session_start();
require_once '../lib/spdo.php';
$db = Spdo::singleton();


        $stmt = $db->prepare("SELECT p.fecha_fin,p.hora_fin 
                              FROM publicaciones as p
                              INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion
                              INNER JOIN local as l on l.idlocal=su.idlocal
                        WHERE idpublicaciones=:id and l.idubigeo='".$_SESSION['idciudad']."'");
        $stmt->bindValue(':id', $_GET['idp'] , PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();
        $cont = 0;     
        $t=array();
        foreach ($items as $valor)
        {
            
            $t[] = array('fecha_fin' => $valor['fecha_fin'],
                                'hora_fin' => $valor['hora_fin'],
                                'enlaces' => array()
                                );
            
        }
        print_r(json_encode($t));
    
?>