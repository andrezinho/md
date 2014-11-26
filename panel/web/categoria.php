<?php 
	session_start();    
    require_once '../controller/categoriaController.php';
    echo categoriaController::Menu(3);
?>