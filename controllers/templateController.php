<?php
class TemplateController{
	public static function templatePrincipal(){
		include "views/template.php";
	}
	public static function menuUsuarioActivoController(){
	  $respuesta = templateModel::menuUsuarioActivoModel(); 
	  echo $respuesta;
	}	
}