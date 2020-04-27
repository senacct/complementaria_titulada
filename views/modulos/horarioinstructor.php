<?php
$idusuario = 0;
if(isset($_SESSION['prc_idusuario'])){   
  $idusuario = $_SESSION['prc_idusuario'];
   //echo showStatus($idusuario); 
}

 echo '<script src="'.SERVERURL.'views/js/horarioInstructor.js"></script>
    <script>
    </script>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Planeacion</a></li>
      <li class="breadcrumb-item active" aria-current="page">Ver Horario</li>
    </ol>
    <div id="cuerpo"></div>
    <div id="programacionFicha"></div>
    <div id="programacion"></div>
    <script>programarFichas();</script>'; 
