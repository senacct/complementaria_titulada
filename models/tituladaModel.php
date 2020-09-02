<?php
require_once "conexion.php";
date_default_timezone_set('America/Bogota'); 
 
	session_start();
$fecha = date("Y-m-d");
$hora = date('H:i:s');

class TituladaModel{

 public function __construct() {
	//require_once "conexion.php";
 }
 public function decode_entities($text){ 
    return html_entity_decode($text);
 } 

/****************************/
public static function verHinstructor($id, $idFicha,$vinculacion,$modificar,$trimestreSel = 0,$anoSel = 0){
$f = new TituladaModel(); 

$ip = $_SERVER["REMOTE_ADDR"]; 
date_default_timezone_set('America/Bogota'); 

if($anoSel != 0 && $trimestreSel != 0){
	$dtrimestre = $f -> dtrimestreSel($anoSel,$trimestreSel);
}else{
	$dtrimestre = $f -> dtrimestre();
}

$fechainicio = $dtrimestre['fechainicio'];
$fechafin = $dtrimestre['fechafin'];
$fechainiciof = strtotime($fechainicio);
$fechafinf = strtotime($fechafin);

$fechahoy = date("Y-m-d");  
$mesInicio = date("n",$fechainiciof);
$mesFin = date("n",$fechafinf);
$diaInicio = date("d",$fechainiciof);
$diaFin = date("d",$fechafinf);
$year = date("Y");
$diaActual = date("j");

$limiteSemanalHoras= 0;

if($vinculacion == 'Planta'){
	$limiteSemanalHoras = 32;
}else{
	$limiteSemanalHoras = 40;
}


$meses = array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"); 
//$dficha = $f -> dficha($idficha);
//$numero = $dficha['numero'];
//$finicia = DateTime::createFromFormat('Y-m-d', $dficha['finicia']);
$html = '';


$ban = 0;
     $sqlt = "SELECT DISTINCT fc.id, fr.nombre, fr.nivel, fc.numero, fc.lugar, pr.mes, pr.dia, pr.inicia, pr.finaliza, pr.fecha, pr.desCompetencia, pr.desResultado, pr.idResultado as idResultado, pr.idCompetencia as idCompetencia, pr.horas, pr.ID as idProgramacion,fc.formacion_Fuera FROM formaciones fr INNER JOIN fcaracterizacion fc ON fr.id = fc.idprograma  INNER JOIN programacion pr ON fc.id = pr.idficha WHERE  fc.estado > 4 AND pr.estado = '1' AND pr.idinstructor = '$id' ORDER BY pr.mes, pr.dia, pr.inicia ;";
     $stmt = Conexion::conectar()->prepare($sqlt);
     $stmt -> execute();
     if($stmt->rowCount() > 0){
           $registros = $stmt->fetchAll();
           $ban = 1;
           //echo json_encode($registros);
     }
// $sqlt = "UPDATE programacion pr, fcaracterizacion fc SET pr.idinstructor = fc.idusuario WHERE fc.id = pr.idficha;"
for ($m = $mesInicio; $m < $mesFin + 1; $m++) { 
      $diaSemana = date("w",mktime(0,0,0,$m,1,$year))+7;
      $ds = date("l", mktime(0, 0, 0, 7, 1, 2000));
      $ultimoDiaMes=date("d",(mktime(0,0,0,$m+1,1,$year)-1)); 
        $html .='<table class="table table-sm table-bordered" id="calendar">';
      $html .='<thead class="thead-dark">';
      $html .='<tr>';
      $html .='<th colspan="4">'.$meses[$m].' '.$year.'</th>';
      $html .='<th colspan="4">INSTRUCTOR</th>';
      $html .='</tr>';  
      $html .='<tr>';
      $html .=' <th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th>';
      $html .=' <th>Vie</th><th>Sab</th><th>Dom</th><th>Horas</th>';
      $html .='</tr>';
      $html .='</thead>';
      $html .='<tbody>';  
      $html .='<tr>';
		$last_cell = $diaSemana + $ultimoDiaMes;
		

		//sumar horas semanales
		$horasSemana = 0;
		$contadorSemana = 0;

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
              if($day < $diaInicio && $m == $mesInicio ){
                  $html .='<td><del>'.$day.'</del></td>'; 
              } else {
                if($day > $diaFin && $m == $mesFin){
                  $html .='<td><del>'.$day.'</del></td>';
                 }else{
                  //$html.= $f->activo('$idficha', $day, $m, $year, $ds, $festivo);
                  /********************/
                    $ban = 0;
					$dato = 'detalle <hr>';

					$html.= '<td id="b'.$m.'_'.$day.'">';
					// $html.= $f->activo2($value['id'], $day, $m, $year, $ds, $festivo);

					$html2 = '';
                    foreach ($registros as $key => $value){
                      if($value['mes'] == $m && $value['dia'] == $day){

						//se suman las horas de este dia a la semana
						$horasSemana += $value['horas'];
						$classColor = 'bg-secondary';
						if($value['formacion_Fuera'] == 1){
							$classColor = 'bg-danger';
						}

                            $dato .='<strong> Horario: </strong> '.$value['inicia'].':00 -'.$value['finaliza'].':00 <br> <strong> Ambiente: </strong> '.$value['lugar'].'<br> <strong> FICHA: </strong> ' . $value['numero'].'<br> ';
							if($value['nivel'] == '0' ){
								$dato .= $value['nombre'].'<hr>';
							}else{
								$dato .= $value['nombre'].'<br>';
								
								$dato .= '<button id="res'.$value['mes'].'_'.$value['dia'].'_'.$value['inicia'].'_'.$value['finaliza'].'" ';
									$dato .= 'onClick="verResultadosHorario('.$value['idProgramacion'].','.$modificar.')"';
									$dato .= ' class="btn btn-primary text-white" ';
									$dato .= ' type="button"> Consultar Resultados <i class="fas fa-list-ol"></i></button>';            

									
									$dato .= $value['desCompetencia'].'<br>';
									$dato .= $value['desResultado'];
								 

								if($modificar == 1){
									$dato .= '<button id="d'.$value['mes'].'_'.$value['dia'].'_'.$value['inicia'].'_'.$value['finaliza'].'" ';
									$dato .= 'onClick="unselCalendario('.$value['id'].','.$year.','.$m.','.$day.','.$ds.','.$value['inicia'].','.$value['finaliza'].','.$festivo.','.$value['idResultado'].','.$value['idCompetencia'].',\''.$value['desResultado'].'\',\''.$value['desResultado'].'\',\'1\')"';
									$dato .= ' class="btn btn-outline-default btn-sm text-white" ';
									$dato .= ' type="button"> Quitar <i class="far fa-calendar-times  "></i></button>';            
								}

								$dato .='</hr>';
								
							}    

							$ban = 1;
							if($ban == 1){
								$dato = substr($dato,0, strlen($dato) - 5);
								$html2 .='<div class="card text-white '.$classColor.' mb-3 h6">'.$dato.'</div>';
							  }

							  $dato = "";
							
                      }
					}
					//
					
					$html.= $f->activo2($value['id'], $day, $m, $year, $ds, $festivo);
                    if($ban == 1){
                      //$dato = substr($dato,0, strlen($dato) - 5);
                      $html .=$html2;
                    }
					
					$html .='</td>';
                    /********************/ 
                 }    
              }
            $day++;
            }
          // cuando llega al final de la semana, iniciamos una columna nueva
          if($i%7==0)
          {
			$contadorSemana ++;
			$html.= '<td id="bH'.$m.'_'.$contadorSemana.'" style="font-size: 24px;" align="right">'.$horasSemana.'/<strong>'.$limiteSemanalHoras.'</strong></td>';

			$html .='</tr><tr><br>';
			$horasSemana = 0;
          }
        }
      $html .='</tr>';
      $html .='<tr>';
      //$html .='<th colspan="7"><p>Hoy es '.$diaActual.' de '.$meses[$mesActual].' de '.$year.'</p></th>';
      $html .='</tr>';
      $html .='</tbody>';
    $html .='</table> ';  
}
return $html;
}

