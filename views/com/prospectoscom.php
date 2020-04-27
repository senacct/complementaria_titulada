<?php
include_once "../../controllers/prospectosController.php";
require_once "../../models/prospectosModel.php";
Class prospectos{
	public function listaProspectos(){
	    $respuesta = ProspectosController::listaProspectos();
 		echo $respuesta;
	}
	public function prospectoEstado($datos){
	    $respuesta = ProspectosController::prospectoEstado($datos);
 		echo $respuesta;
	}	
	public function prospectoCrear($datos){
	    $respuesta = ProspectosController::prospectoCrear($datos);
 		echo $respuesta;
	}		
}

$a =  new prospectos();  
$dato = filter_input(INPUT_POST,'dato');
$request = filter_input(INPUT_POST,'request');
switch ($dato) {  
	case 'prospectos':
		switch ($request){
			case 'lista':
				echo $a->listaProspectos(); 
			break;
			case 'estado':
			    $arregloDatos = [
			    'id' => filter_input(INPUT_POST,'id'),
				'nestado' => filter_input(INPUT_POST,'nestado'),
				'tabla' => filter_input(INPUT_POST,'tabla')
	            ];	
			    echo $a->prospectoEstado($arregloDatos); 
			break;
			case 'crear':
				$nombre = filter_input(INPUT_POST,'nombre');
				$correo = filter_input(INPUT_POST,'correo');
				$tipodoc = filter_input(INPUT_POST,'tipodoc');
				$documento = filter_input(INPUT_POST,'documento');
				$telefonos = filter_input(INPUT_POST,'telefonos');
				$arregloDatos = [
					'cursos' => filter_input(INPUT_POST,'cursos'),
					'tipodoc' => htmlentities($tipodoc),
					'documento' => htmlentities($documento),					
					'nombre' => htmlentities($nombre),
					'correo' => htmlentities($correo),
					'telefonos' => htmlentities($telefonos)
			    ];
			    echo $a->prospectoCrear($arregloDatos);
			break;



	    }	    		
	break;
} 
