<?php
require_once "controllers/templateController.php"; 
require_once "models/templateModel.php";
require_once "controllers/enlacesController.php";  
require_once "routes/enlacesRoutesPublicoModel.php"; 
$template = new TemplateController();
$template->templatePrincipal(); 
