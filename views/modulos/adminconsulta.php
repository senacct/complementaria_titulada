<?php
 echo '<script src="'.SERVERURL.'views/js/gestionFichas.03.js"></script>
      <script src="'.SERVERURL.'views/js/gestionMensajes.04.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gadmin").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Administración</a></li>
        <li class="breadcrumb-item active" aria-current="page">Consultar Fichas</li>
      </ol>
      <div id="cuerpo"></div> 
      <script>listaFichasActivas();</script>        
';
