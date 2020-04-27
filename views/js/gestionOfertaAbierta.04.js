function nuevaFichaOfertaAbierta(){
  try{
    $('#btnnficha').attr('disabled', 'disabled'); 
     var parametros = { 
      dato:'formacion',
      request:'ofertaabierta'
      };      
      $.ajax({
      url: '../views/com/formacioncom.php',
      type:'POST',
      dataType:'html',
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php 
        $('#btnnficha').attr('disabled', false); 
        var datosRecibidos = JSON.parse(data);                  
        $.each(datosRecibidos, function(key,value) { 
        html = '';    
        switch(value.respuesta){   
            case '0':
               Command: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                Command: toastr["success"]("El registro se aplicó correctamente"); 
                listOfertaAbierta(); 
               break;   
            case '3':
                $('#placebtnnficha').html('El usuario tiene procesos administrativos pendientes por gestionar.');
                $('#btnnficha').removeClass('btn-success');
                $('#btnnficha').addClass('btn-danger');
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

function listOfertaAbierta(){
  var parametros = {
      dato:'formacion',
      request:'listOa'
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){
        $('#centro-content').html(data);
    });
}

function eliminarficha(id){
 $('#btneficha'+id).attr('disabled', 'disabled'); 
  try{
     var parametros = { 
      dato:'formacion',
      request:'eliminar',
      id:id
      };      
      $.ajax({
      url:"../views/com/formacioncom.php",
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php  
        console.log(data);
       var datosRecibidos = JSON.parse(data);  
        $('#btneficha'+id).attr('disabled', false);                  
        $.each(datosRecibidos, function(key,value) { 
        html = '';    
        switch(value.respuesta){   
            case '0':
               Command: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                $('#formacion'+id).hide('slow'); 
                Command: toastr["success"]("Registro actualizado");
                listOfertaAbierta();
               break;                                            
            case '5':
               //frmlogin();
               break;
           }   
        });                     
    }); 
  }catch(ex){
    alert(ex);
  }    
}

function elifichaconfirma(id){
 $('#btneficha'+id).attr('disabled', 'disabled');   
  try{
   var parametros = { 
      'id':id
    };  
 swal({
  title: "Confirme Por favor!!!",
  text: "Desea eliminar esta ficha?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Si, Borrar!",
  cancelButtonText: "No, Prefiero Cancelar la solicitud!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm){
  if (isConfirm) {
     var parametros = { 
      dato:'formacion',
      request:'eliminar',
      id:id
      };      
      $.ajax({
      url:"../views/com/formacioncom.php",
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php  
        console.log(data);
       var datosRecibidos = JSON.parse(data);  
        $('#btneficha'+id).attr('disabled', false);                  
        $.each(datosRecibidos, function(key,value) { 
        html = '';    
        switch(value.respuesta){   
            case '0':
               aCommand: toastr["info"]("No hay cambios registrados"); 
               listOfertaAbierta();
               break;                  
            case '1':
                aCommand: toastr["success"]("El registro se eliminó correctamente"); 
                listOfertaAbierta();
               break;                                            
            case '5':
               //frmlogin();
               break; 
           }   
        });
        $('#btneficha'+id).attr('disabled', false);                      
    });     
    swal("Eliminar!", "Esta ficha se borrará y no será visible a partir de este momento.", "success");
  } else {
    swal("Cancelar", "No eliminar la ficha.", "error");
  }
});
}catch(ex)
  {
      alert(ex);
  }  
}

function tablaCursos(idficha, idempresa){
 var html = ''; 
    html +='<div class="container">';
    html +='<div class="row">';
    html +='<div class="col col-12">';

    html +=' <h4 class="h4 mb-4  text-muted">LISTADO DE CURSOS CORTOS</h4> ';
    html +='    <div class="table-responsive">';
    html +='   <table id="formaciones" class="table table-sm table-bordered table-striped " style="width:100%">';
    html +='        <thead>';
    html +='            <tr>';
    html +='                <th>Codigo</th>';
    html +='                <th>Nombre</th>';
    html +='                <th>Version</th>';
    html +='                <th>Horas</th>';
    html +='                <th>Estado</th>';
    html +='                <th>Acciones</th>';
    html +='            </tr>';
    html +='        </thead>';
    html +='        <tbody>';
    html +='        </tbody>';
    html +='    </table>';
    html +='   </div>';
    html +='   </div>';
    html +='   </div>'; 
    html +='   </div>'; 

vtnmodalsm();  
$('#myModalLabel').html('FORMACIONES'); 
$('#bodymodal').html(html);
$('#myModal').modal('show'); 
$('#formaciones').DataTable( { 
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
  data:{'dato':'formacion', 'request':'tabla','idficha':idficha,'idempresa':idempresa},  
},  
columns: [
  { "data": "codigo" },
  { "data": "nombre" },
  { "data": "version" },
  { "data": "horas" },
  { "data": "estado" },    
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

function vtnmodalsm(){
var html = '';
html +='<div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
html +='  <div class="modal-dialog modal-xl" role="document">';
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

function selCurso(idficha, idcurso, idempresa, horas){
     var parametros = { 
      dato:'formacion',
      request:'seleccionar',
      horas:horas,
      idficha:idficha,
      idcurso:idcurso
      };      
      $.ajax({
      url: '../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){
        var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {         
        switch(value.respuesta){   
            case '0':
               aCommand: toastr["info"]("No hay cambios registrados"); 
               //listFormaciones(idempresa);
               break;                  
            case '1':
                aCommand: toastr["success"]("El registro se actualizó correctamente"); 
                listOfertaAbierta();
                $('#myModal').modal('hide');
               break;                                            
            case '5':
               //frmlogin();
               break;
           }   
        });               
        });  
}

function editarFicha(id, idDepto, idCiudad){
var html = '<form>'; 
  html +='      <div class="form-group">';
  html +='          <div class="row">';
  html +='            <div class="col col-12 col-md-6">';
  html +='            <label id="frmlugar" for="lugar" class="col-sm-12 col-form-label">NOMBRE DEL AMBIENTE DONDE SE ORIENTARÁ LA FORMACIÓN:</label>';
  html +='              <input id="lugar" type="text" class="form-control">';
  html +='            </div>';  
  html +='            <div class="col col-12 col-md-6">';
  html +='            <label id="frmdirformacion" for="dirformacion" class="col-sm-12 col-form-label">DIRECCION DONDE SE ORIENTARÁ LA FORMACIÓN:</label>';
  html +='              <input id="dirformacion" type="text" class="form-control">';
  html +='            </div>';  
  html +='           </div>'; 
  html +='          <div class="row">';
  html +='            <div class="col-12 col-md-6">';
  html +='            <label id="frmdepto" for="depto" class="col-sm-12 col-form-label">Departamento :</label>';
  html +='             <select id="depto" class="form-control">'; 
  html +='             </select>'; 
  html +='            </div>';
  html +='            <div class="col-12 col-md-6">';
  html +='            <label id="frmciudad" for="ciudad" class="col-sm-12 col-form-label">Ciudad :</label>';
  html +='             <select id="ciudad" class="form-control">'; 
  html +='             </select>'; 
  html +='            </div>';
  html +='          </div>';
  html +='          <div class="row">';
  html +='            <div class="col col-12 col-md-6">';
  html +='            <label id="frmnaprendices" for="naprendices" class="col-sm-12 col-form-label">Numero de Aprendices :</label>';
  html +='            <input id="naprendices" type="text" onkeypress="return soloNumeros(event)" class="form-control" value="30">';
  html +='            </div>';
  html +='            <div class="col col-12 col-md-6">';
  html +='            <label id="frmpespeciales" for="programa" class="col-sm-12 col-form-label">Programa :</label>';
  html +='              <select id="pespeciales" class="form-control">';
  html +='              </select>'; 
  html +='            </div>';
  html +='          </div>';
  html +='        </form>';
  html+='<script>'; 
  html+=' traerldepto('+idDepto+');'; 
  html+=' traerPespeciales();';  
  html+=' traerlciudad('+idDepto+','+idCiudad+');'; 
  html+='$(document).ready(function() {';
     html+='$("#depto").change(function(){';
          html+='var dato = $(this).val(); ';
          html+=' traerlciudad(dato,\'0\');';                            
     html+=' }) ';
     html+=' }).trigger;';                        
    html+='</script>';  
  html +='<div id="msalida">';
  html +='</div>';
  vtnmodalsm();  
  $('#myModalLabel').html('DATOS DE LA FORMACIÓN: <br><br><span id="placenonbase"> </span> <span id="placeonbase"> </span>');
  $('#bodymodal').html(html);
  var boton = '<button type="button" onClick="updateFicha('+id+');" class="btn btn-info">Guardar</button>';
  $('#btnact').html(boton);
  $('#myModal').modal('show'); 
  var parametros={ 
    dato:'formacion',
    request:'traerdcurso', 
    id:id
  }  
  $.ajax({ //inicia la funcion ajax
  type:"POST", //tipo de envio: post o get como en un formulario web
  url: '../views/com/formacioncom.php',//Trae datos para editar    
  dataType:"html", //tipo de data que retorna
  data:parametros
  }).done(function(data){
    console.log(data);
      var datosRecibidos = JSON.parse(data); 
      var lugar = '';
      var onbase = '';
      var val_onbase = '';
      $.each(datosRecibidos, function(key,value) { 
        if(value.respuesta == '1'){
          $("#depto > option[value="+value.depto+"]").attr("selected","selected");
          lugar = value.lugar;
 
          lugar = lugar.toUpperCase();
          //$("#placeonbase").html(tonbase); 
          $("#lugar").val(lugar); 
          $("#dirformacion").val(value.dirformacion);
          $("#naprendices").val(value.naprendices);
          $("#pespeciales > option[value="+value.pespeciales+"]").attr("selected","selected");
          $("#ciudad > option[value="+value.ciudad+"]").attr("selected","selected");
        }
    });
  });
}
function traerldepto(idDepto){
  var parametros = {
      dato:'depto',
      request:'select' 
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/empresacom.php", //url del archivo a llamar y que hace el procedimiento
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
                    swal("Programación Centro!", "No hay Departamentos creadas o activos", "warning");                    
              break;              
              case '1':
                  $('#depto').html(value.datos);  
                  $("#depto > option[value="+idDepto+"]").attr("selected", "selected");
              break;                 
            }
          
           });              
    });             
}

function traerlciudad(idDepto, idCiudad){
    var parametros = {
        dato:'ciudad',
        request:'select',     
        idDepto:idDepto
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/empresacom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php 
        console.log(data); 
      var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Programación Centro!", "Debe iniciar Sesión...", "warning");
                    frmlogin();
              break;
              case '0':
                    swal("Programación Centro!", "No hay Departamentos creadas o activos", "warning");                    
              break;              
              case '1':
                  $('#ciudad').html(value.datos); 
                  $("#ciudad > option[value="+idCiudad+"]").attr("selected", "selected"); 
              break;                 
            }
           });   
    });             
}

function traerPespeciales(){
      var parametros = {
        dato:'pespeciales',
        request:'list' 
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url: '../views/com/formacioncom.php', //url del archivo a llamar y que hace el procedimiento
    dataType:"html",
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
                    swal("Programación Centro!", "No hay programas especiales creados o activos", "warning");                    
              break;              
              case '1':
                  $('#pespeciales').html(value.datos); 
                  $("#pespeciales > option[value="+value.id+"]").attr("selected", "selected"); 
              break;                 
            }
           });   
    });

}
function updateFicha(id){
$('#btnact').attr('disabled','disabled');
var correcto = '1';
var mensajeerror = '';
var lugar = $('#lugar').val();
var dirformacion = $('#dirformacion').val();
var naprendices = $('#naprendices').val();
var ciudad = '0';
var depto = '0';
var pespeciales = '0';
$("#depto").change(function () {
    $("#depto option:selected").each(function () {
      depto = $(this).val();
        });
}).trigger('change'); 
$("#ciudad").change(function () {
    $("#ciudad option:selected").each(function () {
      ciudad = $(this).val();
        });
}).trigger('change'); 

$("#pespeciales").change(function () {
    $("#pespeciales option:selected").each(function () {
      pespeciales = $(this).val();
        });
}).trigger('change'); 

if(lugar.length < 2){
   correcto = '0';
   $('#frmlugar').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Debe escribir el lugar donde se orientará la formación.<p>';
}else{
   $('#frmlugar').removeClass('alert-danger');
   $('#frmlugar').addClass('alert-ligh');
}

if(dirformacion.length < 2){
   correcto = '0';
   $('#frmdirformacion').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Debe escribir la dirección del sitio donde se orientará la formación.<p>';
}else{
   $('#frmdirformacion').removeClass('alert-danger');
   $('#frmdirformacion').addClass('alert-ligh');
}
if(isNaN(naprendices) == true){
    naprendices = 0;
}
if(parseInt(naprendices, 10) < 1 ){
   correcto = '0';
   $('#frmnaprendices').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Olvidó escribir la cantidad de Aprendices.<p>';
}else{
   $('#frmnaprendices').removeClass('alert-danger');
   $('#frmnaprendices').addClass('alert-ligh');
}
if(depto == '0'){
   correcto = '0';
   $('#frmdepto').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Debe seleccionar el Departamento.<p>';
}else{
   $('#frmdepto').removeClass('alert-danger');
   $('#frmdepto').addClass('alert-ligh');
}
if(ciudad == '0'){
   correcto = '0';
   $('#frmciudad').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Es necesario seleccionar la ciudad donde se dará la formación.<p>';
}else{
   $('#frmciudad').removeClass('alert-danger');
   $('#frmciudad').addClass('alert-ligh');
}
if(correcto == '1'){
    $('#btnact').attr('disabled', 'disabled');
    var parametros={ 
      dato:'formacion',
      request:'update', 
      id:id,
      dirformacion: dirformacion,
      lugar: lugar,
      naprendices: naprendices,
      ciudad: ciudad,
      depto: depto,
      pespeciales: pespeciales,       
    };   
      $.ajax({ //inicia la funcion ajax
          type:"POST", //tipo de envio: post o get como en un formulario web
          url: '../views/com/formacioncom.php',//Trae datos para editar    
          dataType:"html", //tipo de data que retorna
          data:parametros
          }).done(function(data){ 
              listOfertaAbierta();
              $('#myModal').modal('hide');            
              $('#msalida').html('');
          });     
  }else{
     $('#btnact').attr('disabled', false);
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

}

function mostrarCalendario(idficha){
  $('#btncal'+idficha).attr('disabled', 'disabled');
  var html = ''; 
          html +='<h5 class="card-title">Franja</h5>';
          html +='<form class="form-group"> ';
          html +='<div class="form-group mb-2"> ';  
          html +='<label for="inicia" class="col-form-label"><span class="h5">Inicia</span></label> ';
          html +='<select id="inicia" class="form-control form-control-sm"> ';
          for (var i = 6; i < 24; i++) {
            html +='<option value="'+i+'">'+i+':00</option>';
          }
          html +='</select>';
          html +='</div>';
          html +='<label for="finaliza" class="col-form-label"><span class="h5">Finaliza</span></label>';
          html +='<select id="finaliza" class="form-control form-control-sm">';
          html +='</select>';
          html +='</div>';
          html +='</form>'; 
          html +='<button type="button" onClick="resetDias('+idficha+');" class="btn btn-secondary">Desmarcar calendario</button>' ;  
           html +='<script>'; 
           html +=' $(document).ready(function() {';
           html +='   $("#inicia").change(function(){';
           html +='      var dato = $(this).val();';       
           html +='       llenarfinaliza(dato);';
           html +='     })';
           html +='    }).trigger; ';       
         html +='</script>'; 
    calendariomodalsm();
    resetDias(idficha);
    $('#myModal').modal('show'); 
         $("#encabezado").html(html); 
         $('#btncal'+idficha).attr('disabled', false);
         llenarfinaliza(6);   
         programacion(idficha);                             
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


function resetDias(idficha){
    var espera =''; 
        espera += '<div class="spinner-grow text-secondary float-right" role="status">';
        espera += '  <span class="sr-only">Loading...</span>';
        espera += '</div>';   
    $('#myModalLabel').html('CALENDARIO '+ espera);
    var html = '';
    var parametros = {
        dato:'calendario',
        request:'select',
        idficha:idficha, 
        idempresa:'0'
      }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      //var datosRecibidos = JSON.parse(data); 
        $('#myModalLabel').html('CALENDARIO ');
        $('#bodymodal').html(data);
    });        
}

