<?php
require_once "conexion.php";
include_once "../../routes/config.php";
date_default_timezone_set('America/Bogota'); 
session_start();
$fecha = date("Y-m-d");
$hora = date('H:i:s');

class ProgramasModel{

 public function __construct() {
	//require_once "conexion.php";
}
 public function decode_entities($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string 
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string 
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string 
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string 
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string 
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string 
    );
 
$string = str_replace(
	array('&nbsp;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&sup1;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&AACUTE;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&EACUTE;','&Ecirc;','&Euml;','&Igrave;','&IACUTE;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&OACUTE;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&UACUTE;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&quot;','&amp;','&lt;','&gt;','&OElig;','&oelig;','&Scaron;','&scaron;','&Yuml;','&circ;','&tilde;','&ensp;','&emsp;','&thinsp;','&zwnj;','&zwj;','&lrm;','&rlm;','&ndash;','&mdash;','&lsquo;','&rsquo;','&sbquo;','&ldquo;','&rdquo;','&bdquo;','&dagger;','&Dagger;','&permil;','&lsaquo;','&rsaquo;','&euro;','&fnof;','&Alpha;','&Beta;','&Gamma;','&Delta;','&Epsilon;','&Zeta;','&Eta;','&Theta;','&Iota;','&Kappa;','&Lambda;','&Mu;','&Nu;','&Xi;','&Omicron;','&Pi;','&Rho;','&Sigma;','&Tau;','&Upsilon;','&Phi;','&Chi;','&Psi;','&Omega;','&alpha;','&beta;','&gamma;','&delta;','&epsilon;','&zeta;','&eta;','&theta;','&iota;','&kappa;','&lambda;','&mu;','&nu;','&xi;','&omicron;','&pi;','&rho;','&sigmaf;','&sigma;','&tau;','&upsilon;','&phi;','&chi;','&psi;','&omega;','&thetasym;','&upsih;','&piv;','&bull;','&hellip;','&prime;','&Prime;','&oline;','&frasl;','&weierp;','&image;','&real;','&trade;','&alefsym;','&larr;','&uarr;','&rarr;','&darr;','&harr;','&crarr;','&lArr;','&uArr;','&rArr;','&dArr;','&hArr;','&forall;','&part;','&exist;','&empty;','&nabla;','&isin;','&notin;','&ni;','&prod;','&sum;','&minus;','&lowast;','&radic;','&prop;','&infin;','&ang;','&and;','&or;','&cap;','&cup;','&int;','&there4;','&sim;','&cong;','&asymp;','&ne;','&equiv;','&le;','&ge;','&sub;','&sup;','&nsub;','&sube;','&supe;','&oplus;','&otimes;','&perp;','&sdot;','&lceil;','&rceil;','&lfloor;','&rfloor;','&lang;','&rang;','&loz;','&spades;','&clubs;','&hearts;','&diams;'),
  array('&#160;','&#161;','&#162;','&#163;','&#164;','&#165;','&#166;','&#167;','&#168;','&#169;','&#170;','&#171;','&#172;','&#173;','&#174;','&#175;','&#176;','&#177;','&#178;','&#179;','&#180;','&#181;','&#182;','&#183;','&#184;','&#185;','&#186;','&#187;','&#188;','&#189;','&#190;','&#191;','&#192;','&#193;','&#194;','&#195;','&#196;','&#197;','&#198;','&#199;','&#200;','&#201;','&#202;','&#203;','&#204;','&#205;','&#206;','&#207;','&#208;','&#209;','&#210;','&#211;','&#212;','&#213;','&#214;','&#215;','&#216;','&#217;','&#218;','&#219;','&#220;','&#221;','&#222;','&#223;','&#224;','&#225;','&#226;','&#227;','&#228;','&#229;','&#230;','&#231;','&#232;','&#233;','&#234;','&#235;','&#236;','&#237;','&#238;','&#239;','&#240;','&#241;','&#242;','&#243;','&#244;','&#245;','&#246;','&#247;','&#248;','&#249;','&#250;','&#251;','&#252;','&#253;','&#254;','&#255;','&#34;','&#38;','&#60;','&#62;','&#338;','&#339;','&#352;','&#353;','&#376;','&#710;','&#732;','&#8194;','&#8195;','&#8201;','&#8204;','&#8205;','&#8206;','&#8207;','&#8211;','&#8212;','&#8216;','&#8217;','&#8218;','&#8220;','&#8221;','&#8222;','&#8224;','&#8225;','&#8240;','&#8249;','&#8250;','&#8364;','&#402;','&#913;','&#914;','&#915;','&#916;','&#917;','&#918;','&#919;','&#920;','&#921;','&#922;','&#923;','&#924;','&#925;','&#926;','&#927;','&#928;','&#929;','&#931;','&#932;','&#933;','&#934;','&#935;','&#936;','&#937;','&#945;','&#946;','&#947;','&#948;','&#949;','&#950;','&#951;','&#952;','&#953;','&#954;','&#955;','&#956;','&#957;','&#958;','&#959;','&#960;','&#961;','&#962;','&#963;','&#964;','&#965;','&#966;','&#967;','&#968;','&#969;','&#977;','&#978;','&#982;','&#8226;','&#8230;','&#8242;','&#8243;','&#8254;','&#8260;','&#8472;','&#8465;','&#8476;','&#8482;','&#8501;','&#8592;','&#8593;','&#8594;','&#8595;','&#8596;','&#8629;','&#8656;','&#8657;','&#8658;','&#8659;','&#8660;','&#8704;','&#8706;','&#8707;','&#8709;','&#8711;','&#8712;','&#8713;','&#8715;','&#8719;','&#8721;','&#8722;','&#8727;','&#8730;','&#8733;','&#8734;','&#8736;','&#8743;','&#8744;','&#8745;','&#8746;','&#8747;','&#8756;','&#8764;','&#8773;','&#8776;','&#8800;','&#8801;','&#8804;','&#8805;','&#8834;','&#8835;','&#8836;','&#8838;','&#8839;','&#8853;','&#8855;','&#8869;','&#8901;','&#8968;','&#8969;','&#8970;','&#8971;','&#9001;','&#9002;','&#9674;','&#9824;','&#9827;','&#9829;','&#9830;'),
  	$string 
  );
    

