<?php
require_once "conexion.php";
date_default_timezone_set('America/Bogota');

$fecha = date("Y-m-d");
$hora = date('H:i:s');

class FormacionModel{

 public function __construct() {
	//require_once "conexion.php";
}
 public function decode_entities($text){
    return html_entity_decode($text);
}
public function selectDepto(){
   $respuesta = '1';
   $lista = '';
   $sqlt = "SELECT id, depto FROM deptos ORDER BY depto ASC";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
	if($stmt->rowCount() > 0){
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
   $stmt -> execute();
	if($stmt->rowCount() > 0){
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

public static function valRadicado(){
	$tabla = '';
	$opciones = '';
	if(isset($_SESSION['prc_idusuario'])){
	$centro = $_SESSION['prc_centro'];
	$sqlt = "SELECT fc.numero,  fc.onbase, fc.val_onbase, fc.idempresa idempresa,cr.nombre coordinacion, fc.codempresa, fc.controlada, fc.id idficha, fc.lugar, fc.direccion, fc.naprendices, fr.codigo, fr.nombre, fr.horas, us.nombre instructor, us.id idinstructor,  us.bloqueado bloqueado, be.nestado, be.estado estado, be.fecha, em.nombre empresa, em.id, em.identificador idempresa, cd.ciudad, fc.finicia, fc.ffinaliza, ct.validado, ct.nombre ctnombre, ct.telefono cttelefono, ct.correo ctcorreo FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN empresas em ON fc.idempresa = em.id  INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN bitacoraestados be ON fc.id = be.idficha INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id INNER JOIN contactos ct ON em.identificador = ct.idempresa AND us.identificador = ct.idusuario WHERE fc.historico = '0' AND fc.estado = be.estado  AND fc.ccentro = '$centro' AND be.visible = '1' ORDER BY fc.numero ASC";
	$stmt = Conexion::conectar()->prepare($sqlt);
	$stmt -> execute();
	if($stmt->rowCount() > 0){
		$respuesta = '1';
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value) {
			$onbase = $value['onbase'];
			$idficha = $value['idficha'];
			$val_onbase = $value['val_onbase'];
			if($val_onbase == '1'){
				$nval_onbase = 'Validado';
				$sval_onbase = 'btn-success';
			}else{
				$nval_onbase = 'Pendiente';
				$sval_onbase = 'btn-default';
			}
			$ctnombre = html_entity_decode(strtolower($value['ctnombre']));
			$ctnombre = ucwords($ctnombre);
			$cttelefono = $value['cttelefono'];
			$ctcorreo = $value['ctcorreo'];
			$empresa = $value['empresa'];
			$idempresa = $value['idempresa'];
			$coordinacion = $value['coordinacion'];
			$instructor = html_entity_decode(strtolower($value['instructor']));
			$instructor = '<span style=\"color:red;\">'.ucwords($instructor).'</span>';
			$idinstructor = $value['idinstructor'];
			$bloqueado = $value['bloqueado'];
			$ciudad = $value['ciudad'];
			$lugar = $value['lugar'];
			$direccion = $value['direccion'];
			$numero = $value['numero'];
			$nombre = html_entity_decode(strtolower($value['nombre']));
			$nombre = ucwords($nombre);
			$horas = $value['horas'];
			$finicia = $value['finicia'];
			$ffinaliza = '<span style=\"color:blue;\">'.$value['ffinaliza'].'</span>';
			$estado = $value['estado'];
			$nestado = $value['nestado'];
			$bloqueado = $value['bloqueado'];
			$estadob = '';
			if($bloqueado == '1'){
				$estadob = 'btn-success';
			}else{
				$estadob = 'btn-danger';
			}

             $opciones = '<div class=\"btn-group\" role=\"group\" aria-label=\"Basic example\">';
	        if($estado > 2) {
			$opciones .='<button type=\"button\" id=\"btvhorario'.$idficha.'\" onClick=\"verProgramacion(\''.$idficha.'\', \''.$numero.'\');\"  class=\"btn btn-info btn-sm\"><i class=\"far fa-calendar-alt\"></i></button>';
			}else{
			$opciones .='<button type=\"button\" class=\"btn btn-default btn-sm\"><i class=\"far fa-calendar-alt\"></i></button>';
				}
			$opciones .='<button type=\"button\" onClick=\"verbitacora(\''.$idficha.'\');\" class=\"btn btn-info btn-sm\"><i class=\"fas fa-list-ol\"></i></button><button id=\"btnvalidador'.$idficha.'\" onClick=\"validadoRadicado(\''.$idficha.'\',\''.$val_onbase.'\');\" type=\"button\" class=\"btn '.$sval_onbase.' btn-sm\"><i class=\"fas fa-check-square\"></i></button><button  onClick=\"preNoConfirmado('.$idficha.');\" type=\"button\" id=\"btvnotificar'.$idficha.'\" class=\"btn btn-warning btn-sm\"><i class=\"fas fa-exclamation-triangle\"></i></button><button type=\"button\" id=\"btnbloquear'.$idficha.'\" onClick=\"instruBloquear(\''.$idinstructor.'\',\''.$bloqueado.'\');\" class=\"btn '.$estadob.' btn-sm\"><i class=\"fas fas fa-chalkboard-teacher\"></i></button><button type=\"button\" id=\"btnbloquear'.$idficha.'\" onClick=\"bodyRadicado('.$idficha.');\" class=\"btn btn-info btn-sm\"><i class=\"fab fa-creative-commons-share\"></i></button>';
			$opciones .='</div>';
			$tabla .='{"onbase":"'.$onbase.'","val_onbase":"'.$nval_onbase.'","ctnombre":"'.$ctnombre.'","cttelefono":"'.$cttelefono.'","ctcorreo":"'.$ctcorreo.'","empresa":"'.$empresa.'","coordinacion":"'.$coordinacion.'","instructor":"'.$instructor.'","ciudad":"'.$ciudad.'","lugar":"'.$lugar.'","direccion":"'.$direccion.'","numero":"'.$numero.'","nombre":"'.$nombre.'","horas":"'.$horas.'","finicia":"'.$finicia.'","ffinaliza":"'.$ffinaliza.'","nestado":"'.$nestado.'","opciones":"'.$opciones.'"},';
		}
	 }
	}
	$tabla = substr($tabla,0, strlen($tabla) - 1);
	return '{"data":['.$tabla.']}';
}

 public static function validadoRadicado($datos){
  	$idficha = $datos['idficha'];
 	$nestado = $datos['nestado'];
	$sqlt = "UPDATE fcaracterizacion SET val_onbase = '$nestado' WHERE id = '$idficha'";
	    $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
	if($stmt->rowCount() > 0){
			$respuesta = '1';
	      } else{
	    	$respuesta = '0';
	    }
	$newdata =  array (
	'respuesta' => $respuesta,
	'sql' => $sqlt
	);
	$arrDatos[] = $newdata;
	echo json_encode($arrDatos);
 }

 public static function instruBloquear($datos){
 include_once "../../routes/config.php";
$ruta = SERVERURL;
 	$idinstructor = $datos['idinstructor'];
 	$nestado = $datos['nestado'];
	$sqlt = "UPDATE usuarios SET bloqueado = '$nestado' WHERE id = '$idinstructor'";
	    $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
	if($stmt->rowCount() > 0){
			$respuesta = '1';
	      } else{
	    	$respuesta = '0';
	    }
	$newdata =  array (
	'respuesta' => $respuesta,
	'ruta' => $ruta
	);
	$arrDatos[] = $newdata;
	echo json_encode($arrDatos);
 }


public static function tablaCursos($datos){
	$idficha = $datos['idficha'];
	$idempresa = $datos['idempresa'];
	$tabla = '';
	if(isset($_SESSION['prc_idusuario'])){
	$centro = $_SESSION['prc_centro'];
	$sqlt = "SELECT id, codigo, version, nombre, estado, horas FROM formaciones WHERE nivel = '0' AND estado = '1' AND centro = '$centro' ORDER BY nombre ASC";
	$stmt = Conexion::conectar()->prepare($sqlt);
	$stmt -> execute();
	if($stmt->rowCount() > 0){
		$respuesta = '1';
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value) {
			$idcurso = $value['id'];
			$codigo = $value['codigo'];
			$nombre = $value['nombre'];
			$version = $value['version'];
			$horas = $value['horas'];
			$estado = $value['estado'];
			if($estado == '1'){
				$estado = 'Ejecución';
			}
			$seleccionar = '<button onClick=\"selCurso('.$idficha.','.$idcurso.','.$idempresa.','.$horas.');\" type=\"button\" class=\"btn btn-outline-success\"><i class=\"fas fa-check\"></i></button>';
			$tabla .='{"codigo":"'.$codigo.'","nombre":"'.$nombre.'","version":"'.$version.'","horas":"'.$horas.'","estado":"'.$estado.'","acciones":"'.$seleccionar.'"},';
		}
	}
	}
	$tabla = substr($tabla,0, strlen($tabla) - 1);
	return '{"data":['.$tabla.']}';
}
/******************************************/
public function noconfirmadoRadicado($datos){
	$idficha = $datos['idficha'];
	$explicacion = $datos['explicacion'];
		date_default_timezone_set('America/Bogota');
		$ip = $_SERVER["REMOTE_ADDR"];
		$fecha = date("Y-m-d");
		$hora = date('H:i:s');
		$explicacion = htmlentities($datos['explicacion']);
		//$centro = $datos['centro'];
		//$idempresa = $datos['idempresa'];
		//$idus = $datos['idusuario'];

		if(isset($_SESSION['prc_idusuario'])){
			$idusuario = $_SESSION['prc_idusuario'];
			$respuesta = '0';
			$sqlt = "UPDATE fcaracterizacion SET val_onbase = '0' WHERE id = '$idficha'";
	    		$stmt = Conexion::conectar()->prepare($sqlt);
	    		$stmt -> execute();
	    		$result = $stmt->rowCount();
				//if($result > 0){
				  //$respuesta = '1';
				  $a = new FormacionModel();
				  $respuesta = $a -> notificaRadicadoNoConfirmado($idficha, $explicacion);
				//}else{
					//$respuesta = '0';
				//}
			}else{
				$respuesta = '5';
			}
	      $newdata =  array (
	       'respuesta' => $respuesta,
	       'texto' => $texto
	     );
	     $arrDatos[] = $newdata;
	 echo json_encode($arrDatos);
}

public function notificaRadicadoNoConfirmado($idficha, $explicacion){
$lista ='';
$sqlt = "SELECT fc.numero, fc.ccentro, cr.id idcoordinacion, cr.nombre coordinacion, fc.codempresa, fc.controlada, fc.id id, fc.lugar, fc.direccion, fc.naprendices, fr.codigo fcodigo, fr.nombre formacion, fr.horas, us.nombre instructor, us.identificador idusuario, us.correosena, us.correootro, be.nestado, be.estado estado, be.fecha, em.nombre empresa, em.id, em.identificador idempresa, cd.ciudad, fc.finicia, fc.ffinaliza, ct.validado, ct.nombre ctnombre, ct.telefono cttelefono, ct.correo ctcorreo FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN empresas em ON fc.idempresa = em.id  INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN bitacoraestados be ON fc.id = be.idficha AND fc.estado = be.estado INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id INNER JOIN contactos ct ON em.identificador = ct.idempresa AND us.identificador = ct.idusuario WHERE  fc.id = '$idficha' AND fc.estado = be.estado AND be.visible = '1'  ORDER BY fc.id ASC";
	$stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
				$numero = $value['numero'];
				$idcoordinacion = $value['idcoordinacion'];
				$coordinacion = $value['coordinacion'];
				$direccion = $value['direccion'];
				$naprendices = $value['naprendices'];
				$fcodigo = $value['fcodigo'];
				$formacion = $value['formacion'];
				$lugar = $value['lugar'];
				$direccion = $value['direccion'];
				$naprendices = $value['naprendices'];
				$horas = $value['horas'];
				$instructor = $value['instructor'];
				$nestado = $value['nestado'];
				$empresa = $value['empresa'];
				$ciudad = $value['ciudad'];
				$finicia = $value['finicia'];
				$ffinaliza = $value['ffinaliza'];
				$ctnombre = $value['ctnombre'];
				$cttelefono = $value['cttelefono'];
				$ctcorreo = $value['ctcorreo'];
				$correosena = $value['correosena'];
				$correootro = $value['correootro'];
				$ccentro = $value['ccentro'];
				$idcoordinacion = $value['idcoordinacion'];
      }

	$asunto = 'Novedad al Validar Radicado Empresa '.$empresa;
	$cuerpo = '
	<html>
	<head>
	<title>NOVEDAD EN LA VALIDACIÓN  DE LA SOLICITUD</title>
	</head>
	<body>
    <p>Resultado del proceso de validación de datos registrados por el usuario de <b>'.$instructor.' </b> quien solicita la publicación del curso <b>'.$formacion.'</b> de '.$horas.' horas para la empresa <b>'.$empresa.'</b> cuya solicitud se encuentra en este momento en estado <b>'.$nestado.'</b>, y tiene como fecha de inicio <b>'.$finicia.'<b> y fecha de fin <b>'.$ffinaliza.'</b><hr>
         <h3>Datos del contacto registrados por el usuario en la solicitud: </h3><hr>
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">DATO</th>
			      <th scope="col">DESCRIPCION</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
					<td>EMPRESA</td><td>'.$empresa.'</td>
				</tr>
			    <tr>
					<td>CONTACTO</td><td>'.$ctnombre.'</td>
				</tr>
			    <tr>
					<td>TELEFONO</td><td>'.$cttelefono.'</td>
				</tr>
			    <tr>
					<td>CORREO</td><td>'.$ctcorreo.'</td>
				</tr>
			    <tr>
					<td>LUGAR</td><td>'.$lugar.'</td>
				</tr>
			    <tr>
					<td>DIRECCION</td><td>'.$direccion.'</td>
			    </tr>
			    <tr>
					<td>APRENDICES</td><td>'.$naprendices.'</td>
			    </tr>
			  </tbody>
			</table>

	<hr>
	<h2>RESULTADO:</h2><br>
	'.$lista.'
      <p><span style="color:blue">'.$explicacion.'</span><p><br>
      <p>Este correo es informativo y fue generado de forma automática, <b>no es necesario responder este correo.</b><p><br>
	</body>
	</html>
	';
	//para el envío en formato HTML
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	//dirección del remitente
	$headers .= "From: Programacion Centro <noreply@senagalan.com>\r\n";
	//dirección de respuesta, si queremos que sea distinta que la del remitente
	$headers .= "Reply-To: Programacion Centro <noreply@senagalan.com>\r\n";
	//ruta del mensaje desde origen a destino
	$headers .= "Return-path: Programacion Centro <noreply@senagalan.com>\r\n";
	//direcciones que recibirán copia
	//$headers .= "Cco: jarroyaves@sena.edu.co\r\n";
	//direcciones que recibirán copia oculta
	$headers .= "Bcc: erpprogramacion@gmail.com\r\n";
	//mail($correosena.'@sena.edu.co',$asunto,$cuerpo,$headers);
	$a = new FormacionModel();
	$ccoordinador = $a-> traerCorreoCoordinador($ccentro,$coordinacion);
	mail($ccoordinador.'@sena.edu.co',$asunto,$cuerpo,$headers);
	mail($correootro,$asunto,$cuerpo,$headers);
	//Envair Mail Fin
  }
  return '1';
}



