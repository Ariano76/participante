<?php

$host = "localhost";
$bd = "bddemo";
$usuario = "root";
$contrasenia = "";


try {
	$conexion = new PDO("mysql:host=$host; dbname=$bd", $usuario, $contrasenia);
	if ($conexion) {
	}
	
} catch (Exception $e) {

	echo $e->getmessage();
}
?>