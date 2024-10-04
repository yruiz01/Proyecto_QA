<?php
// Activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {
require 'header.php';

if ($_SESSION['comunidades'] == 1) {
?>
    <div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h1 class="box-title"><i class="fa fa-th-large"></i> Comunidades 
                <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true); setTodayDate();">
                  <i class="fa fa-plus-circle"></i> Agregar
                </button>
              </h1>
            </div>
            <div class="panel-body table-responsive" id="listadoregistros">
              <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th>Opciones</th>
                  <th>Nombre_Comunidad</th>
                  <th>Fecha_Creación</th>
                  <th>Estado</th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <th>Opciones</th>
                  <th>Nombre_Comunidad</th>
                  <th>Fecha_Creación</th>
                  <th>Estado</th>
                </tfoot>   
              </table>
            </div>
            <div class="panel-body" style="height: 400px;" id="formularioregistros">
              <form action="" name="formulario" id="formulario" method="POST">
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                  <label for="nombre_comunidad">Nombre</label>
                  <input class="form-control" type="hidden" name="id_comunidad" id="id_comunidad"> <!-- Campo oculto para el ID -->
                  <input class="form-control" type="text" name="nombre_comunidad" id="nombre_comunidad" maxlength="50" placeholder="Nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                  <label for="fecha_creacion">Fecha de Creación</label>
                  <input class="form-control" type="date" name="fecha_creacion" id="fecha_creacion" required>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <button class="btn btn-primary" type="submit" id="btnGuardar">
                    <i class="fa fa-save"></i> Guardar
                  </button>
                  <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar">
                    <i class="fa fa-arrow-circle-left"></i> Cancelar
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php 
} else {
 require 'noacceso.php'; 
}

require 'footer.php';
?>
<script src="scripts/comunidades.js"></script> 

<script>
   function setTodayDate() {
     const today = new Date();
     const day = String(today.getDate()).padStart(2, '0');
     const month = String(today.getMonth() + 1).padStart(2, '0'); 
     const year = today.getFullYear();
     const formattedDate = year + '-' + month + '-' + day;

     // Asignar la fecha actual al campo de fecha
     document.getElementById('fecha_creacion').value = formattedDate;
   }

   // Establecer la fecha cuando se hace clic en el botón "Agregar"
   document.getElementById('btnagregar').addEventListener('click', setTodayDate);
</script>
<?php 
}

ob_end_flush();
?>
