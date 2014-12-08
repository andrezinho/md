<?php
include_once("Main.php");
class publicaciones extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT p.idpublicaciones,
                       p.titulo1,
                       sc.descripcion,
                       concat(substring(cast(p.fecha_inicio as nchar),9,2),'/',substring(cast(p.fecha_inicio as nchar),6,2),'/',substring(cast(p.fecha_inicio as nchar),1,4)),
                       concat(substring(cast(p.fecha_fin as nchar),9,2),'/',substring(cast(p.fecha_fin as nchar),6,2),'/',substring(cast(p.fecha_fin as nchar),1,4)),
                       case p.estado when 1 then 'Activo' else 'Inactiva' end as estado
                from publicaciones as p inner join subcategoria as sc on p.idsubcategoria = sc.idsubcategoria";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }
    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT p.*,sc.idcategoria FROM publicaciones p 
                                    inner join subcategoria as sc on p.idsubcategoria = sc.idsubcategoria
                                    WHERE idpublicaciones = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) 
    {
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();       

            $stmt = $this->db->prepare("INSERT INTO publicaciones
                                                    (idsuscripcion,
                                                    idusuario,
                                                    idsubcategoria,
                                                    idtipo_descuento,
                                                    titulo1,
                                                    titulo2,
                                                    descripcion,
                                                    cc,
                                                    precio_regular,
                                                    precio,
                                                    descuento,
                                                    fecha_inicio,
                                                    hora_inicio,
                                                    fecha_fin,
                                                    hora_fin,
                                                    estado)
                                                    VALUES
                                                    (
                                                    :p1,:p2,:p3,:p4,:p5,:p6,
                                                    :p7,:p8,:p9,:p10,:p11,:p12,
                                                    :p13,:p14,:p15,:p16
                                            );");
            $idsuscripcion = 1;
            $idtipo=1;
            $idusuario=$_SESSION['idusuario'];

            $_P['fecha_inicio'] = $this->fdate($_P['fecha_inicio'],'EN');
            $_P['fecha_fin'] = $this->fdate($_P['fecha_fin'],'EN');

            $stmt->bindParam(':p1', $idsuscripcion , PDO::PARAM_STR);        
            $stmt->bindParam(':p2', $idusuario , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['idsubcategoria'] , PDO::PARAM_INT);
            $stmt->bindParam(':p4', $_P['idtipo_descuento'] , PDO::PARAM_INT);
            $stmt->bindParam(':p5', $_P['titulo1'] , PDO::PARAM_STR);
            $stmt->bindParam(':p6', $_P['titulo2'] , PDO::PARAM_STR);
            $stmt->bindParam(':p7', $_P['c1'] , PDO::PARAM_STR);
            $stmt->bindParam(':p8', $_P['c2'] , PDO::PARAM_STR);
            $stmt->bindParam(':p9', $_P['precio_regular'] , PDO::PARAM_INT);
            $stmt->bindParam(':p10',$_P['precio'] , PDO::PARAM_INT);
            $stmt->bindParam(':p11',$_P['descuento'] , PDO::PARAM_STR);
            $stmt->bindParam(':p12',$_P['fecha_inicio'] , PDO::PARAM_STR);
            $stmt->bindParam(':p13',$_P['hora_inicio'] , PDO::PARAM_STR);
            $stmt->bindParam(':p14',$_P['fecha_fin'] , PDO::PARAM_STR);
            $stmt->bindParam(':p15',$_P['hora_fin'] , PDO::PARAM_STR);
            $stmt->bindParam(':p16',$_P['activo'] , PDO::PARAM_INT);
            $stmt->execute();

            $idp = $this->IdlastInsert("publicaciones","idpublicaciones");
            $this->db->commit();
            return array('res'=>'1','msg'=>'Bien!','idp'=>$idp);
        }
        catch(PDOException $e)
        {
            $this->db->rollBack();
            return array('res'=>'2','msg'=>'Error : '.$e->getMessage() . $str);
        }
    }

    function update($_P ) 
    {
        $idsuscripcion = 1;
        $idtipo=1;
        $idusuario=$_SESSION['idusuario'];
         try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();   

        $_P['fecha_inicio'] = $this->fdate($_P['fecha_inicio'],'EN');
        $_P['fecha_fin'] = $this->fdate($_P['fecha_fin'],'EN');
        $stmt = $this->db->prepare("UPDATE publicaciones set 
                                        idsuscripcion=:p1,                                        
                                        idusuario=:p3,
                                        idsubcategoria=:p4,
                                        idtipo_descuento=:p5,
                                        titulo1=:p6,
                                        titulo2=:p7,
                                        descripcion=:p8,
                                        cc=:p9,
                                        precio_regular=:p10,
                                        precio=:p11,
                                        descuento=:p12,
                                        fecha_inicio=:p13,
                                        hora_inicio=:p14,
                                        fecha_fin=:p15,
                                        hora_fin=:p16,
                                        estado=:p17
                       where idpublicaciones=:idpublicaciones");

        $stmt->bindParam(':p1', $idsuscripcion , PDO::PARAM_STR);        
        $stmt->bindParam(':p3', $idusuario , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['idsubcategoria'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['idtipo_descuento'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['titulo1'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['titulo2'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['c1'] , PDO::PARAM_STR);
        $stmt->bindParam(':p9', $_P['c2'] , PDO::PARAM_STR);
        $stmt->bindParam(':p10',$_P['precio_regular'] , PDO::PARAM_INT);
        $stmt->bindParam(':p11',$_P['precio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p12',$_P['descuento'] , PDO::PARAM_INT);
        $stmt->bindParam(':p13',$_P['fecha_inicio'] , PDO::PARAM_STR);
        $stmt->bindParam(':p14',$_P['hora_inicio'] , PDO::PARAM_STR);
        $stmt->bindParam(':p15',$_P['fecha_fin'] , PDO::PARAM_STR);
        $stmt->bindParam(':p16',$_P['hora_fin'] , PDO::PARAM_STR);
        $stmt->bindParam(':p17',$_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':idpublicaciones', $_P['idpublicaciones'] , PDO::PARAM_INT);
        
        $stmt->execute();
        
            $this->db->commit();
            return array('res'=>'1','msg'=>'Bien!','idp'=>'');
        }
        catch(PDOException $e)
        {
            $this->db->rollBack();
            return array('res'=>'2','msg'=>'Error : '.$e->getMessage() . $str);
        }
        
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