<?php
//session_start();

 echo '<script src="'.SERVERURL.'views/js/gestionFichas.03.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gfichas").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Gestionar Ficha</a></li>
        <li class="breadcrumb-item active" aria-current="page">Programar Ficha</li>
      </ol>'; 
 
echo mostrarprogreso();

 
//require_once "../../models/conexion.php";

seleccionar();
function seleccionar(){
    if(!isset($_SESSION['prc_ciuser'])){
         $respuesta =  '5';
      }else{
         $centro = $_SESSION['prc_centro'];
         $idusuario = $_SESSION['prc_idusuario'];
         $sqlt = "SELECT idregistro FROM reservaregistro WHERE idusuario = '$idusuario' AND estado = '1';";
         $stmt = Conexion::conectar()->prepare($sqlt);
         $stmt -> execute();
       if($stmt->rowCount() > 0){
          $registros = $stmt->fetchAll();
          foreach ($registros as $key => $value){
                   $id = $value['idregistro'];
          }
       }else{
        $sqlt = "SELECT fc.id FROM fcaracterizacion fc WHERE fc.ccentro = '$centro' AND fc.estado = '5'  AND fc.historico = '0' ORDER BY fc.finicia ASC";
        $stmt = Conexion::conectar()->prepare($sqlt);
        $stmt -> execute(); 
        $treg = $stmt->rowCount();
        if($treg > 0){ 
          $registros = $stmt->fetchAll();   
          $encontro = 1;
          $i = 0;
          while ($encontro === 1 && $i < $treg) {      
              $id = $registros[$i]['id'];
              $encontro = buscarreserva($id);
              $i = $i + 1;
            }
         } 
        }
     verprogramar($id);
     }  
}

function mostrarprogreso(){
date_default_timezone_set('America/Bogota'); 
$mes = date('m');
$ano= date('Y');
 
# mktime(0,0,0,$month+1,1,$year) = devuelve el timestamp de la fecha indicada
# aumentando en uno el numero del mes, y dejando el numero del dia como el
# primero 1. Tambien le indicamos que es la hora 0, minuto y segundos 0. Aqui
# obtendremos el timestamp de la hora 0 del primer dia del mes sugiente.
# -1 = restamos un segundo al timestamp, por lo que ya estamo en el mes anterior,
# es decir el que queremos saber.
# date("d" = devuelve el ultimo dia del mes. 
$ultimodia = date("d",(mktime(0,0,0,$mes+1,1,$ano)-1));
$ultimafecha = $ano.'-'.$mes.'-'.$ultimodia;

if(!isset($_SESSION['prc_ciuser'])){
     $respuesta =  '5';
  }else{ 
    $centro = $_SESSION['prc_centro']; 
        $sqlt = "SELECT fc.id FROM fcaracterizacion fc WHERE fc.ccentro = '$centro' AND fc.finicia <= '$ultimafecha' AND (fc.estado = '5'  || fc.estado = '6') AND fc.historico = '0' ORDER BY fc.id ASC";
        $stmt = Conexion::conectar()->prepare($sqlt);
        $stmt -> execute(); 
        $treg = $stmt->rowCount();

        $sqlt = "SELECT fc.id FROM fcaracterizacion fc WHERE fc.ccentro = '$centro' AND fc.finicia <= '$ultimafecha' AND fc.estado = '6'  AND fc.historico = '0' ORDER BY fc.id ASC";
                $stmt = Conexion::conectar()->prepare($sqlt);
                $stmt -> execute(); 
                $tpro = $stmt->rowCount();
#Ninguna ficha programada
                    $respuesta = '<div class="progress">
                      <div class="progress-bar " role="progressbar" style="width: 100%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Así estamos: 0%</div>
                    </div>';                
                if($tpro > 0 && $treg > 0){ 

                  $avance = round(100 * ($tpro / $treg));

                  if($avance <= 25 ){
                    $respuesta = '<div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: '.$avance.'%;" aria-valuenow="'.$avance.'" aria-valuemin="0" aria-valuemax="100">Así estamos: '.$avance.'%</div>
                    </div>';
                  }
                  if($avance > 25 && $avance < 75 ){  
                    $respuesta = '<div class="progress">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: '.$avance.'%;" aria-valuenow="'.$avance.'" aria-valuemin="0" aria-valuemax="100"> Estado actual programación: '.$avance.'%</div>
                    </div>'; 
                  }
                  if($avance > 75 && $avance < 99 ){  
                    $respuesta = '<div class="progress">
                      <div class="progress-bar bg-info" role="progressbar" style="width: '.$avance.'%;" aria-valuenow="'.$avance.'" aria-valuemin="0" aria-valuemax="100">Estado actual programación: '.$avance.'%</div>
                    </div>';
                  }
                  if($avance >= 100){ 
                    $avance = 100;
                    $respuesta = '<div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" style="width: '.$avance.'%;" aria-valuenow="'.$avance.'" aria-valuemin="0" aria-valuemax="100">Estado actual programación: '.$avance.'%</div>
                    </div>';
                  }  

                }
                echo $respuesta;
        }
}

