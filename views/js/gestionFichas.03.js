function listaFichasActivas1(){
  try{
  var cor = $('#correo').val();
  var con = $('#contrasena').val();
  var parametros = {
         'dato':'fichas', 
        'request':'activas'
  };  
  $.ajax({    
  url:"../views/com/fichascom.php",
  type:'POST',
  dataType:'html', //tipo de data que retorna
  data:parametros
  }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php  
  console.log(data);
    var datosRecibidos = JSON.parse(data); 
        $('#cuerpo').html(data);
  });
    //setInterval('swal("¡Información!", "Cragaremos los proyectos que usted ha creado y en los que aparece como interante de equipo de proyecto, ok?", "info");',10);
    }catch(ex){
    alert(ex);
    }     
}

function listaFichasActivas(){
 var html = '';  
    html +=' <div class="table-responsive">';
    html +='  <table id="activas" class="table table-sm table-bordered table-striped">';
    html +='     <thead>';
    html +='         <tr>';
    html +='         <th>NUMERO</th>';   
    html +='         <th>C_EMPRESA</th>';
    html +='         <th>COORDINACION</th>'; 
    html +='         <th>INSTRUCTOR</th>'; 
    html +='         <th>APRENDICES</th>';               
    html +='         <th>C_PROGRAMA</th>'; 
    html +='         <th>PROGRAMA</th>'; 
    html +='         <th>AMBIENTE</th>';   
    html +='         <th>DIRECCION</th>';
    html +='         <th>HORAS</th>'; 
    html +='         <th>EMPRESA</th>';               
    html +='         <th>CIUDAD</th>'; 
    html +='         <th>INICIA</th>'; 
    html +='         <th>FINALIZA</th>';   
    html +='         <th>ESTADO</th>';
    html +='         <th>E.FECHA</th>'; 
    html +='         <th>OPCIONES</th>';                    
    html +='         </tr>';
    html +='     </thead>';
    html +='     <tbody>';
    html +='     </tbody>';
     html +='         <tfoot>';
     html +='             <tr>';
     html +='                 <th colspan="16" style="text-align:left">Total:</th>';
     html +='                 <th></th>';
     html +='             </tr>';
     html +='         </tfoot> ';
    html +='    </table>';
    html +='   </div>';
    $('#cuerpo').html(html);
   var table = $('#activas').DataTable( {
    responsive: true,
    autoWidth: false,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 } 
        ],
    bDeferRender: true,     
    sPaginationType: "full_numbers",
    ajax: {
      url: "../views/com/fichascom.php",
      type: "POST",
      data:{'dato':'fichas', 'request':'activas'},  
    },  
order :[0,'desc'],  
    drawCallback: function () {
      var api = this.api();
        var tt = api.column(4).data().sum()
        var st = api.column( 4, {page:'current'} ).data().sum()
        var resumen = st+' de '+tt;
      $(api.table().footer() ).html(
          ' <tr><th colspan="16">Total Aprendices: '+resumen+'</th></tr>'
      );
    },  
columns: [
    { "data": "numero"},
    { "data": "codempresa"},
    { "data": "coordinacion"},
    { "data": "instructor"},
    { "data": "aprendices"},
    { "data": "codigo"},    
    { "data": "nombre"},
    { "data": "lugar"},
    { "data": "direccion"},
    { "data": "horas"},
    { "data": "empresa"},
    { "data": "ciudad"},
    { "data": "finicia"},
    { "data": "ffinaliza"},
    { "data": "estado"},
    { "data": "fecha"}, 
    { "data": "opciones"}     
  ],
"autoWidth": false,
    "responsive" : true,
   dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf'
    ],     
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
    },
  }); 
} 


function verfichaCrear(idficha){
  var parametros = {
      dato:'fichas',
      request:'ver',
      idficha:idficha 
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
     console.log(data);
     var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Programación Centro!", "Debe iniciar Sesión...", "warning");  
              break;
              case '0':
                    swal("Programación Centro!", "No hay fichas pendientes de creación", "warning");                    
              break;              
              case '1':
                 vtnmodalsm();  
                  $('#myModalLabel').html('DATOS DE LA SOLICITUD');
                  // var boton = '<button type="button"  class="btn btn-info">Enviar</button>';
                  //$('#btnact').html(boton);
                  $('#bodymodal').html(value.lista);
                  $('#myModal').modal('show');
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

function novedarcrear(idficha){
  $('#btnnovedad'+idficha).attr('disabled', 'disabled');
  var empresano = '0';
  var inten = $("#empresano").prop("checked") ? true : false;
  if(inten == true){
      empresano = '1';
  }
  if(inten == false){
      empresano = '0';    
  }

  var programano = '0';
  var intpn = $("#programano").prop("checked") ? true : false;
  if(intpn == true){
      programano = '1';
  }
  if(intpn == false){
      programano = '0';    
  }

  var programano = '0';
  var intin = $("#instruno").prop("checked") ? true : false;
  if(intin == true){
      instruno = '1';
  }
  if(intin == false){
      instruno = '0';    
  }
  var parametros = {
      dato:'fichas',
      request:'novedad', 
      idficha:idficha,
      empresano:empresano,
      instruno:instruno,      
      programano:programano 
    }
if((parseInt(empresano, 10) + parseInt(instruno, 10) + parseInt(instruno, 10)) < 1){
     Command: toastr["warning"]("Debe seleccionar un motivo");
     $('#btnnovedad'+idficha).attr('disabled', false);
}else{
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      $('#btnnovedad'+idficha).attr('disabled', false);
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
                   Command: toastr["success"]("Se envió notificación");
              break;                 
            }
          
           });              
    });       
}

}