/******************************************/
public function noconformeContactos($datos){
		date_default_timezone_set('America/Bogota');
		$ip = $_SERVER["REMOTE_ADDR"];
		$fecha = date("Y-m-d");
		$hora = date('H:i:s');
		$explicacion = htmlentities($datos['explicacion']);
		$centro = $datos['centro'];
		$idempresa = $datos['idempresa'];
		$idus = $datos['idusuario'];

		if(isset($_SESSION['prc_idusuario'])){
			$idusuario = $_SESSION['prc_idusuario'];
			$respuesta = '0';
			$sql1 = "UPDATE contactos SET validado = '0', fecha = '$fecha', hora = '$hora', vusuario = '$idusuario'  WHERE centro = '$centro' AND idempresa = '$idempresa' AND idusuario = '$idus'";
	    		$stmt = Conexion::conectar()->prepare($sql1);
	    		$stmt -> execute();
	    		$result = $stmt->rowCount();
				if($result > 0){
				  $respuesta = '1';
				  $a = new FichasModel();
				  $texto = $a -> notificarNoconforme($centro,$idempresa,$idus, $explicacion);
				}else{
					$respuesta = '0';
				}
			}else{
				$respuesta = '5';
			}
	      $newdata =  array (
	       'respuesta' => $respuesta,
	       'texto' => $texto
	     );
	     $arrDatos[] = $newdata;
	 echo json_encode($arrDatos);
}

public function notificarNoconforme($centro,$idempresa,$idusuario, $explicacion){
$lista ='';
$sqlt = "SELECT fc.numero, cr.id idcoordinacion, cr.nombre coordinacion, fc.codempresa, fc.controlada, fc.id id, fc.lugar, fc.direccion, fc.naprendices, fr.codigo fcodigo, fr.nombre formacion, fr.horas, us.nombre instructor, us.identificador idusuario, be.nestado, be.estado estado, be.fecha, em.nombre empresa, em.id, em.identificador idempresa, cd.ciudad, fc.finicia, fc.ffinaliza, ct.validado, ct.nombre ctnombre, ct.telefono cttelefono, ct.correo ctcorreo FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN empresas em ON fc.idempresa = em.id  INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN bitacoraestados be ON fc.id = be.idficha AND fc.estado = be.estado INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id INNER JOIN contactos ct ON em.identificador = ct.idempresa AND us.identificador = ct.idusuario WHERE  fc.ccentro = '$centro' AND ct.idempresa = '$idempresa' AND ct.idusuario = '$idusuario' AND fc.estado = be.estado AND be.visible = '1'  ORDER BY fc.id ASC";
	$stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
				$numero = $value['numero'];
				$idcoordinacion = $value['idcoordinacion'];
				$coordinacion = $value['coordinacion'];
				$direccion = $value['direccion'];
				$naprendices = $value['naprendices'];
				$fcodigo = $value['fcodigo'];
				$formacion = $value['formacion'];
				$lugar = $value['lugar'];
				$direccion = $value['direccion'];
				$naprendices = $value['naprendices'];
				$horas = $value['horas'];
				$instructor = $value['instructor'];
				$nestado = $value['nestado'];
				$empresa = $value['empresa'];
				$ciudad = $value['ciudad'];
				$finicia = $value['finicia'];
				$ffinaliza = $value['ffinaliza'];
				$ctnombre = $value['ctnombre'];
				$cttelefono = $value['cttelefono'];
				$ctcorreo = $value['ctcorreo'];
      }

	$asunto = 'Novedad al Validar Radicado Empresa '.$empresa;
	$cuerpo = '
	<html>
	<head>
	<title>NOVEDAD EN LA VALIDACIÓN EL RADICADO DE LA SOLICITUD</title>
	</head>
	<body>
    <p>Resultado del proceso de validación de datos registrados por el usuario de <b>'.$instructor.' </b> quien solicita la publicación del curso <b>'.$formacion.'</b> de '.$horas.' horas para la empresa <b>'.$empresa.'</b> cuya solicitud se encuentra en este momento en estado <b>'.$nestado.'</b>, y tiene como fecha de inicio <b>'.$finicia.'<b> y fecha de fin <b>'.$ffinaliza.'</b><hr>
         <h3>Datos del contacto registrados por el usuario en la solicitud: </h3><hr>
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">DATO</th>
			      <th scope="col">DESCRIPCION</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
					<td>EMPRESA</td><td>'.$empresa.'</td>
				</tr>
			    <tr>
					<td>CONTACTO</td><td>'.$ctnombre.'</td>
				</tr>
			    <tr>
					<td>TELEFONO</td><td>'.$cttelefono.'</td>
				</tr>
			    <tr>
					<td>CORREO</td><td>'.$ctcorreo.'</td>
				</tr>
			    <tr>
					<td>LUGAR</td><td>'.$lugar.'</td>
				</tr>
			    <tr>
					<td>DIRECCION</td><td>'.$direccion.'</td>
			    </tr>
			    <tr>
					<td>APRENDICES</td><td>'.$naprendices.'</td>
			    </tr>
			  </tbody>
			</table>

	<hr>
	<h2>RESULTADO:</h2><br>
	'.$lista.'
      <p><span style="color:blue">'.$explicacion.'</span><p><br>
      <p>Este correo es informativo y fue generado de forma automática, <b>no es necesario responder este correo.</b><p><br>
	</body>
	</html>
	';
	//para el envío en formato HTML
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	//dirección del remitente
	$headers .= "From: Programacion Centro <noreply@programacioncentro.com>\r\n";
	//dirección de respuesta, si queremos que sea distinta que la del remitente
	$headers .= "Reply-To: Programacion Centro <noreply@programacioncentro.com>\r\n";
	//ruta del mensaje desde origen a destino
	$headers .= "Return-path: Programacion Centro <noreply@programacioncentro.com>\r\n";
	//direcciones que recibirán copia
	//$headers .= "Cco: jarroyaves@sena.edu.co\r\n";
	//direcciones que recibirán copia oculta
	$headers .= "Bcc: erpprogramacion@gmail.com\r\n";
	mail($correosena.'@sena.edu.co',$asunto,$cuerpo,$headers);
	$a = new FichasModel();
	$ccoordinador = $a-> traerCorreoCoordinador($centro,$coordinacion);
	mail($ccoordinador.'@sena.edu.co',$asunto,$cuerpo,$headers);
	mail($correootro,$asunto,$cuerpo,$headers);
	//Envair Mail Fin
  }
  return $cuerpo;
}
/*****************************************************/

 public function selCurso($datos){
 	$idficha = $datos['idficha'];
 	$idcurso = $datos['idcurso'];
 	$horas = $datos['horas'];
	$sqlt = "UPDATE fcaracterizacion SET idprograma = '$idcurso', horas = '$horas',  validacion = '0', tvalidacion = '' WHERE id = '$idficha'";
	    $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
	if($stmt->rowCount() > 0){
			$respuesta = '1';
	      } else{
	    	$respuesta = '0';
	    }
	$newdata =  array (
	'respuesta' => $respuesta,
	'codigo'=>$sqlt
	);
	$arrDatos[] = $newdata;
	echo json_encode($arrDatos);
 }


 public function traerDepto($idDepto){
   //require_once "conexion.php";
   $respuesta = '1';
   $lista = '';
   $sqlt = "SELECT id, depto FROM deptos WHERE id = '$idDepto'";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
	if($stmt->rowCount() > 0){
			$registros = $stmt->fetchAll();
			foreach ($registros as $key => $value) {
				return $value['depto'];
			}
		}
 }

 public function traerCiudad($idCiudad){
   //require_once "conexion.php";
   $respuesta = '1';
   $lista = '';
   $sqlt = "SELECT id, ciudad FROM ciudades WHERE id = '$idCiudad'";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
	if($stmt->rowCount() > 0){
			$registros = $stmt->fetchAll();
			foreach ($registros as $key => $value) {
				return $value['ciudad'];
			}
		}
 }


public static function nuevaofertaAbierta(){
	date_default_timezone_set('America/Bogota');
	$ip = $_SERVER["REMOTE_ADDR"];
	$fecha = date("Y-m-d");
	$hora = date('H:i:s');
	$respuesta = '0';
	if(!isset($_SESSION['prc_ciuser'])){
	     $respuesta =  '5';
	}else{
	$usuario = $_SESSION['prc_ciuser'];
	$idusuario = $_SESSION['prc_idusuario'];
	$ccentro = $_SESSION['prc_centro'];
	$coordinacion = $_SESSION['prc_coordinacion'];
	$formacion = new FormacionModel();
	$estadoUsuario = $formacion -> traerEstadoUsuario($usuario);
	$nempresa = 'Oferta Abierta';
	$idempresa =  '0';
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
		    $sqlt = "SELECT COUNT(*) as cuantos FROM fcaracterizacion WHERE identificador = '$cad'";
		    $stmt = Conexion::conectar()->prepare($sqlt);
	   $stmt -> execute();
		if($stmt->rowCount() > 0){
			  	$registros = $stmt->fetchAll();
					foreach ($registros as $key => $value) {
						$resultado = $value['cuantos'];
					}
		      } else{
		    	$resultado = 0;
		    }
		}
		$identificador = $cad;
		if($estadoUsuario == '1'){
			$sqlt = "INSERT INTO fcaracterizacion (identificador, idempresa, ofertaabierta, ccentro, coordinacion, idusuario, usuario, estado) VALUES  ('$identificador','$idempresa','S','$ccentro','$coordinacion','$idusuario','$usuario', '1')";
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
			if($stmt->rowCount() > 0){
				$respuesta = '1';
				$sqlt = "SELECT id FROM fcaracterizacion WHERE identificador = '$cad'";
				$stmt = Conexion::conectar()->prepare($sqlt);
				$stmt -> execute();
					if($stmt->rowCount() > 0){
				  	$registros = $stmt->fetchAll();
						foreach ($registros as $key => $value) {
							$id = $value['id'];
						}
					$sqlt = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$id', '$idusuario', 'Borrador', '$fecha', '$hora','Nueva ficha','1','$ip','1');";
					$stmt = Conexion::conectar()->prepare($sqlt);
					$stmt -> execute();
				  }
			}
     }else{
     	$respuesta = '3';
     }
	$newdata =  array (
	 'respuesta' => $respuesta
	);
	$arrDatos[] = $newdata;
	echo json_encode($arrDatos);
	//$stmt -> Conexion::close();
 }
}



public static function newFicha($datos){
date_default_timezone_set('America/Bogota');
$ip = $_SERVER["REMOTE_ADDR"];
$fecha = date("Y-m-d");
$hora = date('H:i:s');
$respuesta = '0';
if(!isset($_SESSION['prc_ciuser'])){
     $respuesta =  '5';
}else{
$usuario = $_SESSION['prc_ciuser'];
$idusuario = $_SESSION['prc_idusuario'];
$ccentro = $_SESSION['prc_centro'];
$coordinacion = $_SESSION['prc_coordinacion'];
$formacion = new FormacionModel();
$estadoUsuario = $formacion -> traerEstadoUsuario($usuario);
$nempresa = strtoupper(htmlentities($datos['nempresa']));
$idempresa =  $datos['idempresa'];
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
	    $sqlt = "SELECT COUNT(*) as cuantos FROM fcaracterizacion WHERE identificador = '$cad'";
	    $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
	if($stmt->rowCount() > 0){
		  	$registros = $stmt->fetchAll();
				foreach ($registros as $key => $value) {
					$resultado = $value['cuantos'];
				}
	      } else{
	    	$resultado = 0;
	    }
	}
	$identificador = $cad;
	if($estadoUsuario == '1'){
		$sqlt = "INSERT INTO fcaracterizacion (identificador, idempresa, ofertaabierta ,ccentro, coordinacion, idusuario, usuario, estado) VALUES  ('$identificador','$idempresa','N','$ccentro','$coordinacion','$idusuario','$usuario', '1')";
		$stmt = Conexion::conectar()->prepare($sqlt);
		$stmt -> execute();
		if($stmt->rowCount() > 0){
			$respuesta = '1';
			$sqlt = "SELECT id FROM fcaracterizacion WHERE identificador = '$cad'";
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
				if($stmt->rowCount() > 0){
			  	$registros = $stmt->fetchAll();
					foreach ($registros as $key => $value) {
						$id = $value['id'];
					}
				$sqlt = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$id', '$idusuario', 'Borrador', '$fecha', '$hora','Nueva ficha','1','$ip','1');";
				$stmt = Conexion::conectar()->prepare($sqlt);
				$stmt -> execute();
			  }
		}
     }else{
     	$respuesta = '3';
     }

	$newdata =  array (
	'respuesta' => $respuesta
	);
	$arrDatos[] = $newdata;
	echo json_encode($arrDatos);
	//$stmt -> Conexion::close();
}
}

