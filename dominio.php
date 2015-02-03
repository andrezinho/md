<?php 
session_start();
require_once '/app/start.php'; //Start para facebook -> ;)
require_once '/app/funciones.php';
$db = Spdo::singleton();

$idd=$_GET["id"]; 

$stmt = $db->prepare("SELECT p.idpublicaciones,
                              p.titulo1, 
                              p.titulo2, 
                              p.descripcion as desc_publi,
                              c.descripcion as categoria,
                              p.precio,
                              p.precio_regular, 
                              p.imagen,
                              p.fecha_inicio,
                              p.fecha_fin,
                              p.hora_inicio,
                              p.hora_fin,
                              p.descuento,
                              e.idempresa,
                              e.razon_social as empresa,
                              e.logo,
                              e.facebook,
                              e.twitter,
                              e.dominio,
                              e.youtube,
                              e.razon_comercial,
                              p.cc,
                              e.website,
                              e.nombre_contacto, 
                              l.idubigeo,
                              l.descripcion as local,
                              l.direccion,
                              l.referencia,
                              l.telefono1,
                              l.telefono2,
                              l.horario,
                              l.mapa_google,
                              l.latitud,
                              l.longitud,
                              u.descripcion as ubigeo
                      FROM publicaciones as p
                              INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                              INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                              INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion
                              INNER JOIN local as l on l.idlocal=su.idlocal
                              INNER JOIN empresa as e on e.idempresa=l.idempresa
                              INNER JOIN ubigeo as u on u.idubigeo=l.idubigeo 
                       WHERE dominio=:id and l.idubigeo='".$_SESSION['idciudad']."'");

$stmt->bindValue(':id', $idd , PDO::PARAM_STR);
$stmt->execute();
$r = $stmt->fetch();
$idempresa = $r['idempresa'];
$ahorro=$r['precio_regular']-$r['precio'];
$img=$host."/panel/web/imagenes/".$r['imagen'].".jpg";

if($r['logo']!=""){$logo=$host."/panel/web/imagenes/logos/".$r['logo'];}
else{$logo=$host."/images/nologo.png";}
     
$st = $db->prepare("SELECT p.* 
                      FROM publicaciones as p 
                           inner join suscripcion as s on s.idsuscripcion = p.idsuscripcion
                           inner join local as l on l.idlocal = s.idlocal
                      WHERE p.estado<>0 and p.tipo=1 and l.idubigeo = '".$_SESSION['idciudad']."'
                      ORDER BY idpublicaciones desc limit 3");
$st->execute();
$lista= $st->rowCount();

$st = $db->prepare("SELECT * FROM categoria ORDER BY orden asc");
$st->execute();

?>
<!DOCTYPE html>
<html class="noIE" lang="es">
<head>

<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="Viewport">
<meta name="description" content="<?php echo $idd;?>">
<meta name="keywords" content="<?php echo $r['titulo2'];?>" />
<meta name="news_keywords" content="<?php echo $r['titulo2'];?>"/>
<meta name="robots"     content="index,follow"/>
<meta name='googlebot'    content='index, follow' />
<meta name="organization"   content="Muchos Descuentos" />
<meta property="og:url"   content="http://www.muchosdescuentos.com/producto/<?php echo $url; ?>" />
<meta name="og:image"     content="<?php echo $img;?>" />
<meta name="og:title"     content="<?php echo $r['titulo1'];?>" />
<meta name="robots"     content="index, follow" />
<meta name="author"     content="Muchos Descuentos" />
<meta name='Origen'     content='Muchos Descuentos' />
<meta name="locality"     content="Lima, Peru" />


<link rel="shortcut icon" type="image/x-icon" href="<?php echo $host; ?>/favicon.ico">
<title><?php echo $idd;?></title>

<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>

<link href="<?php echo $host; ?>/css/bootstrap.css" rel="stylesheet" />
<link href="<?php echo $host; ?>/css/iView.css" rel="stylesheet">
<link href="<?php echo $host; ?>/css/micss.css" rel="stylesheet"/>

<link href="<?php echo $host; ?>/css/suscripcion.css" rel="stylesheet"/>

<link type="text/css" href="<?php echo $host; ?>/css/jquery-ui.min.css" rel="stylesheet" />
<link type="text/css" href="<?php echo $host; ?>/css/jquery-ui.structure.min.css" rel="stylesheet" />
<link type="text/css" href="<?php echo $host; ?>/css/jquery-ui.theme.min.css" rel="stylesheet" />
<!-- Animations -->
<!-- Custom styles for this template -->
<link href="<?php echo $host; ?>/css/custom.css" rel="stylesheet" type="text/css" />
<!-- Style Switcher -->
<link href="<?php echo $host; ?>/css/style-switch.css" rel="stylesheet" type="text/css"/>
<!-- Color -->
<link href="<?php echo $host; ?>/css/skin/color.css" id="colorstyle" rel="stylesheet">
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]> <script src="js/html5shiv.js"></script> <script src="js/respond.min.js"></script> <![endif]-->
<!-- Bootstrap core JavaScript -->

<script type="text/javascript" src="<?php echo $host; ?>/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo $host; ?>/js/jquery-ui-1.10.3.custom.min.js"></script>    
<script src="<?php echo $host; ?>/js/bootstrap.min.js"></script>

<!-- iView Slider -->
<script src="<?php echo $host; ?>/js/raphael-min.js" type="text/javascript"></script>
<script src="<?php echo $host; ?>/js/jquery.easing.js" type="text/javascript"></script>
<script src="<?php echo $host; ?>/js/iView.js" type="text/javascript"></script>
<script src="<?php echo $host; ?>/js/retina-1.1.0.min.js" type="text/javascript"></script>
<script>
  !window.jQuery && document.write("<script src='<?php echo $host; ?>/js/jquery.min.js'><\/script>")
</script>
<!--[if IE 8]>
    <script type="text/javascript" src="<?php echo $host; ?>/js/selectivizr.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo $host; ?>/js/utilitarios.js"></script>
<script type="text/javascript" src="<?php echo $host; ?>/js/mijs/js.js"></script>
<script type="text/javascript" src="<?php echo $host; ?>/js/mijs/publicaciones.js"></script>
</head>
<body>
	<div id="frm-suscripcion"></div>
<header>   
  <div class="c-top" style="background: #EEEEEE; padding: 5px 0 0 0; margin-top: -8px; box-shadow: 3px 2px 5px #ccc;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="topheadrow">
            <a href="<?php echo $host;?>"><img src="<?php echo $host;?>/images/logo-icon.png" class="logo-icon" style="width:43px;height:43px; margin-top: 2px;" /></a>
            <ul class="nav nav-pills pull-right">          
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" data-hoView="dropdown" href="#a">Tef: (01)33333) <i class="fa fa-angle-down fa-fw"></i> </a>
            </li>
            <li> <a href="<?php echo $host; ?>/deseos"> <i class="fa fa-heart fa-fw"></i> <span class="hidden-xs">Mis Deseos</span></a> </li>            
            <?php echo login($helper,$config); ?>
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
            <div class="product-details-head" style="float:left; width:590px; ">
                <div class="short-info-det-name-empresa">                    
                  <div class="name-empresa" >
                    <img src="<?php echo $logo;?>" class="logo-empresa">  
                    <b><?php echo strtoupper($r['empresa']);?></b>
                  </div>
                <div class="frase-empresa"><?php //echo frase ?></div>
                </div>
            </div>
            <!-- <div style="width:auto; float:left; border-right: 1px solid #fafafa;">                                
                <div style="padding:10px 10px"> 
            -->

                <?php 
                  $stmt = $db->prepare("SELECT l.*,u.descripcion as ubigeo
                                        FROM local as l 
                                        inner join ubigeo as u on u.idubigeo=l.idubigeo
                                        WHERE l.idempresa=:ide");
                  $stmt->bindValue(':ide', $r['idempresa'] , PDO::PARAM_INT);
                  $stmt->execute();
                  $u=$stmt->fetch();

                ?>
                <!--
                    <select class="web-list list-local" style="max-width:140px;">
                    <?php 
                      foreach($stmt->fetchAll() as $x)
                      { 
                    ?> 
                      <option value="<?php echo $x['idubigeo'];?>"><?php echo $x['descripcion'];?></option>                    
                    <?php 
                      }
                    ?>                    
                    </select>
                -->
               <!-- </div>
            </div>  -->                    
            <div class="searchbar" style="float:right; width:auto; margin-right: 7px; padding-left:7px;">                        
                <div class="social-icons" style="">                    
                      <ul > 
                        <?php if($r["youtube"]!="")
                            {
                             echo '<li class="icon youtube" ><a href="'.$r["youtube"].'" target="_blank" style="background:#DC2310"><i class="fa fa-youtube fa-fw"></i></a></li>';                  
                            }

                             if($r["twitter"]!=""){
                               echo '<li class="icon twitter"><a href="'.$r["twitter"].'" target="_blank" style="background:#33BCE9"><i class="fa fa-twitter fa-fw"></i></a></li>';
                             }
                             
                             if($r["facebook"]!=""){
                               echo '<li class="icon facebook"><a href="'.$r["facebook"].'" target="_blank" style="background:#37528D"><i class="fa fa-facebook fa-fw"></i></a></li>';
                             }
                             ?>
                      </ul>
                </div>
            </div>
            <div style="width:auto; float:right; border-right: 1px solid #fafafa; padding:0 10px 0 0 ">                                
                <div style="padding:5px 0px 5px 0px">
                    <div>
                        <input id="recibir_ofertas" type="button" value="Suscribirse" class="btn-deseo" style="background:#C73B2C !important; color:#fff !important; width:auto;" title="Recibir Ofertas de esta Empresa" /> 
                    </div>
                </div>
            </div>
            <div style="width:auto; float:right; border-right: 0">
                <div style="padding:5px 0px 5px 0px">
                    <div>
                        <input type="hidden" name="iemp" id="idemp" value="<?php echo $idempresa; ?>" />                        
                    </div>                    
                </div>
            </div>
            <div style="width:auto; float:right; border-right: 1px solid #fafafa; border-right: 0;">                                
                <div style="padding:5px 0px 5px 5px">
                    <div style="height: 40px; padding: 13px 0 0">
                        <a href="#" style="color:#333;" data-toggle="tooltip"  title="Recibir Descuentos de esta Empresa"><i class="fa fa-envelope fa-fw" style="color:#333"></i>&nbsp;</a>                        
                    </div>                                      
                </div>
            </div>            
      </div>
        <div id="buscador" class="product-details-head">
           <div class="searchbar-details">
              <form action="<?php echo $host?>/resultados.php" method="get">
                  <input name="search" class="searchinput" id="search" placeholder="Buscar..." type="search"  />
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
<div class="f-space10"></div>
<div class="my-container">
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-heading" ><span>Datos de <?php echo $r["dominio"];?></span></div>
        <table border="0" width="100%">
        <tr>
        <td width="60%" valign="top">
        <p>
        Somos una empresa con 20 años de experiencia, brindando un servicio de calidad
        para ud. y su familia.

        </p>
        <span><b>Nombre Contacto:</b><?php echo $r["nombre_contacto"]; ?></span><br>
        <span><b>Direccion:</b><?php echo $r["direccion"]." - ".$r["ubigeo"]." - ".$r["local"]; ?></span><br>
        <span><b>Referencia:</b><?php echo $r["referencia"]; ?></span><br>
        <span><b>Telefonos:</b><?php echo $r["telefono1"]." - ".$r["telefono2"]; ?></span><br>
        <span><b>Horario Atenci&oacute;n:</b><?php echo $r["horario"]; ?></span><br>
        <span><b>Web:</b><a href="<?php echo $r["website"];?>" target="_blank" style="color:blue"><?php echo $r["website"];?></a></span>
        </td>
        <td width="40%" valign="top"><b>Ubicaci&oacute;n</b>
          <section id="mapa">
                                                                            
            <iframe width="425" height="150" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://localhost/md/mapa.php?latitud=<?php echo $r['latitud']; ?>&amp;longitud=<?php echo $r['longitud'] ?>">
            </iframe>                                    
          </section>
        </td>
        </tr>
        </table>
    </div>
</div>
</div>
<div class="f-space10"></div>      



<div class="container">
  <div class="row" id="category">
    <div class="col-lg-12 col-md-12 main-column box-block">
      <?php 
      
        while($c=$st->fetch()){
        
         echo' <div class="box-heading"><span>Descuentos de '.$c['descripcion'].'</span><span class="view-all">
         <a href="descuentos/'.urls_amigables($c['descripcion']).'">[Ver Todos]</a></span></div>';
         
         if(!isset($_SESSION['idusuario']))
         {
           $sql_q = "SELECT p.idpublicaciones,p.idtipo_descuento,p.titulo1, p.titulo2, 
                            p.descripcion as desc_publi,e.dominio,c.idcategoria,
                            c.descripcion as categoria,p.precio,p.precio_regular, p.imagen,
                            p.fecha_inicio,p.fecha_fin,p.hora_inicio,p.hora_fin,p.descuento,
                            e.idempresa,e.razon_social as empresa,e.logo,e.facebook,e.twitter,e.youtube,e.razon_comercial,p.cc,e.website,e.nombre_contacto, 
                            l.idubigeo,l.descripcion,l.direccion,l.referencia,l.telefono1,l.telefono2,l.horario,l.mapa_google,l.latitud,
                            l.longitud,0 as deseo
                        FROM publicaciones as p
                                INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                                INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                                INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion
                                INNER JOIN local as l on l.idlocal=su.idlocal
                                INNER JOIN empresa as e on e.idempresa=l.idempresa 
                         WHERE dominio=:d and c.idcategoria=:idc and l.idubigeo='".$_SESSION['idciudad']."' 
                            and p.fecha_fin >= CURDATE()
                         order by idpublicaciones desc limit 8";
          }
         else
         {
            $sql_q = "SELECT  p.idpublicaciones,p.idtipo_descuento,p.titulo1, p.titulo2, 
                              p.descripcion as desc_publi,e.dominio,c.idcategoria,
                              c.descripcion as categoria,p.precio,p.precio_regular, p.imagen,
                              p.fecha_inicio,p.fecha_fin,p.hora_inicio,p.hora_fin,p.descuento,e.idempresa,e.razon_social as empresa,e.logo,e.facebook,
                              e.twitter,e.youtube,e.razon_comercial,p.cc,e.website,e.nombre_contacto, l.idubigeo,l.descripcion,l.direccion,l.referencia,l.telefono1,l.telefono2,l.horario,l.mapa_google,
                              l.latitud,l.longitud,coalesce(d.idpublicaciones,0) as deseo
                        FROM publicaciones as p
                                INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                                INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                                INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion
                                INNER JOIN local as l on l.idlocal=su.idlocal
                                INNER JOIN empresa as e on e.idempresa=l.idempresa 
                                left outer join deseos as d on d.idpublicaciones = p.idpublicaciones and d.idusuario = ".$_SESSION['idusuario']."
                         WHERE dominio=:d and c.idcategoria=:idc and l.idubigeo='".$_SESSION['idciudad']."' 
                            and p.fecha_fin >= CURDATE()
                         order by idpublicaciones desc limit 8";
         }
         
         $pub = $db->prepare($sql_q);
         $pub->bindValue(':idc', $c['idcategoria'] , PDO::PARAM_INT);
         $pub->bindValue(':d', $idd , PDO::PARAM_STR);
         $pub->execute();
         $nl= $pub->rowCount();
      

    ?> 
      <div class="box-content">
        <div class="box-products slide" id="productc3">
          <div class="carousel-inner"> 
            <!-- Items Row -->
            <div class="item active">
              <div class="row box-product"> 
                 <?php  
                    while($p=$pub->fetch())
                    {

                      $o = oferta($p);
                      echo $o;
                    }
                  

                 ?>                
              </div>
            </div>
          </div>
        </div>
        </div>
      <?php } ?>

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

      //SPECIALS
      $('#productc2').carousel({
        interval: 4000
      }); 
      //RELATED PRODUCTS
      $('#productc3').carousel({
        interval: 4000
      }); 
      
      
})(jQuery);

 </script>
</body>
</html>
</body>