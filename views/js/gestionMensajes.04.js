function enviarMensajes(idficha, instructor, numero, correosena, correootro){
  var html = ''
  html += '<form>';
  html += '<div class="form-group">';
  html += '<label for="asunto">Asunto : </label>';
  html += '<input type="text" class="form-control" id="asunto">';
  html += '</div>';
  html += '<div class="form-group">';
  html += '  <label for="mensaje">Mensaje : </label>';
  html +='<textarea type="text" id="mensaje" class="form-control" ';
  html +=' maxlength="500" rows="10" aria-describedby="passwordHelpBlock"></textarea>';
  html +='<p id="passwordHelpBlock" class="text-break">';
  html +=' Texto del Mensaje en 500 caracteres.';
  html +='</p>';
  html += '</div>';
   vtnmodalsm();  
    $('#myModalLabel').html('MENSAJE PARA <span style="color:blue;">'+instructor+'</span> CON RELACION A LA FICHA: <span style="color:blue;">'+numero+'</span>');
      var boton = '<button type="button" onClick="enviarMsg(\''+idficha+'\',\''+instructor+'\',\''+numero+'\',\''+correosena+'\',\''+correootro+'\');" class="btn btn-info">Enviar</button>';
    $('#btnact').html(boton);
    $('#bodymodal').html(html);
    $('#myModal').modal('show');  
}

function enviarMsg(idficha, instructor, numero, correosena, correootro){
  try{
  $('#myModal').modal('hide'); 
   var asunto = $('#asunto').val();
   if(asunto.length == 0){
      asunto = 'SIN ASUNTO';
   }     
   var mensaje = $('#mensaje').val();
   if(mensaje.length == 0){
      mensaje = 'SIN COMENTARIOS';
   }  
 var parametros = { 
      'dato':'contactos',
      'request':'mensaje',
      'idficha':idficha,      
      'instructor':instructor,
      'numero':numero,
      'correosena':correosena,
      'correootro':correootro,
      'asunto':asunto,
      'mensaje':mensaje
   };      
      $.ajax({
      type:'POST',  
      url:"../views/com/fichascom.php",
      dataType:'html', //tipo de data que retorna 
      data:parametros
    }).done(function(data){
      console.log(data);
      var datosRecibidos = JSON.parse(data); 
      $.each(datosRecibidos, function(key,value) {         
      switch(value.respuesta){   
          case '0':
              Command: toastr["info"]("No hay cambios registrados"); 
             break;                  
          case '1':
              Command: toastr["success"]("Notificación enviada correctamente."); 
             break;                                            
          case '5':
             //frmlogin();
             break;
         }  
      });               
 });
}catch(ex)
  {
    alert(ex);
  } 
}