public static function listOfertaAbierta(){
$idempresa = '0';
$respuesta = '0';
if(!isset($_SESSION['prc_ciuser'])){
     $respuesta =  '5';
}else{
$usuario = $_SESSION['prc_ciuser'];
$idusuario = $_SESSION['prc_idusuario'];
$ccentro = $_SESSION['prc_centro'];
   $lista = '';
   $respuesta = '1';
   $lista = '';
   $nDepto = '';
   $nCiudad = '';
   $sqlt = "SELECT id, ccentro, coordinacion, identificador, numero, idempresa, codempresa, idprograma, finicia, ffinaliza, naprendices, idusuario, lugar, pespeciales, direccion, departamento, ciudad, alarmada, estado, tvalidacion, validacion, onbase, val_onbase FROM fcaracterizacion WHERE estado != '0' AND ofertaabierta = 'S' AND usuario = '$usuario' AND historico = '0' ORDER BY id DESC;";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
	if($stmt->rowCount() > 0){
	$respuesta = '1';
	$registros = $stmt->fetchAll();
	$lista .='<div class="container-fluid">';
	$lista .=' <div class="row">';
	$formacion = new FormacionModel();
	foreach ($registros as $key => $value) {
		$id = $value['id'];
		$numero = $value['numero'];
		$codempresa = $value['codempresa'];
		$onbase = $value['onbase'];
		$val_onbase = $value['val_onbase'];
		$idprograma = $value['idprograma'];
		$finicia = $value['finicia'];
		$ffinaliza = $value['ffinaliza'];
		$estado = $value['estado'];
		$lugar = $value['lugar'];
		$tvalidacion = $value['tvalidacion'];
		$validacion = $value['validacion'];
		$direccion = $value['direccion'];
		$pespeciales = $value['pespeciales'];
		$identificador = $value['identificador'];
		$naprendices = $value['naprendices'];
		$idDepto = $value['departamento'];
		$idCiudad = $value['ciudad'];
		$alarmada = $value['alarmada'];
		if($idDepto != '0'){
			$nDepto = $formacion -> traerDepto($idDepto);
		}
		if($idCiudad != '0'){
			$nCiudad = $formacion -> traerCiudad($idCiudad);
		}
		$idCiudad = $value['ciudad'];
		$lista .='<div class="col-sm-12  col-md-4" id="formacion'.$id.'">';
		if($alarmada == '1'){
			$lista .='<div class="card card border-warning">';
			$lista .='	<div class="card-header bg-warning">';
	    }else{
	    	$lista .='<div class="card border-success">';
	    	$lista .='	<div class="card-header">';
		}

		$b = $formacion -> traerEvento($id, $estado,$alarmada);
		$f = $formacion -> traerformacion($idprograma);
		$p = $formacion -> traerpespecial($pespeciales);

		$lista .='<div id="nformacion" <h5 class="card-title">'.$f.'</h5></div>';
		if($estado < 3 && $validacion == '0'){
			$lista .='<button type="button" id="btnedficha'.$id.'"  onClick="tablaCursos('.$id.',\'0\');" class="btn-block  btn btn-outline-info btn-sm">Seleccionar Formación</button><br>';
	    }else{
	    	$lista .='<button type="button" id="btnedficha'.$id.'"   class="btn-block  btn btn-secondary btn-sm">Seleccionar Formación</button><br>';
	    }
	    $lista .='</div>'; //Header
	    $lista .='  <div class="card-body">';

		 $lista .='  <div class="tabla table-responsive">';
	     $lista .='<table class="table table-sm">
		<tbody>
		  <tr class="table-active">
		<td>Ficha</td>
		      <td>'.$numero.'</td>
		    </tr>
		    <tr class="table-active">
		      <td>Codigo empresa</td>
		      <td>'.$codempresa.'</td>
		    </tr>
		    <tr>
		      <td>Inicia</td>
		      <td>'.$finicia.'</td>
		    </tr>
		    <tr>
		      <td>Finaliza</td>
		      <td>'.$ffinaliza.'</td>
		    </tr>
		    <tr>
		      <td>Ciudad</td>
		      <td>'.$nCiudad.' ('.$nDepto.')</td>
		    </tr>
		    <tr>
		      <td>Lugar</td>
		      <td>'.$lugar.'</td>
		    </tr>
		    <tr>
		      <td>Direccion</td>
		      <td>'.$direccion.'</td>
		    </tr>
		    <tr>
		      <td>Aprendices</td>
		      <td>'.$naprendices.'</td>
		    </tr>
		    <tr>
		      <td>Programa</td>
		      <td>'.$p.'</td>
		    </tr>
		  </tbody>
		</table>
		</div>
		';
        $lista .='<div class="btn-group btn-group-sm mx-auto" role="group" aria-label="..." style="width: 100%;">';	//Grupo de botones
		switch ($estado) {
			case '1':
				$lista .='<button type="button" id="btneficha'.$id.'"  onClick="eliminarficha('.$id.');" class="btn btn-outline-danger btn-sm">Eliminar</button>';
				$lista .='<button type="button" id="btnedficha'.$id.'"  onClick="editarFicha('.$id.',\'0\','.$idDepto.','.$idCiudad.');" class="btn btn-outline-success btn-sm">Editar</button><br>';
				break;
			case '2':
			if($validacion == '0'){
				$lista .='<button type="button" id="btneficha'.$id.'"  onClick="elifichaconfirma('.$id.');" class="btn btn-outline-danger btn-sm">Eliminar</button>';
				$lista .='<button type="button" id="btnedficha'.$id.'"  onClick="editarFicha('.$id.',\'0\','.$idDepto.','.$idCiudad.');"  class="btn btn-outline-success btn-sm">Editar</button><br>';

				$lista .='<button type="button" id="btncal'.$id.'"  onClick="mostrarCalendario('.$id.');" class="btn btn-outline-success btn-sm">Horario <i class="far fa-calendar-alt"></i></button><br>';
				}
				break;
			default:
					    $lista .='<button type="button" id="btvhorario'.$id.'"  onClick="verProgramacion('.$id.','.$numero.');" class="btn-block  btn btn-info btn-sm">Ver Horario</button><br>';
				break;
		}


        $lista .='  </div>'; // Grupo de botones
        $lista .='  <div class="botvalenv">'; //Botones de validar y enviar
		$lista .=   $b; //Evento actuak
		if($estado < 3){
		  if($validacion == '0'){
				$lista .='<button type="button" id="btnsdficha'.$id.'"  onClick="solValidarFicha('.$id.','.$idempresa.');" class="btn-block  btn btn-info btn-sm">Validar y Enviar</button>';
						if($validacion == '0' AND strlen($tvalidacion)){
						  $lista .='<button type="button" onClick="verValidacion('.$id.','.$idempresa.');" class="btn btn-block btn-warning btn-sm"> Ver validación</button>';
						}
			    }else{
				$lista .='<button type="button" id="btnscficha'.$id.'"  onClick="solpublicarficha('.$id.',\'0\');" class="btn-block  btn btn-info btn-lg">Enviar</button>';
			 }
		}
	    $lista .='  </div>'; //Botones de validar y enviar
		$lista .='  </div>';
		$lista .='</div>';
		$lista .='</div>';
	}

	$lista .='</div>';
    $lista .='</div>
	    <script>
	    $(document).ready(function() {
	         var heights = $(".tabla").map(function() {
	             return $(this).height();
	         }).get(),
	         maxHeight = Math.max.apply(null, heights);
	         $(".tabla").height(maxHeight);

	         heights = $(".card-title").map(function() {
	             return $(this).height();
	         }).get(),
	         maxHeight = Math.max.apply(null, heights);
	         $(".card-title").height(maxHeight);

	         heights = $(".botvalenv").map(function() {
	             return $(this).height();
	         }).get(),
	         maxHeight = Math.max.apply(null, heights);
	         $(".botvalenv").height(maxHeight);
	     });
	    </script>';
    //$stmt -> Conexion::close();
    }
   return $lista; //container
   }
}



