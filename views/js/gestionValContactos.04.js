function tablaValContacto1(){
  try{
  var parametros = {
         'dato':'empresa', 
        'request':'listacontactos'
  };  
  $.ajax({    
  url:"../views/com/empresacom.php",
  type:'POST',
  dataType:'html', //tipo de data que retorna
  data:parametros
  }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php  
         console.log(data);
   // var datosRecibidos = JSON.parse(data); 
        $('#cuerpo').html(data);
  });
    //setInterval('swal("¡Información!", "Cragaremos los proyectos que usted ha creado y en los que aparece como interante de equipo de proyecto, ok?", "info");',10);
    }catch(ex){
    alert(ex);
    }     
}

function tablaValContacto(){
 var html = '';  
    html +=' <h4 class="h4 mb-4  text-muted">RADICADOS PENDIENTES DE VALIDACIÓN</h4> ';
    html +='    <div class="table-responsive">';
    html +='   <table id="valcontactos" class="table table-sm table-bordered table-striped " style="width:100%">';
    html +='        <thead>';
    html +='            <tr>';
    html +='            <th>ESTADO</th>';   
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
    $('#valcontactos').DataTable( { 
    responsive: true,
    autoWidth: false,
     order :[13,'desc'], 
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 } 
        ],
    bDeferRender: true,     
    sPaginationType: "full_numbers",
    ajax: {
      url: "../views/com/empresacom.php",
      type: "POST",
      data:{'dato':'empresa', 'request':'listacontactos'},  
    }, 
responsive: true,   
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf'
    ],
    autoWidth: false,     
columns: [
    { "data": "validado"},
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

function validarContactos(idficha, nvalidado){ 
  var parametros = { 
      'dato':'empresa',
      'request':'contactovalidar',
      'idficha':idficha,
      'nvalidado':nvalidado
   };      
      $.ajax({
       url:"../views/com/empresacom.php", //url del archivo a llamar y que hace el procedimiento
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
    }).done(function(data){
      console.log(data);
      console.log(data);
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
               Command: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                Command: toastr["success"]("Se actualizó validación");
               $('#valcontactos').DataTable().ajax.reload(null, false);
               break;                                            
            case '5':
               window.location = value.ruta;
               break;
           } 
             
        });               
   });
}

/***************************/
function preNoConfirmado(centro, idempresa, idusuario){
  var html = ''
  html +='<textarea type="text" id="explicacion" class="form-control" ';
  html +=' maxlength="500" rows="10" aria-describedby="passwordHelpBlock"></textarea>';
  html +='<p id="passwordHelpBlock" class="text-break">';
  html +=' Breve explicación en 500 caracteres.';
  html +='</p>';
   vtnmodalsm();  
    $('#myModalLabel').html('RESUMEN DEL PROCESO DE VALIDACION NO CONFORME');
      var boton = '<button type="button" onClick="noConfirmado(\''+centro+'\',\''+idempresa+'\',\''+idusuario+'\');" class="btn btn-info">Enviar</button>';
    $('#btnact').html(boton);
    $('#bodymodal').html(html);
    $('#myModal').modal('show');  
}

function noConfirmado(centro, idempresa, idusuario){
  $('#myModal').modal('hide');   
   var explicacion = $('#explicacion').val();
   if(explicacion.length == 0){
      explicacion = 'SIN COMENTARIOS';
   }  
 var parametros = { 
      'dato':'contactos',
      'request':'noconforme',
      'centro':centro,
      'idempresa':idempresa,      
      'idusuario':idusuario,
      'explicacion':explicacion
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
               Command: toastr["success"]("Notificación enviada correctamente."); 
               $('#valcontactos').DataTable().ajax.reload(null, false);
             break;                                            
          case '5':
             window.location = value.ruta;
             break;
         }  
      });               
 });  
}
/***************************/

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

function verMibitacora(idficha){
  $('#btvbitacora'+idficha).attr('disabled', 'disabled');
  var parametros = {
      dato:'bitacora',
      request:'miver', 
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