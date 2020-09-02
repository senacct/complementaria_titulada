function programarFichas(){
  var html = ''; 
          html +='<h5 class="card-title">Programar Ficha </h5>';
          html +='<form class="form-group"> ';
          html +='<div class="row">';
          html +='<div class="col col-12 col-md-6">';
          html +='<div class="form-group">';
          html +='<div class="input-group mb-3">';
          html +='  <input type="text" class="form-control" id="nficha"  placeholder="Numero de Ficha" disabled>';
          html +='  <div class="input-group-append">';
          html +='  <button class="btn btn-outline-secondary" onClick="traerlfichas();" type="button" id="btnonbase"><i class="fas fa-users"></i></button>';
          html +='  </div>';
          html +='</div>';
          html +='</div>';  
          html +='</div>'; 

          html +='<div class="col col-12 col-md-6">';
          html +='<div class="form-group">';
          html +='<div class="input-group mb-3">';
          html +='  <input type="text" class="form-control" id="instructor" placeholder="Instructor" disabled>';
          html +='  <div class="input-group-append">';
          html +='  <button class="btn btn-outline-secondary" onClick="traerinstructores();" type="button" id="btnonbase"><i class="fas fa-chalkboard-teacher"></i></button>';
          html +='  </div>';
          html +='</div>';
          html +='</div>';  
          html +='</div>'; 

          

          html +='</div>';
          html +='</div>';  

          html +='<div class="row">';  

          html +='            <div class="col col-12 col-md-6">';
          html +='              <label class="col-sm-12 col-form-label">Año</label>';
          html +='              <div class="input-group mb-3">';
          html +='              <select id="añoTrimestre" class="custom-select">';
          html +='                <option value="2020">2020</option>';
          // html +='                <option value="2020">2021</option>';
          html +='              </select>';
          html +='            <script>';
          html +='            ';
          html +='            </script> '; 
          html +='               </div>  ';
        html +='               </div>  ';

          html +='            <div class="col col-12 col-md-6">';
          html +='              <label class="col-sm-12 col-form-label">Trimestre</label>';
          html +='              <div class="input-group mb-3">';
          html +='              <select id="trimestre" class="custom-select">';
          html +='                <option value="1">1</option>';
          html +='                <option value="2">2</option>';
          html +='                <option value="3">3</option>';
          html +='                <option value="4">4</option>';
          html +='              </select>';
          html +='            <script>';
          html +='            ';
          html +='            </script> '; 
          html +='               </div>  ';
        html +='               </div>  ';

          html +='          </div>'; 

          html +='<div class="bs-callout bs-callout-info"><label style="display:none;" id="lIdficha"></label><p id="lficha"></p></div>';
          html +='<div class="bs-callout bs-callout-danger"><label style="display:none;" id="lIdInstructor"></label><label style="display:none;" id="lTVInstructor"></label><p id="linstructor"></p></div>';          

          

          html +='</form>'; 
          
    //resetDias(idficha,idtrimestre);
    $('#cuerpo').html(html); 

     //programacion(idficha, idtrimestre);                             
}


function verHinstructor(idinstructor){

  var trimestreSel = $("#trimestre").val();
  var anoSel = $("#añoTrimestre").val();

  
    var parametros = {
      'dato':'titulada',
      'request':'verHinstructor',
      'id':idinstructor,
      'idFicha':$('#lIdficha').text(),
      vinculacion:$('#lTVInstructor').text(),
      modificar:0,
      trimestreSel:trimestreSel,
      anoSel:anoSel
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../../views/com/tituladacom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      console.log(data);
      $('#programacion').html(data);
    }); 
  
}


function verHficha(idFicha){

  var trimestreSel = $("#trimestre").val();
  var anoSel = $("#añoTrimestre").val();

  var parametros = {
    'dato':'titulada',
    'request':'verHficha',
    'id':idFicha,
    'idFicha':idFicha,
    modificar:0,
    trimestreSel:trimestreSel,
    anoSel:anoSel
  }
  $.ajax({ //inicia la funcion ajax
  type:"POST", //tipo de envio: post o get como en un formulario web
  url:"../../views/com/tituladacom.php", //url del archivo a llamar y que hace el procedimiento
  dataType:"html", //tipo de data que retorna
  data:parametros
  }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
    console.log(data);
    $('#programacion').html(data);
  });     
   
}


function selFichaTitulada(id, numero, nombre){
  $('#lIdficha').text("");
  var boton = '<button type="button" onClick="verHficha('+id+');" class="btn btn-sm btn-outline-success">Ver horario de la ficha</button>';
  $('#myModal').modal('hide');
  $('#lficha').html(numero+' '+nombre + '<br><br>' + boton);
  $('#lIdficha').text(id);
  $("#lficha").prop("name",id);
}


function selInstruProgramar(id, nombre, crnombre, tipoVinculacion){
  $('#lIdInstructor').text("");
  $('#lTVInstructor').text("");

  var boton = '<button type="button" onClick="verHinstructor('+id+');" class="btn btn-sm btn-outline-success">Ver horario del instructor</button>';
  $('#myModal').modal('hide');
  $('#linstructor').html(nombre+'  ('+crnombre+')'+ '<br> Vinculación: ' + tipoVinculacion + '<br><br>' + boton);
  $("#linstructor").prop("name",id);
  $('#lIdInstructor').text(id);
  $('#lTVInstructor').text(tipoVinculacion);

  
}