/****************************/
public static function verHficha($id, $idFicha,$modificar,$trimestreSel= 0 ,$anoSel= 0){
	$f = new TituladaModel(); 
	
	$ip = $_SERVER["REMOTE_ADDR"]; 
	date_default_timezone_set('America/Bogota'); 
	
	if($anoSel != 0 && $trimestreSel != 0){
		$dtrimestre = $f -> dtrimestreSel($anoSel,$trimestreSel);
	}else{
		$dtrimestre = $f -> dtrimestre();
	}


	//$dtrimestre = $f -> dtrimestre();
	$fechainicio = $dtrimestre['fechainicio'];
	$fechafin = $dtrimestre['fechafin'];
	$fechainiciof = strtotime($fechainicio);
	$fechafinf = strtotime($fechafin);
	
	
	$fechahoy = date("Y-m-d");  
	$mesInicio = date("n",$fechainiciof);
	$mesFin = date("n",$fechafinf);
	$diaInicio = date("d",$fechainiciof);
	$diaFin = date("d",$fechafinf);
	$year = date("Y");
	$diaActual = date("j");
	
	
	$meses = array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
	"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"); 
	//$dficha = $f -> dficha($idficha);
	//$numero = $dficha['numero'];
	//$finicia = DateTime::createFromFormat('Y-m-d', $dficha['finicia']);
	$html = '';
	$ban = 0;
		 $sqlt = "SELECT DISTINCT fr.nombre, fr.nivel, fc.numero, fc.lugar, pr.mes, pr.dia, pr.inicia, pr.finaliza, pr.fecha, pr.desCompetencia, pr.desResultado, pr.idResultado as idResultado, pr.idCompetencia as idCompetencia, u.nombre as instructor, pr.ID as idProgramacion, fc.formacion_Fuera FROM formaciones fr INNER JOIN fcaracterizacion fc ON fr.id = fc.idprograma  INNER JOIN programacion pr ON fc.id = pr.idficha INNER JOIN usuarios u ON pr.idinstructor = u.id WHERE  fc.estado > 4 AND pr.estado = '1' AND pr.idficha = '$id' ORDER BY pr.mes, pr.dia, pr.inicia ;";
		 $stmt = Conexion::conectar()->prepare($sqlt);
		 $stmt -> execute();
		 if($stmt->rowCount() > 0){
			   $registros = $stmt->fetchAll();
			   $ban = 1;
			   //echo json_encode($registros);
		 }
		 
	// $sqlt = "UPDATE programacion pr, fcaracterizacion fc SET pr.idinstructor = fc.idusuario WHERE fc.id = pr.idficha;"
	for ($m = $mesInicio; $m < $mesFin + 1; $m++) { 
		  $diaSemana = date("w",mktime(0,0,0,$m,1,$year))+7;
		  $ds = date("l", mktime(0, 0, 0, 7, 1, 2000));
		  $ultimoDiaMes=date("d",(mktime(0,0,0,$m+1,1,$year)-1)); 
			$html .='<table class="table table-sm table-bordered" id="calendar">';
		  $html .='<thead class="thead-dark">';
		  $html .='<tr>';
		  $html .='<th colspan="4">'.$meses[$m].' '.$year.'</th>';
      	  $html .='<th colspan="3">FICHA</th>';
		  $html .='</tr>';  
		  $html .='<tr>';
		  $html .=' <th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th>';
		  $html .=' <th>Vie</th><th>Sab</th><th>Dom</th>';
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
				  if($day < $diaInicio && $m == $mesInicio ){
					  $html .='<td><del>'.$day.'</del></td>'; 
				  } else {
					if($day > $diaFin && $m == $mesFin){
					  $html .='<td><del>'.$day.'</del></td>';
					 }else{
					  //$html.= $f->activo('$idficha', $day, $m, $year, $ds, $festivo);
					  /********************/
						$ban = 0;
						$dato = ' Detalle <hr>';

						$html.= '<td id="b'.$m.'_'.$day.'">';
						$html.= $f->activo2($idFicha, $day, $m, $year, $ds, $festivo);

						if(isset($registros)){
							foreach ($registros as $key => $value){

								$classColor = 'bg-dark';
								if($value['formacion_Fuera'] == 1){
									$classColor = 'bg-danger';
								}

								if($value['mes'] == $m && $value['dia'] == $day){
									$dato .= 'Instructor: '.$value['instructor'].'<br>';
									$dato .= '<strong> Horario: </strong> '.$value['inicia'].':00 -'.$value['finaliza'].':00 <br> <strong> Ambiente: </strong> '.$value['lugar'].'<br> <strong> FICHA: </strong> ' . $value['numero'].'<br>';
								  if($value['nivel'] == '0' ){
									  $dato .= $value['nombre'].'<hr>';
								  }else{
									$dato .= $value['nombre'].'<br>';
									$dato .= '<button id="resf'.$value['mes'].'_'.$value['dia'].'_'.$value['inicia'].'_'.$value['finaliza'].'" ';
									$dato .= 'onClick="verResultadosHorario('.$value['idProgramacion'].','.$modificar.')"';
									$dato .= ' class="btn btn-primary text-white" ';
									$dato .= ' type="button"> Consultar Resultados <i class="fas fa-list-ol"></i></button>';  
									
									  $dato .= $value['desCompetencia'].'<br>';
									  $dato .= $value['desResultado'];

									  
									  if($modificar == 1){
											$dato .= '<button id="d'.$value['mes'].'_'.$value['dia'].'_'.$value['inicia'].'_'.$value['finaliza'].'" ';
											$dato .= 'onClick="unselCalendario('.$idFicha.','.$year.','.$m.','.$day.','.$ds.','.$value['inicia'].','.$value['finaliza'].','.$festivo.','.$value['idResultado'].','.$value['idCompetencia'].',\''.$value['desResultado'].'\',\''.$value['desResultado'].'\',\'1\')"';
											$dato .= ' class="btn btn-outline-default btn-sm text-white" ';
											$dato .= ' type="button"> Quitar <i class="far fa-calendar-times "></i></button>'.'<hr>';            
									  }
									  
									  $dato .='</hr>';
								  } 
								  
								   
								  $ban = 1;
								  if($ban == 1){
									$dato = substr($dato,0, strlen($dato) - 5);
									$html .='<div class="card text-white '.$classColor.' mb-3 h6">'.$dato.'</div>';
									}

									$dato = "";
								}
							  }
						}
						//
						// $html.= '<td id="b'.$m.'_'.$day.'">';
						// $html.= $f->activo2($idFicha, $day, $m, $year, $ds, $festivo);
						// if($ban == 1){
						// 	$dato = substr($dato,0, strlen($dato) - 5);
						// 	$html .='<div class="card text-white bg-dark mb-3 h6">'.$dato.'</div>';
						// }
						
						$html .='</td>';
						/********************/ 
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
		  //$html .='<th colspan="7"><p>Hoy es '.$diaActual.' de '.$meses[$mesActual].' de '.$year.'</p></th>';
		  $html .='</tr>';
		  $html .='</tbody>';
		$html .='</table> ';  
	}
	return $html;
	}
	
/******************************/

function verprogramacion($idinstructor, $ano, $mes, $dia, $ds){
$respuesta = '0'; 
$lista = '';
$t = new TituladaModel();
$festivo = $t->traerFestivo($ano, $mes, $dia);  
if($festivo == '1' || $ds == '0'){
    $lista = '<span class="badge badge-danger">'.$dia.'</span>';
}else{
    $lista = '<span class="badge badge-info">'.$dia.'</span>';
}
$tmes = '';
$tdiasemana = '';
$tinicia = '';
  $sqlt = "SELECT fc.numero, fc.estado AS festado, fc.finicia, fc.ffinaliza, fc.lugar, fc.direccion, pr.ano, pr.mes, pr.diasemana, pr.horas, pr.inicia, pr.finaliza, pr.dia, pr.festivo,   pr.novedad, pr.fecha FROM programacion pr INNER JOIN fcaracterizacion fc ON fc.id = pr.idficha WHERE fc.idusuario = '$idinstructor' AND pr.ano = '$ano' AND pr.estado = '1' AND pr.mes = '$mes' AND pr.dia = '$dia' ORDER BY pr.inicia ASC";
        $stmt = Conexion::conectar()->prepare($sqlt);
        $stmt -> execute();
        if($stmt->rowCount() > 0){
        $lista = '';
        //$respuesta = '1'; 
        $ban = 0;  
        $registros = $stmt->fetchAll();         
        foreach ($registros as $key => $value){
              $numero = $value['numero'];
              $dia = $value['dia'];
              //if($ban == 1){
              //  $dia = '---';
              //}
              $ban = 1;
              $lugar = $value['lugar'];
              $direccion = $value['direccion'];
              $ano = $value['ano'];
              $mes = $value['mes'];
              $diasemana = $value['diasemana'];
              $horas = $value['horas'];
              $inicia = $value['inicia'];
              $finaliza = $value['finaliza'];
              $finicia = $value['finicia'];
              $ffinaliza = $value['ffinaliza'];
              $festivo = $value['festivo'];
              $fecha = $value['fecha'];
              $festado = $value['festado'];
               
              $icono = '';
              if($fecha == $finicia){
                $icono = '<i class="far fa-eye"></i>';
              }
              if($fecha == $ffinaliza){
                $icono = '<i class="fas fa-eye-slash"></i>';
              }
              if($diasemana == '0' || $festivo == '1' ){
              $lista .= '<span style="width:100%;"class="badge badge-danger">['.$dia.']<hr>'.$lugar.'<br>'.$direccion.'<br> '.$numero.'<br>'.$icono.'<br>('.$inicia.':00 -'.$finaliza.':00) </span> &nbsp;<br>';
              }else{
                if($numero == '0'){
              $lista .= '<span style="width:100%;"class="badge badge-secondary">['.$dia.']<hr>'.$lugar.'<br>'.$direccion.'<br>'.$numero.'<br>'.$icono.'<br>('.$inicia.':00 -'.$finaliza.':00) </span> &nbsp;<br>'; 
                }else{
              $lista .= '<span style="width:100%;"class="badge badge-info">['.$dia.']<hr>'.$direccion.'<br>'.$lugar.'<br> '.$numero.'<br>'.$icono.'<br>('.$inicia.':00 -'.$finaliza.':00) </span> &nbsp;<br>';                   
                }
              }
           }
    } 
 return $lista; 
}

/*function traerFestivo($ano, $mes, $day){
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
}*/


function jornada($idficha){
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
     return 'Inicia   '.$inicia.':00  ----  Finaliza'.$finaliza.':00';
    }

function dias($idficha){
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
/*********************************************/
public static function lprogresultado(){
	$tabla = '';
	$opciones = '';
	$a = new TituladaModel();
	if(isset($_SESSION['prc_idusuario'])){ 
	$centro = $_SESSION['prc_centro'];
	$sqlt = "SELECT cp.id cpid, cp.codigo, cp.texto competencia, rs.id rsid, rs.texto resultado FROM competencias cp INNER JOIN resultados rs ON cp.id = rs.idcompetencia WHERE cp.estado = '1' AND rs.estado = '1' AND cp.ccentro = '$centro' ORDER BY cp.id ASC;";
	$stmt = Conexion::conectar()->prepare($sqlt);
	$stmt -> execute();
	$total = $stmt->rowCount();
	if($stmt->rowCount() > 0){
	    $salida = array();		
		$respuesta = '1';
		$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value) {
            $rsid =  $value['rsid'];
            $cpid =  $value['cpid']; 
            $codigo =  $value['codigo'];            
            $lcompetencia = htmlentities($value['competencia']);
            $competencia = substr(htmlentities($value['competencia']),0,40);
            $competencia = strtolower($competencia);
            $resultado = $value['resultado'];
            $resultado = $resultado;
            $resultado = strtolower($resultado);              
			$opciones = '<button type=\"button\" onClick="selResultado('.$rsid.',\''.$lcompetencia.'\',\''.$resultado.'\',\''.$cpid.'\'); " class="btn btn-info btn-sm"><i class="fas fa-check"></i></button>';
			$newarray = array(
				"codigo" => $codigo,
				"competencia" => $competencia,
				"resultado" => $resultado,
				"seleccionar" =>$opciones	
			);
			array_push($salida, $newarray);
				//$tabla .='{"codigo":"'.$codigo.'","competencia":"'.$competencia.'","resultado":"'.$resultado.'","seleccionar":"'.$opciones.'"},';
		   }	
		 }else{
		 	    $newarray = array(
					"codigo" => 'No hay datos',
					"competencia" => 'No hay datos',
					"resultado" => 'No hay datos',
					"seleccionar" =>'No hay datos'	
				);

			array_push($salida, $newarray);
		 }
	}else{
		 	    $newarray = array(
					"codigo" => 'Sin conexion',
					"competencia" => 'Sin conexion',
					"resultado" => 'Sin conexion',
					"seleccionar" =>'Sin conexion'	
				);
			array_push($salida, $newarray);
	 }
	$t = new TituladaModel();
	$tabla = $t->safe_json_encode($salida);
	$tabla = substr($tabla,0, strlen($tabla) - 1);
	echo '{"data":'.$tabla.']}';
} 

/*********************************************/
public static function lresultadoPro($idProgramacion, $modificar){
	$tabla = '';
	$opciones = '';
	$a = new TituladaModel();
	if(isset($_SESSION['prc_idusuario'])){ 
	$centro = $_SESSION['prc_centro'];
	$sqlt = "SELECT cp.id cpid, cp.codigo, cp.texto competencia, rs.id rsid, rs.texto resultado,pre.ID as idProRes FROM competencias cp INNER JOIN resultados rs ON cp.id = rs.idcompetencia INNER JOIN programacion_resultados pre ON rs.id = pre.idResultado WHERE cp.estado = '1' AND rs.estado = '1' AND cp.ccentro = '$centro' AND pre.idProgramacion = '$idProgramacion' ORDER BY cp.id ASC;";
	$stmt = Conexion::conectar()->prepare($sqlt);
	$stmt -> execute();
	$total = $stmt->rowCount();
	if($stmt->rowCount() > 0){
	    $salida = array();		
		$respuesta = '1';
		$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value) {
            $rsid =  $value['rsid'];
            $idProRes =  $value['idProRes'];
            $cpid =  $value['cpid']; 
            $codigo =  $value['codigo'];            
            $lcompetencia = htmlentities($value['competencia']);
            $competencia = substr(htmlentities($value['competencia']),0,40);
            $competencia = strtolower($competencia);
            $resultado = $value['resultado'];
            $resultado = $resultado;
			$resultado = strtolower($resultado);    
			
			
			$newarray = array(
				"codigo" => $codigo,
				"competencia" => $competencia,
				"resultado" => $resultado
			);
			array_push($salida, $newarray);
				//$tabla .='{"codigo":"'.$codigo.'","competencia":"'.$competencia.'","resultado":"'.$resultado.'","seleccionar":"'.$opciones.'"},';
		   }	
		 }else{
		 	    $newarray = array(
					"codigo" => 'No hay datos',
					"competencia" => 'No hay datos',
					"resultado" => 'No hay datos',
					"seleccionar" =>'No hay datos'	
				);

			array_push($salida, $newarray);
		 }
	}else{
		 	    $newarray = array(
					"codigo" => 'Sin conexion',
					"competencia" => 'Sin conexion',
					"resultado" => 'Sin conexion',
					"seleccionar" =>'Sin conexion'	
				);
			array_push($salida, $newarray);
	 }
	$t = new TituladaModel();
	$tabla = $t->safe_json_encode($salida);
	$tabla = substr($tabla,0, strlen($tabla) - 1);
	echo '{"data":'.$tabla.']}';
} 

