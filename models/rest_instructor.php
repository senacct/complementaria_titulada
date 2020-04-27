<?php
session_start();
require_once "conexion.php";
$sqlt = "SELECT id, nombre FROM usuarios";
$stmt = Conexion::conectar()->prepare($sqlt);
$stmt->execute();
if($stmt->rowCount() > 0){
    $registros = $stmt->fetchAll(); 
    foreach ($registros as $key => $value) {        
            $id = $value['id'];
            $nombre = $value['nombre'];
            $nombre = strtolower($nombre);
            $nombre = html_entity_decode($nombre);
            //$nombre = strtolower($nombre);
            //$nombre = strtoupper($nombre);
            //$nombre = htmlentities($nombre);
            
            echo $nombre.'<br>';
            $sqlt = "UPDATE usuarios SET nombre = '$nombre' WHERE id = '$id';";
            $stmt = Conexion::conectar()->prepare($sqlt);
            $stmt->execute();
    }
}       