function traerinstructores(){
  var html = '';  
     html +=' <div class="table-responsive">';
     html +='  <table id="tituladas" class="table table-sm table-bordered table-striped">';
     html +='     <thead>';
     html +='         <tr>';
     html +='         <th>COORDINACION</th>';        
     html +='         <th>INSTRUCTOR</th>';   
     html +='         <th>VINCULACIÓN</th>'; 
     html +='         <th>SELECCIONAR</th>';                    
     html +='         </tr>';
     html +='     </thead>';
     html +='     <tbody>';
     html +='     </tbody>';
     html +='    </table>';
     html +='   </div>';
     vervtnmodal();  
     $('#myModalLabel').html('INSTRUCTORES');
     $('#bodymodal').html(html);
     $('#myModal').modal('show'); 
    var table = $('#tituladas').DataTable( {
     responsive: true,
     autoWidth: false,
         columnDefs: [
             { responsivePriority: 1, targets: 0 },
             { responsivePriority: 2, targets: -1 } 
         ],
     bDeferRender: true,     
     sPaginationType: "full_numbers",
     ajax: {
       url:"../../views/com/usuariocom.php",
       type: "POST",
       data:{'dato':'usuario', 'request':'selprogramar'},   
     },    
 columns: [
     { "data": "coordinacion"},
     { "data": "instructor"},    
     { "data": "vinculacion"},
     { "data": "seleccionar"}     
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
     },
   }); 
 } 
 

 function traerlfichas(){
  var html = '';  
     html +=' <div class="table-responsive">';
     html +='  <table id="tituladas" class="table table-sm table-bordered table-striped">';
     html +='     <thead>';
     html +='         <tr>';
     html +='         <th>COORDINACION</th>';        
     html +='         <th>FICHA</th>';   
     html +='         <th>MODALIDAD</th>'; 
     html +='         <th>NIVEL</th>';         
     html +='         <th>C_PROGRAMA</th>'; 
     html +='         <th>PROGRAMA</th>'; 
     html +='         <th>VERSION</th>';     
     html +='         <th>AMBIENTE</th>';               
     html +='         <th>INICIA</th>'; 
     html +='         <th>FINALIZA</th>';   
     html +='         <th>SELECCIONAR</th>';                    
     html +='         </tr>';
     html +='     </thead>';
     html +='     <tbody>';
     html +='     </tbody>';
     html +='    </table>';
     html +='   </div>';
     vervtnmodal();  
     $('#myModalLabel').html('FICHAS TITULADAS');
     $('#bodymodal').html(html);
     $('#myModal').modal('show'); 
    var table = $('#tituladas').DataTable( {
     responsive: true,
     autoWidth: false,
         columnDefs: [
             { responsivePriority: 1, targets: 0 },
             { responsivePriority: 2, targets: -1 } 
         ],
     bDeferRender: true,     
     sPaginationType: "full_numbers",
     ajax: {
       url: "../../views/com/tituladacom.php",
       type: "POST",
       data:{'dato':'titulada', 'request':'listaFichas', 'tipores':'seleccionar'},  
     },    
 columns: [
     { "data": "coordinacion"},
     { "data": "numero"},    
     { "data": "modalidad"},
     { "data": "nivel"},     
     { "data": "codigo"}, 
     { "data": "nombre"},    
     { "data": "version"},         
     { "data": "lugar"},
     //{ "data": "ciudad"},
     { "data": "finicia"},
     { "data": "ffinaliza"},
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
     },
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


  
function verResultadosHorario(idProgramacion, puedeModificar){

  var html = '';  
     html +=' <div class="table-responsive">';
     html +='  <table id="resultadosSel" class="table table-sm table-bordered table-striped">';
     html +='     <thead>';
     html +='         <tr>';
     html +='         <th>CODIGO</th>';        
     html +='         <th>COMPETENCIA</th>';   
     html +='         <th>RESULTADO</th>'; 
     html +='         </tr>';
     html +='     </thead>';
     html +='     <tbody>';
     html +='     </tbody>';
     html +='    </table>';
     html +='   </div>';
     vervtnmodal();  
     $('#myModalLabel').html('RESULTADOS');
     $('#bodymodal').html(html);
     $('#myModal').modal('show'); 
    var table = $('#resultadosSel').DataTable( {
     responsive: true,
     autoWidth: false,
         columnDefs: [
             { responsivePriority: 1, targets: 0 },
             { responsivePriority: 2, targets: -1 } 
         ],
     bDeferRender: true,     
     sPaginationType: "full_numbers",
     ajax: {
       url: "../../views/com/tituladacom.php",
       type: "POST",
       data:{
          'dato':'titulada',
          'request':'lresultadoPro',
          'idProgramacion':idProgramacion ,
          'modificar':puedeModificar
        },  
     },    
 columns: [
     { "data": "codigo"},
     { "data": "competencia"},    
     { "data": "resultado"},
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
     },
   }); 

}