function calendariomodalsm(){
var html = '';
html +='<div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
html +='  <div class="modal-dialog modal-xl" role="document">';
html +='    <div class="modal-content">';
html +='      <div class="modal-header">';
html +='        <h5 class="modal-title" id="myModalLabel">New message</h5>';
html +='        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
html +='          <span aria-hidden="true">&times;</span>';
html +='        </button>';
html +='      </div>';
html +='<div class="row">'; 
html +='<div class="col-12">';
html +=' <div class="card bg-ligh mb-3" id="programacion">';
html +=' </div>';
html +='<div class="mb-3 my-4 " style="width: 80%;">';
html +='  <div id="encabezado" class="card-body">';
html +='  </div>';
html +='   </div>';
html +='</div>';
html +='</div>';
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

function llenarfinaliza(desde){
var html = ""; 
var inicio = 0;
inicio = parseInt(desde) + 1; 
  for(var i = inicio ; i < 25; i++) {
    html += "<option value='"+i+"'>"+i+":00</option>";
  }
  $("#finaliza").html(html); 
}

function hfranja(finaliza){
   var inicia = 0;
    $("#inicia").change(function () {
      $("#inicia option:selected").each(function () {
        inicia = $(this).val();
      });
    }).trigger('change'); 
    var horas = parseInt(finaliza) - parseInt(inicia);
    $('#horas').html(horas);
}

function programacion(idficha){
  var parametros = {
      dato:'programacion',
      request:'lista',
      idficha:idficha 
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      $('#programacion').html(data);
    });        
}

