<?php
class GestionPlanearModel{
	  public static function prepararModel(){ 
	    return '
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Inicio</a></li>
		    <li class="breadcrumb-item"><a href="'.SERVERURL.'planeacion/">Planeación</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Prepara Formación</li>
		  </ol>
		</nav>
	    <div class="d-flex p-2 bd-highlight"><button type="button"   class="btn btn-success btn-block btn-lg">NUEVA FICHA</button></div>
	    <script src="../../views/js/gestionPlaneacion.03.js"></script>	';
		} 	
	  public static function empresasModel(){
	    return '
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Inicio</a></li>
		    <li class="breadcrumb-item"><a href="'.SERVERURL.'planeacion/">Planeación</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Oferta Empresas</li>
		  </ol>
	    <div class="d-flex p-2 bd-highlight"><button type="button" onClick="nuevaEmpresa(\'24\',\'1\',\'0\')" class="btn btn-success btn-block btn-lg">NUEVA EMPRESA</button></div>
	    <script src="../../views/js/gestionPlaneacion.03.js"></script><script>listEmpresa();</script>	';
		} 	

		public static function horarioinstructor(){
			return require_once("../complementaria/views/modulos/horarioinstructor.php");
		} 
	  public static function statusModel(){
	  	
	    return require_once("../complementaria/views/modulos/status.php");
		} 
	  public static function miplaneacionModel(){
	  	
	    return require_once("../complementaria/views/modulos/miplaneacion.php");
		} 		
	public static function formacionModel($identificador){
		$usuario = $_SESSION['prc_ciuser'];
		require_once "conexion.php";
		$sqlt = "SELECT e.id id, e.nombre nombre, e.departamento iddepto, e.ciudad idciudad FROM empresas e INNER JOIN contactos c ON e.identificador = c.idempresa WHERE e.identificador = '$identificador' AND e.estado = '1' AND c.idusuario = '$usuario' ORDER BY e.nombre ASC";		
		$stmt = Conexion::conectar()->prepare($sqlt);
		$stmt -> execute();
		if($stmt -> rowcount() > 0){
			$respuesta = '1';
			$registros = $stmt->fetchAll();	
			foreach ($registros as $key => $value){
				$idempresa = $value['id'];
				$iddepto = $value['iddepto'];
				$idciudad = $value['idciudad'];
				$empresa = $value['nombre'];
			}
	    return '
	    <script src="'.SERVERURL.'views/js/gestionFormaciones.03.js"></script>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Inicio</a></li>
		    <li class="breadcrumb-item"><a href="'.SERVERURL.'planeacion/">Planeación</a></li>
		    <li class="breadcrumb-item"><a href="'.SERVERURL.'planeacion/empresas/">Oferta Empresas</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Formaciones</li>
		  </ol>
		<blockquote class="blockquote">'.$empresa.'</blockquote>
	    <div class="d-flex p-2 bd-highlight">
	    
	    <button id="btnnficha" type="button" onClick="nuevaFicha(\''.$idempresa.'\',\''.$empresa.'\',\''.$iddepto.'\',\''.$idciudad.'\');" class="btn btn-success btn-block btn-lg"><span id="placebtnnficha">NUEVA FORMACIÓN</span></button>
	    
	    </div><script>listFormaciones('.$idempresa.');</script>';			
		}else{
			return 'Datos adulterados... ¡Ojo con eso!';
		}			
        $stmt -> closed(); 
		} 		
		public static function introduccionModel(){
			return ' ';//require_once("../complementaria/views/modulos/status.php");
		}
	  public static function errorModel(){
	    return ' 
	    <div class="jumbotron">
			  <h1 class="display-4">ERROR: 404</h1>
			  <p class="lead">Esta intentando ingresar a una pagina que no existe en nuestro universo ProyectosClub!</p>
			  <hr class="my-4">
			  <p>Utilice el menu de la izquierda para navegar en las opciones de la aplicación.</p>
			</div>';
		} 	
			
}