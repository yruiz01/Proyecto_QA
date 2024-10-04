<?php 
// Activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {
  require 'header.php';
  if ($_SESSION['acceso'] == 1) {
?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Proyectos 
                  <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar">
                    <i class="fa fa-plus-circle"></i> Agregar
                  </button>
                </h1>
                <div class="box-tools pull-right"></div>
              </div>
              <!--box-header-->
              <!--centro-->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Archivo PDF</th>
                    <th>Estado</th>
                  </thead>
                  <tbody></tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Archivo PDF</th>
                    <th>Estado</th>
                  </tfoot>   
                </table>
              </div>
              <div class="panel-body" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                  <input type="hidden" name="idproyecto" id="idproyecto"> <!-- Campo oculto para el ID -->
                  
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Nombre(*):</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del proyecto" required>
                  </div>
                  
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Descripción(*):</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" maxlength="255" placeholder="Descripción del proyecto" required></textarea>
                  </div>
                  
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Fecha Inicio(*):</label>
                    <input class="form-control" type="date" name="fecha_inicio" id="fecha_inicio" required>
                  </div>
                  
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Fecha Fin(*):</label>
                    <input class="form-control" type="date" name="fecha_fin" id="fecha_fin" required>
                  </div>
                  
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Archivo PDF:</label>
                    <input class="form-control" type="file" name="archivo_pdf" id="archivo_pdf" accept="application/pdf">
                    <input type="hidden" name="archivoactual" id="archivoactual">
                    <a href="#" id="archivo_muestra" target="_blank">Ver archivo</a>
                  </div>
                  
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar">
                      <i class="fa fa-save"></i> Guardar
                    </button>
                    <button class="btn btn-danger" onclick="cancelarform()" type="button">
                      <i class="fa fa-arrow-circle-left"></i> Cancelar
                    </button>
                  </div>
                </form>
              </div>
              <!--fin centro-->
            </div>
          </div>
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
<?php 
  } else {
    require 'noacceso.php'; 
  }
  require 'footer.php';
?>
<script src="scripts/proyecto.js"></script>
<?php 
}
ob_end_flush();
?>
