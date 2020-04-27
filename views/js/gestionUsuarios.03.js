function listadoUsuarios1(){
  try{
  var cor = $('#correo').val();
  var con = $('#contrasena').val();
  var parametros = {
         'dato':'usuario', 
        'request':'listado'
  };  
  $.ajax({    
  url:"../views/com/usuariocom.php",
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

function listadoUsuarios(){
 var html = '';  
    html +=' <h4 class="h4 mb-4  text-muted">LISTADO DE USUARIOS</h4> ';
    html +='    <div class="table-responsive">';
    html +='   <table id="listaUsuarios" class="table table-sm table-bordered table-striped " style="width:100%">';
    html +='        <thead>';
    html +='            <tr>';
    html +='            <th>NOMBRE</th>';    
    html +='            <th>EDITAR</th>';       
    html +='            <th>USUARIO</th>';
    html +='            <th>COORDINACION</th>';    
    html +='            <th>ESTADO</th>';  
    html +='            <th>VICULACION</th>';    
    html +='            <th>ROL</th>';         
    html +='            <th>OTRO CORREO</th>';
    html +='            <th><i class="fas fa-key"></i></th>';     
    html +='            <th>TELEFONO</th>';               
    html +='            <th><i class="far fa-list-alt"></i></th>';
    html +='            </tr>';
    html +='        </thead>';
    html +='        <tbody>';
    html +='        </tbody>';
    html +='    </table>';
    html +='   </div>';
    $('#cuerpo').html(html);
    $('#listaUsuarios').DataTable({ 
             
    responsive: true,
    autoWidth: false,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 } 
        ],
    bDeferRender: true,     
    sPaginationType: "full_numbers",
    ajax: {
      url:"../views/com/usuariocom.php",
      type: "POST",
      data:{'dato':'usuario', 'request':'listado'},  
    },  
columns: [
    { "data": "nombre"}, 
    { "data": "editar"},
    { "data": "correosena"},
    { "data": "crnombre"}, 
    { "data": "estado"},   
    { "data": "vinculacion"},
    { "data": "instructor"},           
    { "data": "correootro"},
    { "data": "contrasena"},       
    { "data": "telefono"},  
    { "data": "permisos"}
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
    }
  }); 
} 
function instruEstado(idinstructor, estado){
 var nestado = '0';
 if(estado == '0'){
    nestado = '1';
 }   
  $('#btnestado'+idinstructor).attr('disabled', 'disabled');
  var parametros = {
      dato:'usuario',
      request:'estado', 
      idinstructor: idinstructor,
      nestado :nestado
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/usuariocom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      console.log(data);
      $('#btnestado'+idinstructor).attr('disabled', false);
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
                 $('#listaUsuarios').DataTable().ajax.reload(null, false);
              break;                 
            }
          
           });              
    });             
}

function chulear(perfil, idusuario, estado){
var boton = '';
 var nestado = '0';
 if(estado == '0'){
    nestado = '1';
 }   
  $('#btn'+perfil).attr('disabled', 'disabled'); 
  var parametros = {
      dato:'usuario',
      request:'chulearperfil', 
      idusuario:idusuario, 
      perfil: perfil,
      nestado :nestado
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/usuariocom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      $('#btn'+perfil).attr('disabled', false);
      var datosRecibidos = JSON.parse(data);
      $.each(datosRecibidos, function(key,value) { 
          switch(value.respuesta){
          case '5':
                swal("Programación Centro!", "Debe iniciar Sesión...", "warning");
                frmlogin();
          break;
          case '0':
                Command: toastr["info"]("Se desactivó el perfil <i class=\"far fa-square\"></i>");
                boton = '<button id=\"'+perfil+'\" type="button" class="btn btn-secondary btn-sm"  onClick="chulear(\''+perfil+'\','+idusuario+',\'0\');"><i class="far fa-square"></i></button>';                    
                $('#'+perfil).html(boton);
          break;              
          case '1':
                Command: toastr["info"]("Perfil activado <i class=\"far fa-check-square\"></i>");
                boton = '<button id=\"'+perfil+'\" type="button" class="btn btn-success btn-sm"  onClick="chulear(\''+perfil+'\','+idusuario+',\'1\');"><i class="far fa-check-square"></i></button>';
                $('#'+perfil).html(boton);
          break;                 
        }
        console.log(boton);
       });              
    });             
}

