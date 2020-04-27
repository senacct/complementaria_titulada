<?php
require_once "models/conexion.php";
date_default_timezone_set('America/Bogota'); 
session_start();
try{
$fecha = '2018-12-31';
for ($i=0; $i < 3651 ; $i++) { 
  $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
  $nuevafecha = date ( 'Y-m-d',$nuevafecha );
    $dia =  date( 'd' ,strtotime($nuevafecha));
    $mes =  date( 'm' ,strtotime($nuevafecha));
    $ano =  date( 'Y' ,strtotime($nuevafecha));
    $numdia = date('t',strtotime($nuevafecha));
    $caldia = 1 + date('z',strtotime($nuevafecha));
    $semana = date('W',strtotime($nuevafecha));
    $semes = getWeekNumber($nuevafecha);
  switch ($numdia) {
    case '0':
      $nomdia = 'DOMINGO';
      $nomdia_corto = 'DOM';
      break;              
    case '1':
      $nomdia = 'LUNES';
      $nomdia_corto = 'LUN';
      break;
    case '2':
      $nomdia = 'MARTES';
      $nomdia_corto = 'MAR';
      break;
    case '3':
      $nomdia = 'MIERCOLES';
      $nomdia_corto = 'MIE';
      break;                                
    case '4':
      $nomdia = 'JUEVES';
      $nomdia_corto = 'JUE';
      break;
    case '5':
      $nomdia = 'VIERNES';
      $nomdia_corto = 'VIE';
      break;
    case '6':
      $nomdia = 'SABADO';
      $nomdia_corto = 'SAB';
      break;                                                 
  }
   switch ($mes) {
    case '1':
      $nombremes = 'ENERO';
      $nommes_corto = 'ENE';
      break;              
    case '2':
      $nombremes = 'FEBRERO';
      $nommes_corto = 'FEB';
      break; 
    case '3':
      $nombremes = 'MARZO';
      $nommes_corto = 'MAR';
      break; 
    case '4':
      $nombremes = 'ABRIL';
      $nommes_corto = 'ABR';
      break; 
    case '5':
      $nombremes = 'MAYO';
      $nommes_corto = 'MAY';
      break; 
    case '6':
      $nombremes = 'JUNIO';
      $nommes_corto = 'JUN';
      break; 
    case '7':
      $nombremes = 'JULIO';
      $nommes_corto = 'JUL';
      break; 
    case '8':
      $nombremes = 'AGOSTO';
      $nommes_corto = 'AGO';
      break;  
    case '9':
      $nombremes = 'SEPTIEMBE';
      $nommes_corto = 'SEP';
      break; 
    case '10':
      $nombremes = 'OCTUBRE';
      $nommes_corto = 'OCT';
      break; 
    case '11':
      $nombremes = 'NOVIEMBRE';
      $nommes_corto = 'NOV';
      break; 
    case '12':
      $nombremes = 'DICIEMBRE';
      $nommes_corto = 'DIC';
      break;                                                                                                     
  } 
  $sqlt = "INSERT INTO calendario(fecha, semana, semes, numdia, dia, mes, ano, nombredia, ndia, nombremes, nmes, festivo) VALUES('$nuevafecha', '$semana','$semes', '$numdia','$dia', '$mes','$ano', '$nomdia', '$nomdia_corto', '$nombremes','$nommes_corto', '0')";
   $stmt = Conexion::conectar()->prepare($sqlt);
  if($stmt -> execute()){
      echo '1';
     }else{
      echo '0';
   }  
  echo $dia.'-'.$mes.'-'.$ano.'-'.$nomdia.'  '.$caldia.' '.$nomdia_corto. 'Numero dia :'.$numdia.' Semana'.$semana.'<br>';
  $fecha = $nuevafecha;
}
} catch (Exception $ex){
  die('Problemas graves para acceder a la Base de Datos, revise su acceso a Internet por favor.');
}   

?>