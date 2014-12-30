<?php
session_start();
require_once 'head.php'; 
$db = Spdo::singleton();

$url=$_GET["id"];

if($url=="")
{
    if(!isset($_SESSION['idusuario']))
        {
          $sql_c = "SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion,
                                   c.descripcion,p.precio,p.precio_regular,p.descuento,
                                   p.imagen,p.idtipo_descuento,s.descripcion as categoria,
                                   0 as deseo
                            FROM publicaciones as p
                            INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                            INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                            INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion 
                            INNER JOIN local as l on l.idlocal=su.idlocal
                            WHERE p.fecha_inicio = CURDATE() AND p.tipo<>1 and l.idubigeo='".$_SESSION['idciudad']."' order by p.idpublicaciones desc";
        }
        else
        {
          $sql_c = "SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion,
                                   c.descripcion,p.precio,p.precio_regular,p.descuento,
                                   p.imagen,p.idtipo_descuento,s.descripcion as categoria,
                                   coalesce(d.idpublicaciones,0) as deseo
                            FROM publicaciones as p
                            INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                            INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                            INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion 
                            INNER JOIN local as l on l.idlocal=su.idlocal
                            left outer join deseos as d on d.idpublicaciones = p.idpublicaciones and d.idusuario = ".$_SESSION['idusuario']."
                            WHERE p.fecha_inicio = CURDATE() AND p.tipo<>1 and l.idubigeo='".$_SESSION['idciudad']."' order by p.idpublicaciones desc";
        }

        $stmt = $db->prepare($sql_c);                
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);        
        $stmt->execute();
        $nc= $stmt->rowCount();
        $st = "Descuentos del Dia";
}
else
{
  if($url=="especiales")
  {

     $str=explode("-", $url);
      $n=count($str);
      $id=$str[$n-1];
      $st="";
      for($i=0; $i<$n; $i++)
      {
        $st .=$str[$i]." ";
      } 

      if(!isset($_SESSION['idusuario']))
      { 
        $sql_qa = "SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion,
                                   c.descripcion as categoria,p.precio,p.precio_regular,p.descuento,
                                   p.imagen,p.idtipo_descuento,0 as deseo
                            FROM publicaciones as p
                            INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                            INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                            INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion 
                            INNER JOIN local as l on l.idlocal=su.idlocal
                            WHERE p.tipo=1 and l.idubigeo='".$_SESSION['idciudad']."' order by p.idpublicaciones desc";        
        
      }
      else
      {
        $sql_qa = "SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion,
                                   c.descripcion as categoria,p.precio,p.precio_regular,p.descuento,
                                   p.imagen,p.idtipo_descuento,coalesce(d.idpublicaciones,0) as deseo
                            FROM publicaciones as p
                            INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                            INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                            INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion 
                            INNER JOIN local as l on l.idlocal=su.idlocal
                            left outer join deseos as d on d.idpublicaciones = p.idpublicaciones and d.idusuario = ".$_SESSION['idusuario']."
                            WHERE p.tipo=1 and l.idubigeo='".$_SESSION['idciudad']."' order by p.idpublicaciones desc";        
      }
      $stmt = $db->prepare($sql_qa);
      $stmt->execute();
      $nc= $stmt->rowCount();
  }

  else
  {

    $str=explode("/", $url);
    $n = count($str);
    if($n>1&&$str[1]!="")
    {
        
        $str=explode("-", $url);
        $n=count($str);
        
        $id=$str[$n-1];
        $id=substr($id,1);
        
        $st="";
        for($i=0; $i<$n-1; $i++)
        {
          $st .=$str[$i]." ";
        }    
        
        if(!isset($_SESSION['idusuario']))
        {
          $sql_c = "SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion,
                                   c.descripcion,p.precio,p.precio_regular,p.descuento,
                                   p.imagen,p.idtipo_descuento,s.descripcion as categoria,
                                   0 as deseo
                            FROM publicaciones as p
                            INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                            INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                            INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion 
                            INNER JOIN local as l on l.idlocal=su.idlocal
                            WHERE s.idsubcategoria=:id and l.idubigeo='".$_SESSION['idciudad']."' order by p.idpublicaciones desc";
        }
        else
        {
          $sql_c = "SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion,
                                   c.descripcion,p.precio,p.precio_regular,p.descuento,
                                   p.imagen,p.idtipo_descuento,s.descripcion as categoria,
                                   coalesce(d.idpublicaciones,0) as deseo
                            FROM publicaciones as p
                            INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                            INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                            INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion 
                            INNER JOIN local as l on l.idlocal=su.idlocal
                            left outer join deseos as d on d.idpublicaciones = p.idpublicaciones and d.idusuario = ".$_SESSION['idusuario']."
                            WHERE s.idsubcategoria=:id and l.idubigeo='".$_SESSION['idciudad']."' order by p.idpublicaciones desc";
        }

        $stmt = $db->prepare($sql_c);        
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        $nc= $stmt->rowCount();
        
      }
      else
      {
        
        $str=explode("-", $url);
        $n=count($str);
        $id=$str[$n-1];
        $st="";
        for($i=0; $i<$n; $i++)
        {
          $st .=$str[$i]." ";
        }    

        if(!isset($_SESSION['idusuario']))
        { 
          $sql_vq = "SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion,
                                       c.descripcion as categoria,p.precio,p.precio_regular,p.descuento,
                                       p.imagen,p.idtipo_descuento,0 as deseo
                                FROM publicaciones as p
                                INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                                INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                                INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion 
                                INNER JOIN local as l on l.idlocal=su.idlocal
                                WHERE c.descripcion=:id and l.idubigeo='".$_SESSION['idciudad']."' order by p.idpublicaciones desc";
        }
        else
        {
          $sql_vq = "SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion,
                                       c.descripcion as categoria,p.precio,p.precio_regular,p.descuento,
                                       p.imagen,p.idtipo_descuento,coalesce(d.idpublicaciones,0) as deseo
                     FROM publicaciones as p
                    INNER JOIN subcategoria as s on s.idsubcategoria=p.idsubcategoria
                    INNER JOIN categoria as c on c.idcategoria=s.idcategoria
                    INNER JOIN suscripcion as su on su.idsuscripcion=p.idsuscripcion 
                    INNER JOIN local as l on l.idlocal=su.idlocal
                    left outer join deseos as d on d.idpublicaciones = p.idpublicaciones and d.idusuario = ".$_SESSION['idusuario']."
                    WHERE c.descripcion=:id and l.idubigeo='".$_SESSION['idciudad']."' order by p.idpublicaciones desc";
          
        }

        $stmt = $db->prepare($sql_vq);        
          $stmt->bindValue(':id', $id , PDO::PARAM_STR);
          $stmt->execute();
          $nc= $stmt->rowCount();
      }
  }
}

