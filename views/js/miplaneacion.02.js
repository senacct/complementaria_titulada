
function verMibitacora(idficha){
  $('#btvbitacora'+idficha).attr('disabled', 'disabled');
  var parametros = {
      dato:'bitacora',
      request:'miver', 
      idficha:idficha 
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      $('#btvbitacora'+idficha).attr('disabled', false);
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
                $('#myModalLabel').html('BITACORA');
                $('#bodymodal').html(value.bitacora);
                $('#myModal').modal('show'); 
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
    url:"../../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      console.log(data);
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


/***************************/


function vtnmodalsm(){
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