<?php
include_once "../../controllers/coordinacionController.php";
require_once "../../models/coordinacionModel.php";
Class Coordinacion{
	public function autorizarFicha($id){
	    $respuesta = CoordinadorController::autorizarFicha($id);
 		echo $respuesta;
	}
	public function denegarFicha($datos){
	    $respuesta = CoordinadorController::denegarFicha($datos);
 		echo $respuesta;
	}
    public function coorConsultar($datos){
	    $respuesta = CoordinadorController::coorConsultar($datos);
 		echo $respuesta;
	}
}

$a =  new Coordinacion();  
$dato = filter_input(INPUT_POST,'dato');
$request = filter_input(INPUT_POST,'request');
switch ($dato) {  
	case 'formacion':
		switch ($request){
			case 'autorizar':
				$idficha = filter_input(INPUT_POST,'idficha');	
				echo $a->autorizarFicha($idficha); 
			break;
			case 'denegar':
	   		    $datos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
				'explicacion' => filter_input(INPUT_POST,'explicacion')
	            ];					
				echo $a->denegarFicha($datos); 
			break;	
			case 'consultar':
	   		    $datos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
			    'centro' => filter_input(INPUT_POST,'centro'),
				'ano' => filter_input(INPUT_POST,'ano'),
				'mes' => filter_input(INPUT_POST,'mes'),
				'dia' => filter_input(INPUT_POST,'dia')
	            ];					
				echo $a->coorConsultar($datos); 
			break;						 		
	    }	    		
	break;
} 
