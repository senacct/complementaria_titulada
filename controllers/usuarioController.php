<?php
class GestionUsuarioController{
	 public static function ingresoUsuario($datos){
		$respuesta = GestionUsuarioModel::ingresoUsuario($datos);
		return $respuesta;	 	
	 }
	 public static function cerrarUsuario(){
		$respuesta = GestionUsuarioModel::cerrarUsuario();
		return $respuesta;	 	
	 }	 
 	 public static function templateIngresoController(){
		$respuesta = GestionUsuarioModel::templateIngresoModel();
		return $respuesta;	 	
	 }

 	 public static function validarCorreosena($correosena){
		$respuesta = GestionUsuarioModel::validarCorreosena($correosena);
		return $respuesta;	 	
	 }
 	 public static function validarcoredit($datos){
		$respuesta = GestionUsuarioModel::validarcoredit($datos);
		return $respuesta;	 	
	 }	 	 
	 public static function crearUsuario($datos){
		$respuesta = GestionUsuarioModel::crearUsuario($datos);
		return $respuesta;	 	
	 }	
	 public static function updateUsuario($datos){
		$respuesta = GestionUsuarioModel::updateUsuario($datos);
		return $respuesta;	 	
	 }		 
     public static function listadoUsuarios(){
		$respuesta = GestionUsuarioModel::listadoUsuarios();
		return $respuesta;	 	
	 }	
     public static function listadoUsuariosSel1(){
		$respuesta = GestionUsuarioModel::listadoUsuariosSel();
		return $respuesta;	 	
	 }	
	 public static function listadoUsuariosSel(){
		$respuesta = GestionUsuarioModel::listadoUsuariosSel();
		return $respuesta;	 	
	 }
	 public static function listadoUsuariosSelFicha(){
		$respuesta = GestionUsuarioModel::listadoUsuariosSelFicha();
		return $respuesta;	 	
	 }
     public static function getPerfiles($datos){
		$respuesta = GestionUsuarioModel::getPerfiles($datos);
		return $respuesta;	 	
	 }		  
     public static function getCoordinaciones(){
		$respuesta = GestionUsuarioModel::getCoordinaciones();
		return $respuesta;	 	
	 }
     public static function traerEditar($id){
		$respuesta = GestionUsuarioModel::traerEditar($id);
		return $respuesta;	 	
	 }	
	public static function instruEstado($datos){
	    $respuesta = GestionUsuarioModel::instruEstado($datos);
 		return $respuesta;
	}		
	public static function chulearPerfil($datos){
	    $respuesta = GestionUsuarioModel::chulearPerfil($datos);
 		return $respuesta;
	}	 
	public static function nuevaContrasena($id){
	    $respuesta = GestionUsuarioModel::nuevaContrasena($id);
 		return $respuesta;
	}	 
}

