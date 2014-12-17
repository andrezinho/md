<?php
include_once("Main.php");
class ciudad extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT s.idciudad,
                       u.descripcion,
                       case s.estado when true then 'ACTIVO' else 'INCANTIVO' end
                from ciudad AS s inner join ubigeo as u on s.idciudad = u.idubigeo";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM ciudad WHERE idciudad = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO ciudad (idciudad, estado) VALUES(:p0,:p2)");
        $stmt->bindParam(':p0', $_P['distrito'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) 
    {
        $stmt = $this->db->prepare("UPDATE ciudad set  estado = :p2, idciudad=:p3 WHERE idciudad = :idciudad");        
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['distrito'] , PDO::PARAM_INT);
        $stmt->bindParam(':idciudad', $_P['idciudad'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function delete($_P ) 
    {
        $stmt = $this->db->prepare("DELETE FROM ciudad WHERE idciudad = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function arrayCiudad()
    {      
       $stmt = $this->db->prepare("SELECT c.idciudad,u.descripcion from ciudad as c inner join ubigeo as u on c.idciudad = u.idubigeo where c.estado = 1 order by c.cod ");
       $stmt->execute();
       $data = array();
       foreach($stmt->fetchAll() as $r)
       {
         $data[] = array($r[0],$r[1]);
       }
       return $data;
    }

    function getCiudad()
    {
        $stmt = $this->db->prepare("SELECT c.idciudad,u.descripcion from ciudad as c inner join ubigeo as u on c.idciudad = u.idubigeo where c.estado = 1 order by c.cod limit 1  ");
        $stmt->execute();
        $data = array();
        $row = $stmt->fetchObject();        
        return $row;
    }
}
?>