?>
<body>
<div id="frm-suscripcion"></div>
<header>   
  <div class="c-top" style="background: #EEEEEE; padding: 5px 0 0 0; margin-top: -8px; box-shadow: 3px 2px 5px #ccc;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="topheadrow">
          <a href="<?php echo $host; ?>/index.php"><img src="<?php echo $host; ?>/images/logo.png" /></a>
          <ul class="nav nav-pills pull-right">
            <li class="dropdown" style="padding:10px 10px 6px;">Descuentos en
              <select id="ciudades" name="ciudades" class="web-list list-local" style="max-width:140px;border:0;">
                <?php                   
                  $sql = "SELECT c.idciudad,u.descripcion from ciudad as c inner join ubigeo as u on c.idciudad = u.idubigeo where c.estado = 1 order by c.cod ";
                  $stmt2 = $db->prepare($sql);
                  $stmt2->execute();                  
                  foreach($stmt2->fetchAll() as $r2)
                  {
                     $s = "";
                     if($r2[0]==$_SESSION['idciudad'])
                     {
                       $s = "selected";
                     }
                     ?>
                     <option value="<?php echo $r2[0] ?>" <?php echo $s; ?>><?php echo $r2[1]; ?></option>
                     <?php
                  }
                ?>
              </select>
            </li>           
            <li> <a href="#" id="recibir_ofertas"> <i class="fa fa-envelope fa-fw"></i> <span class="hidden-xs">Quiero Recibir Ofertas</span></a> </li>
            <li> <a href="<?php echo $host; ?>/deseos.php"> <i class="fa fa-heart fa-fw"></i> <span class="hidden-xs">Mis Deseos</span></a> </li>            
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
          <li> <a href="<?php echo $host;?>"><span class="hidden-sm">&Uacute;ltimas Ofertas</span></a>
          </li>

            <!-- Menu -->

          </ul>
        </div>
          <div class="clearfix"></div>
      </div>
    </div>
  </div>
</header>
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-column box-block">
      <div class="box-heading"><span>Mostrando <?php echo $nc; ?> descuentos <b style="font-size:16px; color:#FCD209">- <?php echo $st;?></b></span></div>
      <div class="box-content" id="item">
        <div class="box-products slide" id="productc3">
          <div class="carousel-inner"> 
            <!-- Items Row -->
            <div class="item active">
              <div class="row box-product" > 
                <!-- Product -->
                <?php while($r = $stmt->fetch())
                {
                  $o = oferta($r);
                  echo $o;
                } 
               ?>
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

</body>
</html>