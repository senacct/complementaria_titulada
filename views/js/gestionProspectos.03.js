function listaProspectos1(){
  try{
  var parametros = {
         'dato':'prospectos', 
        'request':'lista'
  };  
  $.ajax({    
  url:"../views/com/prospectoscom.php",
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


function listaProspectos(){
 var html = '';  
    html +=' <div class="table-responsive">';
    html +='  <table id="listaProspectos" class="table table-sm table-bordered table-striped">';
    html +='     <thead>';
    html +='         <tr>';
    html +='         <th>NOMBRE</th>'; 
    html +='         <th>TIPO_DOC</th>'; 
    html +='         <th>DOCUMENTO</th>';       
    html +='         <th>CORREO</th>';
    html +='         <th>TELEFONO</th>'; 
    html +='         <th>CURSOS</th>'; 
    html +='         <th>FUNCIONARIO</th>';               
    html +='         <th>FECHA</th>'; 
    html +='         <th>HORA</th>'; 
    html +='         <th>ESTADO</th>'; 
    html +='         <th>OPCIONES</th>';                         
    html +='         </tr>';
    html +='     </thead>';
    html +='     <tbody>';
    html +='     </tbody>';
    html +='    </table>';
    html +='   </div>';
    $('#cuerpo').html(html);
   var table = $('#listaProspectos').DataTable( {
    responsive: true,
    autoWidth: false,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 } 
        ],
    bDeferRender: true,     
    sPaginationType: "full_numbers",
    ajax: {
      url: "../views/com/prospectoscom.php",
      type: "POST",
      data:{'dato':'prospectos', 'request':'lista'},  
    },  
order :[0,'desc'],  
   
columns: [
    { "data": "nombre"},
    { "data": "tipodoc"},
    { "data": "documento"},    
    { "data": "correo"},
    { "data": "telefonos"},
    { "data": "cursos"},
    { "data": "usnombre"},
    { "data": "fecha"},    
    { "data": "hora"},
    { "data": "estado"},
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

function prospectoEstado(id, estado, tabla){
 var nestado = '0';
 if(estado == '0'){
    nestado = '1';
 }   
  $('#btnestado'+id).attr('disabled', 'disabled');
  var parametros = {
      'dato':'prospectos',
      'request':'estado', 
      'id': id,
      'nestado' :nestado,
      'tabla' : tabla
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/prospectoscom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      console.log(data);
      $('#btnestado'+id).attr('disabled', false);
      var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Complementaria", "Debe iniciar Sesión...", "warning");
                    window.location = value.ruta;
              break;
              case '0':
                    Command: toastr["warning"]("No se registró ningún cambio");                    
              break;              
              case '1':
                    Command: toastr["success"]("Se registró la actualización");
                    $('#listaProspectos').DataTable().ajax.reload(null, false);
              break;                 
            }
          
           });              
    });             
}

function nuevoProspecto(){
 var html = ''; 
      html +='<form>';
      html +='          <div class="row">';
      html +='            <div class="col col-12 col-md-4">';
      html +='            <label id="frmtipodoc" for="estado" class="col-sm-12 col-form-label">Tipo Documento :</label>';
      html +='               <select id="tipodoc" class="form-control">'; 
      html +='                   <option value="CC">CC</option>';     
      html +='                   <option value="TI">TI</option>';
      html +='                   <option value="CE">CE</option>';
      html +='                   <option value="PS">PS</option>';   
      html +='                   <option value="RC">RC</option>';  
      html +='                   <option value="PEP">PEP</option>';             
      html +='               </select>'; 
      html +='            </div>';
      html +='            <div class="col-12 col-md-8">';
      html +='            <label for="documento" class="col-form-label">Numero</label>';
      html +='             <input type="text" class="form-control" id="documento">';
      html +='            </div>';
      html +='          </div>'; 
      html +='  <div class="form-group">';
      html +='    <label for="recipient-name" class="col-form-label">Nombre:</label>';
      html +='    <input type="text" class="form-control" id="nombre">';
      html +='  </div>';
      html +='  <div class="form-group">';
      html +='    <label for="recipient-name" class="col-form-label">Correo:</label>';
      html +='    <input type="text" class="form-control" id="correo">';
      html +='  </div>    ';
      html +='  <div class="form-group">';
      html +='    <label for="recipient-name" class="col-form-label">Teléfonos:</label>';
      html +='    <input type="text" class="form-control" id="telefonos">';
      html +='  </div>                             ';
      html +='  <div class="form-group">';
      html +='    <label for="message-text" class="col-form-label">Cursos de mi interés:</label>';
      html +='    <textarea class="form-control" id="cursos"></textarea>';
      html +='  </div>';
      html +='</form>';
      html +=' <div id="btnact">';
      html +='  <button type="button" id="btncrearbodega" class="btn btn-success btn-block" onclick="crearProspectos(\'0\');">Guardar</button>';
      html +=' </div>';     
          vervtnmodal();
  $('#bodymodal').html(html);
  $('#myModalLabel').html('GESTIÓN PROSPECTOS');
  $('#myModal').modal('show');
  fhtml ="<a href='#' class='btn btn-default' data-dismiss='modal'>Cerrar</a>";
  $('#myModalFooter').html(fhtml);     
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

function crearProspectos(){
  var nombre = '';
  var correo = '';
  var telefonos = '';
  var cursos = '';
  var documento = '';
  var tipodoc = '';
  $("#tipodoc").change(function () {
    $("#tipodoc option:selected").each(function () {
      tipodoc = $(this).val();
        });
}).trigger('change'); 
  documento = $('#documento').val(); 
  nombre = $('#nombre').val(); 
  correo = $('#correo').val();
  telefonos = $('#telefonos').val();
  cursos = $('#cursos').val();
  var parametros = {
      'dato':'prospectos', 
      'request':'crear',
      'tipodoc':tipodoc,
      'documento':documento,      
      'nombre':nombre,
      'correo':correo,
      'telefonos':telefonos,
      'cursos':cursos
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/prospectoscom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      console.log(data);
     var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Complementaria", "Debe iniciar Sesión...", "warning");
                    window.location = value.ruta;
              break;
              case '0':
                    Command: toastr["warning"]("No se registró ningún cambio");                    
              break;              
              case '1':
                    Command: toastr["success"]("Se registró la actualización");
                    $('#listaProspectos').DataTable().ajax.reload(null, false);
                    $('#myModal').modal('hide');
              break;                 
            }
        });              
    });             
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