function enviarprogramacion(idficha){ 
 $('#btnpasar'+idficha).attr('disabled', 'disabled');   
  try{ 
 swal({
  title: "Confirme Por favor!!!",
  text: "La ficha ya está publicada, desea enviarla para programar horas?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#28a745",
  confirmButtonText: "Si, Enviar para programar!",
  cancelButtonText: "No, Me equivoqué!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm){
  $('#btnpasar'+idficha).attr('disabled', 'disabled');
  if (isConfirm) {
  var parametros = { 
      dato:'fichas',
      request:'pasar',
      idficha:idficha
   };      
      $.ajax({
       url:"../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
               Command: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                Command: toastr["success"]("Se envió para programación");
                window.location = value.ruta+'publicarficha/';
               break;                                            
            case '5':
               //frmlogin();
               break;
           }   
        });
        $('#btnpasar'+idficha).attr('disabled', false);                      
    });     
    swal("Notificar!", "Ficha Publicada. Se ha enviado para programación.", "success");
  } else {
    swal("Cancelar", "Omitir proceso, Aún no está lista.", "error");
    $('#btnprog'+idficha).attr('disabled', false); 
  }
});
}catch(ex)
  {
      alert(ex);
  }  
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
    url:"../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
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

function programadoficha(idficha, tipo){ 
 $('#btnprog'+idficha).attr('disabled', 'disabled');   
  try{ 
 swal({
  title: "Confirme Por favor!!!",
  text: "La ficha ya quedó programada?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#28a745",
  confirmButtonText: "Si, Notificar!",
  cancelButtonText: "No, Aún no está programada!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm){
  $('#btnprog'+idficha).attr('disabled', 'disabled');
  if (isConfirm) {
  var parametros = { 
      dato:'programar',
      request:'programado',
      idficha:idficha
   };      
      $.ajax({
       url:"../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
               Command: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                Command: toastr["success"]("Se envió notificación");
                if(tipo == '1'){
                    window.location = value.ruta+'programar/';
                 }else{
                    window.location = value.ruta+'gespendientes/';
                 }
               break;                                            
            case '5':
               window.location = value.ruta;
               break;
           }   
        });
        $('#btnprog'+idficha).attr('disabled', false);                      
    });     
    swal("Notificar!", "Ficha Programada. Se ha enviado notificación.", "success");
  } else {
    swal("Cancelar", "Omitir Notificación Aún no está lista.", "error");
    $('#btnprog'+idficha).attr('disabled', false); 
  }
});
}catch(ex)
  {
      alert(ex);
  }  
}


function prenovedad(idficha, tipo){
  var html = ''
  html +='<textarea type="text" id="explicacion" class="text-uppercase form-control" ';
  html +=' maxlength="45" rows="4" aria-describedby="passwordHelpBlock"></textarea>';
  html +='<p id="passwordHelpBlock" class="text-break">';
  html +=' Breve explicación en 40 caracteres.';
  html +='</p>';
   vtnmodalsm();  
    $('#myModalLabel').html('BREVE EXPLICACION');
      var boton = '<button type="button" onClick="novedad('+idficha+','+tipo+');" class="btn btn-info">Enviar</button>';
    $('#btnact').html(boton);
    $('#bodymodal').html(html);
    $('#myModal').modal('show');  
}

function novedad(idficha, tipo){
$('#myModal').modal('hide');   
 var explicacion = $('#explicacion').val();
 if(explicacion.length == 0){
    explicacion = 'FICHA NO PROGRAMADA';
 }  
 var parametros = { 
      dato:'programar',
      request:'novedad',
      idficha:idficha,
      explicacion:explicacion
   };      
      $.ajax({
      url: "../views/com/fichascom.php",
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
                Command: toastr["info"]("No hay cambios registrados"); 
               //listFormaciones(idempresa);
               break;                  
            case '1':
                Command: toastr["success"]("El registro se actualizó correctamente"); 
                $("#fila_"+idficha).addClass('table-warning'); 
                $("#fila_"+idficha).hide('slow');

                if(tipo == '1'){
                    window.location = value.ruta+'programar/';
                 }else{
                    window.location = value.ruta+'gespendientes/';
                 }
               break;                                            
            case '5':
               window.location = value.ruta;
               break;
           }  
        });               
   });  
}

/***************************************************************/


