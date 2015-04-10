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
              <select id="ciudades" name="ciudades" class="web-list list-local" style="max-width:200px;border:0;">
                 <?php                   
                  $sql = "SELECT c.cod,concat(u.descripcion,' ',coalesce(c.zona,'')) 
                                from ciudad as c 
                                inner join ubigeo as u on c.idciudad = u.idubigeo 
                                where c.estado = 1 order by c.cod ";
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
            <li> <a href="#" id="recibir_ofertas"> <i class="fa fa-envelope fa-fw"></i> <span class="hidden-xs">Quiero Recibir Descuentos</span></a> </li>
            <?php if (isset($_SESSION['facebook'])||isset($_SESSION['email'])): ?>
            <li> <a href="<?php echo $host; ?>/deseos"> <i class="fa fa-heart fa-fw"></i> <span class="hidden-xs">Mis Deseos</span></a> </li>            
            <?php endif; ?>
            <?php echo login($helper,$config); ?>     
          </ul>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="container" style="height: 47px; "> 
      <div class="row" style="padding: 0px 0 0 0;">
          <div class="searchbar" style="float:right; width:175px; margin-right: 15px; background: #FFF;">
            <div class="social-icons">
                <ul>
                  <li class="icon google-plus"><a href="#a"><i class="fa fa-google-plus fa-fw"></i></a></li>
                  <li class="icon linkedin"><a href="#a"><i class="fa fa-linkedin fa-fw"></i></a></li>
                  <li class="icon twitter"><a href="#a"><i class="fa fa-twitter fa-fw"></i></a></li>
                  <li class="icon facebook"><a href="https://www.facebook.com/MuchosDescuentos?fref=ts" target="_BLANK"><i class="fa fa-facebook fa-fw"></i></a></li>
                </ul>
            </div>  
        </div>
        <div class="searchbar" style="float:right; width:320px;">
          <form action="resultados.php" method="get">                  
            <div style="background: red; float: left; border:1px solid #dadada ">
              <input class="searchinput" name="search" id="search" placeholder="Buscar..." type="search" style="height: 38px; width:290px; ">
            </div>
            <div class="searchbox center" style="width: 27px;background:#DE1215;">
              <button class="fa fa-search fa-fw" type="submit" style="color:#FFF !important"></button>
            </div>          
          </form>          
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
     Para agregar tus <b>Deseos</b> primero debes <b>Inciar Sesion</b> con tu cuenta de usuario o mediante Facebook.
    </div>
  <?php else: ?>    
    <h2>Lista de deseos</h2>
    <div>
      <table class="table-list-md" style="width:100%">
        <tr>
          <th>Item</th>          
          <th>Titulo</th>
          <th>Precio S/.</th>
          <th>Precio Real S/.</th>
          <th>Ahorro S/.</th>          
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
        <?php 
        $sql = "SELECT p.*,coalesce(d.idpublicaciones,0) as deseo,td.nombre as tipo_descuento 
                FROM publicaciones as p inner join suscripcion as s on s.idsuscripcion = p.idsuscripcion inner join 
                local as l on l.idlocal = s.idlocal inner join deseos as d on d.idpublicaciones = p.idpublicaciones 
                inner join tipo_descuento as td on td.idtipo_descuento = p.idtipo_descuento
                WHERE p.estado<>0 and d.idusuario = ".$_SESSION['idusuario']."
                ORDER BY idpublicaciones desc ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $c = 0;
        foreach($stmt->fetchAll() as $r)
        {
          $c +=1;
          ?>
          <tr>
            <td align="center"><?php echo $c; ?></td>
            <td><?php echo utf8_encode($r['titulo1']); ?></td>
            <td align="right"><?php echo number_format($r['precio'],2); ?></td>
            <td align="right" style="text-decoration:line-through;">            
              <?php 
                if($r['tipo_descuento']=="Porcentajes")
                {
                   echo number_format($r['precio_regular'],2); 
                }
              ?>
            </td>
            <td align="right">
              <?php
                if($r['tipo_descuento']=="Porcentajes")
                {
                  echo number_format($r['precio_regular']-$r['precio'],2); 
                }
                else
                {
                  echo $r['tipo_descuento'];
                }
              ?>
            </td>
            <td align="center">
              <button class="btn btn-default btn-compare pull-left" title="Ver" style="background:green"><a href="<?php echo $host; ?>/producto/<?php echo urls_amigables($r['titulo1']."-".$r['idpublicaciones']);?>">Ver</a></button>
            <td align="center">
              <button class="btn btn-default btn-compare pull-left" title="Quitar" style="background:red"><a href="#" id="quit-<?php echo $r['idpublicaciones'] ?>" class="quit-wish">Quitar <b>X</b></a></button>
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