function ingresousuario(){
  try{
  var cor = $('#correo').val();
  var con = $('#contrasena').val();
  var parametros = {
        dato:'usuario',
        request:'ingreso', 
        'correo':cor,
        'contrasena':con
  };  
  $.ajax({    
  url:"../views/com/usuariocom.php",
  type:'POST',
  dataType:'html', //tipo de data que retorna
  data:parametros
  }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php  
    console.log(data);
    var datosRecibidos = JSON.parse(data); 
    $.each(datosRecibidos, function(key,value) {
      switch(value.respuesta){
        case '0':
        swal("¡Ingreso!", "No encuentro un usuario registrado con estos datos!!", "warning");
        break;
        case '1':
        switch(value.estado){
            case '1':
            swal("¡Que bien!", "Bienvenido!", "success"); 
            var binicio = '<span style="color:orange; bgcolor:gray;"><strong>'+value.nombre+'</strong></span>';
            $('#binicio').html(binicio);
            window.location = value.ruta;
            break;
            case '-1':
            //cerrarsuario();
            var mensaje = '<div class="bs-callout bs-callout-danger"><p>No se encontró un usuario con estas credenciales de ingreso, Gracias.</p></div>';
            $('#centro-content').html(mensaje);
            break;            
            case '0':
            //cerrarsuario();
            var mensaje = '<div class="bs-callout bs-callout-danger"><p>El usuario se encuentra suspendido, debe acercarse al centro de formación para que lo habiliten, Gracias.</p></div>';
            $('#centro-content').html(mensaje);
            break;
          }
        break;                
      }
    }); 
  });
    //setInterval('swal("¡Información!", "Cragaremos los proyectos que usted ha creado y en los que aparece como interante de equipo de proyecto, ok?", "info");',10);
    }catch(ex){
    alert(ex);
    }     
}
function editarUsuario(id){
  var html = '';
  html +='<form>';
  html +='  <div class="form-group">';
  html +='      <div class="row">';
  html +='        <div class="col col-12 col-md-4">';
  html +='        <label id="frmcorreosena" for="correosena" class="col-sm-12 col-form-label">Correo Sena<span id="sofia" style="color:green" ></span></label>';
  html +='        <div class="input-group mb-4">';
  html +='          <input id="correosena" type="text" class="form-control" maxlength="15">';
  html +='            <div class="input-group-append">';
  html +='             <span class="input-group-text" id="basic-addon2">@sena.edu.co</span>';
  html +='            </div>';
  html +='          </div>  ';
  html +='        </div> ';
  html +='      <script>';
  html +='            $(correosena).ready(function() {';
  html +='            $("#correosena").focusout(function(){  ';
  html +='                var dato = $(this).val(); ';
  html +='                validarcoredit(dato,\''+id+'\');';
  html +='              }) ';
  html +='             }).trigger;';
  html +='      </script> ';
  html +='    <div class="col col-12 col-md-8">';
  html +='    <label id="frmnombre"  for="nombre" class="col-sm-12 col-form-label">Nombre</label>';
  html +='      <input id="nombre" type="text" class="form-control">';
  html +='    </div>';
  html +='    </div>';
  html +='    <div class="row">';
  html +='      <div class="col col-12 col-md-6">';
  html +='        <label id="frmcorreootro" for="correootro" class="col-sm-12 col-form-label">Otro Correo<span id="sofia" style="color:green" ></span></label>';
  html +='        <div class="input-group mb-3">';
  html +='          <input id="correootro" type="text" class="form-control">';
  html +='          </div>  ';
  html +='      </div> ';
  html +='      <div class="col col-12 col-md-6">';
  html +='        <label id="frmtelefono" for="telefono" class="col-sm-12 col-form-label">Teléfono<span id="sofia" style="color:green" ></span></label>';
  html +='        <div class="input-group mb-3">';
  html +='          <input id="telefono" type="text" class="form-control" maxlength="15" onkeypress="return soloNumeros(event)" onpaste="return false">';
  html +='          </div>  ';
  html +='      </div> ';
  html +='      </div> '; 
  html +='    <div class="row">';
  html +='      <div class="col col-12 col-md-6">';
  html +='        <label id="frmvinculacion" for="vinculacion" class="col-sm-12 col-form-label">Vinculación<span id="sofia" style="color:green" ></span></label>';
  html +='        <select id="vinculacion" class="form-control">'; 
  html +='            <option value="1">Planta</option>';
  html +='            <option value="0">Contratista</option>'; 
  html +='        </select>'; 
  html +='      </div> ';
  html +='      <div class="col col-12 col-md-6">';
  html +='        <label id="frminstructor" for="instructor" class="col-sm-12 col-form-label">Disponible para formación<span id="sofia" style="color:green" ></span></label>';
  html +='        <select id="instructor" class="form-control">'; 
  html +='            <option value="1">Si</option>';
  html +='            <option value="0">No</option>'; 
  html +='        </select>'; 
  html +='      </div> ';   
  html +='      </div> ';       
  html +='    <div class="row">';  
  html +='      <div class="col col-12 col-md-6">';
  html +='        <label id="frmcoordinacion" for="coordinacion" class="col-sm-12 col-form-label">Coordinación<span id="sofia" style="color:green" ></span></label>';
  html +='        <div class="input-group mb-3">';
  html +='        <select id="coordinaciones" class="custom-select custom-select-sm">';
  html +='        </select>';
  html +='      <script>';
  html +='      getCoordinaciones();';
  html +='      </script> '; 
  html +='         </div>  ';
  html +='    </div>'; 
  html +='    </div>';
  html +='    <span id="btnact"><div class="d-flex p-2 bd-highlight"><button id="btncrearusuario" type="button" onClick="crearusuario()" class="btn btn-success btn-sm">Enviar <i class="far fa-paper-plane"></i></button></div></span>';
  html +='  <div id="msalida">';
  html +='  </div> ';
  html +='</form> '; 
    vtnmodalsm();  
    $('#myModalLabel').html('EDITAR USUARIO: ');
    $('#bodymodal').html(html);
    boton = '<button id="btncrearusuario" type="button" onClick="updateusuario(\''+id+'\');" class="btn btn-primary">Actualizar</button>';
    $("#btnact").html(boton);
    $('#myModal').modal('show'); 
    traerEditar(id);
}

