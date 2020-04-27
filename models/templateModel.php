<?php
require_once "conexion.php";
session_start();
class TemplateModel{
	  public static function menuUsuarioActivoModel(){ 
	    $instructor = '<nav class="cd-side-nav">
			<ul> 
				<li class="cd-label">COMERCIO Y TURISMO</li>';
			if(!isset($_SESSION['prc_nomuser'])){	
			$instructor .= 	'<span id="binicio"><a href="'.SERVERURL.'login/" class="label-menu"><button class="button btn btn-sm btn-primary">Iniciar Sesión</button></a></span>';
			}else{
			$v = new TemplateModel(); 
			$idcoordinacion = $_SESSION['prc_coordinacion'];		
			$vcoor = $v -> validarCoordinador($idcoordinacion);	
			$idcentro = $_SESSION['prc_centro'];
			$idusuario = $_SESSION['prc_idusuario'];
			$perfiles = $v -> validarPerfiles($idusuario, $idcentro, $idcoordinacion);
			$instructor .= 	'<span class="mx-auto" style="color:orange; bgcolor:gray;"><strong>'.$_SESSION['prc_nomuser'].'</strong></span>';
			$instructor .='<li class="has-children"> 
					<!--a class="label-menu"  href="'.SERVERURL.'inicio/">Inicio</a-->
				</li>
				<li id="programar" class="has-children bookmarks  active">';
			$instructor .= '<a class="label-menu" href="'.SERVERURL.'planeacion/">Planeación</a>
					<ul>
						<li><a class="label-menu" href="'.SERVERURL.'planeacion/empresas/">Oferta Empresas</a></li>
						<li><a class="label-menu" href="'.SERVERURL.'ofertaabierta/">Oferta Abierta</a></li>
						<li><a class="label-menu" href="'.SERVERURL.'planeacion/status/">Mi Programación</a></li>
						<li><a class="label-menu" href="'.SERVERURL.'planeacion/miplaneacion/">Mi Planeación</a></li>						 
						<li><a class="label-menu" href="'.SERVERURL.'planeacion/horarioinstructor/">Horario Titulada</a></li>						 
					</ul>
				</li>';	

			if($idusuario == $vcoor || $perfiles['coorautorizar'] == '1' || $perfiles['coorconsultar'] == '1'){
			$instructor .='<li id="coordinador" class="has-children bookmarks">
					<a class="label-menu" href="#">Coordinador</a>
					<ul>
						<li><a class="label-menu" href="'.SERVERURL.'autorizar/">Autorizar</a>
						</li>';
			if($perfiles['coorconsultar'] == '1'){
			$instructor .='<li><a class="label-menu" href="'.SERVERURL.'coorconsultar/">Consultar</a>
			               </li>';
					    }
			$instructor .='</ul>
				</li>';
			}

			if($perfiles['gestor'] == '1') {		
			    $instructor .='<li id="gtitulada" class="has-children bookmarks">
					<a class="label-menu" href="#">Titulada</a><ul>';					
					if($perfiles['gestor'] == '1'){		
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'proficha/">Programar Ficha</a></li>';
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'fichastitulada/">Fichas Titulada</a></li>';
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'competencias/">Competencias</a></li>';
					}			
			    $instructor .='</ul>
				    </li>';
			}

			if($perfiles['gescrear'] == '1' || $perfiles['gesprogramar'] == '1' || $perfiles['valonbase'] == '1'){		
			$instructor .='<li id="gfichas" class="has-children bookmarks">
					<a class="label-menu" href="#">Gestionar Ficha</a>
					<ul>';
					if($perfiles['gescrear'] == '1'){
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'publicarficha/">Publicar Ficha</a></li>';
					}
					if($perfiles['gesprogramar'] == '1'){
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'programar/">Programar Ficha</a></li>
						<li><a class="label-menu" href="'.SERVERURL.'gespendientes/">Pendientes Programar'. $v->pendientes().'</a></li>';
					}	
					if($perfiles['valradicado'] == '1'){
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'valradicado/">Validar Radicado</a></li>';
						 
					}					

			$instructor .='</ul>
				</li>';
			}
			if($perfiles['adminprogramas'] == '1' || $perfiles['adminconsulta'] == '1' || $perfiles['valcontactos'] == '1' || $perfiles['agentesgs'] == '1' || $perfiles['adminusuarios'] == '1' || $perfiles['prospectos'] == '1'){		
			    $instructor .='<li id="gadmin" class="has-children bookmarks">
					<a class="label-menu" href="#">Administración</a>
					<ul>';					
						if($perfiles['adminconsulta'] == '1'){		
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'adminconsulta/">Consultar Fichas</a></li>';
						}	
						if($perfiles['adminusuarios'] == '1'){		
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'adminusuarios/">Usuarios</a></li>';
						}										
						if($perfiles['adminprogramas'] == '1'){		
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'programas/">Programas de Formación</a></li>';
						}
						if($perfiles['valcontactos'] == '1'){		
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'valcontactos/">Validar Contactos</a></li>';
						}	
						if($perfiles['prospectos'] == '1'){		
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'prospectos/"><span style="color:violet;">Prospectos</span></a></li>';
						}					
						if($perfiles['agentesgs'] == '1'){		
						$instructor .='<li><a class="label-menu" href="'.SERVERURL.'agentesgs/">Agente SGS'. $v->pendientessgs().'</a></li>';
						}							
			$instructor .='</ul>
				</li>';
			}	
			if($perfiles['bitacoras'] == '1'){	
			$instructor .= 	'
				<li id="reportes" class="has-children">
					<a class="label-menu" href="#0">Reportes</a>
					<ul>';

					if($perfiles['bitacoras'] == '1'){
						if($perfiles['bitacoras'] == '1'){
						  $instructor .='<li><a class="label-menu" href="'.SERVERURL.'bitacoras/">Bitacoras</a>
						               </li>';
								    }
							$instructor .='</ul>
						</li>';
					}
				}
			$instructor .= 	'
				<li id="usuarios" class="has-children users">
					<a class="label-menu" href="#0">Usuarios</a>
					<ul>';		
					if($perfiles['usuarionuevo'] == '1'){
					   $instructor .= 	' <li><a class="label-menu" href="'.SERVERURL.'usuarios/">Nuevo Usuario</a></li>';
					}    
					$instructor .= 	'    <!--li><a class="label-menu" href="'.SERVERURL.'perfil/">Perfil Usuario</a></li-->'; 
					$instructor .= 	'<li><a class="label-menu" href="'.SERVERURL.'salir/"><i class="fa fa-power-off" aria-hidden="true"></i> Salir </a></li>';
					  }
					$instructor .= 	'</ul>
				</li>
			</ul>
<!---->
		</nav>';
	    return $instructor;
		}

public function pendientessgs(){
	$cantidad = 0;
	if(isset($_SESSION['prc_ciuser'])){
	    $coordinacion = $_SESSION['prc_coordinacion'];
	    $ccentro = $_SESSION['prc_centro'];
	    $perfil = $_SESSION['prc_perfil']; 
	    $idusuario = $_SESSION['prc_idusuario'];
	    $sqlt = $sqlt = "SELECT count(fc.id) AS cantidad FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN empresas em ON fc.idempresa = em.id  INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id INNER JOIN reservaregistro rg ON rg.idregistro = fc.id WHERE rg.centro = '$ccentro' AND rg.pendiente = '1' AND rg.sgs = '0' AND fc.estado = '5' AND fc.historico = '0' ORDER BY fc.id DESC";
	    $stmt = Conexion::conectar()->prepare($sqlt);
	    $stmt -> execute(); 
	    $registros = $stmt->fetchAll();
		if(!empty($registros)) {
		    foreach ($registros as $key => $value){
		        $cantidad = $value['cantidad'];
		        }	    
			} 
	     }
	   if($cantidad > 0 ){
	   			$salida = '&nbsp; <span class="badge badge-warning">'.$cantidad.'</span>';
	   }else{
	   		$salida = '';
	   }
	   return $salida;
 }  
 
public function pendientes(){
	$cantidad = 0;
	if(isset($_SESSION['prc_ciuser'])){
	    $coordinacion = $_SESSION['prc_coordinacion'];
	    $centro = $_SESSION['prc_centro'];
	    $perfil = $_SESSION['prc_perfil']; 
	    $idusuario = $_SESSION['prc_idusuario'];
	    $sqlt = $sqlt = "SELECT count(fc.id) AS cantidad FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id INNER JOIN reservaregistro rg ON rg.idregistro = fc.id WHERE rg.idusuario = '$idusuario' AND rg.pendiente = '1' AND fc.estado = '5' AND fc.historico = '0' ORDER BY fc.id DESC";
	    $stmt = Conexion::conectar()->prepare($sqlt);
	    $stmt -> execute(); 
	    $registros = $stmt->fetchAll();
		if(!empty($registros)) {
		    foreach ($registros as $key => $value){
		        $cantidad = $value['cantidad'];
		        }	    
		} 
   }
   if($cantidad > 0 ){
   	$salida = '&nbsp; <span class="badge badge-warning">'.$cantidad.'</span>';
   }else{
   	$salida = '';
   }
   return $salida;
 }  

public function validarCoordinador($idcoordinacion){
	$coordinador = '0';
	  $sqlt = "SELECT coordinador  FROM coordinaciones WHERE id = '$idcoordinacion' AND estado = '1';";
	  $stmt = Conexion::conectar()->prepare($sqlt);
	  $stmt -> execute();
	  if($stmt -> rowcount() > 0){
	    $registros = $stmt->fetchAll();  
	    foreach ($registros as $key => $value) {
	        $coordinador = $value['coordinador']; 
	        }
	     } 
	  return $coordinador; 	
	}

public function validarPerfiles($idusuario, $idcentro, $idcoordinacion){
	$coordinador = '0';
	  $sqlt = "SELECT misempresas, coorautorizar, coorconsultar, gescrear, gestor, prospectos, gesprogramar, adminprogramas, usuarionuevo, adminconsulta, adminusuarios, valradicado, valcontactos, agentesgs, bitacoras  FROM perfiles WHERE idusuario = '$idusuario' AND idcentro = '$idcentro' AND coordinacion = '$idcoordinacion' AND  estado = '1';";
		  $stmt = Conexion::conectar()->prepare($sqlt);
		  $stmt -> execute();
		  if($stmt -> rowcount() > 0){
		    $registros = $stmt->fetchAll();  
		    foreach ($registros as $key => $value) {
				$misempresas = $value['misempresas'];
				$coorautorizar = $value['coorautorizar'];
				$coorconsultar = $value['coorconsultar'];
				$valradicado = $value['valradicado'];
				$prospectos = $value['prospectos'];
				$gescrear = $value['gescrear'];
				$gesprogramar = $value['gesprogramar'];
				$adminprogramas = $value['adminprogramas'];
				$adminusuarios = $value['adminusuarios'];
				$usuarionuevo = $value['usuarionuevo'];
				$adminconsulta = $value['adminconsulta'];
				$valcontactos = $value['valcontactos'];
				$gestor = $value['gestor'];
				$agentesgs = $value['agentesgs'];
				$bitacoras = $value['bitacoras'];
				$datos = [
			 	    'estado' => '1',
					'misempresas' => $misempresas,
					'coorautorizar' => $coorautorizar,
					'coorconsultar' => $coorconsultar,
					'valradicado' => $valradicado,
					'prospectos' => $prospectos,
					'gescrear' => $gescrear,
					'gesprogramar' => $gesprogramar,
					'adminprogramas' => $adminprogramas,
					'adminusuarios' => $adminusuarios,
					'adminconsulta' => $adminconsulta,
					'valcontactos' => $valcontactos,
					'gestor' => $gestor,
					'agentesgs' => $agentesgs,
					'bitacoras' => $bitacoras,
					'usuarionuevo' => $usuarionuevo
	            ]; 
	       }
     }else{
     	$datos = [
				'estado' => '0',
				'misempresas' => '0',
				'coorautorizar' => '0',
				'coorconsultar' => '0',
				'gescrear' => '0',
				'gesprogramar' => '0',
				'adminprogramas' => '0',
				'valcontactos' => '0',
				'prospectos' => '0',
				'gestor' => '0',
				'valonbase' => '0',
				'usuarionuevo' => '0',
				'adminusuarios' => '0',
				'adminconsulta' => '0',
				'bitacoras' => '0',
				'agentesgs' => '0'
			 ];
	     }
	  return $datos; 	
	}
}

 