    //Esta parte se encarga de eliminar cualquier caracter extraño
    return $string;
} 






 public function validarPrograma($codigo){
   $lista = '';
   $respuesta = '1';
   $f = new ProgramasModel();
	if(isset($_SESSION['prc_idusuario'])){ 
	   $centro = $_SESSION['prc_centro'];   
	   $sqlt = "SELECT id, codigo, version, nombre, estado, horas FROM formaciones WHERE codigo = '$codigo' AND centro = '$centro';";
	   $stmt = Conexion::conectar()->prepare($sqlt);
     $stmt -> execute();
	if($stmt->rowCount() > 0){
			$respuesta = '1';
			$registros = $stmt->fetchAll();	
			foreach ($registros as $key => $value) {
				$idcurso = $value['id'];
				$codigo = $value['codigo'];
				$nombre =  $value['nombre'];
				$nombre = html_entity_decode($nombre);
				$version = $value['version'];				
				$horas = $value['horas'];
				$estado = $value['estado'];	
				  $newdata =  array (
						'respuesta' => $respuesta,
						'id'=> $idcurso,
						'codigo' => $codigo,			
						'nombre' => $nombre,
						'version' => $version,
						'horas' => $horas,
						'estado' => $estado 
			        );
			  }
		    }else{
				$newdata =  array (
				  'respuesta' => '0' 
		        );
		    }    
    }else{
		$newdata =  array (
		  'respuesta' => '5' 
        );    	
    }  
	$arrDatos[] = $newdata;   
	echo json_encode($arrDatos);
   }
