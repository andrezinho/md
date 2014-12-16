<?php
require_once '/app/start.php'; //Start para facebook -> ;)
//require_once '/model/menu.php';
require_once '/app/funciones.php';

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
<link href="css/normalize.css" rel="stylesheet" type="text/css"/>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.css" rel="stylesheet">

<!-- IView Slider CSS -->
<link href="css/iView.css" rel="stylesheet">


<link href="css/micss.css" rel="stylesheet"/>

<!-- Animations -->
<link href="css/animate.css" rel="stylesheet" type="text/css"/>

<!-- Custom styles for this template -->
<link href="css/custom.css" rel="stylesheet" type="text/css" />

<!-- Style Switcher -->
<link href="css/style-switch.css" rel="stylesheet" type="text/css"/>

<!-- Color -->
<link href="css/skin/color.css" id="colorstyle" rel="stylesheet">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]> <script src="js/html5shiv.js"></script> <script src="js/respond.min.js"></script> <![endif]-->

<!-- Bootstrap core JavaScript -->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.js"></script>

<!-- Custom Scripts -->
<script src="js/scripts.js"></script>

<!-- iView Slider -->
<script src="js/raphael-min.js" type="text/javascript"></script>
<script src="js/jquery.easing.js" type="text/javascript"></script>
<script src="js/iView.js" type="text/javascript"></script>
<script src="js/retina-1.1.0.min.js" type="text/javascript"></script>
<script>
  !window.jQuery && document.write("<script src='js/jquery.min.js'><\/script>")
</script>
<!--[if IE 8]>
    <script type="text/javascript" src="js/selectivizr.js"></script>
    <![endif]-->

<script type="text/javascript" src="js/utilitarios.js"></script>
<script type="text/javascript" src="js/mijs/js.js"></script>
<script type="text/javascript" src="js/mijs/publicaciones.js"></script>

<!--<base href="http://localhost/md/index.php" />-->
</head>
<body>
<header>   
  <div class="c-top" style="background: #EEEEEE; padding: 5px 0 0 0; margin-top: -8px; box-shadow: 3px 2px 5px #ccc;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="topheadrow">
          <img src="images/logo.png" />
          <ul class="nav nav-pills pull-right">            
            <li class="dropdown" style="padding:10px 10px 6px;">Descuentos en
              <select id="ciudades" name="ciudades" class="web-list list-local" style="max-width:140px;border:0;">
                <?php 
                  $sql = "SELECT ";
                ?>
              </select>
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
  <div class="row" >
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 main-column box-block" >
        <div class="box-heading"><span>Descuentos del d&iacute;a</span><span class="view-all"><a href="#">[Ver Todos]</a></span></div>
      <div class="box-content">
        <div class="box-products slide" id="productc1">          
          <div class="carousel-inner"> 
            <!-- Items Row -->
            <div class="item active">
              <div class="row box-product" id="publicacion"> 
                  <!-- PUBLICACION  -->
              </div>
            </div>
            <!-- end: Items Row --> 
            <!-- Items Row -->
            
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 box-block sidebar">
      <div class="box-heading"><span>Descuentos Especiales</span></div>
      <div class="box-content" >
        <div class="box-products slide carousel-fade" id="productc2">
          <ol class="carousel-indicators">
            <li class="active" data-slide-to="0" data-target="#productc2"></li>
            <li class="" data-slide-to="1" data-target="#productc2"></li>
            <li class="" data-slide-to="2" data-target="#productc2"></li>
          </ol>
          <div class="carousel-inner" style="height:352px"> 
            <!-- item -->
            <div class="item active">
              <div class="product-block">
                <div class="image">
                  <div class="product-label product-sale"><span>-30%</span></div>
                  <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                <div class="product-meta">
                        <div class="name">
                          <a href="producto.html">
                          Parrila extrema + bebidas + show musical para 4  
                          </a>
                        </div>
                        <div class="big-price"> 
                            <span class="price-new">
                                <span class="sym">$</span>
                              96
                            </span> 
                            <span class="price-old">
                            <span class="sym">$</span>
                              119.50
                            </span> 
                        </div>                   
                        <div class="big-btns">
                            <a class="btn btn-default btn-View pull-left" href="producto.html">Ver</a>                            
                        </div> 
                    
                      
                    
                  </div>
                <div class="meta-back"></div>
              </div>
            </div>
            <!-- end: item --> 
            <!-- item -->
            <!-- slide descuentos especiales-->
            <div class="item">
              <div class="product-block">
                <div class="image"> 
                  <div class="product-label product-sale"><span>-30%</span></div>
                <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                <div class="product-meta">
                  <div class="name">
                  <a href="producto.html">
                    Parrila extrema + bebidas + show musical para 5 
                  </a>
                  </div>
                 <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Ver</a></div>
                </div>
                <div class="meta-back"></div>
              </div>
            </div>
            <!-- end: item --> 
            <!-- item -->
            <div class="item">
              <div class="product-block">
                <div class="image"> 
                  <div class="product-label product-sale"><span>-30%</span></div>
                <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                <div class="product-meta">
                  <div class="name">
                  <a href="producto.html">
                  Parrila extrema + bebidas + show musical para 6 
                  </a>
                  </div>
                 <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Ver</a></div>
                </div>
                <div class="meta-back"></div>
              </div>
            </div>
            <!-- end: item --> 
          </div>
        </div>
        <div class="carousel-controls">
          <a class="carousel-control left" data-slide="prev" href="#productc2">
            <i class="fa fa-angle-left fa-fw"></i> 
          </a> 
          <a class="carousel-control right" data-slide="next" href="#productc2"> 
            <i class="fa fa-angle-right fa-fw"></i> 
          </a> 
        </div>
        <div class="nav-bg"></div>
      </div>
    </div>
  </div>
