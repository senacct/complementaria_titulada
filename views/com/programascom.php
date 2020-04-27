<?php
require_once "../../models/programasModel.php";
Class Programas{
	public function verProgramas(){
	    $respuesta = ProgramasModel::verProgramas();
 		return $respuesta;
	}
	public function traerlespecialidad(){
	    $respuesta =  ProgramasModel::traerlespecialidad();
 		return $respuesta;
	}	
	public function validarPrograma($codigo){
	    $respuesta = ProgramasModel::validarPrograma($codigo);
 		return $respuesta;
	}
	public function traerPrograma($id){
	    $respuesta = ProgramasModel::traerPrograma($id);
 		return $respuesta;
	}	
	public function updatePrograma($datos){
	    $respuesta = ProgramasModel::updatePrograma($datos);
 		return $respuesta;
	}	
	public function tablaProgramas(){
	    $respuesta = ProgramasModel::tablaProgramas();
 		return $respuesta;
	}

}

$a =  new Programas(); 
$dato = filter_input(INPUT_POST,'dato');
$request = filter_input(INPUT_POST,'request'); 
switch ($dato) {  
	case 'programas':
		switch ($request){
			case 'ver':
				echo $a->verProgramas(); 
			break;
         	case 'validar':
         	    $codigo = htmlentities(filter_input(INPUT_POST,'codigo'));
         	    return $a->validarPrograma($codigo);
         	break; 
         	case 'traerid':
         	    $id = htmlentities(filter_input(INPUT_POST,'id'));
         	    return $a->traerPrograma($id);
         	break; 
			case 'listado':				
			    $respuesta = $a -> tablaProgramas(); 
			    echo $respuesta;
			break;         	
         	case 'update':
         	    $nombre = filter_input(INPUT_POST,'nombre');
				$nombre = strtoupper($nombre);
	   		    $datos = [
	   		    'id' => filter_input(INPUT_POST,'id'),
	   		    'idespecialidad' => filter_input(INPUT_POST,'idespecialidad'),
			    'codigo' => filter_input(INPUT_POST,'codigo'),
			    'nivel' => filter_input(INPUT_POST,'nivel'),
			    'modalidad' => filter_input(INPUT_POST,'modalidad'),
				'version' => htmlentities(filter_input(INPUT_POST,'version')),
				'horas' => htmlentities(filter_input(INPUT_POST,'horas')),
				'nombre' =>  htmlentities($nombre), 
				'estado' => htmlentities(filter_input(INPUT_POST,'estado'))
                ];
                //return var_dump($arregloDatos);
                echo $a->updatePrograma($datos); 
            break;         	         				
	     }	    		
	break;
	case 'especialidad':
	switch ($request){
			case 'lista':
         	   echo $a->traerlespecialidad();
         	    break;
	    }	    		
	break;
} 
