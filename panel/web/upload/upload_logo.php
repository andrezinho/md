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
    if ($size <= 1024*1024)
    {
        if($width >= 200 && $height >= 200 )
        {        
            //Recuperar el nombre de la imagen actual y eliminarla
            $stmt = $db->prepare("SELECT logo from empresa where idempresa=:id");
            $stmt->bindParam(':id',$id_foto,PDO::PARAM_INT);
            $stmt->execute();
            $r = $stmt->fetchObject();

            switch ($tipo) 
            {
                case 'image/x-png': 
                case 'image/png':
                    $type="png";
                    break;
                default: $type="jpg";break;
            }


            $current_name_imagen = $r->logo;
            if($current_name_imagen!="")
            {                
                if(file_exists("../imagenes/logos/".$current_name_imagen))
                {
                    unlink("../imagenes/logos/".$current_name_imagen);
                }
            }

            $new_name = date('dmYhms_').rand(0,62)."_".$id_foto;

            $foo = new Upload($_FILES["file"]);
            if ($foo->uploaded) 
            {
                $foo->file_new_name_body = $new_name;
                if($type=="jpg")
                {
                    
                    $foo->image_convert = 'jpg';                    
                    $foo->image_resize = true;
                    $foo->jpeg_quality = 100;
                    $foo->image_y = 200;
                    $foo->image_x = 200;

                }                
                
                $foo->Process("../imagenes/logos/");   
                if ($foo->processed) 
                {
                  $new_name = $new_name.".".$type;
                  $stmt = $db->prepare("UPDATE empresa set logo = :lo where idempresa=:id");
                  $stmt->bindParam(':lo',$new_name,PDO::PARAM_STR);
                  $stmt->bindParam(':id',$id_foto,PDO::PARAM_INT);
                  $stmt->execute();
                  $error = 1;
                  $msg= "<img src='imagenes/logos/".$new_name."' width='200' height='200' />";

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