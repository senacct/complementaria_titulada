<?php
require_once "conexion.php";
session_start();
class ProspectosModel{
	 public function __construct() {
			//require_once "conexion.php";
		}
	 public function decode_entities($text){ 
		    return html_entity_decode($text);
		}

public static function listaProspectos(){
  $tabla = '';
  $opciones = '';
  $salida = array();	 
  $p = new ProspectosModel();
  if(isset($_SESSION['prc_idusuario'])){
   $idusuario = $_SESSION['prc_idusuario'];
   $centro = $_SESSION['prc_centro'];
   $perfil = $p->perfilUsuario('prospectoslista', $idusuario);
   if($perfil == '1'){	  
		  $sqlt = "SELECT pr.id, pr.nombre, pr.correo, pr.telefonos, pr.cursos,pr.tipodoc, pr.documento, us.nombre usnombre, pr.fecha, pr.hora, pr.estado FROM prospectos pr INNER JOIN usuarios us ON  pr.idusuario = us.id WHERE pr.centro = '$centro' ";
		  $stmt = Conexion::conectar()->prepare($sqlt);
		  $stmt -> execute();
		  if($stmt->rowCount() > 0){
	  	
		    $respuesta = '1';
		    $registros = $stmt->fetchAll(); 
		    foreach ($registros as $key => $value) {
					$id = $value['id'];
					$nombre = $value['nombre'];
					$correo = $value['correo'];
					$telefonos = $value['telefonos'];
					$cursos = $value['cursos'];
					$tipodoc = $value['tipodoc'];
					$documento = $value['documento'];					
					$usnombre = $value['usnombre'];
					$fecha = $value['fecha'];
					$hora = $value['hora'];
		            $estado = $value['estado'];
			      if($estado == '1'){
			        $sestado = 'btn-success';
			        $testado = '<span style="color:green;">Seleccionado</span>';
			        $iestado = '<i class="far fa-check-circle"></i>';
			      }else{
			        $sestado = 'btn-info';
			        $testado = '<span style="color:orange;">Pendiente</span>';
			        $iestado = '<i class="far fa-circle"></i>';
			      }
			      $labelestado ='<button type="button" id="btnestado'.$id.'" onClick="prospectoEstado(\''.$id.'\',\''.$estado.'\',\'prospectos\');" class="btn '.$sestado.' btn-sm">'.$iestado.'</button>';

			     // $tabla .= '{"nombre":"'.$nombre.'","correo":"'.$correo.'","telefonos":"'.$telefonos.'","cursos":"'.$cursos.'","usnombre":"'.$usnombre.'","fecha":"'.$fecha.'","hora":"'.$hora.'","estado":"'.$iestado.'","opciones":"'.$labelestado.'"},';
		        $newarray = array(
					"nombre" => $nombre,
					"correo" => $correo,
					"telefonos" => $telefonos,
					"cursos" => $cursos,
					"usnombre" => $usnombre,
					"fecha" => $fecha,
					"tipodoc" => $tipodoc,
					"documento" => $documento,					
					"hora" => $hora,
					"estado" => $testado,
					"opciones" => $labelestado 
			    );
			array_push($salida, $newarray); 
		    } 

     }
   } else{
		       
		$newarray = array(
			"nombre" => "Sin Autorización",
			"correo" => "Sin Autorización",
			"telefonos" => "Sin Autorización",
			"cursos" => "Sin Autorización",
			"usnombre" => "Sin Autorización",
			"tipo" => "Sin Autorización",
			"numero" => "Sin Autorización",			
			"fecha" => "Sin Autorización",
			"hora" => "Sin Autorización",
			"estado" => "Sin Autorización",
			"opciones" => "Sin Autorización"
		);
		array_push($salida, $newarray); 
   }
  } 
    $tabla = json_encode($salida); 
	return '{"data":'.$tabla.'}';	     
}

public static function prospectoCrear($datos){
include_once "../../routes/config.php";
	$ruta = SERVERURL; 		
	$ip = $_SERVER["REMOTE_ADDR"]; 
	date_default_timezone_set('America/Bogota');
	$fecha = date("Y-m-d");
	$hora = date('H:i:s'); 
	$nombre = $datos['nombre'];
	$correo = $datos['correo'];
	$tipodoc = $datos['tipodoc'];
	$documento = $datos['documento'];	
	$telefonos = $datos['telefonos'];
	$cursos = $datos['cursos'];
	if(isset($_SESSION['prc_idusuario'])){
		$idusuario = $_SESSION['prc_idusuario'];
	    $centro = $_SESSION['prc_centro'];	
	    $sqlt = "INSERT INTO prospectos (idusuario, nombre, tipodoc, documento, correo, centro, telefonos, cursos, fecha, hora, ip, estado) VALUES('$idusuario', UPPER('$nombre'), '$tipodoc', '$documento',  LOWER('$correo'), '$centro','$telefonos', '$cursos','$fecha', '$hora', '$ip', '0')";
	    $stmt = Conexion::conectar()->prepare($sqlt);
	    $stmt -> execute();
	    if($stmt->rowCount() > 0){
	    	$respuesta = '1';
	    }
	}else{
		$respuesta = '5';
	}    
	   $newdata =  array (
	      'respuesta' => $respuesta,
	      'sql' => $sqlt
	    );
	   $arrDatos[] = $newdata;   
	echo json_encode($arrDatos); 
}


public static function perfilUsuario($perfil, $idusuario){
    $respuesta = '0';	
	$sqlt = "SELECT $perfil FROM perfiles WHERE idusuario = '$idusuario';";
	$stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
	if($stmt->rowCount() > 0){
	    $registros = $stmt->fetchAll(); 
		foreach ($registros as $key => $value){		
			$respuesta = $value[$perfil];
	    };	
	} 
	return $respuesta;  	
  }

public static function prospectoEstado($datos){
	include_once "../../routes/config.php";
	    $ruta = SERVERURL; 	
	 	$id = $datos['id'];
	 	$nestado = $datos['nestado'];
	 	$tabla = $datos['tabla'];
	 	if(isset($_SESSION['prc_idusuario'])){
				$sqlt = "UPDATE $tabla SET estado = '$nestado' WHERE id = '$id'";
				$stmt = Conexion::conectar()->prepare($sqlt);
	    		$stmt -> execute();
				if($stmt->rowCount() > 0){
						$respuesta = '1';	
				      } else{
				    	$respuesta = '0';
				    } 
		}else{
			$respuesta = '5';
		}		     
		$newdata =  array (
		'respuesta' => $respuesta,
		'ruta' => $ruta,
		'consulta'=> $sqlt
		);
		$arrDatos[] = $newdata;  
		echo json_encode($arrDatos);
	 }


}
