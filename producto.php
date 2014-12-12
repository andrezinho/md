<?php 
$host="http://".$_SERVER['SERVER_NAME']."/md";
require '/app/start.php'; //Start para facebook -> ;)
$db = Spdo::singleton(); 

$url=$_GET["id"];

$id=explode("-",$url);
$n=count($id);

$titulo="";
for($s=0; $s<($n-1); $s++) { 
  $titulo .=$id[$s]." ";
}
$id=$id[$n-1];


$stmt = $db->prepare("SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion as desc_publi,
                             c.descripcion as categoria,p.precio,p.precio_regular, p.imagen,p.fecha_inicio,
                             p.fecha_fin,p.hora_inicio,p.hora_fin,p.descuento,e.idempresa,e.razon_social as empresa,e.logo,e.facebook,e.twitter,e.youtube,
                             e.website,e.nombre_contacto, l.idubigeo,l.descripcion,
                             l.direccion,l.referencia,l.telefono1,l.telefono2,l.horario,
                             l.mapa_google
                      FROM publicaciones as p
                              INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                              INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                              INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion
                              INNER JOIN local as l on l.idlocal=su.idlocal
                              INNER JOIN empresa as e on e.idempresa=l.idempresa 
                       WHERE idpublicaciones=:id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        $r = $stmt->fetch();
        $ahorro=$r['precio_regular']-$r['precio'];
        $img=$host."/panel/web/imagenes/".$r['imagen'].".jpg";
        if($r['logo']!=""){$logo=$host."/panel/web/imagenes/logos/".$r['logo'];}
        else{$logo=$host."/images/nologo.png";}
        

 ?>
<!DOCTYPE html>
<html class="noIE" lang="en-US">
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
<meta content="Flatroshop online shopping point" name="description">
<meta content="logoby.us" name="author">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<title>Muchos Descuentos - Detalle</title>
<!-- Reset CSS -->
<link href="<?php echo $host;?>/css/normalize.css" rel="stylesheet" type="text/css"/>
<!-- Bootstrap core CSS -->
<link href="<?php echo $host;?>/css/bootstrap.css" rel="stylesheet">

<!-- Iview Slider CSS -->
<link href="<?php echo $host;?>/css/iview.css" rel="stylesheet">

<!--  Responsive 3D Menu  -->
<link href="<?php echo $host;?>/css/menu3d.css" rel="stylesheet"/>

<!-- Animations -->
<link href="<?php echo $host;?>/css/animate.css" rel="stylesheet" type="text/css"/>

<!-- Custom styles for this template -->
<link href="<?php echo $host;?>/css/custom.css" rel="stylesheet" type="text/css" />

<!-- Style Switcher -->
<link href="<?php echo $host;?>/css/style-switch.css" rel="stylesheet" type="text/css"/>

<!-- Color -->
<link href="<?php echo $host;?>/css/skin/color.css" id="colorstyle" rel="stylesheet">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]> <script src="<?php echo $host;?>/js/html5shiv.js"></script> <script src="<?php echo $host;?>/js/respond.min.js"></script> <![endif]-->

<!-- Bootstrap core JavaScript -->
<script src="<?php echo $host;?>/js/jquery-1.10.2.min.js"></script>
<script src="<?php echo $host;?>/js/bootstrap.min.js"></script>
<script src="<?php echo $host;?>/js/bootstrap-select.js"></script>

<!-- Custom Scripts -->
<script src="<?php echo $host;?>/js/scripts.js"></script>

<!-- MegaMenu -->
<script src="<?php echo $host;?>/js/menu3d.js" type="text/javascript"></script>

<!-- iView Slider -->
<script src="<?php echo $host;?>/js/raphael-min.js" type="text/javascript"></script>
<script src="<?php echo $host;?>/js/jquery.easing.js" type="text/javascript"></script>
<script src="<?php echo $host;?>/js/iview.js" type="text/javascript"></script>
<script src="<?php echo $host;?>/js/retina-1.1.0.min.js" type="text/javascript"></script>