function selCalendario(idficha, ano, mes, dia, ds, festivo){
//Retoma el valor del usuario para vincularlo en la tabla porgramacion
  var  idusuario = $("#usID").text();

  $('#b'+mes+'_'+dia).attr('disabled', 'disabled');
  $('#'+mes+'_'+dia).removeClass('btn-outline-warning');
  $('#'+mes+'_'+dia).removeClass('btn-outline-success');
  var inicia = $("#inicia").val();
  var finaliza = $("#finaliza").val();
  var parametros = {
      dato:'calendario',
      request:'sel',
      idficha:idficha,
      inicia:inicia,
      finaliza:finaliza,
      ano:ano,
      mes:mes,
      dia: dia,
      ds:ds,
      festivo:festivo,
      idInstructor:idusuario
     }
      $.ajax({
      url: '../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php  
        console.log(data);
       var datosRecibidos = JSON.parse(data);  
        $('#btnnficha').attr('disabled', false);                  
        $.each(datosRecibidos, function(key,value){ 
        html = '';    
        switch(value.respuesta){   
            case '0':
               aCommand: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                var boton = '';
                boton +='<button id="d'+mes+'_'+dia+'" ';
                boton +='onClick="unselCalendario('+idficha+','+ano+','+mes+','+dia+','+ds+','+inicia+','+finaliza+','+festivo+')"';
                boton +=' class="btn btn-outline-default btn-sm" ';
                boton +=' type="button">'+dia+' <i class="far fa-calendar-times"></i></button>';            
                $('#b'+mes+'_'+dia).html(boton); 
                programacion(idficha);     
               break;                                            
            case '5':
               //frmlogin();
               break;
           }   
        }); 

    }); 
  
}


