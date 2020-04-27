function nuevoPrograma(id){
var html = '<form>'; 
    html +='      <div class="form-group">';
    html +='          <div class="row">';
    html +='            <div class="col col-12 col-md-6">';
    html +='            <label id="frmcodigo" for="codigo" class="col-sm-12 col-form-label">Codigo :<span id="sofia" style="color:green" ></span></label>';
    html +='              <input id="codigo" type="text" class="form-control">';
    html +='            </div>';  
    //html +='                <script>';
    //html +='                $(codigo).ready(function() {';
    //html +='                $("#codigo").focusout(function(){';  
    //html +='                var dato = $(this).val(); ';
    //html +='                existeprograma(dato);';
    //html +='                 }) ';
    //html +='                 }).trigger;';
    //html +='                </script>'; 
    html +='            <div class="col col-12 col-md-6">';
    html +='            <label id="frmversion"  for="version" class="col-sm-12 col-form-label">Versión</label>';
    html +='              <input id="version" type="text" class="form-control">';
    html +='            </div>';
    html +='          </div>';
    html +='          <div class="row">';
    html +='            <div class="col col-12 col-md-6">';
    html +='            <label id="frmhoras" for="horas" class="col-sm-12 col-form-label">Horas :</label>';
    html +='              <input id="horas" type="text" class="form-control">';
    html +='            </div>';
    html +='            <div class="col-12 col-md-6">';
    html +='            <label id="frmestado" for="estado" class="col-sm-12 col-form-label">Estado :</label>';
    html +='        <select id="estado" class="form-control">'; 
    html +='            <option value="1">Ejecución</option>';
    html +='            <option value="0">No disponible</option>'; 
    html +='        </select>'; 
    html +='            </div>';
    html +='          </div>'; 
    
    html +='          <div class="row">';
    html +='            <div class="col col-12 col-md-6">';
    html +='            <label id="frmnivel" for="estado" class="col-sm-12 col-form-label">Nivel :</label>';
    html +='        <select id="nivel" class="form-control">'; 
    html +='            <option value="0">Complementaria</option>';
    html +='            <option value="1">Operario</option>'; 
    html +='            <option value="2">Auxiliar</option>';
    html +='            <option value="3">Técnico</option>';   
    html +='            <option value="4">Tecnologo</option>';  
    html +='            <option value="5">Especialización Tecnológica</option>';             
    html +='        </select>'; 
    html +='            </div>';
    html +='            <div class="col-12 col-md-6">';
    html +='            <label id="frmmodalidad" for="estado" class="col-sm-12 col-form-label">Modalidad :</label>';
    html +='        <select id="modalidad" class="form-control">'; 
    html +='            <option value="0">Presencial</option>';
    html +='            <option value="1">Virtual</option>'; 
    html +='            <option value="2">Distancia</option>';  
    html +='            <option value="3">Mixta</option>';         
    html +='        </select>'; 
    html +='            </div>';
    html +='          </div>'; 
    html +='          <div class="row">';
    html +='            <div class="col-12 col-md-12">';
    html +='            <label id="frmespecialidad" for="estado" class="col-sm-12 col-form-label">Especialidad :</label>';
    html +='        <select id="especialidad" class="form-control">'; 
    html +='        </select>'; 
    html +='            </div>';
    html +='          </div>'; 

    html +='          <div class="form-group">';
    html +='            <label id="frmnombre" for="nombre" class="col-sm-4 col-form-label">Programa :</label>';
    html +='              <textarea rows="5" id="nombre" type="text" class="form-control"></textarea>';
    html +='          </div>';
    html +='<div id="msalida">';
    html +='</div>';
    html +='        </form>';
    vtnmodalsm();  
    $('#myModalLabel').html('PROGRAMA DE FORMACIÓN: ');
    $('#bodymodal').html(html);
    boton = '<button id="btncrearprograma" type="button" onClick="crearprograma(\''+id+'\');" class="btn btn-primary">Guardar</button>';
    $("#btnact").html(boton);
    $('#myModal').modal('show'); 
     traerlespecialidad(1);
}


function traerlespecialidad(idespecialidad){
  var parametros = {
      dato:'especialidad',
      request:'lista' 
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/programascom.php", //Trae datos para editar  
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Programación Centro!", "Debe iniciar Sesión...", "warning");
                    frmlogin();
              break;
              case '0':
                    swal("Programación Centro!", "No hay especialidades creadas o activas", "warning");                    
              break;              
              case '1':
                  $('#especialidad').html(value.datos);  
                  $("#especialidad > option[value="+idespecialidad+"]").attr("selected", "selected");
              break;                 
            }
          
           });              
    });             
}

