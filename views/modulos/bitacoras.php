<?php
echo '<nav aria-label="breadcrumb">
      <script>
      $(".has-children").removeClass("active");
      $("#reportes").addClass("active");
      </script>
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Inicio</a></li>
	    <li class="breadcrumb-item"><a href="'.SERVERURL.'reportes/">Reportes</a></li>
	    <li class="breadcrumb-item active" aria-current="page">Bitacora</li>
	  </ol>
	</nav>
	 <div id="cuerpo"></div> 
	  <script src="../views/js/gestionReportes.01.js"></script>	
	   <script>listaBitacora();</script>
	 ';
