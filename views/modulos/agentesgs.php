<?php
//session_start();

 echo '<script src="'.SERVERURL.'views/js/gestionFichas.03.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gadmin").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Gestionar Ficha</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ageste SGS</li>
      </ol>      
';  
//require_once "../../models/conexion.php";

seleccionar();
function seleccionar(){
    if(!isset($_SESSION['prc_ciuser'])){
         $respuesta =  '5';
      }else{
         $centro = $_SESSION['prc_centro'];
         $idusuario = $_SESSION['prc_idusuario'];
         $ccentro = $_SESSION['prc_centro'];
         $sqlt = "SELECT fc.id, rr.tpendiente, rr.sgs, rr.tsgs, us.nombre AS nusuario FROM fcaracterizacion fc INNER JOIN reservaregistro rr ON fc.id = rr.idregistro INNER JOIN usuarios us ON rr.idusuario = us.id WHERE rr.centro = '$ccentro' AND fc.estado = '5' AND rr.sgs = '0' AND rr.pendiente = '1';";
         $stmt = Conexion::conectar()->prepare($sqlt);
         $stmt -> execute();
         if($stmt->rowCount() > 0){
            $registros = $stmt->fetchAll();
            $tban = '0';
            foreach ($registros as $key => $value){
                 $id = $value['id'];
                 $tpendiente = $value['tpendiente'];
                 $sgs = $value['sgs'];
                 $tsgs = $value['tsgs'];
                 $nusuario = $value['nusuario'];
                 verprogramar($id, $tpendiente, $sgs, $tsgs, $nusuario, $tban);
                 $tban = '1';
            }
         } 
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

 

function verprogramar($id, $tpendiente, $sgs, $tsgs, $nusuario, $tban){ 
if(isset($_SESSION['prc_ciuser'])){
    $coordinacion = $_SESSION['prc_coordinacion'];
    $centro = $_SESSION['prc_centro'];
    $perfil = $_SESSION['prc_perfil'];     
    $sqlt = "SELECT fc.id id, fc.lugar, cr.nombre ncoordinacion, fc.direccion, fc.naprendices, fc.numero, fr.codigo, fr.version, fr.nombre, fr.horas, us.nombre instructor, em.nombre empresa, cd.ciudad, fc.finicia, fc.ffinaliza FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN empresas em ON fc.idempresa = em.id  INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id WHERE fc.id = '$id';";
    $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute(); 
    $registros = $stmt->fetchAll();
}    
    $lista = '';
    $ban = 'show'; 
    if(!empty($registros)) {
      if($tban == '0'){
          $lista .='<div class="progress">
            <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
          </div> ';
          $tban = '1';   
          }   
    foreach ($registros as $key => $value){
        $id = $value['id'];
        $numero = $value['numero'];
        $inicial = $value['finicia'];
        $finaliza = $value['ffinaliza'];
        $empresa = $value['empresa'];
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
        $datos ='<span style="color:black;"> Empresa: '.$empresa.'</span><br>';
        $datos .= 'Ambiente : '.$lugar.'<br> Direccion <span style="color:blue">'.$direccion.'</span>';
        $datos .= '<br> <span class="text-center" style="color:blue">Fecha Inicio '.$inicial.' Fecha Final '.$finaliza.'</span><br>';
        $datos .= $jornada.'<br>';
        $datos .= 'Cupo : <span style="color:blue">'.$cupo.'</span><br>';
        $datos .= '<span style="color:blue">'.$instructor.'</span><br>';
        $datos .=  'Coordinacion/Equipo : '. $ncoordinacion.'<br>';
        $datos .=  $dias.'</br>';
        
        $cabecera = '
        <div class="card text-white bg-dark">
          <div class="card-body">SOLICITADO POR '.$nusuario.':<hr> '.$tpendiente.'
            .
          </div>
        </div>      
        <div class="container px-md-1"><div class="row mx-auto  align-items-center">  
        <div class="col py-5 px-md-3 border bg-light h1">'.$numero.'</div>
        <div class="col  col-md-auto col-sm-12">'.$datos.'</div>
        </div></div>
  

        ';
        $lista .= verprogramacion($id, $cabecera, $ban, $programa);
        $ban = '';
    }
   }

echo $lista .='<div class="progress">
  <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
</div> ';
}



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
        $lista .= '<div class="btn-group" role="group" aria-label="Basic example">';
        $lista .= '<button type="button" class="btn btn-success" onClick="presgsrespuesta('.$idficha.');">Registrar Respuesta</button></div>';  
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
