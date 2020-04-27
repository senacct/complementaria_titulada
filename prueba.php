<?php
	//include_once "routes/config.php";
	require_once "models/conexion.php";
	session_start();
 include_once "../../routes/config.php";
  $ruta = SERVERURL;   
 $sqlt = "SELECT nombre, correosena, correootro, telefono, contrasena, ip FROM usuarios WHERE id = '1'";
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
  $asunto = 'PROGRAMACION CENTRO - COMPLEMENTARIA DATASENA'; 
  $cuerpo = ' 
  <html> 
  <head> 
  <title>PROGRAMACION CENTRO - COMPLEMENTARIA DATASENA</title> 
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