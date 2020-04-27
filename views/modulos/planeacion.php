<?php
 include_once "controllers/planearController.php";
 include_once "models/planearModel.php"; 
 $codigo = explode("/", $_GET['modulo']);
    echo '<script>
          $(".has-children").removeClass("active");
          $("#programar").addClass("active");
      </script>';
    $modulo = $codigo[0];
    if(count($codigo) == 3){       
      if($codigo[1] == 'fichas' ||
         $codigo[1] == 'empresas'||
         $codigo[1] == 'status'||
         $codigo[1] == 'miplaneacion' || 
         $codigo[1] == 'horarioinstructor'){
        $modulo = $codigo[1]; 
      }else{
        $modulo = 'error';
      }
    } 
    if(count($codigo) == 5){       
      if($codigo[2] == 'formaciones'){
        $modulo = $codigo[2]; 
      }else{
        $modulo = 'error';
      }
    } 
    $a =  new GestionPlanearController();   
    echo $a->planearTemplateController($modulo);