function safe_json_encode($value){
	$t = new TituladaModel();
    if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
        $encoded = json_encode($value, JSON_PRETTY_PRINT);
    } else {
        $encoded = json_encode($value);
    }
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            return $encoded;
        case JSON_ERROR_DEPTH:
            return 'Maximum stack depth exceeded'; // or trigger_error() or throw new Exception()
        case JSON_ERROR_STATE_MISMATCH:
            return 'Underflow or the modes mismatch'; // or trigger_error() or throw new Exception()
        case JSON_ERROR_CTRL_CHAR:
            return 'Unexpected control character found';
        case JSON_ERROR_SYNTAX:
            return 'Syntax error, malformed JSON'; // or trigger_error() or throw new Exception()
        case JSON_ERROR_UTF8:
            $clean = $t->utf8ize($value);
            return $t-> safe_json_encode($clean);
        default:
            return 'Unknown error'; // or trigger_error() or throw new Exception()
    }
}
function utf8ize($mixed) {
	$t = new TituladaModel();
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = $t->utf8ize($value);
        }
    } else if (is_string ($mixed)) {
        return  utf8_encode($mixed);
    }
    return $mixed;
}

public static function listaCompetencias(){
	$tabla = '';
	$opciones = '';
  $salida = array();
	$a = new TituladaModel();
	if(isset($_SESSION['prc_idusuario'])){ 
	$centro = $_SESSION['prc_centro'];
	$sqlt = "SELECT id, codigo, texto, estado FROM competencias WHERE ccentro = '$centro' ORDER BY id ASC";
	$stmt = Conexion::conectar()->prepare($sqlt);
	$stmt -> execute();
	$total = $stmt->rowCount();
	if($stmt->rowCount() > 0){
		$respuesta = '1';
		$registros = $stmt->fetchAll();	
		foreach ($registros as $key => $value) {
            $id =  $value['id'];
			$codigo = $value['codigo'];
            $nombre = html_entity_decode(trim($value['texto']));
            $nombre = strtoupper($nombre);

			$estado = $value['estado'];
				switch ($estado) {
					case '1':
					$lestado = 'Activo';
					$eestado = '<i class="fas fa-lock-open"></i>';
					$cestado = 'info';
					break;
					case '2':
					$lestado = 'Suspendido';
					$eestado = '<i class="fas fa-lock"></i>';
					$cestado = 'danger';
					break;						
					default:
						$lestado = 'Error';
					break;
				}
				$opciones = '<div class="btn-group" onClick="nuevacompetencia(\''.$id.'\');" role="group" aria-label="Basic example"><button type="button"  class="btn btn-info btn-sm"><i class="far fa-edit"></i></button><button type="button"  class="btn btn-'.$cestado.' btn-sm">'.$eestado.'</button></div>';

				//$tabla .='{"codigo":"'.$codigo.'","nombre":"'.$nombre.'","estado":"'.$lestado.'","opciones":"'.$opciones.'"},';
          $newarray = array(
            "codigo" => $codigo,
            "nombre" => $nombre,
            "estado" => $lestado,
            "opciones" =>$opciones 
          );
          array_push($salida, $newarray);

		   }	
		 } else{
		 	    //$tabla .='{"codigo":"Sin datos","nombre":"Sin datos","estado":"Sin datos", "opciones":"Sin datos"},';
         $newarray = array(
            "codigo" => "Sin datos",
            "nombre" => "Sin datos",
            "estado" => "Sin datos",
            "opciones" =>"Sin datos" 
          );
          array_push($salida, $newarray);
		 }
	}else{
		//$tabla .='{"codigo":"Sin conexión","nombre":"Sin conexión","estado":"Sin conexión", "opciones":"Sin conexión"},';
         $newarray = array(
            "codigo" => "Sin conexión",
            "nombre" => "Sin conexión",
            "estado" => "Sin conexión",
            "opciones" =>"Sin conexión" 
          );
          array_push($salida, $newarray);
}

  $t = new TituladaModel();
  $tabla = $t->safe_json_encode($salida);
  $tabla = substr($tabla,0, strlen($tabla) - 1);
  echo '{"data":'.$tabla.']}';
} 
	   

