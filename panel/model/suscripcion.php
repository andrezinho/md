<?php
include_once("Main.php");
class suscripcion extends Main
{
    var $idperfil = 3;
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT s.idsuscripcion,
                       concat(e.razon_social,' - ',l.descripcion),
                       concat(substr(cast(s.fecha_inicio as nchar),9,2),'/',substr(cast(s.fecha_inicio as nchar),6,2),'/',substr(cast(s.fecha_inicio as nchar),1,4)),
                       concat(substr(cast(s.fecha_fin as nchar),9,2),'/',substr(cast(s.fecha_fin as nchar),6,2),'/',substr(cast(s.fecha_fin as nchar),1,4)),
                       s.max_publi,
                       s.num_publi,
                       case s.estado when 0 then 'EN ESPERA'
                                     when 1 then 'ACTIVO' 
                                     WHEN 2 then 'VENCIDO' 
                                     when 3 then 'ANULADO' end
                FROM suscripcion as s inner join local as l on s.idlocal = l.idlocal
                        inner join empresa as e on e.idempresa = l.idempresa ";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

   function edit($id ) 
   {
        $stmt = $this->db->prepare("SELECT u.*,
                                           l.idempresa
                                    FROM suscripcion as u
                                    inner join local as l on l.idlocal = u.idlocal
                                    WHERE idsuscripcion = :id ");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) 
    {        
        $estado = 0;
        $_P['num_publi']=0;

        $fecha_i = $this->fdate($_P['fecha_inicio'],'EN');
        $fecha_f = $this->fdate($_P['fecha_fin'],'EN');

        $stmt = $this->db->prepare("INSERT INTO suscripcion (idlocal,
                                                         fecha_reg,
                                                         fecha_inicio,
                                                         fecha_fin,
                                                         max_publi,
                                                         num_publi,
                                                         observacion,
                                                         estado) 
                                                VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8)");
        $stmt->bindParam(':p1', $_P['idlocal'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['fecha_reg'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $fecha_i , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $fecha_f , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['max_publi'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['num_publi'] , PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['observacion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $estado , PDO::PARAM_INT);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) 
    {
        $fecha_i = $this->fdate($_P['fecha_inicio'],'EN');
        $fecha_f = $this->fdate($_P['fecha_fin'],'EN');
        if(isset($_P['estado']))
        {
            $stmt = $this->db->prepare("UPDATE suscripcion set idlocal = :p1, 
                                                            fecha_inicio = :p2,
                                                            fecha_fin = :p3,
                                                            max_publi = :p4,
                                                            observacion = :p5,
                                                            estado = :p6
                                        WHERE idsuscripcion = :idsuscripcion");
            $stmt->bindParam(':p1', $_P['idlocal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $fecha_i , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $fecha_f , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['max_publi'] , PDO::PARAM_INT);
            $stmt->bindParam(':p5', $_P['observacion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p6', $_P['estado'] , PDO::PARAM_INT);
            $stmt->bindParam(':idsuscripcion', $_P['idsuscripcion'] , PDO::PARAM_INT);            
        }
        else
        {
            $stmt = $this->db->prepare("UPDATE suscripcion set idlocal = :p1, 
                                                            fecha_inicio = :p2,
                                                            fecha_fin = :p3,
                                                            max_publi = :p4,
                                                            observacion = :p5
                                        WHERE idsuscripcion = :idsuscripcion");
            $stmt->bindParam(':p1', $_P['idlocal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $fecha_i , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $fecha_f , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['max_publi'] , PDO::PARAM_INT);
            $stmt->bindParam(':p5', $_P['observacion'] , PDO::PARAM_STR);            
            $stmt->bindParam(':idsuscripcion', $_P['idsuscripcion'] , PDO::PARAM_INT);            
        }
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) 
    {
        $stmt = $this->db->prepare("DELETE FROM suscripcion WHERE idsuscripcion = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>