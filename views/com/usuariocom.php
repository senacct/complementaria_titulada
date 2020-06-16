<?php
include_once "../../controllers/usuarioController.php";
include_once "../../models/usuarioModel.php";
$a =  new GestionUsuarioController();  
//$a -> traerPropositos();
$dato = filter_input(INPUT_POST,'dato');
$request = filter_input(INPUT_POST,'request');
switch ($dato) {  
	case 'usuario':
		switch ($request){
			//Opcion 1 request usuario
			case 'ingreso':
			    $datos = [
				 'correo' => filter_input(INPUT_POST,'correo'),
				 'contrasena' => filter_input(INPUT_POST,'contrasena')
	            ];					
			    $respuesta = $a -> ingresoUsuario($datos); 
			    echo $respuesta;
			break;
			//Opcion 2 request usuario			
			case 'cerrar':				
			    $respuesta = $a -> cerrarUsuario(); 
			    echo $respuesta;
			break;
			case 'validar':		
			    $correosena = filter_input(INPUT_POST,'correosena');		
			    $respuesta = $a -> validarCorreosena($correosena); 
			    echo $respuesta;
			break;	
			case 'validaredit':		
			    $datos = [
				 'id' => filter_input(INPUT_POST,'id'),
				 'correosena' => filter_input(INPUT_POST,'correosena')
	            ];			
			    $respuesta = $a -> validarcoredit($datos); 
			    echo $respuesta;
			break;				
			case 'listado':				
			    $respuesta = $a -> listadoUsuarios(); 
			    echo $respuesta;
			break;
			case 'selprogramar':				
			    $respuesta = $a -> listadoUsuariosSel(); 
				//echo 'Respuesta';
				echo $respuesta;
			break;	
			case 'selprogramarFicha':				
			    $respuesta = $a -> listadoUsuariosSelFicha(); 
				//echo 'Respuesta';
				echo $respuesta;
			break;			
			case 'getPerfiles':
			    $datos = [
				 'idusuario' => filter_input(INPUT_POST,'idusuario'),
				 'idcoordinacion' => filter_input(INPUT_POST,'idcoordinacion')
	            ];				
			    $respuesta = $a -> getPerfiles($datos); 
			    echo $respuesta;
			break;				
			case 'coordinaciones':				
			    $respuesta = $a -> getCoordinaciones(); 
			    echo $respuesta;
			break;							
			case 'crear':
         	$nombre = filter_input(INPUT_POST,'nombre');
			$nombre = strtoupper($nombre);
			    $datos = [
				 'correosena' => filter_input(INPUT_POST,'correosena'),
				 'correootro' => filter_input(INPUT_POST,'correootro'),
				 'vinculacion' => filter_input(INPUT_POST,'vinculacion'),
				 'instructor' => filter_input(INPUT_POST,'instructor'),
				 'nombre' => htmlentities($nombre),
				 'telefono' => filter_input(INPUT_POST,'telefono')
	            ];					
			    $respuesta = $a -> crearUsuario($datos); 
			    echo $respuesta;
			break;	
			case 'update':
         	$nombre = filter_input(INPUT_POST,'nombre');
			$nombre = strtoupper($nombre);
			$nombre = addslashes($nombre);
			    $datos = [
			    'id' => filter_input(INPUT_POST,'id'),	
			     'idcoordinacion' => filter_input(INPUT_POST,'idcoordinacion'),
				 'correosena' => filter_input(INPUT_POST,'correosena'),
				 'correootro' => filter_input(INPUT_POST,'correootro'),
				 'vinculacion' => filter_input(INPUT_POST,'vinculacion'),
				 'instructor' => filter_input(INPUT_POST,'instructor'),
				 'nombre' => htmlentities($nombre),
				 'telefono' => filter_input(INPUT_POST,'telefono')
	            ];					
			    $respuesta = $a -> updateUsuario($datos); 
			    echo $respuesta;
			break;	
			case 'restablecer':
			    $id = filter_input(INPUT_POST,'idusuario');					
			    $respuesta =  $a -> nuevaContrasena($id); 
			    echo $respuesta;
			break;			
			case 'geteditar':
			    $id = filter_input(INPUT_POST,'id');					
			    $respuesta =  $a -> traerEditar($id); 
			    echo $respuesta;
			break;
			case 'estado':
			    $datos = [
			    'idinstructor' => filter_input(INPUT_POST,'idinstructor'),
				'nestado' => filter_input(INPUT_POST,'nestado')
	            ];	
			echo $a->instruEstado($datos); 
			break;
			case 'chulearperfil':
			    $datos = [
			    'idusuario' => filter_input(INPUT_POST,'idusuario'),	
			    'perfil' => filter_input(INPUT_POST,'perfil'),
				'nestado' => filter_input(INPUT_POST,'nestado')
	            ];	
			echo $a->chulearPerfil($datos); 
			break;																	
	    }		
	break;
} 