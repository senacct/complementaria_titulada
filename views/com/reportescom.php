<?php
include_once "../../controllers/reportesController.php";
include_once "../../models/reportesModel.php";
$a =  new GestionReportesController();  
$dato = filter_input(INPUT_POST,'dato');
$request = filter_input(INPUT_POST,'request');
switch ($dato) {  
	case 'reportes':
		switch ($request){
			case 'bitacoras':
			    $respuesta = $a -> reportesBitacora(); 
			    echo $respuesta;
			break;			
		}
	break;
} 