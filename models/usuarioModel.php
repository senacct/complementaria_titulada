<?php
require_once "conexion.php";
date_default_timezone_set('America/Bogota'); 

if(!isset($_SESSION)){
    session_start();
}
$fecha = date("Y-m-d");
$hora = date('H:i:s');
class GestionUsuarioModel{
  public static function templateIngresoModel(){
  $html = '
    <script src="'.SERVERURL.'views/js/gestionUsuarios.03.js"></script>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Iniciar Sesión</li>
    </ol>'; 
  $html .='<div class="container" >';
  $html .='<div class="row p-3 mt-n1">';
  $html .='<div class="col-sm-12 ">';
  $html .='<div class="card mx-auto" style="width: 100%;">';
  $html .='<div class="card-body">';
  $html .='<form>';
  $html .='<div class="form-group">';
  $html .='  <label for="correo">Usuario</label>';
  $html .='  <input type="email" class="form-control" id="correo" ';
  $html .='  aria-describedby="emailHelp" placeholder="Enter email">';
  $html .='  <small id="emailHelp" class="form-text text-muted">El usuario es su correo SENA</small>';
  $html .='</div>';
  $html .='<div class="form-group">';
  $html .='  <label for="contrasena">Password</label>';
  $html .='  <input type="password" class="form-control" id="contrasena" placeholder="Password">';
  $html .='</div>';
  $html .='<div class="form-group form-check">';
  $html .='  <input type="checkbox" class="form-check-input" id="exampleCheck1">';
  $html .='  <label class="form-check-label" for="exampleCheck1">Recordarme Aquí</label>';
  $html .='</div>';
  $html .='<button type="button" onClick="ingresousuario();" class="btn btn-sm btn-primary">Ingresar &nbsp; <i class="fas fa-sign-in-alt"></i></button>';
  $html .='</form>';
  $html .='  </div>';
  $html .='</div>';
  $html .='  </div>';
  $html .='</div>';  
  $html .='</div>';   
  echo $html;
  }