function unselProgramacion(idficha, ano, mes, dia, ds, inicia, finaliza, festivo){
  $('#b'+mes+'_'+dia).attr('disabled', 'disabled');
  console.log(mes+' '+dia+' '+ds+' '+festivo);
  $('#'+mes+'_'+dia).removeClass('btn-outline-warning');
  $('#'+mes+'_'+dia).removeClass('btn-outline-success');
  var boton = '';
  if(ds == 0 || festivo == '1'){
    boton +='<button id="d'+mes+'_'+dia+'" onClick="selCalendario('+idficha+','+ano+','+mes+','+dia+','+ds+','+festivo+')"';
    boton +=' class="btn btn-outline-danger btn-sm" type="button">'+dia+'</button>';
  }else{
    boton +='<button id="d'+mes+'_'+dia+'" onClick="selCalendario('+idficha+','+ano+','+mes+','+dia+','+ds+','+festivo+')"';
    boton +=' class="btn btn-outline-success btn-sm" type="button">'+dia+'</button>';
  } 
   var parametros = {
      dato:'calendario',
      request:'unsel',
      idficha:idficha,
      inicia:inicia,
      finaliza:finaliza, 
      ano:ano,
      mes:mes,
      dia: dia,
      ds:ds,
      festivo:festivo
     }
      $.ajax({
      url: '../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php  
       var datosRecibidos = JSON.parse(data);  
        $('#btnnficha').attr('disabled', false);                  
        $.each(datosRecibidos, function(key,value){ 
        html = '';    
        switch(value.respuesta){   
            case '0':
               aCommand: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                programacion(idficha); 
                $('#b'+mes+'_'+dia).html(boton);
               break;                                            
            case '5':
               //frmlogin();
               break;
           }   
        }); 

    }); 
  
}