</div>

<div class="row clearfix f-space30"></div>
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-column box-block">
      <div class="box-heading"><span>Descuentos de Viajes</span><span class="view-all"><a href="#">[Ver Todos]</a></span></div>
      <div class="box-content">
        <div class="box-products slide" id="productc3">
          <div class="carousel-inner"> 
            <!-- Items Row -->
            <div class="item active">
              <div class="row box-product"> 
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 4
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">Ver</a> <b>&GT;</b></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 4
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">VER <b>&GT;</b></a></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 4
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">VER <b>&GT;</b></a></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 4
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">VER <b>&GT;</b></a></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 
              </div>
            </div>
            <!-- end: Items Row --> 
            <!-- Items Row -->
            <div class="item">
              <div class="row box-product"> 
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 4
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">VER <b>&GT;</b></a></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 

                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 4
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">VER <b>&GT;</b></a></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 4
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="View"><a href="producto.html">VER <b>&GT;</b></a></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 5
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="View"><a href="producto.html">VER <b>&GT;</b></a></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 
              </div>
            </div>
            <!-- end: Items Row --> 
          </div>
        </div>


          <div class="row clearfix f-space30"></div>
              <!-- segundo bloque-->
              <div class="meta-back"></div>
              <div class="row box-product"> 
                <!-- Product -->
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 6
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">VER <b>&GT;</b></a></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 4
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">VER <b>&GT;</b></a></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 4
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">VER <b>&GT;</b></a></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>-30%</span></div>
                      <a class="img" href="producto.html"><img alt="product info" src="images/products/product1.jpg" title="product title"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        Parrila extrema + bebidas + show musical para 4
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">$</span>
                            96
                          </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                            119.50
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="producto.html">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">$</span>
                          96
                        </span> 
                        <span class="price-old">
                          <span class="sym">$</span>
                          119.50
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">VER <b>&GT;</b></a></button>
                      </div>

                    </div>
                    <div class="meta-back"></div>
                  </div> <!-- aqui. -->
                </div>
                <!-- end: Product --> 
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


<section class="like-box">
  
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like-box" data-href="https://www.facebook.com/MuchosDescuentos?fref=ts" data-width="1141px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>


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