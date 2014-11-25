<?php
include_once("Main.php");
class empresa extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT e.idempresa,
                      e.razon_social,
                      e.ruc,
                      e.nombre_contacto,
                      e.telefonos,
                      case e.estado when 1 then 'Activo' else 'Inactiva' end as estado,
                      concat('<a id=\"local-',e.idempresa,'\" href=\"index.php?controller=local&ide=',e.idempresa,'\" ref=\"Locales\" title=\"Locales\" class=\"btn-locales\"><span  class=\"box-boton boton-home\"></span></a>')
               from empresa as e ";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM empresa WHERE idempresa = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $_P['logo'] = "";
        $_P['colores']="";
        $stmt = $this->db->prepare("INSERT into empresa(ruc,
                                                        razon_social,
                                                        razon_comercial,
                                                        logo,
                                                        colores,
                                                        telefonos,
                                                        facebook,
                                                        twitter,
                                                        youtube,
                                                        website,
                                                        estado,
                                                        nombre_contacto)
                                    values(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12)");
        
        $stmt->bindParam(':p1', $_P['ruc'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['razon_social'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['razon_comercial'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['logo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['colores'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['telefonos'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['facebook'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['twitter'] , PDO::PARAM_STR);
        $stmt->bindParam(':p9', $_P['youtube'] , PDO::PARAM_STR);
        $stmt->bindParam(':p10', $_P['website'] , PDO::PARAM_STR);
        $stmt->bindParam(':p11', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p12', $_P['nombre_contacto'] , PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }
    function update($_P ) 
    {
        $sql = "update empresa set  ruc=:p1,
                                    razon_social=:p2,
                                    razon_comercial=:p3,
                                    logo=:p4,
                                    colores=:p5,
                                    telefonos=:p6,
                                    facebook=:p7,
                                    twitter=:p8,
                                    youtube=:p9,
                                    website=:p10,
                                    estado=:p11,
                                    nombre_contacto=:p12
                       where idempresa = :idempresa";
        $stmt = $this->db->prepare($sql);
              
        $stmt->bindParam(':p1', $_P['ruc'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['razon_social'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['razon_comercial'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['logo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['colores'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['telefonos'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['facebook'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['twitter'] , PDO::PARAM_STR);
        $stmt->bindParam(':p9', $_P['youtube'] , PDO::PARAM_STR);
        $stmt->bindParam(':p10', $_P['website'] , PDO::PARAM_STR);
        $stmt->bindParam(':p11', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p12', $_P['nombre_contacto'] , PDO::PARAM_STR);

        $stmt->bindParam(':idempresa', $_P['idempresa'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM empresa WHERE idempresa = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>