function solpublicarficha(idFicha){
 $('#btnscficha'+idFicha).attr('disabled', 'disabled'); 
   var parametros = {
      dato:'formacion',
      request:'solcrear',
      idficha: idFicha
     }
      $.ajax({
      url: '../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php 
        console.log(data);
        listOfertaAbierta(); 
  
    }); 
}
function soloNumeros(e){
    key =e.keyCode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letras = "0123456789";
    especiales = "8-37-38-46-164";
    teclado_especial = false;
        for (var i in especiales){
          if(key==especiales[i]){
            teclado_especial=true;break;
          }
          if(letras.indexOf(teclado)==-1 && !teclado_especial){
          return false;
           }
        }
}

function solValidarFicha(idFicha){
 $('#btnsdficha'+idFicha).attr('disabled', 'disabled'); 
   var parametros = {
      dato:'formacion',
      request:'solvalidar',
      idficha: idFicha
     }
      $.ajax({
      url: '../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php 
      listOfertaAbierta();       
      $('#btnsdficha'+idFicha).attr('disabled', false);
       var datosRecibidos = JSON.parse(data);            
        $.each(datosRecibidos, function(key,value){ 
          aCommand: toastr[value.tipo](value.mensaje);
      });
    }); 
}

function verValidacion(idFicha, idempresa){
 $('#btnsficha'+idFicha).attr('disabled', 'disabled'); 
 var html = '';
 var orden = 0;
   var parametros = {
      dato:'formacion',
      request:'vervalidacion',
      idficha: idFicha
     }
      $.ajax({
      url: '../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php 
        $('#btnsficha'+idFicha).attr('disabled', false); 
        listOfertaAbierta();  
       var datosRecibidos = JSON.parse(data);      
       var tdatosRecibidos = datosRecibidos[0];
       html += '<table class="table table-sm table-striped">'; 
       html += ' <thead>'; 
       html += '<tr  class="table-secondary">';
       html += '  <th scope="col">#</th>';
       html += '  <th scope="col">Novedad</th>';
       html += '</tr>            ';
       html += '</thead>'; 
       html += ' <tbody>'; 
        $.each(tdatosRecibidos, function(key,value){ 
          orden = orden + 1;
          html += '<tr>';
          html += ' <td scope="row">'+orden+'</td>';
          html += ' <td>'+value.mensaje+'</td>';
          html += '</tr>';
        });
       html += ' <tbody>';         
       html += '</table">'; 
         vtnmodalsm();  
          $('#myModalLabel').html('DATOS DE LA VALIDACION');
          $('#bodymodal').html(html);
          $('#myModal').modal('show'); 
    }); 
}