<!--[if IE 8]>
    <script type="text/javascript" src="<?php echo $host;?>/js/selectivizr.js"></script>
    <![endif]-->

</head>
<body>
<!-- Header -->
<header> 
  <!-- Top Heading Bar -->
  <div class="c-top" style="background: #EEEEEE; padding: 5px 0 0 0; margin-top: -8px; box-shadow: 3px 2px 5px #ccc;">
  <div class="container">
    <div class="row">

      <div class="col-md-12">

        <div class="topheadrow">

            <a href="<?php echo $host;?>/index.php"><img src="<?php echo $host;?>/images/logo-icon.png" class="logo-icon" style="width:43px;height:43px; margin-top: 2px;" /></a>



          <ul class="nav nav-pills pull-right">


            <!-- 
              <li class="dropdown">
               <a class="dropdown-toggle" data-toggle="dropdown" data-hoView="dropdown" href="#a">Inicio</a>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" data-hoView="dropdown" href="#a">Nombre de la Categoria</a>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" data-hoView="dropdown" href="#a">Sub Categoria</a>
            </li>
            -->
            <!-- <li style="border-left:0"> <a href="#a"> <i class="fa fa-envelope fa-fw"></i> <span class="hidden-xs">Quiero Recibir Ofertas</span></a> </li> -->
          
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" data-hoView="dropdown" href="#a">Tef: (01)33333) <i class="fa fa-angle-down fa-fw"></i> </a>
            </li>
            <li> <a href="#a"> <i class="fa fa-heart fa-fw"></i> <span class="hidden-xs">Mis Deseos</span></a> </li>
            <li class="dropdown"> <a class="dropdown-toggle" data-hoView="dropdown" data-toggle="dropdown" href="#a"> <i class="fa fa-user fa-fw"></i> <span class="hidden-xs"> Iniciar Sesión</span></a>
              <div class="loginbox dropdown-menu"> 
                Conectarse con:<br>
                  <div class="social-icons">
                    <ul>
                      <li class="icon google-plus"><a href="#a"><i class="fa fa-google-plus fa-fw"></i></a></li>
                      <li class="icon twitter"><a href="#a"><i class="fa fa-twitter fa-fw"></i></a></li>
                      <li class="icon facebook" id="icon_facebook"><a href="<?php echo $helper->getLoginUrl($config['scopes']); ?>"><i class="fa fa-facebook fa-fw"></i></a></li>
                    </ul>
                  </div>
               <!-- <span class="form-header">Login</span>-->
               <br><br>
               <div><hr> Login:</div>
                
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

          <div class="searchbar" style="float:right; width:auto; margin-right: 7px;">                        
                <div class="social-icons-r" style="margin-top:3px">                    
                  <ul>
                  <li class="icon google-plus"><a href="#a"><i class="fa fa-google-plus fa-fw"></i></a></li>
                  <li class="icon twitter"><a href="#a"><i class="fa fa-twitter fa-fw"></i></a></li>
                  <li class="icon facebook"><a href="https://www.facebook.com/MuchosDescuentos?fref=ts" target="_blank"><i class="fa fa-facebook fa-fw"></i></a></li>
                </ul>
                </div>
            </div>



        </div>

      </div>
    </div>
  </div>
 </div>
  <!-- end: Top Heading Bar -->
  
  <!-- end: Logo and Search -->
  <!--<div class="f-space20"></div>-->
  <!-- Menu -->

  <div class="container" >
      <div style="width: 846px; display: inline-block; background: #EEEEEE">
            <div class="product-details-head" style="float:left; width:200px; border-right: 1px solid #fafafa;">
                <div class="short-info-det-name-empresa">                    
                  <div class="name-empresa">
                    <img src="<?php echo $logo;?>" class="logo-empresa">  
                    <b><?php echo $r['empresa'];?></b>
                  </div>
                <div class="frase-empresa"><?php //echo frase ?></div>
                </div>
            </div>
            <div style="width:auto; float:left; border-right: 1px solid #fafafa;">                                
                <div style="padding:10px 10px"> 


                <?php 
                  $stmt = $db->prepare("SELECT * FROM local WHERE idempresa=:ide");
                  $stmt->bindValue(':ide', $r['idempresa'] , PDO::PARAM_INT);
                  $stmt->execute();
                ?>


                    <select class="web-list list-local" style="max-width:140px;">
                    
                    <?php while($x = $stmt->fetch()){ $c=1;?>

                      <option value="<?php echo $x['idubigeo'];?>"><?php echo $x['descripcion'];?></option>
                    
                    <?php $c++; }?>
                    
                    </select>
               </div>
            </div>                      
            <div style="width:auto; float:left; border-right: 1px solid #fafafa; border-right: 0;">                                
                <div style="padding:5px 0px 5px 5px">
                    <div style="height: 40px; padding: 13px 0 0">
                        <a href="#" style="color:#333;" data-toggle="tooltip"  title="Recibir Descuentos de Shoes Center"><i class="fa fa-envelope fa-fw" style="color:#333"></i>&nbsp;</a>                        
                    </div>                    
                    <!-- <input type="button" value="Quiero Recibir Descuentos" class="btn-deseo" style="background:#C73B2C !important; color:#fff !important; width:auto;" /> -->
                </div>
            </div>
            <div style="width:auto; float:left; border-right: 0">
                <div style="padding:5px 0px 5px 0px">
                    <div>
                        <input type="text" name="deseo-descuento" class="input-deseo" placeholder="tucorreo@midominio.com" style="border:1px solid #999; width: 100%"/>
                    </div>                    
                </div>
            </div>
            <div style="width:auto; float:left; border-right: 1px solid #fafafa; padding:0 10px 0 0 ">                                
                <div style="padding:5px 0px 5px 0px">
                    <div>
                        <input type="button" value="Suscribirse" class="btn-deseo" style="background:#C73B2C !important; color:#fff !important; width:auto;" /> 
                    </div>
                </div>
            </div>
            <div class="searchbar" style="float:right; width:auto; margin-right: 7px;">                        
                <div class="social-icons" style="">                    
                      <ul >
                        <li class="icon youtube" ><a href="<?php echo $r['youtube'];?>" target="_blank" style="background:#DC2310"><i class="fa fa-youtube fa-fw"></i></a></li>                  
                        <li class="icon twitter"><a href="<?php echo $r['twitter'];?>" target="_blank" style="background:#33BCE9"><i class="fa fa-twitter fa-fw"></i></a></li>
                        <li class="icon facebook"><a href="<?php echo $r['facebook'];?>" target="_blank" style="background:#37528D"><i class="fa fa-facebook fa-fw"></i></a></li>
                      </ul>
                </div>
            </div>
            <div style="width:85px; float:right; padding: 17px 0 0">S&iacute;guenos en :</div>
          
      </div>
        <div id="buscador" class="product-details-head">
           <div class="searchbar-details">
              <form action="#">
                  <input name="input_seach" class="searchinput" id="" placeholder="Buscar..."  />
                  <div class="searchbox pull-left">
                    <button class="fa fa-search fa-fw" type="submit" style="margin-top:3px;"></button>
                  </div>
              </form>
            </div>
        </div>

  </div>

      </div>
    </div>
  </div>
