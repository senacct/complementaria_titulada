<?php
//include_once "models/conexion.php"; 
 echo '<script src="'.SERVERURL.'views/js/gestionUsuarios.03.js"></script>
      <script>
      $(".has-children").removeClass("active");
      $("#usuarios").addClass("active");
      </script>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="'.SERVERURL.'inicio/">Usuarios</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nuevo Usuario</li>
      </ol> 
       
';
  if(isset($_SESSION['prc_idusuario'])){ 
     $centro = $_SESSION['prc_centro'];
  ?>
  <form>
    <div class="form-group">
        <div class="row">
          <div class="col col-12 col-md-4">
          <label id="frmcorreosena" for="correosena" class="col-sm-12 col-form-label">Correo Sena<span id="sofia" style="color:green" ></span></label>
          <div class="input-group mb-4">
            <input id="correosena" type="text" class="form-control" maxlength="15">
              <div class="input-group-append">
               <span class="input-group-text" id="basic-addon2">@sena.edu.co</span>
              </div>
            </div>  
          </div> 
        <script>
              $(correosena).ready(function() {
              $("#correosena").focusout(function(){  
                  var dato = $(this).val(); 
                  validarcorreosena(dato);
                }) 
               }).trigger;
        </script> 
      <div class="col col-12 col-md-8">
      <label id="frmnombre"  for="nombre" class="col-sm-12 col-form-label">Nombre</label>
        <input id="nombre" type="text" class="form-control">
      </div>
      </div>
      <div class="row">
        <div class="col col-12 col-md-6">
          <label id="frmcorreootro" for="correootro" class="col-sm-12 col-form-label">Otro Correo<span id="sofia" style="color:green" ></span></label>
          <div class="input-group mb-3">
            <input id="correootro" type="text" class="form-control">
            </div>  
        </div> 
        <div class="col col-12 col-md-6">
          <label id="frmtelefono" for="telefono" class="col-sm-12 col-form-label">Teléfono<span id="sofia" style="color:green" ></span></label>
          <div class="input-group mb-3">
            <input id="telefono" type="text" class="form-control" maxlength="15" onkeypress="return soloNumeros(event)" onpaste="return false">
            </div>  
        </div> 
      </div>
      <span id="btnact"><div class="d-flex p-2 bd-highlight"><button id="btncrearusuario" type="button" onClick="crearusuario()" class="btn btn-success btn-sm">Enviar <i class="far fa-paper-plane"></i></button></div></span>
    <div id="msalida">
    </div> 
  </form>  
      <section>
      <ol>
        <li>Al correo SENA se enviarán por defecto, todas las notificaciones.</li>
        <li>Se da la opción de registrar otro correo para recibir notificaciones del estado de las fichas.</li>
      </ol>
    </section>  
  <?php
  }
  ?>
