<?php

function conectarDB(){
    $host = "localhost";
    $usuario = "root";
    $clave = "";
    $baseDatos = "gestor_historias_db";

    $conexion = new mysqli($host, $usuario, $clave, $baseDatos);
    $conexion -> set_charset("utf8mb4");
    
    if($conexion->connect_error){
        die("Error de conexión" . $conexion->connect_error);
    }
    return $conexion;
}