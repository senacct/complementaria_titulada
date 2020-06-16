<?php
require_once "../../models/empresaModel.php";
require_once "../../models/formacionModel.php";
Class Formacion{
	public function newFicha($datos){
	    $respuesta = FormacionModel::newFicha($datos);
 		echo $respuesta;
	}
    public function nuevaofertaAbierta(){
	    $respuesta = FormacionModel::nuevaofertaAbierta();
 		echo $respuesta;
	}
	public function listOfertaAbierta(){
	    $respuesta = FormacionModel::listOfertaAbierta();
 		echo $respuesta;
	}	
	public function listFormaciones($idempresa){
	    $respuesta = FormacionModel::listFormaciones($idempresa);
 		echo $respuesta;
	}
	public function eliminarFicha($id){
	    $respuesta = FormacionModel::eliminarFicha($id);
 		echo $respuesta;
	}	
	public function tablaCursos($datos){
	    $respuesta = FormacionModel::tablaCursos($datos); 
 		return $respuesta;
	}
 	
	public function selCurso($datos){
	    $respuesta = FormacionModel::selCurso($datos);
 		return $respuesta;
	}

	public function traerdCurso($id){
	    $respuesta = FormacionModel::traerdCurso($id);
 		return $respuesta;
	}

	public function updateCurso($datos){
	    $respuesta = FormacionModel::updateCurso($datos);
 		echo $respuesta;
	}

	public function listPespeciales(){
	    $respuesta = FormacionModel::listPespeciales();
 		return $respuesta;
	}	
	public function selectCalendario($datos){
	    $respuesta = FormacionModel::selectCalendario($datos); 
 		return $respuesta;
	}	

	public function selCalendario($datos){
	    $respuesta = FormacionModel::selCalendario($datos);
 		return $respuesta;
	}

	public function unselCalendario($datos){
	    $respuesta = FormacionModel::unselCalendario($datos);
 		return $respuesta;
	}		
	public function programacion($idficha){
	    $respuesta = FormacionModel::programacion($idficha);
 		return $respuesta;
	}
	public function verprogramacion($datos){
	    $respuesta = FormacionModel::verprogramacion($datos);
 		return $respuesta;
	}	
	public function solValidarFicha($idficha){
	    $respuesta = FormacionModel::solValidarFicha($idficha);
 		return $respuesta;
	}	

	public function solpublicarficha($idficha){
	    $respuesta = FormacionModel::solpublicarficha($idficha);
 		return $respuesta;
	}

	public function verValidacion($idficha){
	    $respuesta = FormacionModel::verValidacion($idficha);
 		return $respuesta;
	}
	public function updateRadicado($datos){
	    $respuesta = FormacionModel::updateRadicado($datos);
 		return $respuesta;
	}	
	public function valRadicado(){
	    $respuesta = FormacionModel::valRadicado();
 		return $respuesta;
	}
    public function validadoRadicado($datos){
	    $respuesta = FormacionModel::validadoRadicado($datos);
 		return $respuesta;
	}	
	public function instruBloquear($datos){
	    $respuesta = FormacionModel::instruBloquear($datos);
 		return $respuesta;
	}
	public function noconfirmadoRadicado($datos){
	    $respuesta = FormacionModel::noconfirmadoRadicado($datos);
 		echo $respuesta;
	}	
}

