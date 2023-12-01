<?php

$host = "localhost";
$bd = "libreria";
$usuario = "root";
$contrasenia = "";

try {

    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasenia);

} catch (PDOException $ex) {

    echo $ex->getMessage();

}

?>