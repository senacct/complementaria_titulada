<?php
//include_once "models/conexion.php"; 
 echo '<script src="'.SERVERURL.'views/js/gestionProgramas.04.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gadmin").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Administración</a></li>
        <li class="breadcrumb-item active" aria-current="page">Programas de Formación</li>
      </ol> 
      <div class="d-flex p-2 bd-highlight"><button type="button" onClick="nuevoPrograma(\'0\')" class="btn btn-success btn-block btn-lg">NUEVO PROGRAMA</button></div>   
            <div id="cuerpo"></div> 
      <script>tablaProgramas();</script> 
      ';
  if(isset($_SESSION['prc_idusuario'])){ 
     $centro = $_SESSION['prc_centro'];
     $sqlt = "SELECT pr.id, pr.codigo, pr.version, pr.nombre, pr.estado, pr.horas, ep.nombre nespecialidad FROM formaciones pr INNER JOIN  especialidad ep ON pr.idespecialidad = ep.id WHERE pr.centro = '$centro' ORDER BY pr.nombre ASC";
     $stmt = Conexion::conectar()->prepare($sqlt);
    if($stmt -> execute()){
    $registros = $stmt->fetchAll();
    }
  }
  ?>
<section class="p-3">
<div class="table-responsive"> 
    <table id="programas" <table class="table table-sm table-bordered table-striped " style="width:100%">
        <thead>
          <tr>  
            <th>C_PROGRAMA</th>             
            <th>PROGRAMA</th>
            <th>VERSION</th>    
            <th>ESPECIALIDAD</th>                    
            <th>HORAS</th> 
            <th>ESTADO</th>                                 
            <th>EDITAR</th>                        
          </tr>  
        </thead>
        <tbody>
            <?php if(!empty($registros)) { ?>
                <?php foreach ($registros as $key => $value) { ?>
                    <tr id="fila_<?php echo $value['id']; ?>">
                        <td><?php echo $value['codigo']; ?></td>
                        <td><?php echo $value['nombre']; ?></td>
                        <td><?php echo $value['version']; ?></td> 
                        <td><?php echo $value['nespecialidad']; ?></td>  
                        <td><?php echo $value['horas']; ?></td> 
                        <?php 
                        $estado = $value['estado']; 
                        switch ($estado) {
                           case '1':
                             $estado = 'Ejecución';
                             break;
                           
                           default:
                              $estado = 'No disponible';
                             break;
                         } 
                        ?>

                        <td><?php echo $estado;?></td>
                        <td> 
               <button type="button" onClick ="editarPrograma('<?php echo $value['id']; ?>');"      class="btn btn-info btn-sm"><i class="far fa-edit"></i>
               </button>
            </td>                        
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
</section>
<?php
?>
    <script>
    $(document).ready(function() {
 $('#programas').DataTable( { 
responsive: true,
autoWidth: false,
    columnDefs: [
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: -1 } 
    ],
bDeferRender: true,     
sPaginationType: "full_numbers",  
columns: [
  { "data": "codigo" },
  { "data": "nombre" },
  { "data": "version" },
  { "data": "nespecialidad" },  
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
    } );
</script>