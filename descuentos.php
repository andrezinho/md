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

<!--	Responsive 3D Menu	-->
<link href="css/menu3d.css" rel="stylesheet"/>

<!-- Animations -->
<link href="css/animate.css" rel="stylesheet" type="text/css"/>

<!-- Custom styles for this template -->
<link href="css/custom.css" rel="stylesheet" type="text/css" />

<!-- Style Switcher -->
<link href="css/style-switch.css" rel="stylesheet" type="text/css"/>

<!-- Color -->
<link href="css/skin/color.css" id="colorstyle" rel="stylesheet">

<!-- Paginacion -->
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/jPages.css">
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]> <script src="js/html5shiv.js"></script> <script src="js/respond.min.js"></script> <![endif]-->

<!-- Bootstrap core JavaScript -->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.js"></script>

<!-- Custom Scripts -->
<script src="js/scripts.js"></script>

<!-- MegaMenu -->
<script src="js/menu3d.js" type="text/javascript"></script>
<!-- iView Slider -->
<script src="js/raphael-min.js" type="text/javascript"></script>
<script src="js/jquery.easing.js" type="text/javascript"></script>
<script src="js/iView.js" type="text/javascript"></script>
<script src="js/retina-1.1.0.min.js" type="text/javascript"></script>
<script>
  !window.jQuery && document.write("<script src='js/jquery.min.js'><\/script>")
</script>
<!-- Paginacion -->
<script src="js/jPages.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
     /* initiate plugin */
        $("div.holder").jPages({
            containerID  : "item",
            perPage      : 8,
            startPage    : 1,
            startRange   : 1,
            midRange     : 5,
            endRange     : 1,
            scrollBrowse :true,
            keyBrowse    :true   
        });
        });
  
</script>



<!--[if IE 8]>
    <script type="text/javascript" src="js/selectivizr.js"></script>
    <![endif]-->

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
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" data-hoView="dropdown" href="#a">Lima <i class="fa fa-angle-down fa-fw"></i></a>              
              <ul class="dropdown-menu" role="menu">
                  <li><a href="#a">LIMA</a></li>                
                  <li><a href="#a">TRUJILLO</a></li>                
              </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" data-hoView="dropdown" href="#a">(01)33333) <i class="fa fa-angle-down fa-fw"></i> </a>
            </li>
            <li> <a href="#a"> <i class="fa fa-envelope fa-fw"></i> <span class="hidden-xs">Quiero Recibir Ofertas</span></a> </li>
            <li> <a href="#a"> <i class="fa fa-heart fa-fw"></i> <span class="hidden-xs">Mis Deseos</span></a> </li>
            <li class="dropdown"> <a class="dropdown-toggle" data-hoView="dropdown" data-toggle="dropdown" href="#a"> <i class="fa fa-user fa-fw"></i> <span class="hidden-xs"> Iniciar Sesión</span></a>
              
              <div class="loginbox dropdown-menu"> 
                Conectarse con:<br>
                  <div class="social-icons">
                    <ul>
                      <li class="icon google-plus"><a href="#a"><i class="fa fa-google-plus fa-fw"></i></a></li>
                      <li class="icon twitter"><a href="#a"><i class="fa fa-twitter fa-fw"></i></a></li>
                      <li class="icon facebook"><a href="#a"><i class="fa fa-facebook fa-fw"></i></a></li>
                    </ul>
                  </div>
               <!-- <span class="form-header">Login</span>-->
               <br><br>
               <div id="log-in"><hr> 
                <span>Login:</span>
                <span><a href="#">Registrar</a></span>
               </div>
                
                <form>
                  <div class="form-group"> <i class="fa fa-user fa-fw"></i>
                    <input class="form-control" id="InputUserName" placeholder="Username" type="text" data-validation="required">
                  </div>
                  <div class="form-group"> <i class="fa fa-lock fa-fw"></i>
                    <input class="form-control" id="InputPassword" placeholder="Password" type="password" data-validation="required">
                  </div>
                  <button class="btn medium color1 pull-right" type="submit">Entrar</button>
                </form>
                <a href="#">¿Olvidaste tu contrase&nacute;a?</a>
              </div>
            </li>
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
                  <li class="icon facebook"><a href="#a"><i class="fa fa-facebook fa-fw"></i></a></li>
                </ul>
            </div>  
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row clearfix" style="width: 1140px;margin-left: 0px;">
      <div> 
        <!-- Navigation Buttons/Quick Cart for Tablets and Desktop Only -->
        <div class="menu-links hidden-xs">
          <ul class="nav nav-pills nav-justified">
          <li> <a href="index.html"><span class="hidden-sm">&Uacute;ltimas Ofertas</span><i class="fa fa-angle-down fa-fw"></i></a> </li>
            <li> <a href="index.html"><span class="hidden-sm">Viajes</span><i class="fa fa-angle-down fa-fw"></i></a> </li>
            <li> <a href="about.html"><span class="hidden-sm">Servicios</span> <i class="fa fa-angle-down fa-fw"></i></a> </li>
            <li> <a href="blog.html"><span class="hidden-sm">Restaurants</span><i class="fa fa-angle-down fa-fw"></i></a> </li>
            <li> <a href="contact.html"><span class="hidden-sm ">Productos</span><i class="fa fa-angle-down fa-fw"></i></a> </li>
            <li class="dropdown"> <a href="cart.html"><span class="hidden-sm"> Belleza y Salud</span><i class="fa fa-angle-down fa-fw"></i></a> 
              <!-- 
              <div class="dropdown-menu quick-cart">
                <div class="qc-row qc-row-heading"> hola </div>
                
              </div>
               --> 
            </li>
            <li> <a href="contact.html"><span class="hidden-sm">Entretenimiento</span><i class="fa fa-angle-down fa-fw"></i></a> </li>
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
      <div class="box-heading"><span>Mostrando 18 descuentos <b style="font-size:16px; color:#FCD209">- Viajes</b></span></div>
      <div class="box-content" id="item">
        <div class="box-products slide" id="productc3">
          <div class="carousel-inner"> 
            <!-- Items Row -->
            <div class="item active">
              <div class="row box-product" > 
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">Ver1</a> <b>&GT;</b></button>
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
                        <button class="btn btn-default btn-compare pull-left" title="Ver"><a href="producto.html">VER4 <b>&GT;</b></a></button>
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