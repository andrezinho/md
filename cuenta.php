<?php
require_once 'head.php'; //Start para facebook -> x)
$url=$_GET["id"];
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
            <li> <a href="<?php echo $host; ?>/deseos.php"> <i class="fa fa-heart fa-fw"></i> <span class="hidden-xs">Mis Deseos</span></a> </li>            
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

<h3 class="micuenta">Mi Cuenta</h3>
<hr>
<article class="enlaces">
    <p><b><a href="#" id="datos">Mis Datos</a></b></p>
    <!--<p><b><a href="#" id="direccion">Mis Direcci&oacute;n</a></b></p>-->
    <!--<p><b><a href="#" id="cupones">Mis Cupones</a></b></p>-->
    <!--<p><b><a href="#" id="creditos">Mis Cr&eacute;ditos</a></b></p>-->
    <!--<p><b><a href="#" id="suscripciones">Mis Suscripciones</a></b></p>-->
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

 <aside id="actualizar" style="display: none;">
    <span style='font-weight:bold;color:#000;text-align:center'>
        <center><h3>MuchosDescuentos</h3> Tus datos se actualizar&oacute;n correctamente.</center>
    </span>
    <hr>
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
            <li><a href="#" style="color:#333 !important;">Empresa 6</a></li>                        
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