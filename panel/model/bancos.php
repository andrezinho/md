<?php
include_once("Main.php");
class bancos extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT s.idbancos,
                       s.descripcion
                from bancos AS s ";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM bancos WHERE idbancos = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO bancos (descripcion) VALUES(:p1)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE bancos set descripcion = :p1 WHERE idbancos = :idbancos");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);        
        $stmt->bindParam(':idbancos', $_P['idbancos'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM bancos WHERE idbancos = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>