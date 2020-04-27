<?php
//include_once "models/conexion.php"; 
 echo '<script src="'.SERVERURL.'views/js/gestionFichas.03.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gfichas").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Gestionar Ficha</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pendientes Programar</li>
      </ol>      
';

//require_once "../../models/conexion.php";
verprogramar();

function verprogramar(){

if(isset($_SESSION['prc_ciuser'])){
    $coordinacion = $_SESSION['prc_coordinacion'];
    $centro = $_SESSION['prc_centro'];
    $perfil = $_SESSION['prc_perfil']; 
    $idusuario = $_SESSION['prc_idusuario'];
    $sqlt = $sqlt = "SELECT fc.id id, fc.lugar, cr.nombre ncoordinacion, fc.direccion, fc.naprendices, fc.numero, fr.codigo, fr.version, fr.nombre, fr.horas, us.nombre instructor, em.nombre empresa, cd.ciudad, fc.finicia, fc.ffinaliza, rg.tpendiente FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN empresas em ON fc.idempresa = em.id  INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id INNER JOIN reservaregistro rg ON rg.idregistro = fc.id WHERE rg.idusuario = '$idusuario' AND rg.pendiente = '1' AND fc.estado = '5' AND fc.historico = '0' ORDER BY fc.id DESC";
    $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute(); 
    $registros = $stmt->fetchAll();
}    
    $lista = '<div id="accordion">';
    $ban = 'show'; 
    if(!empty($registros)) {
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
        $tpendiente = $value['tpendiente'];
        $programa = $pcodigo.' - '.$version.' '.$pnombre; 
        $datos ='<span style="color:black;">'.$empresa.'</span><br>';
        $datos .= $lugar.'<br> Direccion '.$direccion;
        $datos .= '<br> Fecha Inicio '.$inicial.' Fecha Final '.$finaliza.'<br>';
        $datos .= $jornada.'<br>';
        $datos .= 'Cupo : '.$cupo.'<br>';
        $datos .= '<span style="color:black">'.$instructor.'</span><br>';
        $datos .=  $ncoordinacion.'<br>';
        $datos .=  $dias.'</br>';
        
        $cabecera = '<div class="container container px-md-4"><div class="row align-items-center">  
        <div class="col py-5 px-md-6 border bg-light h1">'.$numero.'</div>
        <div class="col  col-md-auto col-sm-12">'.$datos.'</div>
        <div class="col  col-md-auto col-sm-12">'.$tpendiente.'</div>
        </div></div>';
        $lista .= verprogramacion($id, $cabecera, $ban, $programa);
        $ban = '';
    }
   } 
echo $lista .= '</div>';
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
        $lista .='<div class="card text-white">
            <div class="card-header" id="header'.$idficha.'">
              <h5 class="mb-0">';
        $lista .='<button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$idficha.'" aria-expanded="true" aria-controls="collapse'.$idficha.'">';            
        $lista .= $cabecera;
        $lista .='</button>
              </h5>
            </div>
            <div id="collapse'.$idficha.'" class="collapse '.$ban.'" aria-labelledby="header'.$idficha.'" data-parent="#accordion">
             <div class="card-body"> ';
        $lista .='<div class="table-responsive">';
        $lista .= '<span style="color:black">'.$programa.'</span>';
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
            $lista .= '<span style="color:red;"> '.$dia.' </span> '; 
            }else{
            $lista .= '<span> '.$dia.' </span> ';
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
        $lista .= '<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-success" onClick="programadoficha('.$idficha.');">Programado</button>';
        $lista .= '<button type="button" class="btn btn-warning" onClick="prenovedad('.$idficha.');">Reportar Novedad</button></div>';  
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

    