/******************************************************************/
function presgsrespuesta(idficha){
  var html = ''
  html +='<textarea type="text" id="explicacion" class="text-uppercase form-control" ';
  html +=' maxlength="500" rows="4" aria-describedby="passwordHelpBlock"></textarea>';
  html +='<p id="passwordHelpBlock" class="text-break">';
  html +='</p>';
   vtnmodalsm();  
    $('#myModalLabel').html('ACCION REALIZADA');
      var boton = '<button type="button" onClick="sgsrespuesta('+idficha+');" class="btn btn-info">Enviar</button>';
    $('#btnact').html(boton);
    $('#bodymodal').html(html);
    $('#myModal').modal('show');  
}
function sgsrespuesta(idficha){
$('#myModal').modal('hide');   
 var explicacion = $('#explicacion').val();
 if(explicacion.length == 0){
    explicacion = 'SIN COMENTARIOS';
 }  
 var parametros = { 
      dato:'programar',
      request:'sgsrespuesta',
      idficha:idficha,
      explicacion:explicacion
   };      
      $.ajax({
      url: "../views/com/fichascom.php",
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
                Command: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                Command: toastr["success"]("El registro se actualizó correctamente"); 
                $("#fila_"+idficha).addClass('table-warning'); 
                $("#fila_"+idficha).hide('slow');  
                window.location = value.ruta+'agentesgs/';
               break;                                            
            case '5':
               window.location = value.ruta;
               break;
           }  
        });               
   });  
}
/****************************************************************/
function prependiente(idficha){
  var html = ''
  html +='<textarea type="text" id="explicacion" class="text-uppercase form-control" ';
  html +=' maxlength="500" rows="4" aria-describedby="passwordHelpBlock"></textarea>';
  html +='<p id="passwordHelpBlock" class="text-break">';
  html +='</p>';
   vtnmodalsm();  
    $('#myModalLabel').html('MOTIVO POR EL QUE LA FICHA QUEDA PENDIENTE');
      var boton = '<button type="button" onClick="pendiente('+idficha+');" class="btn btn-info">Enviar</button>';
    $('#btnact').html(boton);
    $('#bodymodal').html(html);
    $('#myModal').modal('show');  
}

function pendiente(idficha){
$('#myModal').modal('hide');   
 var explicacion = $('#explicacion').val();
 if(explicacion.length == 0){
    explicacion = 'SIN COMENTARIOS';
 }  
 var parametros = { 
      dato:'programar',
      request:'pendiente',
      idficha:idficha,
      explicacion:explicacion
   };      
      $.ajax({
      url: "../views/com/fichascom.php",
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
                Command: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                Command: toastr["success"]("El registro se actualizó correctamente"); 
                $("#fila_"+idficha).addClass('table-warning'); 
                $("#fila_"+idficha).hide('slow');  
                window.location = value.ruta+'programar/';
               break;                                            
            case '5':
               window.location = value.ruta;
               break;
           }  
        });               
   });  
}


function quitarControl(idficha, estado){
 var nestado = '0';
 if(estado == '0'){
    nestado = '1';
 }   
  $('#btnqc'+idficha).attr('disabled', 'disabled');
  var parametros = {
      dato:'fichas',
      request:'control', 
      idficha: idficha,
      nestado :nestado
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      $('#btnqc'+idficha).attr('disabled', false);
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
                 $('#activas').DataTable().ajax.reload(null, false);
              break;                 
            }
          
           });              
    });             
}




function notificarficha(idficha){ 
  var parametros = { 
      dato:'fichas',
      request:'notcrear',
      idficha:idficha
   };      
      $.ajax({
       url:"../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
      
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
               Command: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                Command: toastr["success"]("Se envió notificación");
               break;                                            
            case '5':
               //frmlogin();
               break;
           } 
             
        });               
   });
}

function upnumeroficha(idficha){
  var numero = $('#numeroficha').val();
  if(numero.length > 0){
  var parametros = { 
      dato:'fichas',
      request:'upnumero',
      numero:numero,
      idficha:idficha
   };      
      $.ajax({
       url:"../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
               Command: toastr["info"]("No hay cambios registrados"); 
               //listFormaciones(idempresa);
               break;                  
            case '1':
                $("#numficha").html(value.dato);  
                Command: toastr["success"]("Dato actualizado correctamente");
               break;                                            
            case '5':
               //frmlogin();
               break;
           }  
        });               
   });
  }else{
    Command: toastr["warning"]("No hay datos para actualizar"); 
  } 
}

function upcodempresa(idficha){
  var codigo = $('#codigoempresa').val();
  if(codigo.length > 0){
   var parametros = { 
      dato:'fichas',
      request:'upcodigo',
      codigo:codigo,
      idficha:idficha
   };      
      $.ajax({
      url:"../views/com/fichascom.php", //url del archivo a llamar y que hace el procedimiento
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
               Command: toastr["info"]("No hay cambios registrados"); 
               //listFormaciones(idempresa);
               break;                  
            case '1': 
                $("#codmepresa").html(value.dato);  
                Command: toastr["success"]("Dato actualizado correctamente");
               break;                                            
            case '5':
               //frmlogin();
               break;
           }  
        });               
   });
  }else{
    Command: toastr["warning"]("No hay datos para actualizar"); 
  }
}

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