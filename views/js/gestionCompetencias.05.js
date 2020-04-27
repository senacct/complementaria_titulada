function listarCompetencias1(){
  try{
  var cor = $('#correo').val();
  var con = $('#contrasena').val();
  var parametros = {
     'dato':'titulada', 
     'request':'lcompetencias'
  };  
  $.ajax({    
  url:"../views/com/tituladacom.php",
  type:'POST',
  dataType:'html', //tipo de data que retorna
  data:parametros
  }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php  
      $('#cuerpo').html(data);
     
      });
         //setInterval('swal("¡Información!", "Cragaremos los proyectos que usted ha creado y en los que aparece como interante de equipo de proyecto, ok?", "info");',10);
    }catch(ex){
      alert(ex);
  }     
}

function listarCompetencias(){
 var html = '';  
    html +=' <div class="table-responsive">';
    html +='  <table id="competencias" class="table table-sm table-bordered table-striped">';
    html +='     <thead>';
    html +='         <tr>';
    html +='         <th>CODIGO</th>';      
    html +='         <th>COMPETENCIA</th>';       
    html +='         <th>ESTADO</th>';             
    html +='         <th>OPCIONES</th>';                    
    html +='         </tr>';
    html +='     </thead>';
    html +='     <tbody>';
    html +='     </tbody>';
    html +='    </table>';
    html +='   </div>';
    $('#cuerpo').html(html);
   var table = $('#competencias').DataTable( {
    responsive: true,
    autoWidth: false,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 } 
        ],
    bDeferRender: true,     
    sPaginationType: "full_numbers",
    ajax: {
      url: "../views/com/tituladacom.php",
      type: "POST",
      data:{'dato':'titulada', 'request':'lcompetencias'},  
    },    
  columns: [
      { "data": "codigo"},  
      { "data": "nombre"},
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

/*function existecompetencia(codigo){
  var parametros = {
    'dato':'titulada',
    'request':'existecompetencia',   
    'codigo':codigo 
  };  
try{
    var html = '';  
    $.ajax({ //inicia la funcion ajax
    type:'POST', //tipo de envio: post o get como en un formulario web
    url:"../views/com/tituladacom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:'html',
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php    
        console.log(data);
        var datosRecibidos = JSON.parse(data); 
          $.each(datosRecibidos, function(key,value) {
          switch(value.respuesta){  
              case '0': 
                  $('#btncrearprograma').html('<button id="btnnficha" type="button" onclick="crearficha(\'0\');" class="btn btn-info">Crear</button>');
              break;
              case '1':
                  var id = value.id;
                  $("#texto").val(value.texto);
                  var boton = '<div id="btncrearprograma"><button id="btnnficha" type="button" onClick="crearcompetencia(\''+id+'\');" class="btn btn-primary">Actualizar</button></div>';
                  $("#btnact").html(boton);
               break;
              case '2':
                    Command: toastr["warning"]("Esta ficha ya existe pero corresponde a una formación que NO es Titulada"); 
                    $('#btnact').hide();
              break;
                }
           });                
            
    });
  }
  catch(ex){
      alert(ex);
  }  
}*/


function traerEditcompetencia(id){
  var parametros = {
    'dato':'titulada',
    'request':'edicompetencia',   
    'id':id 
  };  
try{
      var html = '';  
      $.ajax({ //inicia la funcion ajax
      type:'POST', //tipo de envio: post o get como en un formulario web
      url:"../views/com/tituladacom.php", //url del archivo a llamar y que hace el procedimiento
      dataType:'html',
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php    
          var datosRecibidos = JSON.parse(data); 
            $.each(datosRecibidos, function(key,value) {
            switch(value.respuesta){  
                case '0': 
                    $('#btncrearprograma').html('<button id="btnnficha" type="button" onclick="crearcompetencia(\'0\');" class="btn btn-info btn-block">Crear</button>');
                break;
                case '1':
                    var id = value.id;
                    $("#codigo").val(value.codigo);
                    $("#texto").val(value.texto);
                    var boton = '<div id="btncrearprograma"><button id="btnnficha" type="button" onClick="crearcompetencia(\''+id+'\');" class="btn btn-info btn-block">Actualizar</button></div>';
                    $("#btnact").html(boton);
                 break;
                  }
             });                
              
      });
    }
    catch(ex){
        alert(ex);
    }  
}

function nuevacompetencia(id){
 var html = '';
 var tit = '';
     html +='<div id="panelfrm" class="panel panel-default"> ';
         html +='<div id="frmcomercio" class="panel-body"> ';
         html +='<form role="form">';
              html+='  <div id="frmcodigo" class="form-group">';
              html+='    <label for="codigo" class="col-form-label">Código de la competencia</label>';
              html+='    <input type="text" class="form-control" id="codigo"';
              html+='           placeholder="Código de la Competencia" maxlength="15">';
              html+='  </div>';
              html +='                <script>';
              html +='                $(codigo).ready(function() {';
              html +='                $("#codigo").focusout(function(){';  
              html +='                var dato = $(this).val(); ';
              //html +='                existecompetencia(dato);';
              html +='                 }) ';
              html +='                 }).trigger;';
              html +='                </script>';                
              html+='  <div id="frmtexto" class="form-group">';
              html+='    <label for="texto" class="col-form-label">Texto de la Competencia</label>';
              html+='    <textarea id="texto" class="form-control" rows="5" maxlength="600"></textarea>';
              html+='  </div>';
           html +='  </form>';
        html +=' </div>';
        html +=' </div>';
        html +=' <div id="btnact">';
        html +='  <button type="button" id="btncrearcompetencia" class="btn btn-success btn-block" onclick="crearcompetencia(\'0\');">Guardar Competencia</button>';
        html +=' </div>';
        if(id !== '0'){
            html +=' <div id="resultados">';
            html +=' </div>';
            html +=' <div id="agregar">';
            html +=' <form role="form">';
            html +='  <div class="form-group">';
            html +='    <label for="nresultado" class="col-form-label">Nuevo Resultado para esta Competencia</label>';
            html +='    <textarea type="nresultado" rows="3" class="form-control" id="nresultado"';
            html +='           placeholder="Texto del RAP a agregar"></textarea>';
            html +='  </div>  ';
            html += '<span id="btnnrap"></span>';
            html +=' </form>';   
            html +=' </div>'; 
        }
            html +=' </div>';      
  vtnmodalsm();
  $('#bodymodal').html(html);
  $('#myModalLabel').html('COMPETENCIAS');
  $('#myModal').modal('show');
  fhtml ="<a href='#' class='btn btn-default' data-dismiss='modal'>Cerrar</a>";
  $('#myModalFooter').html(fhtml);
  if(id !== '0'){
    traerEditcompetencia(id);
    var boton ='<button type="button" onclick="nuevorap('+id+');" class="btn btn-primary">Guardar nuevo RAP</button>';
    $('#btnnrap').html(boton);
    traerlresultados(id);
  }  
}  

function nuevorap(idcompetencia){  
var nresultado = $('#nresultado').val();
  if(nresultado.length > 2){
      var parametros={ 
        'dato':'titulada', 
        'request':'nuevorap',    
        'idcompetencia':idcompetencia,
        'nresultado':nresultado
      };   
      $.ajax({ //inicia la funcion ajax
          type:"POST", //tipo de envio: post o get como en un formulario web
          url:"../views/com/tituladacom.php", //Trae datos para editar    
          dataType:"html", //tipo de data que retorna
          data:parametros
          }).done(function(data){
            var datosRecibidos = JSON.parse(data);                  
            $.each(datosRecibidos, function(key,value){ 
            switch(value.respuesta){   
              case '0':
                  Command: toastr["info"]("No hay cambios registrados"); 
                 break;                  
              case '1':
                  Command: toastr["success"]("El registro se aplicó correctamente"); 
                  traerlresultados(idcompetencia);
                 break;                                               
              case '5':
                 //frmlogin(); 
                 break;
               }
          });
         });     
  }else{
        Command:toastr["warning"]("El texto del RAP no puede estar vacío");
  }
}


function traerlresultados(id){ 
  var lista = '<table class="table table-sm table-striped">';
  var contador = 0;
  var parametros = {
    'id':id,
    'dato':'titulada', 
    'request':'lresultados'
  }; 
  try{
      var html = '';  
      $.ajax({ //inicia la funcion ajax
      type:'POST', //tipo de envio: post o get como en un formulario web
      url:'../views/com/tituladacom.php', //url del archivo a llamar y que hace el procedimiento
      dataType:'html',
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php 
      console.log(data);  
          var datosRecibidos = JSON.parse(data); 
            $.each(datosRecibidos, function(key,value) {
              if(value.respuesta == '1'){
                lista += '<tr>';
                    lista += '<td>'+value.rstexto+'</td>';
                    if(value.estado == '1'){
                    lista += '<td><button onclick="quitarlresultados('+value.idcompetencia+','+value.id+')" type="button" class="btn btn-success btn-sm"><i class="far fa-check-square"></i>'+value.id+'</td>';  
                    }else{
                     lista += '<td><button onclick="activarlresultados('+value.idcompetencia+','+value.id+')" type="button" class="btn btn-warning btn-sm"><i class="far fa-square"></i>'+value.id+'</td>';  
                    }   
                  
                lista += '</tr>';
              }
             });  
             lista += '</table>';
             $('#resultados').html(lista);               
      });
    }
    catch(ex){
        alert(ex);
    }  
}

function crearcompetencia(id){
var codigo = $('#codigo').val();
var texto = $('#texto').val(); 
    $('#btncrearcompetencia').attr('disabled', 'disabled');
  var parametros={ 
    'id':id,
    'codigo':codigo,
    'texto':texto,
    'dato':'titulada', 
    'request':'compeupdate'
  };   
      $.ajax({ //inicia la funcion ajax
          type:"POST", //tipo de envio: post o get como en un formulario web
          url:"../views/com/tituladacom.php", //Trae datos para editar    
          dataType:"html", //tipo de data que retorna
          data:parametros
          }).done(function(data){ 
            $('#btncrearcompetencia').attr('disabled', false); 
            var datosRecibidos = JSON.parse(data);                  
            $.each(datosRecibidos, function(key,value){ 
            switch(value.respuesta){   
              case '0':
                  Command: toastr["info"]("No hay cambios registrados"); 
                 break;                  
              case '1':
                  Command: toastr["success"]("El registro se aplicó correctamente"); 
                  $('#competencias').DataTable().ajax.reload(null, false);
                    $('#myModal').modal('hide');
                 break;                                               
              case '5':
                 //frmlogin(); 
                 break;
               }   
          });     
       });          
}

/************************************************/
function quitarlresultados(idcompetencia, idresultado){ 
  var parametros = {
          'dato':'titulada', 
          'request':'quitarlresultados',  
          'id':idresultado
      }; 
  try{
      var html = '';  
      $.ajax({ //inicia la funcion ajax
      type:'POST', //tipo de envio: post o get como en un formulario web
      url:'../views/com/tituladacom.php', //url del archivo a llamar y que hace el procedimiento
      dataType:'html',
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php 
            var datosRecibidos = JSON.parse(data);                  
            $.each(datosRecibidos, function(key,value){ 
            switch(value.respuesta){   
              case '0':
                  Command: toastr["info"]("No hay cambios registrados"); 
                 break;                  
              case '1':
                  Command: toastr["success"]("El registro se aplicó correctamente"); 
                  traerlresultados(idcompetencia);
                 break;                                               
              case '5':
                 //frmlogin(); 
                 break;
               }   
          });     
       
      });
    }
    catch(ex){
        alert(ex);
    }  
}

function activarlresultados(idcompetencia, idresultado){ 
  var parametros = {
      'dato':'titulada', 
      'request':'activarlresultados',   
      'id':idresultado
      }; 
  try{
      var html = '';  
      $.ajax({ //inicia la funcion ajax
      type:'POST', //tipo de envio: post o get como en un formulario web
      url:'../views/com/tituladacom.php', //url del archivo a llamar y que hace el procedimiento
      dataType:'html',
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php 
            var datosRecibidos = JSON.parse(data);                  
            $.each(datosRecibidos, function(key,value){ 
            switch(value.respuesta){   
              case '0':
                  Command: toastr["info"]("No hay cambios registrados"); 
                 break;                  
              case '1':
                  Command: toastr["success"]("El registro se aplicó correctamente"); 
                  traerlresultados(idcompetencia);
                 break;                                               
              case '5':
                 //frmlogin(); 
                 break;
               }   
          }); 
                             
      });
    }
    catch(ex){
        alert(ex);
    }  
}
/************************************************/


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