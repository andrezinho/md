<?php
require_once '/app/start.php'; //Start para facebook -> ;)
require_once '/app/funciones.php';
$db = Spdo::singleton();

//$host="http://".$_SERVER['SERVER_NAME']."/md";

$url=$_GET["id"];
$str=explode("-", $url);

$n=count($str);
$id="";
for($i=0; $i<$n; $i++){
$id .=$str[$i]." ";
}

$stmt = $db->prepare("SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion,
                             c.descripcion,p.precio,p.precio_regular,p.descuento,
                             p.imagen,p.idtipo_descuento
                      FROM publicaciones as p
                      INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                      INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                      WHERE c.descripcion=:id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        $nc= $stmt->rowCount();


        //echo $nc;
        
?>
<!DOCTYPE html>
<html class="noIE" lang="es">
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="Viewport">
<meta content="Muchos Descuentos" name="description">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<!--<meta content="logoby.us" name="author">-->
<title>Muchos Descuentos</title>

<!-- Reset CSS -->
<link href="<?php echo $host; ?>/css/normalize.css" rel="stylesheet" type="text/css"/>

<!-- Bootstrap core CSS -->
<link href="<?php echo $host; ?>/css/bootstrap.css" rel="stylesheet">

<!-- IView Slider CSS -->
<link href="<?php echo $host; ?>/css/iView.css" rel="stylesheet">


<link href="<?php echo $host; ?>/css/micss.css" rel="stylesheet"/>

<!-- Animations -->
<link href="<?php echo $host; ?>/css/animate.css" rel="stylesheet" type="text/css"/>

<!-- Custom styles for this template -->
<link href="<?php echo $host; ?>/css/custom.css" rel="stylesheet" type="text/css" />

<!-- Style Switcher -->
<link href="<?php echo $host; ?>/css/style-switch.css" rel="stylesheet" type="text/css"/>

<!-- Color -->
<link href="<?php echo $host; ?>/css/skin/color.css" id="colorstyle" rel="stylesheet">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]> <script src="js/html5shiv.js"></script> <script src="js/respond.min.js"></script> <![endif]-->

<!-- Bootstrap core JavaScript -->
<script src="<?php echo $host; ?>/js/jquery-1.10.2.min.js"></script>
<script src="<?php echo $host; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo $host; ?>/js/bootstrap-select.js"></script>

<!-- Custom Scripts -->
<script src="<?php echo $host; ?>/js/scripts.js"></script>

<!-- iView Slider -->
<script src="<?php echo $host; ?>/js/raphael-min.js" type="text/javascript"></script>
<script src="<?php echo $host; ?>/js/jquery.easing.js" type="text/javascript"></script>
<script src="<?php echo $host; ?>/js/iView.js" type="text/javascript"></script>
<script src="<?php echo $host; ?>/js/retina-1.1.0.min.js" type="text/javascript"></script>
<script>
  !window.jQuery && document.write("<script src='<?php echo $host; ?>/js/jquery.min.js'><\/script>")
</script>
<!--[if IE 8]>
    <script type="text/javascript" src="js/selectivizr.js"></script>
    <![endif]-->

<script type="text/javascript" src="<?php echo $host; ?>/js/mijs/js.js"></script>
<script type="text/javascript" src="<?php echo $host; ?>/js/mijs/publicaciones.js"></script>

