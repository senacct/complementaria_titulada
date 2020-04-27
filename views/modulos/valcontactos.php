<?php
//include_once "models/conexion.php"; 
 echo '<script src="'.SERVERURL.'views/js/gestionValContactos.04.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gadmin").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Administración</a></li>
        <li class="breadcrumb-item active" aria-current="page">Validar Contactos</li>
      </ol>  
      <div id="cuerpo"></div> 
      <script>tablaValContacto();</script>          
';

