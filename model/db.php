<?php

$servidor = "localhost";
$usuario = "root";
$password = "123456";
$base_datos = "db_tareas";


$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

if($conexion->connect_error){
    die("Error de conexión: ".$conexion->connect_error);

}


//$sql="CREATE DATABASE db_tareas";
/*
if($conexion->query($sql)===TRUE){
    echo "Base de datos creada";
}else{
    echo "ERROR ".$conexion->error;
}
*/

?>
