<?php
//include_once "models/conexion.php"; 
echo '<script src="'.SERVERURL.'views/js/gestionValRadicado.06.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gfichas").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Gestionar Ficha</a></li>
        <li class="breadcrumb-item active" aria-current="page">Validar Radicado</li>
      </ol>  
      <div id="cuerpo"></div> 
      <script>tablaValRadicado();</script>
';
