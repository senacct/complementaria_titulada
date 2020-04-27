<?php
class ProspectosController{
	 public static function listaProspectos(){
		$respuesta = ProspectosModel::listaProspectos();
		return $respuesta;	 	
	 }
	 public static function prospectoEstado($datos){
		$respuesta = ProspectosModel::prospectoEstado($datos);
		return $respuesta;	 	
	 }	 
	 public static function prospectoCrear($datos){
		$respuesta = ProspectosModel::prospectoCrear($datos);
		return $respuesta;	 	
	 }	 	 
}
 