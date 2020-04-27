function autorizar(idficha){
 var parametros = { 
      dato:'formacion',
      request:'autorizar',
      idficha:idficha
   };      
      $.ajax({
      url: '../views/com/coordinacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
 
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
               caCommand: toastr["info"]("No hay cambios registrados"); 
               //listFormaciones(idempresa);
               break;                  
            case '1':
                aCommand: toastr["success"]("El registro se actualizó correctamente"); 
                $("#fila_"+idficha).addClass('table-success'); 
                $("#fila_"+idficha).hide('slow');  
               break;                                            
            case '5':
               //frmlogin();
               break;
           }  
        });               
   });  
}

function coorconsultar(ano, mes, dia){
 var parametros = { 
      dato:'formacion',
      request:'consultar',
      ano:ano,
      mes:mes,
      dia:dia
   };      
      $.ajax({
      url: '../views/com/coordinacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
      console.log(data);
      var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Programación Centro!", "Debe iniciar Sesión...", "warning");
                    frmlogin();
              break;
              case '0':
                    swal("Programación Centro!", "No hay datos creados o activos", "warning");                    
              break;              
              case '1':
                vervtnmodal();  
                $('#myModalLabel').html('FICHAS PROGRAMADAS HOY '+ano+'-'+mes+'-'+dia);
                $('#bodymodal').html(value.horario);
                $('#myModal').modal('show'); 
              break;                 
            }
          
           });              
    });             
}


function predenegar(idficha){ 
 var html = ''
html +='<textarea type="text" id="explicacion" class="text-uppercase form-control" ';
html +=' maxlength="45" rows="4" aria-describedby="passwordHelpBlock"></textarea>';
html +='<p id="passwordHelpBlock" class="text-break">';
html +=' Breve explicación en 40 caracteres.';
html +='</p>';
 vtnmodalsm();  
  $('#myModalLabel').html('MOTIVO PARA DENEGAR LA SOLICITUD');
    var boton = '<button type="button" onClick="denegar('+idficha+');" class="btn btn-info">Enviar</button>';
  $('#btnact').html(boton);
  $('#bodymodal').html(html);
  $('#myModal').modal('show');  
}

function denegar(idficha){
$('#myModal').modal('hide');   
 var explicacion = $('#explicacion').val();
 if(explicacion.length == 0){
    explicacion = 'SIN COMENTARIOS';
 }  
 var parametros = { 
      dato:'formacion',
      request:'denegar',
      idficha:idficha,
      explicacion:explicacion
   };      
      $.ajax({
      url: '../views/com/coordinacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
               caCommand: toastr["info"]("No hay cambios registrados"); 
               //listFormaciones(idempresa);
               break;                  
            case '1':
                aCommand: toastr["success"]("El registro se actualizó correctamente"); 
                $("#fila_"+idficha).addClass('table-warning'); 
                $("#fila_"+idficha).hide('slow');  
               break;                                            
            case '5':
               //frmlogin();
               break;
           }  
        });               
   });  
}
function verProgramacion(idficha){
  $('#btvhorario'+idficha).attr('disabled', 'disabled');
  var parametros = {
      dato:'programacion',
      request:'ver', 
      idficha:idficha 
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      $('#btvhorario'+idficha).attr('disabled', false);
      var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Programación Centro!", "Debe iniciar Sesión...", "warning");
                    frmlogin();
              break;
              case '0':
                    swal("Programación Centro!", "No hay datos creados o activos", "warning");                    
              break;              
              case '1':
                vervtnmodal();  
                $('#myModalLabel').html('PROGRAMACION');
                $('#bodymodal').html(value.horario);
                $('#myModal').modal('show'); 
              break;                 
            }
          
           });              
    });             
}
function vervtnmodal(){
var html = '';
html +='<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
html +='  <div class="modal-dialog modal-lg" role="document">';
html +='    <div class="modal-content">';
html +='      <div class="modal-header">';
html +='        <h5 class="modal-title" id="myModalLabel">New message</h5>';
html +='        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
html +='          <span aria-hidden="true">&times;</span>';
html +='        </button>';
html +='      </div>';

html +='      <div id="bodymodal" class="modal-body">';
html +='      </div>';
html +='      <div class="modal-footer">';
html +='      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>';
html +='      <span id="btnact"></span> ';
html +='      </div>';
html +='    </div>';
html +='  </div>';
html +='</div>';
$('#placemodal').html(html);          
}
function vtnmodalsm(){
var html = '';
html +='<div class="modal fade bd-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
html +='  <div class="modal-dialog modal-sm" role="document">';
html +='    <div class="modal-content">';
html +='      <div class="modal-header">';
html +='        <h5 class="modal-title" id="myModalLabel">New message</h5>';
html +='        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
html +='          <span aria-hidden="true">&times;</span>';
html +='        </button>';
html +='      </div>';

html +='      <div id="bodymodal" class="modal-body">';
html +='      </div>';
html +='      <div class="modal-footer">';
html +='      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>';
html +='      <span id="btnact"></span> ';
html +='      </div>';
html +='    </div>';
html +='  </div>';
html +='</div>';
$('#placemodal').html(html);          
}