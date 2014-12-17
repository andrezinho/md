<?php 
require_once '../lib/spdo.php';
$db = Spdo::singleton();


        $stmt = $db->prepare("SELECT * 
                              FROM publicaciones
                              WHERE estado<>0 and tipo=1
                              ORDER BY idpublicaciones desc limit 3");
        //$stmt->bindValue(':p1', $_SESSION['id_perfil'] , PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();
        $cont = 0;     
        
        foreach ($items as $valor)
        {
            
            $menu[$cont] = array(
                                'idtipo_descuento' => $valor['idtipo_descuento'],
                                'idpublicaciones' => $valor['idpublicaciones'],
                                'titulo1' => ucfirst($valor['titulo1']),
                                'titulo2' => $valor['titulo2'],
                                'descripcion' => $valor['descripcion'],
                                'precio_regular' => $valor['precio_regular'],
                                'precio' => $valor['precio'],
                                'descuento' => $valor['descuento'],
                                'fecha_inicio' => $valor['fecha_inicio'],
                                'fecha_fin' => $valor['fecha_fin'],
                                'hora_inicio' => $valor['hora_inicio'],
                                'hora_fin' => $valor['hora_fin'],
                                'imagen' => $valor['imagen'],
                                'enlaces' => array()
                );
            $cont ++;
        }
        print_r(json_encode($menu));
    
?>