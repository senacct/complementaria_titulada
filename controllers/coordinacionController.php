<?php
class CoordinadorController{
	 public static function autorizarFicha($idficha){
		$respuesta = CoordinadorModel::autorizarFicha($idficha);
		return $respuesta;	 	
	 }
	 public static function coorConsultar($idficha){
		$respuesta = CoordinadorModel::coorConsultar($idficha);
		return $respuesta;	 	
	 }	 
	 public static function denegarFicha($datos){
		$respuesta = CoordinadorModel::denegarFicha($datos);
		return $respuesta;	 	
	 }	 
}
 