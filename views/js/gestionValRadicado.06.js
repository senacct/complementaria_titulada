function tablaValRadicado1(){
  try{
  var cor = $('#correo').val();
  var con = $('#contrasena').val();
  var parametros = {
         'dato':'formacion', 
        'request':'radicado'
  };  
  $.ajax({    
  url:"../views/com/formacioncom.php",
  type:'POST',
  dataType:'html', //tipo de data que retorna
  data:parametros
  }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php  

    var datosRecibidos = JSON.parse(data); 
        $('#cuerpo').html(data);
  });
    //setInterval('swal("¡Información!", "Cragaremos los proyectos que usted ha creado y en los que aparece como interante de equipo de proyecto, ok?", "info");',10);
    }catch(ex){
    alert(ex);
    }     
}

function tablaValRadicado(){
 var html = '';  
    html +=' <h4 class="h4 mb-4  text-muted">RADICADOS PENDIENTES DE VALIDACIÓN</h4> ';
    html +='    <div class="table-responsive">';
    html +='   <table id="radicados" class="table table-sm table-bordered table-striped " style="width:100%">';
    html +='        <thead>';
    html +='            <tr>';
    html +='            <th>RADICADO</th>';   
    html +='            <th>VALIDADO</th>';
    html +='            <th>CONTACTO</th>'; 
    html +='            <th>C_TELEFONO</th>';               
    html +='            <th>C_CORREO</th>'; 
    html +='            <th>EMPRESA</th>'; 
    html +='            <th>COORDINACION</th>';   
    html +='            <th>INSTRUCTOR</th>';
    html +='            <th>CIUDAD</th>'; 
    html +='            <th>AMBIENTE</th>';               
    html +='            <th>DIRECCION</th>'; 
    html +='            <th>FICHA</th>'; 
    html +='            <th>CURSO</th>';   
    html +='            <th>HORAS</th>';
    html +='            <th>INICIA</th>'; 
    html +='            <th>FINALIZA</th>';               
    html +='            <th>ESTADO</th>'; 
    html +='            <th>OPCIONES</th>'; 
    html +='            </tr>';
    html +='        </thead>';
    html +='        <tbody>';
    html +='        </tbody>';
    html +='    </table>';
    html +='   </div>';
    $('#cuerpo').html(html);
    $('#radicados').DataTable( { 
    responsive: true,
    autoWidth: false,
    
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 } 
        ],
    bDeferRender: true,     
    sPaginationType: "full_numbers",
    ajax: {
      url: "../views/com/formacioncom.php",
      type: "POST",
      data:{'dato':'formacion', 'request':'radicado'},  
    },  
columns: [
    { "data": "onbase"},
    { "data": "val_onbase"},
    { "data": "ctnombre"},
    { "data": "cttelefono"},
    { "data": "ctcorreo"},    
    { "data": "empresa"},
    { "data": "coordinacion"},
    { "data": "instructor"},
    { "data": "ciudad"},
    { "data": "lugar"},
    { "data": "direccion"},
    { "data": "numero"},
    { "data": "nombre"},
    { "data": "horas"},
    { "data": "finicia"},
    { "data": "ffinaliza"},
    { "data": "nestado"}, 
    { "data": "opciones"}    
  ],
"autoWidth": false,
    "responsive" : true,  
"oLanguage": {
    "sProcessing": "Procesando...",
    "sLengthMenu": 'Mostrar <select>'+
        '<option value="10">10</option>'+
        '<option value="20">20</option>'+
        '<option value="30">30</option>'+
        '<option value="40">40</option>'+
        '<option value="50">50</option>'+
        '<option value="-1">All</option>'+
        '</select> registros',    
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando del (_START_ al _END_) de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Filtrar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Por favor espere - cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    } 
    }
  }); 
} 

function instruBloquear(idinstructor, estado){
 var nestado = '0';
 if(estado == '0'){
    nestado = '1';
 }   
  $('#btnbloquear'+idinstructor).attr('disabled', 'disabled');
  var parametros = {
      dato:'formacion',
      request:'bloquear', 
      idinstructor: idinstructor,
      nestado :nestado
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      $('#btnbloquear'+idinstructor).attr('disabled', false);
      var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Programación Centro!", "Debe iniciar Sesión...", "warning");
                    frmlogin();
              break;
              case '0':
                    Command: toastr["warning"]("No se registró ningún cambio");                    
              break;              
              case '1':
                 Command: toastr["success"]("Se registró la actualización");
                 $('#radicados').DataTable().ajax.reload(null, false);
              break;                 
            }
          
           });              
    });             
}

