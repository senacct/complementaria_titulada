<?php
 echo '<script src="'.SERVERURL.'views/js/gestionCompetencias.05.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gtitulada").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Titutlada</a></li>
        <li class="breadcrumb-item active" aria-current="page">Competencias</li>
      </ol>
      <div class="d-flex p-2 bd-highlight"><button type="button" onClick="nuevacompetencia(\'0\');"  class="btn btn-success btn-block btn-lg">NUEVA COMPETENCIA</button></div>      
      <div id="ventana"></div>
      <div id="cuerpo"></div>
      <script>listarCompetencias();</script>'; 
