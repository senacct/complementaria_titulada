<?php
require_once "../../controllers/tituladaController.php";
require_once "../../models/tituladaModel.php";
Class Titulada{	
	public function programacion($datos){
	    $respuesta = TituladaController::programacion($datos);
 		return $respuesta;
	}
	public function listaFichasTitulada($tipores){
	    $respuesta = TituladaController::listaFichasTitulada($tipores);
 		return $respuesta;
	}
	public function listaCompetencias(){
	    $respuesta = TituladaController::listaCompetencias();
 		return $respuesta;
	}	
	public function listaResultados($id){
	    $respuesta = TituladaController::listaResultados($id);
 		return $respuesta;
	}	
	public function verHinstructor($id,$idFicha,$vinculacion,$modificar,$trimestreSel,$anoSel){
	    $respuesta = TituladaController::verHinstructor($id,$idFicha,$vinculacion,$modificar,$trimestreSel,$anoSel);
 		return $respuesta;
	}	
	public function verHficha($id,$idFicha,$modificar,$trimestreSel,$anoSel){
	    $respuesta = TituladaController::verHficha($id,$idFicha,$modificar,$trimestreSel,$anoSel);
 		return $respuesta;
	}	
	public function lprogresultado(){
	    $respuesta = TituladaController::lprogresultado();
 		return $respuesta;
	}	
	public function lresultadoPro($idProgramacion, $modificar){
	    $respuesta = TituladaController::lresultadoPro($idProgramacion, $modificar);
 		return $respuesta;
	}
	public function traerlprogramas(){
	    $respuesta = TituladaController::traerlprogramas();
 		return $respuesta;
	} 
	public function existeFicha($ficha){
	    $respuesta = TituladaController::existeFicha($ficha);
 		return $respuesta;
	}	
	public function traerEditficha($id){
	    $respuesta = TituladaController::traerEditficha($id);
 		return $respuesta;
	}	
	public function traerEditCompetencia($id){
	    $respuesta = TituladaController::traerEditCompetencia($id);
 		return $respuesta;
	}		
	public function updateFicha($datos){
	    $respuesta = TituladaController::updateFicha($datos);
 		echo $respuesta;
	}
	public function updateCompetencia($datos){
	    $respuesta = TituladaController::updateCompetencia($datos);
 		echo $respuesta;
	}	

	public function quitarlresultados($id){
	    $respuesta = TituladaController::quitarlresultados($id);
 		echo $respuesta;
	}
	public function activarlresultados($id){
	    $respuesta = TituladaController::activarlresultados($id);
 		echo $respuesta;
	}	
	public function nuevorap($datos){
	    $respuesta = TituladaController::nuevorap($datos);
 		echo $respuesta;
	}	

	public function validarfecha($fecha){
	$html = '';	
	$respuesta = '1';	
	$date = date('Y-m-d',strtotime('2017-01-01'));
	$tfecha = strtotime($fecha);
	$nfecha = date('Y-m-d', $tfecha);
		for ($i = 1; $i < 5200; $i++) { 
		    $mod_date = date(strtotime($date."+ $i days"));
		    if(date('Y-m-d',$mod_date) == $nfecha){
		      $respuesta = '0';
		    } 
		}
       return $respuesta;
	}			 
}