public static function quitarlresultados($id){
	   if(isset($_SESSION['prc_idusuario'])){ 
		$sqlt = "UPDATE resultados SET estado = '2' WHERE id = '$id'";
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
		'respuesta' => $respuesta 
		);
		$arrDatos[] = $newdata;  
		echo json_encode($arrDatos);
	 }

public static function activarlresultados($id){
	   if(isset($_SESSION['prc_idusuario'])){ 
		$sqlt = "UPDATE resultados SET estado = '1' WHERE id = '$id'";
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
		'respuesta' => $respuesta 
		);
		$arrDatos[] = $newdata;  
		echo json_encode($arrDatos);
	 }

public static function listaFichasTitulada($tipores){
	$tabla = '';
	$opciones = '';
	$a = new TituladaModel();
	if(isset($_SESSION['prc_idusuario'])){ 
	$centro = $_SESSION['prc_centro'];
	$sqlt = "SELECT fc.numero, fc.alarmada, fc.controlada, cr.nombre coordinacion, fc.codempresa, fc.controlada, fc.id id, fc.lugar, fc.direccion, fc.naprendices, fr.nivel, fr.codigo, fr.nombre, fr.version, fr.nivel, fr.modalidad, fr.horas, fc.idempresa, fc.ofertaabierta, fc.departamento iddepto, cd.id idciudad, cd.ciudad, fc.finicia, fc.ffinaliza FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN ciudades cd ON fc.ciudad = cd.id  INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id WHERE fr.nivel <> '0' AND fc.ccentro = '$centro'  ORDER BY fc.id ASC";
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
 			$nivel = $value['nivel'];
 			$modalidad = $value['modalidad']; 	
 			$version = $value['version']; 			
			$direccion = $value['direccion'];
			$naprendices = $value['naprendices'];
			$codigo = $value['codigo'];
			$nombre = html_entity_decode(strtolower($value['nombre']));
			$nombre = ucwords($nombre);
			$horas = $value['horas'];
			$ciudad = $value['ciudad'];
			$idciudad = $value['idciudad'];
			$iddepto = $value['iddepto'];
			$finicia = $value['finicia'];
			$ffinaliza = $value['ffinaliza'];
			$idempresa = $value['idempresa'];
			$controlada = $value['controlada'];
				switch ($nivel) {
						case '0':
						$lnivel = 'Complementaria';
						break;
						case '1':
						$lnivel = 'Operario';
						break;						
						case '2':
						$lnivel = 'Auxiliar';
						break;
						case '3':						
						$lnivel = 'Técnico';
						break;
						case '4':
						$lnivel = 'Tecnologo';
						break;
						case '5':
						$lnivel = 'Especialización';
						break;
					default:
						$lnivel = 'Error';
						break;
				}

				switch ($modalidad){
						case '0':
						$lmodalidad = 'Presencial';
						break;
						case '1':
						$lmodalidad = 'Virtual';
						break;						
						case '2':
						$lmodalidad = 'Distancia';
						break;
						case '3':						
						$lmodalidad = 'Mixta';
						break;
					}

			if($tipores == 'editar'){

				$opciones ='<button type=\"button\" id=\"btnqc'.$id.'\" onClick =\"nuevaFichaTitulada('.$id.',\''.$iddepto.'\',\''.$idciudad.'\');\" class=\"btn btn-info btn-sm\"><i class=\"far fa-edit\"></i></button>';
			}  

			if($tipores == 'seleccionar'){	
				$opciones ='<button type=\"button\" id=\"btnqc'.$id.'\" onClick =\"selFichaTitulada('.$id.',\''.$numero.'\',\''.$nombre.'\');\" class=\"btn btn-info btn-sm\"><i class=\"fas fa-check\"></i></button>';
			}  

			$tabla .='{"numero":"'.$numero.'","coordinacion":"'.$coordinacion.'","codigo":"'.$codigo.'","version":"'.$version.'","nombre":"'.$nombre.'","lugar":"'.$lugar.'","finicia":"'.$finicia.'","ffinaliza":"'.$ffinaliza.'" ,"nivel":"'.$lnivel.'","modalidad":"'.$lmodalidad.'","opciones":"'.$opciones.'"},';
		}	
	 } else{
	 	$tabla .='{"numero":"Sin datos","coordinacion":"Sin datos","codigo":"Sin datos","version":"Sin datos","nombre":"Sin datos","lugar":"Sin datos","finicia":"Sin datos","ffinaliza":"Sin datos" ,"nivel":"Sin datos","modalidad":"Sin datos","opciones":"Sin datos"},';
	 }
	} 
	$tabla = substr($tabla,0, strlen($tabla) - 1);
	echo '{"data":['.$tabla.']}';		   
}



