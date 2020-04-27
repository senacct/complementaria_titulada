<?php
//include_once "models/conexion.php"; 
 echo '<script src="'.SERVERURL.'views/js/gestionCoordinador.06.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#coordinador").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Coordinador</a></li>
        <li class="breadcrumb-item active" aria-current="page">Autorizar</li>
      </ol>      
';
if(isset($_SESSION['prc_ciuser'])){
    $coordinacion = $_SESSION['prc_coordinacion'];
    $centro = $_SESSION['prc_centro'];
    $perfil = $_SESSION['prc_perfil'];
    $sqlt = "SELECT fc.id id, fc.lugar, fc.direccion, fc.naprendices, fr.codigo, fr.nombre, fr.horas, us.nombre instructor, em.nombre empresa, cd.ciudad, fc.finicia, fc.ffinaliza FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN empresas em ON fc.idempresa = em.id  INNER JOIN ciudades cd ON fc.ciudad = cd.id  WHERE  fc.ccentro = '$centro' AND fc.historico = '0' AND fc.estado = '3' ORDER BY fc.id ASC";
    	$stmt = Conexion::conectar()->prepare($sqlt);
    	$stmt -> execute();
    	if($stmt -> rowcount() > 0){
    		$registros = $stmt->fetchAll();
    	}
 }
?>
<section class="p-3">
<div class="table-responsive"> 
    <table id="usetTable" <table class="table table-sm table-bordered table-striped " style="width:100%">
        <thead>
          <tr>	
            <th>C_PROGRAMA</th>             
            <th>PROGRAMA</th>
            <th>HORAS</th>
            <th>DENEGAR</th>  
            <th>HORARIO</th>             
            <th>INSTRUCTOR</th>
            <th>EMPRESA</th>
            <th>CIUDAD</th>  
            <th>LUGAR</th> 
            <th>APRENDICES</th> 
            <th>DIRECCION</th>                                   
            <th>DESDE</th>
            <th>HASTA</th>
            <th>AUTORIZAR</th>                        
          </tr>  
        </thead>
        <tbody>
            <?php if(!empty($registros)) { ?>
                <?php foreach ($registros as $key => $value) { ?>
                    <tr id="fila_<?php echo $value['id']; ?>">
                        <td><?php echo $value['codigo']; ?></td>
                        <td><?php echo html_entity_decode($value['nombre']); ?></td>
                        <td><?php echo $value['horas']; ?></td>
                        <td> 
					     <button type="button" onClick ="predenegar('<?php echo $value['id']; ?>');"  
					      class="btn btn-warning btn-sm"><i class="far fa-thumbs-down"></i>
					     </button>
						</td>   
                        <td> 
                         <button type="button" onClick ="verProgramacion('<?php echo $value['id']; ?>');"      
                            class="btn btn-info btn-sm"><i class="far fa-calendar-alt"></i>
                         </button>
                        </td>                                             
                        <td><?php echo html_entity_decode($value['instructor']);?></td>
                        <td><?php echo html_entity_decode($value['empresa']);?></td>
                        <td><?php echo $value['ciudad'];?></td>
                        <td><?php echo $value['lugar'];?></td>
                        <td><?php echo $value['naprendices'];?></td>  
                        <td><?php echo html_entity_decode($value['direccion']);?></td>             
                        <td><?php echo $value['finicia'];?></td>
                        <td><?php echo $value['ffinaliza'];?></td>  
                        <td> 
					     <button type="button" onClick ="autorizar('<?php echo $value['id']; ?>');"      
                            class="btn btn-success btn-sm"><i class="far fa-thumbs-up"></i>
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
        $('#usetTable').DataTable({ 
        	autoWidth: false,
    columnDefs: [
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: -1 }
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