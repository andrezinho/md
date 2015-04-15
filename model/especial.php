<?php 
session_start();
require_once '../lib/spdo.php';
$db = Spdo::singleton();


        $stmt = $db->prepare("SELECT p.*,e.dominio
                      FROM publicaciones as p 
                           inner join suscripcion as s on s.idsuscripcion = p.idsuscripcion
                           inner join local as l on l.idlocal = s.idlocal
                           INNER JOIN empresa as e on e.idempresa=l.idempresa
                      WHERE p.estado=1 and p.tipo=1 and l.idubigeo = '".$_SESSION['idciudad']."'
                            and p.fecha_fin >= CURDATE() and s.fecha_fin >= CURDATE() and s.estado=1
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
                                'titulo1' => utf8_encode($valor['titulo1']),
                                'titulo2' => utf8_encode($valor['titulo2']),
                                'descripcion' => utf8_encode($valor['descripcion']),
                                'precio_regular' => $valor['precio_regular'],
                                'precio' => $valor['precio'],
                                'descuento' => $valor['descuento'],
                                'fecha_inicio' => $valor['fecha_inicio'],
                                'fecha_fin' => $valor['fecha_fin'],
                                'hora_inicio' => $valor['hora_inicio'],
                                'hora_fin' => $valor['hora_fin'],
                                'imagen' => $valor['imagen'],
                                'dominio' => $valor['dominio'],
                                'enlaces' => array()
                );
            $cont ++;
        }
        print_r(json_encode($menu));
    
?>