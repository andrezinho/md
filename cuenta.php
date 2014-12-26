<?php
require_once 'head.php'; //Start para facebook -> x)
?>
<script type="text/javascript">
  $(document).ready(function(){
    $.get('cuenta/datos.php',function(datos){//alert(datos);
      $(".formulario").show().html(datos);
  });
  });
</script>
</head>
<body>
<header>   
  <div class="c-top" style="background: #EEEEEE; padding: 5px 0 0 0; margin-top: -8px; box-shadow: 3px 2px 5px #ccc;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="topheadrow">
          <a href="index.php"><img src="images/logo.png" /></a>
          <ul class="nav nav-pills pull-right">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" data-hoView="dropdown" href="#a">Lima <i class="fa fa-angle-down fa-fw"></i></a>              
              <ul class="dropdown-menu" role="menu">
                  <li><a href="#a">LIMA</a></li>                
                  <li><a href="#a">TRUJILLO</a></li>                
              </ul>
            </li>            
            <li> <a href="#a"> <i class="fa fa-envelope fa-fw"></i> <span class="hidden-xs">Quiero Recibir Ofertas</span></a> </li>
            <li> <a href="#a"> <i class="fa fa-heart fa-fw"></i> <span class="hidden-xs">Mis Deseos</span></a> </li>            
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
                <span><a href="#">Registrar</a></span>
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
                        <li><a href="#">Mis Datos</a></li>
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
          <li> <a href="index.php"><span class="hidden-sm">&Uacute;ltimas Ofertas</span><i class="fa fa-angle-down fa-fw"></i></a>
          </li>
            <!-- Menu -->

          </ul>
        </div>
          <div class="clearfix"></div>
      </div>
    </div>
  </div>
</header>
<!-- end: Header --> 
</div>
</div>
</div>
<!-- end: Widgets -->

<div class="container" style="">

  
<?php if (!isset($_SESSION['facebook'])&&!isset($_SESSION['email'])){ ?>
  <article class="conface">
    <h3>Conectar con Facebook</h3>
    <p style="font-size:12px">Conecta tu cuenta de Facebook para ingresar a MuchosDescuentos</p>
    <a href="<?php echo $helper->getLoginUrl($config['scopes']); ?>">
    <img src="images/conface.png" alt="conectar con facebook">
    </a>
  </article>

<?php } 
     else{ ?>

<h3>Mi Cuenta</h3>
<hr>
<article class="enlaces">
    <p><b><a href="#" id="datos">Mis Datos</a></b></p>
    <!--<p><b><a href="#" id="direccion">Mis Direcci&oacute;n</a></b></p>-->
    <p><b><a href="#" id="cupones">Mis Cupones</a></b></p>
    <!--<p><b><a href="#" id="creditos">Mis Cr&eacute;ditos</a></b></p>-->
    <p><b><a href="#" id="suscripciones">Mis Suscripciones</a></b></p>
  </article>
<?php } ?>

  <aside class="formulario">

  </aside>
  <aside id="bienvenido">
    <span style='font-weight:bold;color:#000;text-align:center'>
    <h3>Bienvenido a MuchosDescuentos</h3> Te has registrado correctamente.
    </span>
    <hr>
    <p>Ya puedes Iniciar Sesi&oacute;n.</p> 
    </aside>

</div>


<div class="row clearfix f-space30"></div>
<!-- footer -->
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


<script>

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