function buscarreserva($idregistro){
$respuesta = 0;    
if(!isset($_SESSION['prc_ciuser'])){
     $respuesta =  5;
  }else{
     $idusuario = $_SESSION['prc_idusuario'];
     $centro = $_SESSION['prc_centro'];
     $sqlt = "SELECT idusuario FROM reservaregistro WHERE idregistro = '$idregistro' AND (estado = '1' || pendiente = '1');";
     $stmt = Conexion::conectar()->prepare($sqlt);
     $stmt -> execute();
     if($stmt->rowCount() > 0){ 
        $respuesta = 1;   
     }else{
        $sqlt= "INSERT INTO reservaregistro (idusuario, idregistro, centro, estado ) VALUES ('$idusuario','$idregistro', '$centro', '1');";
        $stmt = Conexion::conectar()->prepare($sqlt);
        $stmt -> execute();
        $respuesta = 0;
     }
  }
 return $respuesta;
}

function verprogramar($id){ 
if(isset($_SESSION['prc_ciuser'])){
    $coordinacion = $_SESSION['prc_coordinacion'];
    $centro = $_SESSION['prc_centro'];
    $perfil = $_SESSION['prc_perfil'];     
    $sqlt = "SELECT fc.id id, fc.lugar, cr.nombre ncoordinacion, fc.direccion, fc.naprendices, fc.numero, fr.codigo, fr.version, fr.nombre, fr.horas, us.nombre instructor, fc.idempresa, fc.ofertaabierta, cd.ciudad, fc.finicia, fc.ffinaliza FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id WHERE fc.id = '$id';";
    $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute(); 
    $registros = $stmt->fetchAll();
}    
    $lista = '';
    $ban = 'show'; 
    if(!empty($registros)) {
    foreach ($registros as $key => $value){
        $id = $value['id'];
        $numero = $value['numero'];
        $inicial = $value['finicia'];
        $finaliza = $value['ffinaliza']; 
        $ciudad = $value['ciudad'];
        $lugar = $value['lugar'];
        $direccion = $value['direccion'];
        $cupo = $value['naprendices'];
        $instructor = $value['instructor'];
        $ncoordinacion = $value['ncoordinacion'];
        $jornada = jornada($id);
        $dias = dias($id);
        $pcodigo = $value['codigo'];
        $version = $value['version'];
        $pnombre = $value['nombre'];
        $programa = $pcodigo.' - '.$version.' '.$pnombre; 
        $idempresa = $value['idempresa'];
        $empresa = '';
        if($value['ofertaabierta'] == 'S'){
              $empresa = '<span style="color:blue;">Oferta Abierta</span>';  
        }else{
              $empresa = traerEmpresa($idempresa); 
        }
        $datos ='<span style="color:black;"> Empresa: '.$empresa.'</span><br>';
        $datos .= 'Ambiente : '.$lugar.'<br> Direccion <span style="color:blue">'.$direccion.'</span>';
        $datos .= '<br> <span class="text-center" style="color:blue">Fecha Inicio '.$inicial.' Fecha Final '.$finaliza.'</span><br>';
        $datos .= $jornada.'<br>';
        $datos .= 'Cupo : <span style="color:blue">'.$cupo.'</span><br>';
        $datos .= '<span style="color:blue">'.$instructor.'</span><br>';
        $datos .=  'Coordinacion/Equipo : '. $ncoordinacion.'<br>';
        $datos .=  $dias.'</br>';
        
        $cabecera = '<div class="container px-md-1"><div class="row mx-auto  align-items-center">  
        <div class="col py-5 px-md-3 border bg-light h1">'.$numero.'<button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Programar después" onClick="prependiente('.$id.');"><i class="fas fa-warehouse"></i></button></div>
        <div class="col  col-md-auto col-sm-12">'.$datos.'</div>
        </div></div>';
        $lista .= verprogramacion($id, $cabecera, $ban, $programa);
        $ban = '';
    }
   } 
echo $lista .= '</div>';
}

