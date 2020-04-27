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
    url:"../../../../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
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

function listFormaciones(idempresa){
  var parametros = {
      dato:'formacion',
      request:'list',           
      idempresa:idempresa
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../../../../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){
        $('#centro-content').html(data);
    });
}


function traerldepto(idDepto){
	var parametros = {
    	dato:'depto',
    	request:'select' 
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../../../../views/com/empresacom.php", //url del archivo a llamar y que hace el procedimiento
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
    url:"../../../../views/com/empresacom.php", //url del archivo a llamar y que hace el procedimiento
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
    url: '../../../../views/com/formacioncom.php', //url del archivo a llamar y que hace el procedimiento
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

function mostrarCalendario(idficha, idempresa){
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
          html +='<button type="button" onClick="resetDias('+idficha+','+idempresa+');" class="btn btn-secondary">Desmarcar calendario</button>' ;  
           html +='<script>'; 
           html +=' $(document).ready(function() {';
           html +='   $("#inicia").change(function(){';
           html +='      var dato = $(this).val();';       
           html +='       llenarfinaliza(dato);';
           html +='     })';
           html +='    }).trigger; ';       
         html +='</script>'; 
    calendariomodalsm();
    resetDias(idficha,idempresa);
    $('#myModal').modal('show'); 
         $("#encabezado").html(html); 
         $('#btncal'+idficha).attr('disabled', false);
         llenarfinaliza(6);   
         programacion(idficha);                             
}

function resetDias(idficha, idempresa){
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
        idempresa:idempresa 
      }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../../../../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      //var datosRecibidos = JSON.parse(data); 
        $('#myModalLabel').html('CALENDARIO ');
        $('#bodymodal').html(data);
    });        
}

function programacion(idficha){
  var parametros = {
      dato:'programacion',
      request:'lista',
      idficha:idficha 
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../../../../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      $('#programacion').html(data);
    });        
}

