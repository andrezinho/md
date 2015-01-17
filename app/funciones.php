<?php 
function dameURL()
{
    $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    return $url;
}
      //echo dameURL();
      function urls_amigables($url) { 
      // Tranformamos todo a minusculas 
      $url = strtolower($url);
 
      //Rememplazamos caracteres especiales latinos 
      $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
      $repl = array('a', 'e', 'i', 'o', 'u', 'n');
      $url = str_replace ($find, $repl, $url);
 
      // Añadimos los guiones 
      $find = array(' ', '&', '\r\n', '\n', '+');
      $url = str_replace ($find, '-', $url);
 
      // Eliminamos y Reemplazamos demás caracteres especiales 
      $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
      $repl = array('', '-', ''); 
      $url = preg_replace ($find, $repl, $url);
 
      return $url;
 
}
function getVariables($url)
      {
            //quitamos la barra del final
            $url = preg_replace('/\/$/','',$url);
            //separamos las partes/variables de la url y las contamos
            $variables = explode('/',$url);
            $cantVariables = count($cantidad);
            for($c = 0; $c < $cantVariables; $c++)
            {
                  //acumulamos los valores en un arreglo
                  $variables[$c] = limpiar($variables[$c]);
            }
            return $variables;
      }

function limpiar($valor)
{
      //permitimos solo letras(a-Z), numero y guiones
      return preg_replace('/[^a-zA-Z0-9-_]/','',$valor);
}

function oferta($r)
{
      $host="http://".$_SERVER['SERVER_NAME']."/md/";
      $link = $host."/producto/".urls_amigables($r['titulo1']."-".$r['idpublicaciones']);
      $img  = $host."/panel/web/imagenes/home/small_".$r['imagen'].".jpg";

      $html = '';
      $html .= '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <div class="product-block">
                    <div class="image">
                      <div class="product-label product-sale"><span>'.$r['descuento'].'</span></div>
                      <a class="img" href="'.$link.'"><img alt="product info" src="'.$img.'" title="'.utf8_encode($r['titulo1']).'"></a> </div>
                    <div class="product-meta">
                      <div class="name">
                        <a href="producto.html">
                        '.utf8_encode($r['titulo1']).'
                        </a>
                      </div>
                      <div class="big-price"> 
                        <span class="price-new">
                          <span class="sym">S/.</span>
                           '.$r['precio'].'
                          </span> 
                        <span class="price-old">
                          <span class="sym">S/. </span>
                            '.$r['precio_regular'].'
                          </span> 
                      </div>
                      <div class="big-btns"><a class="btn btn-default btn-View pull-left" href="'.$host.'/ficha-compra.php?p='.$r['idpublicaciones'].'">Comprar</a></div>
                      <div class="small-price">
                        <span class="price-new">
                          <span class="sym">S/.</span>
                          '.$r['precio'].'
                        </span> 
                        <span class="price-old">
                          <span class="sym">S/.</span>
                          '.$r['precio_regular'].'
                        </span>
                      </div>
                      ';
             $html .= '<div class="small-btns">';
             
             if($r['deseo']==0) 
             {
                  $html .='<button id="btn-wishlist-'.$r['idpublicaciones'].'" class="btn btn-default btn-wishlist pull-left" title="">
                        <i class="fa fa-heart fa-fw" id="fa-heart-'.$r['idpublicaciones'].'"></i>';
             } 
            else 
            {
                   $html .= '<button class="btn btn-default btn-wishlist pull-left" title="">
                        <i class="fa fa-heart fa-fw" style="color:#FCD209"></i> ';
             } 
                  $html .= '</button>
                        <button class="btn btn-default btn-compare pull-left" title="Ver">
                          <a href="producto/'.urls_amigables($r['titulo1'].'-'.$r['idpublicaciones']).'">Ver</a> <b>&GT;</b>
                        </button>
                      </div>';
                   

                  $html .='</div>
                    <div class="meta-back"></div>
                  </div> 
                  <div class="row clearfix f-space30"></div>
                </div>';
  return $html;
}
function login($helper,$config)
{
    $host="http://".$_SERVER['SERVER_NAME']."/md/";
    if (!isset($_SESSION['facebook'])&&!isset($_SESSION['email']))
    {
       $html = '<li class="dropdown">
                <a class="dropdown-toggle" data-hoView="dropdown" data-toggle="dropdown" href="#a"> 
                  <i class="fa fa-user fa-fw"></i>
                    <span class="hidden-xs"> Iniciar Sesión</span>              
                </a>              
                <div class="loginbox dropdown-menu" id="box-login"> 
                  Conectarse con:<br>
                    <div class="social-icons">
                      <ul>
                        <li class="icon google-plus"><a href="#a"><i class="fa fa-google-plus fa-fw"></i></a></li>
                        <li class="icon twitter"><a href="#"><i class="fa fa-twitter fa-fw"></i></a></li>
                        <li class="icon facebook" id="icon_facebook"><a href="'.$helper->getLoginUrl($config['scopes']).'"><i class="fa fa-facebook fa-fw"></i></a></li>
                      </ul>
                    </div>               
                 <br><br>
                 <div id="log-in"><hr> 
                  <span>Login:</span>
                  <span><a href="cuenta.php" id="registrar">Registrar</a></span>
                 </div>
                 <form id="frmlogin" method="post"  action="'.$host.'panel/web/process.php">
                    <div class="form-group"> <i class="fa fa-user fa-fw"></i>
                      <input class="form-control" id="usuario" name="usuario" placeholder="Email" type="text" data-validation="required">
                    </div>
                    <div class="form-group"> <i class="fa fa-lock fa-fw"></i>
                      <input class="form-control" id="password" name="password" placeholder="Password" type="password" data-validation="required">
                    </div>
                    <input type="hidden" name="url_ref" id="url_ref" value="http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'" />
                    <button class="btn medium color1 pull-right" type="submit">Entrar</button>
                 </form>
                 <a href="#">¿Olvidaste tu contrase&nacute;a?</a>
                </div>
              </li>';
    }
    else
    {
      $html= '<li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" data-hoView="dropdown" href="#a"><i class="fa fa-user fa-fw"></i>
            '.$_SESSION['name'].'
            </a>
              <div class="loginbox dropdown-menu">                     
                <ul>';
                if($_SESSION['id_perfil']!=4) 
                { 
                  $html .= '<li><a href="panel/">Panel Admin</a></li>';
                } 
                else 
                { 
                  $html .= '<li><a href="cuenta.php">Mis Datos</a></li>';
                }

                $html .= '<li><a href="#">Mis Cupones</a></li>
                          <li><a href="#">Mis Suscripciones</a></li>
                          <li><a href="app/logout.php?url_ref=http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'">Salir</a></li>
                          </ul>               
                          </div>
                          </li>';
      }
      return $html;
}
?>