function crearprograma(id){
$('#btncrearprograma').attr('disabled', 'disabled'); 
var correcto = '1';
var mensajeerror = '';
var codigo = $('#codigo').val();
var version = $('#version').val();
var horas = $('#horas').val();
var nombre = $('#nombre').val();
var estado = '1'; 
var idespecialidad = '0';
var nivel = '1'; 
var modalidad = '0';
$("#especialidad").change(function () {
    $("#especialidad option:selected").each(function () {
      idespecialidad = $(this).val();
        });
}).trigger('change'); 

$("#estado").change(function () {
    $("#estado option:selected").each(function () {
      estado = $(this).val();
        });
}).trigger('change');

$("#nivel").change(function () {
    $("#nivel option:selected").each(function () {
      nivel = $(this).val();
        });
}).trigger('change'); 

$("#modalidad").change(function () {
    $("#modalidad option:selected").each(function () {
      modalidad = $(this).val();
        });
}).trigger('change');

 
if(codigo.length < 5){
   correcto = '0';
   $('#frmcodigo').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Debe escribir el codigo del programa.<p>';
}else{
   $('#frmcodigo').removeClass('alert-danger');
   $('#frmcodigo').addClass('alert-ligh');
}
if(version.length < 1){
   correcto = '0';
   $('#frmversion').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Olvidó escribir la versión.<p>';
}else{
   $('#frmversion').removeClass('alert-danger');
   $('#frmversion').addClass('alert-ligh');
}

if(horas.length < 1){
   correcto = '0';
   $('#frmhoras').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Las horas es un campo obligatorio.<p>';
}else{
   $('#frmhoras').removeClass('alert-danger');
    $('#frmhoras').addClass('alert-ligh');
}

 
if(nombre.length < 5){
   correcto = '0';
   $('#frmnombre').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">El nombre no puede estar en blanco.</p>';
}else{
   $('#frmnombre').removeClass('alert-danger');
   $('#frmnombre').addClass('alert-ligh');
}
if(correcto == '1'){
    var parametros={ 
      'dato':'programas',
      'request':'update', 
      'id':id, 
      'idespecialidad':idespecialidad, 
      'codigo':codigo,
      'version':version,
      'horas':horas,
      'nombre':nombre,
      'estado':estado,
      'nivel':nivel,
      'modalidad':modalidad
    };   
      $.ajax({ //inicia la funcion ajax
          type:"POST", //tipo de envio: post o get como en un formulario web
          url:"../views/com/programascom.php", //Trae datos para editar    
          dataType:"html", //tipo de data que retorna
          data:parametros
          }).done(function(data){ 
            var datosRecibidos = JSON.parse(data); 
            $.each(datosRecibidos, function(key,value) {
              if(value.respuesta == '1'){
                  $('#myModal').modal('hide');            
                  $('#msalida').html('');
                  $('#tablaprogramas').DataTable().ajax.reload(null, false);
              }
            });
          });     
  }else{ 
     aCommand: toastr["warning"]("Faltan datos para realizar el proceso"); 
     var mens ='<div id="mserr" class="alert alert-danger" role="alert">';
     mens +=     '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
     mens +=       '<span aria-hidden="true">&times;</span>';
     mens +=     '</button>';
         mens += '<h4 class="alert-heading"><strong>Hay datos por revisar!</strong></h4><hr>' ;
         mens += '<p><b>Antes de continuar debe ingresar estos datos:</b></p><br>';
         mens += mensajeerror;
         mens +='</div>';
         $('#msalida').html(mens);
      }
  $('#btncrearprograma').attr('disabled', false); 
}


function tablaProgramas1(){
  try{
  var cor = $('#correo').val();
  var con = $('#contrasena').val();
  var parametros = {
         'dato':'programas', 
        'request':'listado'
  };  
  $.ajax({    
  url:"../views/com/programascom.php",
  type:'POST',
  dataType:'html', //tipo de data que retorna
  data:parametros
  }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php  
 $('#cuerpo').html(data);
    var datosRecibidos = JSON.parse(data); 
       
  });
    //setInterval('swal("¡Información!", "Cragaremos los proyectos que usted ha creado y en los que aparece como interante de equipo de proyecto, ok?", "info");',10);
    }catch(ex){
    alert(ex);
    }     
}

