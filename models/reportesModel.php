<?php
require_once "conexion.php";
date_default_timezone_set('America/Bogota'); 

if(!isset($_SESSION)){
    session_start();
}
$fecha = date("Y-m-d");
$hora = date('H:i:s');
class GestionReportesModel{
  public static function reportesBitacora(){
    $tabla = '';
    $opciones = '';
    $salida = array();
    if(isset($_SESSION['prc_idusuario'])){ 
    $centro = $_SESSION['prc_centro'];
    $sqlt = "SELECT fc.numero, fc.id id, us.nombre, cr.nombre crnombre, bt.nestado, bt.fecha, bt.hora, bt.ip FROM fcaracterizacion fc INNER JOIN bitacoraestados bt  ON fc.id = bt.idficha INNER JOIN usuarios us ON us.id = bt.idusuario INNER JOIN coordinaciones cr ON us.idcoordinacion = cr.id INNER JOIN usuariocentro uc ON uc.idusuario = us.id  WHERE uc.centro  = '$centro' ORDER BY fc.numero, bt.estado ASC";
    $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
    if($stmt->rowCount() > 0){
      $respuesta = '1';
      $registros = $stmt->fetchAll(); 
      foreach ($registros as $key => $value) {
        $numero = $value['numero'];
        $nombre = html_entity_decode(strtolower($value['nombre']));
        $nombre = ucwords($nombre);
        $nestado = html_entity_decode(strtolower($value['nestado']));
        $nestado = ucwords($nestado);      
        $fecha = $value['fecha'];
        $hora = $value['hora'];
        $ip = $value['ip'];
                $newarray = array(  
                  "numero" => $numero,
                  "nombre" => $nombre,
                  "nestado" => $value['nestado'],
                  "fecha" => $value['fecha'],
                  "hora" => $value['hora'],
                  "ip" => $value['ip']
                  );
                array_push($salida, $newarray); 
               }
            } 
      $tabla = json_encode($salida); 
    return '{"data":'.$tabla.'}';           
  }
}
}