<!--<base href="http://localhost/md/index.php" />-->
</head>
<body>
<header>   
  <div class="c-top" style="background: #EEEEEE; padding: 5px 0 0 0; margin-top: -8px; box-shadow: 3px 2px 5px #ccc;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="topheadrow">
          <a href="<?php echo $host; ?>/index.php"><img src="<?php echo $host; ?>/images/logo.png" /></a>
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
                      <li><a href="<?php echo $host;?>/panel/">Panel Admin</a></li>
                      <?php } 
                      else { ?>
                        <li><a href="<?php echo $host;?>/cuenta.php">Mis Datos</a></li>
                      <?php } ?>
                      <li><a href="#">Mis Cupones</a></li>
                      <li><a href="#">Mis Suscripciones</a></li>
                      <li><a href="<?php echo $host;?>/app/logout.php">Salir</a></li>
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

            <!-- Menu -->

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
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-column box-block">
      <div class="box-heading"><span>Mostrando <?php echo $nc; ?> descuentos <b style="font-size:16px; color:#FCD209">- <?php echo $id;?></b></span></div>
      <div class="box-content" id="item">
        <div class="box-products slide" id="productc3">
          <div class="carousel-inner"> 
            <!-- Items Row -->
            <div class="item active">
              <div class="row box-product" > 
                <!-- Product -->
                

                <?php while($r = $stmt->fetch()){

                $link = $host."/producto/".urls_amigables($r['titulo1']."-".$r['idpublicaciones']);
                $img  = $host."/panel/web/imagenes/home/small_".$r['imagen'].".jpg";
                if($r['idtipo_descuento']!=1){$descuento="-".$r['descuento']."%";}
                else{$descuento=$r['descuento'];} 
                  ?>


                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span><?php echo $descuento;?></span></div>
                      <a class="img" href="<?php echo $link;?>"><img alt="product info" src="<?php echo $img;?>" title="<?php echo $r['titulo1'];?>"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        <?php echo $r['titulo1'];?>
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                           <?php echo $r['precio'];?>
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            <?php echo $r['precio_regular'];?>
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          <?php echo $r['precio'];?>
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          <?php echo $r['precio_regular'];?>
                        </span>
                      </div>
                      <div class="rating"> 
                        <i class="fa fa-star"></i> 
                        <i class="fa fa-star"></i> 
                        <i class="fa fa-star"></i> 
                        <i class="fa fa-star-half-o"></i> 
                        <i class="fa fa-star-o"></i> 
                      </div>
                      
                      <div class="small-btns">
                        <button class="btn btn-default btn-wishlist pull-left" title="">
                         <i class="fa fa-heart fa-fw"></i> 
                        </button>
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="<?php echo $link; ?>">Ver</a> <b>&GT;</b></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> 
                </div> <!-- fin col-lg-3 col-md-3 col-sm-6 col-xs-12-->



                <?php }?>





              </div>
            </div>
            
          </div>
        </div>
        </div>

      </div>
    </div>
  </div>
</div>
<!-- end: Products --> 


          <div class="f-space10"></div>
        </div>
       
       
          <!-- end: twitter widget box -->
          <div class="f-space10"></div>
        </div>
      </div>
     
  </div>
</div>
<!-- end: Widgets -->

<div class="row clearfix f-space30"></div>

<!-- footer -->


<section class="pages">
      <div class="holder">
        <a class="jp-previous jp-disabled">← previous</a>
        <a class="jp-current">1</a>
        <span class="jp-hidden">...</span>
        <a>2</a>
        <a>3</a>
        <a>4</a>
        <a>5</a>
        <a class="jp-hidden">6</a>
        <a class="jp-hidden">7</a>
        <a class="jp-hidden">8</a>
        <a class="jp-hidden">9</a>
        <span>...</span>
        <a>10</a>
        <a class="jp-next">next →</a>
    </div>
</section>






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
            <li><a href="#">Preguntas Frecuentes.</a></li>
            <li><a href="#">Acerca del Pago en Efectivo.</a></li>
            <li><a href="#">Libro de Reclamaciones.</a></li>
            <li><a href="#">Pol&iacute;ticas y Privacidad.</a></li>
            <li><a href="#">Mapa del sitio.</a></li>            
        </ul>        
      </div>
      <div class="col-sm-3 col-xs-12 shopinfo">
        <h4 class="title">EMPRESAS</h4>
            <li><a href="#">Empresa 1</a></li>
            <li><a href="#">Empresa 2</a></li>
            <li><a href="#">Empresa 3</a></li>
            <li><a href="#">Empresa 4</a></li>
            <li><a href="#">Empresa 5</a></li>                        
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