public static function listFormaciones($idempresa){
$respuesta = '0';
if(!isset($_SESSION['prc_ciuser'])){
     $respuesta =  '5';
}else{
$usuario = $_SESSION['prc_ciuser'];
$idusuario = $_SESSION['prc_idusuario'];
$ccentro = $_SESSION['prc_centro'];
   $lista = '';
   $respuesta = '1';
   $lista = '';
   $nDepto = '';
   $nCiudad = '';
   $sqlt = "SELECT id, ccentro, coordinacion, identificador, numero, idempresa, codempresa, idprograma, finicia, ffinaliza, naprendices, idusuario, lugar, pespeciales, direccion, departamento, ciudad, alarmada, estado, tvalidacion, validacion, onbase, val_onbase FROM fcaracterizacion WHERE estado != '0' AND idempresa = '$idempresa' AND usuario = '$usuario' AND historico = '0' ORDER BY id DESC;";
   $stmt = Conexion::conectar()->prepare($sqlt);
$stmt -> execute();
	if($stmt->rowCount() > 0){
	$respuesta = '1';
	$registros = $stmt->fetchAll();
	$lista .='<div class="container-fluid">';
	$lista .=' <div class="row">';
	$formacion = new FormacionModel();
	foreach ($registros as $key => $value) {
		$id = $value['id'];
		$numero = $value['numero'];
		$codempresa = $value['codempresa'];
		$onbase = $value['onbase'];
		$val_onbase = $value['val_onbase'];
		$idprograma = $value['idprograma'];
		$finicia = $value['finicia'];
		$ffinaliza = $value['ffinaliza'];
		$estado = $value['estado'];
		$lugar = $value['lugar'];
		$tvalidacion = $value['tvalidacion'];
		$validacion = $value['validacion'];
		$direccion = $value['direccion'];
		$pespeciales = $value['pespeciales'];
		$identificador = $value['identificador'];
		$naprendices = $value['naprendices'];
		$idDepto = $value['departamento'];
		$idCiudad = $value['ciudad'];
		$alarmada = $value['alarmada'];
		if($idDepto != '0'){
			$nDepto = $formacion -> traerDepto($idDepto);
		}
		if($idCiudad != '0'){
			$nCiudad = $formacion -> traerCiudad($idCiudad);
		}
		$idCiudad = $value['ciudad'];
		$lista .='<div class="col-sm-12  col-md-4" id="formacion'.$id.'">';
		if($alarmada == '1'){
			$lista .='<div class="card card border-warning">';
			$lista .='	<div class="card-header bg-warning">';
	    }else{
	    	$lista .='<div class="card border-success">';
	    	$lista .='	<div class="card-header">';
		}

		$b = $formacion -> traerEvento($id, $estado,$alarmada);
		$f = $formacion -> traerformacion($idprograma);
		$p = $formacion -> traerpespecial($pespeciales);

		$lista .='<div id="nformacion" <h5 class="card-title">'.$f.'</h5></div>';
		if($estado < 3 && $validacion == '0'){
			$lista .='<button type="button" id="btnedficha'.$id.'"  onClick="tablaCursos('.$id.','.$idempresa.');" class="btn-block  btn btn-outline-info btn-sm">Seleccionar Formación</button><br>';
	    }else{
	    	$lista .='<button type="button" id="btnedficha'.$id.'"   class="btn-block  btn btn-secondary btn-sm">Seleccionar Formación</button><br>';
	    }
	    $lista .='</div>'; //Header
	    $lista .='  <div class="card-body">';
			if(strlen($onbase) > 1){
				if($val_onbase == '1'){
					$lista .='<div id="nformacion" <span style="font-size: 0.8rem; color:green;">'.$onbase.'</span>&nbsp; <span class="badge badge-pill badge-success"><i class="fas fa-check"></i></span></div>';
				}else{
					$lista .='<div id="nformacion" <span style="font-size: 0.8rem; color:blue;">'.$onbase.'</span>&nbsp;&nbsp; <span class="badge badge-pill badge-info"><i class="far fa-clock"></i></span></div>';
				}
			}else{
				    $lista .='<div id="nformacion" <span style="font-size: 0.8rem; color:blue;">'.$onbase.'</span>&nbsp; <span class="badge badge-pill badge-warning">Falta radicar oficio de solicitud</span></div>';
			}
		 $lista .='  <div class="tabla table-responsive">';
	     $lista .='<table class="table table-sm">
		<tbody>
		  <tr class="table-active">
		<td>Ficha</td>
		      <td>'.$numero.'</td>
		    </tr>
		    <tr class="table-active">
		      <td>Codigo empresa</td>
		      <td>'.$codempresa.'</td>
		    </tr>
		    <tr>
		      <td>Inicia</td>
		      <td>'.$finicia.'</td>
		    </tr>
		    <tr>
		      <td>Finaliza</td>
		      <td>'.$ffinaliza.'</td>
		    </tr>
		    <tr>
		      <td>Ciudad</td>
		      <td>'.$nCiudad.' ('.$nDepto.')</td>
		    </tr>
		    <tr>
		      <td>Lugar</td>
		      <td>'.$lugar.'</td>
		    </tr>
		    <tr>
		      <td>Direccion</td>
		      <td>'.$direccion.'</td>
		    </tr>
		    <tr>
		      <td>Aprendices</td>
		      <td>'.$naprendices.'</td>
		    </tr>
		    <tr>
		      <td>Programa</td>
		      <td>'.$p.'</td>
		    </tr>
		  </tbody>
		</table>
		</div>
		';
        $lista .='<div class="btn-group btn-group-sm mx-auto" role="group" aria-label="..." style="width: 100%;">';	//Grupo de botones
		switch ($estado) {
			case '1':
				$lista .='<button type="button" id="btneficha'.$id.'"  onClick="eliminarficha('.$id.','.$idempresa.');" class="btn btn-outline-danger btn-sm">Eliminar</button>';
				$lista .='<button type="button" id="btnedficha'.$id.'"  onClick="editarFicha('.$id.','.$idempresa.','.$idDepto.','.$idCiudad.');" class="btn btn-outline-success btn-sm">Editar</button><br>';
				break;
			case '2':
			if($validacion == '0'){
				$lista .='<button type="button" id="btneficha'.$id.'"  onClick="elifichaconfirma('.$id.','.$idempresa.');" class="btn btn-outline-danger btn-sm">Eliminar</button>';
				$lista .='<button type="button" id="btnedficha'.$id.'"  onClick="editarFicha('.$id.','.$idempresa.','.$idDepto.','.$idCiudad.');" class="btn btn-outline-success btn-sm">Editar</button><br>';

				$lista .='<button type="button" id="btncal'.$id.'"  onClick="mostrarCalendario('.$id.','.$idempresa.');" class="btn btn-outline-success btn-sm">Horario <i class="far fa-calendar-alt"></i></button><br>';
				}
				break;
			default:
					    $lista .='<button type="button" id="btvhorario'.$id.'"  onClick="verProgramacion('.$id.','.$numero.');" class="btn-block  btn btn-info btn-sm">Ver Horario</button><br>';
				break;
		}


        $lista .='  </div>'; // Grupo de botones
        $lista .='  <div class="botvalenv">'; //Botones de validar y enviar
		$lista .=   $b; //Evento actuak
		if($estado < 3){
		  if($validacion == '0'){
				$lista .='<button type="button" id="btnsdficha'.$id.'"  onClick="solValidarFicha('.$id.','.$idempresa.');" class="btn-block  btn btn-info btn-sm">Validar y Enviar</button>';
						if($validacion == '0' AND strlen($tvalidacion)){
						  $lista .='<button type="button" onClick="verValidacion('.$id.','.$idempresa.');" class="btn btn-block btn-warning btn-sm"> Ver validación</button>';
						}
			    }else{
				$lista .='<button type="button" id="btnscficha'.$id.'"  onClick="solpublicarficha('.$id.','.$idempresa.');" class="btn-block  btn btn-info btn-lg">Enviar</button>';
			 }
		}

	    $lista .='  </div>'; //Botones de validar y enviar
		$lista .='  </div>';

		$lista .='</div>';

		$lista .='</div>';
	}

	$lista .='</div>';

    $lista .='</div>
	    <script>
	    $(document).ready(function() {
	         var heights = $(".tabla").map(function() {
	             return $(this).height();
	         }).get(),
	         maxHeight = Math.max.apply(null, heights);
	         $(".tabla").height(maxHeight);

	         heights = $(".card-title").map(function() {
	             return $(this).height();
	         }).get(),
	         maxHeight = Math.max.apply(null, heights);
	         $(".card-title").height(maxHeight);

	         heights = $(".botvalenv").map(function() {
	             return $(this).height();
	         }).get(),
	         maxHeight = Math.max.apply(null, heights);
	         $(".botvalenv").height(maxHeight);
	     });
	    </script>';
    //$stmt -> Conexion::close();
    }
   return $lista; //container
   }
}
#VALIDAR Y SOLICITAR LA CREACION DE FICHAS
public function solpublicarficha($idficha){
date_default_timezone_set('America/Bogota');
$ip = $_SERVER["REMOTE_ADDR"];
$fecha = date("Y-m-d");
$hora = date('H:i:s');
$respuesta = '0';
if(!isset($_SESSION['prc_ciuser'])){
     $respuesta =  '5';
}else{
$usuario = $_SESSION['prc_ciuser'];
$idusuario = $_SESSION['prc_idusuario'];
$ccentro = $_SESSION['prc_centro'];
$datos = array();
$correcto = 1;
$texto = new FormacionModel();
$sqlt = "SELECT finicia, coordinacion, controlada, idprograma, idempresa, lugar, direccion, naprendices FROM fcaracterizacion WHERE id = '$idficha'";
$stmt = Conexion::conectar()->prepare($sqlt);
$stmt -> execute();
	if($stmt->rowCount() > 0){
	  $registros = $stmt->fetchAll();
	  foreach ($registros as $key => $value) {
		  	$finicia = $value['finicia'];
		  	$idprograma = $value['idprograma'];
		  	$idempresa = $value['idempresa'];
		  	$controlada = $value['controlada'];
		  	$coordinacion = $value['coordinacion'];
		  	$naprendices = $value['naprendices'];
		  	$lugar = $value['lugar'];
		  	$direccion = $value['direccion'];
		  	if($idempresa !== '0'){
		  			$sql = "UPDATE empresas SET editable = '0' WHERE id = '$idempresa' AND estado = '1'";
					$stmt = Conexion::conectar()->prepare($sql);
					$stmt -> execute();
            }
		  	if($controlada == '1'){
			  	if($finicia !== '0000-00-00'){
			  		$restriccion =  $texto->valRestricciones($idficha, $coordinacion, $naprendices, $finicia);
			  		if($restriccion == 0){
					$sqlt = "SELECT diaslimite, horalimite, habiles, aprendices FROM coordinaciones WHERE id  = '$coordinacion'";
					$stmt = Conexion::conectar()->prepare($sqlt);
					$stmt -> execute();
					if($stmt->rowCount() > 0){
		  				 $correcto = 0;
		  				    $msrestric = 'Esta ficha no cumple una o varias de estas restricciones:';
							$correstricc = $stmt->fetchAll();
							foreach ($correstricc as $key => $restric){
								$diaslimite = $restric['diaslimite'];
								$horalimite = $restric['horalimite'];
								$habiles = $restric['habiles'];
								$aprendices = $restric['aprendices'];
							}
							if($aprendices > 0) $msrestric .=' La ficha debe tener cupo mínimo de '.$aprendices.' aprendices. ';
							if($diaslimite > 0) $msrestric .=' La ficha debe ser enviada '.$diaslimite.' dias antes de la fecha de inicio. ';
							if($horalimite > 0) $msrestric .=' Sólo se reciben solicitudes hasta las '.$horalimite.':00 horas. ';
							if($habiles > 0) $msrestric .=' Se reciben solicitudes sólo en días hábiles. ';
	  			 			$newdata = array(
	  			     		'tipo' => 'warning',
                     		'mensaje'=>$msrestric
	  			 		);
	  			      }
		  		 array_push($datos, $newdata);
				  	}
			  	}
		    }
	    }
	}
	if($correcto == '1'){
		 $newdata = array(
		    'tipo' => 'success',
	     	'mensaje'=>'La ficha fué enviada para autorización por parte del Coordinador Acadédmico.'
		 );
		array_push($datos, $newdata);
   		$sqlt = "UPDATE fcaracterizacion SET estado = '3' WHERE id = '$idficha'";
		$stmt = Conexion::conectar()->prepare($sqlt);
		if($stmt -> execute()){


         #actualizar la bitacora de la ficha
		  $sqlt = "UPDATE bitacoraestados SET visible = '0' WHERE idficha = '$idficha' ";
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();

		   $sqlt = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$idficha', '$idusuario', 'Enviado', '$fecha', '$hora','Enviada para autorización','1','$ip','3');";
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
			$c_coordinador = $texto -> traerCorreoCoordinador($ccentro,$coordinacion);
			$destinatario = $c_coordinador."@sena.edu.co";
			$respuesta = $texto -> notificarFicha($destinatario, $idficha, $idprograma, $idempresa, $lugar, $direccion);
			$destinatario = $_SESSION['prc_correo']."@sena.edu.co";
			$respuesta = $texto -> notificarFicha($destinatario, $idficha, $idprograma, $idempresa, $lugar, $direccion);
			if(strlen($_SESSION['prc_correootro']) > 0){
			 $destinatario = $_SESSION['prc_correootro'];
			 $respuesta = $texto -> notificarFicha($destinatario, $idficha, $idprograma, $idempresa, $lugar, $direccion);
		    }
		    $respuesta = '1';
		}else{
			$respuesta = '0';
		}

	}
 }
   return $respuesta;
}


public function traerCorreoCoordinador($ccentro,$coordinacion){
$respuesta = '0';
   $sqlt = "SELECT us.correosena FROM coordinaciones cr INNER JOIN usuarios us ON cr.coordinador = us.id WHERE cr.centro = '$ccentro' AND cr.id = '$coordinacion'";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
			 $respuesta = $value['correosena'];
		}
	}
	return $respuesta;
}

public function traerEstadoUsuario($usuario){
$bloqueado = 'No existe ';
   $sqlt = "SELECT bloqueado FROM usuarios WHERE identificador = '$usuario'";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
			 $bloqueado = $value['bloqueado'];
		}
	}
	return $bloqueado;
}
public function traerNombreUsuario($usuario){
$nombre = 'No existe ';
   $sqlt = "SELECT nombre FROM usuarios WHERE identificador = '$usuario'";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
			 $nombre = $value['nombre'];
		}
	}
	return $nombre;
}

public function notificarFicha($destinatario, $idficha, $idprograma, $idempresa, $lugar, $direccion){
	$texto = new FormacionModel();
	$datosFormacion = $texto -> traerDatosFormacion($idprograma);
	$codigo = $datosFormacion['codigo'];
	$usuario = $_SESSION['prc_ciuser'];
	$nombre_usuario = $texto -> traerNombreUsuario($usuario);
	$nombre_usuario = $texto->decode_entities($nombre_usuario);
	$nombre_formacion = $datosFormacion['nombre'];
	$horas_formacion = $datosFormacion['horas'];
    if($idempresa !== '0'){
	$datosEmpresa = $texto -> datosEmpresa($idempresa);
		$nit = $datosEmpresa[0]['nit'];
		$empresa = $datosEmpresa[0]['empresa'];
		$direccion = $datosEmpresa[0]['direccion'];
		$nombre = $datosEmpresa[0]['nombre'];
		$telefono = $datosEmpresa[0]['telefono'];
		$correo = $datosEmpresa[0]['correo'];
    }
	$respuesta = 0;
	$lista = '';
	$tmes = '';
	$tdiasemana = '';
	$tinicia = '';
	$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$dias=array(0=>"Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" );
  $sqlt = "SELECT ano, mes, diasemana, horas, inicia, finaliza, dia, festivo, estado, novedad FROM programacion WHERE idficha = '$idficha' AND estado <> '0' ORDER BY mes, inicia, finaliza, diasemana, dia ASC";
  		$stmt = Conexion::conectar()->prepare($sqlt);
   		$stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();
		$lista .='<table class="table table-borderless">';
		$lista .='<tr>';
		$ban = 0;
		foreach ($registros as $key => $value){
			$ano = $value['ano'];
			$mes = $value['mes'];
			$diasemana = $value['diasemana'];
			$horas = $value['horas'];
			$inicia = $value['inicia'];
			$finaliza = $value['finaliza'];
			$festivo = $value['festivo'];
			$dia = $value['dia'];
			if($ban == 0){
				$tinicia = $inicia;
				$tfinaliza = $finaliza;
				$tdiasemana = $diasemana;
				$tmes = $mes;
				$lista .='<tr class="table-success">';
				$lista .='<td colspan="7"><strong>'.$meses[$mes].'</strong></td>';
				$lista .='</tr>';
				$lista .='<tr class="table-secondary">';
				$lista .='<td colspan="7"> Franja: ('.$inicia.':00 -'.$finaliza.':00)</td>';
				$lista .='</tr>';
				$lista .='<tr>';
				$lista .='<td>'.$dias[$diasemana].'</td>';
				$ban = 1;
		    }
			if($tmes !== $mes){
				$lista .='</tr>';
				$lista .='<tr class="table-success">';
				$lista .='<td colspan="7"><strong>'.$meses[$mes].'</strong></td>';
				$lista .='</tr>';
				$lista .='<tr class="table-secondary">';
				$lista .='<td colspan="7"> Franja: ('.$inicia.':00 -'.$finaliza.':00)</td>';
				$lista .='</tr>';
				$lista .='<tr>';
			$tinicia = $inicia;
			$tfinaliza = $finaliza;
			$tmes = $mes;
			}
			if($tinicia !== $inicia || $tfinaliza !== $finaliza){
				$lista .='</tr>';
				$lista .='<tr class="table-secondary">';
				$lista .='<td colspan="7"> Franja: ('.$inicia.':00 -'.$finaliza.':00)</td>';
				$lista .='</tr>';
				$lista .='</tr>';
				$lista .='<tr>';
				$lista .='<td>'.$dias[$diasemana].'</td>';
			$tdiasemana = $diasemana;
			$tinicia = $inicia;
			$tfinaliza = $finaliza;
			}
			if($tdiasemana !== $diasemana){
				$lista .='</tr>';
				$lista .='<tr>';
				$lista .='<td>'.$dias[$diasemana].'</td>';
			$tdiasemana = $diasemana;
			}
			if($diasemana == '0' || $festivo == '1' ){
			$lista .= '<td class="table-danger">'.$dia.'</td>';
			}else{
			$lista .= '<td>'.$dia.'</td>';
			}
		}
		$lista .='</tr>';
		$lista .='</table>';
	}
	$asunto = $codigo." FORMACION ".html_entity_decode($nombre_formacion)." HORAS ".$horas_formacion;
	$cuerpo = '
	<html>
	<head>
	<title>'.$codigo.' FORMACION '.html_entity_decode($nombre_formacion).' HORAS '.$horas_formacion.'</title>
	</head>
	<body>
	<h2>'.$nombre_usuario.'</h2>
	<h3>'.$codigo.' FORMACION '.html_entity_decode($nombre_formacion).' HORAS '.$horas_formacion.'</h3>
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">DATO</th>
			      <th scope="col">DESCRIPCION</th>
			    </tr>
			  </thead>
			  <tbody>';
			  if($idempresa !== '0'){
			   $cuerpo .= ' <tr>
					<td>NIT</td><td>'.$nit.'</td>
				</tr>
			    <tr>
					<td>EMPRESA</td><td>'.html_entity_decode($empresa).'</td>
				</tr>
			    <tr>
					<td>DIRECCION</td><td>'.html_entity_decode($direccion).'</td>
				</tr>
			    <tr>
					<td>CONTACTO</td><td>'.html_entity_decode($nombre).'</td>
				</tr>
			    <tr>
					<td>TELEFONO</td><td>'.$telefono.'</td>
				</tr>
			    <tr>
					<td>CORREO</td><td>'.$correo.'</td>
			    </tr>';
			   }else{
			   	$cuerpo .= '
			   	<tr>
					<td>TIPO DE OFERTA</td><td>Oferta Abierta</td>
				</tr>';
			   }
			    $cuerpo .= '
			    <tr>
					<td>LUGAR</td><td>'.html_entity_decode($lugar).'</td>
				</tr>
			    <tr>
					<td>DIRECCION</td><td>'.html_entity_decode($direccion).'</td>
			    </tr>
			  </tbody>
			</table>

	<hr>
	<h2>PROGRAMACION</h2>
	'.$lista.'
	<hr>

	</body>
	</html>
	';
	//para el envío en formato HTML
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	//dirección del remitente
	$headers .= "From: Programacion Centro <noreply@senagalan.com>\r\n";
	//dirección de respuesta, si queremos que sea distinta que la del remitente
	$headers .= "Reply-To: Programacion Centro <noreply@senagalan.com>\r\n";
	//ruta del mensaje desde origen a destino
	$headers .= "Return-path: Programacion Centro <noreply@senagalan.com>\r\n";
	//direcciones que recibirán copia
	$headers .= "Cco: ".$correo."\r\n";
	//direcciones que recibirán copia oculta
	$headers .= "Bcc: erpprogramacion@gmail.com\r\n";
	mail($destinatario,$asunto,$cuerpo,$headers);
	//Envair Mail Fin
	return $cuerpo;
}

