<?php
include_once("Main.php");
class local extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols,$emp)
    {
        $sql = "SELECT l.idlocal,
                        l.descripcion,
                        l.direccion,
                        concat(u.descripcion,' ',coalesce(c.zona,'')),
                        l.telefono1,
                l.telefono2
             from local as l inner join ciudad as c on c.idciudad=l.idubigeo
              inner join  ubigeo as u on u.idubigeo = c.idciudad
             where l.idempresa=".$emp;                
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM local WHERE idlocal = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) 
    {
        $_P['mapa_google']="";
        $stmt = $this->db->prepare("INSERT INTO local (idempresa, 
                                                       idubigeo,
                                                       descripcion,
                                                       direccion,
                                                       referencia,
                                                       telefono1,
                                                       telefono2,
                                                       horario,
                                                       mapa_google,
                                                       pagina_web,
                                                       estado,
                                                       latitud,
                                                       longitud) 
                                    VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13);");
        $stmt->bindParam(':p1', $_P['idempresa'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['distrito'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['referencia'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['telefono1'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['telefono2'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['horario'] , PDO::PARAM_STR);
        $stmt->bindParam(':p9', $_P['mapa_google'] , PDO::PARAM_STR);
        $stmt->bindParam(':p10', $_P['pagina_web'] , PDO::PARAM_STR);
        $stmt->bindParam(':p11',$_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p12',$_P['latitud'] , PDO::PARAM_STR);
        $stmt->bindParam(':p13',$_P['longitud'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) 
    {
        $stmt = $this->db->prepare("UPDATE local set 
                                       idubigeo=:p1,
                                       descripcion=:p2,
                                       direccion=:p3,
                                       referencia=:p4,
                                       telefono1=:p5,
                                       telefono2=:p6,
                                       horario=:p7,
                                       mapa_google=:p8,
                                       pagina_web=:p9,
                                       estado=:p10,
                                       latitud=:p11,
                                       longitud=:p12
                                    WHERE idlocal = :idlocal");

        $stmt->bindParam(':p1', $_P['distrito'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['referencia'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['telefono1'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['telefono2'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['horario'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['mapa_google'] , PDO::PARAM_STR);
        $stmt->bindParam(':p9', $_P['pagina_web'] , PDO::PARAM_STR);
        $stmt->bindParam(':p10',$_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p11',$_P['latitud'] , PDO::PARAM_STR);
        $stmt->bindParam(':p12',$_P['longitud'] , PDO::PARAM_STR);

        $stmt->bindParam(':idlocal', $_P['idlocal'] , PDO::PARAM_INT);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function delete($_P ) 
    {
        $stmt = $this->db->prepare("DELETE FROM local WHERE idlocal = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function arrayLocal($idempresa)
    {
      if($idempresa==0)
      {
        $stmt = $this->db->prepare("SELECT * from vlocal");      
      }
      else
      {
        $stmt = $this->db->prepare("SELECT * from vlocal where idempresa = :ide");      
        $stmt->bindParam(':ide',$idempresa,PDO::PARAM_INT);
      }
      $stmt->execute();
      $data = array();
      foreach($stmt->fetchAll() as $r)
      {
        $data[] = array($r[0],$r[1]);
      }
      return $data;
    }
}
?>