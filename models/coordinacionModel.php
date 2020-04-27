<?php
require_once "conexion.php";
session_start();
class CoordinadorModel{
	 public function __construct() {
			//require_once "conexion.php";
		}
	 public function decode_entities($text){ 
		    return html_entity_decode($text);
		}

public static function coorConsultar($datos){
include_once "../../routes/config.php";
$fecha = date("Y-m-d");
$hora = date('H:i:s'); 
$ruta = SERVERURL;  
$respuesta = '0';
$lista = '';
$ano = $datos['ano'];
$mes = $datos['mes'];
$dia = $datos['dia'];
$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"); 
$dias=array(0=>"Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" );
if(isset($_SESSION['prc_idusuario'])){   
	$centro = $_SESSION['prc_centro'];
    $sqlt = "SELECT fc.id id, fc.lugar, fc.direccion, pr.diasemana, fc.naprendices, fr.codigo, fr.nombre, fr.horas, us.nombre instructor, em.nit, em.nombre empresa, dp.depto, cd.ciudad, fc.finicia, fc.ffinaliza, pe.programa, fc.numero, fc.codempresa, pr.inicia, pr.finaliza FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN empresas em ON fc.idempresa = em.id  INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN deptos dp ON fc.departamento = dp.id INNER JOIN pespeciales pe ON fc.pespeciales = pe.id INNER JOIN programacion pr ON pr.idficha = fc.id WHERE pr.estado = '1' AND fc.ccentro = '$centro' AND pr.ano = '$ano' AND pr.mes = '$mes' AND pr.dia = '$dia' ORDER BY cd.ciudad, pr.inicia ASC";
		$stmt = Conexion::conectar()->prepare($sqlt);
		$stmt -> execute();
		if($stmt -> rowcount() > 0){
		$respuesta = '1';	
		$registros = $stmt->fetchAll();	
		$a = new CoordinadorModel();
			foreach ($registros as $key => $value) {
				$idficha = $value['id'];
				$id = $value['id'];
				$lugar = $a->decode_entities($value['lugar']);
				$direccion = $a->decode_entities($value['direccion']);
				$naprendices = $value['naprendices'];
				$codigo = $value['codigo'];
				$nombre = strtoupper(html_entity_decode($value['nombre']));
				$horas = $value['horas'];
				$instructor = strtoupper(html_entity_decode($value['instructor']));
				$nit = $value['nit'];
				$empresa = $a->decode_entities($value['empresa']);
				$depto = $a->decode_entities($value['depto']);
				$ciudad = $a->decode_entities($value['ciudad']);
				$finicia = $value['finicia'];
				$ffinaliza = $value['ffinaliza'];
				$inicia = $value['inicia'];
				$diasemana = $value['diasemana'];
				$finaliza = $value['finaliza'];				
				$programa = $a->decode_entities($value['programa']);
				$numero = $value['numero'];
				$codempresa = $value['codempresa'];	 	
				
				$lista .='<div class="card border-info mb-3" style="max-width: 100%;">';
				$lista .='  <div class="card-header">'.$ciudad.'</div>';
				$lista .='  <div class="card-body">';
				$lista .='    <h5 class="card-title"><span style="color:red">'.$instructor.'</span></h5>';
				$lista .='    <p class="card-text">'.$lugar.' '.$direccion.'<br><span style="color:blue">'.$inicia.':00 HASTA '.$finaliza.':00 </span> <br> FICHA: <span style="font-weight: bold;">'.$numero.'</span><br>'.$dias[$diasemana].' '.$dia.' de '.$meses[$mes].' de '.$ano.'</p>';
				$lista .='  </div>';
				$lista .='<div class="card-footer bg-transparent border-success">'.$nombre.'</div>';
				$lista .='</div>';				            
	            $respuesta = '1';
		 		$newdata =  array (
				  'respuesta' => $respuesta,
				  'horario' => $lista
	            ); 
		}			
	  }	
	 }else{
	    $respuesta = '5';
		$newdata =  array (
		  'respuesta' => $respuesta
	    ); 
	 }
 $arrDatos[] = $newdata;   
 echo json_encode($arrDatos);
}	

public function dias($idficha){
    $respuesta = '';
    $td = '';
    $dias=array(0=>"Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" );
    $sqlt = "SELECT diasemana FROM programacion WHERE idficha = '$idficha' AND estado <> '0' ORDER BY diasemana ASC";
    $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        $registros = $stmt->fetchAll(); 
        foreach ($registros as $key => $value) {
           $d = $value['diasemana'];
           if($td !== $d){ 
           $respuesta .= '<i class="far fa-check-square"></i> &nbsp;'.$dias[$d].'&nbsp;&nbsp;&nbsp;';
           }
           $td = $d;
        }
    }
 return $respuesta;
}
	public function jornada($idficha){
		$inicia = 0;
		$finaliza = 0;
		$sqlt = "SELECT inicia FROM programacion WHERE idficha = '$idficha' AND estado <> '0' ORDER BY inicia ASC LIMIT 1;";
  		$stmt = Conexion::conectar()->prepare($sqlt);
   		$stmt->execute();
	    if($stmt->rowCount() > 0){
	    	$registros = $stmt->fetchAll();	
	    	foreach ($registros as $key => $value) {
	    		$inicia = $value['inicia'];
	    	}
	    }

		$sqlt = "SELECT finaliza FROM programacion WHERE idficha = '$idficha' AND estado <> '0'  ORDER BY finaliza DESC LIMIT 1;";
  		$stmt = Conexion::conectar()->prepare($sqlt);
   		$stmt->execute();
	    if($stmt->rowCount() > 0){
	    	$registros = $stmt->fetchAll();	
	    	foreach ($registros as $key => $value) {
	    		$finaliza = $value['finaliza'];
	    	}
	    }	    
	 return 'Inicia  '.$inicia.':00 Finaliza '.$finaliza.':00';
	}


	public static function autorizarFicha($idficha){
	  date_default_timezone_set('America/Bogota'); 
	  $ip = $_SERVER["REMOTE_ADDR"]; 
	  $fecha = date("Y-m-d");
	  $hora = date('H:i:s');		
	  $ip = $_SERVER["REMOTE_ADDR"]; 	
	  if(isset($_SESSION['prc_idusuario'])){ 
	    $idusuario = $_SESSION['prc_idusuario'];     
		$respuesta = '0';
		$sqlt1 = "UPDATE fcaracterizacion SET estado = '4', alarmada = '0' WHERE id = '$idficha' AND estado = '3'";
	    		$stmt = Conexion::conectar()->prepare($sqlt1);
	    		$stmt -> execute();
	    		$result = $stmt->rowCount();
				if($result > 0){
				  $respuesta = '1';
				  $sqlt2 = "UPDATE bitacoraestados SET visible = '0' WHERE idficha = '$idficha'"; 
					$stmt = Conexion::conectar()->prepare($sqlt2);
					$stmt -> execute();   

				   $sqlt3 = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$idficha', '$idusuario', 'Autorizada', '$fecha', '$hora','Autorizada','1','$ip','4');";	
					$stmt = Conexion::conectar()->prepare($sqlt3);
					$stmt -> execute();					  
				}else{
				  $respuesta = '0';
				}
			}else{
			   $respuesta = '5';
			}	
	      $newdata =  array (
	       'respuesta' => $respuesta 
	     );  
	     $arrDatos[] = $newdata;   
	 echo json_encode($arrDatos);
	}

	public static function denegarFicha($datos){
		date_default_timezone_set('America/Bogota'); 
		$ip = $_SERVER["REMOTE_ADDR"]; 
		$fecha = date("Y-m-d");
		$hora = date('H:i:s'); 		
		$idficha = $datos['idficha'];
		$explicacion = strtoupper($datos['explicacion']);
		$explicacion = htmlentities($explicacion);
		if(isset($_SESSION['prc_idusuario'])){
			$idusuario = $_SESSION['prc_idusuario'];
			$respuesta = '0';
			$sql1 = "UPDATE fcaracterizacion SET estado = '2', alarmada = '1', validacion = '0' WHERE id = '$idficha' AND estado = '3'";
	    		$stmt = Conexion::conectar()->prepare($sql1);
	    		$stmt -> execute();
	    		$result = $stmt->rowCount();
				if($result > 0){
				  $respuesta = '1';
				  $sql2 = "UPDATE bitacoraestados SET visible = '0' WHERE idficha = '$idficha' ";
					$stmt = Conexion::conectar()->prepare($sql2);
					$stmt -> execute();   

				   $sql3 = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$idficha', '$idusuario', 'Denegado', '$fecha', '$hora','$explicacion','1','$ip','2');";	
					$stmt = Conexion::conectar()->prepare($sql3);
					$stmt -> execute();	
					$a = new CoordinadorModel();
				    $texto =  $a ->notificarficha($idficha, $explicacion);     
				}else{
					$respuesta = '0'; 
				}
			}else{
				$respuesta = '5';
			}	
	      $newdata =  array (
	       'respuesta' => $respuesta 
	     );  
	     $arrDatos[] = $newdata;   
	 echo json_encode($arrDatos);
	}

