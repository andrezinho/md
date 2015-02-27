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
        
        $_P['colores']="";

        if($this->verifica_dominio($_P['dominio'],0))
        {


            $stmt = $this->db->prepare("INSERT into empresa(ruc,
                                                            razon_social,
                                                            razon_comercial,                                                        
                                                            colores,
                                                            telefonos,
                                                            facebook,
                                                            twitter,
                                                            youtube,
                                                            website,
                                                            estado,
                                                            nombre_contacto,
                                                            bcp,
                                                            scotiabank,
                                                            interbank,
                                                            continental,
                                                            nacion,otros,dominio)
                                        values(:p1,:p2,:p3,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15,:p16,:p17,:p18,:p19)");
            
            $stmt->bindParam(':p1', $_P['ruc'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $_P['razon_social'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['razon_comercial'] , PDO::PARAM_STR);        
            $stmt->bindParam(':p5', $_P['colores'] , PDO::PARAM_STR);
            $stmt->bindParam(':p6', $_P['telefonos'] , PDO::PARAM_STR);
            $stmt->bindParam(':p7', $_P['facebook'] , PDO::PARAM_STR);
            $stmt->bindParam(':p8', $_P['twitter'] , PDO::PARAM_STR);
            $stmt->bindParam(':p9', $_P['youtube'] , PDO::PARAM_STR);
            $stmt->bindParam(':p10', $_P['website'] , PDO::PARAM_STR);
            $stmt->bindParam(':p11', $_P['activo'] , PDO::PARAM_INT);
            $stmt->bindParam(':p12', $_P['nombre_contacto'] , PDO::PARAM_STR);
            $stmt->bindParam(':p13', $_P['bcp'] , PDO::PARAM_STR);
            $stmt->bindParam(':p14', $_P['scotiabank'] , PDO::PARAM_STR);
            $stmt->bindParam(':p15', $_P['interbank'] , PDO::PARAM_STR);
            $stmt->bindParam(':p16', $_P['continental'] , PDO::PARAM_STR);
            $stmt->bindParam(':p17', $_P['nacion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p18', $_P['otros'] , PDO::PARAM_STR);
            $stmt->bindParam(':p19', $_P['dominio'] , PDO::PARAM_STR);
            
            $p1 = $stmt->execute();
            $p2 = $stmt->errorInfo();


            $idempresa = $this->IdlastInsert('empresa','idempresa');

            foreach($_P['idbancosd'] as $k => $v)
            {
                if($v!="")
                {
                    $stmt2=$this->db->prepare("insert into empresa_bancos(idempresa,idbancos,nrocuenta) 
                            values(:ide,:idb,:nroc)");
                    $stmt2->bindParam(':ide',$idempresa,PDO::PARAM_INT);
                    $stmt2->bindParam(':idb',$v,PDO::PARAM_INT);
                    $stmt2->bindParam(':nroc',$_P['nrocuentad'][$k],PDO::PARAM_STR);
                    $stmt2->execute();
                }
            }

            return array($p1 , $p2[2]);
        }
        else
        {
            return array(false,'El dominio ya está en uso, intente con otro nombre');
        }

        
    }
    function update($_P ) 
    {
        if($this->verifica_dominio($_P['dominio'],$_P['idempresa']))
        {

            $sql = "update empresa set  ruc=:p1,
                                        razon_social=:p2,
                                        razon_comercial=:p3,                                    
                                        colores=:p5,
                                        telefonos=:p6,
                                        facebook=:p7,
                                        twitter=:p8,
                                        youtube=:p9,
                                        website=:p10,
                                        estado=:p11,
                                        nombre_contacto=:p12,
                                        bcp=:p13,
                                        scotiabank=:p14,
                                        interbank=:p15,
                                        continental=:p16,
                                        nacion=:p17,
                                        otros=:p18,
                                        dominio=:p19
                           where idempresa = :idempresa";
            $stmt = $this->db->prepare($sql);
                  
            $stmt->bindParam(':p1', $_P['ruc'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $_P['razon_social'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['razon_comercial'] , PDO::PARAM_STR);        
            $stmt->bindParam(':p5', $_P['colores'] , PDO::PARAM_STR);
            $stmt->bindParam(':p6', $_P['telefonos'] , PDO::PARAM_STR);
            $stmt->bindParam(':p7', $_P['facebook'] , PDO::PARAM_STR);
            $stmt->bindParam(':p8', $_P['twitter'] , PDO::PARAM_STR);
            $stmt->bindParam(':p9', $_P['youtube'] , PDO::PARAM_STR);
            $stmt->bindParam(':p10', $_P['website'] , PDO::PARAM_STR);
            $stmt->bindParam(':p11', $_P['activo'] , PDO::PARAM_INT);
            $stmt->bindParam(':p12', $_P['nombre_contacto'] , PDO::PARAM_STR);
            $stmt->bindParam(':p13', $_P['bcp'] , PDO::PARAM_STR);
            $stmt->bindParam(':p14', $_P['scotiabank'] , PDO::PARAM_STR);
            $stmt->bindParam(':p15', $_P['interbank'] , PDO::PARAM_STR);
            $stmt->bindParam(':p16', $_P['continental'] , PDO::PARAM_STR);
            $stmt->bindParam(':p17', $_P['nacion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p18', $_P['otros'] , PDO::PARAM_STR);
            $stmt->bindParam(':p19', $_P['dominio'] , PDO::PARAM_STR);

            $stmt->bindParam(':idempresa', $_P['idempresa'] , PDO::PARAM_INT);

            $p1 = $stmt->execute();
            $p2 = $stmt->errorInfo();

            $stmt_=$this->db->prepare("delete from empresa_bancos where idempresa = :idem");
            $stmt_->bindParam(':idem',$_P['idempresa'],PDO::PARAM_INT);
            $stmt_->execute();

            foreach($_P['idbancosd'] as $k => $v)
            {
                if($v!="")
                {
                    $stmt2=$this->db->prepare("insert into empresa_bancos(idempresa,idbancos,nrocuenta) 
                            values(:ide,:idb,:nroc)");
                    $stmt2->bindParam(':ide',$_P['idempresa'],PDO::PARAM_INT);
                    $stmt2->bindParam(':idb',$v,PDO::PARAM_INT);
                    $stmt2->bindParam(':nroc',$_P['nrocuentad'][$k],PDO::PARAM_STR);
                    $stmt2->execute();
                }
            }

            return array($p1 , $p2[2]);
        }
        else
        {
            return array(false,'El dominio ya está en uso, intente con otro nombre');
        }
    }

    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM empresa WHERE idempresa = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function verifica_dominio($dominio,$idempresa)
    {
        if($idempresa!=0)
        {
            $stmt=$this->db->prepare("SELECT count(*) as n from empresa where dominio = :d and idempresa <> ".$idempresa);
        }
        else 
        {
            $stmt=$this->db->prepare("SELECT count(*) as n from empresa where dominio = :d ");
        }
        $stmt->bindParam(':d',$dominio,PDO::PARAM_STR);
        $stmt->execute();
        $r = $stmt->fetchObject();
        if($r->n==0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function getCuentas($idempresa)
    {
        $stmt=$this->db->prepare("SELECT b.idbancos,b.descripcion as banco,eb.nrocuenta
                                  from empresa_bancos as eb inner join bancos as b on b.idbancos=eb.idbancos
                                  where eb.idempresa =:ide");
        $stmt->bindParam(':ide',$idempresa,PDO::PARAM_INT);
        $stmt->execute();
        $data=array();
        foreach ($stmt->fetchAll() as $r) {
            $data[]=array('idbancos'=>$r[0],
                           'bancos'=>$r[1],
                           'nrocuenta'=>$r[2]
                           );
        }
        return $data;
    }   
}
?>