function  validadoRadicado(idficha, estado){
 var nestado = '0';
 if(estado == '0'){
    nestado = '1';
 }   
  $('#btnvalidador'+idficha).attr('disabled', 'disabled');
  var parametros = {
      dato:'formacion',
      request:'validadoradicado', 
      idficha: idficha,
      nestado :nestado
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      $('#btnvalidador'+idficha).attr('disabled', false);
      var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Programación Centro!", "Debe iniciar Sesión...", "warning");
                    frmlogin();
              break;
              case '0':
                    Command: toastr["warning"]("No se registró ningún cambio");                    
              break;              
              case '1':
                 Command: toastr["success"]("Se registró la actualización");
                 $('#radicados').DataTable().ajax.reload(null, false);
              break;                 
            }
          
           });              
    });             
}


function verbitacora(idficha){
  $('#btvbitacora'+idficha).attr('disabled', 'disabled');
  var parametros = {
      dato:'bitacora',
      request:'ver', 
      idficha:idficha 
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
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

function verProgramacion(idficha, numero){
  $('#btvhorario'+idficha).attr('disabled', 'disabled');
  var parametros = {
      dato:'programacion',
      request:'ver', 
      idficha:idficha,
      numero:numero 
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
function bodyRadicado(id){
html = '';  
html += ' <form class="form-inline">';
html +='<div class="form-group">';
html +='<div class="input-group mb-4">';
html +='  <input type="text" class="form-control" id="nonbase" placeholder="Número radicación solicitud">';
html +='  <div class="input-group-append">';
html +='  <button class="btn btn-outline-secondary" onClick="updateRadicado('+id+');" type="button" id="btnonbase"><i class="fas fa-check"></i></button>';
html +='  </div>';
html +='</div>';
html +='</div>';    
html +='</form>';
   vervtnmodal();  
    $('#myModalLabel').html('Número Radicación Solicitud');
    $('#bodymodal').html(html);
    $('#myModal').modal('show');  
}

function updateRadicado(idficha){
  var onbase = $('#nonbase').val();
  if(onbase.length > 0){
  var parametros = { 
      'dato':'formacion',
      'request':'updateRadicado', 
      'onbase':onbase,
      'idficha':idficha
   };      
      $.ajax({
       url:"../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
      console.log(data);
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
               Command: toastr["info"]("No hay cambios registrados."); 
               break;                  
            case '1': 
                $("#placenonbase").html(value.dato);
                Command: toastr["success"]("Registro actualizado correctamente.");
                $('#radicados').DataTable().ajax.reload(null, false); 
               break;                                            
            case '5':
               window.location = value.ruta;
               break;
           }  
        });               
   });
  }else{
    Command: toastr["warning"]("No hay datos para actualizar"); 
  } 
}

function preNoConfirmado(idficha){
  var html = '';
  $('#btvnotificar'+idficha).attr('disabled', 'disabled');
  html +='<textarea type="text" id="explicacion" class="form-control" ';
  html +=' maxlength="500" rows="10" aria-describedby="passwordHelpBlock"></textarea>';
  html +='<p id="passwordHelpBlock" class="text-break"><hr>';
  html +=' Explicación en max. 500 caracteres.';
  html +='</p>';
   vervtnmodal();  
    $('#myModalLabel').html('REPORTAR NOVEDAD EN PROCESO DE VALIDACIÓN');
      var boton = '<button type="button" onClick="noConfirmado('+idficha+');" class="btn btn-info">Enviar</button>';
    $('#btnact').html(boton);
    $('#bodymodal').html(html);
    $('#myModal').modal('show');  
    $('#btvnotificar'+idficha).attr('disabled', false);
}

function noConfirmado(idficha){
  $('#myModal').modal('hide');   
   var explicacion = $('#explicacion').val();
   if(explicacion.length == 0){
      explicacion = 'SIN COMENTARIOS';
   }  
 var parametros = { 
      dato:'formacion',
      request:'noconfirmado',    
      idusuario:idficha,
      explicacion:explicacion
   };      
      $.ajax({
      url: "../views/com/formacioncom.php",
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
      console.log(data);
      var datosRecibidos = JSON.parse(data); 
      $.each(datosRecibidos, function(key,value) {         
      switch(value.respuesta){   
          case '0':
              Command: toastr["info"]("No hay cambios registrados"); 
             //listFormaciones(idempresa);
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
}
/***************************/


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