</header>
<!-- end: Header -->
<div class="row clearfix f-space20"></div>
<div class="container">




    <div class="row">
        
        <section id="contenido">
              <div class="box-heading"><span><?php echo strtoupper($r['titulo2']);?></span></div>  
          <section id="producto-detalle">        
            <article class="producto-image">
              <img src="<?php echo $img;?>" class="big-image" />
            </article>
            <article class="producto-detalle"> 
                <div class="product-details">
                    <div class="short-info-det">
                        <div class="precio-empresa"><b>Precio S/.</b><b class="c-precio"><?php echo $r['precio']; ?></b></div>
                            <div class="product-btns-detalle">
                                <div class="product-big-btns">
                                    <button class="btn-comprar" data-toggle="tooltip" title="Comprar">COMPRAR</button>
                                    <button class="btn btn-wishlist-det" data-toggle="tooltip" title="Agregar a mis deseos"> <i class="fa fa-heart fa-fw"></i> </button>
                                </div>
                            </div>
                            <div class="time" style="padding:8px 0;"><img src="<?php echo $host;?>/images/time.jpg">Finaliza el: <b><?php echo $r['hora_fin'];?></b></div>
                    </div>
                </div>
                <div class="product-details">
                    <div class="short-info-det">                    
                        <div class="name-empresa">
                            <p>Precio Regular</p>
                            <p>Descuento</p>
                            <p>Ahorro</p>
                            <div class="limpia"></div>
                            <p class="p1">S/. <?php echo $r['precio_regular'];?></p>
                            <p class="p2"><?php echo $r['descuento'];?></p>
                            <p class="p3">S/. <?php echo $ahorro;?></p>
                        </div>
                    </div>
                </div>
              <div class="product-details">
                <div class="short-info-det">                   
                      <div class="short-info-opt" style="height: 40px">                           
                          <div style="float:left;" class="fb-like" data-href="http://www.muchosdescuentos.com/peru/producto.php" data-width="50" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
                          <!-- <div  class="fb-like" data-href="http://www.muchosdescuentos.com/peru/producto.html" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div> -->
                          <script src="https://apis.google.com/js/platform.js" async defer>
                            {lang: 'es'}
                          </script>                          
                          <a href="http://www.muchosdescuentos.com/peru/producto.html" class="twitter-share-button"
                            data-dnt="true"
                            data-count="none"
                            data-via="twitterdev">
                          Tweet
                          </a>                          
                          <script type="text/javascript">
                            window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
                          </script>
                          <div class="g-plusone" data-size="medium" data-annotation="none"></div>
                      </div>
                </div>
                <div class="short-info-det" style="padding:5px 13px">
                 <div class="rating"> Califica: 
                   <i class="fa fa-star fa-star-o" style="color:red"></i> 
                   <i class="fa fa-star" style="color:red"></i> 
                   <i class="fa fa-star" style="color:red"></i> 
                   <i class="fa fa-star-half-o" style="color:red"></i> 
                   <i class="fa fa-star-o" style="color:red"></i> 
                 </div>
                </div>
              </div>
              <div class="product-details">
                 
                  <div class="short-info-det"  style="padding:9px 2.5px;color:#000; ">
                    <div style="font-size:11px;">Enviar a un Amigo:</div>
                    <input type="text" name="deseo-descuento" class="input-deseo" placeholder="tucorreo@midominio.com" style="border:1px solid #999;"/>
                    <input type="button" value="Enviar" class="btn-deseo" style="background:#C73B2C !important; color:#fff !important;" />
                  </div>
                  
              </div>

            </article>
            <div class="row clearfix f-space30"></div>
             <!-- Nav tabs -->
            <ul class="nav nav-tabs blog-tabs nav-justified">
              <li class="active"><a href="#detalle-producto" data-toggle="tab">Detalles de la Oferta</a></li>
              <li><a href="#reviews" data-toggle="tab">Local</a></li>
              <li><a href="#tags" data-toggle="tab">Acerca de Shoes Center</a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
               <div class="tab-pane active" id="detalle-producto">
                  <div >
                <!-- detail mobile -->
                <h3 class="tab_title mobile"><span class="logo_section logo_info"></span>TODO SOBRE LA OFERTA</h3>
                <!-- detail mobile -->
                <!--¡Vacaciones en el sur! Disfruta unos días junto a tu pareja en la hermosa ciudad de Ica. Visitar la Laguna de la Huacachina son solo algunas de las cosas que podrás hacer. ¡Escápate con 59% de descuento! <br/><br/>

                              <b>La oferta incluye:</b><br>
                              <b>OPCIÓN 1:</b><br>
                              S/. 199 en vez de S/. 480 por:<br>
                              • 1 Noche en Casasol Hotel (válido de domingo a jueves)<br>
                              • Visita a la laguna de Huacachina<br>
                              • Paseo en tubulares<br>
                              • Traslados hacia los lugares donde se realizan las actividades<br>
                              • Desayunos<br>
                              <br>
                       
                              <b>Descripción:</b><br>
                              <b>Casasol Hotel</b> se encuentra ubicado a 15 minutos del centro de la ciudad, en un lugar campestre rodeado de vegetación y de una piscina para que tú y tu acompañante disfruten al máximo los días de calor. Las habitaciones cuentan con TV con cable, agua caliente y anexo telefónico. Los tours cuentan con traslados desde el hotel hacia la atracción turística (Huacachina), además del retorno al hotel.<br>
                              <br>
                              
                              <b>CONDICIONES COMERCIALES</b>
                              Aqui van todas las condiciones comerciales.<br/>
                              Hola condiciones.<br/>-->
                              <?php echo $r['descripcion'];?><br>
                              
                              <b>CONDICIONES COMERCIALES</b>

                              <?php echo $r['cc'];?>

                      </div>
                 </div>
                  <div class="tab-pane " id="reviews">          
                        <div class="table-responsive">
                          <table class="table table-striped" cellspacing="5" style="font-size:12px">
                              <tr>
                                  <td>
                                    <table>
                                        <tbody valign="top">
                                          <tr>
                                              <td colspan="2">La empresa<br> <strong>Shoes Center</strong><br>
                                                  <p>Es una empresa dedicada a la importacion de marcas posicionadas<br> en el mercado como Puma,etc</p>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>                    
                                                <b>Direccion:</b> <br>
                                                    Av. Alfredo Mendiola 3698 - CC<br>
                                                    Mega Plaza Norte
                                              </td>
                                              <td><b>Horario:</b> <br>
                                                  De lunes a domingo<br> de 10am a 10pm.
                                              </td>
                                          </tr>
                                          <tr>
                                              <td><b>Telefono:</b> <br>
                                                  (01)-000000
                                              </td>
                                              <td><b> Email:</b><br>
                                                  email@midominio.com.pe
                                              </td>
                                          </tr>
                                          <tr>
                                              <td><b>Sitio Web:</b><br>
                                                  http://www.empresa.com.pe
                                              </td>
                                              <td>                                                        
                                              </td>
                                          </tr>
                                         </tbody>
                                    </table>
                                  </td>
                                  <td>
                                    <section id="mapa">
                                          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1982.1129930889124!2d-76.36987206824831!3d-6.493045374463339!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2spe!4v1409630416904" width="400" height="255" frameborder="0" style="border:0">
                                          </iframe>
                                    </section>
                                  </td>
                              </tr>              
                          </table>
                      </div> <!-- fin table responsive -->
                   </div> <!-- fin tab-pane-->
                    <div class="tab-pane" id="tags">
                   
                   </div>
            </div> <!-- fin tab-content -->
            <div class="clearfix f-space30"></div>

            <div id="fb-root"></div>
              <script>(function(d, s, id) 
                {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
              </script>
            <div class="fb-comments" data-href="https://www.facebook.com/andrez.adz" data-width="848" data-numposts="5" data-colorscheme="light">                
            </div>
</section>

</section> <!-- fin  section contenido -->

        <section id="c-especial">
          <article class="producto-especial">
           <div class="box-block sidebar">
              <div class="box-heading"><span>Descuentos Especiales</span></div>
                  <div class="box-content">
                        <div class="box-products slide carousel-fade" id="productc2">
                              <ol class="carousel-indicators">
                                <li class="active" data-slide-to="0" data-target="#productc2"></li>
                                <li class="" data-slide-to="1" data-target="#productc2"></li>
                                <li class="" data-slide-to="2" data-target="#productc2"></li>
                              </ol>
                            <div class="carousel-inner" style="height:380px"> 
            <!-- item -->
                                  <div class="item active">
                                        <div class="product-block">
                                            <div class="image">
                                                <div class="product-label product-sale"><span>-30%</span></div>
                                                      <a class="img" href="producto.html"><img alt="product info" src="<?php echo $host;?>/images/products/product1.jpg" title="product title"></a>
                                                </div>
                                                <div class="product-meta">
                                                      <div class="name">
                                                            <a href="<?php echo $host;?>/producto.php">
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
                                                <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="">Ver</a></div> 
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
                <a class="img" href="producto.html"><img alt="product info" src="<?php echo $host;?>/images/products/product1.jpg" title="product title"></a> </div>
                <div class="product-meta">
                  <div class="name">
                  <a href="<?php echo $host;?>/producto.php">
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
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="">Ver</a></div>
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
                <a class="img" href="<?php echo $host;?>/producto.php"><img alt="product info" src="<?php echo $host;?>/images/products/product1.jpg" title="product title"></a> </div>
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
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="">Comrpar</a></div>
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
           <div class="row clearfix f-space30"></div>
           <div class="product-block">
            <div class="image">
              <div class="product-label product-sale"><span>-30%</span></div>
              <a class="img" href="<?php echo $host;?>/producto.php"><img alt="product info" src="<?php echo $host;?>/images/products/product1.jpg" title="product title"></a> </div>
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
              <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="">Comprar</a></div>

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
                <button class="btn btn-default btn-compare pull-left" title="View">Ver <b>></b></button>
              </div>

            </div>
            <div class="meta-back"></div>
          </div> 
         <div class="row clearfix f-space30"></div>
         <div class="product-block">
            <div class="image">
              <div class="product-label product-sale"><span>-30%</span></div>
              <a class="img" href="<?php echo $host;?>/producto.php"><img alt="product info" src="<?php echo $host;?>/images/products/product1.jpg" title="product title"></a> </div>
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
              <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="">Ver</a></div>

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
                <button class="btn btn-default btn-compare pull-left" title="View">Ver <b>></b></button>
              </div>
            </div>
            <div class="meta-back"></div>
          </div> 
        </article>
     </section>
  </div>
  <!-- fin c-especial -->

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
        <ul >
            <li ><a href="#" style="color:#333 !important;">Preguntas Frecuentes.</a></li>
            <li><a href="#" style="color:#333 !important;">Acerca del Pago en Efectivo.</a></li>
            <li><a href="#" style="color:#333 !important;">Libro de Reclamaciones.</a></li>
            <li><a href="#" style="color:#333 !important;">Pol&iacute;ticas y Privacidad.</a></li>
            <li><a href="#" style="color:#333 !important;">Mapa del sitio.</a></li>            
        </ul>        
      </div>
      <div class="col-sm-3 col-xs-12 shopinfo">
        <h4 class="title">EMPRESAS</h4>
        <ul>
            <li><a href="#" style="color:#333 !important;">Empresa 1</a></li>
            <li><a href="#" style="color:#333 !important;">Empresa 2</a></li>
            <li><a href="#" style="color:#333 !important;">Empresa 3</a></li>
            <li><a href="#" style="color:#333 !important;">Empresa 4</a></li>
            <li><a href="#" style="color:#333 !important;">Empresa 5</a></li>                        
        </ul>
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

<script src="<?php echo $host;?>/js/jquery.elevatezoom.js" type="text/javascript"></script> 
<script>

(function($) {
  "use strict";
  //Mega Menu
 $('#menuMega').menu3d();
             
              //Help/Contact Number/Quick Message
      $('.quickbox').carousel({
        interval: 10000
      });
      
      //SPECIALS
      $('#productc2').carousel({
        interval: 4000
      }); 
      //RELATED PRODUCTS
      $('#productc3').carousel({
        interval: 4000
      }); 
      
      //Zoom Product
      $("#product-image").elevateZoom({
                          zoomType : "inner",
                          cursor : "crosshair",
                          easing: true,
                           gallery: "thumbs",
                           galleryActiveClass: "active",
                          loadingIcon : true
                        }); 
      $("#product-image").bind("click", function(e) {  
  var ez =   $('#product-image').data('elevateZoom');
  ez.closeAll(); //NEW: This function force hides the lens, tint and window 
  //$.fancybox(ez.getGalleryList());     
  return false;
});
})(jQuery);

 </script>
</body>
</html>