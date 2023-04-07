<?php
	//servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos
	// 18/12/2017
	$server="localhost";
	$user="root";
	$password="";
	$database="iedonal1_sisca";

	$mysqli=new mysqli($server,$user,$password, $database); 
	 date_default_timezone_set("America/Bogota");
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	
?>