public static function updatePrograma($datos){
	date_default_timezone_set('America/Bogota'); 
	$fecha = date("Y-m-d");
	$hora = date('H:i:s');		
	if(isset($_SESSION['prc_idusuario'])){ 
	   $centro = $_SESSION['prc_centro'];   	
		$id = $datos['id'];
		$idespecialidad = $datos['idespecialidad'];
		$codigo = $datos['codigo'];
		$version = $datos['version'];
		$horas = $datos['horas'];
		$nombre = $datos['nombre']; 
		$estado =  $datos['estado'];
		$nivel = $datos['nivel']; 
		$modalidad =  $datos['modalidad'];	

		if($id == '0'){
			$sqlt = "INSERT INTO formaciones (centro, codigo, idespecialidad, nivel, modalidad, version, nombre, horas, tipo, fecha, hora, estado) VALUES ('$centro','$codigo','$idespecialidad','$nivel','$modalidad','$version','$nombre','$horas','NUEVO','$fecha','$hora','$estado')";
		}else{
			$sqlt = "UPDATE formaciones SET codigo = '$codigo', idespecialidad = '$idespecialidad', nivel = '$nivel', modalidad = '$modalidad', version = '$version' , nombre = '$nombre', horas = '$horas', estado = '$estado' WHERE id = '$id';";
		}
			$stmt = Conexion::conectar()->prepare($sqlt);
			if($stmt -> execute()){
				$respuesta = '1';
			}
		}
        $newdata =  array (
		  'respuesta' => $respuesta,
		  'sqlt' => $sqlt,
		  'ruta' => SERVERURL.'programas/'
        );   
	$arrDatos[] = $newdata;   
	echo json_encode($arrDatos);
		//$stmt -> Conexion::close();	 
}
 public function traerPrograma($id){
   $lista = '';
   $respuesta = '1';
   $f = new ProgramasModel();
	if(isset($_SESSION['prc_idusuario'])){ 
	   $centro = $_SESSION['prc_centro'];   
	   $sqlt = "SELECT id, codigo, version, nombre, estado, horas, idespecialidad, nivel, modalidad FROM formaciones WHERE id = '$id';";
	   $stmt = Conexion::conectar()->prepare($sqlt);
     $stmt -> execute();
	if($stmt->rowCount() > 0){
			$respuesta = '1';
			$registros = $stmt->fetchAll();	
			foreach ($registros as $key => $value) {
				$idcurso = $value['id'];
				$codigo = $value['codigo'];
				$nombre = html_entity_decode($value['nombre']);
				$version = $value['version'];
				$idespecialidad = $value['idespecialidad'];				
				$horas = $value['horas'];
				$estado = $value['estado'];	
				$nivel = $value['nivel'];
				$modalidad = $value['modalidad'];					
				  $newdata =  array (
						'respuesta' => $respuesta,
						'idcurso'=>$id,
						'codigo' => $codigo,			
						'nombre' => $nombre,
						'version' => $version,
						'nivel' => $nivel,
						'modalidad' => $modalidad,						
						'idespecialidad' => $idespecialidad,
						'horas' => $horas,
						'estado' => $estado 
			        );
			  }
		    }else{
				$newdata =  array (
				  'respuesta' => '0' 
		        );
		    }    
    }else{
		$newdata =  array (
		  'respuesta' => '5' 
        );    	
    }  
	$arrDatos[] = $newdata;   
	echo json_encode($arrDatos);
   }