public function datosEmpresa($id){
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
			    $nit = $a->decode_entities($value['nit']);
				$nombre = $a->decode_entities($value['enombre']);
				$direccion = $a->decode_entities($value['edireccion']);
				$cnombre = $a->decode_entities($value['cnombre']);
				$ctelefono = $a->decode_entities($value['ctelefono']);
				$ccorreo = $a->decode_entities($value['ccorreo']);
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
						'idCiudad' => $idCiudad
			        );
        }
    }else{
		$newdata =  array (
			'respuesta' => '0'
        );
    }
	$arrDatos[] = $newdata;
	return $arrDatos;
}

public function verValidacion($idficha){
	$texto = new FormacionModel();
	$restriccion = 0;
	$lista = '';
	$salida = array();
	$tdatos = array();
	$sqlt = "SELECT tvalidacion , finicia, controlada, coordinacion, naprendices FROM fcaracterizacion WHERE id = '$idficha'";
	$stmt = Conexion::conectar()->prepare($sqlt);
	$stmt -> execute();
if($stmt->rowCount() > 0){
  $registros = $stmt->fetchAll();
  foreach ($registros as $key => $value) {
	  	foreach (json_decode($value['tvalidacion'],true) as $key => $nvalue){
	  		array_push($tdatos, $nvalue);
	    }
  	$finicia = $value['finicia'];
  	$controlada = $value['controlada'];
  	$coordinacion = $value['coordinacion'];
  	$naprendices = $value['naprendices'];
  	if($controlada == '1'){
	  	if($finicia !== '0000-00-00'){
	  		$restriccion =  $texto->valRestricciones($idficha, $coordinacion,$naprendices, $finicia);
		  		if($restriccion == 0){
				$sqlt = "SELECT diaslimite, horalimite, habiles, aprendices FROM coordinaciones WHERE id  = '$coordinacion'";
				$stmt = Conexion::conectar()->prepare($sqlt);
				$stmt -> execute();
				if($stmt->rowCount() > 0){
	  				 $correcto = 0;
	  				    $msrestric = 'Esta ficha no cumple una o varias de estas restricciones:';
						$correstricc = $stmt->fetchAll();
						foreach ($correstricc as $key => $restric){
							$diaslimite = $restric['diaslimite'];
							$horalimite = $restric['horalimite'];
							$habiles = $restric['habiles'];
							$aprendices = $restric['aprendices'];
						}
						if($aprendices > 0) $msrestric .=' La ficha debe tener cupo mínimo de '.$aprendices.' aprendices. ';
						if($diaslimite > 0) $msrestric .=' La ficha debe ser enviada '.$diaslimite.' dias antes de la fecha de inicio. ';
						if($horalimite > 0) $msrestric .=' Sólo se reciben solicitudes hasta las '.$horalimite.':00 horas. ';
						if($habiles > 0) $msrestric .=' Se reciben solicitudes sólo en días hábiles. ';
	  			 			$newdata = array(
		  			     		'tipo' => 'warning',
	                     		'mensaje'=>$msrestric
		  			 		);
					array_push($tdatos, $newdata);
  			      }
			  	}
	  	   }
       }
    }
  }
array_push($salida, $tdatos);
return json_encode($salida);
}

public function valRestricciones($idficha, $coordinacion, $naprendices, $finicia){
	$correcto = 1;
	date_default_timezone_set('America/Bogota');
	$fecha = date("Y-m-d");
	$hora = date('G');
	$sqlt = "SELECT diaslimite, horalimite, habiles, aprendices FROM coordinaciones WHERE id  = '$coordinacion'";
	$stmt = Conexion::conectar()->prepare($sqlt);
  //$stmt -> bindParam(":idficha", $idficha, PDO::PARAM_INT);
    $stmt -> execute();
	if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
			$diaslimite = $value['diaslimite'];
			$horalimite = $value['horalimite'];
			$habiles = $value['habiles'];
			$aprendices = $value['aprendices'];
		}
	}
	if($habiles == '1'){
	    $f = new FormacionModel();
		$mesActual = date("n");
		$year = date("Y");
		$diaActual = date("j");
		$ds = date("w", mktime(0, 0, 0, $mesActual, $diaActual, $year));
		$festivo = $f->traerFestivo($year, $mesActual, $diaActual);
		if($festivo == '1' || $ds == '0' || $ds == '6'){
			$correcto = 0;
		}
	}
	if($hora >= $horalimite && $horalimite > 0){
	   $correcto = 0;
	}
	if($naprendices < $aprendices){
	   $correcto = 0;
	}
	$date1 = new DateTime($fecha);
	$date2 = new DateTime($finicia);
	$diff = $date1->diff($date2);
	if($diff->days <= $diaslimite && $diaslimite > 0){
		$correcto = 0;
	}
	if($correcto == 0){
		    $sqlt = "UPDATE fcaracterizacion SET validacion = '$correcto' WHERE id = '$idficha'";
				$stmt = Conexion::conectar()->prepare($sqlt);
				$stmt -> execute();
	}
	return  $correcto;
}



public function solValidarFicha($idficha){
date_default_timezone_set('America/Bogota');
$fecha = date("Y-m-d");
$hora = date('H:i:s');
$validacion = '1';
$salida = array();
$mensaje = array(
	0=>"La ficha no tiene programaci&oacute;n",
	"Las horas de programaci&oacute;n no corresponden a las horas definidas para este programa.",
	"Tiene cruce de horarios con otras formaciones complementarias.",
	"El proceso no puede continuar debido a que la fecha de inicio es extemporanea.","No hay un programa de formaci&oacute;n seleccionado o v&aacute;lido", "Falta completar los datos de la ficha, ingresando por la opci&oacute;n editar.");
	$validar = new FormacionModel();
	$datosFicha = $validar -> traerDatosFicha($idficha);
	$datosFormacion = $validar -> traerDatosFormacion($datosFicha['idprograma']);
	$datosProgramacion = $validar -> traerHorasProgramadas($idficha);
    $mensajeRespuesta = array();
    $valCruce = array();
    $totalHorasProgramadas = 0;
    $valCruceFranjas = '';
    if($datosFicha['estado'] == '1'){
    		  $newdata = array(
				'tipo' => 'warning',
				'mensaje'=>$mensaje[5]
		  	   );
    	array_push($mensajeRespuesta,$newdata);
    	$validacion = '0';
    }
    if($datosFormacion['respuesta'] == 0){
    	      $newdata = array(
				'tipo' => 'warning',
				'mensaje'=>$mensaje[4]
		  	   );
    	array_push($mensajeRespuesta,$newdata);
    	$validacion = '0';
    }
	if($datosProgramacion[0]['respuesta'] == 0){
    	      $newdata = array(
				'tipo' => 'warning',
				'mensaje'=>$mensaje[0]
		  	   );
    	array_push($mensajeRespuesta,$newdata);
    	$validacion = '0';
	}else{
		foreach ($datosProgramacion as $key => $thoras) {
			if(isset($thoras['horas'])){
				$tthoras = $thoras['horas'];
		    }else{
		    	$tthoras = 0;
		    }
		 $totalHorasProgramadas = $totalHorasProgramadas + $tthoras;
		}
		if($totalHorasProgramadas != $datosFicha['horas']){
    	      $newdata = array(
				'tipo' => 'warning',
				'mensaje'=>$mensaje[1]. "Horas programadas: ".$totalHorasProgramadas." Horas del programa: ".$datosFicha['horas']
		  	   );
    	    array_push($mensajeRespuesta,$newdata);
		 	$validacion = '0';
		 }

		 $valCruceFranjas = $validar ->validarCruceFranja($datosFicha, $datosProgramacion);
		 foreach ($valCruceFranjas as $key => $value) {
		 	if($value['respuesta'] == '1'){
				$validacion = '0';
    	      $newdata = array(
				'tipo' => 'warning',
				'mensaje'=>"La programaci&oacute;n presenta cruce de horarios en la fecha ".$value['fecha']. " [".$value['numero']."]"
		  	   );
    	    array_push($mensajeRespuesta,$newdata);
		     }
		 }




	}
    $tvalidacion = json_encode($mensajeRespuesta);
    $sqlt = "UPDATE fcaracterizacion SET validacion = '$validacion', tvalidacion = '$tvalidacion' WHERE id = '$idficha'";
	$stmt = Conexion::conectar()->prepare($sqlt);
	$stmt -> execute();
if($validacion == 1){
	    	  $newdata = array(
				'tipo' => 'success',
				'mensaje'=>"La solicitud pasó la primera validación. Ahora puede hacer click en enviar."
		  	   );
    	    array_push($mensajeRespuesta,$newdata);
}
array_push($salida, $mensajeRespuesta[0]);
return json_encode($mensajeRespuesta);
}

public function validarCruceFranja($datosFicha, $datosProgramacion){
$idusuario = $datosFicha['idusuario'];
$cidficha = $datosFicha['idficha'];
$usuario = $datosFicha['usuario'];
  $a = 0;
  $b = 0;
foreach ($datosProgramacion as $key => $value) {
  $cfecha = $value['fecha'];
  $cinicia = $value['inicia'];
  $cfinaliza = $value['finaliza'];
  $sqlt = "SELECT pg.idficha, pg.fecha, pg.diasemana, pg.inicia, pg.finaliza, fc.numero FROM programacion pg INNER JOIN fcaracterizacion fc ON fc.id = pg.idficha WHERE pg.fecha = '$cfecha'

  AND (pg.estado = '1' OR pg.estado = '2')
  AND
  ((
  		('$cinicia' BETWEEN pg.inicia  AND (pg.finaliza - 1 ))
  	 OR ('$cfinaliza' BETWEEN (pg.inicia + 1) AND pg.finaliza)
  )
  OR (('$cinicia' <= pg.inicia) AND ('$cfinaliza' >= pg.finaliza)) )
  AND fc.usuario = '$usuario'
  AND pg.idficha <> '$cidficha'
  AND fc.estado <> '0'
  AND fc.historico = '0'
  ";

	$stmt = Conexion::conectar()->prepare($sqlt);
       $stmt -> execute();
		if($stmt->rowCount() > 0){
		    $registros = $stmt->fetchAll();
            foreach ($registros as $key => $value){
				$idficha = $value['idficha'];
                $diasemana = $value['diasemana'];
                $inicia = $value['inicia'];
                $finaliza = $value['finaliza'];
                $numero = $value['numero'];
                  $newdata = array (
                    'respuesta' => 1,
                    'fecha' => $cfecha,
                    'idficha' => $idficha,
                    'diasemana' => $diasemana,
                    'inicia' => $inicia,
                    'finaliza' => $finaliza,
                    'numero' => $numero
                 );
                 $datos[] = $newdata;
            }
		}else{
			    $newdata = array (
                    'respuesta' => 0,
                    'fecha' => '',
                    'idficha' => '',
                    'diasemana' => '',
                    'inicia' => '',
                    'finaliza' => ''
                 );
                 $datos[] = $newdata;
		}
  }
return $datos;
}

public function traerDatosFormacion($idformacion){
   $lista = '';

   $sqlt = "SELECT nombre, codigo, horas FROM formaciones WHERE id = '$idformacion'";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
	if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
		    $nombre = $value['nombre'];
			$horas = $value['horas'];
			$codigo = $value['codigo'];
			 $datos = [
				'respuesta'=>1,
			    'nombre' => $nombre,
			    'horas' => $horas,
				'codigo' => $codigo
	        ];
		}



	} else{
			$datos = [
				'respuesta'=> 0,
				'nombre'=>'No hay programa seleccionado'
			];
	}
    return $datos;
}

public function traerDatosFicha($idficha){
$sqlt = "SELECT horas, finicia, ffinaliza, idprograma, estado, idusuario, usuario, numero, codempresa, lugar, direccion  FROM fcaracterizacion WHERE id  = '$idficha'";
	$stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
			$idusuario = $value['idusuario'];
			$usuario = $value['usuario'];
			$numero = $value['numero'];
			$codempresa = $value['codempresa'];
			$horas = $value['horas'];
			$finicia = $value['finicia'];
			$ffinaliza = $value['ffinaliza'];
			$idprograma = $value['idprograma'];
			$estado = $value['estado'];
			$lugar = $value['lugar'];
			$direccion = $value['direccion'];
			 $datos = [
				'respuesta' => 1,
			    'lugar' => $lugar,
			    'direccion' => $direccion,
			    'numero' => $numero,
			    'codempresa' => $codempresa,
			    'idficha' => $idficha,
			    'idusuario' => $idusuario,
			    'usuario' => $usuario,
			    'horas' => $horas,
			    'idprograma' => $idprograma,
				'estado' => $estado,
			    'finicia' => $finicia,
				'ffinaliza' => $ffinaliza
	        ];
		}
	}else{
		$datos = [
		'respuesta'=>0,
		'mensaje'=> 'No es posible encontrar esta ficha en el sistema.'
		];
	}