function tablaProgramas(){
 var html = '';  

    html +=' <h4 class="h4 mb-4  text-muted">LISTADO DE PROGRAMAS</h4> ';
    html +='    <div class="table-responsive">';
    html +='   <table id="tablaprogramas" class="table table-sm table-bordered table-striped " style="width:100%">';
    html +='        <thead>';
    html +='            <tr>';
    html +='            <th>C_PROGRAMA</th>';    
    html +='            <th>PROGRAMA</th>';       
    html +='            <th>VERSION</th>';
    html +='            <th>ESPECIALIDAD</th>';  
    html +='            <th>NIVEL</th>';
    html +='            <th>MODALIDAD</th>';       
    html +='            <th>HORAS</th>';       
    html +='            <th>ESTADO</th>';
    html +='            <th>EDITAR</th>'; 
    html +='            </tr>';
    html +='        </thead>';
    html +='        <tbody>';
    html +='        </tbody>';
    html +='    </table>';
    html +='   </div>';

    $('#cuerpo').html(html);
    $('#tablaprogramas').DataTable({ 
    responsive: true,   
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf'
    ],
    autoWidth: false,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 } 
        ],
    bDeferRender: true,     
    sPaginationType: "full_numbers",
    ajax: {
      url:"../views/com/programascom.php",
      type: "POST",
      data:{'dato':'programas', 'request':'listado'},  
    },  
columns: [
    { "data": "codigo"}, 
    { "data": "nombre"},
    { "data": "version"},
    { "data": "nespecialidad"}, 
    { "data": "nivel"}, 
    { "data": "modalidad"},       
    { "data": "horas"},         
    { "data": "estado"},
    { "data": "acciones"}
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


function editarPrograma(id){
  nuevoPrograma(id);
  var parametros = {
    dato:'programas',
    request:'traerid',   
    'id':id 
  };  
 if(id !== '0'){   
  try{
      var html = '';  
      $.ajax({ //inicia la funcion ajax
      type:'POST', //tipo de envio: post o get como en un formulario web
      url:"../views/com/programascom.php", //url del archivo a llamar y que hace el procedimiento
      dataType:'html',
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php   
          var datosRecibidos = JSON.parse(data); 
            $.each(datosRecibidos, function(key,value) {
              if(value.respuesta == '1'){
                $('#codigo').val(value.codigo);
                $('#version').val(value.version);
                $('#horas').val(value.horas);
                $('#nombre').val(value.nombre);
                $("#estado > option[value="+value.estado+"]").attr("selected", "selected");
                $("#nivel > option[value="+value.nivel+"]").attr("selected", "selected");
                $("#modalidad > option[value="+value.modalidad+"]").attr("selected", "selected");
                $('#btnact').html('<button id="btncrearprograma" type="button" onClick="crearprograma(\''+id+'\');" class="btn btn-primary">Actualizar</button>');
                traerlespecialidad(value.idespecialidad);
              }else{
                $('#btnact').html('<button id="btncrearprograma" type="button" onClick="crearprograma(\'0\');" class="btn btn-primary">Guardar</button>');
              }
                
             });               
              
      });    
    }
    catch(ex){
        alert(ex);
    }  
  }       
}

function existeprograma(codigo){
  var parametros = {
    dato:'programas',
    request:'validar',   
    'codigo':codigo 
  };  
try{
      var html = '';  
      $.ajax({ //inicia la funcion ajax
      type:'POST', //tipo de envio: post o get como en un formulario web
      url:"../views/com/programascom.php", //url del archivo a llamar y que hace el procedimiento
      dataType:'html',
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php    
          console.log(data);
          var datosRecibidos = JSON.parse(data); 
            $.each(datosRecibidos, function(key,value) {
              if(value.respuesta == '1'){
                $('#codigo').val(value.codigo);
                $('#version').val(value.version);
                $('#horas').val(value.horas);
                $('#nombre').val(value.nombre);
                $("#estado > option[value="+value.estado+"]").attr("selected", "selected");
                $('#btnact').html('<button id="btncrearprograma" type="button" onclick="crearprograma(\''+value.id+'\');" class="btn btn-info">Actualizar</button>');
              }else{
                $('#btnact').html('<button id="btncrearprograma" type="button" onclick="crearprograma(\'0\');" class="btn btn-info">Crear</button>');
              }
             });                
              
      });
    }
    catch(ex){
        alert(ex);
    }  
}

function vtnmodalsm(){
var html = '';
html +='<div class="modal fade bd-example-modal-md" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
html +='  <div class="modal-dialog modal-md" role="document">';
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