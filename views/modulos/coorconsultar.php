<?php
echo '<script src="'.SERVERURL.'views/js/gestionCoordinador.06.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#coordinador").addClass("active");
      </script>
       <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Inicio</a></li>
          <li class="breadcrumb-item"><a href="'.SERVERURL.'coordinador/">Coordinador</a></li>
          <li class="breadcrumb-item active" aria-current="page">Consultar</li>
        </ol>'; 
if(isset($_SESSION['prc_idusuario'])){   
  $idusuario = $_SESSION['prc_idusuario'];
   echo showStatus($idusuario); 
}
function showStatus($idusuario){
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

function verprogramacion($idusuario, $ano, $mes, $dia, $ds){
$respuesta = '0';
$cantidad = 0;  
$lista = '';
$festivo = traerFestivo($ano, $mes, $dia);  
if($festivo == '1' || $ds == '0'){
 $tipo = 'class="badge badge-danger"';
}else{
 $tipo = 'class="badge badge-info"';
}
$tmes = '';
$tdiasemana = '';
$tinicia = '';
if(isset($_SESSION['prc_centro'])){  
   $centro = $_SESSION['prc_centro'];    
  $sqlt = "SELECT COUNT(fc.numero) AS cantidad FROM programacion pr INNER JOIN fcaracterizacion fc ON fc.id = pr.idficha WHERE fc.ccentro = '$centro' AND pr.ano = '$ano' AND pr.estado = '1' AND pr.mes = '$mes' AND pr.dia = '$dia' ORDER BY pr.inicia ASC";
        $stmt = Conexion::conectar()->prepare($sqlt);
        $stmt -> execute();
        if($stmt->rowCount() > 0){
        $lista = '';
        //$respuesta = '1'; 
        $ban = 0;  
        $registros = $stmt->fetchAll();         
        foreach ($registros as $key => $value){
              $cantidad = $value['cantidad'];
        } 
      }
        if($cantidad > 0){
           $lista .= '<span style="width:100%;" '.$tipo.'>'.$dia.'<br><button onClick="coorconsultar('.$ano.','.$mes.','.$dia.');" class="btn btn-secondary  btn-sm">FICHAS HOY: '.$cantidad.'</button></span>'; 
        }else{
           $lista .= '<span style="width:100%;" '.$tipo.'>'.$dia.'</span> &nbsp;<br>'; 
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