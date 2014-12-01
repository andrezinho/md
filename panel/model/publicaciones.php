<?php
include_once("Main.php");
class publicaciones extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT sc.idpublicaciones,
                       sc.descripcion,
                       c.descripcion,
                       case sc.estado when 1 then 'ACTIVO' else 'INCANTIVO' end
                from publicaciones as sc inner join categoria as c on c.idcategoria = sc.idcategoria";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM publicaciones WHERE idpublicaciones = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO publicaciones (descripcion, estado, idcategoria) VALUES(:p1,:p2,:p3)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p3', $_P['idcategoria'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) 
    {
        $stmt = $this->db->prepare("UPDATE publicaciones set descripcion = :p1, estado = :p2, idcategoria=:p3 WHERE idpublicaciones = :idpublicaciones");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p3', $_P['idcategoria'] , PDO::PARAM_INT);
        $stmt->bindParam(':idpublicaciones', $_P['idpublicaciones'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function delete($_P ) 
    {
        $stmt = $this->db->prepare("DELETE FROM publicaciones WHERE idpublicaciones = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>