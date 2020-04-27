<?php
class EnlacesController{
public static function enlacesPublico(){ 
	//$modulo = $_GET["modulo"];
		if(isset($_GET["modulo"])){
			$request = explode("/",$_GET['modulo']);	
			$modulo = $request[0];	
			$respuesta = EnlacesRoutesPublico::enlacesRoutesModel($modulo);
			if($modulo == 'inicio' ||
			   $modulo == 'login' ||
			   $modulo == 'salir' ||
			   $modulo == 'planeacion' ||
			   $modulo == 'usuarios' ||
			   $modulo == 'formaciones' ||
			   $modulo == 'autorizar' ||
			   $modulo == 'coorconsultar' ||
			   $modulo == 'publicarficha' ||
			   $modulo == 'programar' ||
			   $modulo == 'gespendientes' ||	
			   $modulo == 'programas' ||
			   $modulo == 'adminconsulta' ||
			   $modulo == 'adminusuarios' ||
			   $modulo == 'valradicado' ||
			   $modulo == 'valcontactos' ||
			   $modulo == 'ofertaabierta' ||
			   $modulo == 'agentesgs' ||
			   $modulo == 'prospectos' ||
			   $modulo == 'proficha' ||
			   $modulo == 'bitacoras' ||
			   $modulo == 'competencias' ||			   
			   $modulo == 'fichastitulada' ||			   			   
			   $modulo == 'notificaciones'){
			}else{
			$respuesta = EnlacesRoutesPublico::enlacesRoutesModel("inicio");
		}	
		include_once $respuesta;
    }
}
}
