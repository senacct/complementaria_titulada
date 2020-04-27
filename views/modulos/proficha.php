<?php
 echo '<script src="'.SERVERURL.'views/js/gestionProgramarTitulada.07.js"></script>
    <script>
    $(".has-children").removeClass("active");
    $("#gtitulada").addClass("active");
    </script>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Titutlada</a></li>
      <li class="breadcrumb-item active" aria-current="page">Programar Ficha</li>
    </ol>
    <div id="cuerpo"></div>
    <div id="programacionFicha"></div>
    <div id="programacion"></div>
    <script>programarFichas(\'1\',\'1\');</script>'; 
