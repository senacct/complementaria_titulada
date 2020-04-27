<?php
echo '<script>
      $(".has-children").removeClass("active");
      $("#programar").addClass("active");
      </script>
       <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Inicio</a></li>
          <li class="breadcrumb-item"><a href="'.SERVERURL.'planeacion/">Planeación</a></li>
          <li class="breadcrumb-item active" aria-current="page">Mi Programación</li>
        </ol>'; 
if(isset($_SESSION['prc_idusuario'])){   
  $idusuario = $_SESSION['prc_idusuario'];
   echo showStatus($idusuario); 
}


function showStatus($idusuario){
if(isset($_SESSION['prc_idusuario'])){   
  $idusuario = $_SESSION['prc_idusuario'];  
    $ip = $_SERVER["REMOTE_ADDR"]; 
    date_default_timezone_set('America/Bogota'); 
    $fechahoy = date("Y-m-d");  
    $mesActual = date("n");
    $year = date("Y");
    $diaActual = date("j");
    $meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
    "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"); 
    $html = '';
    for ($m = $mesActual; $m < 13; $m++) { 
      $diaSemana=date("w",mktime(0,0,0,$m,1,$year))+7;
      $ds = date("l", mktime(0, 0, 0, 7, 1, 2000));
      $ultimoDiaMes=date("d",(mktime(0,0,0,$m+1,1,$year)-1)); 
        //$html .='<div id="franja"></div>';
        //$html .='<div id="hfranja"></div>';

      $html .='<div class="card" style="width: 100%;">';
      $html .='<div class="table-responsive">';
      $html .='<table class="table table-sm"  id="calendar">';
      $html .='<thead class="thead-dark">';
      $html .='<tr>';
      $html .='<th colspan="7">'.$meses[$m].' '.$year.'</th>';
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
          if($i == $diaSemana)
          {
            $day=1;
          }
          if($i<$diaSemana || $i>=$last_cell)
          {
            $html .='<td " >&nbsp;</td>';
          }else{
            // mostramos el dia
              $ds = date("w", mktime(0, 0, 0, $m, $day, $year));
                  $html.='<td >'.verprogramacion($idusuario, $year, $m, $day, $ds).'</td>';
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
      $html .='<td  class="table-primary" colspan="7"><p>Hoy es '.$diaActual.' de '.$meses[$mesActual].' de '.$year.'</p></td>';
      $html .='</tr>';
      $html .='</tbody>';
    $html .='</table>';  
    $html .='</div>';
    $html .='</div>';   
    }
    return $html;
    }
}

function verprogramacion($idusuario, $ano, $mes, $dia, $ds){
$respuesta = '0'; 
$lista = '';
$festivo = traerFestivo($ano, $mes, $dia);  
if($festivo == '1' || $ds == '0'){
    $lista = '<span class="badge badge-danger">'.$dia.'</span>';
}else{
    $lista = '<span class="badge badge-info">'.$dia.'</span>';
}
$tmes = '';
$tdiasemana = '';
$tinicia = '';
  $sqlt = "SELECT fc.numero, fc.estado AS festado, fc.finicia, fc.ffinaliza, fc.lugar, fc.direccion, pr.ano, pr.mes, pr.diasemana, pr.horas, pr.inicia, pr.finaliza, pr.dia, pr.festivo,   pr.novedad, pr.fecha FROM programacion pr INNER JOIN fcaracterizacion fc ON fc.id = pr.idficha WHERE fc.idusuario = '$idusuario' AND pr.ano = '$ano' AND pr.estado = '1' AND pr.mes = '$mes' AND pr.dia = '$dia' ORDER BY pr.inicia ASC";
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
              if($ban == 1){
                $dia = '---';
              }
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
              $lista .= '<span style="width:100%;"class="badge badge-danger">'.$dia.'<br>'.$lugar.'<br>'.$direccion.'<br> '.$numero.'<br>'.$icono.'<br>('.$inicia.':00 -'.$finaliza.':00) </span> &nbsp;<br>';
              }else{
                if($numero == '0'){
              $lista .= '<span style="width:100%;"class="badge badge-secondary">'.$dia.'<br>'.$lugar.'<br>'.$direccion.'<br>'.$numero.'<br>'.$icono.'<br>('.$inicia.':00 -'.$finaliza.':00) </span> &nbsp;<br>'; 
                }else{
              $lista .= '<span style="width:100%;"class="badge badge-info">'.$dia.'<br>'.$lugar.'<br>'.$direccion.'<br> '.$numero.'<br>'.$icono.'<br>('.$inicia.':00 -'.$finaliza.':00) </span> &nbsp;<br>';                   
                }
              }
           }
    } 
 return $lista; 
}

function traerFestivo($ano, $mes, $day){
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