public static function updateFicha($datos){ 

	//nuevos datos
	$directorGrupo = $datos['directorGrupo'];
	$formacionFuera = $datos['formacionFuera'];


	$ip = $_SERVER["REMOTE_ADDR"]; 
	date_default_timezone_set('America/Bogota'); 
	$fecha = date("Y-m-d");
	$hora = date('H:i:s');	
	$id = $datos['id'];
	$numero = $datos['numero'];	
	$jornada = $datos['jornada'];
	$lugar = $datos['lugar'];
	$programa = $datos['programa'];
	$fechainicio = $datos['fechainicio'];
	$depto = $datos['depto'];
	$ciudad = $datos['ciudad'];	
	$fechafin = $datos['fechafin'];
	$coordinacion = $datos['coordinacion'];
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
	if(!isset($_SESSION['prc_ciuser'])){ 
	     $respuesta =  '5';
	}else{
		$idusuario = $_SESSION['prc_idusuario'];
		$usuario =	$_SESSION['prc_ciuser'];
		$ccentro = $_SESSION['prc_centro'];
		if($id == '0'){
		$sqlt = "INSERT INTO fcaracterizacion (identificador, numero, lugar, ccentro, idprograma, coordinacion, departamento, ciudad, idusuario, finicia, ffinaliza,  usuario, estado, director_grupo, formacion_Fuera) VALUES ('$identificador','$numero','$lugar','$ccentro','$programa','$coordinacion','$depto','$ciudad','$idusuario', '$fechainicio', '$fechafin', '$usuario', '1', '$directorGrupo', '$formacionFuera')";
		}else{
		$sqlt = "UPDATE fcaracterizacion SET lugar = '$lugar', idprograma = '$programa', coordinacion = '$coordinacion', departamento = '$depto', ciudad = '$ciudad', idusuario = '$idusuario', finicia = '$fechainicio', ffinaliza = '$fechafin', usuario = '$usuario', formacion_Fuera = '$formacionFuera', director_grupo = '$directorGrupo' WHERE id = '$id'"; 		
		}
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
				if($stmt->rowCount() > 0){
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

public static function nuevorap($datos){ 
	$idcompetencia = $datos['idcompetencia'];	
	$nresultado = htmlentities($datos['nresultado']);
	if(!isset($_SESSION['prc_ciuser'])){ 
	     $respuesta =  '5';
	}else{
		$idusuario = $_SESSION['prc_idusuario'];
		$usuario =	$_SESSION['prc_ciuser'];
		$ccentro = $_SESSION['prc_centro'];
			$sqlt = "INSERT INTO resultados (idcompetencia, ccentro, texto, estado) VALUES('$idcompetencia','$ccentro','$nresultado','1')";
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
				if($stmt->rowCount() > 0){
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
}


public static function updateCompetencia($datos){ 
	$id = $datos['id'];
	$codigo = $datos['codigo'];	
	$texto = htmlentities($datos['texto']);
	if(!isset($_SESSION['prc_ciuser'])){ 
	     $respuesta =  '5';
	}else{
		$idusuario = $_SESSION['prc_idusuario'];
		$usuario =	$_SESSION['prc_ciuser'];
		$ccentro = $_SESSION['prc_centro'];
		if($id == '0'){      
			$sqlt = "INSERT INTO competencias (codigo, texto, ccentro, estado) VALUES('$codigo', '$texto','$ccentro','1')";
		}else{
			$sqlt = "UPDATE competencias SET  codigo = '$codigo', texto = '$texto' WHERE id = '$id';";       
		}
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
				if($stmt->rowCount() > 0){
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

 public function existeFicha($ficha){
   $lista = '';
   $respuesta = '1';
   $f = new TituladaModel();
	if(isset($_SESSION['prc_idusuario'])){ 
	   $centro = $_SESSION['prc_centro'];   
	   $sqlt = "SELECT fc.id, fc.numero,   fc.coordinacion, fc.idprograma, fc.finicia, fc.ffinaliza, fc.lugar, fr.nivel, fc.departamento, fc.ciudad, fc.jornada FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id WHERE fc.numero = '$ficha' AND fc.ccentro = '$centro';";
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
			if($stmt->rowCount() > 0){
				$respuesta = '1';
				$registros = $stmt->fetchAll();	
				foreach ($registros as $key => $value) {
					$id = $value['id'];
					$numero = $value['numero'];
					$coordinacion = $value['coordinacion'];
					$idprograma = $value['idprograma'];
					$jornada = $value['jornada'];
					$finicia = $value['finicia'];
					$ffinaliza = $value['ffinaliza'];
					$departamento = $value['departamento'];
					$ciudad = $value['ciudad'];
					$lugar = $value['lugar'];
					if($value['nivel'] == '0'){
						$respuesta = '2';
					}
					  $newdata =  array (
							'respuesta' => $respuesta,
							'id'=> $id,
							'numero' => $numero, 
							'coordinacion' => $coordinacion, 
							'idprograma' => $idprograma, 
							'jornada' => $jornada, 							
							'finicia' => $finicia, 
							'ffinaliza' => $ffinaliza, 
							'departamento' => $departamento, 
							'ciudad' => $ciudad, 
							'lugar' => $lugar
				        );
				}
		    }else{
				$newdata =  array (
				  'respuesta' => '0',
				  'sqlt'=> $sqlt 
		        );
		    }    
    }else{
		$newdata =  array (
		  'respuesta' => '5' 
        );    	
    }  
	$arrDatos[] = $newdata;   
	echo json_encode($arrDatos);
   }



 public static function listaResultados($id){
   $lista = '';
   $respuesta = '1';
   $f = new TituladaModel();
	if(isset($_SESSION['prc_idusuario'])){ 
	   $centro = $_SESSION['prc_centro'];   
	   $sqlt = "SELECT id, idcompetencia, texto, estado FROM resultados WHERE idcompetencia = '$id'";
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
			if($stmt->rowCount() > 0){
				$respuesta = '1';
				$registros = $stmt->fetchAll();	
				foreach ($registros as $key => $value){
					$id =  $value['id'];
					$texto =  html_entity_decode($value['texto']);
					$estado =  $value['estado'];
					$idcompetencia =  $value['idcompetencia'];
					$newdata =  array (
					  'id' => $id,
					  'idcompetencia' => $idcompetencia,
					  'estado' => $estado,
					  'rstexto' => $texto,
					  'respuesta' => $respuesta,  
					  'registros' => $stmt->rowCount()    
					);
					$arrDatos[] = $newdata; 
				}
		    }else{
				$newdata =  array (
				  'respuesta' => '0' 
		        );
		        $arrDatos[] = $newdata; 
		    }    
    }else{
		$newdata =  array (
		  'respuesta' => '5' 
        );    	
        $arrDatos[] = $newdata; 
    }  
	 
	echo json_encode($arrDatos);
   }

 public static function traerEditficha($id){
   $lista = '';
   $respuesta = '1';
   $f = new TituladaModel();
	if(isset($_SESSION['prc_idusuario'])){ 
	   $centro = $_SESSION['prc_centro'];   
	   $sqlt = "SELECT fc.id, fc.numero,   fc.coordinacion, fc.idprograma, fc.finicia, fc.ffinaliza, fc.lugar, fr.nivel, fc.departamento, fc.ciudad, fc.jornada, fc.formacion_Fuera, fc.director_grupo FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id WHERE fc.id = '$id' AND fc.ccentro = '$centro';";
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
			if($stmt->rowCount() > 0){
				$respuesta = '1';
				$registros = $stmt->fetchAll();	
				foreach ($registros as $key => $value) {
					$id = $value['id'];
					$numero = $value['numero'];
					$coordinacion = $value['coordinacion'];
					$idprograma = $value['idprograma'];
					$jornada = $value['jornada'];
					$finicia = $value['finicia'];
					$ffinaliza = $value['ffinaliza'];
					$departamento = $value['departamento'];
					$ciudad = $value['ciudad'];
					$lugar = $value['lugar'];
					$director_grupo = $value['director_grupo'];
					$formacion_Fuera = $value['formacion_Fuera'];
					if($value['nivel'] == '0'){
						$respuesta = '2';
					}
					  $newdata =  array (
							'respuesta' => $respuesta,
							'id'=> $id,
							'numero' => $numero, 
							'coordinacion' => $coordinacion, 
							'idprograma' => $idprograma, 
							'jornada' => $jornada, 							
							'finicia' => $finicia, 
							'ffinaliza' => $ffinaliza, 
							'departamento' => $departamento, 
							'ciudad' => $ciudad, 
							'lugar' => $lugar,
							'director_grupo' => $director_grupo,
							'formacion_Fuera' => $formacion_Fuera
				        );
				}
		    }else{
				$newdata =  array (
				  'respuesta' => '0',
				  'sqlt'=> $sqlt 
		        );
		    }    
    }else{
		$newdata =  array (
		  'respuesta' => '5' 
        );    	
    }  
	$arrDatos[] = $newdata;   
	echo json_encode($arrDatos);
   }

 public static function traerEditCompetencia($id){
   $lista = '';
   $respuesta = '1';
   $f = new TituladaModel();
	if(isset($_SESSION['prc_idusuario'])){ 
	   $centro = $_SESSION['prc_centro'];   
	   $sqlt = "SELECT codigo, texto, id FROM competencias WHERE id = '$id' AND ccentro = '$centro';";
			$stmt = Conexion::conectar()->prepare($sqlt);
			$stmt -> execute();
			if($stmt->rowCount() > 0){
				$respuesta = '1';
				$registros = $stmt->fetchAll();	
				foreach ($registros as $key => $value) {
					$id = $value['id'];
					$codigo = $value['codigo'];
		            $texto = html_entity_decode(trim($value['texto']));
		            $texto = strtoupper($texto);
					  $newdata =  array (
							'respuesta' => $respuesta,
							'id'=> $id,
							'codigo' => $codigo, 
							'texto' => $texto
				        );
				}
		    }else{
				$newdata =  array (
				  'respuesta' => '0',
				  'sqlt'=> $sqlt 
		        );
		    }    
    }else{
		$newdata =  array (
		  'respuesta' => '5' 
        );    	
    }  
	$arrDatos[] = $newdata;   
	echo json_encode($arrDatos);
   }

public static function traerlprogramas(){
    $respuesta = '1';
    $lista = '';
	if(isset($_SESSION['prc_idusuario'])){   
	   $sqlt = "SELECT id, codigo, version, nombre, nivel, modalidad FROM formaciones WHERE nivel > '0' AND estado = '1' ORDER BY nombre ASC;";
	   $stmt = Conexion::conectar()->prepare($sqlt);
     $stmt -> execute();
		if($stmt->rowCount() > 0){
				$respuesta = '1';
				$registros = $stmt->fetchAll();	
				foreach ($registros as $key => $value) {
					$id = $value['id'];
					$codigo = $value['codigo'];
					$version = $value['version'];
					$nivel = $value['nivel'];
					$modalidad = $value['modalidad'];					
					$nombre = html_entity_decode($value['nombre']);
				switch ($nivel) {
						case '0':
						$lnivel = 'Complementaria';
						break;
						case '1':
						$lnivel = 'Operario';
						break;						
						case '2':
						$lnivel = 'Auxiliar';
						break;
						case '3':						
						$lnivel = 'Técnico';
						break;
						case '4':
						$lnivel = 'Tecnologo';
						break;
						case '5':
						$lnivel = 'Especialización';
						break;
					default:
						$lnivel = 'Error';
						break;
				}

				switch ($modalidad){
						case '0':
						$lmodalidad = 'Presencial';
						break;
						case '1':
						$lmodalidad = 'Virtual';
						break;						
						case '2':
						$lmodalidad = 'Distancia';
						break;
						case '3':						
						$lmodalidad = 'Mixta';
						break;
					}					 		
					$lista .= '<option value="'.$id.'">'.$codigo.' - '.$version.' '.$lnivel.' '.$nombre.' '.$lmodalidad.'</option>'; 
				  }
			    }else{
			      $respuesta = '0';
		    }    
	}else{
         $respuesta = '5';   	
	} 
		$newdata =  array (
		'respuesta' => $respuesta,
		'datos' => $lista 
		); 
	$arrDatos[] = $newdata;  

	return json_encode($arrDatos);   
}

public static function programacion($datos){
$f = new TituladaModel();	

$ip = $_SERVER["REMOTE_ADDR"]; 
date_default_timezone_set('America/Bogota'); 


$idficha = $datos['idficha'];
$idtrimestre = $datos['idtrimestre'];
$dtrimestre = $f -> dtrimestre();
$fechainicio = $dtrimestre['fechainicio'];
$fechafin =	$dtrimestre['fechafin'];
$fechainiciof = strtotime($fechainicio);
$fechafinf = strtotime($fechafin);

$fechahoy = date("Y-m-d");	
$mesInicio = date("n",$fechainiciof);
$mesFin = date("n",$fechafinf);
$diaInicio = date("d",$fechainiciof);
$diaFin = date("d",$fechafinf);
$year = date("Y");
$diaActual = date("j");


$meses = array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");	
$dficha = $f -> dficha($idficha);
$numero = $dficha['numero'];
$finicia = DateTime::createFromFormat('Y-m-d', $dficha['finicia']);
$html = '';
for ($m = $mesInicio; $m < $mesFin + 1; $m++) { 
	$diaSemana = date("w",mktime(0,0,0,$m,1,$year))+7;
	$ds = date("l", mktime(0, 0, 0, 7, 1, 2000));
	$ultimoDiaMes=date("d",(mktime(0,0,0,$m+1,1,$year)-1));	
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
					if($day < $diaInicio && $m == $mesInicio ){
					    $html .='<td><del>'.$day.'</del></td>'; 
					} else {
						if($day > $diaFin && $m == $mesFin){
							$html .='<td><del>'.$day.'</del></td>';
						 }else{
						  $html.= $f->activo($idficha, $day, $m, $year, $ds, $festivo);
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
	//$html .='<th colspan="7"><p>Hoy es '.$diaActual.' de '.$meses[$mesActual].' de '.$year.'</p></th>';
	$html .='</tr>';
	$html .='</tbody>';
$html .='</table> ';	
}
return $html;
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

public static function dtrimestreSel($ano,$trimestre){
	$respuesta = [];	
	$sqlt = "SELECT fechainicio, fechafin FROM trimestres WHERE ano = '$ano' AND `trimestre` = '$trimestre'";
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

public function activo($idficha, $day, $m, $year, $ds, $festivo){
$html ='';	
	if($ds == 0 || $festivo == 1){
	   $html .='<td id="b'.$m.'_'.$day.'"><button id="d'.$m.'_'.$day.'" onClick="selCalendario('.$idficha.','.$year.','.$m.','.$day.','.$ds.','.$festivo.')" class="btn btn-outline-danger btn-sm" type="button">'.$day.'</button></td>';
	}else{
		$html .='<td id="b'.$m.'_'.$day.'"><button id="d'.$m.'_'.$day.'" onClick="selCalendario('.$idficha.','.$year.','.$m.','.$day.','.$ds.','.$festivo.')" class="btn btn-outline-success btn-sm" type="button">'.$day.'</button></td>';
	}	
	return $html;
}

public function activo2($idficha, $day, $m, $year, $ds, $festivo){
	$html ='';	
		if($ds == 0 || $festivo == 1){
		   $html .='<button id="d'.$m.'_'.$day.'" onClick="selCalendario('.$idficha.','.$year.','.$m.','.$day.','.$ds.','.$festivo.')" class="btn btn-outline-danger btn-sm" type="button">'.$day.'</button>';
		}else{
			$html .='<button id="d'.$m.'_'.$day.'" onClick="selCalendario('.$idficha.','.$year.','.$m.','.$day.','.$ds.','.$festivo.')" class="btn btn-outline-success btn-sm" type="button">'.$day.'</button>';
		}	
		return $html;
	}

  public function __destruct(){
		   //$stmt -> Conexion::close();
	}
}

