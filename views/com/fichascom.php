<?php
require_once "../../controllers/fichasController.php";
require_once "../../models/fichasModel.php";
Class Fichas{
	public function quitarControl($datos){
	    $respuesta = FichasController::quitarControl($datos);
 		return $respuesta;
	}	
	public function programadoFicha($id){
	    $respuesta = FichasController::programadoFicha($id);
 		echo $respuesta;
	}	
	public function verFicha($id){
	    $respuesta = FichasController::verFicha($id);
 		echo $respuesta;
	}
	public function upnumeroficha($datos){
	    $respuesta = FichasController::upnumeroficha($datos);
 		echo $respuesta;		
	}
    public function upcodempresa($datos){
	    $respuesta = FichasController::upcodempresa($datos);
 		echo $respuesta;    	
    }
    public function notpublicarficha($idficha){
	    $respuesta = FichasController::notpublicarficha($idficha); 
 		echo $respuesta;    	
    }   
    public function novpublicarficha($datos){
	    $respuesta = FichasController::novpublicarficha($datos); 
 		echo $respuesta;    	
    }      
	public function verprogramacion($idficha){
	    $respuesta = FichasController::verprogramacion($idficha);
 		echo $respuesta;
	}	
	public function verbitacora($idficha){
	    $respuesta = FichasController::verbitacora($idficha);
 		echo $respuesta;
	}
	public function verMibitacora($idficha){
	    $respuesta = FichasController::verMibitacora($idficha);
 		echo $respuesta;
	}	
	public function novedadFicha($datos){
	    $respuesta = FichasController::novedadFicha($datos);
 		echo $respuesta;
	}
	public function pendienteFicha($datos){
	    $respuesta = FichasController::pendienteFicha($datos);
 		echo $respuesta;
	}
	public function sgsrespuestaFicha($datos){
	    $respuesta = FichasController::sgsrespuestaFicha($datos);
 		echo $respuesta;
	}
	public function noconformeContactos($datos){
	    $respuesta = FichasController::noconformeContactos($datos);
 		echo $respuesta;
	}
	public function enviarMensaje($datos){
	    $respuesta = FichasController::enviarMensaje($datos);
 		return $respuesta;
	}	
	public function sendProgramar($idficha){
	    $respuesta = FichasController::sendProgramar($idficha);
 		echo $respuesta;
	}	
	public function listaFichasActivas(){
	    $respuesta =  FichasController::listaFichasActivas();
 		return $respuesta;
	}			
}

$a =  new Fichas(); 
 
$dato = filter_input(INPUT_POST,'dato');
$request = filter_input(INPUT_POST,'request');
switch ($dato) {  
	case 'fichas':
		switch ($request){
			case 'control':
			    $arregloDatos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
				'nestado' => filter_input(INPUT_POST,'nestado')
	            ];	
			echo $a->quitarControl($arregloDatos); 
			break;			
			case 'ver':
				$idficha = filter_input(INPUT_POST,'idficha');	
				echo $a->verFicha($idficha);
			break;
			case 'upnumero':
				$datos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
				'numero' => filter_input(INPUT_POST,'numero')
	            ];		
				echo $a->upnumeroficha($datos); 
			break;
			case 'upcodigo':
				$datos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
				'codigo' => filter_input(INPUT_POST,'codigo')
	            ];	
				echo $a->upcodempresa($datos); 
			break;	
			case 'notcrear':
			    $idficha = filter_input(INPUT_POST,'idficha');
				echo $a->notpublicarficha($idficha); 
			break;	
			case 'pasar':
			    $idficha = filter_input(INPUT_POST,'idficha');
				echo $a->sendProgramar($idficha); 
			break;			
			case 'novedad':
				$datos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
				'empresano' => filter_input(INPUT_POST,'empresano'),
				'instruno' => filter_input(INPUT_POST,'instruno'),
				'programano' => filter_input(INPUT_POST,'programano')
	            ];
				echo $a->novpublicarficha($datos); 
			break;	
			case 'activas':
			echo $a->listaFichasActivas(); 
			break;									
	     }	    		
	break;
	case 'programacion':
		switch ($request){
			case 'ver':
				$idficha = filter_input(INPUT_POST,'idficha');	
				echo $a->verprogramacion($idficha); 
			break;
		
	     }	  
	break;       
	case 'bitacora':
		switch ($request){
			case 'ver':
				$idficha = filter_input(INPUT_POST,'idficha');	
				echo $a->verbitacora($idficha); 
			break;
			case 'miver':
				$idficha = filter_input(INPUT_POST,'idficha');	
				echo $a->verMibitacora($idficha); 
			break;			
	     }	    		     		
	break;
	case 'programar':
		switch ($request){
			case 'programado':
				$idficha = filter_input(INPUT_POST,'idficha');	
				echo $a->programadoFicha($idficha); 
			break;
			case 'pendiente':
	   		    $datos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
				'explicacion' => filter_input(INPUT_POST,'explicacion')
	            ];		
				echo $a->pendienteFicha($datos); 
			break;	
			case 'sgsrespuesta':
	   		    $datos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
				'explicacion' => filter_input(INPUT_POST,'explicacion')
	            ];		
				echo $a->sgsrespuestaFicha($datos); 
			break;					
			case 'novedad':
	   		    $datos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
				'explicacion' => filter_input(INPUT_POST,'explicacion')
	            ];					
				echo $a->novedadFicha($datos); 
			break;						
	     }	    		
	break;
	case 'contactos':
		switch ($request){
			case 'noconforme':
				$datos = [
			    'centro' => filter_input(INPUT_POST,'centro'),
			    'idempresa' => filter_input(INPUT_POST,'idempresa'),
				'idusuario' => filter_input(INPUT_POST,'idusuario'),
				'explicacion' => filter_input(INPUT_POST,'explicacion')
	            ];	
				echo $a->noconformeContactos($datos); 
			break;
			case 'mensaje':
				$datos = [
					'idficha' => filter_input(INPUT_POST,'idficha'),
					'instructor' => filter_input(INPUT_POST,'instructor'),
					'numero' => filter_input(INPUT_POST,'numero'),
					'correosena' => filter_input(INPUT_POST,'correosena'),
					'correootro' => filter_input(INPUT_POST,'correootro'),
					'asunto' => filter_input(INPUT_POST,'asunto'),
					'mensaje' => filter_input(INPUT_POST,'mensaje')  
	            ];	
				echo $a->enviarMensaje($datos); 
			break;						
	     }	    		     		
	break;			
} 
