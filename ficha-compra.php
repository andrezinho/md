<?php
session_start();
require_once 'head.php'; //Start para facebook -> ;)
$url=$_GET["id"];
$db = Spdo::singleton();
$stmt = $db->prepare("SELECT * 
                      FROM publicaciones
                      WHERE estado<>0 and tipo=1
                      ORDER BY idpublicaciones desc limit 3");
$stmt->execute();
$lista= $stmt->rowCount();

$id = $_GET['p'];
$stmt = $db->prepare("SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion as desc_publi,
                             c.descripcion as categoria,p.precio,p.precio_regular, p.imagen,p.fecha_inicio,
                             p.fecha_fin,p.hora_inicio,p.hora_fin,p.descuento,e.idempresa,e.razon_social as empresa,e.logo,e.facebook,e.twitter,e.youtube,e.razon_comercial,p.cc,
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
$rr = $stmt->fetch();

$ahorro=$rr['precio_regular']-$rr['precio'];
$img=$host."/panel/web/imagenes/".$r['imagen'].".jpg";
if($rr['logo']!=""){$logo=$host."/panel/web/imagenes/logos/".$rr['logo'];}
else{$logo=$host."/images/nologo.png";}
?>
<script type="text/javascript">
  $(document).ready(function(){

  });
</script>
<body>
<div id="frm-suscripcion"></div>
<header>   
  <div class="c-top" style="background: #EEEEEE; padding: 5px 0 0 0; margin-top: -8px; box-shadow: 3px 2px 5px #ccc;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="topheadrow">
          <a href="<?php echo $host;?>"><img src="<?php echo $host;?>/images/logo.png" /></a>
          <ul class="nav nav-pills pull-right">            
            <li class="dropdown" style="padding:10px 10px 6px;">Descuentos en
              <select id="ciudades" name="ciudades" class="web-list list-local" style="max-width:140px;border:0;">
                <?php                   
                  $sql = "SELECT c.idciudad,u.descripcion from ciudad as c inner join ubigeo as u on c.idciudad = u.idubigeo where c.estado = 1 order by c.cod ";
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

            <li> <a href="#" id="recibir_ofertas"> <i class="fa fa-envelope fa-fw"></i> <span class="hidden-xs">Quiero Recibir Ofertas</span></a> </li>
            <li> <a href="#"> <i class="fa fa-heart fa-fw"></i> <span class="hidden-xs">Mis Deseos</span></a> </li>            
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
          <li> <a href="<?php echo $host;?>"><span class="hidden-sm">&Uacute;ltimas Ofertas</span></a>
          </li>
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
  <div style="min-height:350px;">
    <h2>Proceso de Compra</h2>
    <div class="box-pay">
      <div class="box-pay-p">
        <div class="box-pay-title" style="background:#B3B3B3">Datos Personales</div>
        <div style="margin:20px 0">
          <table>
            <tr>
              <td>Nombres</td>
              <td>: <?php echo $_SESSION['name']; ?></td>
            </tr>
            <tr>
              <td>e-mail</td>
              <td>: <?php echo $_SESSION['email']; ?></td>
            </tr>
            <tr>
              <td>DNI</td>
              <td>: <?php echo $_SESSION['dni']; ?></td>
            </tr>
            <tr>
              <td>Telefono</td>
              <td>: <?php echo $_SESSION['telefono']; ?></td>
            </tr>
            <tr>
              <td>Celular</td>
              <td>: <?php echo $_SESSION['celular']; ?></td>
            </tr>

          </table>
        </div>
      </div>
    </div>
    <div class="box-pay">
      <div class="box-pay-p">
        <div class="box-pay-title" style="background:#838383">Tu Compra</div>
        <div style="margin:20px 0">
          <table>
            <tr>
              <td><img src="panel/web/imagenes/home/small_<?php echo $rr['imagen']; ?>.jpg" width="50" ></td>
              <td><?php echo utf8_encode($rr['titulo2']); ?></td>
            </tr>
          </table>
          <hr>
          <table>
            <td width="260" align="right">Sub total</td>
            <td><b>S/. <?php echo $rr['precio'] ?></b></td>
          </table>
          <hr>
          <table>
            <td width="260" align="right">Total</td>
            <td><b>S/. <?php echo $rr['precio'] ?></b></td>
          </table>
        </div>
      </div>
    </div>
    <div class="box-pay">
      <div class="box-pay-p">
        <div class="box-pay-title" style="background:#666666">Medio de Pago</div>
        <div style="margin:20px 0">
        <div style="">
          <table cellpadding="0">
            <tr>
              <td><input type="radio" name="medio_pago" value="1"/></td>
              <td><img src="images/visa.jpg" style="width:70px"></td>              
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="vertical-align: text-top;">
                Paga con Tarjeta de Crédito Visa
              </td>
            </tr>
          </table>
        </div>        

        <div style="margin-top:5px">
          <table cellpadding="0">
            <tr>
              <td><input type="radio" name="medio_pago" value="2"/></td>
              <td style="padding:0"><img src="images/master_card.jpg" style="width:70px"></td>              
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="vertical-align: text-top;">
                Paga con Tarjeta de Crédito Master Card
              </td>
            </tr>
          </table>
        </div>

        <div style="background:#dadada;margin-top:20px; padding:10px; ">
          <table>
            <tr>
              <td><input type="radio" name="acepto_terminos" value="1" checked="" /></td>
              <td>
                Acepto los <a href="#" style="color:blue">Términos y Condiciones</a>, y <a href="#" style="color:blue">Políticas de Privacidad</a>
              </td>              
            </tr>            
          </table>
        </div>        

        
                <div class="product-details" >
                    <div class="short-info-det">
                    <div class="product-btns-detalle">
                            <div class="product-big-btns" style="background:#FFF;">
                                <button class="btn-comprar" data-toggle="tooltip" title="Comprar" style="width:100%">COMPRAR</button>
                                <!-- <button class="btn btn-wishlist-det" data-toggle="tooltip" title="Agregar a mis deseos"> <i class="fa fa-heart fa-fw"></i> </button> -->
                            </div>
                    </div>
                    </div>
                </div>




        </div>
      </div>
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

</body>
</html>