return $datos;
}

public function traerHorasProgramadas($idficha){
$iniciaficha = '0000-00-00';
$finalficha = '000-00-00';
$sqlt = "SELECT fecha, inicia, finaliza, horas, ano, mes, dia, diasemana, festivo, novedad FROM programacion WHERE idficha  = '$idficha' AND estado <> '0' ORDER BY fecha, inicia ASC";
$stmt = Conexion::conectar()->prepare($sqlt);
$stmt -> execute();
if($stmt->rowCount() > 0){
$registros = $stmt->fetchAll();
$ban = 0;
foreach ($registros as $key => $value){
	 if($ban == 0){
	 	$iniciaficha = $value['fecha'];
	 	$ban = 1;
	 }
	$finalficha = $value['fecha'];
	$fecha = $value['fecha'];
	$inicia = $value['inicia'];
	$finaliza = $value['finaliza'];
	$horas = $value['horas'];
	$ano = $value['ano'];
	$mes = $value['mes'];
	$dia = $value['dia'];
	$diasemana = $value['diasemana'];
	$festivo = $value['festivo'];
	$novedad = $value['novedad'];
	$newdata = [
	 	'respuesta'=> 1,
		'fecha' => $fecha,
		'inicia' => $inicia,
		'finaliza' => $finaliza,
		'horas' => $horas,
		'ano' => $ano,
		'mes' => $mes,
		'dia' => $dia,
		'diasemana' => $diasemana,
		'festivo' => $festivo,
		'novedad' => $novedad
    ];
$datos[] = $newdata;
}
}else{
	$newdata = [
	'respuesta'=> 0,
	'mensaje' => 'No hay programación para esta ficha'
	];
$datos[] = $newdata;
}

$sqlt = "UPDATE fcaracterizacion SET finicia = '$iniciaficha' WHERE id = '$idficha' AND numero = '0';";
	$stmt = Conexion::conectar()->prepare($sqlt);
	$stmt -> execute();

$sqlt = "UPDATE fcaracterizacion SET ffinaliza = '$finalficha' WHERE id = '$idficha'";
	$stmt = Conexion::conectar()->prepare($sqlt);
	$stmt -> execute();
return $datos;
}



#VALIDAR Y SOLICITAR LA CREACION DE FICHAS
public function listPespeciales(){
   $respuesta = '1';
   $lista = '';
   $sqlt = "SELECT id, programa FROM pespeciales WHERE estado = '1' ORDER BY id ASC";
   $stmt = Conexion::conectar()->prepare($sqlt);
	if($stmt -> execute()){
		$respuesta = '1';
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value) {
			$id = $value['id'];
			$programa = $value['programa'];
			$lista .= '<option value="'.$id.'">'.$programa.'</option>';
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

public function dficha($idficha){
$respuesta = [];
$sqlt = "SELECT numero, finicia FROM fcaracterizacion WHERE id = '$idficha'";
	$stmt = Conexion::conectar()->prepare($sqlt);
	$stmt -> execute();
	if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
	    $numero = $value['numero'];
	 	$finicia = $value['finicia'];
		$respuesta = [
		    'numero' => $numero,
			'finicia' => $finicia
            ];
		}
	}
return $respuesta;
}

public static function selectCalendario($datos){
$ip = $_SERVER["REMOTE_ADDR"];
date_default_timezone_set('America/Bogota');
$fechahoy = date("Y-m-d");
$mesActual = date("n");
$year = date("Y");
$diaActual = date("j");
$f = new FormacionModel();
$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$idficha = $datos['idficha'];
$dficha = $f-> dficha($idficha);
$numero = $dficha['numero'];
$finicia = DateTime::createFromFormat('Y-m-d', $dficha['finicia']);
$html = '';
for ($m = $mesActual; $m < 13; $m++) {
	$diaSemana=date("w",mktime(0,0,0,$m,1,$year))+7;
	$ds = date("l", mktime(0, 0, 0, 7, 1, 2000));
	$ultimoDiaMes=date("d",(mktime(0,0,0,$m+1,1,$year)-1));
    //$html .='<div id="franja"></div>';
    //$html .='<div id="hfranja"></div>';
    $html .='<table class="table table-sm table-bordered" id="calendar">';
	$html .='<thead class="thead-dark">';
	$html .='<tr>';
	$html .='<th colspan="7">'.$meses[$m].' '.$year.'</th>';
	$html .='</tr>';
	$html .='<tr>';
	$html .='	<th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th>';
	$html .='	<th>Vie</th><th>Sab</th><th>Dom</th>';
	$html .='</tr>';
	$html .='</thead>';
	$html .='<tbody>';
	$html .='<tr>';
		$last_cell = $diaSemana + $ultimoDiaMes;
		for($i=1;$i<=42;$i++)
		{
			if($i==$diaSemana)
			{
				$day=1;
			}
			if($i<$diaSemana || $i>=$last_cell)
			{
				$html .='<td>&nbsp;</td>';
			}else{
				// mostramos el dia

				$ds = date("w", mktime(0, 0, 0, $m, $day, $year));
				$festivo = $f->traerFestivo($year, $m, $day);
				if($numero !== '0'){
				$temfecha = DateTime::createFromFormat('Y-m-d', $year.'-'.$m.'-'.$day);
				$res = ($temfecha >= $finicia) ? "SI" : "NO";
					switch ($res) {
						case 'SI':
							$html.= $f->activo($idficha, $day, $m, $year, $ds, $festivo);
							break;
						case 'NO':
							$html .='<td><del>'.$day.'</del></td>';
							break;
						default:
							$html .='<td><del>'.$day.'</del></td>';
							break;
					}
				}

				if($numero == '0'){
					if($day == $diaActual && $m == $mesActual && $numero == '0'){
					    $html .='<td><button class="btn btn-outline-primary btn-sm" type="button" disabled>'.$day.'</button></td>';
					} else {

						if($day > $diaActual || $m > $mesActual){
							$html.= $f->activo($idficha, $day, $m, $year, $ds, $festivo);
						 }else{
						  $html .='<td><del>'.$day.'</del></td>';
						 }

					}
				}
				$day++;
				}



			// cuando llega al final de la semana, iniciamos una columna nueva
			if($i%7==0)
			{
				$html .='</tr><tr><br>';
			}
		}
	$html .='</tr>';
	$html .='<tr>';
	$html .='<th colspan="7"><p>Hoy es '.$diaActual.' de '.$meses[$mesActual].' de '.$year.'</p></th>';
	$html .='</tr>';
	$html .='</tbody>';
$html .='</table> ';
}
return $html;
}

public function activo($idficha, $day, $m, $year, $ds, $festivo){
$html ='';
	if($ds == 0 || $festivo == 1){
	   $html .='<td id="b'.$m.'_'.$day.'"><button id="d'.$m.'_'.$day.'" onClick="selCalendario('.$idficha.','.$year.','.$m.','.$day.','.$ds.','.$festivo.')" class="btn btn-outline-danger btn-sm" type="button">'.$day.'</button></td>';
	}else{
		$html .='<td id="b'.$m.'_'.$day.'"><button id="d'.$m.'_'.$day.'" onClick="selCalendario('.$idficha.','.$year.','.$m.','.$day.','.$ds.','.$festivo.')" class="btn btn-outline-success btn-sm" type="button">'.$day.'</button></td>';
	}
	return $html;
}


public static function verprogramacion($datos){
$idficha = $datos['idficha'];
$numero = $datos['numero'];
$respuesta = '0';
$lista = '';
$tmes = '';
$tdiasemana = '';
$tinicia = '';
$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$dias=array(0=>"Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" );
  $sqlt = "SELECT ano, mes, diasemana, horas, inicia, finaliza, dia, festivo, estado, novedad FROM programacion WHERE idficha = '$idficha' AND estado = '1' ORDER BY mes, inicia, finaliza, diasemana, dia ASC";
  		$stmt = Conexion::conectar()->prepare($sqlt);
   		$stmt -> execute();
		if($stmt->rowCount() > 0){
		$respuesta = '1';
		$registros = $stmt->fetchAll();
		$lista .='<div class="table-responsive">';
		$lista .='<table class="table table-borderless">';
		$lista .='<span class="h2">'.$numero.'</span>';
		$lista .='<tr>';
		$ban = 0;
		$thoras = 0;
		foreach ($registros as $key => $value){
			$ano = $value['ano'];
			$mes = $value['mes'];
			$diasemana = $value['diasemana'];
			$horas = $value['horas'];
			$thoras = $thoras + $horas;
			$inicia = $value['inicia'];
			$finaliza = $value['finaliza'];
			$festivo = $value['festivo'];
			$dia = $value['dia'];
			if($ban == 0){
				$tinicia = $inicia;
				$tfinaliza = $finaliza;
				$tdiasemana = $diasemana;
				$tmes = $mes;
				$lista .='<tr class="table-success">';
				$lista .='<td colspan="7"><strong>'.$meses[$mes].'</strong></td>';
				$lista .='</tr>';
				$lista .='<tr class="table-secondary">';
				$lista .='<td colspan="7"> Franja: ('.$inicia.':00 -'.$finaliza.':00)</td>';
				$lista .='</tr>';
				$lista .='<tr>';
				$lista .='<td>'.$dias[$diasemana].'</td><td>';
				$ban = 1;
		    }
			if($tmes !== $mes){
				$lista .='</td>';
				$lista .='</tr>';
				$lista .='<tr class="table-success">';
				$lista .='<td colspan="7"><strong>'.$meses[$mes].'</strong></td>';
				$lista .='</tr>';
				$lista .='<tr class="table-secondary">';
				$lista .='<td colspan="7"> Franja: ('.$inicia.':00 -'.$finaliza.':00)</td>';
				$lista .='</tr>';
				$lista .='<tr>';
				$lista .='<td>';
			$tinicia = $inicia;
			$tfinaliza = $finaliza;
			$tdiasemana = '';
			$tmes = $mes;
			}
			if($tinicia !== $inicia || $tfinaliza !== $finaliza){
				$lista .='</tr>';
				$lista .='<tr class="table-secondary">';
				$lista .='<td colspan="7"> Franja: ('.$inicia.':00 -'.$finaliza.':00)</td>';
				$lista .='</tr>';
				$lista .='<tr>';
				$lista .='<td>'.$dias[$diasemana].'</td><td>';
			$tdiasemana = $diasemana;
			$tinicia = $inicia;
			$tfinaliza = $finaliza;
			}
			if($tdiasemana !== $diasemana){
				$lista .='</td>';
				$lista .='</tr>';
				$lista .='<tr>';
				$lista .='<td>'.$dias[$diasemana].'</td><td>';
			$tdiasemana = $diasemana;
			}
			if($diasemana == '0' || $festivo == '1' ){
			$lista .= '<span style="color:red;"> '.$dia.' </span>';
			}else{
			$lista .= '<span> '.$dia.' </span>';
			}
		}
		$lista .='</td>';
		$lista .='</tr>';
		$lista .='<tr class="table-info">';
		$lista .='<td>';
		$lista .='TOTAL HORAS PROGRAMACION ';
		$lista .='</td>';
		$lista .='<td class="h3 info">';
		$lista .= $thoras;
		$lista .='</td>';
		$lista .='</tr>';
		$lista .='</table>';
		$lista .='</div>';
	}
		$newdata =  array (
		'respuesta' => $respuesta,
		'horario' => $lista
		);
		$arrDatos[] = $newdata;
echo json_encode($arrDatos);
}


