<?php
 require_once "conexion.php";
 include_once "../../routes/config.php"; 
 session_start();
class EmpresaModel{

 public function __construct() {
	//require_once "conexion.php";
}
 public function decode_entities($text){ 
    return html_entity_decode($text);
} 

public function tablaContacto(){
 $salida = array();	
 if(isset($_SESSION['prc_ciuser'])){
    $coordinacion = $_SESSION['prc_coordinacion'];
    $centro = $_SESSION['prc_centro'];
    $perfil = $_SESSION['prc_perfil'];	
    $sqlt = "SELECT fc.numero, cr.nombre coordinacion, fc.codempresa, fc.controlada, fc.id idficha, fc.lugar, fc.direccion, fc.naprendices, fr.codigo, fr.nombre, fr.horas, us.nombre instructor, us.identificador idusuario, be.nestado, be.estado estado, be.fecha, em.nombre empresa, em.id, em.identificador idempresa, cd.ciudad, fc.finicia, fc.ffinaliza, fc.validado, ct.nombre ctnombre, ct.telefono cttelefono, ct.correo ctcorreo FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN empresas em ON fc.idempresa = em.id  INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN bitacoraestados be ON fc.id = be.idficha INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id INNER JOIN contactos ct ON em.identificador = ct.idempresa AND us.identificador = ct.idusuario WHERE fc.historico = '0' AND fc.estado = be.estado  AND fc.ccentro = '$centro' AND be.visible = '1' ";
        $stmt = Conexion::conectar()->prepare($sqlt);
         $stmt -> execute();
          if($stmt->rowCount() > 0){
             $registros = $stmt->fetchAll(); 
             foreach ($registros as $key => $value) {
             	$idficha = $value['idficha'];
             	$idusuario = $value['idusuario'];
             	$idempresa = $value['idempresa'];
             	$nvalidado = $value['validado'];
             if($nvalidado == '1'){
             	$evalidado = "<span style='color:green;'>Validado</span>";
             	$lvalidado = '<i class="far fa-check-square"></i>';
             	$bvalidado = 'btn-success';
             }else{
             	$evalidado = "<span style='color:blue;'>Pendiente</span>";

             	$lvalidado = '<i class="far fa-square"></i>';             	
             	$bvalidado = 'btn-default';
             }	
            $opciones = '<div class="btn-group" role="group" aria-label="Basic example">';
            if($value['estado'] > 2) { 
            $opciones .= ' <button type="button" id="btvhorario'.$idficha.'" onClick ="verProgramacion('.$idficha.');"  class="btn btn-info btn-sm"><i class="far fa-calendar-alt"></i></button>'; 
            }else{
            $opciones .= '<button type="button" id="btvhorario'.$idficha.'" class="btn btn-default btn-sm"><i class="far fa-calendar-alt"></i></button>';
            }                           
		    $opciones .= '<button type="button" id="btvbitacora'.$idficha.'" onClick ="verMibitacora('.$idficha.');" class="btn btn-info btn-sm"><i class="fas fa-list-ol"></i></button><button type="button" id="btvalidar'.$idficha.'" onClick="validarContactos('.$idficha.',\''.$nvalidado.'\');" class="btn '.$bvalidado.' btn-sm">'.$lvalidado.'</button><button type="button" id="btvnotificar'.$idficha.'" onClick ="preNoConfirmado('.$centro.',\''.$idempresa.'\',\''.$idusuario.'\');" class="btn btn-warning btn-sm"><i class="fas fa-exclamation-triangle"></i></i></button></div>';                 
              	$newarray = array(	
					"validado" => $evalidado,
					"ctnombre" => $value['ctnombre'],
					"cttelefono" => $value['cttelefono'],
					"ctcorreo" => $value['ctcorreo'],
					"empresa" => $value['empresa'],
					"coordinacion" => $value['coordinacion'],
					"instructor" => $value['instructor'],
					"ciudad" => $value['ciudad'],
					"lugar" => $value['lugar'],
					"direccion" => $value['direccion'],
					"numero" => $value['numero'],
					"nombre" => $value['nombre'],				
					"horas"  => $value['horas'],
					"finicia" => $value['finicia'],
					"ffinaliza" => $value['ffinaliza'],
					"nestado" => $value['nestado'],
					"opciones" => $opciones
			    );
			array_push($salida, $newarray); 
             }
          } 
    $tabla = json_encode($salida); 
	return '{"data":'.$tabla.'}';			   
   }
}

public function validarContactos($datos){
include_once "../../routes/config.php";
$ruta = SERVERURL;  
$sqlt = '';
$ip = $_SERVER["REMOTE_ADDR"]; 
$fecha = date("Y-m-d");
$hora = date('H:i:s'); 	
$idficha = $datos['idficha'];
$nvalidado = $datos['nvalidado'];
if($nvalidado == '1'){
	$nvalidado = '0';
}else{
	$nvalidado = '1';
}
if(isset($_SESSION['prc_idusuario'])){
	$idusuario = $_SESSION['prc_idusuario'];
	$respuesta = '0';
	$sqlt = "UPDATE fcaracterizacion SET validado = '$nvalidado', vfecha = '$fecha', vhora = '$hora', vusuario = '$idusuario' WHERE  id = '$idficha'";
		$stmt = Conexion::conectar()->prepare($sqlt);
		$stmt -> execute();
        if($stmt->rowCount() > 0){
		    $respuesta = '1';
		}else{
			$respuesta = '0';
		}  
	}else{
		$respuesta = '5';
	}	
  $newdata =  array (
   'respuesta' => $respuesta,
   'ruta'=> $ruta,
   '$sqlt'=>$sqlt 
 );  
 $arrDatos[] = $newdata;   
echo json_encode($arrDatos);
}	

public function selectDepto(){
	//require_once "conexion.php";
   $respuesta = '1';
   $lista = '';
   $sqlt = "SELECT id, depto FROM deptos ORDER BY depto ASC";
   $stmt = Conexion::conectar()->prepare($sqlt);
	if($stmt -> execute()){
		$respuesta = '1';
		$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value) {
			$id = $value['id'];
			$departamento = $value['depto'];
			$lista .= '<option value="'.$id.'">'.$departamento.'</option>';
		}			
		$newdata =  array (
              'respuesta' => $respuesta,
              'datos' => $lista
            );  			
	}else{
		$respuesta = '0';	
		$newdata =  array (
		     'respuesta' => $respuesta 
		);  
	}
	$arrDatos[] = $newdata;   
	echo json_encode($arrDatos);
			   
}

