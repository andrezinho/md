<?php 
      function dameURL(){
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

?>