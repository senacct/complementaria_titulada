<?php
	date_default_timezone_set('America/Bogota'); 
	include_once "../../routes/config.php";
	require_once "conexion.php";
	session_start();
class FichasModel{
	 public function __construct() {
			//require_once "conexion.php";
		}
	 public function decode_entities($text){ 
		    return html_entity_decode($text);
		} 

public static function listaFichasActivas(){
	$tabla = '';
	$opciones = '';
	$a = new FichasModel();
	if(isset($_SESSION['prc_idusuario'])){ 
	$centro = $_SESSION['prc_centro'];
	$sqlt = "SELECT fc.numero, fc.alarmada, fc.controlada, cr.nombre coordinacion, fc.codempresa, fc.controlada, fc.id id, fc.lugar, fc.direccion, fc.naprendices, fr.nivel, fr.codigo, fr.nombre, fr.horas, us.nombre instructor, us.correosena, us.correootro, be.nestado, be.estado estado, be.fecha, fc.idempresa, fc.ofertaabierta, cd.ciudad, fc.finicia, fc.ffinaliza FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN bitacoraestados be ON fc.id = be.idficha AND fc.estado = be.estado INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id WHERE fr.nivel = '0' AND fc.ccentro = '$centro' AND fc.historico = '0' AND fc.estado = be.estado AND be.visible = '1'  ORDER BY fc.id ASC";
	$stmt = Conexion::conectar()->prepare($sqlt);
	$stmt -> execute();
	$total = $stmt->rowCount();
	if($stmt->rowCount() > 0){
		$respuesta = '1';
		$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value) {
			$id = $value['id'];
			$numero = $value['numero'];
			$coordinacion = $value['coordinacion'];
			$codempresa = $value['codempresa'];
			$lugar = $value['lugar'];
			$correosena = $value['correosena'];
			$correootro = $value['correootro'];			
			$direccion = $value['direccion'];
			$naprendices = $value['naprendices'];
			$codigo = $value['codigo'];
			$nombre = html_entity_decode(strtolower($value['nombre']));
			$nombre = ucwords($nombre);
			$horas = $value['horas'];
			$instructor = html_entity_decode(strtolower($value['instructor']));
			$instructor = ucwords($instructor);
			$nestado = $value['nestado'];
			$fecha = $value['fecha'];
			$ciudad = $value['ciudad'];
			$finicia = $value['finicia'];
			$ffinaliza = $value['ffinaliza'];
			$idempresa = $value['idempresa'];
			$controlada = $value['controlada'];
			$ofertaabierta = $value['ofertaabierta'];
			$empresa = '';
			if($ofertaabierta == 'S'){
				$empresa = '<span style=\"color:blue;\">Oferta Abierta</span>';
				$codempresa = '<span style=\"color:blue;\">Oferta Abierta</span>';
			}else{
				$empresa = $a->traerEmpresa($idempresa);
			}
			if($controlada == '1'){
			    $ilabel = 'btn-default';
				$elabel = '<i class=\"fas fa-lock\"></i>';
			}else{
				$ilabel = 'btn-warning';
				$elabel = '<i class=\"fas fa-lock-open\"></i>';
			}
			$opciones ='<div class=\"btn-group\" role=\"group\" aria-label=\"Basic example\"><button type=\"button\" id=\"btvhorario'.$id.'\" onClick =\"verProgramacion(\''.$id.'\')\"  class=\"btn btn-info btn-sm\"><i class=\"far fa-calendar-alt\"></i></button><button type=\"button\" id=\"btvbitacora'.$id.'\" onClick =\"verbitacora('.$id.')\" class=\"btn btn-info btn-sm\"><i class=\"fas fa-list-ol\"></i></button><button type=\"button\" id=\"btnqc'.$id.'\" onClick =\"quitarControl('.$id.','.$controlada.')\" class=\"btn '.$ilabel.' btn-sm\">'.$elabel.'</button><button type=\"button\" id=\"btnqc'.$id.'\" onClick =\"enviarMensajes('.$id.',\''.$instructor.'\','.$numero.',\''.$correosena.'\',\''.$correootro.'\');\" class=\"btn btn-info btn-sm\"><i class=\"far fa-envelope\"></i></button></div>';  
			
			$tabla .='{"numero":"'.$numero.'","codempresa":"'.$codempresa.'","coordinacion":"'.$coordinacion.'","aprendices":"'.$naprendices.'","instructor":"'.$instructor.'","codigo":"'.$codigo.'","nombre":"'.$nombre.'","lugar":"'.$lugar.'","direccion":"'.$direccion.'","horas":"'.$horas.'","empresa":"'.$empresa.'","ciudad":"'.$ciudad.'","finicia":"'.$finicia.'","ffinaliza":"'.$ffinaliza.'","estado":"'.$nestado.'","fecha":"'.$fecha.'","opciones":"'.$opciones.'","total":"'.$total.'"},';
		}	
	 } 
	} 
	$tabla = substr($tabla,0, strlen($tabla) - 1);
	return '{"data":['.$tabla.']}';		   
}


