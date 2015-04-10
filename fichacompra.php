<?php
session_start();
require_once 'head.php';

//$db = Spdo::singleton();
$url=$_GET["id"];

$id=explode("-",$url);
$n=count($id);

$titulo="";
for($s=0; $s<($n-1); $s++) 
{
  $titulo .=$id[$s]." ";
}
$id=$id[$n-1];

$stmt = $db->prepare("SELECT * 
                      FROM publicaciones
                      WHERE estado<>0 and tipo=1
                      ORDER BY idpublicaciones desc limit 3");
$stmt->execute();
$lista= $stmt->rowCount();
//$id = $_GET['p'];
$stmt = $db->prepare("SELECT p.idpublicaciones,p.titulo1, p.titulo2, p.descripcion as desc_publi,
                             c.descripcion as categoria,p.precio,p.precio_regular, p.imagen,p.fecha_inicio,e.dominio,
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
//print_r($_SESSION);
$ahorro=$rr['precio_regular']-$rr['precio'];
$img=$host."/panel/web/imagenes/".$rr['imagen'].".jpg";
if($rr['logo']!=""){$logo=$host."/panel/web/imagenes/logos/".$rr['logo'];}
else{$logo=$host."/images/nologo.png";}
?>

<script type="text/javascript" src="<?php echo $host; ?>/js/compra.js"></script>
<style type="text/css">
  input {border:1px solid #dadada; height: 28px}
  .box-msg-result { font-size:10px; color:red;font-style: italic;}
</style>
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
            <li style="padding:10px 10px 6px;">Descuentos en
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
            <li> <a href="<?php echo $host; ?>/deseos"> <i class="fa fa-heart fa-fw"></i> <span class="hidden-xs">Mis Deseos</span></a> </li>            
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
  <div style="min-height:350px;" id="box-compra-all">
    <h2 style="margin:10px 0; ">Proceso de Compra</h2>
    <div class="box-pay">
      <div class="box-pay-p">
        <div class="box-pay-title" style="background:#B3B3B3">Datos Personales</div>
        <div style="margin:20px 0">
        <?php if (!isset($_SESSION['facebook'])&&!isset($_SESSION['email'])): ?>
          <div style="padding:3px;">
            <div style="color:red;display:none" id="box-msg-session-required">
              Para poder confirmar la compra primero debes <b>Inciar Sesion</b> con tu cuenta de usuario o mediante Facebook.
            </div>
            <br/>
            <span style="font-size:16px;">¿No tienes cuenta? Puedes registrarte desde aqui:</span>
            <br/><br/>
            <div style="text-align:center">
            <!--
            <div class="searchbar" >                       
              <div style="padding-top:10px;display:inline-block">Conectarse con:</div>
              <div class="social-icons" style="float:right;">                    
                    <ul >
                      
                      <li class="icon facebook"><a href="<?php echo $helper->getLoginUrl($config['scopes']); ?>" style="background:#37528D"><i class="fa fa-facebook fa-fw"></i></a></li>
                    </ul>
              </div>
            </div>
            -->
            </div>
            <div>
              <form id="frm" name="frm">

                 <input type="hidden" name="idp" id="idp" value="<?php echo $id ?>" />

                 <table border="0">
                  <tr> 
                   <td>*Nombres</td>
                   <td>
                    <input type="text" id="nombres" name="nombres" value="" placeholder="Tu nombre" autofocus="autofocus" title="Ingrese el Nombre" style="width:100%"><span class="item-required"></span>
                    <div id="nombres-resultado" class="box-msg-result"></div>
                   </td>
                   </tr>

                   <tr>
                   <td><b>*</b>Apellidos</td>
                   <td>
                  <input type="text" id="apellidos" name="apellidos" value="<?php echo $_SESSION['apellido'];?>" placeholder="Tu Apellido" autofocus="autofocus" title="Ingrese sus Apellidos" style="width:100%"><span class="item-required"></span>
                  <div id="apellidos-resultado" class="box-msg-result"></div>
                   </td>
                   </tr>
                  
                 
                   <tr>
                   <td><b>*</b>Email</td>
                   <td>
                  <input type="text" id="email" name="email" value="" placeholder="Tu Email"  autofocus="autofocus" title="Ingrese su Email" style="width:100%">                  
                  <div id="email-resultado" class="box-msg-result"></div>
                   </td>
                   </tr>

                   <tr>
                   <td><b>*</b>Contraseña</td>
                   <td>
                    <input type="password" id="passw" name="passw" value="" placeholder="Tu Password"  autofocus="autofocus" title="Ingrese su Contraseña" style="width:100%">
                    <span class="item-required" class="box-msg-result"></span>
                   </td>
                   </tr>

                   <tr>
                   <td><b>*</b>Repetir Contraseña</td>
                   <td>
                  <input type="password" id="rpassw" name="rpassw" value="" placeholder="Repetir Contraseña"  autofocus="autofocus" title="password" style="width:100%">                  
                  <div id="resultado_contra"></div>
                  <div id="resultado-rpassw" class="box-msg-result"></div>
                   </td>
                   </tr>

                
                   <tr>
                   <td><b>*</b>Tipo Documento</td>
                   <td>
                    <select id="tipodoc" name="tipodoc" class="ui-widget-content ui-corner-all" style="height:30px">
                        <option value="1" selected>DNI</option>
                        <option value="2">RUC</option>
                        <option value="3">PASAPORTE</option>        
                        <option value="4">CARNET DE EXTRANJERIA</option>
                    </select>
                   </td>
                   </tr>

                   <tr>
                   <td><b>*</b>Nro. Documento</td>
                   <td>
                   <input type="text" id="ndoc" name="ndoc" value="" placeholder=""  autofocus="autofocus" title="Ingrese su Numero Documento" style="width:100%">                  
                   <div id="ndoc-rpassw" class="box-msg-result"></div>
                   </td>
                   </tr>

                   <tr>
                     <td><b>*</b>Genero</td>
                     <td>
                      <input type="radio" name="sexo" value="1" checked  id="sexo1" style="height:15px"/>
                        <label for="sexo1">Masculino</label>                    
                     </td>
                   </tr>

                   <tr>
                     <td>&nbsp;</td>
                     <td>
                      <input type="radio" name="sexo" value="0" id="sexo2" style="height:15px" /> <label for="sexo2">Femenino</label>
                     </td>
                   </tr>
                   
                 </table>
                 </form>  
            </div>
            
          </div>
          <?php else: ?>
          <form id="frm" name="frm">
            <input type="hidden" name="idp" id="idp" value="<?php echo $id ?>" />
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
          </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="box-pay">
      <div class="box-pay-p">
        <div class="box-pay-title" style="background:#838383">Tu Compra</div>
        <div style="margin:20px 0">
          <table>
            <tr>
              <td><img src="<?php echo $img;?>" width="50" ></td>
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
              <td><input type="radio" name="medio_pago" value="1" checked="" /></td>
              <td >
                Depósito en Cuenta Bancaria
              </td>
            </tr>
          </table>
        </div>            
        <div style="background:#dadada;margin-top:20px; padding:10px; ">
          <table>
            <tr>
              <td><input type="checkbox" name="acepto_terminos" id="acepto_terminos" value="1" /></td>
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
                    <button id="btn-conf-compra" class="btn-comprar" data-toggle="tooltip" title="Pagar" style="width:100%">CONFIRMAR COMPRA</button>                    
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