function getCoordinaciones(){
  try{
  var parametros = {
        dato:'usuario',
        request:'coordinaciones'
  };  
  $.ajax({    
    url:"../views/com/usuariocom.php",
    type:'POST',
    dataType:'html', //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php  
             $('#coordinaciones').html(data);
        });
      }catch(ex){
    alert(ex);
    }     
}

function reestablecerUsuario(id, nombre, coordinacion){
var html = '';  
      html +='<div class="row">';
      html +='<div class="col-md-6">';
      html +='<div class="card" style="width: 18rem;">';
      html +=' <button type="button" id="btnnewpass" onCLick="nuevaContrasena('+id+');" class="btn btn-lg btn-danger">Generar Nueva Contraseña</button>';
      html +='</div> '; 
      html +='</div> ';
      html +='<div class="col-md-6">';
      html +='<div id="newpass"> </div>';
      html +='</div> '; 
      html +='</div> '; 
vtnmodalsm();  
      $('#myModalLabel').html('RESTAURAR PASSWORD : <strong>'+nombre+ '</strong> ('+coordinacion+')');
      $('#bodymodal').html(html);
      $('#myModal').modal('show');  

}

function nuevaContrasena(idusuario){  
  $('#btnnewpass').attr('disabled', 'disabled');
  var parametros = {
      dato:'usuario',
      request:'restablecer', 
      idusuario: idusuario
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../views/com/usuariocom.php",
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      $('#btnnewpass').attr('disabled', false);
      var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Programación Centro!", "Debe iniciar Sesión...", "warning");
                    frmlogin();
              break;
              case '0':
                    Command: toastr["warning"]("No se registró ningún cambio"); 
                    var newpass = '<div class="bs-callout bs-callout-danger"><p>Intente nuevamente, Gracias.</p></div> ';                  
                    $('#newpass').html(newpass);
              break;              
              case '1':
                 Command: toastr["success"]("Se registró la actualización");
                 var newpass = '<span style="color:blue; font-weight: bold; font-size: XX-large">'+value.newpass+'</span><br><div class="bs-callout bs-callout-info"><p>Esta es la nueva contraseña!</p></div>';
                 $('#newpass').html(newpass);
              break;                 
            }
          
           });              
    });             
}
function getPerfiles(idusuario, idcoordinacion, nombre, coordinacion){
  try{
      var parametros = {
            dato:'usuario',
            request:'getPerfiles',
            idusuario:idusuario,
            idcoordinacion:idcoordinacion
      };  
      $.ajax({    
        url:"../views/com/usuariocom.php",
        type:'POST',
        dataType:'html', //tipo de data que retorna
        data:parametros
        }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php  
         var datosRecibidos = JSON.parse(data); 
             $.each(datosRecibidos, function(key,value) {
               switch(value.respuesta){  
                 case '0':
                 swal("¡Ingreso!", "No había una sesión de usuario activa!!", "warning");
                 break;
                 case '1':
                  vtnmodalsm();  
                        $('#myModalLabel').html('PERMISOS USUARIO: <strong>'+nombre+ '</strong> ('+coordinacion+')');
                        $('#bodymodal').html(value.datos);
                        $('#myModal').modal('show');
                 break;                
               }
             });  
         });
      }catch(ex){
    alert(ex);
    }     
}

