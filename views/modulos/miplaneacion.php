<?php
//include_once "models/conexion.php"; 
 echo '<script src="'.SERVERURL.'views/js/miplaneacion.02.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#programar").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Planeación</a></li>
        <li class="breadcrumb-item active" aria-current="page">Mi Planeación</li>
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
    $usuario = $_SESSION['prc_ciuser'];
    $sqlt = "SELECT fc.numero, fc.ofertaabierta, fc.alarmada, cr.nombre coordinacion, fc.codempresa, fc.controlada, fc.id id, fc.lugar, fc.direccion, fc.naprendices, fr.codigo, fr.nombre, fr.horas, us.nombre instructor, be.nestado, be.estado estado, be.fecha, fc.idempresa, cd.ciudad, fc.finicia, fc.ffinaliza FROM fcaracterizacion fc INNER JOIN formaciones fr ON fc.idprograma = fr.id INNER JOIN usuarios us ON fc.idusuario = us.id INNER JOIN ciudades cd ON fc.ciudad = cd.id INNER JOIN bitacoraestados be ON fc.id = be.idficha AND fc.estado = be.estado INNER JOIN coordinaciones cr ON fc.coordinacion = cr.id WHERE fc.ccentro = '$centro' AND fc.usuario = '$usuario' AND fc.historico = '0' AND fc.estado = be.estado AND be.visible = '1'  ORDER BY fc.id ASC";
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
            <th>NUMERO</th>
            <th>C_EMPRESA</th> 
            <th>COORDINACION</th>                
            <th>C_PROGRAMA</th>             
            <th>PROGRAMA</th>            
            <th>AMBIENTE</th>             
            <th>DIRECCION</th>            
            <th>HORAS</th>           
            <th>EMPRESA</th> 
            <th>CIUDAD</th>
            <th>INICIA</th>
            <th>FINALIZA</th> 
            <th>ESTADO</th>                       
            <th>E.FECHA</th>                                                         
            <th>OPCIONES</th>                        
          </tr>  
        </thead>
        <tbody>
            <?php if(!empty($registros)) { ?>
                <?php foreach ($registros as $key => $value) { 

                    if($value['alarmada'] == 1){
                        ?>
                        <tr class="bg-warning" id="fila_<?php echo $value['id']; ?>">
                        <?php
                    }else{
                        ?>
                        <tr id="fila_<?php echo $value['id']; ?>">
                        <?php
                    }
                        ?>
                    
                        <td><?php echo $value['numero']; ?></td>
                        <?php
                        $codigoEmpresa = '';
                            if($value['ofertaabierta'] == 'S'){
                                  $codigoEmpresa = 'Oferta Abierta';  
                            }else{
                                  $codigoEmpresa = $value['codempresa'];  
                            } 
                         ?>                          
                        <td><?php echo $codigoEmpresa; ?></td> 
                        <td><?php echo $value['coordinacion']; ?></td> 
                         
                        <td><?php echo $value['codigo']; ?></td>                           
                        <td><?php echo html_entity_decode($value['nombre']); ?></td>
                        <td><?php echo html_entity_decode($value['lugar']); ?></td>
                        <td><?php echo html_entity_decode($value['direccion']); ?></td>      
                        <td><?php echo $value['horas']; ?></td>  
                        <?php
                            $idempresa = $value['idempresa'];
                            $empresa = '';
                            if($value['ofertaabierta'] == 'S'){
                                  $empresa = 'Oferta Abierta';  
                            }else{
                                  $empresa = traerEmpresa($idempresa);  
                            }
                        ?>                    
                        
                        <td><?php echo html_entity_decode($empresa);?></td>


                        <td><?php echo html_entity_decode($value['ciudad']);?></td>             
                        <td><?php echo $value['finicia'];?></td>
                        <td><?php echo $value['ffinaliza'];?></td>                          
                        <td><?php echo html_entity_decode($value['nestado']);?></td>             
                        <td><?php echo $value['fecha'];?></td>                        
                        <td> 
                        <div class="btn-group" role="group" aria-label="Basic example">
                        <?php if($value['estado'] > 2 || $value['alarmada'] == 1) {   ?>
                         <button type="button" id="btvhorario'<?php echo $value['id']; ?>'" onClick ="verProgramacion('<?php echo $value['id']; ?>');"  class="btn btn-info btn-sm"><i class="far fa-calendar-alt"></i>
                         </button> 
                        <?php }else{ ?>
                         <button type="button" id="btvhorario'<?php echo $value['id']; ?>'" class="btn btn-default btn-sm"><i class="far fa-calendar-alt"></i>
                         </button> 
                        <?php  } ?>                           
                         <button type="button" id="btvbitacora'<?php echo $value['id']; ?>'" onClick ="verMibitacora('<?php echo $value['id']; ?>');" class="btn btn-info btn-sm"><i class="fas fa-list-ol"></i></i>
                         </button>
                        </div>                        
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
