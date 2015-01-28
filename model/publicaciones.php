<?php 
session_start();
require_once '../lib/spdo.php';
$db = Spdo::singleton();
    
    if(!isset($_SESSION['idusuario']))
    {        
        $sql = "SELECT p.*,0 as deseo,e.dominio
                FROM publicaciones as p 
                    inner join suscripcion as s on s.idsuscripcion = p.idsuscripcion
                    inner join local as l on l.idlocal = s.idlocal
                    INNER JOIN empresa as e on e.idempresa=l.idempresa                 
                WHERE p.estado<>0 and p.tipo<>1 and l.idubigeo = '".$_SESSION['idciudad']."'
                    and p.fecha_fin >= CURDATE()
                ORDER BY idpublicaciones desc limit 3 ";

    }
    else
    {
        $sql = "SELECT p.*,coalesce(d.idpublicaciones,0) as deseo,e.dominio
            FROM publicaciones as p inner join suscripcion as s 
                on s.idsuscripcion = p.idsuscripcion
                inner join local as l on l.idlocal = s.idlocal
                INNER JOIN empresa as e on e.idempresa=l.idempresa                 
                left outer join deseos as d on d.idpublicaciones = p.idpublicaciones and d.idusuario = ".$_SESSION['idusuario']."
            WHERE p.estado<>0 and p.tipo<>1 and l.idubigeo = '".$_SESSION['idciudad']."'
                    and p.fecha_fin >= CURDATE()
            ORDER BY idpublicaciones desc limit 3 ";

    }

    $stmt = $db->prepare($sql);    
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
                            'deseo' => $valor['deseo'],
                            'dominio' => $valor['dominio'],
                            'enlaces' => array()
            );
        $cont ++;
    }
    print_r(json_encode($menu));
?>