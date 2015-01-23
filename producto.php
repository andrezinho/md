<?php
session_start();
require_once '/app/start.php'; //Start para facebook -> ;)
require_once '/app/funciones.php';

$db = Spdo::singleton();
$url=$_GET["id"];
$id=explode("-",$url);
$n=count($id);

$titulo="";
for($s=0; $s<($n-1); $s++) 
{
  $titulo .=$id[$s]." ";
}
$id=$id[$n-1];
$stmt = $db->prepare("SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion as desc_publi,
                             c.descripcion as categoria,p.precio,p.precio_regular, p.imagen,
                             p.fecha_inicio,p.fecha_fin,p.hora_inicio,p.hora_fin,p.descuento,
                             e.idempresa,e.razon_social as empresa,e.logo,e.facebook,e.twitter,e.dominio,
                             e.youtube,e.razon_comercial,p.cc,
                             e.website,e.nombre_contacto, l.idubigeo,l.descripcion,
                             l.direccion,l.referencia,l.telefono1,l.telefono2,l.horario,
                             l.mapa_google,l.latitud,l.longitud
                      FROM publicaciones as p
                              INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                              INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                              INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion
                              INNER JOIN local as l on l.idlocal=su.idlocal
                              INNER JOIN empresa as e on e.idempresa=l.idempresa 
                       WHERE idpublicaciones=:id and l.idubigeo='".$_SESSION['idciudad']."'");

$stmt->bindValue(':id', $id , PDO::PARAM_STR);
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
?>


<!DOCTYPE html>
<html class="noIE" lang="es">
<head>

<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="Viewport">
<meta name="description" content="<?php echo $r['titulo2'];?>">
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
<title><?php echo $titulo;?></title>

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

<!-- timer -->
<script type="text/javascript" src="<?php echo $host; ?>/js/countdown.js"></script>
<script type="text/javascript" src="<?php echo $host; ?>/js/jquery.countdown.js"></script>
<script type="text/javascript">
  var host=window.location.host;
  host=host+"/md";
  //host=host;
  $(document).ready(function(){
    
    $("#sendf").click(function(){
      var mail=$("#enviar_mail").val();
      var idp=$("#idp").val();//alert(idp);
      if(mail!="")
      {
        
        if($("#enviar_mail").val().indexOf('@', 0) == -1 || $("#enviar_mail").val().indexOf('.', 0) == -1)
        {$(".ms").empty().html("<span style='color:red;'>Email no es correcto.</span>");}
        
        else
        { 

           $.post('http://'+host+'/model/mail_amigo.php',"mail="+mail+"&idp="+idp,function(datos){
            
              if(datos.res==2){$(".ms").empty().html("<span style='color:red;'>"+datos.msg+"</span>");}
            
              else{
                //$(".ms").css({display:"none"});
                $(".ms").empty().html("<span style='color:red;'>"+datos.msg+"</span>");
            
                }
            },'json');
          } 
       }
      else{$(".ms").empty().html("<span style='color:red;'>Ingrese su email</span>");}
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
<div class="row clearfix f-space20"></div>
<div class="container">
    <div class="row">        
        <section id="contenido">
              <div class="box-heading"><span><?php echo utf8_encode(strtoupper($r['titulo2']));?></span></div>  
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
                                <?php 
                                 $fc=$host."/".$r['dominio']."/fichacompra/".urls_amigables($r['titulo1']."-".$r['idpublicaciones']);
                                 ?>
                                    <a href="<?php echo $fc;?>" id="comprar" class="btn-comprar" data-toggle="tooltip" title="Comprar" style="width:100%; padding:15px 0 0 0">COMPRAR</a>                                    
                                </div>
                            </div>
                            <div class="time" style="padding:8px 0;"><img src="<?php echo $host;?>/images/time.jpg">Finaliza en: 
                            <input type="hidden" name="idp" id="idp" value="<?php echo $r['idpublicaciones'];?>">
                            <div id="note"></div>

                            </div>
                    </div>
                </div>
                <div class="product-details">
                    <div class="short-info-det">                    
                        <div class="name-empresa">
                            <p>Precio Regular</p>
                            <p>Descuento</p>
                            <p>Ahorro</p>
                            <div class="limpia"></div>
                            <p class="p1" style="font-size:15px">S/. <?php echo $r['precio_regular'];?></p>
                            <p class="p2" style="font-size:15px"><?php echo $r['descuento'];?></p>
                            <p class="p3" style="font-size:15px">S/. <?php echo $ahorro;?></p>
                        </div>
                    </div>
                </div>
              <div class="product-details">
                <div class="short-info-det" style="padding:15px 0px">                   
                      <div class="short-info-opt" style="height: 0px">                           
                          <div style="float:left;" class="fb-like" data-href="http://www.muchosdescuentos.com/producto/<?php echo $url;?>" data-width="50" data-layout="button" data-action="like" data-show-faces="false"></div>
                          
                          <div style="float:left;margin-left:1px;" class="fb-share-button" data-href="http://www.muchosdescuentos.com/producto/<?php echo $url;?>" data-layout="button"></div>



                          <!-- <div  class="fb-like" data-href="http://www.muchosdescuentos.com/peru/producto.html" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div> -->
                          <script src="https://apis.google.com/js/platform.js" async defer>
                            {lang: 'es'}
                          </script>                          
                          <a href="http://www.muchosdescuentos.com/producto/<?php echo $url;?>" class="twitter-share-button"
                            data-dnt="true"
                            data-count="none">
                          Tweet
                          </a>                          
                          <script type="text/javascript">
                            window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
                          </script>
                          <div class="g-plusone" data-size="medium" data-annotation="none"></div>
                      </div>
                </div>
                <div class="short-info-det" >
                 <!-- <div class="rating"> Califica: 
                   <i class="fa fa-star fa-star-o" style="color:red"></i> 
                   <i class="fa fa-star" style="color:red"></i> 
                   <i class="fa fa-star" style="color:red"></i> 
                   <i class="fa fa-star-half-o" style="color:red"></i> 
                   <i class="fa fa-star-o" style="color:red"></i> 
                 </div> -->
                </div>
              </div>              
              <div class="product-details">
                  <div class="short-info-det"  style="padding:9px 2.5px;color:#000; ">
                    <div style="font-size:11px;">Enviar a un Amigo:</div>
                    <input type="text" id="enviar_mail" name="deseo-descuento" class="input-deseo" placeholder="tucorreo@midominio.com" style="border:1px solid #999;"/>
                    <input type="button" value="Enviar" id="sendf" class="btn-deseo" style="background:#C73B2C !important; color:#fff !important;" />
                    <p class="ms"></p>
                  </div>
              </div>
            </article>
            <div class="row clearfix f-space30"></div>
             <!-- Nav tabs -->
            <ul class="nav nav-tabs blog-tabs nav-justified">
              <li class="active"><a href="#detalle-producto" data-toggle="tab">Detalles de la Oferta</a></li>
              <li><a href="#tags" data-toggle="tab">Condiciones Comerciales</a> </li>
              <li><a href="#reviews" data-toggle="tab">Local</a></li>
              
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
               <div class="tab-pane active" id="detalle-producto">
                  <div >
                <!-- detail mobile -->
                <h3 class="tab_title mobile">
                    <span class="logo_section logo_info"></span>
                    TODO SOBRE LA OFERTA
                </h3>
                <!-- detail mobile -->
              
                              <?php echo utf8_encode($r['desc_publi']);?><br>
                              
                              

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
                                              <td colspan="2">La empresa<br> <strong><?php echo $r['empresa'];?></strong><br>
                                                  <p><?php echo $r['razon_comercial'];?></p>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>                    
                                                <b>Direccion:</b> <br>
                                                    <?php echo $r['direccion']."<br>";
                                                          echo $u['ubigeo'];
                                                     ?>
                                                    
                                              </td>
                                              <td><b>Horario:</b> <br>
                                                  <!-- De lunes a domingo<br> de 10am a 10pm.-->
                                                  <?php echo $r['horario']; ?>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td><b>Telefonos:</b> <br>
                                                  <?php echo $r['telefono1']."<br>";
                                                        echo $r['telefono2'];
                                                  ?>
                                              </td>
                                              <td><b> Email:</b><br>
                                                 <?php echo $u['email'];?>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td><b>Sitio Web:</b><br>
                                                  <?php echo $u['pagina_web'];?>
                                              </td>
                                              <td>                                                        
                                              </td>
                                          </tr>
                                         </tbody>
                                    </table>
                                  </td>

                                  <td>
                                    
                                    <section id="mapa">
                                                                            
                                      <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://localhost/md/mapa.php?latitud=<?php echo $r['latitud']; ?>&amp;longitud=<?php echo $r['longitud'] ?>">
                                      </iframe>                                    

                                    </section>
                                  </td>
                              </tr>              
                          </table>
                      </div> <!-- fin table responsive -->
                   </div> <!-- fin tab-pane-->
                    <div class="tab-pane" id="tags">
                    <h3>CONDICIONES COMERCIALES</h3>

                              <?php echo utf8_encode($r['cc']);?>
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
                                <?php for ($i=0; $i<$lista ; $i++){ 
                                        if ($i==0) {$activo="active";}
                                        else{$activo="";}
                                        echo '<li class="'.$activo.'" data-slide-to="'.$i.'" data-target="#productc2"></li>';
                                }?>
                              </ol>
                            <div class="carousel-inner" id="items2" style="height:380px"> 
                                
                                <!-- Productos Especiales -->
                  
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
           
           <?php 
           
           $pub = $db->prepare("SELECT p.idpublicaciones,p.idtipo_descuento,p.titulo1, p.titulo2, p.descripcion as desc_publi,
                             c.idcategoria,c.descripcion as categoria,p.precio,p.precio_regular, p.imagen,p.fecha_inicio,
                             p.fecha_fin,p.hora_inicio,p.hora_fin,p.descuento,e.idempresa,e.razon_social as empresa,e.logo,e.facebook,e.twitter,e.youtube,e.razon_comercial,e.dominio,p.cc,
                             e.website,e.nombre_contacto, l.idubigeo,l.descripcion,
                             l.direccion,l.referencia,l.telefono1,l.telefono2,l.horario,
                             l.mapa_google,l.latitud,l.longitud
                      FROM publicaciones as p
                              INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                              INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                              INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion
                              INNER JOIN local as l on l.idlocal=su.idlocal
                              INNER JOIN empresa as e on e.idempresa=l.idempresa 
                       WHERE l.idlocal=:idl and p.tipo<>1 order by idpublicaciones desc limit 3");
         $pub->bindValue(':idl', $u['idlocal'] , PDO::PARAM_INT);
         $pub->execute();
           while($p=$pub->fetch()){
           ?>
           <div class="product-block">
            <div class="image">

            <?php if($p['idtipo_descuento']!=1){?>
                <div class="product-label product-sale"><span><?php echo $p['descuento']?></span></div>
            <?php } else{ ?>
            <div class="product-label product-sale"><span><?php echo $p['descuento']?></span></div>
            <?php } ?>
              


              <a class="img" href="<?php echo $host;?>/producto/<?php echo urls_amigables($p['titulo1']."-".$p['idpublicaciones']);?>"><img alt="product info" src="<?php echo $host;?>/panel/web/imagenes/home/small_<?php echo $p['imagen']?>.jpg" title="<?php echo utf8_encode($p['titulo1']);?>"></a> </div>
            <div class="product-meta">
              <div class="name">
                <a href="<?php echo $host;?>/producto/<?php echo urls_amigables($p['titulo1']."-".$p['idpublicaciones']);?>">
                <?php echo utf8_encode($p['titulo1']); ?>
                </a>
              </div>

              <div class="big-price"> 
                <span class="price-new">
                  <span class="sym">S/.</span>
                   <?php echo $p['precio'] ?>
                  </span> 
                <span class="price-old">
                  <span class="sym">S/.</span>
                    <?php echo $p['precio_regular'] ?>
                  </span> 
              </div>
              <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="<?php echo $host."/".$p['dominio']."/";?>/fichacompra/<?php echo urls_amigables($p['titulo1']."-".$p['idpublicaciones']);?>">Comprar</a></div>

              <div class="small-price">
                <span class="price-new">
                  <span class="sym">S/.</span>
                  <?php echo $p['precio'] ?>
                </span> 
                <span class="price-old">
                  <span class="sym">S/.</span>
                  <?php echo $p['precio_regular'] ?>
                </span>
              </div>
              <!--
              <div class="rating"> 
                <i class="fa fa-star"></i> 
                <i class="fa fa-star"></i> 
                <i class="fa fa-star"></i> 
                <i class="fa fa-star-half-o"></i> 
                <i class="fa fa-star-o"></i> 
              </div>
              -->
              <div class="small-btns">
                <button class="btn btn-default btn-wishlist pull-left" title="">
                 <i class="fa fa-heart fa-fw"></i> 
                </button>
                <button class="btn btn-default btn-compare pull-left" title="View"><a href="<?php echo $host;?>/producto/<?php echo urls_amigables($p['titulo1']."-".$p['idpublicaciones']);?>">Ver</a> <b>></b></button>
              </div>

            </div>
            <div class="meta-back"></div>
          </div> 
         <div class="row clearfix f-space30"></div>   
           <?php } ?>
    
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