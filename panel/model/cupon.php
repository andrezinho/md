<?php
include_once("Main.php");
class cupon extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
      if($_SESSION['id_perfil']==1)
      {
        $sql = "SELECT 	c.idcupon,
                        c.numero,
                        concat(substring(c.fecha,9,2),'/',substring(c.fecha,6,2),'/',substring(c.fecha,1,4)),
                        substring(c.hora,1,5),
                        concat('S/. ',c.costo_descuento),
                        u.nrodocumento,
                        concat(u.nombres,' ',coalesce(u.apellidos,''),' ') as cliente,
                        p.titulo1,
                        concat('<a target=\"_blank\" href=\"../../cupones/print_cupon.php?token=',c.token,'\" class=\"box-boton boton-print\"></a>'),
                        case c.estado when 0 then 'Anulado' 
                                      when 1 then 'Comprado'
                                      when 2 then 'Entregado'
                              end as estado
                FROM  cupon as c inner join usuario as u on c.idcliente = u.idusuario
                      inner join publicaciones as p on p.idpublicaciones=c.idpublicaciones";
        }
        else
        {
          $sql = "SELECT  c.idcupon,
                        c.numero,
                        concat(substring(c.fecha,9,2),'/',substring(c.fecha,6,2),'/',substring(c.fecha,1,4)),
                        substring(c.hora,1,5),
                        concat('S/. ',c.costo_descuento),
                        u.nrodocumento,
                        concat(u.nombres,' ',coalesce(u.apellidos,''),' ') as cliente,
                        p.titulo1,
                        concat('<a target=\"_blank\" href=\"../../cupones/print_cupon.php?token=',c.token,'\" class=\"box-boton boton-print\"></a>'),
                        case c.estado when 0 then 'Anulado' 
                                      when 1 then 'Comprado'
                                      when 2 then 'Entregado'
                              end as estado
                FROM    cupon as c inner join usuario as u on c.idcliente = u.idusuario
                        inner join publicaciones as p on p.idpublicaciones=c.idpublicaciones 
                        inner join suscripcion as s on p.idsuscripcion = s.idsuscripcion
                        inner join local as l on l.idlocal = s.idlocal
                WHERE l.idlocal = ".$_SESSION['idlocal'];
        }
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT  c.idcupon,
                                            c.token,
                                            c.numero,
                                            u.nombres,
                                            u.apellidos,
                                            u.nrodocumento,
                                            p.idpublicaciones,
                                            p.fecha_fin,
                                            p.precio_regular,
                                            p.descuento,
                                            p.precio,
                                            e.razon_social,
                                            l.direccion,    
                                            l.telefono1,
                                            l.telefono2,
                                            l.email,
                                            e.website,
                                            p.titulo2,
                                            p.cc,
                                            ub.descripcion as ciudad,
                                            e.idempresa,
                                            l.idubigeo,
                                            ci.idciudad,
                                            c.estado
                                        FROM cupon as c inner join publicaciones as p on c.idpublicaciones = p.idpublicaciones
                                        inner join usuario as u on c.idcliente = u.idusuario
                                        left outer join suscripcion as s on p.idsuscripcion = s.idsuscripcion
                                        left outer join local as l on l.idlocal = s.idlocal
                                        left outer join empresa as e on e.idempresa = l.idempresa
                                        left outer join ciudad as ci on ci.cod = l.idubigeo
                                        left outer join ubigeo as ub on ub.idubigeo = ci.idciudad 
                                        WHERE c.idcupon = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function update($_P ) 
    {
        $stmt = $this->db->prepare("UPDATE cupon set 
                                       estado=:p1
                                    WHERE idcupon = :idcupon");

        $stmt->bindParam(':p1', $_P['op'] , PDO::PARAM_INT);
        $stmt->bindParam(':idcupon', $_P['idcupon'] , PDO::PARAM_INT);        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>