<?php
//include_once "models/conexion.php"; 
 echo '<script src="'.SERVERURL.'views/js/gestionFichas.03.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#gfichas").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Gestionar Ficha</a></li>
        <li class="breadcrumb-item active" aria-current="page">Publicar Ficha</li>
      </ol>      
';


function traerEmpresa($idempresa){
$respuesta = '';   
   $sqlt = "SELECT nombre FROM empresas WHERE id = '$idempresa'";
   $stmt = Conexion::conectar()->prepare($sqlt);
   $stmt -> execute();
        if($stmt->rowCount() > 0){
        $registros = $stmt->fetchAll(); 
        foreach ($registros as $key => $value){
             $respuesta = $value['nombre'];
        }           
    } 
    return $respuesta;  
}

    if(isset($_SESSION['prc_ciuser'])){
        $coordinacion = $_SESSION['prc_coordinacion'];
        $centro = $_SESSION['prc_centro'];
        $perfil = $_SESSION['prc_perfil']; 
    	$sqlt = "SELECT fc.id id, fc.lugar, fc.numero, fc.codempresa, cr.nombre coordinacion, fc.direccion, fc.naprendices, fr.codigo, fr.nombre, fr.horas, us.nombre instructor, fc.idempresa, fc.ofertaabierta, cd.ciudad, fc.finicia, fc.ffinaliza FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id WHERE fc.ccentro = '$centro' AND fc.historico = '0' AND fc.estado = '4'   ORDER BY fc.id ASC";
    	$stmt = Conexion::conectar()->prepare($sqlt);
    	$stmt -> execute();
    	if($stmt -> rowcount() > 0){
    		$registros = $stmt->fetchAll();
    	}
    }    
?>
<section class="p-3">
<div class="table-responsive"> 
    <table id="cProgramacion" <table class="table table-sm table-bordered table-striped " style="width:100%">
        <thead>
          <tr>	
            <th>C_PROGRAMA</th>             
            <th>PROGRAMA</th>
            <th>NUMERO</th>             
            <th>CODEMPRESA</th>            
            <th>HORAS</th> 
            <th>COORDINACION</th>                       
            <th>INSTRUCTOR</th> 
            <th>EMPRESA</th>                                 
            <th>INICIA</th>
            <th>FINALIZA</th>
            <th>VER</th>                        
          </tr>  
        </thead>
        <tbody>
            <?php if(!empty($registros)) { ?>
                <?php foreach ($registros as $key => $value) { ?>

                       <?php
                            $idempresa = $value['idempresa'];
                            $empresa = '';
                            if($value['ofertaabierta'] == 'S'){
                                  $empresa = '<span style="color:blue;">Oferta Abierta</span>';  
                                  $codempresa = '<span style="color:blue;">Oferta Abierta</span>';  
                            }else{
                                  $empresa = traerEmpresa($idempresa); 
                                  $codempresa = $value['codempresa']; 
                            }
                        ?>  
                    <tr id="fila_<?php echo $value['id']; ?>">
                        <td><?php echo $value['codigo']; ?></td>
                        <td><?php echo html_entity_decode($value['nombre']); ?></td>
                        <td><?php echo $value['numero']; ?></td>  
                        <td><?php echo $codempresa; ?></td>  
                        <td><?php echo $value['horas']; ?></td>    
                        <td><?php echo $value['coordinacion']; ?></td>                    
                        <td><?php echo html_entity_decode($value['instructor']);?></td>
                        <td><?php echo $empresa;?></td>            
                        <td><?php echo $value['finicia'];?></td>
                        <td><?php echo $value['ffinaliza'];?></td>  
                        <td> 
					     <button type="button" onClick ="verfichaCrear('<?php echo $value['id']; ?>');"      class="btn btn-success btn-sm"><i class="fas fa-binoculars"></i>
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
        $('#cProgramacion').DataTable({ 
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


    