public function selectCiudad($idDepto){
   $respuesta = '1';
   $lista = '';
   $sqlt = "SELECT id, ciudad FROM ciudades WHERE idDepto = '$idDepto' ORDER BY ciudad ASC";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> bindParam(":idDepto", $idDepto, PDO::PARAM_INT);
	if($stmt -> execute()){
		$respuesta = '1';
		$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value) {
			$id = $value['id'];
			$ciudad = $value['ciudad'];
			$lista .= '<option value="'.$id.'">'.$ciudad.'</option>';
		}			
		$newdata =  array (
              'respuesta' => $respuesta,
              'datos' => $lista
            );  			
	}else{
		$respuesta = '0';	
		$newdata =  array (
		     'respuesta' => $respuesta
		);  
	}
	$arrDatos[] = $newdata;   

	echo json_encode($arrDatos);
    //$stmt -> Conexion::close();		   
}

public function updateEmpresa($datos){
//session_start();
date_default_timezone_set('America/Bogota'); 
$ip = $_SERVER["REMOTE_ADDR"]; 
$fecha = date("Y-m-d");   
$hora = date('H:i:s');
$id = $datos['id'];
$nit = htmlentities($datos['nit']);
$departamento = $datos['depto'];  
$ciudad = $datos['ciudad'];
$nombre = $datos['nempresa']; 
$direccion = $datos['direccion'];
$ncontacto = $datos['ncontacto'];
$tcontacto =  $datos['tcontacto'];
$correo = strtolower($datos['correo']);
if(isset($_SESSION['prc_idusuario'])){  
	$centro = $_SESSION['prc_centro'];		
	$coordinacion = $_SESSION['prc_coordinacion'];
	$usuario =	$_SESSION['prc_ciuser'];
	$idusuario = 	$_SESSION['prc_idusuario'];
		if($id == '0'){
		    $editable = '1';
			$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$num = "0123456789";
			$cad = "";
			$resultado = 1;
	        while($resultado > 0){
	           $cad = "";
	          for($j=0;$j<4;$j++) {
	            $cad .= substr($str,rand(0,25),1); 
	            }
	          for($j=0;$j<6;$j++) {
	            $cad .= substr($num,rand(0,5),1);
	            }
	            $sqlt = "SELECT COUNT(*) as cuantos FROM empresas WHERE identificador = '$cad'";
	            $stmt = Conexion::conectar()->prepare($sqlt);
				  if($stmt -> execute()){
				  	$registros = $stmt->fetchAll();	
						foreach ($registros as $key => $value) {
							$resultado = $value['cuantos'];
						}	
	              } else{
	            	$resultado = 0;
	            }  
	        }
	      $identificador = $cad;      
		}else{
		   $sqlt = "SELECT identificador, editable FROM empresas WHERE id = '$id'";
		   $stmt = Conexion::conectar()->prepare($sqlt);
			if($stmt -> execute()){
			$registros = $stmt->fetchAll();	
				foreach ($registros as $key => $value) {
					$identificador = $value['identificador'];
					$editable = $value['editable'];
				}
			}
       }
	if($editable == '1'){
		$sqlt = "INSERT INTO empresas (id, identificador, centro, nit, departamento, ciudad, nombre, direccion, usuario, fecha, hora, ip, estado, editable) VALUES  ('$id', '$identificador', '$centro', '$nit', '$departamento', '$ciudad', '$nombre', '$direccion', '$usuario','$fecha', '$hora', '$ip', '1', '1' ) ON DUPLICATE KEY UPDATE departamento = '$departamento', ciudad = '$ciudad', nombre = '$nombre', direccion = '$direccion' ";
			$stmt = Conexion::conectar()->prepare($sqlt);
			if($stmt -> execute()){
				$a = new EmpresaModel;
				$respuesta = $a->updateContacto($identificador, $usuario, $ncontacto, $tcontacto, $correo, $id);
			}
	}else{
			$a = new EmpresaModel;
			$respuesta = $a->updateContacto($identificador, $usuario, $ncontacto, $tcontacto, $correo, $id);	
 	}
}
//$stmt -> Conexion::close();	 
return true;
}

 public static function traerDepto($idDepto){
   //require_once "conexion.php";
   $respuesta = '1';
   $lista = '';
   $sqlt = "SELECT id, depto FROM deptos WHERE id = '$idDepto'";
   $stmt = Conexion::conectar()->prepare($sqlt);
		if($stmt -> execute()){
			$registros = $stmt->fetchAll();	
			foreach ($registros as $key => $value) {
				return $value['depto'];
			}			
		}	
 }	

 public static function traerCiudad($idCiudad){
   //require_once "conexion.php";
   $respuesta = '1';
   $lista = '';
   $sqlt = "SELECT id, ciudad FROM ciudades WHERE id = '$idCiudad'";
   $stmt = Conexion::conectar()->prepare($sqlt);
		if($stmt -> execute()){
			$registros = $stmt->fetchAll();	
			foreach ($registros as $key => $value) {
				return $value['ciudad'];
			}			
		}
 }

 public static function validarEmpresa($nit){
    $lista = '';
   $respuesta = '1';
   $sqlt = "SELECT e.nombre enombre, e.id, id, e.direccion edireccion, e.departamento, e.ciudad, e.sofia sofia FROM empresas e WHERE e.nit = '$nit';";
   $stmt = Conexion::conectar()->prepare($sqlt);
   //$stmt -> bindParam(":idDepto", $idDepto, PDO::PARAM_STR);
   $stmt->execute();
	if($stmt->rowCount() > 0){
	$respuesta = '1';
	$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value) {
			    $a = new EmpresaModel;
			    $id = $value['id'];
			    $sofia = $value['sofia'];
				$nombre = html_entity_decode($value['enombre']);
				$direccion = html_entity_decode($value['edireccion']);
				$idDepto = $value['departamento'];
				$idCiudad = $value['ciudad'];
				$departamento = $a->traerDepto($idDepto);
				$ciudad = $a->traerCiudad($idCiudad);
				  $newdata =  array (
						'respuesta' => $respuesta,
						'id'=>$id,
						'nit' => $nit,			
						'empresa' => $nombre,
						'direccion' => $direccion,
						'sofia' => $sofia,
						'idDepto' => $idDepto,
						'idCiudad' => $idCiudad,
			        );
        }
    }else{
		$newdata =  array (
		  'respuesta' => '0' 
        );
    }  
	$arrDatos[] = $newdata;   
	echo json_encode($arrDatos);
   }
   
 public static function editEmpresa($id){
    $lista = '';
   //require_once "conexion.php";
   $respuesta = '1';
   $sqlt = "SELECT e.nombre enombre, e.nit, nit, e.direccion edireccion, c.nombre cnombre, e.departamento, e.ciudad, c.telefono ctelefono, c.correo ccorreo FROM empresas e INNER JOIN contactos c ON e.identificador = c.idempresa WHERE e.id = '$id' ORDER BY e.nombre ASC";
   $stmt = Conexion::conectar()->prepare($sqlt);
   //$stmt -> bindParam(":idDepto", $idDepto, PDO::PARAM_STR);
	if($stmt -> execute()){
	$respuesta = '1';
	$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value) {
			    $a = new EmpresaModel;
			    $nit = htmlentities($value['nit']);
			    $nombre = $value['enombre'];
				$nombre = htmlentities($nombre);
				$direccion = htmlentities($value['edireccion']); 
				$cnombre = htmlentities($value['cnombre']);
				$ctelefono = htmlentities($value['ctelefono']);
				$ccorreo = htmlentities($value['ccorreo']);
				$idDepto = $value['departamento'];
				$idCiudad = $value['ciudad'];
				$departamento = $a->traerDepto($idDepto);
				$ciudad = $a->traerCiudad($idCiudad);
				  $newdata =  array (
						'respuesta' => $respuesta,
						'id'=>$id,
						'nit' => $nit,			
						'empresa' => $nombre,
						'direccion' => $direccion,
						'nombre' => $cnombre,
						'telefono' => $ctelefono,
						'correo' => $ccorreo,
						'idDepto' => $idDepto,
						'idCiudad' => $idCiudad,
			        );
        }
    }else{
		$newdata =  array (
			'respuesta' => '0' 
        );
    }  
	$arrDatos[] = $newdata;   
	echo json_encode($arrDatos);
  }

 public static function listEmpresa(){
   //session_start();	
   $lista = '';
   $respuesta = '1';

   $lista = '';
   if(isset($_SESSION['prc_idusuario'])){ 
   	   $usuario = $_SESSION['prc_ciuser'];
   	   $centro = $_SESSION['prc_centro'];
		   $sqlt = "SELECT e.id id, e.identificador identificador, e.nombre enombre, e.direccion edireccion, c.nombre cnombre, e.departamento, e.ciudad, c.telefono ctelefono, c.correo ccorreo FROM empresas e INNER JOIN contactos c ON e.identificador = c.idempresa WHERE e.centro = '$centro' AND e.estado = '1' AND c.idusuario = '$usuario' ORDER BY e.nombre ASC";
		   $stmt = Conexion::conectar()->prepare($sqlt);
		   //$stmt -> bindParam(":idDepto", $idDepto, PDO::PARAM_STR);
			if($stmt -> execute()){
			$respuesta = '1';
			$registros = $stmt->fetchAll();	
		 	$lista .='<div class="container-fluid">';
			$lista .=' <div class="row">';
				foreach ($registros as $key => $value) {
				$id = $value['id'];
				$identificador = $value['identificador'];
				$nombre = html_entity_decode($value['enombre']);
				$direccion = html_entity_decode($value['edireccion']);
				$cnombre = html_entity_decode($value['cnombre']);
				$ctelefono = html_entity_decode($value['ctelefono']);
				$ccorreo = html_entity_decode($value['ccorreo']);
				$idDepto = $value['departamento'];
				$idCiudad = $value['ciudad'];
				$a = new EmpresaModel;
				$departamento = $a->traerDepto($idDepto);
				$ciudad = $a->traerCiudad($idCiudad);
				$lista .='<div class="col-sm-12 col-md-4">';
				$lista .='<div class="card">';
				$lista .= '  <div class="card-body">';
				$lista .= '    <h5 class="card-title">';
				$lista .= '    <p class="p-2 mb-2 bg-secondary text-white">'.$nombre.'</p>';
				$lista .= '    </h5>';
				$lista .= '    <h6 class="card-subtitle mb-2 text-muted">'.$direccion.'</h6>';
				$lista .= '    <small class="text-muted">'.$ciudad.' ('.$departamento.')</small><hr>';
				//$lista .= '    <h6 class="text-muted">Mi contacto</h6><hr>';
				$lista .= '    <h6 class="text-muted h6">'.$cnombre.'</h6>';
				$lista .= '    <h6 class="text-muted">'.$ctelefono.'</h6>';
				$lista .= '    <p class="text-muted" style="font-size: 0.7rem"><small>'.$ccorreo.'</small></p>';	
				$lista .= '    <hr>';
				$lista .= '    </h6>';
				$lista .= '    <p class="card-text"></p>';
				$lista .= ' <div class="btn-group btn-group-sm" role="group" aria-label="...">';
				$lista .= ' <button type="button" onClick="traerempresaedit('.$id.');" '; 
				$lista .= '  class="btn btn-sm btn-outline-info">Contacto</button>';
				$lista .= '<a  href="'.SERVERURL.'planeacion/empresas/formaciones/'.$identificador.'/"'; 
				$lista .= '" class="btn btn-sm btn-outline-info">';
				$lista .= 'Formaciones';
				$lista .= '</a>';
				$lista .= '<button type="button" class="btn btn-sm btn-outline-warning">Quitar</button>';
				$lista .= '</div>';
				$lista .= '  </div>';
				$lista .= '</div>';
		        $lista .= '</div>'; //col
		        }

		        $lista .= '<script>';
		        $lista .= '$(document).ready(function() {';
				$lista .= '	    var heights = $(".card").map(function() {';
				$lista .= '	        return $(this).height();';
				$lista .= '	    }).get(),';
				$lista .= '	    maxHeight = Math.max.apply(null, heights);';
				$lista .= '	    $(".card").height(maxHeight);';

				$lista .= '	    heights = $(".card-title").map(function() {';
				$lista .= '	        return $(this).height();';
				$lista .= '	    }).get(),';
				$lista .= '	    maxHeight = Math.max.apply(null, heights);';
				$lista .= '	    $(".card-title").height(maxHeight);';

				$lista .= '	    heights = $(".card-subtitle").map(function() {';
				$lista .= '	        return $(this).height();';
				$lista .= '	    }).get(),';
				$lista .= '	    maxHeight = Math.max.apply(null, heights);';
				$lista .= '	    $(".card-subtitle").height(maxHeight);';
				
				$lista .= '	});';		
		        $lista .= '</script>';
		                //$stmt -> Conexion::close();
		    }    

			$lista .= '</div>'; //row
			$lista .= '</div>';
    }
		return $lista; //container
    }

    public function updateContacto($identificador, $idusuario, $nombre, $telefono, $correo, $idEmpresa){
		date_default_timezone_set('America/Bogota'); 
		$ip = $_SERVER["REMOTE_ADDR"]; 
		$fecha = date("Y-m-d");
		$hora = date('H:i:s'); 
		$centro = $_SESSION['prc_centro'];		
    	if($idEmpresa !== '0'){
    		$sqlt = "UPDATE contactos SET estado = '0' WHERE centro = '$centro' AND idempresa = '$idEmpresa' AND idusuario = '$idusuario'";
	    		$stmt = Conexion::conectar()->prepare($sqlt);
				if($stmt -> execute()){
						$respuesta = '1';
				}
    	}
		$sqlt = "INSERT INTO contactos (centro, idempresa, idusuario, nombre, telefono, correo, fecha, hora, ip, estado) VALUES  ('$centro', '$identificador', '$idusuario', '$nombre', '$telefono', '$correo','$fecha','$hora','$ip','1') ON DUPLICATE KEY UPDATE nombre = '$nombre', telefono = '$telefono', correo = '$correo'";
			$stmt = Conexion::conectar()->prepare($sqlt);
			if($stmt -> execute()){
				        $respuesta = '1';
			}
		return $respuesta;
    }

		public function updateFichas($datos){
			return var_dump($datos);


		}


	public function __destruct(){
		    //$stmt -> Conexion::close();
	}
}

