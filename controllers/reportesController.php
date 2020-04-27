<?php
class GestionReportesController{
	 public static function reportesBitacora(){
		$respuesta = GestionReportesModel::reportesBitacora();
		return $respuesta;	 	
	 } 
}

