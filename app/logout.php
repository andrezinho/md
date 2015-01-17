<?php
	session_start();
	session_destroy();
	if(isset($_GET['url_ref']))
	{
		header('Location: '.$_GET['url_ref']);
	}
	else
	{
		header('Location: ../index.php');		
	}
?>