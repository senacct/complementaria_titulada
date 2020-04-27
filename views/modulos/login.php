<?php
 require_once "controllers/usuarioController.php";
 require_once "models/usuarioModel.php";
 //$codigo = explode("/", $_GET['modulo']);
    $a =  new GestionUsuarioController();   
    echo $a->templateIngresoController();