<?php
require_once 'head.php';
$stmt = $db->prepare("SELECT p.*,e.dominio 
                      FROM publicaciones as p 
                           inner join suscripcion as s on s.idsuscripcion = p.idsuscripcion
                           inner join local as l on l.idlocal = s.idlocal
                           INNER JOIN empresa as e on e.idempresa=l.idempresa
                      WHERE p.estado<>0 and p.tipo=1 and l.idubigeo = '".$_SESSION['idciudad']."'
                          and p.fecha_fin >= CURDATE()
                      ORDER BY idpublicaciones desc limit 3");
$stmt->execute();
$lista= $stmt->rowCount();

$st = $db->prepare("SELECT * FROM categoria ORDER BY orden asc");
$st->execute();

?>
<body>
<div id="frm-suscripcion"></div>

<header>   
    
  <!-- Barra Top y Logo -->
  <div class="c-top" style="background: #EEEEEE; padding: 5px 0 0 0; margin-top: -8px; box-shadow: 3px 2px 5px #ccc;">  
  <div class="my-container">
    <div>
      <div>
        <div class="topheadrow">        
          <div>            
             <div class="logoimage"><img src="images/logo.png" /></div>             
          </div>

          <ul class="nav nav-pills pull-right">            
            <li class="dropdown" style="padding:10px 10px 6px;">Descuentos en
              <select id="ciudades" name="ciudades" class="web-list list-local" style="max-width:200px;border:0;">
                <?php                   
                  $sql = "SELECT c.idciudad,concat(u.descripcion,' ',coalesce(c.zona,'')) from ciudad as c inner join ubigeo as u on c.idciudad = u.idubigeo where c.estado = 1 order by c.cod ";
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
  <!-- Fin de Barra Top y Logo -->
  
  <!-- Buscador y Barra de Redes Sociales -->
  <div class="my-container" style="height: 60px; "> 
      <div style="padding: 4px 0 0 0; width:100%">
          <div class="searchbar" style="float:right; width:175px;">
            <div class="social-icons">
                <ul>
                  <li class="icon google-plus"><a href="#a"><i class="fa fa-google-plus fa-fw"></i></a></li>
                  <li class="icon linkedin"><a href="#a"><i class="fa fa-linkedin fa-fw"></i></a></li>
                  <li class="icon twitter"><a href="#a"><i class="fa fa-twitter fa-fw"></i></a></li>
                  <li class="icon facebook"><a href="https://www.facebook.com/MuchosDescuentos?fref=ts" target="_BLANK"><i class="fa fa-facebook fa-fw"></i></a></li>
                </ul>
            </div>  
        </div>
        <div class="searchbar" style="float:right; width:220px;">
          <form action="resultados.php" method="get">                  
            <div style="background: red; float: left; ">
              <input class="searchinput" name="search" id="search" placeholder="Buscar..." type="search" style="height: 40px;">
            </div>
            <div class="searchbox">
              <button class="fa fa-search fa-fw" type="submit"></button>
            </div>          
          </form>          
        </div>
        
      </div>
 </div>
  <!-- Fin de Buscador y Barra de Redes Sociales -->
  
  <!-- Menu -->
  <div class="my-container">
    <div  id="posicion">
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
  <!-- Fin de Menu -->
  
</header>
<!-- end: Header --> 
<!-- Products -->

    <?php
      $stmt = $db->prepare("SELECT p.*,e.dominio
                      FROM publicaciones as p 
                           inner join suscripcion as s on s.idsuscripcion = p.idsuscripcion
                           inner join local as l on l.idlocal = s.idlocal
                           INNER JOIN empresa as e on e.idempresa=l.idempresa
                      WHERE p.estado<>0 and p.tipo=1 and l.idubigeo = '".$_SESSION['idciudad']."'
                            and p.fecha_fin >= CURDATE()
                      ORDER BY idpublicaciones desc limit 3");
        //$stmt->bindValue(':p1', $_SESSION['id_perfil'] , PDO::PARAM_INT);
        $stmt->execute();
        $i= $stmt->rowCount();
        if($i>0){$a="9";}
        else{$a="12";}
    ?>

<div class="f-space10"></div>
<div class="my-container">
  <div class="row" >

  
    <div class="col-lg-<?php $a;?> col-md-9 col-sm-12 col-xs-12 main-column box-block" >
  
        <div class="box-heading" ><span>Descuentos Recientes</span><span class="view-all"><a href="descuentos/">[Ver Todos]</a></span></div>
        <div class="box-content">
        <div class="box-products" >          
          <div> 
            <!-- Items Row -->
            <div>
              <div class="row box-product" id="publicacion"> 
                  <!-- PUBLICACION  -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if($i>0){?>
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 box-block sidebar">
        <div class="box-heading" style="margin-bottom: 2px"><span>% Especiales</span><span class="view-all"><a href="descuentos/especiales" style="font-size:10px">[Ver Todos]</a></span></div>
        <div class="box-content" >
            <div class="box-products slide carousel-fade" id="productc2">
                  <ol class="carousel-indicators">          
                      <?php for ($i=0; $i<$lista ; $i++){ 
                        if ($i==0) {$activo="active";}
                        else{$activo="";}
                        echo '<li class="'.$activo.'" data-slide-to="'.$i.'" data-target="#productc2"></li>';
                      }?>
                  </ol>
              <div class="carousel-inner" id="items" > 
              <!-- PRODUCTOS ESPECIALES -->           
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
<?php } ?>


  </div>
</div>
<div class="row clearfix f-space30"></div>
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
                         WHERE c.idcategoria=:idc and p.tipo<>1 and l.idubigeo='".$_SESSION['idciudad']."' 
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
                         WHERE c.idcategoria=:idc and p.tipo<>1 and l.idubigeo='".$_SESSION['idciudad']."' 
                            and p.fecha_fin >= CURDATE()
                         order by idpublicaciones desc limit 8";
         }
         
         $pub = $db->prepare($sql_q);
         $pub->bindValue(':idc', $c['idcategoria'] , PDO::PARAM_INT);
         $pub->execute();
         $cant= $pub->rowCount();
    ?> 
      <div class="box-content">
        <div class="box-products slide" id="productc3">
          <div class="carousel-inner"> 
            <!-- Items Row -->
            <div class="item active">
              <div class="row box-product"> 
                 <?php  
                 if ($cant>0) {
                  while($p=$pub->fetch())
                    {
                      $o = oferta($p);
                      echo $o;
                      
                    }
                  }
                  else{echo "<br><center><layout>Disculpe no existe descuentos para esta zona, le recomendamos visitar las otras zonas</layout></center>";}
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

       
      
   </div><!-- fin col -->

   </div> <!-- fin row -->

</div> <!-- fin container -->


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
</body>
</html>