function crearusuario(){
$('#btncrearusuario').attr('disabled', 'disabled'); 
var correcto = '1';
var mensajeerror = '';
var correosena = $('#correosena').val();
var nombre = $('#nombre').val();
var correootro = $('#correootro').val();
var telefono = $('#telefono').val();
var instructor = '0';
var vinculacion = '0';
$("#vinculacion").change(function () {
    $("#vinculacion option:selected").each(function () {
      vinculacion = $(this).val();
        });
}).trigger('change');

$("#instructor").change(function () {
    $("#instructor option:selected").each(function () {
      instructor = $(this).val();
        });
}).trigger('change');

if(correosena.length < 0){
   correcto = '0';
   $('#frmcorreosena').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">El correo SENA es obligatorio.<p>';
}else{
   $('#frmcorreosena').removeClass('alert-danger');
   $('#frmcorreosena').addClass('alert-ligh');
}
if(correootro.length < 5 || validaremail(correootro) == 0){
   correcto = '0';
   $('#frmcorreootro').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Debe registrar otro correo y con un formato valido.<p>';
}else{
   $('#frmcorreootro').removeClass('alert-danger');
   $('#frmcorreootro').addClass('alert-ligh');
}

if(nombre.length < 5){
   correcto = '0';
   $('#frmnombre').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">El NOMBRE es un campo obligatorio.<p>';
}else{
   $('#frmnombre').removeClass('alert-danger');
    $('#frmnombre').addClass('alert-ligh');
}

if(telefono.length < 5){
   correcto = '0';
   $('#frmtelefono').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Debe registrar un numero telefónico.</p>';
}else{
   $('#frmtelefono').removeClass('alert-danger');
   $('#frmtelefono').addClass('alert-ligh');
}
if(correcto == '1'){
    var parametros = { 
      'dato':'usuario',
      'request':'crear',
      'correosena':correosena, 
      'nombre':nombre,
      'correootro':correootro,
      'telefono':telefono,
      'vinculacion':vinculacion,
      'instructor':instructor       
      
    };   
      $.ajax({ //inicia la funcion ajax
          type:"POST", //tipo de envio: post o get como en un formulario web
          url:"../views/com/usuariocom.php", //Trae datos para editar    
          dataType:"html", //tipo de data que retorna
          data:parametros
          }).done(function(data){
            console.log(data);
            var datosRecibidos = JSON.parse(data); 
            $.each(datosRecibidos, function(key,value) {
              if(value.respuesta == '1'){           
                window.location = value.ruta;
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
  $('#btncrearusuario').attr('disabled', false); 
}

function updateusuario(id){
$('#btncrearusuario').attr('disabled', 'disabled'); 
var correcto = '1';
var mensajeerror = '';
var idcoordinacion = '';
var correosena = $('#correosena').val();
var nombre = $('#nombre').val();
var correootro = $('#correootro').val();
var telefono = $('#telefono').val();

var instructor = '0';
var vinculacion = '0';
$("#vinculacion").change(function () {
    $("#vinculacion option:selected").each(function () {
      vinculacion = $(this).val();
        });
}).trigger('change');

$("#instructor").change(function () {
    $("#instructor option:selected").each(function () {
      instructor = $(this).val();
        });
}).trigger('change');


  $("#coordinaciones").change(function () {
      $("#coordinaciones option:selected").each(function () {
         idcoordinacion  = $(this).val();
      });
  }).trigger('change');  
if(correosena.length < 0){
   correcto = '0';
   $('#frmcorreosena').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">El correo SENA es obligatorio.<p>';
}else{
   $('#frmcorreosena').removeClass('alert-danger');
   $('#frmcorreosena').addClass('alert-ligh');
}
if(correootro.length < 5 || validaremail(correootro) == 0){
   correcto = '0';
   $('#frmcorreootro').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Debe registrar otro correo y con un formato valido.<p>';
}else{
   $('#frmcorreootro').removeClass('alert-danger');
   $('#frmcorreootro').addClass('alert-ligh');
}

if(nombre.length < 5){
   correcto = '0';
   $('#frmnombre').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">El NOMBRE es un campo obligatorio.<p>';
}else{
   $('#frmnombre').removeClass('alert-danger');
    $('#frmnombre').addClass('alert-ligh');
}

if(telefono.length < 5){
   correcto = '0';
   $('#frmtelefono').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Debe registrar un numero telefónico.</p>';
}else{
   $('#frmtelefono').removeClass('alert-danger');
   $('#frmtelefono').addClass('alert-ligh');
}
if(correcto == '1'){
    var parametros = { 
      'dato':'usuario',
      'request':'update',
      'id':id,
      'idcoordinacion':idcoordinacion, 
      'correosena':correosena, 
      'nombre':nombre,
      'correootro':correootro,
      'vinculacion':vinculacion,
      'instructor':instructor,
      'telefono':telefono
    };   
      $.ajax({ //inicia la funcion ajax
          type:"POST", //tipo de envio: post o get como en un formulario web
          url:"../views/com/usuariocom.php", //Trae datos para editar    
          dataType:"html", //tipo de data que retorna
          data:parametros
          }).done(function(data){
            console.log(data);
          var datosRecibidos = JSON.parse(data); 
             $.each(datosRecibidos, function(key,value) {
             switch(value.respuesta){
               case '0':
               swal("¡Ingreso!", "No había una sesión de usuario activa!!", "warning");
               break;
               case '1':
               Command: toastr["success"]("Registro autorizado correctamente."); 
               $('#listaUsuarios').DataTable().ajax.reload(null, false);
               break;                
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
  $('#btncrearusuario').attr('disabled', false); 
}

function traerEditar(id){
   var parametros = {
    dato:'usuario',
    request:'geteditar',   
    id:id 
    };  
      try{
        $.ajax({ //inicia la funcion ajax
        type:'POST', //tipo de envio: post o get como en un formulario web
        url:"../views/com/usuariocom.php",
        dataType:'html',
        data:parametros
        }).done(function(data){ 
          console.log(data);
         var datosRecibidos = JSON.parse(data); 
            $.each(datosRecibidos, function(key,value) {
            switch(value.respuesta){
              case '0':
              swal("¡Ingreso!", "No había una sesión de usuario activa!!", "warning");
              break;
              case '1':
                $('#correosena').val(value.correosena);
                $('#nombre').val(value.nombre);
                $('#correootro').val(value.correootro);
                $('#telefono').val(value.telefono);
                $('#coordinaciones > option[value="'+value.idcoordinacion+'"]').attr('selected', 'selected'); 
                $('#vinculacion > option[value="'+value.vinculacion+'"]').attr('selected', 'selected'); 
                $('#instructor > option[value="'+value.instructor+'"]').attr('selected', 'selected'); 
              break;                
            }
          });                
        });
      }
  catch(ex){
      alert(ex);
  } 
   
}
function validarcoredit(correosena, id){
if(correosena.length > 0){
  var parametros = {
    dato:'usuario',
    request:'validaredit',
    id:id,   
    correosena:correosena 
    };  
  try{
    $.ajax({ //inicia la funcion ajax
    type:'POST', //tipo de envio: post o get como en un formulario web
    url:"../views/com/usuariocom.php",
    dataType:'html',
    data:parametros
    }).done(function(data){   
    var datosRecibidos = JSON.parse(data); 
      $.each(datosRecibidos, function(key,value){
        if(value.respuesta == '1'){
          $('#btnact').hide();
            Command: toastr["warning"]("El usuario "+correosena+" ya existe.");
        }else{
          $('#btnact').show();
        }
       });                
    });
  }
  catch(ex){
      alert(ex);
  } 
  }else{
    aCommand: toastr["warning"]("El correo SENA es un dato obligatorio."); 
  } 
}

function validarcorreosena(correosena){
if(correosena.length > 0){
  var parametros = {
    dato:'usuario',
    request:'validar',   
    correosena:correosena 
    };  
  try{
    $.ajax({ //inicia la funcion ajax
    type:'POST', //tipo de envio: post o get como en un formulario web
    url:"../views/com/usuariocom.php",
    dataType:'html',
    data:parametros
    }).done(function(data){   
    var datosRecibidos = JSON.parse(data); 
      $.each(datosRecibidos, function(key,value){
        if(value.respuesta == '1'){
          $('#btnact').hide();
            Command: toastr["warning"]("El usuario "+correosena+" ya existe.");
        }else{
          $('#btnact').show();
        }
       });                
    });
  }
  catch(ex){
      alert(ex);
  } 
  }else{
    aCommand: toastr["warning"]("El correo SENA es un dato obligatorio."); 
  } 
}

function cerrarsuario(){
  try{
  var parametros = {
        dato:'usuario',
        request:'cerrar'
  };  
  $.ajax({    
    url:"../views/com/usuariocom.php",
    type:'POST',
    dataType:'html', //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php  
     var datosRecibidos = JSON.parse(data); 
        $.each(datosRecibidos, function(key,value) {
        switch(value.respuesta){
          case '0':
          swal("¡Ingreso!", "No había una sesión de usuario activa!!", "warning");
          break;
          case '1':
          window.location = value.ruta;
          break;                
        }
         }); 
        });
    //setInterval('swal("¡Información!", "Cragaremos los proyectos que usted ha creado y en los que aparece como interante de equipo de proyecto, ok?", "info");',10);
    }catch(ex){
    alert(ex);
    }     
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

function validaremail(email) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
        return '0';
      }else{
        return '1';
      }
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

function soloTelefono(e,nboton){ 
key =e.keyCode || e.which;
teclado = String.fromCharCode(key).toLowerCase();
letras = "0123456789";
especiales = "8-37-38-46-164";
teclado_especial = false;
for (var i in especiales){
  if(key==especiales[i]){
    teclado_especial=true;break;
  }  
}
if (key === 13) {
    document.getElementById(nboton).click();
} 
if(letras.indexOf(teclado)==-1 && !teclado_especial){
  return false;
   }   
}
Encoder = {

  // When encoding do we convert characters into html or numerical entities
  EncodeType : "entity",  // entity OR numerical

  isEmpty : function(val){
    if(val){
      return ((val===null) || val.length==0 || /^\s+$/.test(val));
    }else{
      return true;
    }
  },
  
  // arrays for conversion from HTML Entities to Numerical values
  arr1: ['&nbsp;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&sup1;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&AACUTE;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&EACUTE;','&Ecirc;','&Euml;','&Igrave;','&IACUTE;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&OACUTE;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&UACUTE;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&quot;','&amp;','&lt;','&gt;','&OElig;','&oelig;','&Scaron;','&scaron;','&Yuml;','&circ;','&tilde;','&ensp;','&emsp;','&thinsp;','&zwnj;','&zwj;','&lrm;','&rlm;','&ndash;','&mdash;','&lsquo;','&rsquo;','&sbquo;','&ldquo;','&rdquo;','&bdquo;','&dagger;','&Dagger;','&permil;','&lsaquo;','&rsaquo;','&euro;','&fnof;','&Alpha;','&Beta;','&Gamma;','&Delta;','&Epsilon;','&Zeta;','&Eta;','&Theta;','&Iota;','&Kappa;','&Lambda;','&Mu;','&Nu;','&Xi;','&Omicron;','&Pi;','&Rho;','&Sigma;','&Tau;','&Upsilon;','&Phi;','&Chi;','&Psi;','&Omega;','&alpha;','&beta;','&gamma;','&delta;','&epsilon;','&zeta;','&eta;','&theta;','&iota;','&kappa;','&lambda;','&mu;','&nu;','&xi;','&omicron;','&pi;','&rho;','&sigmaf;','&sigma;','&tau;','&upsilon;','&phi;','&chi;','&psi;','&omega;','&thetasym;','&upsih;','&piv;','&bull;','&hellip;','&prime;','&Prime;','&oline;','&frasl;','&weierp;','&image;','&real;','&trade;','&alefsym;','&larr;','&uarr;','&rarr;','&darr;','&harr;','&crarr;','&lArr;','&uArr;','&rArr;','&dArr;','&hArr;','&forall;','&part;','&exist;','&empty;','&nabla;','&isin;','&notin;','&ni;','&prod;','&sum;','&minus;','&lowast;','&radic;','&prop;','&infin;','&ang;','&and;','&or;','&cap;','&cup;','&int;','&there4;','&sim;','&cong;','&asymp;','&ne;','&equiv;','&le;','&ge;','&sub;','&sup;','&nsub;','&sube;','&supe;','&oplus;','&otimes;','&perp;','&sdot;','&lceil;','&rceil;','&lfloor;','&rfloor;','&lang;','&rang;','&loz;','&spades;','&clubs;','&hearts;','&diams;'],
  arr2: ['&#160;','&#161;','&#162;','&#163;','&#164;','&#165;','&#166;','&#167;','&#168;','&#169;','&#170;','&#171;','&#172;','&#173;','&#174;','&#175;','&#176;','&#177;','&#178;','&#179;','&#180;','&#181;','&#182;','&#183;','&#184;','&#185;','&#186;','&#187;','&#188;','&#189;','&#190;','&#191;','&#192;','&#193;','&#194;','&#195;','&#196;','&#197;','&#198;','&#199;','&#200;','&#201;','&#202;','&#203;','&#204;','&#205;','&#206;','&#207;','&#208;','&#209;','&#210;','&#211;','&#212;','&#213;','&#214;','&#215;','&#216;','&#217;','&#218;','&#219;','&#220;','&#221;','&#222;','&#223;','&#224;','&#225;','&#226;','&#227;','&#228;','&#229;','&#230;','&#231;','&#232;','&#233;','&#234;','&#235;','&#236;','&#237;','&#238;','&#239;','&#240;','&#241;','&#242;','&#243;','&#244;','&#245;','&#246;','&#247;','&#248;','&#249;','&#250;','&#251;','&#252;','&#253;','&#254;','&#255;','&#34;','&#38;','&#60;','&#62;','&#338;','&#339;','&#352;','&#353;','&#376;','&#710;','&#732;','&#8194;','&#8195;','&#8201;','&#8204;','&#8205;','&#8206;','&#8207;','&#8211;','&#8212;','&#8216;','&#8217;','&#8218;','&#8220;','&#8221;','&#8222;','&#8224;','&#8225;','&#8240;','&#8249;','&#8250;','&#8364;','&#402;','&#913;','&#914;','&#915;','&#916;','&#917;','&#918;','&#919;','&#920;','&#921;','&#922;','&#923;','&#924;','&#925;','&#926;','&#927;','&#928;','&#929;','&#931;','&#932;','&#933;','&#934;','&#935;','&#936;','&#937;','&#945;','&#946;','&#947;','&#948;','&#949;','&#950;','&#951;','&#952;','&#953;','&#954;','&#955;','&#956;','&#957;','&#958;','&#959;','&#960;','&#961;','&#962;','&#963;','&#964;','&#965;','&#966;','&#967;','&#968;','&#969;','&#977;','&#978;','&#982;','&#8226;','&#8230;','&#8242;','&#8243;','&#8254;','&#8260;','&#8472;','&#8465;','&#8476;','&#8482;','&#8501;','&#8592;','&#8593;','&#8594;','&#8595;','&#8596;','&#8629;','&#8656;','&#8657;','&#8658;','&#8659;','&#8660;','&#8704;','&#8706;','&#8707;','&#8709;','&#8711;','&#8712;','&#8713;','&#8715;','&#8719;','&#8721;','&#8722;','&#8727;','&#8730;','&#8733;','&#8734;','&#8736;','&#8743;','&#8744;','&#8745;','&#8746;','&#8747;','&#8756;','&#8764;','&#8773;','&#8776;','&#8800;','&#8801;','&#8804;','&#8805;','&#8834;','&#8835;','&#8836;','&#8838;','&#8839;','&#8853;','&#8855;','&#8869;','&#8901;','&#8968;','&#8969;','&#8970;','&#8971;','&#9001;','&#9002;','&#9674;','&#9824;','&#9827;','&#9829;','&#9830;'],   
  // Convert HTML entities into numerical entities
  HTML2Numerical : function(s){
    return this.swapArrayVals(s,this.arr1,this.arr2);
  },  
  // Convert Numerical entities into HTML entities
  NumericalToHTML : function(s){
    return this.swapArrayVals(s,this.arr2,this.arr1);
  },

  // Numerically encodes all unicode characters
  numEncode : function(s){ 
    if(this.isEmpty(s)) return ""; 

    var a = [],
      l = s.length; 
    
    for (var i=0;i<l;i++){ 
      var c = s.charAt(i); 
      if (c < " " || c > "~"){ 
        a.push("&#"); 
        a.push(c.charCodeAt()); //numeric value of code point 
        a.push(";"); 
      }else{ 
        a.push(c); 
      } 
    } 
    
    return a.join("");  
  }, 
  
  // HTML Decode numerical and HTML entities back to original values
  htmlDecode : function(s){

    var c,m,d = s;
    
    if(this.isEmpty(d)) return "";

    // convert HTML entites back to numerical entites first
    d = this.HTML2Numerical(d);
    
    // look for numerical entities &#34;
    arr=d.match(/&#[0-9]{1,5};/g);
    
    // if no matches found in string then skip
    if(arr!=null){
      for(var x=0;x<arr.length;x++){
        m = arr[x];
        c = m.substring(2,m.length-1); //get numeric part which is refernce to unicode character
        // if its a valid number we can decode
        if(c >= -32768 && c <= 65535){
          // decode every single match within string
          d = d.replace(m, String.fromCharCode(c));
        }else{
          d = d.replace(m, ""); //invalid so replace with nada
        }
      }     
    }

    return d;
  },    

  // encode an input string into either numerical or HTML entities
  htmlEncode : function(s,dbl){
      
    if(this.isEmpty(s)) return "";

    // do we allow double encoding? E.g will &amp; be turned into &amp;amp;
    dbl = dbl || false; //default to prevent double encoding
    
    // if allowing double encoding we do ampersands first
    if(dbl){
      if(this.EncodeType=="numerical"){
        s = s.replace(/&/g, "&#38;");
      }else{
        s = s.replace(/&/g, "&amp;");
      }
    }

    // convert the xss chars to numerical entities ' " < >
    s = this.XSSEncode(s,false);
    
    if(this.EncodeType=="numerical" || !dbl){
      // Now call function that will convert any HTML entities to numerical codes
      s = this.HTML2Numerical(s);
    }

    // Now encode all chars above 127 e.g unicode
    s = this.numEncode(s);

    // now we know anything that needs to be encoded has been converted to numerical entities we
    // can encode any ampersands & that are not part of encoded entities
    // to handle the fact that I need to do a negative check and handle multiple ampersands &&&
    // I am going to use a placeholder

    // if we don't want double encoded entities we ignore the & in existing entities
    if(!dbl){
      s = s.replace(/&#/g,"##AMPHASH##");
    
      if(this.EncodeType=="numerical"){
        s = s.replace(/&/g, "&#38;");
      }else{
        s = s.replace(/&/g, "&amp;");
      }

      s = s.replace(/##AMPHASH##/g,"&#");
    }
    
    // replace any malformed entities
    s = s.replace(/&#\d*([^\d;]|$)/g, "$1");

    if(!dbl){
      // safety check to correct any double encoded &amp;
      s = this.correctEncoding(s);
    }

    // now do we need to convert our numerical encoded string into entities
    if(this.EncodeType=="entity"){
      s = this.NumericalToHTML(s);
    }

    return s;         
  },

  // Encodes the basic 4 characters used to malform HTML in XSS hacks
  XSSEncode : function(s,en){
    if(!this.isEmpty(s)){
      en = en || true;
      // do we convert to numerical or html entity?
      if(en){
        s = s.replace(/\'/g,"&#39;"); //no HTML equivalent as &apos is not cross browser supported
        s = s.replace(/\"/g,"&quot;");
        s = s.replace(/</g,"&lt;");
        s = s.replace(/>/g,"&gt;");
      }else{
        s = s.replace(/\'/g,"&#39;"); //no HTML equivalent as &apos is not cross browser supported
        s = s.replace(/\"/g,"&#34;");
        s = s.replace(/</g,"&#60;");
        s = s.replace(/>/g,"&#62;");
      }
      return s;
    }else{
      return "";
    }
  },

  // returns true if a string contains html or numerical encoded entities
  hasEncoded : function(s){
    if(/&#[0-9]{1,5};/g.test(s)){
      return true;
    }else if(/&[A-Z]{2,6};/gi.test(s)){
      return true;
    }else{
      return false;
    }
  },

  // will remove any unicode characters
  stripUnicode : function(s){
    return s.replace(/[^\x20-\x7E]/g,"");
    
  },

  // corrects any double encoded &amp; entities e.g &amp;amp;
  correctEncoding : function(s){
    return s.replace(/(&amp;)(amp;)+/,"$1");
  },


  // Function to loop through an array swaping each item with the value from another array e.g swap HTML entities with Numericals
  swapArrayVals : function(s,arr1,arr2){
    if(this.isEmpty(s)) return "";
    var re;
    if(arr1 && arr2){
      //ShowDebug("in swapArrayVals arr1.length = " + arr1.length + " arr2.length = " + arr2.length)
      // array lengths must match
      if(arr1.length == arr2.length){
        for(var x=0,i=arr1.length;x<i;x++){
          re = new RegExp(arr1[x], 'g');
          s = s.replace(re,arr2[x]); //swap arr1 item with matching item from arr2  
        }
      }
    }
    return s;
  },

  inArray : function( item, arr ) {
    for ( var i = 0, x = arr.length; i < x; i++ ){
      if ( arr[i] === item ){
        return i;
      }
    }
    return -1;
  }

}