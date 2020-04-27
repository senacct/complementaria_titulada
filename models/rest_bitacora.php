<?php
session_start();
require_once "conexion.php";
$sqlt = "SELECT id, estado FROM fcaracterizacion";
$stmt = Conexion::conectar()->prepare($sqlt);
$stmt->execute();
if($stmt->rowCount() > 0){
    $registros = $stmt->fetchAll(); 
    foreach ($registros as $key => $value) {        
            $idficha = $value['id'];
            $eficha = $value['estado'];
            $sqlt = "UPDATE bitacoraestados SET visible = '1' WHERE idficha = '$idficha' AND estado = '$eficha'  ORDER BY id DESC LIMIT 1;";
            $stmt = Conexion::conectar()->prepare($sqlt);
            $stmt->execute();
    }
}       
