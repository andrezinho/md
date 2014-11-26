<?php 
require_once '../lib/spdo.php';
$db = Spdo::singleton();


        $stmt = $db->prepare("SELECT * from categoria");
        //$stmt->bindValue(':p1', $_SESSION['id_perfil'] , PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();
        $cont = 0; 
        $cont2 = 0;
        
        foreach ($items as $valor)
        {
            $stmt = $db->prepare("SELECT * from subcategoria where idcategoria=".$valor['idcategoria']);
            //$stmt->bindValue(':p1', $_SESSION['id_perfil'] , PDO::PARAM_INT);
            $stmt->execute();
            $hijos = $stmt->fetchAll();
          
           
            $menu[$cont] = array(
                                'texto' => ucfirst($valor['descripcion']),
                                //'url' => $url,
                                'enlaces' => array()
                );
            $cont2 = 0;
            foreach($hijos as $h)
            {
                            
              $menu[$cont]['enlaces'][$cont2] = array('idsubcategoria'=>$h['idsubcategoria'],'texto' => ucfirst($h['descripcion']));
              $cont2 ++;
            }
            $cont ++;
        }
        print_r(json_encode($menu));
    
?>