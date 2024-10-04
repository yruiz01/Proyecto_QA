<?php
// Activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['grupos'] == 1) {
?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Proyectos<button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>Agregar</button></h1>
                <div class="box-tools pull-right">
                  <a href="../vistas/vista_grupo.php?idgrupo=<?php echo $_GET["idgrupo"] ?>"><button class="btn btn-info"><i class='fa fa-arrow-circle-left'></i> Volver</button></a>
                </div>
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
                    <th>Estado</th>
                    <th>Fecha Alerta</th>
                    <th>Estado Alerta</th>
                    <th>Responsable</th>
                    <th>Contribución Proyecto</th>
                    <th>Archivo PDF</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Fecha Alerta</th>
                    <th>Estado Alerta</th>
                    <th>Responsable</th>
                    <th>Contribución Proyecto</th>
                    <th>Archivo PDF</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 400px;" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST" enctype="multipart/form-data">
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Nombre</label>
                    <input class="form-control" type="hidden" name="idcurso" id="idcurso">
                    <input type="hidden" id="idgrupo" name="idgrupo" value="<?php echo $_GET["idgrupo"]; ?>">
                    <input class="form-control" type="text" name="nombre" id="nombre" maxlength="50" placeholder="Nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Descripción</label>
                    <input class="form-control" type="text" name="descripcion" id="descripcion" maxlength="255" placeholder="Descripción">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Fecha de Inicio</label>
                    <input class="form-control" type="date" name="fecha_inicio" id="fecha_inicio" required>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Fecha de Fin</label>
                    <input class="form-control" type="date" name="fecha_fin" id="fecha_fin" required>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Fecha de Alerta</label>
                    <input class="form-control" type="date" name="fecha_alerta" id="fecha_alerta">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Estado de Alerta</label>
                    <select class="form-control" name="estado_alerta" id="estado_alerta">
                      <option value="Pendiente">Pendiente</option>
                      <option value="Enviado">Enviado</option>
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Responsable</label>
                    <input class="form-control" type="text" name="responsable" id="responsable" maxlength="100" placeholder="Responsable">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Contribución al Proyecto</label>
                    <input class="form-control" type="text" name="contribucion_proyecto" id="contribucion_proyecto" maxlength="255" placeholder="Contribución al Proyecto">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Archivo PDF</label>
                    <input class="form-control" type="file" name="archivo_pdf" id="archivo_pdf" accept="application/pdf">
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
<script src="scripts/cursos.js"></script>
<?php
}
ob_end_flush();
?>
