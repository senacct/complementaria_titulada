<?php
//include_once "models/conexion.php"; 
 echo '<script src="'.SERVERURL.'views/js/gestionProgramas.05.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gadmin").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Administración</a></li>
        <li class="breadcrumb-item active" aria-current="page">Programas de Formación</li>
      </ol> 
      <div class="d-flex p-2 bd-highlight"><button type="button" onClick="nuevoPrograma(\'0\')" class="btn btn-success btn-block btn-lg">NUEVO PROGRAMA</button></div>   
            <div id="cuerpo"></div> 
      <script>tablaProgramas();</script> 
      ';