  public static function ingresoUsuario($datos){
  include_once "../../routes/config.php";
  $ruta = SERVERURL;  
  date_default_timezone_set('America/Bogota'); 
  $coordinacion = '';  
  $us = $datos['correo'];
  $ps = $datos['contrasena'];
  $fecha = date("Y-m-d");
  $hora = date('H:i:s');
  try{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
      {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
      }
      elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
      {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
      }
      else
      {
        $ip=$_SERVER['REMOTE_ADDR'];
      }
      $reestablecer = '0';
      $estado = '-1';
      $sqlt1 = "SELECT id, identificador, estado, reestablecer, nombre, correosena, telefono, correootro, perfil, idcoordinacion FROM usuarios WHERE correosena = LOWER('$us') AND contrasena = '$ps'";
      $stmt = Conexion::conectar()->prepare($sqlt1);
      $stmt -> execute();
      $registros = $stmt->fetchAll(); 
      if($stmt -> rowcount() > 0){
        $formacion = new GestionUsuarioModel(); 
        $respuesta = '1';
        $nombre = '';
        $correo = '';
          foreach ($registros as $key => $value) { 
            $estadousuario = $value['estado']; 
            $reestablecer = $value['reestablecer'];            
            $identificador = $value['identificador'];  
            $nombre = $value['correosena'];
            $correo = $value['nombre'];             
            if($estadousuario == '1'){  
                $_SESSION['prc_ciuser'] = trim($value['identificador']);   
                $_SESSION['prc_correootro'] = $value['correootro'];
                $_SESSION['prc_correo'] = $value['correosena'];
                $_SESSION['prc_nomuser'] = $value['nombre'];
                $_SESSION['prc_estado'] = $value['estado'];
                $_SESSION['prc_telefono'] = $value['telefono'];
                $_SESSION['prc_perfil'] = $value['perfil'];
                $_SESSION['prc_idusuario'] = $value['id'];    
                $datos = $formacion -> usuariocentro($_SESSION['prc_idusuario']);
                if($datos[0]['centro'] !== '0'){
                    $_SESSION['prc_centro'] = $datos[0]['centro'];
                    $_SESSION['prc_coordinacion'] = $datos[0]['coordinacion'];
                    $coordinacion = $_SESSION['prc_coordinacion'];
                    $estado = $datos[0]['estado'];
                  }
             } 
            }
     
              $sqlt = "INSERT INTO historico (usuario, categoria, evento, fecha, hora, ip, valortexto) VALUES('$identificador','Sesion', 'Inicio Sesion','$fecha', '$hora', '$ip','$coordinacion' );";
              $stmt = Conexion::conectar()->prepare($sqlt);
              $stmt -> execute();
            } else{
              $sqlt = "INSERT INTO historico (usuario, categoria, evento, fecha, hora, ip, valortexto) VALUES('$us', 'Sesion','Inicio fallido','$fecha', '$hora', '$ip','$coordinacion');";
              $stmt = Conexion::conectar()->prepare($sqlt);
              $stmt -> execute();

            }
    } catch (Exception $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
                  $newdata =  array (
                     'respuesta' => '1',
                     'estado' => $estado,
                     'reestablecer' => $reestablecer,
                     'ruta' => $ruta
                );    
  $arrDatos[] = $newdata;   
  echo json_encode($arrDatos);   
  }
 public static function validarcoredit($datos){
   $lista = '';
   $respuesta = '1';
    $correosena = strtolower($datos['correosena']);
    $id = $datos['id'];
  if(isset($_SESSION['prc_idusuario'])){ 
     $centro = $_SESSION['prc_centro'];   
     $sqlt = "SELECT correosena FROM usuarios WHERE correosena = '$correosena' AND id <> '$id';";
     $stmt = Conexion::conectar()->prepare($sqlt);
     $stmt -> execute();
     if($stmt->rowCount() > 0){
          $newdata =  array (
          'respuesta' => '1' 
         );
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
 public static function validarCorreosena($correosena){
   $lista = '';
   $respuesta = '1';
  if(isset($_SESSION['prc_idusuario'])){ 
     $centro = $_SESSION['prc_centro'];   
     $sqlt = "SELECT correosena FROM usuarios WHERE correosena = '$correosena';";
     $stmt = Conexion::conectar()->prepare($sqlt);
     $stmt -> execute();
     if($stmt->rowCount() > 0){
          $newdata =  array (
          'respuesta' => '1' 
         );
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

 public static function traerEditar($id){
 $lista = '';
 $respuesta = '1';
  if(isset($_SESSION['prc_idusuario'])){ 
     $centro = $_SESSION['prc_centro'];   
     $sqlt = "SELECT correosena, correootro, nombre, telefono, vinculacion, instructor, idcoordinacion FROM usuarios WHERE id = '$id';";
     $stmt = Conexion::conectar()->prepare($sqlt);
      $stmt -> execute();
      if($stmt -> rowcount() > 0){
        $respuesta = '1';
        $registros = $stmt->fetchAll();  
        foreach ($registros as $key => $value) {
            $correosena = $value['correosena'];
            $correootro = $value['correootro'];
            $vinculacion = $value['vinculacion'];
            $instructor = $value['instructor'];
            $nombre = html_entity_decode(strtolower($value['nombre']));
            $nombre = ucwords($nombre);
            $telefono = $value['telefono'];
            $idcoordinacion = $value['idcoordinacion'];
             $newdata =  array (
                'respuesta' => $respuesta,
                'correosena'=>$correosena, 
                'correootro'=>$correootro,
                'vinculacion'=>$vinculacion, 
                'instructor'=>$instructor,                
                'nombre'=>$nombre,
                'telefono'=>$telefono,
                'idcoordinacion'=>$idcoordinacion,
                'sqlt'=>$sqlt
             );  
            }
         }else{
           $newdata =  array (
              'respuesta' => '0'
           );    
      }   
      $arrDatos[] = $newdata;   
      return json_encode($arrDatos); 
  }
}

public static function cerrarUsuario(){
include_once "../../routes/config.php"; 
  $fecha = date("Y-m-d");
  $hora = date('H:i:s');
$ruta = SERVERURL;
if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
 if(isset($_SESSION['prc_ciuser'])){   
    $usuario = $_SESSION['prc_ciuser'];
    $sqlt = "INSERT INTO historico (usuario, categoria, evento,  fecha, hora, ip) VALUES('$usuario','Sesion', 'Cerrar Sesion', '$fecha', '$hora', '$ip' );";
    $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
  }
    $_SESSION = array();
    session_destroy();
    $newdata =  array (
         'respuesta' => '1',
         'ruta' => $ruta
    );  
  $arrDatos[] = $newdata;   
  echo json_encode($arrDatos);
 }  

public static function nuevaContrasena($id){
include_once "../../routes/config.php";
$ruta = SERVERURL; 
$str = "ABCDEFGHIJKLMNPQRSTUVWXYZ";
$num = "123456789";
$newpass = "";
  for($j=0;$j<2;$j++) {
    $newpass .= substr($str,rand(0,24),1); 
    }
  for($j=0;$j<5;$j++) {
    $newpass .= substr($num,rand(0,9),1);
    }
  $sqlt = "UPDATE usuarios SET contrasena = '$newpass' WHERE id = '$id'";
      $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
  if($stmt->rowCount() > 0){
      $respuesta = '1'; 
        } else{
        $respuesta = '0';
      }  
  $newdata =  array (
  'respuesta' => $respuesta,
  'ruta' => $sqlt,
  'newpass' => $newpass
  );
  $arrDatos[] = $newdata;  
  echo json_encode($arrDatos);
 }


public static function usuariocentro($idusuario){
  $sqlt = "SELECT centro, coordinacion, estado  FROM usuariocentro WHERE idusuario = '$idusuario' AND estado = '1';";
  $stmt = Conexion::conectar()->prepare($sqlt);
  $stmt -> execute();
  if($stmt -> rowcount() > 0){
    $registros = $stmt->fetchAll();  
    foreach ($registros as $key => $value) {
        $centro = $value['centro'];
        $coordinacion = $value['coordinacion'];
        $estado = $value['estado'];
         $newdata =  array (
            'centro' => $centro,
            'coordinacion'=>$coordinacion,
            'estado'=>$estado 
         );  
        }
     }else{
       $newdata =  array (
          'centro' => '0'
       );    
  }   
  $arrDatos[] = $newdata;   
  return $arrDatos; 
  }

public static function crearusuario($datos){
  include_once "../../routes/config.php";
  $ruta = SERVERURL; 
    date_default_timezone_set('America/Bogota'); 
    $fecha = date("Y-m-d");
    $hora = date('H:i:s');    
    $vinculacion = $datos['vinculacion'];
    $instructor = $datos['instructor'];
    $nombre = $datos['nombre'];
    $correosena = strtolower($datos['correosena']);
    $correootro = strtolower($datos['correootro']);
    $telefono = htmlentities($datos['telefono']);
    if(isset($_SESSION['prc_idusuario'])){  
        $ip = $_SERVER["REMOTE_ADDR"]; 
        $centro = $_SESSION['prc_centro'];    
        $coordinacion = $_SESSION['prc_coordinacion'];
        $usuario =  $_SESSION['prc_ciuser'];
        $idusuario =  $_SESSION['prc_idusuario'];
          $str = "ABCDEFGHIJKLMNPQRSTUVWXYZ";
          $num = "123456789";
          $cad = "";
          $resultado = 1;
          while($resultado > 0){
             $cad = "";
            for($j=0;$j<2;$j++) {
              $cad .= substr($str,rand(0,24),1); 
              }
            for($j=0;$j<5;$j++) {
              $cad .= substr($num,rand(0,9),1);
              }
              $sqlt = "SELECT COUNT(*) as cuantos FROM usuarios WHERE identificador = '$cad'";
              $stmt = Conexion::conectar()->prepare($sqlt);
              if($stmt -> execute()){
                $registros = $stmt->fetchAll(); 
                  foreach ($registros as $key => $value){
                    $resultado = $value['cuantos'];
                   } 
                }else{
                    $resultado = 0;
              }  
          }
        $identificador = $cad;      
        $sqlt = "INSERT INTO usuarios (idcentro, idcoordinacion, vinculacion, instructor, nombre, correosena, correootro, telefono, contrasena, identificador, estado, bloqueado, fecha, hora, ip) VALUES ('$centro','$coordinacion','$vinculacion','$instructor','$nombre','$correosena','$correootro','$telefono','$identificador', '$identificador','1','1','$fecha','$hora','$ip');";
          $stmt = Conexion::conectar()->prepare($sqlt);
          if($stmt -> execute()){
            $sqlt = "SELECT id FROM usuarios WHERE identificador = '$cad'";
            $stmt = Conexion::conectar()->prepare($sqlt);
           if($stmt -> execute()){
            $registros = $stmt->fetchAll(); 
            foreach ($registros as $key => $value){
              $id = $value['id'];
            }
                $sqlt = "INSERT INTO perfiles (idusuario, idcentro, coordinacion, estado) VALUES ('$id','$centro','$coordinacion', '1') ON DUPLICATE KEY UPDATE coordinacion = '$coordinacion', estado = '1'";
                 $stmt = Conexion::conectar()->prepare($sqlt);
                 $stmt -> execute();

                $sqlt = "INSERT INTO usuariocentro (idusuario, centro, coordinacion, ip, invita, estado) VALUES ('$id','$centro','$coordinacion', '$ip','$idusuario','1') ON DUPLICATE KEY UPDATE estado = '1'";
                 $stmt = Conexion::conectar()->prepare($sqlt);
                 $stmt -> execute();
           }
      }
      $notificar = new GestionUsuarioModel();
      $notificar ->  notificarusuario($id);
    }

$ruta = SERVERURL."usuarios/";
$newdata =  array (
          'respuesta' => '1',
          'ruta' => $ruta
       );   
 $arrDatos[] = $newdata;   
  return json_encode($arrDatos);
} 

public static function updateusuario($datos){
  include_once "../../routes/config.php";
    $ruta = SERVERURL;    
    date_default_timezone_set('America/Bogota'); 
    $fecha = date("Y-m-d");
    $hora = date('H:i:s'); 
    $vinculacion = $datos['vinculacion'];
    $instructor = $datos['instructor'];
    $id = $datos['id'];
    $nombre = $datos['nombre'];
    $newdata = array();
    $correosena = strtolower($datos['correosena']);
    $correootro = strtolower($datos['correootro']);
    $telefono = htmlentities($datos['telefono']);
    $idcoordinacion = $datos['idcoordinacion'];    
    if(isset($_SESSION['prc_idusuario'])){  
        $ip = $_SERVER["REMOTE_ADDR"]; 
        $centro = $_SESSION['prc_centro'];    
        $usuario =  $_SESSION['prc_ciuser'];
        $idusuario =  $_SESSION['prc_idusuario'];   
        $sqlt = "UPDATE usuarios SET idcoordinacion = '$idcoordinacion',  nombre = '$nombre', correosena = '$correosena', correootro = '$correootro', telefono = '$telefono', vinculacion = '$vinculacion',  instructor = '$instructor', fecha = '$fecha', hora = '$hora', ip = '$ip' WHERE id = '$id';";
          $stmt = Conexion::conectar()->prepare($sqlt);
          if($stmt -> execute()){
            $sqlt = "UPDATE perfiles SET coordinacion = '$idcoordinacion' WHERE idusuario = '$id';";
             $stmt = Conexion::conectar()->prepare($sqlt);
             $stmt -> execute();

            $sqlt = "UPDATE usuariocentro SET coordinacion = '$idcoordinacion' WHERE  idusuario = '$id';";
             $stmt = Conexion::conectar()->prepare($sqlt);
             $stmt -> execute();
             $respuesta = '1';
          }
      }else{
        $respuesta = '0';
      }
      $newdata =  array (
          'respuesta' => $respuesta 
       );   
 $arrDatos[] = $newdata;   
  return json_encode($arrDatos);
    }

 

public function notificarusuario($id){
  include_once "../../routes/config.php";
  $ruta = SERVERURL;   
 $sqlt = "SELECT nombre, correosena, correootro, telefono, contrasena, ip FROM usuarios WHERE id = '$id'";
  $stmt = Conexion::conectar()->prepare($sqlt);
  if($stmt -> execute()){
  $registros = $stmt->fetchAll(); 
    foreach ($registros as $key => $value){
      $nombre = $value['nombre'];
      $correosena = $value['correosena'];
      $correootro = $value['correootro'];
      $telefono = $value['telefono'];
      $contrasena = $value['contrasena'];
      $ip = $value['ip'];
    }
  }
  $asunto = 'PROGRAMACION CENTRO - SENAGALAN.COM'; 
  $cuerpo = ' 
  <html> 
  <head> 
  <title>PROGRAMACION CENTRO - COMPLEMENTARIA SENAGALAN.COM</title> 
  </head> 
  <body> 
  <h2>'.$nombre.'</h2>
  <h3>PLATAFORMA PARA LA PROGRAMACI&Oacute;N DE FORMACI&Oacute;N COMPLEMENTARIA</h3>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">DATO</th>
            <th scope="col">DESCRIPCI&Oacute;N</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          <td>USUARIO</td><td>'.$correosena.'</td>
        </tr> 
          <tr>        
          <td>CONTRASE&Ntilde;A</td><td>'.$contrasena.'</td>
        </tr> 
          <tr>          
          <td>ACCESO A LA PLATAFORMA </td><td>'.SERVERURL.'</td>
        </tr>         
        </tbody>
      </table>
      <hr>
      <p>Con este correo le estamos informado que sus datos fueron registrados correctamente.<p>
      <p>Cuando realice el primer ingreso a la plataforma, <b>el sistema le pedira que asigne una nueva contrase&ntilde;a.<b></p>
      <p>Este correo es informativo y fue generado de forma autom&aacute;tica, <b>no es necesario responder este correo.</b><p>
  '; 
  //para el envío en formato HTML 
  $headers = "MIME-Version: 1.0\r\n"; 
  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
  //dirección del remitente 
  $headers .= "From: Programacion Centro <noreply@senagalan.com>\r\n"; 
  //dirección de respuesta, si queremos que sea distinta que la del remitente 
  $headers .= "Reply-To: Programacion Centro <noreply@senagalan.com>\r\n"; 
  //ruta del mensaje desde origen a destino 
  $headers .= "Return-path: Programacion Centro <noreply@senagalan.com>\r\n"; 
  //direcciones que recibirán copia 
  $headers .= "Cco: ".$correo."\r\n"; 
  //direcciones que recibirán copia oculta 
  $headers .= "Bcc: erpprogramacioncentro@gmail.com\r\n"; 
  mail($correosena.'@sena.edu.co',$asunto,$cuerpo,$headers); 
  if(strlen($correootro) > 1){
    mail($correootro,$asunto,$cuerpo,$headers);
  }  
  //Envair Mail Fin 
  return true;
}

public static function getCoordinaciones(){
  $salida = '';
  if(isset($_SESSION['prc_idusuario'])){ 
  $centro = $_SESSION['prc_centro'];
  $sqlt = "SELECT cr.id, cr.nombre, us.nombre coordinador FROM coordinaciones cr INNER JOIN usuarios us ON us.id = cr.coordinador WHERE cr.estado = '1' AND cr.centro = '$centro';";
  $stmt = Conexion::conectar()->prepare($sqlt);
  $stmt -> execute();
  
  if($stmt->rowCount() > 0){
    $respuesta = '1';
    $registros = $stmt->fetchAll(); 
    foreach ($registros as $key => $value) {
      $id = $value['id'];
      $nombre = html_entity_decode(strtolower($value['nombre']));
      $nombre = ucwords($nombre);
      $coordinador = html_entity_decode(strtolower($value['coordinador']));
      $coordinador = ucwords($coordinador);  
      $salida .= '<option value="'.$id.'">'.$nombre.' -- '.$coordinador.'</option>';
    } 
   } 
  
  } 
 return $salida;      
}


public static function listadoUsuarios(){
  $tabla = '';
  $opciones = '';
  if(isset($_SESSION['prc_idusuario'])){ 
  $centro = $_SESSION['prc_centro'];
  $sqlt = "SELECT us.id id, us.nombre, us.vinculacion, us.instructor, us.correosena, us.correootro, us.telefono, uc.estado, us.idcoordinacion, cr.nombre crnombre FROM usuarios us INNER JOIN coordinaciones cr ON us.idcoordinacion = cr.id INNER JOIN usuariocentro uc ON uc.idusuario = us.id WHERE uc.centro = '$centro' ORDER BY us.nombre ASC";
  $stmt = Conexion::conectar()->prepare($sqlt);
  $stmt -> execute();
  if($stmt->rowCount() > 0){
    $respuesta = '1';
    $registros = $stmt->fetchAll(); 
    foreach ($registros as $key => $value) {
      $id = $value['id'];
      $nombre = html_entity_decode(strtolower($value['nombre']));
      $nombre = ucwords($nombre);
      $crnombre = html_entity_decode(strtolower($value['crnombre']));
      $crnombre = ucwords($crnombre);      
      $correosena = $value['correosena'];
      $correootro = $value['correootro'];
      $vinculacion = $value['vinculacion'];
      $instructor = $value['instructor'];      
      $idcoordinacion = $value['idcoordinacion'];
      $telefono = $value['telefono'];
      $estado = $value['estado'];
      if($estado == '1'){
        $sestado = 'btn-success';
        $testado = '<span style=\"color:green;\">Activo</span>';
        $iestado = '<i class=\"fas fa-lock-open\"></i>';
      }else{
        $sestado = 'btn-danger';
        $testado = '<span style=\"color:orange;\">Inactivo</span>';
        $iestado = '<i class=\"fas fa-lock\"></i>';
      }

      if($vinculacion == '1'){
        $lvinculacion = 'Planta';
      }else{
        $lvinculacion = 'Contratista';
      }
      if($instructor == '1'){
        $linstructor = 'Instructor';
      }else{
        $linstructor = 'Otro';
      }
      if($estado == '1'){
        $sestado = 'btn-success';
        $testado = '<span style=\"color:green;\">Activo</span>';
        $iestado = '<i class=\"fas fa-lock-open\"></i>';
      }else{
        $sestado = 'btn-danger';
        $testado = '<span style=\"color:orange;\">Inactivo</span>';
        $iestado = '<i class=\"fas fa-lock\"></i>';
      }




      $editar ='<button type=\"button\" id=\"btneditar'.$id.'\" onClick=\"editarUsuario(\''.$id.'\');\" class=\"btn btn-info btn-sm\"><i class=\"fas fa-user-edit\"></i></button>';

      $labelestado ='<button type=\"button\" id=\"btnestado'.$id.'\" onClick=\"instruEstado(\''.$id.'\',\''.$estado.'\');\" class=\"btn '.$sestado.' btn-sm\">'.$iestado.'</button>';

      $reestablecer ='<button type=\"button\" id=\"btnreestablecer'.$id.'\" onClick=\"reestablecerUsuario(\''.$id.'\',\''.$nombre.'\',\''.$crnombre.'\');\"  class=\"btn btn-success btn-sm\"><i class=\"fas fa-redo-alt\"></i></button>';

      $permisos ='<button type=\"button\" id=\"btnperfiles'.$id.'\" onClick=\"getPerfiles(\''.$id.'\',\''.$idcoordinacion.'\',\''.$nombre.'\',\''.$crnombre.'\');\"  class=\"btn btn-info btn-sm\"><i class=\"fas fa-user-shield\"></i></button>';

      $tabla .= '{"nombre":"'.$nombre.'","crnombre":"'.$crnombre.'","correosena":"'.$correosena.'","contrasena":"'.$reestablecer.'","correootro":"'.$correootro.'","estado":"'.$labelestado.'","vinculacion":"'.$lvinculacion.'","instructor":"'.$linstructor.'","telefono":"'.$telefono.'","editar":"'.$editar.'","permisos":"'.$permisos.'"},';
    } 
   } 
  $tabla = substr($tabla,0, strlen($tabla) - 1);
  } 
 return '{"data":['.$tabla.']}';      
}


public static function listadoUsuariosSel1(){
  $tabla = '';
  $opciones = '';
  if(isset($_SESSION['prc_idusuario'])){ 
  $centro = $_SESSION['prc_centro'];
  $sqlt = "SELECT us.id id, us.nombre, us.vinculacion, us.instructor, uc.estado, us.idcoordinacion, cr.nombre crnombre FROM usuarios us INNER JOIN coordinaciones cr ON us.idcoordinacion = cr.id INNER JOIN usuariocentro uc ON uc.idusuario = us.id WHERE uc.centro = '$centro' AND us.instructor = '1' ORDER BY us.nombre ASC";
  $stmt = Conexion::conectar()->prepare($sqlt);
  $stmt -> execute();
  if($stmt->rowCount() > 0){
    $respuesta = '1';
    $registros = $stmt->fetchAll(); 
    foreach ($registros as $key => $value) {
      $id = $value['id'];
      $nombre = html_entity_decode(strtolower($value['nombre']));
      $nombre = ucwords($nombre);
      $crnombre = html_entity_decode(strtolower($value['crnombre']));
      $crnombre = ucwords($crnombre);      
      $vinculacion = $value['vinculacion'];  
      $idcoordinacion = $value['idcoordinacion'];
      $estado = $value['estado'];
      if($estado == '1'){
        $sestado = 'btn-success';
        $testado = '<span style=\"color:green;\">Activo</span>';
        $iestado = '<i class=\"fas fa-lock-open\"></i>';
      }else{
        $sestado = 'btn-danger';
        $testado = '<span style=\"color:orange;\">Inactivo</span>';
        $iestado = '<i class=\"fas fa-lock\"></i>';
      }

      if($vinculacion == '1'){
        $lvinculacion = 'Planta';
      }else{
        $lvinculacion = 'Contratista';
      }
      if($estado == '1'){
        $sestado = 'btn-success';
        $testado = '<span style=\"color:green;\">Activo</span>';
        $iestado = '<i class=\"fas fa-lock-open\"></i>';
      }else{
        $sestado = 'btn-danger';
        $testado = '<span style=\"color:orange;\">Inactivo</span>';
        $iestado = '<i class=\"fas fa-lock\"></i>';
      }
      $seleccionar ='<button type=\"button\" id=\"btnperfiles'.$id.'\" onClick=\"selInstruProgramar(\''.$id.'\',\''.$nombre.'\',\''.$crnombre.'\');\"  class=\"btn btn-info btn-sm\"><i class=\"fas fa-check\"></i></button>';

      $tabla .= '{"instructor":"'.$nombre.'","coordinacion":"'.$crnombre.'" , "vinculacion":"'.$lvinculacion.'","seleccionar":"'.$seleccionar.'"},';
    } 
   } 
  $tabla = substr($tabla,0, strlen($tabla) - 1);
  } 
 return '{"data":['.$tabla.']}';      
}

public static function listadoUsuariosSel(){
  $tabla = '';
  $opciones = '';
  if(isset($_SESSION['prc_idusuario'])){ 
  $centro = $_SESSION['prc_centro'];
  $sqlt = "SELECT us.id id, us.nombre, us.vinculacion, us.instructor, uc.estado, us.idcoordinacion, cr.nombre crnombre FROM usuarios us INNER JOIN coordinaciones cr ON us.idcoordinacion = cr.id INNER JOIN usuariocentro uc ON uc.idusuario = us.id WHERE uc.centro = '$centro' AND us.instructor = '1' ORDER BY us.nombre ASC";
  $stmt = Conexion::conectar()->prepare($sqlt);
  $stmt -> execute();
  if($stmt->rowCount() > 0){
    $respuesta = '1';
    $registros = $stmt->fetchAll(); 
    foreach ($registros as $key => $value) {
      $id = $value['id'];
      $nombre = html_entity_decode(strtolower($value['nombre']));
      $nombre = ucwords($nombre);
      $crnombre = html_entity_decode(strtolower($value['crnombre']));
      $crnombre = ucwords($crnombre);      
      $vinculacion = $value['vinculacion'];  
      $idcoordinacion = $value['idcoordinacion'];
      $estado = $value['estado'];
      if($estado == '1'){
        $sestado = 'btn-success';
        $testado = '<span style=\"color:green;\">Activo</span>';
        $iestado = '<i class=\"fas fa-lock-open\"></i>';
      }else{
        $sestado = 'btn-danger';
        $testado = '<span style=\"color:orange;\">Inactivo</span>';
        $iestado = '<i class=\"fas fa-lock\"></i>';
      }

      if($vinculacion == '1'){
        $lvinculacion = 'Planta';
      }else{
        $lvinculacion = 'Contratista';
      }
      if($estado == '1'){
        $sestado = 'btn-success';
        $testado = '<span style=\"color:green;\">Activo</span>';
        $iestado = '<i class=\"fas fa-lock-open\"></i>';
      }else{
        $sestado = 'btn-danger';
        $testado = '<span style=\"color:orange;\">Inactivo</span>';
        $iestado = '<i class=\"fas fa-lock\"></i>';
      }
      $seleccionar ='<button type=\"button\" id=\"btnperfiles'.$id.'\" onClick=\"selInstruProgramar(\''.$id.'\',\''.$nombre.'\',\''.$crnombre.'\',\''.$lvinculacion.'\');\"  class=\"btn btn-info btn-sm\"><i class=\"fas fa-check\"></i></button>';

      $tabla .= '{"instructor":"'.$nombre.'","coordinacion":"'.$crnombre.'" , "vinculacion":"'.$lvinculacion.'","seleccionar":"'.$seleccionar.'"},';
    } 
   } 
  $tabla = substr($tabla,0, strlen($tabla) - 1);
  } 
 return '{"data":['.$tabla.']}';     
}


public static function listadoUsuariosSelFicha(){
  $tabla = '';
  $opciones = '';
  if(isset($_SESSION['prc_idusuario'])){ 
  $centro = $_SESSION['prc_centro'];
  $sqlt = "SELECT us.id id, us.nombre, us.vinculacion, us.instructor, uc.estado, us.idcoordinacion, cr.nombre crnombre FROM usuarios us INNER JOIN coordinaciones cr ON us.idcoordinacion = cr.id INNER JOIN usuariocentro uc ON uc.idusuario = us.id WHERE uc.centro = '$centro' AND us.instructor = '1' ORDER BY us.nombre ASC";
  $stmt = Conexion::conectar()->prepare($sqlt);
  $stmt -> execute();
  if($stmt->rowCount() > 0){
    $respuesta = '1';
    $registros = $stmt->fetchAll(); 
    foreach ($registros as $key => $value) {
      $id = $value['id'];
      $nombre = html_entity_decode(strtolower($value['nombre']));
      $nombre = ucwords($nombre);
      $crnombre = html_entity_decode(strtolower($value['crnombre']));
      $crnombre = ucwords($crnombre);      
      $vinculacion = $value['vinculacion'];  
      $idcoordinacion = $value['idcoordinacion'];
      $estado = $value['estado'];
      if($estado == '1'){
        $sestado = 'btn-success';
        $testado = '<span style=\"color:green;\">Activo</span>';
        $iestado = '<i class=\"fas fa-lock-open\"></i>';
      }else{
        $sestado = 'btn-danger';
        $testado = '<span style=\"color:orange;\">Inactivo</span>';
        $iestado = '<i class=\"fas fa-lock\"></i>';
      }

      if($vinculacion == '1'){
        $lvinculacion = 'Planta';
      }else{
        $lvinculacion = 'Contratista';
      }
      if($estado == '1'){
        $sestado = 'btn-success';
        $testado = '<span style=\"color:green;\">Activo</span>';
        $iestado = '<i class=\"fas fa-lock-open\"></i>';
      }else{
        $sestado = 'btn-danger';
        $testado = '<span style=\"color:orange;\">Inactivo</span>';
        $iestado = '<i class=\"fas fa-lock\"></i>';
      }
      $seleccionar ='<button type=\"button\" id=\"btnperfiles'.$id.'\" onClick=\"selInstruProgramarFicha(\''.$id.'\',\''.$nombre.'\',\''.$crnombre.'\',\''.$lvinculacion.'\');\"  class=\"btn btn-info btn-sm\"><i class=\"fas fa-check\"></i></button>';

      $tabla .= '{"instructor":"'.$nombre.'","coordinacion":"'.$crnombre.'" , "vinculacion":"'.$lvinculacion.'","seleccionar":"'.$seleccionar.'"},';
    } 
   } 
  $tabla = substr($tabla,0, strlen($tabla) - 1);
  } 
 return '{"data":['.$tabla.']}';     
} 


public static function getPerfiles($parametros){ 
$idusuario = $parametros['idusuario'];
$idcoordinacion = $parametros['idcoordinacion']; 
$respuesta = '1'; 
$lista = '';
if(isset($_SESSION['prc_idusuario'])){ 
$centro = $_SESSION['prc_centro'];
$coordinacion = $_SESSION['prc_coordinacion'];
$sqlt = "SELECT misempresas, coorautorizar, prospectos, coorconsultar, gescrear, gesprogramar, adminprogramas, usuarionuevo, adminconsulta, adminusuarios, valradicado, valcontactos, agentesgs  FROM perfiles WHERE idusuario = '$idusuario' AND idcentro = '$centro' AND coordinacion = '$idcoordinacion' AND  estado = '1';";
$stmt = Conexion::conectar()->prepare($sqlt);
$stmt -> execute();
if($stmt->rowCount() > 0){
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
      $agentesgs = $value['agentesgs'];
      $newdata = [
          'misempresas' => $misempresas,
          'coorautorizar' => $coorautorizar,
          'coorconsultar' => $coorconsultar,
          'valradicado' => $valradicado,
          'gescrear' => $gescrear,
          'gesprogramar' => $gesprogramar,
          'adminprogramas' => $adminprogramas,
          'adminusuarios' => $adminusuarios,
          'adminconsulta' => $adminconsulta,
          'valcontactos' => $valcontactos,
          'agentesgs' => $agentesgs,
          'usuarionuevo' => $usuarionuevo
              ];

      $lista .= '<div class="table-responsive-sm">';
      $lista .= '<table class="table">';
      $lista .= ' <thead>';
      $lista .= '  <tr>';
      $lista .= '   <th scope="col">Perfil</th>';
      $lista .= '   <th scope="col">Estado</th>';
      $lista .= '  </tr>';
      $lista .= ' </thead> ';
      $lista .= ' <tbody>';

/*******************/
      $lista .= '  <tr><td>Crear Empresas/Oferta Cerrada</td>';
      $lista .= '  <td id="misempresas"><button id="btnmisempresas" type="button"  ';
      if($misempresas == '1'){
        $stmisempresas = 'btn btn-success btn-sm';
        $imisempresas = '<i class="far fa-check-square"></i>';
      }else{
        $stmisempresas = 'btn btn-secondary btn-sm';
        $imisempresas = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stmisempresas.'" ';
      $lista .= '  onClick="chulear(\'misempresas\',\''.$idusuario.'\',\''.$misempresas.'\');">';
      $lista .= $imisempresas.'</button></td></tr>';

/*******************/

      $lista .= '  <tr><td>Coordinador Autorizar fichas</td>';
      $lista .= '  <td id="coorautorizar"><button id="btncoorautorizar" type="button" ';
      if($coorautorizar == '1'){
        $stcoorautorizar = 'btn btn-success btn-sm';
        $icoorautorizar = '<i class="far fa-check-square"></i>';
      }else{
        $stcoorautorizar = 'btn btn-secondary btn-sm';
        $icoorautorizar = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stcoorautorizar.'" ';
      $lista .= 'onClick="chulear(\'coorautorizar\',\''.$idusuario.'\',\''.$coorautorizar.'\');">';
      $lista .= $icoorautorizar.'</button></td></tr>';

/*******************/
      $lista .= '  <tr><td>Gestor</td>';
      $lista .= '  <td id="gestor"><button id="btngestor" type="button" ';
      if($coorautorizar == '1'){
        $stcoorautorizar = 'btn btn-success btn-sm';
        $icoorautorizar = '<i class="far fa-check-square"></i>';
      }else{
        $stcoorautorizar = 'btn btn-secondary btn-sm';
        $icoorautorizar = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stcoorautorizar.'" ';
      $lista .= 'onClick="chulear(\'gestor\',\''.$idusuario.'\',\''.$coorautorizar.'\');">';
      $lista .= $icoorautorizar.'</button></td></tr>';

/*******************/
      $lista .= '  <tr><td>Coordinador Consultar</td>';
      $lista .= '  <td id="coorconsultar"><button id="btncoorconsultar" type="button" ';
      if($coorconsultar == '1'){
        $stcoorconsultar = 'btn btn-success btn-sm';
        $icoorconsultar = '<i class="far fa-check-square"></i>';
      }else{
        $stcoorconsultar = 'btn btn-secondary btn-sm';
        $icoorconsultar = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stcoorconsultar.'" ';
      $lista .= 'onClick="chulear(\'coorconsultar\',\''.$idusuario.'\',\''.$coorconsultar.'\');">';
      $lista .= $icoorconsultar.'</button></td></tr>';
/*******************/

      $lista .= '  <tr><td>Validar Radicados</td>';
      $lista .= '  <td id="valradicado"><button id="btnvalradicado" type="button" ';
      if($valradicado == '1'){
        $stvalradicado = 'btn btn-success btn-sm';
        $ivalradicado = '<i class="far fa-check-square"></i>';
      }else{
        $stvalradicado = 'btn btn-secondary btn-sm';
        $ivalradicado = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stvalradicado.'" ';
      $lista .= 'onClick="chulear(\'valradicado\',\''.$idusuario.'\',\''.$valradicado.'\');">';
      $lista .= $ivalradicado.'</button></td></tr>';
/*******************/

      $lista .= '  <tr><td>Publicar Fichas</td>';
      $lista .= '  <td id="gescrear"><button id="btngescrear" type="button" ';
      if($gescrear == '1'){
        $stgescrear = 'btn btn-success btn-sm';
        $igescrear = '<i class="far fa-check-square"></i>';
      }else{
        $stgescrear = 'btn btn-secondary btn-sm';
        $igescrear = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stgescrear.'" ';
      $lista .= 'onClick="chulear(\'gescrear\',\''.$idusuario.'\',\''.$gescrear.'\');">';
      $lista .= $igescrear.'</button></td></tr>';
/*******************/

      $lista .= '  <tr><td>Programar ambientes</td>';
      $lista .= '  <td id="gesprogramar"><button id="btngesprogramar" type="button" ';
      if($gesprogramar == '1'){
        $stgesprogramar = 'btn btn-success btn-sm';
        $igesprogramar = '<i class="far fa-check-square"></i>';
      }else{
        $stgesprogramar = 'btn btn-secondary btn-sm';
        $igesprogramar = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stgesprogramar.'" ';
      $lista .= 'onClick="chulear(\'gesprogramar\',\''.$idusuario.'\',\''.$gesprogramar.'\');">';
      $lista .= $igesprogramar.'</button></td></tr>';

/*******************/      
      $lista .= '  <tr><td>Administrar Programas de formación</td>';
      $lista .= '  <td id="adminprogramas"><button id="btnadminprogramas" type="button" ';
      if($adminprogramas == '1'){
        $stadminprogramas = 'btn btn-success btn-sm';
        $iadminprogramas = '<i class="far fa-check-square"></i>';
      }else{
        $stadminprogramas = 'btn btn-secondary btn-sm';
        $iadminprogramas = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stadminprogramas.'" ';
      $lista .= 'onClick="chulear(\'adminprogramas\',\''.$idusuario.'\',\''.$adminprogramas.'\');">';
      $lista .= $iadminprogramas.'</button></td></tr>';

/*******************/      
      $lista .= '  <tr><td>Administrar usuarios</td>';
      $lista .= '  <td id="adminusuarios"><button id="btnadminusuarios" type="button" ';
      if($adminusuarios == '1'){
        $stadminusuarios = 'btn btn-success btn-sm';
        $iadminusuarios = '<i class="far fa-check-square"></i>';
      }else{
        $stadminusuarios = 'btn btn-secondary btn-sm';
        $iadminusuarios = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stadminusuarios.'" ';
      $lista .= 'onClick="chulear(\'adminusuarios\',\''.$idusuario.'\',\''.$adminusuarios.'\');">';
      $lista .= $iadminusuarios.'</button></td></tr>';
/*******************/

      $lista .= '  <tr><td>Consultar fichas</td>';
      $lista .= '  <td id="adminconsulta"><button id="btnadminconsulta" type="button" ';
      if($adminconsulta == '1'){
        $stadminconsulta = 'btn btn-success btn-sm';
        $iadminconsulta = '<i class="far fa-check-square"></i>';
      }else{
        $stadminconsulta = 'btn btn-secondary btn-sm';
        $iadminconsulta = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stadminconsulta.'" ';
      $lista .= 'onClick="chulear(\'adminconsulta\',\''.$idusuario.'\',\''.$adminconsulta.'\');"">';
      $lista .= $iadminconsulta.'</button></td></tr>';
/*******************/

      $lista .= '  <tr><td>Validar Contactos</td>';
      $lista .= '  <td id="valcontactos"><button id="btnvalcontactos" type="button" ';
      if($valcontactos == '1'){
        $stvalcontactos = 'btn btn-success btn-sm';
        $ivalcontactos = '<i class="far fa-check-square"></i>';
      }else{
        $stvalcontactos = 'btn btn-secondary btn-sm';
        $ivalcontactos = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stvalcontactos.'" ';
      $lista .= 'onClick="chulear(\'valcontactos\',\''.$idusuario.'\',\''.$valcontactos.'\');">';
      $lista .= $ivalcontactos.'</button></td></tr>';
/*******************/

      $lista .= '  <tr><td>Prospectos</td>';
      $lista .= '  <td id="prospectos"><button id="btnprospectos" type="button" ';
      if($prospectos == '1'){
        $stprospectos = 'btn btn-success btn-sm';
        $iprospectos = '<i class="far fa-check-square"></i>';
      }else{
        $stprospectos = 'btn btn-secondary btn-sm';
        $iprospectos = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stprospectos.'" ';
      $lista .= 'onClick="chulear(\'prospectos\',\''.$idusuario.'\',\''.$prospectos.'\');">';
      $lista .= $iprospectos.'</button></td></tr>';
/*******************/

      $lista .= '  <tr><td>Agente SGS</td>';
      $lista .= '  <td id="agentesgs"><button id="btnagentesgs" type="button" ';
      if($agentesgs == '1'){
        $stagentesgs = 'btn btn-success btn-sm';
        $iagentesgs = '<i class="far fa-check-square"></i>';
      }else{
        $stagentesgs = 'btn btn-secondary btn-sm';
        $iagentesgs = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stagentesgs.'" ';
      $lista .= 'onClick="chulear(\'agentesgs\',\''.$idusuario.'\',\''.$agentesgs.'\');">';
      $lista .= $iagentesgs.'</button></td></tr>';
/*******************/

      $lista .= '  <tr><td>Crear Usuarios</td>';
      $lista .= '  <td id="usuarionuevo"><button id="btnusuarionuevo" type="button" ';
      if($usuarionuevo == '1'){
        $stusuarionuevo = 'btn btn-success btn-sm';
        $iusuarionuevo = '<i class="far fa-check-square"></i>';
      }else{
        $stusuarionuevo = 'btn btn-secondary btn-sm';
        $iusuarionuevo = '<i class="far fa-square"></i>'; 
      }
      $lista .= ' class="'.$stusuarionuevo.'" ';
      $lista .= 'onClick="chulear(\'usuarionuevo\',\''.$idusuario.'\',\''.$usuarionuevo.'\');">';
      $lista .= $iusuarionuevo.'</button></td></tr>';
/*******************/
      
      $lista .= ' </tbody>';      
      $lista .= '</table>';
      $lista .= '</div>';               
        }        
      } else{
            $respuesta = '0';               
    }  
     }else{
          $respuesta = '5';
     }
  $salida =  array (
    'respuesta' => $respuesta, 
    'datos'=> $lista
  );
  $arrDatos[] = $salida;
  return json_encode($arrDatos);
 }

public static function instruEstado($datos){  
$respuesta = '0';  
if(isset($_SESSION['prc_idusuario'])){   
    $idinstructor = $datos['idinstructor'];
    $nestado = $datos['nestado'];
    $sqlt = "UPDATE usuariocentro SET estado = '$nestado' WHERE idusuario = '$idinstructor'";
        $stmt = Conexion::conectar()->prepare($sqlt);
      $stmt -> execute();
    if($stmt->rowCount() > 0){
        $respuesta = '1'; 
          } else{
          $respuesta = '0';
        }  
    }      
    $newdata =  array (
    'respuesta' => $respuesta
    );
    $arrDatos[] = $newdata;  
    echo json_encode($arrDatos);
 }


public static function chulearPerfil($datos){  #Falta validar cuando sea de otra coordinación
  $idusuario = $datos['idusuario'];
  $perfil = $datos['perfil'];
  $nestado = $datos['nestado'];
  $respuesta = '5';
  $sqlt = "UPDATE perfiles SET $perfil = '$nestado' WHERE idusuario = '$idusuario'";
      $stmt = Conexion::conectar()->prepare($sqlt);
    $stmt -> execute();
  if($stmt->rowCount() > 0){
      $respuesta = $nestado; 
        } else{
      $respuesta = $nestado;
      }  
  $newdata =  array (
  'respuesta' => $respuesta
  );
  $arrDatos[] = $newdata;  
  echo json_encode($arrDatos);
 }
}
