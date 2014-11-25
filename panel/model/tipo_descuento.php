<?php
include_once("Main.php");
class tipo_descuento extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT idtipo_descuento,
                       nombre,                         
                       case estado when 1 then 'ACTIVO' else 'INCANTIVO' end
                from tipo_descuento";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM tipo_descuento WHERE idtipo_descuento = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO tipo_descuento (nombre, estado, descripcion, imagen) VALUES(:p1,:p2,:p3,:p4)");
        $stmt->bindParam(':p1', $_P['nombre'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);        
        $stmt->bindParam(':p3', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['imagen'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE tipo_descuento set nombre = :p1, estado = :p2  ,
                                    descripcion = :p3,
                                    imagen=:p4
                                    WHERE idtipo_descuento = :idtipo_descuento");
        $stmt->bindParam(':p1', $_P['nombre'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);        
        $stmt->bindParam(':p3', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['imagen'] , PDO::PARAM_STR);
        $stmt->bindParam(':idtipo_descuento', $_P['idtipo_descuento'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM tipo_descuento WHERE idtipo_descuento = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>