<?php
session_start();
require_once 'head.php'; //Start para facebook -> ;)
$url=$_GET["id"];
$db = Spdo::singleton();
$stmt = $db->prepare("SELECT * 
                      FROM publicaciones
                      WHERE estado<>0 and tipo=1
                      ORDER BY idpublicaciones desc limit 3");
$stmt->execute();
$lista= $stmt->rowCount();

?>
<script type="text/javascript">
  $("document").ready(function(){
     $(".quit-wish").click(function(){
        var i=$(this).attr("id"),temp=i;i=i.split("-");i=i[1];if(i!=""){quitwishlist(i);}
     });
  });
  function quitwishlist(i)
  {    
    $.post('http://'+host+'/model/deletewish.php','i='+i,function(r){            
       location.reload();
    });
  }
</script>
<body>
<div id="frm-suscripcion"></div>
<header>   
  <div class="c-top" style="background: #EEEEEE; padding: 5px 0 0 0; margin-top: -8px; box-shadow: 3px 2px 5px #ccc;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="topheadrow">
          <a href="<?php echo $host;?>"><img src="<?php echo $host;?>/images/logo.png" /></a>
          <ul class="nav nav-pills pull-right">            
            <li class="dropdown" style="padding:10px 10px 6px;">Descuentos en
              <select id="ciudades" name="ciudades" class="web-list list-local" style="max-width:140px;border:0;">
                <?php                   
                  $sql = "SELECT c.idciudad,u.descripcion from ciudad as c inner join ubigeo as u on c.idciudad = u.idubigeo where c.estado = 1 order by c.cod ";
                  $stmt = $db->prepare($sql);
                  $stmt->execute();                  
                  foreach($stmt->fetchAll() as $r)
                  {
                     $s = "";
                     if($r[0]==$_SESSION['idciudad'])
                     {
                       $s = "selected";
                     }
                     ?>
                     <option value="<?php echo $r[0] ?>" <?php echo $s; ?>><?php echo $r[1]; ?></option>
                     <?php
                  }
                ?>
              </select>
            </li>       

            <li> <a href="#" id="recibir_ofertas"> <i class="fa fa-envelope fa-fw"></i> <span class="hidden-xs">Quiero Recibir Ofertas</span></a> </li>
            <li> <a href="#"> <i class="fa fa-heart fa-fw"></i> <span class="hidden-xs">Mis Deseos</span></a> </li>            
            <?php echo login($helper,$config); ?>     
          </ul>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="container">
    <div class="row clearfix">      
      <div class="pull-right" style="float:right; diaplay:inline-block; width:410px;margin-bottom: 6px; ">
        <div class="searchbar" style="float:left; width:220px;">
          <form action="#">                  
            <div style="background: red; float: left; ">
              <input class="searchinput" id="search" placeholder="Buscar..." type="search" style="height: 40px;">
            </div>
            <div class="searchbox">
              <button class="fa fa-search fa-fw" type="submit"></button>
            </div>          
          </form>          
        </div>
        <div class="searchbar" style="float:left; width:175px;">
            <div class="social-icons">
                <ul>
                  <li class="icon google-plus"><a href="#a"><i class="fa fa-google-plus fa-fw"></i></a></li>
                  <li class="icon linkedin"><a href="#a"><i class="fa fa-linkedin fa-fw"></i></a></li>
                  <li class="icon twitter"><a href="#a"><i class="fa fa-twitter fa-fw"></i></a></li>
                  <li class="icon facebook"><a href="https://www.facebook.com/MuchosDescuentos?fref=ts" target="_BLANK"><i class="fa fa-facebook fa-fw"></i></a></li>
                </ul>
            </div>  
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row clearfix" style="width: 1140px;margin-left: 0px;" id="posicion">
      <div> 
        <!-- Navigation Buttons/Quick Cart for Tablets and Desktop Only -->
        <div class="menu-links hidden-xs">
          <ul class="nav nav-pills nav-justified" id="listamenu">
          <li> <a href="<?php echo $host;?>"><span class="hidden-sm">&Uacute;ltimas Ofertas</span></a>
          </li>
          </ul>
        </div>
          <div class="clearfix"></div>
      </div>
    </div>
  </div>
</header>
<!-- end: Header --> 
<!-- Products -->
<div class="container"> 
  <div style="min-height:350px;">
   <?php if (!isset($_SESSION['facebook'])&&!isset($_SESSION['email'])): ?>
    <div id="box-msg-session-required" class="ui-widget-content" style="padding:50px 20px; text-align:center ">
      Agregar tus deseos primero debes <b>Inciar Sesion</b> con tu cuenta de usuario o mediante Facebook.
    </div>
  <?php else: ?>    
    <h2>Mis Cupones</h2>
    <div>
      <table class="table-list-md" style="width:100%">
        <tr>
          <th>Item</th>          
          <th>Codigo de Reserva</th> 
          <th>Titulo</th>
          <th>Precio S/.</th>
          <th>Fecha Compra</th>
          <th>Hora de Compra</th>          
          <th>Ver</th>          
        </tr>
        <?php 
        $sql = "SELECT  c.idcupon,
                        c.token,
                        c.numero,
                        c.fecha,
                        c.hora,
                        c.costo_descuento,
                        u.nombres,
                        u.apellidos,
                        u.nrodocumento,
                        p.idpublicaciones,
                        p.fecha_fin,                        
                        e.razon_social,
                        l.direccion,  
                        l.telefono1,
                        l.telefono2,
                        l.email,
                        e.website,
                        e.bcp,
                        e.scotiabank,
                        e.interbank,
                        e.continental,
                        e.nacion,
                        p.titulo2,
                        p.cc,
                        ub.descripcion as ciudad
                FROM cupon as c inner join publicaciones as p on c.idpublicaciones = p.idpublicaciones
                inner join usuario as u on c.idcliente = u.idusuario
                inner join suscripcion as s on p.idsuscripcion = s.idsuscripcion
                inner join local as l on l.idlocal = s.idlocal
                inner join empresa as e on e.idempresa = l.idempresa
                inner join ubigeo as ub on ub.idubigeo = l.idubigeo
                where c.idcliente = ".$_SESSION['idusuario'];

        $stmt = $db->prepare($sql);            
        $stmt->execute();
        $c = 0;

        foreach($stmt->fetchAll() as $r)
        {
          $c +=1;
          ?>
          <tr>
            <td align="center"><?php echo $c; ?></td>
            <td><?php echo utf8_encode($r['numero']); ?></td>
            <td><?php echo utf8_encode($r['titulo2']); ?></td>
            <td align="right"><?php echo number_format($r['costo_descuento'],2); ?></td>            
            <td align="center"><?php echo $r['fecha'] ?></td>
            <td align="center"><?php echo $r['hora'] ?></td>
            <td align="center">
              <button class="btn btn-default btn-compare pull-left" title="Ver" style="background:green"><a href="<?php echo $host; ?>/cupones/print_cupon.php?token=<?php echo $r['token']; ?>" target="_blank">Ver</a></button>
            </td>            
          </tr>
          <?php
          }
        ?>
      </table>
    </div>
     <?php endif; ?>
  </div>
</div>
<footer class="footer">
<!--<section class="footer-img"></section>-->
<section id="fmenu">
  <ul>
    <li><a href="#">¿C&oacute;mo Funciona?</a></li>
    <li><a href="#">¿Qui&eacute;nes Somos?</a></li>
    <li><a href="#">¿P&uacute;blica con nosotros</a></li>
    <li><a href="#">Ayuda</a></li>
  </ul>
</section>
  <div class="container" style="padding: 0 50px">
    <div class="row">
      <div class="col-sm-3 col-xs-12 shopinfo">
        <h4 class="title">INFORMACI&Oacute;N</h4>
        <ul>
            <li><a href="#" style="color:#333 !important;">Preguntas Frecuentes.</a></li>
            <li><a href="#" style="color:#333 !important;">Acerca del Pago en Efectivo.</a></li>
            <li><a href="#" style="color:#333 !important;">Libro de Reclamaciones.</a></li>
            <li><a href="#" style="color:#333 !important;">Pol&iacute;ticas y Privacidad.</a></li>
            <li><a href="#" style="color:#333 !important;">Mapa del sitio.</a></li>            
        </ul>        
      </div>
      <div class="col-sm-3 col-xs-12 shopinfo">
        <h4 class="title">EMPRESAS</h4>
            <li><a href="#" style="color:#333 !important;">Empresa 1</a></li>
            <li><a href="#" style="color:#333 !important;">Empresa 2</a></li>
            <li><a href="#" style="color:#333 !important;">Empresa 3</a></li>
            <li><a href="#" style="color:#333 !important;">Empresa 4</a></li>
            <li><a href="#" style="color:#333 !important;">Empresa 5</a></li>                        
      </div>
      <div class="col-sm-3 col-xs-12 getintouch">
        <h4 class="title">CONT&Aacute;CTENOS</h4>
        <ul>
          <li>
            <div class="icon"><i class="fa fa-map-marker fa-fw" style="color:#000;"></i></div>
            <div class="c-info"> <span>Avenida xxx, Lima, Per&uacute;<br>
              <a href="#a" style="color:#000;">B&uacute;scanos en el Map.</a></span></div>
          </li>
          <li>
            <div class="icon"><i class="fa fa-envelope-o fa-fw" style="color:#000;"></i></div>
            <div class="c-info"> <span>Email:<br>
              <a href="#a" style="color:#000;">@muchosdescuentos.com</a></span>
            </div>
          </li>
          <li>
            <div class="icon"><i class="fa fa-phone fa-fw" style="color:#000;"></i></div>
            <div class="c-info"> <span>Tel&eacute;fono:<br>
              <a href="#a" style="color:#000;">(01) 222 3333</a></span></div>
          </li>
        </ul>
      </div>
      <div class="col-sm-3 col-xs-12 getintouch">
        <h4 class="title">S&Iacute;GUENOS EN</h4>    
        <div class="social-icons">
          <ul>
            <li class="icon google-plus"><a href="#a"><i class="fa fa-google-plus fa-fw"></i></a></li>            
            <li class="icon twitter"><a href="#a"><i class="fa fa-twitter fa-fw"></i></a></li>
            <li class="icon facebook"><a href="#a"><i class="fa fa-facebook fa-fw"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
</footer>
<!-- end: footer --> 
</body>
</html>