function selCalendario(idficha, ano, mes, dia, ds, festivo){
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
      festivo:festivo
     }
      $.ajax({
      url: '../../../../views/com/formacioncom.php',
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
      url: '../../../../views/com/formacioncom.php',
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

function solpublicarficha(idFicha, idempresa){
 $('#btnscficha'+idFicha).attr('disabled', 'disabled'); 
   var parametros = {
      dato:'formacion',
      request:'solcrear',
      idficha: idFicha
     }
      $.ajax({
      url: '../../../../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php 
        listFormaciones(idempresa); 
      
    }); 
}


function solValidarFicha(idFicha, idempresa){
 $('#btnsdficha'+idFicha).attr('disabled', 'disabled'); 
   var parametros = {
      dato:'formacion',
      request:'solvalidar',
      idficha: idFicha
     }
      $.ajax({
      url: '../../../../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php 
      listFormaciones(idempresa);       
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
      url: '../../../../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php 
        $('#btnsficha'+idFicha).attr('disabled', false); 
        listFormaciones(idempresa);  
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
      url: '../../../../views/com/formacioncom.php',
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

function nuevaFicha(idempresa,nempresa,idDepto,idCiudad){
  try{
    $('#btnnficha').attr('disabled', 'disabled'); 
     var parametros = { 
      dato:'formacion',
      request:'nueva',
      idempresa:idempresa,
      idDepto:idDepto,
      idCiudad:idCiudad,
      nempresa:nempresa
      };      
      $.ajax({
      url: '../../../../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php 
        $('#btnnficha').attr('disabled', false); 
        var datosRecibidos = JSON.parse(data);                  
        $.each(datosRecibidos, function(key,value) { 
        html = '';    
        switch(value.respuesta){   
            case '0':
               aCommand: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                aCommand: toastr["success"]("El registro se aplicó correctamente"); 
                listFormaciones(idempresa); 
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

function eliminarficha(id, idempresa){
 $('#btneficha'+id).attr('disabled', 'disabled'); 
  try{
     var parametros = { 
      dato:'formacion',
      request:'eliminar',
      id:id
      };      
      $.ajax({
      url: '../../../../views/com/formacioncom.php',
      type:'POST',
      dataType:'html', //tipo de data que retornaf
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php  
       var datosRecibidos = JSON.parse(data);  
        $('#btneficha'+id).attr('disabled', false);                  
        $.each(datosRecibidos, function(key,value) { 
        html = '';    
        switch(value.respuesta){   
            case '0':
               aCommand: toastr["info"]("No hay cambios registrados"); 
               break;                  
            case '1':
                $('#formacion'+id).hide('slow'); 
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

function elifichaconfirma(id, idempresa){
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
      url: '../../../../views/com/formacioncom.php',
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
               listFormaciones(idempresa);
               break;                  
            case '1':
                aCommand: toastr["success"]("El registro se eliminó correctamente"); 
                listFormaciones(idempresa);
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


function tablaCursos1(idficha, idempresa){
  console.log(idficha);
  console.log(idempresa);
  try{
  var cor = $('#correo').val();
  var con = $('#contrasena').val();
  var parametros = {
      'dato':'formacion', 
      'request':'tabla',
      'idficha':idficha,
      'idempresa':idempresa 
    }; 
  $.ajax({    
  url:"../../../../views/com/formacioncom.php",
  type:'POST',
  dataType:'html', //tipo de data que retorna
  data:parametros
  }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php  
 $('#cuerpo').html(data);
   console.log(data);
       
  });
    //setInterval('swal("¡Información!", "Cragaremos los proyectos que usted ha creado y en los que aparece como interante de equipo de proyecto, ok?", "info");',10);
    }catch(ex){
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
  url: "../../../../views/com/formacioncom.php",
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

function selCurso(idficha, idcurso, idempresa, horas){
     var parametros = { 
      dato:'formacion',
      request:'seleccionar',
      horas:horas,
      idficha:idficha,
      idcurso:idcurso
      };      
      $.ajax({
      url: '../../../../views/com/formacioncom.php',
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
                listFormaciones(idempresa);
                $('#myModal').modal('hide');
               break;                                            
            case '5':
               //frmlogin();
               break;
           }   
        });               
        });  
}


function editarFicha(id, idempresa, idDepto, idCiudad){
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
  var boton = '<button type="button" onClick="updateFicha('+id+','+idempresa+');" class="btn btn-info">Guardar</button>';
  $('#btnact').html(boton);
  $('#myModal').modal('show'); 
  var parametros={ 
    dato:'formacion',
    request:'traerdcurso', 
    id:id
  }  
  $.ajax({ //inicia la funcion ajax
  type:"POST", //tipo de envio: post o get como en un formulario web
  url: '../../../../views/com/formacioncom.php',//Trae datos para editar    
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
          onbase = value.onbase
          val_onbase = value.val_onbase
              boton = ' <form class="form-inline">';
              boton +='<div class="form-group">';
              boton +='<div class="input-group mb-4">';
              boton +='  <input type="text" class="form-control" id="nonbase" placeholder="Número radicación solicitud">';
              boton +='  <div class="input-group-append">';
              boton +='  <button class="btn btn-outline-secondary" onClick="updateRadicado('+id+','+idempresa+');" type="button" id="btnonbase"><i class="fas fa-check"></i></button>';
              boton +='  </div>';
              boton +='</div>';
              boton +='</div>';    
              boton +='</form>';
          //var boton = '<button type="button" onClick="updateRadicado('+id+','+idempresa+');" class="btn btn-outline-secondary btn-sm">Ingresar código de radicación</button>';
          $("#placenonbase").html(onbase); 
          if(onbase.length < 5 || val_onbase != '1'){

             tonbase = '<span style="font-size: 1.2rem; color:blue;" id="onbase">'+boton+'</span>';
          }else{
             $("#placenonbase").html('');
             if(val_onbase == '1'){
               tonbase = '<span style="font-size:1rem; color:green;" id="onbase">'+onbase+'</span> &nbsp;<span style="font-size: 0.8rem; color:green;"><i class="fas fa-check"></i></span>';
              }else{
               tonbase = '<span style="font-size: 1.2rem; color:blue;" id="onbase">'+onbase+'</span>';  
              }
          }
          lugar = lugar.toUpperCase();
          $("#placeonbase").html(tonbase); 
          $("#lugar").val(lugar); 
          $("#dirformacion").val(value.dirformacion);
          $("#naprendices").val(value.naprendices);
          $("#pespeciales > option[value="+value.pespeciales+"]").attr("selected","selected");
          $("#ciudad > option[value="+value.ciudad+"]").attr("selected","selected");
        }
    });
  });
}


function updateFicha(id, idempresa){
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
          url: '../../../../views/com/formacioncom.php',//Trae datos para editar    
          dataType:"html", //tipo de data que retorna
          data:parametros
          }).done(function(data){ 
              listFormaciones(idempresa);
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
function updateRadicado(idficha, idempresa){
  var onbase = $('#nonbase').val();
  if(onbase.length > 0){
  var parametros = { 
      'dato':'formacion',
      'request':'updateRadicado', 
      'onbase':onbase,
      'idficha':idficha
   };      
      $.ajax({
       url:"../../../../views/com/formacioncom.php", //url del archivo a llamar y que hace el procedimiento
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
               //listFormaciones(idempresa);
               break;                  
            case '1': 
                $("#placenonbase").html(value.dato);
                Command: toastr["success"]("Registro actualizado correctamente.");
                listFormaciones(idempresa); 
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