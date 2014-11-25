<?php
include_once("Main.php");
class asesor extends Main
{
    var $idperfil = 2; //Asesor

    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT u.idusuario,
                       concat(u.nombres,' ',u.apellidos),
                       u.nrodocumento,
                       concat(e.razon_social,'-',l.descripcion),
                       case u.estado when 1 then 'ACTIVO' else 'INCANTIVO' end
                from usuario as u inner join local as l on u.idlocal = l.idlocal
                        inner join empresa as e on e.idempresa = l.idempresa
                where u.idperfil = 3";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

   function edit($id ) 
   {
        $stmt = $this->db->prepare("SELECT u.*,u.idempresa
                                    FROM usuario as u
                                    inner join local as l on l.idlocal = u.idlocal
                                  WHERE idpublicador = :id ");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) 
    {
        $passw = $this->genera_passw();
        $idubigeo = "000000";
        $stmt = $this->db->prepare("INSERT INTO usuario (idperfil,
                                                         nombres,
                                                         apellidos,
                                                         idubigeo,
                                                         email,
                                                         telefono,
                                                         celular,
                                                         idtipo_documento,
                                                         nrodocumento,
                                                         passw,
                                                         estado,
                                                         idlocal) 
                                                VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12)");
        $stmt->bindParam(':p1', $this->idperfil , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['nombres'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['apellidos'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $idubigeo , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['email'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['telefono'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['celular'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['idtipo_documento'] , PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['nrodocumento'] , PDO::PARAM_STR);
        $stmt->bindParam(':p10', $passw , PDO::PARAM_STR);
        $stmt->bindParam(':p11', $_P['activo'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) 
    {
        $stmt = $this->db->prepare("UPDATE usuario set nombres = :p1, 
                                                        apellidos = :p2,
                                                        email = :p3,
                                                        telefono = :p4,
                                                        celular = :p5,
                                                        idtipo_documento = :p6,
                                                        nrodocumento = :p7,
                                                       estado = :p8
                                                       WHERE idusuario = :idasesor");
        $stmt->bindParam(':p1', $_P['nombres'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['apellidos'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['email'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['celular'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['idtipo_documento'] , PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['nrodocumento'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':idasesor', $_P['idusuario'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) 
    {
        $stmt = $this->db->prepare("DELETE FROM usuario WHERE idusuario = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function vemail($email)
    {
        $stmt = $this->db->prepare("SELECT count(*) as n from usuario where email = :e and idperfil = 2");
        $stmt->bindParam(':e',$email,PDO::PARAM_STR);
        $stmt->execute();
        $r = $stmt->fetchObject();
        if($r->n>0)
        {
            $data = array(0,"El correo ya existe");
        }
        else
        {
            $data = array(1,"El correo no existe en nuestra bd");
        }
        return $data;
    }
}
?>