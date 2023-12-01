<?php

$host = "sql112.infinityfree.com";
$bd = "if0_35526361_libreria";
$usuario = "if0_35526361";
$contrasenia = "Fce8I3oFIr3M";

try {

    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasenia);

} catch (PDOException $ex) {

    echo $ex->getMessage();

}

?>