public static function programacion($idficha){
$respuesta = 0;
$lista = '';
$tmes = '';
$tdiasemana = '';
$tinicia = '';
$mesActual = date("n");
$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$dias=array(0=>"Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" );
  $sqlt = "SELECT ano, mes, diasemana, horas, inicia, finaliza, dia, festivo, estado, novedad FROM programacion WHERE idficha = '$idficha' AND estado = '1' ORDER BY mes, inicia, finaliza, diasemana, dia ASC";
  		$stmt = Conexion::conectar()->prepare($sqlt);
   		$stmt -> execute();
		if($stmt->rowCount() > 0){
	    $respuesta = 1;
		$registros = $stmt->fetchAll();
		$lista .='<div class="table-responsive">';
		$lista .='<table class="table table-borderless">';
		$lista .='<tr>';
		$ban = 0;
		$thoras = 0;
		foreach ($registros as $key => $value){
			$ano = $value['ano'];
			$mes = $value['mes'];
			$diasemana = $value['diasemana'];
			$horas = $value['horas'];
			$thoras = $thoras + $horas;
			$inicia = $value['inicia'];
			$finaliza = $value['finaliza'];
			$festivo = $value['festivo'];
			$dia = $value['dia'];
			if($ban == 0){
				$tinicia = $inicia;
				$tfinaliza = $finaliza;
				$tdiasemana = $diasemana;
				$tmes = $mes;
				$lista .='<tr class="table-success">';
				$lista .='<td colspan="7"><strong>'.$meses[$mes].'</strong></td>';
				$lista .='</tr>';
				$lista .='<tr class="table-secondary">';
				$lista .='<td colspan="7"> Franja: ('.$inicia.':00 -'.$finaliza.':00)</td>';
				$lista .='</tr>';
				$lista .='<tr>';
				$lista .='<td>'.$dias[$diasemana].'</td><td>';
				$ban = 1;
		    }
			if($tmes !== $mes){
				$lista .='</td>';
				$lista .='</tr>';
				$lista .='<tr class="table-success">';
				$lista .='<td colspan="7"><strong>'.$meses[$mes].'</strong></td>';
				$lista .='</tr>';
				$lista .='<tr class="table-secondary">';
				$lista .='<td colspan="7"> Franja: ('.$inicia.':00 -'.$finaliza.':00)</td>';
				$lista .='</tr>';
				$lista .='<tr>';
				$lista .='<td>';
			$tinicia = $inicia;
			$tfinaliza = $finaliza;
			$tdiasemana = '';
			$tmes = $mes;
			}
			if($tinicia !== $inicia || $tfinaliza !== $finaliza){
				$lista .='</tr>';
				$lista .='<tr class="table-secondary">';
				$lista .='<td colspan="7"> Franja: ('.$inicia.':00 -'.$finaliza.':00)</td>';
				$lista .='</tr>';
				$lista .='<tr>';
				$lista .='<td>'.$dias[$diasemana].'</td><td>';
			$tdiasemana = $diasemana;
			$tinicia = $inicia;
			$tfinaliza = $finaliza;
			}
			if($tdiasemana !== $diasemana){
				$lista .='</td>';
				$lista .='</tr>';
				$lista .='<tr>';
				$lista .='<td>'.$dias[$diasemana].'</td><td>';
			$tdiasemana = $diasemana;
			}
			if($diasemana == '0' || $festivo == '1' ){
				if($mes < $mesActual){
					$lista .= '<button id="p'.$mes.'_'.$dia.'" type="button"  class="btn-danger" disabled>'.$dia.'</button>';
			    }else{
			      $lista .= '<button id="p'.$mes.'_'.$dia.'" type="button" onClick="unselProgramacion('.$idficha.','.$ano.','.$mes.','.$dia.','.$diasemana.','.$inicia.','.$finaliza.','.$festivo.')" class="btn-danger" >'.$dia.'</button>';
			    }
			}else{
		     	if($mes < $mesActual){
			       $lista .= '<button id="p'.$mes.'_'.$dia.'" type="button" disabled>'.$dia.'</button>';
		        }else{
		          $lista .= '<button id="p'.$mes.'_'.$dia.'" type="button" onClick="unselProgramacion('.$idficha.','.$ano.','.$mes.','.$dia.','.$diasemana.','.$inicia.','.$finaliza.','.$festivo.')">'.$dia.'</button>';
		         }
			}
		}
		$lista .='</td>';
		$lista .='</tr>';
		$lista .='<tr class="table-info">';
		$lista .='<td>';
		$lista .='TOTAL HORAS PROGRAMACION ';
		$lista .='</td>';
		$lista .='<td class="h3 info">';
		$lista .= $thoras;
		$lista .='</td>';
		$lista .='</tr>';
		$lista .='</table>';
	}
	$respuesta = $lista;
	return $respuesta;
}
// metodo original en la parte inferior
public function selCalendario($datos){


	$ip = $_SERVER["REMOTE_ADDR"];

	
	//Datos para el trimestre
	$f = new FormacionModel();
	date_default_timezone_set('America/Bogota');

	$dtrimestre = $f -> dtrimestre();
	$fechainicio = $dtrimestre['fechainicio'];
	$fechafin = $dtrimestre['fechafin'];
	$fechainiciof = strtotime($fechainicio);
	$fecha_actual = strtotime($fechainicio);
	$fechafinf = strtotime($fechafin);

	// $fechahoy = date("Y-m-d");
	// $mesInicio = date("n",$fechainiciof);
	// $mesFin = date("n",$fechafinf);
	// $diaInicio = date("d",$fechainiciof);
	// $diaFin = date("d",$fechafinf);
	// $year = date("Y");
	// $diaActual = date("j");


	$labelCorrecto = '';
	$labelError = '';
	$idficha = $datos['idficha'];
	$inicia =  $datos['inicia'];
	$finaliza = $datos['finaliza'];
	$ano = $datos['ano'];
	$mes = $datos['mes'];
	$dia = $datos['dia'];
	$fecha = $ano.'-'.$mes.'-'.$dia;

	$festivo = $datos['festivo'];
	$estado = $datos['estado'];
	$horas = $finaliza - $inicia;
	$estado = $datos['estado'];

	$idInstructor = 0;
	$idResultado[] =array();

	// $idCompetencia[];
	// $textCompetencia[] = {};
	// $textResultado = "";

	$esTitulada = false;
	$esMultiple = false;
	$numCruces = 0;


	if(isset($datos['esTitulada'])){
		$converEsTitulada = $datos['esTitulada'];

		if($converEsTitulada > 0){
			$esTitulada = true;
		}
	}

	if(isset($datos['esMultiple'])){
		$converesMultiple = $datos['esMultiple'];

		if($converesMultiple > 0){
			$esMultiple = true;
		}
	}

	//se valida si tiene los dos nuevos parametros para agregarlos a la consulta
	if(isset($datos['idInstructor'])){
		$idInstructor = $datos['idInstructor'];
	}
	if(isset($datos['idResultado'])){
		$idResultado = json_decode($datos['idResultado']);
	}

	if($esMultiple){
		$diasemana = json_decode($datos['ds']);
	}else{
		$diasemana = $datos['ds'];
		$ds = $datos['ds'];
	}

	if($esTitulada){
		$sqlValCruces = "select COUNT(*) as programados from programacion  where (idficha = '$idficha'  OR idinstructor ='$idInstructor') and ( ( (inicia <= '$inicia' and finaliza > '$inicia' ) OR (inicia < '$finaliza' and finaliza >= '$finaliza') ) OR (inicia > '$inicia' and finaliza < '$finaliza') ) AND ano = '$ano' and mes = '$mes' AND dia = '$dia' AND estado = '1';";
		$stmt2 = Conexion::conectar()->prepare($sqlValCruces);
		if($stmt2 -> execute()){
			$registros = $stmt2->fetchAll();
			foreach ($registros as $key => $value){
					$numCruces = $value['programados'];
			}
		}
	}

	if($numCruces >0){

		// se presentan cruces de horarios
		$respuesta = '2';
		$label = '<small>Se presentan cruces de horarios</small>';
		$newdata =  array (
			'respuesta' => $respuesta,
			'label' => $label
			);
			$arrDatos[] = $newdata;

	}else{


		$sqlt ="";

		if($esTitulada){

			if(!$esMultiple){

				$sqlt .="INSERT INTO programacion (idficha, inicia, finaliza, ano, mes, dia, diasemana, festivo, ip, fecha, estado, horas, idinstructor)  VALUES ('$idficha','$inicia','$finaliza','$ano', '$mes', '$dia', '$ds', '$festivo', '$ip', '$fecha', '$estado', '$horas', '$idInstructor') ON DUPLICATE KEY  UPDATE  estado = '$estado' , idinstructor = '$idInstructor'; " .

								"select @idProgramacion := ID from programacion where idficha = '$idficha' AND inicia = '$inicia' AND finaliza = '$finaliza' AND ano = '$ano' AND mes ='$mes' AND dia = '$dia' AND diasemana = '$ds' AND festivo = '$festivo' AND ip = '$ip' AND fecha = '$fecha' AND estado = '$estado' AND horas = '$horas' AND idinstructor = '$idInstructor'; " .

								"DELETE FROM programacion_resultados WHERE idProgramacion = @idProgramacion; " ;


							foreach ($idResultado as &$valor) {

								$sqlt .="INSERT INTO programacion_resultados (idProgramacion, idResultado) VALUES (@idProgramacion,'$valor') ; " ;
							}
				/*
					echo '<script>';
				  echo 'console.log('. json_encode( $sqlt ) .')';
				  echo '</script>';
				
				  /**/
						$stmt = Conexion::conectar()->prepare($sqlt);
						if($stmt -> execute()){
							$sqlt = "UPDATE fcaracterizacion SET validacion = '0', tvalidacion = '' WHERE id = '$idficha'";
								$stmt = Conexion::conectar()->prepare($sqlt);
								$stmt -> execute();	
							$respuesta = '1';
							$label = '<small>'.$inicia.'h<br>'.$dia.' '.$finaliza.'h</small>';
						}else{
							$respuesta = '0';
						}
				$newdata =  array (
				'respuesta' => $respuesta,
				'label' => $label
				);
				$arrDatos[] = $newdata;  

			}else{

				$sqlt = "START TRANSACTION; " ;

				//numero de dias selecionados en la lista, realiza bloques de querys por dia de la semana
				for($i = 0; $i < count($diasemana); $i+=1){

					$fecha_actual = strtotime($fechainicio);

					$mes = date("n",$fecha_actual);
					$dia = date("d",$fecha_actual);
					$ano = date("Y",$fechafinf);
					$ds = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

					while($ds != $diasemana[$i] ){

						//Agregamos un dia hasta encontrar el primer dia que corresponda el dia de la semana seleccionado
						$fecha_actual =strtotime('+1 days', $fecha_actual);

						$mes = date("n",$fecha_actual);
						$dia = date("d",$fecha_actual);
						$ano = date("Y",$fecha_actual);
						$ds = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
					}

					$mesSQL = date("n",$fechainiciof);
							$diaSQL = date("d",$fechainiciof);
							$anoSQL = date("Y",$fechainiciof);

					$fechaSQLini = $anoSQL.'-'.$mesSQL.'-'.$diaSQL;

					$mesSQL = date("n",$fechafinf);
							$diaSQL = date("d",$fechafinf);
							$anoSQL = date("Y",$fechafinf);

					$fechaSQLfin = $anoSQL.'-'.$mesSQL.'-'.$diaSQL;

					// Se realiza validacion para verificar que ese dia, la programacion este disponible en todo el trimestre
					$sqlValCruces = "select COUNT(*) as programados from programacion  where (idficha = '$idficha'  OR idinstructor ='$idInstructor') and ( ( (inicia <= '$inicia' and finaliza > '$inicia' ) OR (inicia < '$finaliza' and finaliza >= '$finaliza') ) OR (inicia > '$inicia' and finaliza < '$finaliza') )  AND (fecha BETWEEN '$fechaSQLini' AND '$fechaSQLfin') AND diasemana = '$ds' AND estado = '1';";

									
					$stmt2 = Conexion::conectar()->prepare($sqlValCruces);
					if($stmt2 -> execute()){
						$registros = $stmt2->fetchAll();
						foreach ($registros as $key => $value){
							
								$numCruces = $value['programados'];
						}
					}

					/*
					echo '<script>';
				  echo 'console.log('. json_encode( $sqlValCruces ) .')';
				  echo '</script>';
				
				  /**/ 

					$textoDia ="";
					if($numCruces >0){

						$textoDia=$f->convertirDiaTexto($ds);

						// se presentan cruces de horarios
						$respuesta = '2';
						$labelError = $labelError . ' - '.$textoDia.'';
						
				
					}else{

					//al encontrar el dia, realiza las querys correspondientes a todos los dias iguales en el trimestre
						while($fecha_actual <= $fechafinf){

							$mes = date("n",$fecha_actual);
							$dia = date("d",$fecha_actual);
							$ano = date("Y",$fechafinf);
							$festivo = $f->traerFestivo($ano, $mes, $dia);
							$ds = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

							$fecha = $ano.'-'.$mes.'-'.$dia;


							$sqlt .="INSERT INTO programacion (idficha, inicia, finaliza, ano, mes, dia, diasemana, festivo, ip, fecha, estado, horas, idinstructor)  VALUES ('$idficha','$inicia','$finaliza','$ano', '$mes', '$dia', '$ds', '$festivo', '$ip', '$fecha', '$estado', '$horas', '$idInstructor') ON DUPLICATE KEY  UPDATE  estado = '$estado' , idinstructor = '$idInstructor'; " .

								"select @idProgramacion := ID from programacion where idficha = '$idficha' AND inicia = '$inicia' AND finaliza = '$finaliza' AND ano = '$ano' AND mes ='$mes' AND dia = '$dia' AND diasemana = '$ds' AND festivo = '$festivo' AND ip = '$ip' AND fecha = '$fecha' AND estado = '$estado' AND horas = '$horas' AND idinstructor = '$idInstructor'; " .

								"DELETE FROM programacion_resultados WHERE idProgramacion = @idProgramacion; " ;


							foreach ($idResultado as &$valor) {

								$sqlt .="INSERT INTO programacion_resultados (idProgramacion, idResultado) VALUES (@idProgramacion,'$valor') ; " ;
							}

							// agregamos 7 dias hasta llegar al ultimo dia del trimestre
							$fecha_actual =strtotime('+7 days', $fecha_actual);
						}
					}
				}

				$sqlt .= " COMMIT; ";

				$textoDia = $f->convertirDiaTexto($ds);
				//ejecutamos bloques de SQL por dia.

				$stmt = Conexion::conectar()->prepare($sqlt);
				if($stmt -> execute()){
					$sqlt = "UPDATE fcaracterizacion SET validacion = '0', tvalidacion = '' WHERE id = '$idficha'";
						$stmt = Conexion::conectar()->prepare($sqlt);
						$stmt -> execute();
					$respuesta = '1';
					$labelCorrecto = $labelCorrecto. ' - '.$textoDia.'';
				}else{
					$respuesta = '0';
				}


				$resultadoLabel = "";
	
				if($labelCorrecto != ''){
					$resultadoLabel = 'Programacion creada correctamente para los dias '.$labelCorrecto;
				}
	
				if($labelError != ''){
					$resultadoLabel = $resultadoLabel . ' ** Error al crear programacion en los dias '.$labelError.' por favor verifique los cruces de horarios';
				}
	
				$newdata =  array (
					'respuesta' => $respuesta,
					'label' => $resultadoLabel
					);

								
				$arrDatos[] = $newdata;
	
			}

		}else{
			//consulta anterior
			$sqlt = "INSERT INTO programacion (idficha, inicia, finaliza, ano, mes, dia, diasemana, festivo, ip, fecha, estado, horas, idinstructor, idResultado, desResultado, idCompetencia, desCompetencia)  VALUES ('$idficha','$inicia','$finaliza','$ano', '$mes', '$dia', '$diasemana', '$festivo', '$ip', '$fecha', '$estado', '$horas', '$idInstructor', '$idResultado', '$textResultado', '$idCompetencia', '$textCompetencia') ON DUPLICATE KEY  UPDATE  estado = '$estado' , idinstructor = '$idInstructor', idResultado = '$idResultado', desResultado = '$textResultado', idCompetencia = '$idCompetencia', desCompetencia = '$textCompetencia'";

			$stmt = Conexion::conectar()->prepare($sqlt);
						if($stmt -> execute()){
							$sqlt = "UPDATE fcaracterizacion SET validacion = '0', tvalidacion = '' WHERE id = '$idficha'";
								$stmt = Conexion::conectar()->prepare($sqlt);
								$stmt -> execute();	
							$respuesta = '1';
							$label = '<small>'.$inicia.'h<br>'.$dia.' '.$finaliza.'h</small>';
						}else{
							$respuesta = '0';
						}
				$newdata =  array (
				'respuesta' => $respuesta,
				'label' => $label
				);
				$arrDatos[] = $newdata;  

		}
	
	}


echo json_encode($arrDatos);
}