public static function tablaProgramas(){
  $tabla = '';
  $opciones = '';
  if(isset($_SESSION['prc_idusuario'])){ 
  $centro = $_SESSION['prc_centro'];
   $sqlt = "SELECT pr.id, pr.codigo, pr.version, pr.nombre, pr.estado, pr.horas, ep.nombre nespecialidad, pr.nivel, pr.modalidad FROM formaciones pr INNER JOIN  especialidad ep ON pr.idespecialidad = ep.id WHERE pr.centro = '$centro' ORDER BY pr.nombre ASC";
  $stmt = Conexion::conectar()->prepare($sqlt);
  $stmt -> execute();
  if($stmt->rowCount() > 0){
    $respuesta = '1';
    $registros = $stmt->fetchAll(); 
    foreach ($registros as $key => $value) {
      $id = $value['id'];
      $nombre = html_entity_decode(strtolower($value['nombre']));
      $nombre = ucwords($nombre);     
      $codigo = $value['codigo'];
      $version = $value['version'];
      $nivel = $value['nivel'];
      $modalidad = $value['modalidad'];      
      $horas = $value['horas'];
      $nespecialidad = html_entity_decode(strtolower($value['nespecialidad']));
      $nespecialidad = ucwords($nespecialidad); 
      $estado = $value['estado'];


				switch ($nivel) {
						case '0':
						$lnivel = 'Complementaria';
						break;
						case '1':
						$lnivel = 'Operario';
						break;						
						case '2':
						$lnivel = 'Auxiliar';
						break;
						case '3':						
						$lnivel = 'Técnico';
						break;
						case '4':
						$lnivel = 'Tecnologo';
						break;
						case '5':
						$lnivel = 'Especialización';
						break;
					default:
						$lnivel = 'Error';
						break;
				}

				switch ($modalidad){
						case '0':
						$lmodalidad = 'Presencial';
						break;
						case '1':
						$lmodalidad = 'Virtual';
						break;						
						case '2':
						$lmodalidad = 'Distancia';
						break;
						case '3':						
						$lmodalidad = 'Mixta';
						break;
					}



      if($estado == '1'){
        $sestado = 'btn-success';
        $testado = '<span style=\"color:green;\">Ejecucion</span>';
        $iestado = '<i class=\"fas fa-lock-open\"></i>';
      }else{
        $sestado = 'btn-danger';
        $testado = '<span style=\"color:orange;\">No Disponible</span>';
        $iestado = '<i class=\"fas fa-lock\"></i>';
      }
      $acciones ='<button type=\"button\" id=\"btneditar'.$id.'\" onClick=\"editarPrograma(\''.$id.'\');\" class=\"btn btn-info btn-sm\"><i class=\"far fa-edit\"></i></button>';
      $tabla .= '{"codigo":"'.$codigo.'","nombre":"'.$nombre.'","version":"'.$version.'","nespecialidad":"'.$nespecialidad.'","horas":"'.$horas.'","estado":"'.$testado.'","nivel":"'.$lnivel.'","modalidad":"'.$lmodalidad.'","acciones":"'.$acciones.'"},';
    } 
   } 
  $tabla = substr($tabla,0, strlen($tabla) - 1);
  } 
 return '{"data":['.$tabla.']}';      
}


public function verProgramas(){
	$tabla = '';
	if(isset($_SESSION['prc_idusuario'])){ 
	   $centro = $_SESSION['prc_centro'];
	   $sqlt = "SELECT id, codigo, version, nombre, estado, horas, nivel, modalidad FROM formaciones WHERE centro = '$centro' ORDER BY nombre ASC";
	   $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
	if($stmt->rowCount() > 0){
			$respuesta = '1';
			$registros = $stmt->fetchAll();	
			foreach ($registros as $key => $value) {
				$idcurso = $value['id'];
				$codigo = $value['codigo'];
				$nombre = $value['nombre'];
				$version = $value['version'];				
				$horas = $value['horas'];
				$nivel = $value['nivel'];				
				$modalidad = $value['modalidad'];				
				$estado = $value['estado'];	
				if($estado == '1'){
					$estado = 'Ejecución';
				}


				$seleccionar = '<button  type=\"button\" class=\"btn btn-outline-success\"><i class=\"fas fa-check\"></i></button>';   
				$tabla .='{"codigo":"'.$codigo.'","nombre":"'.$nombre.'","version":"'.$version.'","horas":"'.$horas.'","estado":"'.$estado.'","acciones":"'.$seleccionar.'"},';	
				}	
			} 
		}
		$tabla = substr($tabla,0,strlen($tabla) - 1); 
		return '{"data":['.$tabla.']}';		   
}

public static function traerlespecialidad(){
    $respuesta = '1';
    $lista = '';
	if(isset($_SESSION['prc_idusuario'])){   
	   $sqlt = "SELECT id, nombre, label FROM especialidad WHERE estado = '1'";
	   $stmt = Conexion::conectar()->prepare($sqlt);
     $stmt -> execute();
		if($stmt->rowCount() > 0){
				$respuesta = '1';
				$registros = $stmt->fetchAll();	
				foreach ($registros as $key => $value) {
					$id = $value['id'];
					$nombre = html_entity_decode($value['nombre']);
					$label = html_entity_decode($value['label']);				
					$lista .= '<option value="'.$id.'">'.$nombre.'</option>'; 
				  }
			    }else{
			      $respuesta = '0';
		    }    
	}else{
         $respuesta = '5';   	
	} 
		$newdata =  array (
		'respuesta' => $respuesta,
		'datos' => $lista 
		); 
	$arrDatos[] = $newdata;  

	return json_encode($arrDatos);   
}


	public function __destruct(){
		   //$stmt -> Conexion::close();
	}
}