public static function quitarControl($datos){
include_once "../../routes/config.php";
$ruta = SERVERURL; 	
 	$idficha = $datos['idficha'];
 	$nestado = $datos['nestado'];
	$sqlt = "UPDATE fcaracterizacion SET controlada = '$nestado' WHERE id = '$idficha'";
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

public function traerEmpresa($idempresa){
$respuesta = '';   
   $sqlt = "SELECT nombre FROM empresas WHERE id = '$idempresa'";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
        if($stmt->rowCount() > 0){
        $registros = $stmt->fetchAll(); 
        foreach ($registros as $key => $value){
				$nombre = html_entity_decode(strtolower($value['nombre']));
				$nombre = ucwords($nombre);
				$respuesta = $nombre;
        }           
    } 
    return $respuesta;  
}

public function traerNitEmpresa($idempresa){
$respuesta = '';   
   $sqlt = "SELECT nit FROM empresas WHERE id = '$idempresa'";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
        if($stmt->rowCount() > 0){
        $registros = $stmt->fetchAll(); 
        foreach ($registros as $key => $value){
				$nit = html_entity_decode(strtolower($value['nit']));
				$respuesta = $nit;
        }           
    } 
    return $respuesta;  
}
public static function verFicha($idficha){
include_once "../../routes/config.php";
$fecha = date("Y-m-d");
$hora = date('H:i:s'); 
$ruta = SERVERURL;  
$respuesta = '0';
$lista = '';
if(isset($_SESSION['prc_idusuario'])){   
 $sqlt = "SELECT fc.id id, fc.lugar, fc.direccion, fc.naprendices, fr.codigo, fr.nombre, fr.horas, us.nombre instructor,  fc.ofertaabierta, fc.idempresa, dp.depto, cd.ciudad, fc.finicia, fc.ffinaliza, pe.programa, fc.numero, fc.codempresa FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN deptos dp ON fc.departamento = dp.id INNER JOIN pespeciales pe ON fc.pespeciales = pe.id WHERE fc.id = '$idficha' AND fc.estado = '4' ORDER BY fc.id ASC";
		$stmt = Conexion::conectar()->prepare($sqlt);
		$stmt -> execute();
		if($stmt -> rowcount() > 0){
		$respuesta = '1';	
		$registros = $stmt->fetchAll();	
		$a = new FichasModel();
			foreach ($registros as $key => $value) {
				$id = $value['id'];
				$idempresa = $value['idempresa'];
				$lugar = $a->decode_entities($value['lugar']);
				$direccion = $a->decode_entities($value['direccion']);
				$naprendices = $value['naprendices'];
				$codigo = $value['codigo'];
				$nombre = $a->decode_entities($value['nombre']);
				$horas = $value['horas'];
				$instructor = $a->decode_entities($value['instructor']);
                if($value['ofertaabierta'] == 'S'){
                      $empresa = '<span style="color:blue;">Oferta Abierta</span>';  
                      $codempresa = '<span style="color:blue;">Oferta Abierta</span>';  
                      $nit = '<span style="color:blue;">Oferta Abierta</span>';
                }else{
                      $empresa = $a->traerEmpresa($idempresa); 
                      $nit = $a->traerNitEmpresa($idempresa); 
                      $codempresa = $value['codempresa']; 
                }
				$depto = $a->decode_entities($value['depto']);
				$ciudad = $a->decode_entities($value['ciudad']);
				$finicia = $value['finicia'];
				$ffinaliza = $value['ffinaliza'];
				$programa = $a->decode_entities($value['programa']);
				$numero = $value['numero'];
				$codempresa = $value['codempresa'];			
				$lista .='<div class="table-responsive-lg">';
				$lista .='<div ><button id="btnpasar'.$id.'" onClick="enviarprogramacion('.$id.');" class="btn btn-success btn-sm button">Ya está publicada, Viene de corrección, enviar a programación &nbsp; <i class="fas fa-arrow-alt-circle-right"></i> </button></div>';
					$lista .='<table class="table table-dark">';
					$lista .='<tr>';
					if($value['ofertaabierta'] == 'N'){
						$lista .='<td>NIT</td><td>'.$nit.'</td>';
						$lista .='</tr><tr>';				
						$lista .='<td>EMPRESA</td><td>'.$empresa.'</td>';
						$lista .='</tr>';
				    }else{
						$lista .='</tr>';				
						$lista .='<td>EMPRESA</td><td><span style="color:red;">Oferta Abierta</span></td>';	
						$lista .='<tr>';	
					}		
					$lista .='<td>SERVICIO REQ.</td><td>'.$nombre.'</td>';
					$lista .='</tr><tr>';	
					$lista .='<td>DEPARTAMENTO</td><td>'.$depto.'</td>';
					$lista .='</tr><tr>';			
					$lista .='<td>CIUDAD</td><td>'.$ciudad.'</td>';
					$lista .='</tr><tr>';
					$dias = $a -> dias($idficha);
					$lista .='<td>DIAS</td><td>'.$dias.'</td>';	
					$lista .='</tr><tr>';					
					$jornada = $a -> jornada($idficha);
					$lista .='<td>JORNADA</td><td>'.$jornada.'</td>';
					$lista .='</tr><tr>';
					$lista .='<td>C_PROGRAMA</td><td>'.$codigo.'</td>';
					$lista .='</tr><tr>';									
					$lista .='<td>INICIA</td><td>'.$finicia.'</td>';
					$lista .='</tr><tr>';				
					$lista .='<td>FINALIZA</td><td>'.$ffinaliza.'</td>';				
					$lista .='</tr><tr>';
					$lista .='<td>RESPONSABLE</td><td>'.$instructor.'</td>';
					$lista .='</tr><tr>';					
					$lista .='<td>PROGRAMA/CONVENIO</td><td>'.$programa.'</td>';	  
					$lista .='</tr><tr>';				
					$lista .='<td>AMBIENTE</td><td>'.$lugar.' '.$direccion.'</td>';
					$lista .='</tr><tr>';								
					$lista .='<td>APRENDICES</td><td>'.$naprendices.'</td>';
					$lista .='</tr><tr>';				
					$lista .='<td>NUMERO FICHA</td><td ><span id="numficha" style="color:orange">'.$numero.'</span></td>';
					$lista .='</tr><tr>';				
					$lista .='<td>CODIGO EMPRESA</td><td id="codmepresa">'.$codempresa.'</td>';				
					$lista .='</tr>';		
					$lista .='</table>';
				$lista .='</div>';	
				$lista .='<div>';
				$lista .='</div><hr>';	
				$lista .='<div class="row">';
				$lista .='  <div class="col-6">';
				$lista .='  <form>';
				$lista .='<div class="input-group mb-3">';
				$lista .='  <input type="text" class="form-control" id="numeroficha" placeholder="Numero Ficha">';
				$lista .='  <div class="input-group-append">';
				$lista .='    <button class="btn btn-outline-secondary" onClick="upnumeroficha('.$id.');" type="button" id="button-addon2"><i class="fas fa-check"></i></button>';
				$lista .='  </div>';
				$lista .='</div>';
				if($value['ofertaabierta'] == 'N'){
				$lista .='<div class="input-group mb-3">';
				$lista .='  <input type="text" class="form-control" id="codigoempresa" placeholder="Codigo Empresa">';
				$lista .='  <div class="input-group-append">';
				$lista .='    <button class="btn btn-outline-secondary" onClick="upcodempresa('.$id.');" type="button" id="button-addon2"><i class="fas fa-check"></i></button>';
				$lista .='  </div>';
				$lista .='</div>';
			    }else{
			    	$codempresa = 'Oferta Abierta';
			    }
				if(strlen($numero) > 3 && strlen($codempresa) > 3){
				$lista .='    <button type="button" onClick="notificarficha('.$id.');" class="btn btn-primary">Notificar Ficha Creada</button>';
				}
				$lista .='  </form>';
				$lista .='  </div>';
				$lista .='  <div class="col-6">';
				$lista .='	<div class="form-check">';
				$lista .='	  <input class="form-check-input" type="checkbox" value="" id="instruno">';
				$lista .='	  <label class="form-check-label" for="instruno">';
				$lista .='	    Solicitud Instructor';
				$lista .='	  </label>';
				$lista .='	</div>';
				$lista .='	<div class="form-check">';
				$lista .='	  <input class="form-check-input" type="checkbox" value="" id="empresano">';
				$lista .='	  <label class="form-check-label" for="empresano">';
				$lista .='	    La empresa no Existe en Sofia';
				$lista .='	  </label>';
				$lista .='	</div>';			
				$lista .='	<div class="form-check">';
				$lista .='	  <input class="form-check-input" type="checkbox" value="" id="programano">';
				$lista .='	  <label class="form-check-label" for="programano">';
				$lista .='	    El programa no está disponible en Sofía.';
				$lista .='	  </label>';
				$lista .='	</div><hr>';								
				$lista .='    <button id="btnnovedad'.$id.'" onClick="novedarcrear('.$id.');" class="btn btn-warning btn-sm button">Notificar Novedad</button>';
				$lista .='  </div>';			
				$lista .='</div>';	
				$lista .= $a -> verprogramaciona($id);							            
	            $respuesta = '1';
		 		$newdata =  array (
				  'respuesta' => $respuesta,
				  'lista' => $lista
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
 echo  json_encode($arrDatos);
}

public static function verprogramaciona($idficha){
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
			$lista .= '<span>'.$dia.' </span>';
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
return $lista; 
}

public static function verbitacora($idficha){
$respuesta = '0';	
$lista = '';
$tmes = '';
$tdiasemana = '';
$tinicia = '';
if(isset($_SESSION['prc_idusuario'])){
  $usuario = $_SESSION['prc_idusuario'];
  $sqlt = "SELECT fc.idusuario propietario, fc.numero, b.nestado, b.descripcion, b.fecha, b.hora, u.nombre, b.idusuario FROM fcaracterizacion fc INNER JOIN bitacoraestados b ON fc.id = b.idficha INNER JOIN usuarios u ON b.idusuario = u.id  WHERE b.idficha = '$idficha' ORDER BY b.fecha, b.hora ASC";
}
  		$stmt = Conexion::conectar()->prepare($sqlt);
   		$stmt -> execute();
		if($stmt->rowCount() > 0){
		$respuesta = '1';	
		$registros = $stmt->fetchAll();	
		$ban = 0;
		$thoras = 0;
		foreach ($registros as $key => $value){
			$nestado = $value['nestado'];
			$descripcion = $value['descripcion'];
			$fecha = $value['fecha'];
			$hora = $value['hora'];
			$nombre = $value['nombre'];
			$propietario = $value['propietario'];
			$idusuario = $value['idusuario'];
			$numero = $value['numero'];			
			if($ban == 0 ){
				$lista .='<div class="table-responsive">';
				$lista .='<caption>LISTADO DE EVENTOS FICHA '.$numero.'</caption>';			
				$lista .='<table class="table table-striped">';
				$lista .='<thead>';
				$lista .='  <tr class="table-active">';
				$lista .='    <th scope="row">ESTADO</th>';
				$lista .='    <th scope="row">DESCRIPCION</th>';
				$lista .='    <th scope="row">FECHA</th>';
				$lista .='    <th scope="row">HORA</th>';
				 
				$lista .='    <th scope="row">USUARIO</th>  ';    
			    
				$lista .='  </tr>';
				$lista .='</thead>';
				$lista .='<tbody> '; 
				$ban = 1;
			}

			$lista .='<tr>';
			$lista .='  <td>'.$nestado.'</td>';
			$lista .='  <td>'.$descripcion.'</td>';
			$lista .='  <td>'.$fecha.'</td>';
			$lista .='  <td>'.$hora.'</td> '; 
			$lista .='  <td>'.$nombre.'</td>  ';
			$lista .='</tr>';

		} 
	$lista .='  </tbody>';	
	$lista .='</table>';
	$lista .='</div>	';	
	}  
      $newdata =  array (
       'respuesta' => '1',
       'bitacora' =>  $lista
     );  
	     $arrDatos[] = $newdata;  
	 echo json_encode($arrDatos); 
}

public static function verMibitacora($idficha){
$respuesta = '0';	
$lista = '';
$tmes = '';
$tdiasemana = '';
$tinicia = '';
if(isset($_SESSION['prc_idusuario'])){
   $usuario = $_SESSION['prc_idusuario'];
   $sqlt = "SELECT fc.idusuario propietario, fc.numero, b.nestado, b.descripcion, b.fecha, b.hora, u.nombre, b.idusuario FROM fcaracterizacion fc INNER JOIN bitacoraestados b ON fc.id = b.idficha INNER JOIN usuarios u ON b.idusuario = u.id  WHERE b.idficha = '$idficha' ORDER BY b.fecha, b.hora ASC";
  }
  		$stmt = Conexion::conectar()->prepare($sqlt);
   		$stmt -> execute();
		if($stmt->rowCount() > 0){
		$respuesta = '1';	
		$registros = $stmt->fetchAll();	
		$ban = 0;
		$thoras = 0;
		foreach ($registros as $key => $value){
			$nestado = $value['nestado'];
			$descripcion = $value['descripcion'];
			$fecha = $value['fecha'];
			$hora = $value['hora'];
			$nombre = $value['nombre'];
			$propietario = $value['propietario'];
			$idusuario = $value['idusuario'];
			$numero = $value['numero'];			
			if($ban == 0 ){
				$lista .='<div class="table-responsive">';
				$lista .='<caption>LISTADO DE EVENTOS FICHA '.$numero.'</caption>';			
				$lista .='<table class="table table-striped">';
				$lista .='<thead>';
				$lista .='  <tr class="table-active">';
				$lista .='    <th scope="row">ESTADO</th>';
				$lista .='    <th scope="row">DESCRIPCION</th>';
				$lista .='    <th scope="row">FECHA</th>';
				$lista .='    <th scope="row">HORA</th>';
				$lista .='  </tr>';
				$lista .='</thead>';
				$lista .='<tbody> '; 
				$ban = 1;
			}

			$lista .='<tr>';
			$lista .='  <td>'.$nestado.'</td>';
			$lista .='  <td>'.$descripcion.'</td>';
			$lista .='  <td>'.$fecha.'</td>';
			$lista .='  <td>'.$hora.'</td> '; 
			$lista .='</tr>';

		} 
	$lista .='  </tbody>';	
	$lista .='</table>';
	$lista .='</div>	';	
	}  
      $newdata =  array (
       'respuesta' => '1',
       'bitacora' =>  $lista
     );  
	     $arrDatos[] = $newdata;  
	 echo json_encode($arrDatos); 
}

public static function verprogramacion($idficha){
$respuesta = '0';	
$lista = '';
$tmes = '';
$tdiasemana = '';
$tinicia = '';
$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$dias=array(0=>"Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" );
  $sqlt = "SELECT pr.ano, pr.mes, pr.diasemana, pr.horas, pr.inicia, pr.finaliza, pr.dia, pr.festivo, pr.estado, pr.novedad, fc.lugar, fc.direccion, fc.numero  FROM programacion pr INNER JOIN fcaracterizacion fc ON pr.idficha = fc.id WHERE pr.idficha = '$idficha' AND pr.estado = '1' ORDER BY pr.mes, pr.inicia, pr.finaliza, pr.diasemana, pr.dia ASC";
  		$stmt = Conexion::conectar()->prepare($sqlt);
   		$stmt -> execute();
		if($stmt->rowCount() > 0){
		$respuesta = '1';	
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
			$lugar = $value['lugar'];
			$numero = $value['numero'];
			$direccion = $value['direccion'];
			if($ban == 0){
				$tinicia = $inicia;
				$tfinaliza = $finaliza;
				$tdiasemana = $diasemana;
				$tmes = $mes;

				$lista .='<tr class="table-warning">';
				$lista .='<td colspan="2">'; 
				$lista .='<h3>'.$numero.'<br>'.$lugar.'<br>'.$direccion.'</h3>';	
				$lista .='</td>';
				$lista .='</tr>';


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
			$lista .= '<h3><span class="badge badge-danger">'.$dia.' </span></h3>';	
			}else{
			$lista .= '<h3><span class="badge badge-secondary" >'.$dia.' </span></h3>';
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
       'respuesta' => '1',
       'horario' =>  $lista
     );  
	     $arrDatos[] = $newdata;  
	 echo json_encode($arrDatos); 
}
	
public static function sendProgramar($idficha){
	include_once "../../routes/config.php"; 
	$ruta = SERVERURL;  
	$ip = $_SERVER["REMOTE_ADDR"]; 
	$fecha = date("Y-m-d");
	$hora = date('H:i:s'); 	
	$texto = '';
	if(isset($_SESSION['prc_idusuario'])){    			
		$idusuario = $_SESSION['prc_idusuario'];
		$respuesta = '0';			
		$sqlt = "SELECT numero, codempresa  FROM fcaracterizacion WHERE id = '$idficha' ";
		$stmt = Conexion::conectar()->prepare($sqlt);
		$stmt -> execute();
		if($stmt -> rowcount() > 0){
			$registros = $stmt->fetchAll();	
			foreach ($registros as $key => $value) {
				$numero = $value['numero'];
				$codigo = $value['codempresa'];
			}
			if(strlen($numero) >= 2){
				$a = new FichasModel();
			    $sqlt = "UPDATE fcaracterizacion SET estado = '5' WHERE id = '$idficha' AND estado = '4'";
	    		$stmt = Conexion::conectar()->prepare($sqlt);
	    		$stmt -> execute();
	    		$result = $stmt->rowCount();
				if($result > 0){
				  $respuesta = '1';
				  $sql2 = "UPDATE bitacoraestados SET visible = '0' WHERE idficha = '$idficha'";
					$stmt = Conexion::conectar()->prepare($sql2);
					$stmt -> execute();   

				   $sql3 = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$idficha', '$idusuario', 'Publicada', '$fecha', '$hora','Publicada en Sofía','1','$ip','5');";	
					$stmt = Conexion::conectar()->prepare($sql3);
					$stmt -> execute(); 
				}else{
					$respuesta = '0';
				}
	     	}else{
	     		$respuesta = '0';
	     	}
		  }
		}else{
			$respuesta = '5';
		}	
      $newdata =  array (
       'respuesta' => $respuesta,
	   'ruta' => $ruta
     );  
     $arrDatos[] = $newdata;  
 echo json_encode($arrDatos);
}

	public function notpublicarficha($idficha){
		date_default_timezone_set('America/Bogota'); 
		$ip = $_SERVER["REMOTE_ADDR"]; 
		$fecha = date("Y-m-d");
		$hora = date('H:i:s'); 	
		$texto = '';
		if(isset($_SESSION['prc_idusuario'])){    			
			$idusuario = $_SESSION['prc_idusuario'];
			$respuesta = '0';			
			$sqlt = "SELECT numero, codempresa  FROM fcaracterizacion WHERE id = '$idficha' ";
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
			if($stmt -> rowcount() > 0){
				$registros = $stmt->fetchAll();	
				foreach ($registros as $key => $value) {
					$numero = $value['numero'];
					$codigo = $value['codempresa'];
				}
				if(strlen($numero) >= 2){
					$a = new FichasModel();
				    $a ->notificarficha($idficha); //Enviar correo de notificación
				    $sqlt = "UPDATE fcaracterizacion SET estado = '5' WHERE id = '$idficha' AND estado = '4'";
		    		$stmt = Conexion::conectar()->prepare($sqlt);
		    		$stmt -> execute();
		    		$result = $stmt->rowCount();
					if($result > 0){
					  $respuesta = '1';
					  $sql2 = "UPDATE bitacoraestados SET visible = '0' WHERE idficha = '$idficha' ";
						$stmt = Conexion::conectar()->prepare($sql2);
						$stmt -> execute();   

					   $sql3 = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$idficha', '$idusuario', 'Publicada', '$fecha', '$hora','Publicada en Sofía','1','$ip','5');";	
						$stmt = Conexion::conectar()->prepare($sql3);
						$stmt -> execute(); 
					}else{
						$respuesta = '0';
					}
		     	}else{
		     		$respuesta = '0';
		     	}
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

public function notificarFicha($idficha){ ///////////////////////
$lista ='';	
$sqlt = "SELECT f.numero, f.codempresa, f.horas, f.finicia, f.ffinaliza, f.idprograma, f.estado, f.idusuario, f.usuario, f.numero, f.codempresa, f.lugar, f.direccion, f.ofertaabierta, f.idempresa, e.nit, p.codigo, p.nombre nombre_formacion , u.nombre nombre_usuario, u.correosena, u.correootro FROM fcaracterizacion f INNER JOIN empresas e ON f.idempresa = e.id INNER JOIN formaciones p ON f.idprograma = p.id INNER JOIN usuarios u ON f.idusuario = u.id WHERE f.id  = '$idficha'";
	$stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value){
			$idusuario = $value['idusuario'];
			$numero = $value['numero'];
			$codempresa = $value['codempresa'];
			$correosena = $value['correosena'];
			$correootro = $value['correootro'];
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

			if($value['ofertaabierta'] == 'N'){
			   $sqlt = "SELECT nombre, direccion, nit FROM empresas WHERE id = '$idempresa'";
			   $stmt = Conexion::conectar()->prepare($sqlt);
			   $stmt -> execute();
			        if($stmt->rowCount() > 0){
			        $registros = $stmt->fetchAll(); 
			        foreach ($registros as $key => $valueEm){
			             $nombre = $valueEm['nombre'];
			             $nit = $valueEm['nit'];  
			        }           
			    } 
			}

	$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
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
	$asunto = $codigo." FORMACION ".$nombre_formacion." HORAS ".$horas_formacion; 
	$cuerpo = ' 
	<html> 
	<head> 
	<title>'.$codigo.' FORMACION '.$nombre_formacion.' HORAS '.$horas_formacion.'</title> 
	</head> 
	<body> 
	<h2>'.$nombre_usuario.'</h2>
	<h3>'.$codigo.' FORMACION '.$nombre_formacion.' HORAS '.$horas_formacion.' FICHA '.$numero.' CODIGO EMPRESA '.$codempresa.'</h3>
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
				</tr>';

             if($value['ofertaabierta'] == 'N'){
			    $cuerpo .= ' <tr>		
			    <tr>				
					<td>COD_EMPRESA</td><td>'.$codempresa.'</td>
				</tr>				  
			    <tr>
					<td>NIT</td><td>'.$nit.'</td>
				</tr>	
			    <tr>				
					<td>EMPRESA</td><td>'.$nombre.'</td>
				</tr>	
			    <tr>';
			    }					
				$cuerpo .= ' 		
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
	<hr>
      <p>La ficha ya se encuentra publicada en Sofia.<p>
      <p>Este correo es informativo y fue generado de forma automática, <b>no es necesario responder este correo.</b><p>
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
	//$headers .= "Cco: ".$correosena."\r\n"; 
	//direcciones que recibirán copia oculta 
	$headers .= "Bcc: erpprogramacion@gmail.com\r\n"; 
	mail($correosena.'@sena.edu.co',$asunto,$cuerpo,$headers);	
	mail($correootro,$asunto,$cuerpo,$headers);	
	//Envair Mail Fin 
	
  } 
  return true;
}
/***********************************************/
public function enviarMensaje($datos){  
	$idficha = $datos['idficha'];
	$instructor = $datos['instructor'];
	$numero = $datos['numero'];
	$correosena = $datos['correosena'];
	$correootro = $datos['correootro'];
	$asunto = $datos['asunto'];
	$mensaje = $datos['mensaje'];
	$tasunto = $numero."  ".$asunto; 
	$cuerpo = ' 
	<html> 
	<head> 
	<title>MENSAJE PARA :'.$instructor.'</title> 
	</head> 
	<body> 
	<h2>MENSAJE PARA : '.$instructor.' FICHA CON RELACIÓN A LA FICHA '.$numero.'</h2>
	<hr>
     '.$mensaje.'
	<hr>
      <p>Este correo es informativo y fue generado de forma automática.<p>
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
	//$headers .= "Cco: ".$correosena."\r\n"; 
	//direcciones que recibirán copia oculta 
	$headers .= "Bcc: erpprogramacion@gmail.com\r\n"; 
	mail($correosena.'@sena.edu.co',$tasunto,$cuerpo,$headers);	
	mail($correootro,$tasunto,$cuerpo,$headers);	
	//Envair Mail Fin 
	      $newdata =  array (
	       'respuesta' => '1',
	       'cuerpo' => $cuerpo
	     );  
	     $arrDatos[] = $newdata;   
	 return json_encode($arrDatos);
}
/***********************************************/
public function novpublicarficha($datos){
include_once "../../routes/config.php";
$ruta = SERVERURL; 	
		date_default_timezone_set('America/Bogota'); 
		$ip = $_SERVER["REMOTE_ADDR"]; 
		$fecha = date("Y-m-d");
		$hora = date('H:i:s'); 		
		$idficha = $datos['idficha'];
		$empresano = $datos['empresano'];
		$instruno = $datos['instruno'];
		$programano = $datos['programano'];
		$explicacion = '';
		if($empresano == '1'){
			$explicacion = 'Empresa no existe en SOFIA.';
		}
		if($programano == '1'){
			$explicacion = $explicacion .= ' Programa No Disponible.';
		}
		if($instruno == '1'){
			$explicacion = $explicacion .= ' Solicitud Instructor.';
		}		
		$explicacion = htmlentities($explicacion);
		if(isset($_SESSION['prc_idusuario'])){
			$idusuario = $_SESSION['prc_idusuario']; 
			$sql2 = "UPDATE bitacoraestados SET visible = '0' WHERE idficha = '$idficha' ";
			$stmt = Conexion::conectar()->prepare($sql2);
			$stmt -> execute();  
			$respuesta = '0';
			$sql1 = "UPDATE fcaracterizacion SET estado = '2', alarmada = '1', validacion = '0'  WHERE id = '$idficha' AND estado = '4'";
	    		$stmt = Conexion::conectar()->prepare($sql1);
	    		$stmt -> execute();
	    		$result = $stmt->rowCount();
				if($result > 0){
				  $respuesta = '1';
				  $sql2 = "UPDATE bitacoraestados SET visible = '0' WHERE idficha = '$idficha'";
					$stmt = Conexion::conectar()->prepare($sql2);
					$stmt -> execute();   
				   $sql3 = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$idficha', '$idusuario', 'No_Publicada', '$fecha', '$hora','$explicacion','1','$ip','2');";	
					$stmt = Conexion::conectar()->prepare($sql3);
					$stmt -> execute();	
					$a = new FichasModel();
				    $texto =  $a ->notnovpublicarficha($idficha, $explicacion, $empresano, $programano, $instruno); 
				    $validacion = '0';	
				    $mensajeRespuesta = array();
		    	      $newdata = array( 
						'tipo' => 'warning',     	      	
						'mensaje'=>$explicacion
				  	   );		
		    	    array_push($mensajeRespuesta,$newdata);	
		    	    $tvalidacion = json_encode($mensajeRespuesta);
				    $sqlt = "UPDATE fcaracterizacion SET validacion = '$validacion', tvalidacion = '$tvalidacion' WHERE id = '$idficha'";
					$stmt = Conexion::conectar()->prepare($sqlt);
					$stmt -> execute();
				}else{
					$respuesta = '0'; 
				}
			}else{
				$respuesta = '5';
			}	
	      $newdata =  array (
	       'respuesta' => $respuesta,
	       'ruta' => $ruta  
	     );  
	     $arrDatos[] = $newdata;   
	 echo json_encode($arrDatos);
}

public function notnovpublicarficha($idficha, $explicacion, $empresano, $programano, $instruno){
$lista ='';	
$sqlt = "SELECT f.numero, f.codempresa, f.horas, f.finicia, f.ffinaliza, f.idprograma, f.estado, f.idusuario, f.usuario, f.numero, f.codempresa, f.lugar, f.direccion, f.ofertaabierta, f.idempresa, p.codigo, p.nombre nombre_formacion , u.nombre nombre_usuario, u.correosena, u.correootro, f.ccentro, f.coordinacion FROM fcaracterizacion f INNER JOIN formaciones p ON f.idprograma = p.id INNER JOIN usuarios u ON f.idusuario = u.id WHERE f.id  = '$idficha'";
	$stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value){
					$ccentro  = $value['ccentro'];
					$coordinacion = $value['coordinacion'];
					$idusuario = $value['idusuario'];
					$nit = $value['nit'];
					$numero = $value['numero'];
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
			if($value['ofertaabierta'] == 'N'){
			   $sqlt = "SELECT nombre, direccion, nit FROM empresas WHERE id = '$idempresa'";
			   $stmt = Conexion::conectar()->prepare($sqlt);
			   $stmt -> execute();
			        if($stmt->rowCount() > 0){
			        $registros = $stmt->fetchAll(); 
			        foreach ($registros as $key => $valueEm){
			             $nombre = $valueEm['nombre'];
			             $nit = $valueEm['nit'];
			             $direccion = $valueEm['direccion'];             
			        }           
			    } 
			} 
	$asunto = "FICHA NO PUBLICADA ".$codigo." FORMACION ".$nombre_formacion." HORAS ".$horas_formacion; 
	$cuerpo = ' 
	<html> 
	<head> 
	<title>FICHA NO PUBLICADA</title> 
	</head> 
	<body> 
	<h1>'.$explicacion.'</h1>';

		if($empresano == '1'){
			$cuerpo .= '<p>Los datos de la empresa '.$nombre.' no aparecen creados en Sofia. Debe presentar certificado de camara de comercio y RUT para crear la empresa en la plataforma Sofía.</p>';
		}
		if($programano == '1'){
			$cuerpo .= '<p>El programa de formación no se encuentra en estado En Ejcución en Sofia. Debe seleccionar un nuevo programa o acercarse a la oficina de Gestión Académica del centro de formación para revisar que programa se encuentra disponible.</p>';
		}		

	$cuerpo .= '<h1>Se requiere que corrija los datos pronto, de lo contrario la ficha no se creará dentro de los tiempos requeridos.</h1>
	<h2>'.$nombre_usuario.'</h2>
	<h3>'.$codigo.' FORMACION '.$nombre_formacion.' HORAS '.$horas_formacion.' FICHA '.$numero.' 
	</h3>
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
				</tr>';
				if($value['ofertaabierta'] == 'N'){
			    $cuerpo .= ' <tr>				
					<td>COD_EMPRESA</td><td>'.$codempresa.'</td>
				</tr>				  
			    <tr>
					<td>NIT</td><td>'.$nit.'</td>
				</tr>	
			    <tr>				
					<td>EMPRESA</td><td>'.$nombre.'</td>
				</tr>';
				}	

			    $cuerpo .= '<tr>					
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
	$a = new FichasModel();
	$ccoordinador = $a-> traerCorreoCoordinador($ccentro,$coordinacion);
	mail($ccoordinador.'@sena.edu.co',$asunto,$cuerpo,$headers);		
	mail($correootro,$asunto,$cuerpo,$headers);	
	//Envair Mail Fin 
  } 
  return true;
}


/******************************************/

public function novedadFicha($datos){
include_once "../../routes/config.php";
$ruta = SERVERURL; 	
		date_default_timezone_set('America/Bogota'); 
		$ip = $_SERVER["REMOTE_ADDR"]; 
		$fecha = date("Y-m-d");
		$hora = date('H:i:s'); 		
		$idficha = $datos['idficha'];
		$explicacion = strtoupper($datos['explicacion']);
		$explicacion = htmlentities($explicacion);
		if(isset($_SESSION['prc_idusuario'])){
			$idusuario = $_SESSION['prc_idusuario'];

			$sql2 = "UPDATE reservaregistro SET estado = '0' WHERE idregistro = '$idficha' AND idusuario = '$idusuario';";
			$stmt = Conexion::conectar()->prepare($sql2);
			$stmt -> execute();

			$respuesta = '0';
			$sql1 = "UPDATE fcaracterizacion SET estado = '2', alarmada = '1', validacion = '0'  WHERE id = '$idficha' AND estado = '5'";
	    		$stmt = Conexion::conectar()->prepare($sql1);
	    		$stmt -> execute();
	    		$result = $stmt->rowCount();
				if($result > 0){
				  $respuesta = '1';
				  $sql2 = "UPDATE bitacoraestados SET visible = '0' WHERE idficha = '$idficha'";
					$stmt = Conexion::conectar()->prepare($sql2);
					$stmt -> execute();   
				   $sql3 = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$idficha', '$idusuario', 'No_Programada', '$fecha', '$hora','$explicacion','1','$ip','2');";	
					$stmt = Conexion::conectar()->prepare($sql3);
					$stmt -> execute();	
					$a = new FichasModel();
				    $texto =  $a ->notificarNovedadficha($idficha, $explicacion); 
				    $validacion = '0';	
				    $mensajeRespuesta = array();
		    	      $newdata = array( 
						'tipo' => 'warning',     	      	
						'mensaje'=>$explicacion
				  	   );		
		    	    array_push($mensajeRespuesta,$newdata);	
		    	    $tvalidacion = json_encode($mensajeRespuesta);
				    $sqlt = "UPDATE fcaracterizacion SET validacion = '$validacion', tvalidacion = '$tvalidacion' WHERE id = '$idficha'";
					$stmt = Conexion::conectar()->prepare($sqlt);
					$stmt -> execute();
				}else{
					$respuesta = '0'; 
				}
			}else{
				$respuesta = '5';
			}	
	      $newdata =  array (
	       'respuesta' => $respuesta,
	       'ruta' => $ruta  
	     );  
	     $arrDatos[] = $newdata;   
	 echo json_encode($arrDatos);
}

public static function pendienteFicha($datos){
include_once "../../routes/config.php";
$ruta = SERVERURL; 	
		date_default_timezone_set('America/Bogota'); 
		$ip = $_SERVER["REMOTE_ADDR"]; 
		$fecha = date("Y-m-d");
		$hora = date('H:i:s'); 		
		$idficha = $datos['idficha'];
		$explicacion = strtoupper($datos['explicacion']);
		$explicacion = htmlentities($explicacion);
		if(isset($_SESSION['prc_idusuario'])){
			$idusuario = $_SESSION['prc_idusuario'];
			$ccentro = $_SESSION['prc_centro'];
			$sqlt = "UPDATE reservaregistro SET centro = '$ccentro', estado = '0', sgs = '0', pendiente = '1', tpendiente = '$explicacion' WHERE idregistro = '$idficha' AND idusuario = '$idusuario';";
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
	       'ruta' => $ruta,
	       'sqlt' => $sqlt  
	     );  
	     $arrDatos[] = $newdata;   
	 echo json_encode($arrDatos);
}

public static function sgsrespuestaFicha($datos){
include_once "../../routes/config.php";
$ruta = SERVERURL; 	
date_default_timezone_set('America/Bogota'); 
$ip = $_SERVER["REMOTE_ADDR"]; 
$fecha = date("Y-m-d");
$hora = date('H:i:s'); 		
$idficha = $datos['idficha'];
$explicacion = strtoupper($datos['explicacion']);
$explicacion = htmlentities($explicacion);
if(isset($_SESSION['prc_idusuario'])){
	$idusuario = $_SESSION['prc_idusuario'];
	$ccentro = $_SESSION['prc_centro'];
	$sql2 = "UPDATE reservaregistro SET sgs = '1',  tsgs = '$explicacion' WHERE idregistro = '$idficha';";
	$stmt = Conexion::conectar()->prepare($sql2);
	$stmt -> execute();
	$result = $stmt->rowCount();
		if($result > 0){
		  $respuesta = '1';
		}
	}else{
		$respuesta = '5';
	}	
  $newdata =  array (
   'respuesta' => $respuesta,
   'ruta' => $ruta  
 );  
 $arrDatos[] = $newdata;   
 echo json_encode($arrDatos);
}


public function notificarNovedadficha($idficha, $explicacion){
$lista ='';	
$sqlt = "SELECT f.numero, f.codempresa, f.horas, f.finicia, f.ffinaliza, f.idprograma, f.estado, f.idusuario, f.usuario, f.numero, f.codempresa, f.lugar, f.direccion, f.idempresa, f.ofertaabierta, p.codigo, p.nombre nombre_formacion , u.nombre nombre_usuario, u.correosena, u.correootro, f.ccentro, f.coordinacion FROM fcaracterizacion f  INNER JOIN formaciones p ON f.idprograma = p.id INNER JOIN usuarios u ON f.idusuario = u.id WHERE f.id  = '$idficha'";
	$stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
		if($stmt->rowCount() > 0){
		$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value){
			$ccentro  = $value['ccentro'];
			$coordinacion = $value['coordinacion'];
			$idusuario = $value['idusuario'];
			$idempresa = $value['idempresa'];
			$nit = $value['nit'];
			$numero = $value['numero'];
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
 
		   $sqlt = "SELECT nombre, nit  FROM empresas WHERE id = '$idempresa'";
		   $stmt = Conexion::conectar()->prepare($sqlt);
		   $stmt -> execute();
		        if($stmt->rowCount() > 0){
		        $registros = $stmt->fetchAll(); 
		        foreach ($registros as $key => $valueEm){
						$nombre = html_entity_decode(strtolower($valueEm['nombre']));
						$nombre = ucwords($nombre);
						$nit = $valueEm['nit'];
		        }           
		    } 


	$asunto = "FICHA NO PROGRAMADA ".$codigo." FORMACION ".$nombre_formacion." HORAS ".$horas_formacion; 
	$cuerpo = ' 
	<html> 
	<head> 
	<title>FICHA NO PROGRAMADA</title> 
	</head> 
	<body> 
	<h1>'.$explicacion.'</h1>
	<h1>Se requiere que corrija los datos pronto, de lo contrario las horas no se verán reflejadas en la plataforma por favor.</h1>
	<h2>'.$nombre_usuario.'</h2>
	<h3>'.$codigo.' FORMACION '.$nombre_formacion.' HORAS '.$horas_formacion.' FICHA '.$numero.' </h3>
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
				</tr>';
				if($value['ofertaabierta'] == 'N'){
			    $cuerpo .= '
				    <tr>				
						<td>COD_EMPRESA</td><td>'.$codempresa.'</td>
					</tr>				  
				    <tr>
						<td>NIT</td><td>'.$nit.'</td>
					</tr>	
				    <tr>				
						<td>EMPRESA</td><td>'.$nombre.'</td>
					</tr>';	
			    }
			    $cuerpo .= '
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
	$a = new FichasModel();
	$ccoordinador = $a-> traerCorreoCoordinador($ccentro,$coordinacion);
	mail($ccoordinador.'@sena.edu.co',$asunto,$cuerpo,$headers);		
	mail($correootro,$asunto,$cuerpo,$headers);	
	//Envair Mail Fin 
  } 
  return true;
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
				  $a = new FichasModel();
				  $respuesta = $a -> notificarNoconforme($centro,$idempresa,$idus, $explicacion); 
				 
			}else{
				$respuesta = '5';
			}	
	      $newdata =  array (
	       'respuesta' => $respuesta 
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

	$asunto = 'Novedad al Validar Contacto Empresa '.$empresa; 
	$cuerpo = ' 
	<html> 
	<head> 
	<title>NOVEDAD EN LA VALIDACIÓN</title> 
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
	//mail($correosena.'@sena.edu.co',$asunto,$cuerpo,$headers);
	$a = new FichasModel();
	$ccoordinador = $a-> traerCorreoCoordinador($centro,$coordinacion);
	mail($ccoordinador.'@sena.edu.co',$asunto,$cuerpo,$headers);		
	//mail($correootro,$asunto,$cuerpo,$headers);	
	//Envair Mail Fin 
  } 
  return '1';
}


/********************************************/
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
public static function programadoFicha($idficha){
include_once "../../routes/config.php";
$ruta = SERVERURL; 	
date_default_timezone_set('America/Bogota'); 
$ip = $_SERVER["REMOTE_ADDR"]; 
$fecha = date("Y-m-d");
$hora = date('H:i:s'); 	
	if(isset($_SESSION['prc_idusuario'])){
		$idusuario = $_SESSION['prc_idusuario'];
		$respuesta = '0';
		$sql2 = "UPDATE reservaregistro SET estado = '0' WHERE idregistro = '$idficha' AND idusuario = '$idusuario';";
		$stmt = Conexion::conectar()->prepare($sql2);
		$stmt -> execute();
		$sqlt = "UPDATE fcaracterizacion SET estado = '6' WHERE id = '$idficha' AND estado = '5'";
    		$stmt = Conexion::conectar()->prepare($sqlt);
    		$stmt -> execute();
    		$result = $stmt->rowCount();
			if($result > 0){
			  $respuesta = '1';
			  $sql2 = "UPDATE bitacoraestados SET visible = '0' WHERE idficha = '$idficha'";
				$stmt = Conexion::conectar()->prepare($sql2);
				$stmt -> execute();   
			   $sql3 = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$idficha', '$idusuario', 'Programada', '$fecha', '$hora','Publicada y Programada','1','$ip','6');";	
				$stmt = Conexion::conectar()->prepare($sql3);
				$stmt -> execute();

			}else{
				$respuesta = '0';
			}
		}else{
			$respuesta = '5';
		}	
      $newdata =  array (
       'respuesta' => $respuesta,
       'ruta' => $ruta   
     );  
     $arrDatos[] = $newdata;   
 echo json_encode($arrDatos);
}

public function upnumeroficha($datos){
		date_default_timezone_set('America/Bogota'); 
		$ip = $_SERVER["REMOTE_ADDR"]; 
		$fecha = date("Y-m-d");
		$hora = date('H:i:s'); 	
		$idficha = $datos['idficha'];
		$numero = $datos['numero'];	
		if(isset($_SESSION['prc_idusuario'])){
			$idusuario = $_SESSION['prc_idusuario'];
			$respuesta = '0';
			$sqlt = "UPDATE fcaracterizacion SET numero = '$numero' WHERE id = '$idficha' AND estado = '4'";
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
	       'dato'=> $numero 
	     );  
	     $arrDatos[] = $newdata;   
	 echo json_encode($arrDatos);
	}	

	public function upcodempresa($datos){
		date_default_timezone_set('America/Bogota'); 
		$ip = $_SERVER["REMOTE_ADDR"]; 
		$fecha = date("Y-m-d");
		$hora = date('H:i:s'); 	
		$idficha = $datos['idficha'];
		$codigo = $datos['codigo'];	
		if(isset($_SESSION['prc_idusuario'])){
			$idusuario = $_SESSION['prc_idusuario'];
			$respuesta = '0';
			$sqlt = "UPDATE fcaracterizacion SET codempresa = '$codigo' WHERE id = '$idficha' AND estado = '4'";
	    		$stmt = Conexion::conectar()->prepare($sqlt);
	    		$stmt -> execute();
	    		$result = $stmt->rowCount();
				if($result > 0){
				  $respuesta = '1';
				 /* $sql2 = "UPDATE bitacoraestados SET visible = '0' WHERE idficha = '$idficha' AND estado = '5'";
					$stmt = Conexion::conectar()->prepare($sql2);
					$stmt -> execute();   

				   $sql3 = "INSERT INTO bitacoraestados (idficha, idusuario, nestado, fecha, hora, descripcion, visible, ip, estado) VALUES ('$idficha', '$idusuario', 'Creada', '$fecha', '$hora','Creada','1','$ip','5');";	
					$stmt = Conexion::conectar()->prepare($sql3);
					$stmt -> execute();	*/
				}else{
					$respuesta = '0';
				}
			}else{
				$respuesta = '5';
			}	
	      $newdata =  array (
	       'respuesta' => $respuesta,
	       'dato'=> $codigo 
	     );  
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
}

