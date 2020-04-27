<?php
class FichasController{
	public static function quitarControl($datos){
	    $respuesta = FichasModel::quitarControl($datos);
 		return $respuesta;
	}	
	public static function programadoFicha($idficha){
	    $respuesta = FichasModel::programadoFicha($idficha);
 		return $respuesta;
	}
	 public static function verFicha($idficha){
		$respuesta = FichasModel::verFicha($idficha);
		return $respuesta;	 	
	 } 
	 public static function upnumeroficha($datos){
		$respuesta = FichasModel::upnumeroficha($datos);
		return $respuesta;	 	
	 } 
	 public static function upcodempresa($datos){
		$respuesta = FichasModel::upcodempresa($datos);
		return $respuesta;	 	
	 } 
	 public static function notpublicarficha($datos){
		$respuesta = FichasModel::notpublicarficha($datos);
		return $respuesta;	 	
	 } 
	 public static function novpublicarficha($datos){
		$respuesta = FichasModel::novpublicarficha($datos);
		return $respuesta;	 	
	 } 	 
	public static function verprogramacion($idficha){
	    $respuesta = FichasModel::verprogramacion($idficha);
 		return $respuesta;
	}
	public static function verbitacora($idficha){
	    $respuesta = FichasModel::verbitacora($idficha);
 		return $respuesta;
	}
	public static function verMibitacora($idficha){
	    $respuesta = FichasModel::verMibitacora($idficha);
 		return $respuesta;
	}	
	public static function sendProgramar($idficha){
	    $respuesta = FichasModel::sendProgramar($idficha);
 		return $respuesta;
	}	
	public static function novedadFicha($datos){
		$respuesta = FichasModel::novedadFicha($datos);
		return $respuesta;	 	
	}
	public static function pendienteFicha($datos){
		$respuesta = FichasModel::pendienteFicha($datos);
		return $respuesta;	 	
	}	
	public static function sgsrespuestaFicha($datos){
		$respuesta = FichasModel::sgsrespuestaFicha($datos);
		return $respuesta;	 	
	}		
	public static function noconformeContactos($datos){
		$respuesta = FichasModel::noconformeContactos($datos);
		return $respuesta;	 	
	}
	public static function enviarMensaje($datos){
		$respuesta = FichasModel::enviarMensaje($datos);
		return $respuesta;	 	
	}	
	public function listaFichasActivas(){
	    $respuesta =  FichasModel::listaFichasActivas();
 		return $respuesta;
	}			 	 		 
}
 