$a =  new Formacion();  
//$a -> traerPropositos();
$dato = filter_input(INPUT_POST,'dato');
$request = filter_input(INPUT_POST,'request');
switch ($dato) {  
	case 'programacion':
		switch ($request){
			case 'lista':
			    $idficha = filter_input(INPUT_POST,'idficha');	
			echo $a->programacion($idficha); 
			break;
			case 'ver':
	   		    $datos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
				'numero' => filter_input(INPUT_POST,'numero')
	            ];	
			echo $a->verprogramacion($datos); 
			break;			
	}		
	break;
 
	case 'formacion':
		switch ($request) {
			case 'nueva':
	   		    $arregloDatos = [
			    'idempresa' => filter_input(INPUT_POST,'idempresa'),
				'nempresa' => filter_input(INPUT_POST,'nempresa')
	            ];			
			return $a->newFicha($arregloDatos); 
			break;
			case 'ofertaabierta':			
			return  $a->nuevaofertaAbierta(); 
			break;			
			case 'list':
			       $idempresa = filter_input(INPUT_POST,'idempresa');			
			return $a->listFormaciones($idempresa);  
			break;	
			case 'listOa':			       			
			return $a->listOfertaAbierta();  
			break;				
			case 'eliminar':
				   $id = filter_input(INPUT_POST,'id');	
			return $a->eliminarFicha($id); 
			break;	
			case 'tabla':
			$arregloDatos = [
				   'idficha' => filter_input(INPUT_POST,'idficha'),	
				   'idempresa' => filter_input(INPUT_POST,'idempresa')
				   ];	
			echo $a->tablaCursos($arregloDatos); 
			break;
			case 'updateRadicado':
			$arregloDatos = [
				   'idficha' => filter_input(INPUT_POST,'idficha'),	
				   'onbase' => filter_input(INPUT_POST,'onbase')
				   ];	
			echo $a->updateRadicado($arregloDatos); 
			break;			
			case 'seleccionar':
			$arregloDatos = [
				   'idficha' => filter_input(INPUT_POST,'idficha'),
				    'horas' => filter_input(INPUT_POST,'horas'),
				   'idcurso' => filter_input(INPUT_POST,'idcurso')
	            ];	
			echo $a->selCurso($arregloDatos); 
			break;
			case 'update':
			$lugar = filter_input(INPUT_POST,'lugar');
			$lugar = strtoupper($lugar);
			$dirformacion = filter_input(INPUT_POST,'dirformacion');
			$dirformacion = strtoupper($dirformacion);			
			$arregloDatos = [
					'id' => filter_input(INPUT_POST,'id'),
					'lugar' => htmlentities($lugar),
					'dirformacion' => htmlentities($dirformacion),
					'naprendices' => filter_input(INPUT_POST,'naprendices'),
					'ciudad' => filter_input(INPUT_POST,'ciudad'),
					'depto' => filter_input(INPUT_POST,'depto'),
					'pespeciales' => filter_input(INPUT_POST,'pespeciales')
	            ];	
			echo $a->updateCurso($arregloDatos); 
			break;
			case 'traerdcurso':
				   $idficha = filter_input(INPUT_POST,'id') ;
			echo $a->traerdCurso($idficha); 
			break;	
			case 'solvalidar':
				   $idficha = filter_input(INPUT_POST,'idficha') ;
			echo $a->solValidarFicha($idficha); 
			break;
			case 'solcrear':
				   $idficha = filter_input(INPUT_POST,'idficha') ;
			echo $a->solpublicarficha($idficha); 
			break;				
			case 'vervalidacion':
				   $idficha = filter_input(INPUT_POST,'idficha') ;
			echo $a->verValidacion($idficha); 
			break;	
			case 'radicado':
			echo $a->valRadicado(); 
			break;
			case 'bloquear':
			    $arregloDatos = [
			    'idinstructor' => filter_input(INPUT_POST,'idinstructor'),
				'nestado' => filter_input(INPUT_POST,'nestado')
	            ];	
			echo $a->instruBloquear($arregloDatos); 
			break;
			case 'validadoradicado':
			    $arregloDatos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
			    'nestado' => filter_input(INPUT_POST,'nestado')
	            ];	
			echo $a->validadoRadicado($arregloDatos); 
			break;
			case 'noconfirmado':
				$datos = [
				'idficha' => filter_input(INPUT_POST,'idusuario'),
				'explicacion' => filter_input(INPUT_POST,'explicacion')
	            ];	
				echo $a->noconfirmadoRadicado($datos); 
			break;						
		     default:
			   return '1';
			break;
		}
	break;
	case 'pespeciales':
			switch ($request) {
				case 'list':			
				return $a->listPespeciales(); 
				break;
			}
	break;		
	case 'calendario':
		switch ($request) {
			case 'select':
			$arregloDatos = [
			'idficha' => filter_input(INPUT_POST,'idficha'),
			'idempresa' => filter_input(INPUT_POST,'idempresa') 
		    ];
			echo $a->selectCalendario($arregloDatos);  
			break;
			case 'sel':
			$arregloDatos = [
				'idficha' => filter_input(INPUT_POST,'idficha'),
				'inicia' => filter_input(INPUT_POST, 'inicia'),
				'finaliza' => filter_input(INPUT_POST, 'finaliza'),
				'ano' => filter_input(INPUT_POST, 'ano'),
				'mes' => filter_input(INPUT_POST, 'mes'),
				'dia' => filter_input(INPUT_POST, 'dia'),
				'ds' => filter_input(INPUT_POST, 'ds'),
				'festivo' => filter_input(INPUT_POST, 'festivo'),
				'estado' => '1',

				//se agregan dos parametros mas
				'idInstructor' => filter_input(INPUT_POST, 'idInstructor'),
				'idResultado' => filter_input(INPUT_POST, 'idResultado'),
				'idCompetencia' => filter_input(INPUT_POST, 'idCompetencia'),
				'textCompetencia' => filter_input(INPUT_POST, 'textCompetencia'),
				'textResultado' => filter_input(INPUT_POST, 'textResultado'),
				'esTitulada' => filter_input(INPUT_POST, 'esTitulada'),
				'esMultiple' => filter_input(INPUT_POST, 'esMultiple')


		    ];
			echo $a->selCalendario($arregloDatos); 
			break;	
			case 'unsel':
			$arregloDatos = [
				'idficha' => filter_input(INPUT_POST,'idficha'),
				'inicia' => filter_input(INPUT_POST, 'inicia'),
				'finaliza' => filter_input(INPUT_POST, 'finaliza'),
				'ano' => filter_input(INPUT_POST, 'ano'),
				'mes' => filter_input(INPUT_POST, 'mes'),
				'dia' => filter_input(INPUT_POST, 'dia'),
				'ds' => filter_input(INPUT_POST, 'ds'),
				'festivo' => filter_input(INPUT_POST, 'festivo'),
				'estado' => '0',

				//se agregan dos parametros mas
				'idInstructor' => filter_input(INPUT_POST, 'idInstructor'),
				'idResultado' => filter_input(INPUT_POST, 'idResultado'),
				'idCompetencia' => filter_input(INPUT_POST, 'idCompetencia'),
				'textCompetencia' => filter_input(INPUT_POST, 'textCompetencia'),
				'textResultado' => filter_input(INPUT_POST, 'textResultado'),
				'esTitulada' => filter_input(INPUT_POST, 'esTitulada')
		    ];
			echo $a->unselCalendario($arregloDatos); 
			break;				
		break;
	}
	break;		

} 
