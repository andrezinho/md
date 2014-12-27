<?php
session_start();
require_once 'head.php'; //Start para facebook -> ;)
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
    $.post('model/deletewish.php','i='+i,function(r){            
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
          <a href="index.php"><img src="images/logo.png" /></a>
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
            <?php if (!isset($_SESSION['facebook'])&&!isset($_SESSION['email'])): ?>
            <li class="dropdown">
              <a class="dropdown-toggle" data-hoView="dropdown" data-toggle="dropdown" href="#a"> 
                <i class="fa fa-user fa-fw"></i>
                  <span class="hidden-xs"> Iniciar Sesión</span>              
              </a>              
              <div class="loginbox dropdown-menu"> 
                Conectarse con:<br>
                  <div class="social-icons">
                    <ul>
                      <li class="icon google-plus"><a href="#a"><i class="fa fa-google-plus fa-fw"></i></a></li>
                      <li class="icon twitter"><a href="#"><i class="fa fa-twitter fa-fw"></i></a></li>
                      <li class="icon facebook" id="icon_facebook"><a href="<?php echo $helper->getLoginUrl($config['scopes']); ?>"><i class="fa fa-facebook fa-fw"></i></a></li>
                    </ul>
                  </div>               
               <br><br>
               <div id="log-in"><hr> 
                <span>Login:</span>
                <span><a href="cuenta.php" id="registrar">Registrar</a></span>
               </div>
               <form id="frmlogin" method="post"  action="panel/web/process.php">
                  <div class="form-group"> <i class="fa fa-user fa-fw"></i>
                    <input class="form-control" id="usuario" name="usuario" placeholder="Email" type="text" data-validation="required">
                  </div>
                  <div class="form-group"> <i class="fa fa-lock fa-fw"></i>
                    <input class="form-control" id="password" name="password" placeholder="Password" type="password" data-validation="required">
                  </div>
                  <button class="btn medium color1 pull-right" type="submit">Entrar</button>
               </form>
               <a href="#">¿Olvidaste tu contrase&nacute;a?</a>
              </div>
            </li>
              <?php else: ?>
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" data-hoView="dropdown" href="#a"><i class="fa fa-user fa-fw"></i>
                  <?php echo $_SESSION['name'];?>
                  </a>

                    <div class="loginbox dropdown-menu"> 
                    
                      <ul>
                      <?php if($_SESSION['id_perfil']!=4) { ?>
                      <li><a href="panel/">Panel Admin</a></li>
                      <?php } 
                      else { ?>
                        <li><a href="cuenta.php">Mis Datos</a></li>
                      <?php } ?>
                      <li><a href="#">Mis Cupones</a></li>
                      <li><a href="#">Mis Suscripciones</a></li>
                      <li><a href="app/logout.php">Salir</a></li>
                      </ul>               
                    </div>
                </li>
                <?php endif; ?>
                 
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
          <li> <a href="index.php"><span class="hidden-sm">&Uacute;ltimas Ofertas</span></a>
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
              <button class="btn btn-default btn-compare pull-left" title="Ver" style="background:green"><a href="producto/<?php echo urls_amigables($r['titulo1']."-".$r['idpublicaciones']);?>">Ver</a></button>
            <td align="center">
              <button class="btn btn-default btn-compare pull-left" title="Quitar" style="background:red"><a href="#" id="quit-<?php echo $r['idpublicaciones'] ?>" class="quit-wish">Quitar <b>X</b></a></button>
            </td>

          </tr>
          <?php
        }
        
        ?>
      </table>
    </div>
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
<script type="text/javascript">
(function($) {
  "use strict";
    $('#menuMega').menu3d();
    $('#iView').iView({
        pauseTime: 10000,
        pauseOnHoView: true,
        directionNavHoViewOpacity: 0.6,
        timer: "360Bar",
        timerBg: '#2da5da',
        timerColor: '#fff',
        timerOpacity: 0.9,
        timerDiameter: 20,
        timerPadding: 1,
touchNav: true,
        timerStroke: 2,
        timerBarStrokeColor: '#fff'
    });				
    $('.quickbox').carousel({
        interval: 10000
    });
   $('#monthly-deals').carousel({
        interval: 3000
    });
    $('#productc2').carousel({
        interval: 4000
    });
    $('#tweets').carousel({
        interval: 5000
    });
})(jQuery);
</script>
</body>
</html>