$a =  new Titulada();  
//$a -> traerPropositos();
$dato = filter_input(INPUT_POST,'dato');
$request = filter_input(INPUT_POST,'request');
switch ($dato) {  
	case 'titulada':
		switch ($request){
			case 'lcompetencias':
				echo $a->listaCompetencias(); 			
			break;
			case 'verHinstructor':
				$id = filter_input(INPUT_POST,'id');
				$idFicha = filter_input(INPUT_POST,'idFicha');
				$vinculacion = filter_input(INPUT_POST,'vinculacion');
				$modificar = filter_input(INPUT_POST,'modificar');
				$trimestreSel = filter_input(INPUT_POST,'trimestreSel');
				$anoSel = filter_input(INPUT_POST,'anoSel');

				echo $a->verHinstructor($id,$idFicha, $vinculacion, $modificar,$trimestreSel,$anoSel); 			
			break;	
			case 'verHficha':
			    $id = filter_input(INPUT_POST,'id');
				$idFicha = filter_input(INPUT_POST,'idFicha');
				$modificar = filter_input(INPUT_POST,'modificar');
				$trimestreSel = filter_input(INPUT_POST,'trimestreSel');
				$anoSel = filter_input(INPUT_POST,'anoSel');
				
				echo $a->verHficha($id,$idFicha,$modificar,$trimestreSel,$anoSel); 			
			break;			
			case 'update':
			$error = 0;
            $numero = filter_input(INPUT_POST,'ficha');
            $jornada = filter_input(INPUT_POST,'jornada');
            $ciudad = filter_input(INPUT_POST,'ciudad');
            $depto = filter_input(INPUT_POST,'depto'); 
            $coordinacion = filter_input(INPUT_POST,'coordinacion');                        
            $fechainicio = filter_input(INPUT_POST,'fechainicio');            
			$fechafin = filter_input(INPUT_POST,'fechafin');
			$lugar = filter_input(INPUT_POST,'ambiente');
			$lugar = strtoupper($lugar);
			$programa = filter_input(INPUT_POST,'programa');
			$error = $a->validarfecha($fechainicio);
			$ferror = 'frmfinicio';
			$verror = $fechainicio;

//nuevos datos
			$directorGrupo = filter_input(INPUT_POST,'directorGrupo');
			$formacionFuera = filter_input(INPUT_POST,'formacionFuera');
			

			if($error == 0){
			   $error = $a->validarfecha($fechafin);
			   if($error == '1'){
					$ferror = 'frmfechafin';
					$verror = $fechafin;			   	
			   }	
		    }
			$arregloDatos = [
					'id' => filter_input(INPUT_POST,'idficha'),
					'jornada' => $jornada,
					'numero' => $numero,
					'ciudad' => $ciudad,
					'depto' => $depto,
					'coordinacion' => $coordinacion,					
					'lugar' => htmlentities($lugar),
					'programa' => $programa,
					'fechainicio' => $fechainicio,
					'fechafin' => $fechafin,
					
					'directorGrupo' => $directorGrupo,
					'formacionFuera' => $formacionFuera
	            ];
	        if($error == 0){
				echo $a->updateFicha($arregloDatos); 
	        }else{
				$newdata =  array (
				'respuesta' => '3',
				'ferror' => $ferror,
				'verror' => $verror
				);
				$arrDatos[] = $newdata;  
				echo json_encode($arrDatos); 	
	        }    	
						
			break;
			case 'lista':
	   		    $datos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
				'idtrimestre' => filter_input(INPUT_POST,'idtrimestre')
	            ];
			echo $a->programacion($datos); 
			break;
			case 'listaFichas':
			$tipores = filter_input(INPUT_POST,'tipores');
			echo $a->listaFichasTitulada($tipores); 
			break;	
			case 'lresultados':
			$id = htmlentities(filter_input(INPUT_POST,'id'));			
			echo $a->listaResultados($id); 
			break;		
			case 'lprogresultado':			
			echo $a->lprogresultado(); 
			break;	
			case 'lresultadoPro':
				
				$idProgramacion = filter_input(INPUT_POST,'idProgramacion');
				$modificar= filter_input(INPUT_POST,'modificar');

				echo $a->lresultadoPro($idProgramacion,$modificar); 
				
			break;					
			case 'valfecha':
			$fecha = filter_input(INPUT_POST,'fecha');
			echo $a->validarFecha($fecha); 
			break;					
			case 'programas':
			echo $a->traerlprogramas(); 
			break;						
         	case 'existe':
         	    $ficha = htmlentities(filter_input(INPUT_POST,'ficha'));
         	    return $a->existeFicha($ficha);
         	break;  
         	case 'teditar':
         	    $id = htmlentities(filter_input(INPUT_POST,'id'));
         	    return $a->traerEditficha($id);
         	break;
         	case 'edicompetencia':
         	    $id = htmlentities(filter_input(INPUT_POST,'id'));
         	    return $a->traerEditCompetencia($id);
         	break;  

         	case 'quitarlresultados':
         	    $id = htmlentities(filter_input(INPUT_POST,'id'));
         	    return $a->quitarlresultados($id);
         	break;  
         	case 'activarlresultados':
         	    $id = htmlentities(filter_input(INPUT_POST,'id'));
         	    return $a->activarlresultados($id);
         	break;  

         	case 'nuevorap':
         	    $nresultado = htmlentities(filter_input(INPUT_POST,'nresultado'));
	   		    $datos = [
			    'idcompetencia' => filter_input(INPUT_POST,'idcompetencia'),
				'nresultado' => $nresultado
	            ];
         	    return $a->nuevorap($datos);
         	break; 

			case 'compeupdate':
			    $datos = [
			     'id' => filter_input(INPUT_POST,'id'),	
				 'codigo' => filter_input(INPUT_POST,'codigo'),
				 'texto' => filter_input(INPUT_POST,'texto')
	            ];					
			    return $a -> updateCompetencia($datos); 
			break;         	         			
	}		
	break;
} 


