<?php 
include_once "routes/config.php"; 
?>
<!doctype html>
<html lang="es" class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Language" content="es" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<script src="<?php echo SERVERURL; ?>contents/jq/jquery-3.4.1.min.js"></script>
	<link href="<?php echo SERVERURL; ?>contents/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
	<script src="<?php echo SERVERURL; ?>contents/bootstrap/js/bootstrap.js"></script>		
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>contents/css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>contents/css/style.01.css"> <!-- Resource style -->
    <script src="<?php echo SERVERURL; ?>contents/js/sweetalert-dev.js"></script><!-- Alert -->
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL; ?>contents/css/sweetalert.css"><!-- Alert -->
    <link rel="stylesheet" href="<?php echo SERVERURL; ?>contents/css/toastr.css">
    <script src="<?php echo SERVERURL; ?>contents/js/toastr.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<!--Tablas-->
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>contents/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/r-2.2.3/rg-1.1.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/r-2.2.3/rg-1.1.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>
 	<script type="text/javascript" src="https:////cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
	<link rel="shortcut icon" href="../imgpg/favicon.png" type="image/png"/>
	<title>Complementaria | SENA</title>
</head>
<body>
	<header class="cd-main-header">
		<a href="#0" class="cd-logo"><span class="h4" style="color:orange;">Programación</span><span class="h4" style="color:#6363F9;">CENTRO</span>
		</a>  
		<a href="#0" class="cd-nav-trigger"> <span></span></a>
		<nav class="cd-nav">
			<ul class="cd-top-nav">
			</ul>
		</nav>
	</header> <!-- .cd-main-header -->
	<main class="cd-main-content">
<!--menu-->
    <div id="main-menu">
     <?php 
         $a =  new templateController();   
         echo $a->menuUsuarioActivoController();            
      ?>
    </div>  
<!--menu-->
		<div class="content-wrapper" >
			<div class="container-fluid">
					<?php
						$modulos = new EnlacesController();
						$modulos -> enlacesPublico(); 
					?>
					<div id="centro-content">					  
					</div> 
			</div>
		</div> <!-- .content-wrapper -->
	</main> <!-- .cd-main-content -->
	<div id="placemodal"></div>
<script src="<?php echo SERVERURL; ?>contents/js/jquery.menu-aim.js"></script>
<script src="<?php echo SERVERURL; ?>contents/js/main.js"></script> <!-- Resource jQuery -->
<script type="text/javascript">
</script>
</body>
</html>