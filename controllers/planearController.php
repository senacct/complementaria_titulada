<?php
class GestionPlanearController{
	 public static function PlanearTemplateController($modulo){
	 	switch ($modulo) {
			case 'horarioinstructor':
				$respuesta =  GestionPlanearModel::horarioinstructor();
			break;				 
	 		case 'planeacion':
	 			$respuesta =  GestionPlanearModel::introduccionModel();
	 			break;	 		
	 		case 'preparar':
	 			$respuesta = GestionPlanearModel::prepararModel();
	 			break;
	 		case 'empresas':
				$respuesta = GestionPlanearModel::empresasModel();
	 			break;
	 		case 'status':
				$respuesta = GestionPlanearModel::statusModel();
	 			break;	
	 		case 'miplaneacion':
				$respuesta = GestionPlanearModel::miplaneacionModel();
	 			break;		 			
	 		case 'formaciones':
				$codigo = explode("/", $_GET['modulo']);   
				if(count($codigo) == 5){       
				  $respuesta = GestionPlanearModel::formacionModel($codigo[3]);      
				} 	 		    
	 			break;	
	 		case 'error':
				$respuesta = GestionPlanearModel::errorModel();
				 break;		 				 		
	 		default:
	 			$respuesta = '<h1>Esta intentando colocar datos errados en el sistema...Eso no se hace!!</h1>';
	 			break;
	 	}
		echo $respuesta;	 	
	 }
}
 



