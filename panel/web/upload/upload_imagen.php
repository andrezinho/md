<?php
include('../../lib/Spdo.php');
include('../../lib/class.upload.php');
$db = Spdo::singleton();
$id_foto=$_POST['p'];

//Validar si el usuario a modificar la publicacion tiene permiso para realizarlo


//Validaciones
$file = $_FILES["file"];
$tipo = $file["type"];
$size = $file["size"];
$ruta_provisional = $file["tmp_name"];

$dimensiones = getimagesize($ruta_provisional);
$width = $dimensiones[0];
$height = $dimensiones[1];

if ($tipo == 'image/jpg' || $tipo == 'image/jpeg' || $tipo == 'image/png' || $tipo == 'image/gif')
{
    if ($size <= 1024*1024*2)
    {
        if($width >= 262 && $height >= 261 )
        {        
            //Recuperar el nombre de la imagen actual y eliminarla
            $stmt = $db->prepare("SELECT imagen from publicaciones where idpublicaciones=:id");
            $stmt->bindParam(':id',$id_foto,PDO::PARAM_INT);
            $stmt->execute();
            $r = $stmt->fetchObject();

            $current_name_imagen = $r->imagen;
            if($current_name_imagen!="")
            {                
                if(file_exists("../imagenes/".$current_name_imagen.".jpg"))
                {
                    unlink("../imagenes/".$current_name_imagen.".jpg");
                }
                if(file_exists("../imagenes/home/small_".$current_name_imagen.".jpg"))
                {
                    unlink("../imagenes/home/small_".$current_name_imagen.".jpg");
                }
            }

            $new_name = date('dmYhms_').rand(0,62)."_".$id_foto;

            $foo = new Upload($_FILES["file"]);
            if ($foo->uploaded) 
            {    
                $foo->file_new_name_body = $new_name;            
                $foo->image_convert = 'jpg';
                $foo->image_resize = true;
                $foo->image_y = 380;
                $foo->image_x = 577;
                $foo->Process("../imagenes/");   
                if ($foo->processed) 
                {
                  $foo->file_new_name_body = 'small_'.$new_name;
                  $foo->image_convert = 'jpg';
                  $foo->image_resize = true;      
                  //$foo->image_ratio = true;
                  $foo->image_y = 261;
                  $foo->image_x = 262;
                  $foo->Process('../imagenes/home/');    

                  //
                  $stmt = $db->prepare("UPDATE publicaciones set imagen = '".$new_name."'
                                        where idpublicaciones=:id");
                  $stmt->bindParam(':id',$id_foto,PDO::PARAM_INT);
                  $stmt->execute();
                  $error = 1;
                  $msg= "<img src='imagenes/home/small_".$new_name.".jpg' />";

                } 
                else 
                {
                    $msg = $foo->error;
                    $error = 0;
                }
            }
            else
            {
                $msg = $foo->error;
                $error = 0;
            }
            
        }
        else
        {
            $msg = "Error, La imagen no supera las dimensiones minimas.";
            $error = 0;
            
        }
    }
    else
    {
        $msg = "Error, el tamaño máximo permitido es un 2MB";
        $error = 0;
    }
}
else
{
    $msg = "Error, el archivo no es una imagen";
    $error = 0;    
}

print_r(json_encode(array($error,$msg)));

?>