/*function verprogramacion($idficha, $cabecera, $ban, $programa){
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
        $lista .='<div class="card text-blue">
            <div class="card-header" id="header'.$idficha.'">
              <h5 class="mb-0">';
        //$lista .='<button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$idficha.'" aria-expanded="true" aria-controls="collapse'.$idficha.'">';            
        $lista .= $cabecera;
        //$lista .='</button>
        $lista .='</h5>
            </div>
            <div id="collapse'.$idficha.'" class="collapse '.$ban.'" aria-labelledby="header'.$idficha.'" data-parent="#accordion">
             <div class="card-body"> ';
        $lista .='<div class="table-responsive">';
        $lista .= '<span style="color:blue">'.$programa.'</span>';
        $lista .='<table class="table table-border">';
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
            $lista .= '<span class="badge badge-danger"> '.$dia.' </span> '; 
             }else{
            $lista .= '<span class="badge badge-secondary"> '.$dia.' </span> ';
            }
        }

        $lista .='</td>';       
        $lista .='</tr>';
        $lista .='<tr class="table-info">';
        $lista .='<td>';
        $lista .='TOTAL HORAS PROGRAMACION';                       
        $lista .='</td>';
        $lista .='<td class="h3 info">';
        $lista .= $thoras;                      
        $lista .='</td>';                   
        $lista .='</tr>';       
        $lista .='</table>';   
        $lista .='</div>';
        $lista .= '<div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="btnprog'.$idficha.'" class="btn btn-success" onClick="programadoficha('.$idficha.',\'1\');">Programado</button>';
        $lista .= '<button type="button" class="btn btn-warning" onClick="prenovedad('.$idficha.',\'1\');">Reportar Novedad al Instructor</button></div>';  
        $lista .='</div> 
        </div> 
          </div>';      
    } 
 return $lista; 
}*/

function verprogramacion($idficha, $cabecera, $ban, $programa){
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
        $lista .='<div class="card text-blue">
            <div class="card-header" id="header'.$idficha.'">
              <h5 class="mb-0">';
        //$lista .='<button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$idficha.'" aria-expanded="true" aria-controls="collapse'.$idficha.'">';            
        $lista .= $cabecera;
        //$lista .='</button>
        $lista .='</h5>
            </div>
            <div id="collapse'.$idficha.'" class="collapse '.$ban.'" aria-labelledby="header'.$idficha.'" data-parent="#accordion">
             <div class="card-body"> ';
        $lista .='<div class="table-responsive">';
        $lista .= '<span style="color:blue">'.$programa.'</span>';
        $lista .='<table class="table table-border">';
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
            $lista .= '<span class="badge badge-danger"> '.$dia.' </span> '; 
             }else{
            $lista .= '<span class="badge badge-secondary"> '.$dia.' </span> ';
            }
        }

        $lista .='</td>';       
        $lista .='</tr>';
        $lista .='<tr class="table-info">';
        $lista .='<td>';
        $lista .='TOTAL HORAS PROGRAMACION';                       
        $lista .='</td>';
        $lista .='<td class="h3 info">';
        $lista .= $thoras;                      
        $lista .='</td>';                   
        $lista .='</tr>';       
        $lista .='</table>';   
        $lista .='</div>';
        $lista .= '<div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="btnprog'.$idficha.'" class="btn btn-success" onClick="programadoficha('.$idficha.',\'1\');">Programado</button>';
        $lista .= '<button type="button" class="btn btn-warning" onClick="prenovedad('.$idficha.',\'1\');">Reportar Novedad al Instructor</button></div>';  
        $lista .='</div> 
        </div> 
          </div>';      
    } 
 return $lista; 
}


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


function traerEmpresa($idempresa){
$respuesta = '';   
   $sqlt = "SELECT nombre FROM empresas WHERE id = '$idempresa'";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
        if($stmt->rowCount() > 0){
        $registros = $stmt->fetchAll(); 
        foreach ($registros as $key => $value){
             $respuesta = $value['nombre'];
        }           
    } 
    return $respuesta;  
}