public function notificarFicha($idficha, $explicacion){
$lista ='';	
$sqlt = "SELECT f.numero, f.codempresa, f.horas, f.finicia, f.ffinaliza, f.idprograma, f.estado, f.idusuario, f.usuario, f.numero, f.codempresa, f.lugar, f.direccion, e.nombre, e.direccion, e.nit, p.codigo, p.nombre nombre_formacion , u.nombre nombre_usuario, u.correosena, u.correootro FROM fcaracterizacion f INNER JOIN empresas e ON f.idempresa = e.id INNER JOIN formaciones p ON f.idprograma = p.id INNER JOIN usuarios u ON f.idusuario = u.id WHERE f.id  = '$idficha'";
	$stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value){
			$idusuario = $value['idusuario'];
			$nit = $value['nit'];
			$numero = $value['numero'];
			$codempresa = $value['codempresa'];
			$correosena = $value['correosena'];
			$correootro = $value['correootro'];
			$nombre = $value['nombre'];
			$direccion = $value['direccion'];
			$usuario = $value['usuario'];
			$numero = $value['numero'];
			$codempresa = $value['codempresa'];
			$horas_formacion = $value['horas'];
			$finicia = $value['finicia'];
			$ffinaliza = $value['ffinaliza'];
			$idprograma = $value['idprograma'];
			$estado = $value['estado'];
			$lugar = $value['lugar'];
			$direccion = $value['direccion'];
			$codigo = $value['codigo'];
			$nombre_formacion = $value['nombre_formacion'];
			$nombre_usuario = $value['nombre_usuario'];
      }				


	$asunto = "DENEGADA ".$codigo." FORMACION ".$nombre_formacion." HORAS ".$horas_formacion; 
	$cuerpo = ' 
	<html> 
	<head> 
	<title>SOLICITUD NO AUTORIZADA</title> 
	</head> 
	<body> 
	<h1>'.$explicacion.'</h1>
	<h2>'.$nombre_usuario.'</h2>
	<h3>'.$codigo.' FORMACION '.$nombre_formacion.' HORAS '.$horas_formacion.' FICHA '.$numero.' CODIGO EMPRESA '.$codigo.'</h3>
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">DATO</th>
			      <th scope="col">DESCRIPCION</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
					<td>FICHA</td><td>'.$numero.'</td>
				</tr>	
			    <tr>				
					<td>COD_EMPRESA</td><td>'.$codempresa.'</td>
				</tr>				  
			    <tr>
					<td>NIT</td><td>'.$nit.'</td>
				</tr>	
			    <tr>				
					<td>EMPRESA</td><td>'.$nombre.'</td>
				</tr>	
			    <tr>					
					<td>DIRECCION</td><td>'.$direccion.'</td>
				</tr>	

			    <tr>					
					<td>LUGAR</td><td>'.$lugar.'</td>
				</tr>	
			    <tr>					
					<td>DIRECCION</td><td>'.$direccion.'</td>
			    </tr>			    
			  </tbody>
			</table>

	<hr>
	<h2>PROGRAMACION</h2>
	'.$lista.'
      <p>Este correo es informativo y fue generado de forma automática, <b>no es necesario responder este correo.</b><p>
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
	//$headers .= "Cco: ".$correosena."\r\n"; 
	//direcciones que recibirán copia oculta 
	$headers .= "Bcc: erpprogramacion@gmail.com\r\n"; 
	mail($correosena.'@sena.edu.co',$asunto,$cuerpo,$headers);	
	mail($correootro,$asunto,$cuerpo,$headers);	
	//Envair Mail Fin 
  } 
  return true;
}



}
