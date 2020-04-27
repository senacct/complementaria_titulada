<?php
//include_once "models/conexion.php"; 
 echo '<script src="'.SERVERURL.'views/js/gestionProspectos.03.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gadmin").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Administración</a></li>
        <li class="breadcrumb-item active" aria-current="page">Propspectos</li>
      </ol>
      <div class="d-flex p-2 bd-highlight"><button type="button" onClick="nuevoProspecto(\'0\')" class="btn btn-success btn-block btn-lg">NUEVO PROSPECTO</button></div> 
      <div id="cuerpo"></div> 
      <script>listaProspectos();</script>            
';