function unselCalendario(idficha, ano, mes, dia, ds, inicia, finaliza, festivo){
  //Retoma el valor del usuario para vincularlo en la tabla porgramacion
  var  idusuario = $("#usID").text();

  $('#b'+mes+'_'+dia).attr('disabled', 'disabled');
  console.log(mes+' '+dia+' '+ds+' '+festivo);
  $('#'+mes+'_'+dia).removeClass('btn-outline-warning');
  $('#'+mes+'_'+dia).removeClass('btn-outline-success');
  var boton = '';
    if(ds == 0 || festivo == '1'){
        boton +='<button id="d'+mes+'_'+dia+'" onClick="selCalendario('+idficha+','+ano+','+mes+','+dia+','+ds+','+festivo+')"';
        boton +=' class="btn btn-outline-danger btn-sm" type="button">'+dia+'</button>';
    }else{
        boton +='<button id="d'+mes+'_'+dia+'" onClick="selCalendario('+idficha+','+ano+','+mes+','+dia+','+ds+','+festivo+')"';
        boton +=' class="btn btn-outline-success btn-sm" type="button">'+dia+'</button>';
    } 
     var parametros = {
        dato:'calendario',
        request:'unsel',
        idficha:idficha,
        inicia:inicia,
        finaliza:finaliza,
        ano:ano,
        mes:mes,
        dia: dia,
        ds:ds,
        festivo:festivo,
        idInstructor:idusuario
       }
      $.ajax({
      url: '../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php  
       var datosRecibidos = JSON.parse(data);  
        $('#btnnficha').attr('disabled', false);                  
        $.each(datosRecibidos, function(key,value){ 
        html = '';    
        switch(value.respuesta){   
            case '0':
               aCommand: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                 $('#b'+mes+'_'+dia).html(boton);
                 programacion(idficha);
               break;                                            
            case '5':
               //frmlogin();
               break;
           }   
        }); 

    }); 
  
}
