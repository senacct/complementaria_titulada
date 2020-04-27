<?php
require_once "../../models/empresaModel.php";
Class Empresa{

	public function updateEmpresa($datos){
		    $respuesta = EmpresaModel::updateEmpresa($datos);
	 		return $respuesta;
	}
	public function listEmpresa(){
		    $respuesta = EmpresaModel::listEmpresa();
	 		echo $respuesta;
	}		
	public function editEmpresa($id){
		    $respuesta = EmpresaModel::editEmpresa($id);
	 		return $respuesta;
	}
	public function validarEmpresa($nit){
		    $respuesta = EmpresaModel::validarEmpresa($nit);
	 		return $respuesta;
	}	
	public function selectDeptos(){
		    $respuesta = EmpresaModel::selectDepto();
	 		return $respuesta;
	}
	public function tablaContacto(){
		    $respuesta = EmpresaModel::tablaContacto();
	 		return $respuesta;
	}	
	public function selectCiudad($idDepto){
		    $respuesta = EmpresaModel::selectCiudad($idDepto);
	 		return $respuesta;
	}
	public function validarContactos($datos){
	        $respuesta = EmpresaModel::validarContactos($datos);
 		    echo $respuesta;
	}
}

$a =  new Empresa();  
//$a -> traerPropositos();
$dato = filter_input(INPUT_POST,'dato');
$request = filter_input(INPUT_POST,'request');
switch ($dato) {  
	case 'ingreso':
		$a-> usuario = filter_input(INPUT_POST,'usuario'); 	
		$a-> password = filter_input(INPUT_POST,'password'); 
		$a-> consultaUsuario();	
	break;
	case 'depto':
		switch ($request) {
			case 'select':
				   return $a->selectDeptos(); 
				break;
			default:
				# code...
				break;
		}

	case 'ciudad':
		switch ($request) {
			case 'select':
			       $idDepto = filter_input(INPUT_POST,'idDepto');
				   return $a->selectCiudad($idDepto); 
				break;
			default:
				   return '1';
				break;
		}

	break;	

	case 'empresa':
         switch ($request) {  
         	case 'update': 
         	$nempresa = filter_input(INPUT_POST,'nempresa');
			$nempresa = strtoupper($nempresa);
			$nit = filter_input(INPUT_POST,'nit');
         	$ncontacto = filter_input(INPUT_POST,'ncontacto');
			$ncontacto = strtoupper($ncontacto);
	   		    $arregloDatos = [
			    'id' => filter_input(INPUT_POST,'id'),
				'nempresa' => htmlentities($nempresa),
				'nit' => htmlentities($nit),
				'direccion' =>  htmlentities(filter_input(INPUT_POST,'direccion')),
				'depto' => filter_input(INPUT_POST,'depto'),
				'ciudad' => filter_input(INPUT_POST,'ciudad'),
				'ncontacto'=>  htmlentities($ncontacto),
				'tcontacto'=>  htmlentities(filter_input(INPUT_POST,'tcontacto')),
				'correo' => htmlentities(filter_input(INPUT_POST,'correo'))
                ];
                //return var_dump($arregloDatos);
                return $a->updateEmpresa($arregloDatos); 
         		break;
         	case 'list':
         	    return $a->listEmpresa();
         	break;
         	case 'edit':
         	    $id = htmlentities(filter_input(INPUT_POST,'id'));
         	    return $a->editEmpresa($id);
         	break;  
         	case 'validar':
         	    $nit = htmlentities(filter_input(INPUT_POST,'nit'));
         	    return $a->validarEmpresa($nit);
         	break;   
         	case 'listacontactos':
         	    echo $a->tablaContacto();
         	break;
			case 'contactovalidar':
				$datos = [
			    'idficha' => filter_input(INPUT_POST,'idficha'),
				'nvalidado' => filter_input(INPUT_POST,'nvalidado')
	            ];	
				echo $a->validarContactos($datos);          	          	         	       	
         	default:
         		# code...
         		break;
         }

	break;
 
	default:
		return $dato;
		break;
} 
