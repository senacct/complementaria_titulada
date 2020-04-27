<?php
class TituladaController{
	public static function programacion($datos){
	    $respuesta =  TituladaModel::programacion($datos);
 		return $respuesta;
	}	
	public static function listaCompetencias(){
	    $respuesta =  TituladaModel::listaCompetencias();
 		return $respuesta;
	}	
	public static function listaFichasTitulada($tipores){
	    $respuesta =  TituladaModel::listaFichasTitulada($tipores);
 		return $respuesta;
	}
	public static function listaResultados($id){
	    $respuesta =  TituladaModel::listaResultados($id);
 		return $respuesta;
	}	
	public static function lprogresultado(){
	    $respuesta =  TituladaModel::lprogresultado();
 		return $respuesta;
	}			
	public static function traerlprogramas(){
	    $respuesta =  TituladaModel::traerlprogramas();
 		return $respuesta;
	}	
	public static function existeFicha($ficha){
	    $respuesta =  TituladaModel::existeFicha($ficha);
 		return $respuesta;
	}	
	public static function traerEditficha($id){
	    $respuesta =  TituladaModel::traerEditficha($id);
 		return $respuesta;
	}		
	public static function traerEditCompetencia($id){
	    $respuesta =  TituladaModel::traerEditCompetencia($id);
 		return $respuesta;
	}	
	public static function updateFicha($datos){
	    $respuesta =  TituladaModel::updateFicha($datos);
 		return $respuesta;
	}		
	public static function updateCompetencia($datos){
	    $respuesta =  TituladaModel::updateCompetencia($datos);
 		return $respuesta;
	}	
	public static function quitarlresultados($id){
	    $respuesta =  TituladaModel::quitarlresultados($id);
 		return $respuesta;
	}
	public static function nuevorap($id){
	    $respuesta =  TituladaModel::nuevorap($id);
 		return $respuesta;
	}			
	public static function activarlresultados($id){
	    $respuesta =  TituladaModel::activarlresultados($id);
 		return $respuesta;
	}	
	public function verHinstructor($id,$idFicha,$vinculacion,$modificar){
	    $respuesta = TituladaModel::verHinstructor($id,$idFicha,$vinculacion,$modificar);
 		return $respuesta;
	}					
	public function verHficha($id,$idFicha,$modificar){
	    $respuesta = TituladaModel::verHficha($id,$idFicha,$modificar);
 		return $respuesta;
	}				 	 		 
}
 