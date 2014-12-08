<!DOCTYPE HTML>
<html>
 <head>
  <script src="../js/jquery-1.11.1.min.js"></script>
   <script>
     $(function(){
        
        $("input[name='file']").on("change", function(){
            document.getElementById("loader").style.display="inline-block";
            var formData = new FormData($("#formulario")[0]);
            var ruta = "upload_imagen.php";

            $("#respuesta").empty();    
            
            $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(datos)
                {

                    if(datos[0]=="1")
                    {
                        document.getElementById("loader").style.display="none";
                        opener.document.getElementById("imagen-d").innerHTML=datos[1];
                    }
                    else
                    {
                        $("#respuesta").empty().append(datos[1]);
                    }
                   
                }
            });
            
        });
     });
    </script>
 </head>
 <body style="padding:0;margin:0;background:#dadada; color:#666;">
 <div style="text-align:center; ">
 <form method="post" id="formulario" enctype="multipart/form-data">
   <input type="hidden" name="p" value="<?php echo $_GET['p'] ?>" />
    <h2>Seleccionar Imagen</h2><input type="file" name="file">    
    <br/>
    <br/>
    <div id="loader" style="display:none">Subiendo imagen...</div>
 </form>
 </div>
 <div id="respuesta"></div>
 </body>
</html>