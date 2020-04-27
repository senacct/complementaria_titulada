function listaBitacora1(){
  try{
  var parametros = {
         'dato':'reportes', 
        'request':'bitacoras'
  };  
  $.ajax({    
  url:"../views/com/reportescom.php",
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

function listaBitacora(){
 var html = '';  
    html +=' <h4 class="h4 mb-4  text-muted">LISTADO DE TIEMPOS</h4> ';
    html +='    <div class="table-responsive">';
    html +='   <table id="listaBitacoras" class="table table-sm table-bordered table-striped " style="width:100%">';
    html +='        <thead>';
    html +='            <tr>';
    html +='            <th>FICHA</th>';     
    html +='            <th>USUARIO</th>';         
    html +='            <th>ESTADO</th>';             
    html +='            <th>FECHA</th>';
    html +='            <th>HORA</th>';     
    html +='            <th>IP</th>';       
    html +='            </tr>';
    html +='        </thead>';
    html +='        <tbody>';
    html +='        </tbody>';
    html +='    </table>';
    html +='   </div>';
    $('#cuerpo').html(html);
    $('#listaBitacoras').DataTable({    
    responsive: true,
    autoWidth: false,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 } 
        ],
    bDeferRender: true,     
    sPaginationType: "full_numbers",
    ajax: {
      url:"../views/com/reportescom.php",
      type: "POST",
      data:{'dato':'reportes', 'request':'bitacoras'},  
    },  
columns: [
    { "data": "numero"},
    { "data": "nombre"},    
    { "data": "nestado"},  
    { "data": "fecha"},
    { "data": "hora"}, 
    { "data": "ip"}
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