public static function convertirDiaTexto($ds){
	switch($ds){
		case 0:
			$textoDia = 'Domingo';
		break;
		case 1:
			$textoDia = 'Lunes';
		break;
		case 2:
			$textoDia = 'Martes';
		break;
		case 3:
			$textoDia = 'Miercoles';
		break;
		case 4:
			$textoDia = 'Jueves';
		break;
		case 5:
			$textoDia = 'Viernes';
		break;
		case 6:
			$textoDia = 'Sabado';
		break;
	}

	return $textoDia;
}
/* copia metodo anterior
public function selCalendario($datos){
	$ip = $_SERVER["REMOTE_ADDR"];
	$label = '';
	$idficha = $datos['idficha'];
	$inicia =  $datos['inicia'];
	$finaliza = $datos['finaliza'];
	$ano = $datos['ano'];
	$mes = $datos['mes'];
	$dia = $datos['dia'];
	$fecha = $ano.'-'.$mes.'-'.$dia;
	$diasemana = $datos['ds'];
	$festivo = $datos['festivo'];
	$estado = $datos['estado'];
	$horas = $finaliza - $inicia;
	$sqlt = "INSERT INTO programacion (idficha, inicia, finaliza, ano, mes, dia, diasemana, festivo, ip, fecha, estado, horas)  VALUES ('$idficha','$inicia','$finaliza','$ano', '$mes', '$dia', '$diasemana', '$festivo', '$ip', '$fecha', '$estado', '$horas') ON DUPLICATE KEY  UPDATE  estado = '$estado'";
		$stmt = Conexion::conectar()->prepare($sqlt);
		if($stmt -> execute()){
			$sqlt = "UPDATE fcaracterizacion SET validacion = '0', tvalidacion = '' WHERE id = '$idficha'";
			    $stmt = Conexion::conectar()->prepare($sqlt);
				$stmt -> execute();
			$respuesta = '1';
			$label = '<small>'.$inicia.'h<br>'.$dia.' '.$finaliza.'h</small>';
		}else{
			$respuesta = '0';
		}
$newdata =  array (
'respuesta' => $respuesta,
'label' => $label
);
$arrDatos[] = $newdata;
echo json_encode($arrDatos);
}*/

public function unselCalendario($datos){
	$ip = $_SERVER["REMOTE_ADDR"];
	$idficha = $datos['idficha'];
	$inicia =  $datos['inicia'];
	$finaliza = $datos['finaliza'];
	$ano = $datos['ano'];
	$mes = $datos['mes'];
	$dia = $datos['dia'];
	$diasemana = $datos['ds'];
	$festivo = $datos['festivo'];
	$estado = $datos['estado'];

	$idInstructor = 0;
	$idResultado = 0;

	$idCompetencia = 0;
	$textCompetencia = "";
	$textResultado = "";

	$esTitulada = false;

	if(isset($datos['esTitulada'])){
		$converEsTitulada = $datos['esTitulada'];

		if($converEsTitulada > 0){
			$esTitulada = true;
		}
	}

	//se valida si tiene los dos nuevos parametros para agregarlos a la consulta
	if(isset($datos['idInstructor'])){
		$idInstructor = $datos['idInstructor'];
	}
	if(isset($datos['idResultado'])){
		$idResultado = $datos['idResultado'];
	}

	if(isset($datos['idCompetencia'])){
		$idCompetencia = $datos['idCompetencia'];
	}
	if(isset($datos['textCompetencia'])){
		$textCompetencia = $datos['textCompetencia'];
	}
	if(isset($datos['textResultado'])){
		$textResultado = $datos['textResultado'];
	}

	$sqlt = "";
	if(!$esTitulada){

		$sqlt = "INSERT INTO programacion (idficha, inicia, finaliza, ano, mes, dia, diasemana, festivo, ip, estado, idinstructor, idResultado, desResultado, idCompetencia, desCompetencia)  VALUES ('$idficha','$inicia','$finaliza','$ano', '$mes', '$dia', '$diasemana', '$festivo', '$ip', '$estado', '$idInstructor', '$idResultado', '$textResultado', '$idCompetencia', '$textCompetencia') ON DUPLICATE KEY  UPDATE  estado = '$estado' , idinstructor = '$idInstructor', idResultado = '$idResultado', desResultado = '$textResultado', idCompetencia = '$idCompetencia', desCompetencia = '$textCompetencia'";

	}else{
		$sqlt .="INSERT INTO programacion (idficha, inicia, finaliza, ano, mes, dia, diasemana, festivo, ip, estado, idinstructor)  VALUES ('$idficha','$inicia','$finaliza','$ano', '$mes', '$dia', '$diasemana', '$festivo', '$ip',  '$estado',  '$idInstructor') ON DUPLICATE KEY  UPDATE  estado = '$estado' , idinstructor = '$idInstructor'; " .

								"select @idProgramacion := ID from programacion where idficha = '$idficha' AND inicia = '$inicia' AND finaliza = '$finaliza' AND ano = '$ano' AND mes ='$mes' AND dia = '$dia' AND diasemana = '$diasemana' AND festivo = '$festivo' AND ip = '$ip' AND estado = '$estado' AND idinstructor = '$idInstructor'; DELETE FROM programacion_resultados WHERE idProgramacion = @idProgramacion; " ;
	}

		$stmt = Conexion::conectar()->prepare($sqlt);
		if($stmt -> execute()){
			$sqlt = "UPDATE fcaracterizacion SET validacion = '0', tvalidacion = '' WHERE id = '$idficha'";
		    $stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
			$respuesta = '1';
				}else{
			$respuesta = '0';
		}
$newdata =  array (
'respuesta' => $respuesta,
'sql' => $sqlt
);
$arrDatos[] = $newdata;
echo json_encode($arrDatos);
/*

					echo '<script>';
				  echo 'console.log('. json_encode( $sqlt ) .')';
				  echo '</script>';*/
				
				  
}

public function traerFestivo($ano, $mes, $day){
$respuesta = 0;
   $sqlt = "SELECT estado FROM festivos WHERE ano ='$ano' AND mes = '$mes' AND dia = '$day'";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
			 $respuesta = $value['estado'];
		}
	}
	return $respuesta;
}


 public function traerEvento($id, $estado, $alarmada){
   $respuesta = '';
   $lista = '';
   $sqlt = "SELECT fecha, hora, nestado, descripcion FROM bitacoraestados WHERE visible = '1' AND idficha ='$id' AND estado = '$estado'";
   $stmt = Conexion::conectar()->prepare($sqlt);
	if($stmt -> execute()){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
		if($alarmada == '1'){
			 $respuesta = '<br><span class="h6 text-muted">Estado: '.$value['nestado'].'</span><small class="float-right form-text text-muted">'.$value['fecha'].' '.$value['hora'].'</small>
			 <br>'.'<small class="form-text text-muted">'.$value['descripcion'].'</small>';
			}else{
			 $respuesta = '<br><span class="text-muted">Estado: '.$value['nestado'].'</span><small class="float-right form-text text-muted">'.$value['fecha'].' '.$value['hora'].'</small>';
			}

		}
	}
	return $respuesta;
 }

 public function traerformacion($id){
   $respuesta = '<span style="color:red"><strong>SELECCIONAR FORMACION</strong></span>';
   $lista = '';
   $sqlt = "SELECT nombre, codigo, horas FROM formaciones WHERE id = '$id'";
   $stmt = Conexion::conectar()->prepare($sqlt);
	if($stmt -> execute()){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
			 $codigo = $value['codigo'];
			 $horas = $value['horas'];
			 $respuesta = '<span>'.$value['nombre'].'</span><br><span class="h6">'.$codigo.'</span><span class="h6 "> - '.$horas.' Horas</span>';
		}
	}
	return $respuesta;
 }

 public function traerpespecial($id){
   $respuesta = '';
   $sqlt = "SELECT programa FROM pespeciales WHERE id = '$id'";
   $stmt = Conexion::conectar()->prepare($sqlt);
	if($stmt -> execute()){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
			     $respuesta = $value['programa'];
		}
	}
	return $respuesta;
 }

 public static function traerdCurso($id){
   $sqlt = "SELECT lugar, direccion, naprendices, ciudad, departamento, pespeciales, onbase, val_onbase FROM fcaracterizacion WHERE id = '$id'";
   $stmt = Conexion::conectar()->prepare($sqlt);
	if($stmt -> execute()){
		$registros = $stmt->fetchAll();
		foreach ($registros as $key => $value){
			$a = new FormacionModel;
			$lugar = $a->decode_entities($value['lugar']);
			$dirformacion = $a->decode_entities($value['direccion']);
			$naprendices = $value['naprendices'];
			$ciudad = $value['ciudad'];
			$onbase = $value['onbase'];
			$val_onbase = $value['val_onbase'];
			$depto = $value['departamento'];
			$pespeciales = $value['pespeciales'];
				$newdata =  array (
					'respuesta' => '1',
					'lugar' => $lugar,
					'dirformacion' => $dirformacion,
					'naprendices' => $naprendices,
					'ciudad' => $ciudad,
					'onbase' => $onbase,
					'val_onbase' => $val_onbase,
					'depto' => $depto,
					'pespeciales' => $pespeciales
				);
		}
	}else{
		$newdata =  array (
		 'respuesta' => '0'
		);
	}
	$arrDatos[] = $newdata;
    return json_encode($arrDatos);
  }
public function updateRadicado($datos){
 include_once "../../routes/config.php";
$ruta = SERVERURL;
		$idficha = $datos['idficha'];
		$onbase = $datos['onbase'];
		if(isset($_SESSION['prc_idusuario'])){
			$idusuario = $_SESSION['prc_idusuario'];
			$respuesta = '0';
			$sqlt = "UPDATE fcaracterizacion SET onbase = '$onbase' WHERE id = '$idficha';";
	    		$stmt = Conexion::conectar()->prepare($sqlt);
	    		$stmt -> execute();
	    		$result = $stmt->rowCount();
				if($result > 0){
				  $respuesta = '1';
				}else{
					$respuesta = '0';
				}
			}else{
				$respuesta = '5';
			}
	      $newdata =  array (
	       'respuesta' => $respuesta,
	       'dato'=> $onbase,
	       'sql'=> $sqlt,
	       'ruta'=>$ruta
	     );
	     $arrDatos[] = $newdata;
	 echo json_encode($arrDatos);
	}


	public static function eliminarFicha($id){
		$respuesta = '0';
		$sqlt = "DELETE FROM fcaracterizacion WHERE id = '$id'";
		$stmt = Conexion::conectar()->prepare($sqlt);
		$stmt -> execute();
		if($stmt->rowCount() > 0){
	          $respuesta = '1';
	          $sqlt = "DELETE FROM bitacoraestados WHERE idficha = '$id'";
				$stmt = Conexion::conectar()->prepare($sqlt);
				$stmt -> execute();
	         }
	         else{
	        $respuesta = '0';
		}
		$newdata =  array (
		'respuesta' => $respuesta
		);
		$arrDatos[] = $newdata;
		echo json_encode($arrDatos);
	}

	public static function dtrimestre(){
		$respuesta = [];
		$sqlt = "SELECT fechainicio, fechafin FROM trimestres WHERE estado = '1'";
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
			if($stmt->rowCount() > 0){
				$registros = $stmt->fetchAll();
				foreach ($registros as $key => $value){
				$fechainicio = $value['fechainicio'];
				 $fechafin = $value['fechafin'];
				$respuesta = [
					'fechainicio' => $fechainicio,
					'fechafin' => $fechafin
					];
				}
			}
		return $respuesta;
		}


    public static function updateCurso($datos){
		$ip = $_SERVER["REMOTE_ADDR"];
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-d");
		$hora = date('H:i:s');
		$id = $datos['id'];
		$lugar =  $datos['lugar'];
		$dirformacion = $datos['dirformacion'];
		$naprendices = $datos['naprendices'];
		$ciudad = $datos['ciudad'];
		$depto = $datos['depto'];
		$pespeciales = $datos['pespeciales'];
		if(!isset($_SESSION['prc_ciuser'])){
		     $respuesta =  '5';
		}else{
		$idusuario = $_SESSION['prc_idusuario'];
		$sqlt = "UPDATE fcaracterizacion SET lugar = '$lugar', direccion = '$dirformacion', naprendices = '$naprendices', departamento = '$depto', ciudad = '$ciudad', pespeciales = '$pespeciales', estado = '2' WHERE id = '$id'";
    		$stmt = Conexion::conectar()->prepare($sqlt);
			if($stmt -> execute()){

			  $sqlt = "UPDATE bitacoraestados SET visible = '0' WHERE idficha = '$id'";
				$stmt = Conexion::conectar()->prepare($sqlt);
				$stmt -> execute();

			   $sqlt = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$id', '$idusuario', 'Editado', '$fecha', '$hora','Usuario completó los datos básicos de la ficha','1','$ip','2');";
				$stmt = Conexion::conectar()->prepare($sqlt);
				$stmt -> execute();

				$respuesta = '1';
			}else{
				$respuesta = '0';
			}
		}
		$newdata =  array (
		'respuesta' => $respuesta,
		'sql' => $sqlt
		);
		$arrDatos[] = $newdata;
		echo json_encode($arrDatos);
	   //$stmt -> Conexion::close();
    }


	public function __destruct(){
		   //$stmt -> Conexion::close();
	}
}

