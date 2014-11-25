<?php
include_once("Main.php");
class categoria extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT idcategoria,
                       descripcion,
                       orden,
                       case estado when 1 then 'ACTIVO' else 'INCANTIVO' end
                from categoria";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM categoria WHERE idcategoria = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO categoria (descripcion, estado, orden) VALUES(:p1,:p2,:p3)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['orden'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE categoria set descripcion = :p1, estado = :p2, orden=:p3 WHERE idcategoria = :idcategoria");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['orden'] , PDO::PARAM_INT);
        $stmt->bindParam(':idcategoria', $_P['idcategoria'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM categoria WHERE idcategoria = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>