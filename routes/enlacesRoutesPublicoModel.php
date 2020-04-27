<?php
class EnlacesRoutesPublico{
	public static function enlacesRoutesModel($enlace){
		$modulo = "views/modulos/".$enlace.".php"; 
      return $modulo;
	}
}

