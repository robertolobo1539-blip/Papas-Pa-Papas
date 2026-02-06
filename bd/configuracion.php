﻿<?php 

//Datos del servidor y base de datos 

$server="sql200.infinityfree.com"; 
$username="if0_40999838"; 
$password= "C5BLRFrd11g"; 
$database_name="if0_40999838_registrousuarios";
// Crear conexión mysqli
$conexion = mysqli_connect($server, $username, $password, $database_name);

if (!$conexion) {
  die("Error de conexión: " . mysqli_connect_error());
}

mysqli_set_charset($conexion, "utf8");
?>