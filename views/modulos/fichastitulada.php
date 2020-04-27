<?php
 echo '<script src="'.SERVERURL.'views/js/gestionProgramarTitulada.07.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gtitulada").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Titutlada</a></li>
        <li class="breadcrumb-item active" aria-current="page">Fichas Titulada</li>
      </ol>
      <div class="d-flex p-2 bd-highlight"><button type="button" onClick="nuevaFichaTitulada(\'0\',\'24\',\'16\');"  class="btn btn-success btn-block btn-lg">NUEVA FICHA</button></div>      
      <div id="ventana"></div>
      <div id="cuerpo"></div>
      <script>listarFichasTitulada();</script>'; 
