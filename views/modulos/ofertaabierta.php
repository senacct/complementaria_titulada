<?php
$idusuario = 0;
if(isset($_SESSION['prc_idusuario'])){   
	$idusuario = $_SESSION['prc_idusuario'];
	 
}
echo ' <nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Inicio</a></li>
			    <li class="breadcrumb-item"><a href="'.SERVERURL.'planeacion/">Planeación</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Oferta Abierta <label id="usID">'.$idusuario.'</label></li>
			  </ol>
		</nav>
	    <div class="d-flex p-2 bd-highlight"><button type="button" onClick="nuevaFichaOfertaAbierta();"  class="btn btn-success btn-block btn-lg">NUEVA FICHA</button></div>
	    <script src="../views/js/gestionOfertaAbierta.04.js"></script>	
	    <script>listOfertaAbierta();</script>
	 ';
