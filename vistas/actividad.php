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
        <!-- Contenedor principal -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h1 class="box-title">Gestión de Actividades - Selecciona un Proyecto</h1>
                            <div class="box-tools pull-right">
                                <a href="../vistas/vista_grupo.php?idgrupo=<?php echo $_GET["idgrupo"]; ?>">
                                    <button class="btn btn-success"><i class='fa fa-arrow-circle-left'></i> Volver</button>
                                </a>
                                <!-- Campo oculto con el ID del grupo actual -->
                                <input type="hidden" id="idgrupo" name="idgrupo" value="<?php echo $_GET["idgrupo"]; ?>">
                            </div>
                        </div>

                        <!-- Selector del curso (proyecto) -->
                        <div class="form-inline col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <select name="curso" id="curso" class="form-control selectpicker" data-live-search="true" required>
                                <option value="">Seleccione un proyecto</option>
                            </select>
                        </div>

                        <!-- Formulario para agregar/editar actividad -->
                        <div class="panel-body">
                            <form action="" name="formulario" id="formulario" method="POST">
                                <div class="form-group">
                                    <input type="hidden" id="id_actividad" name="id_actividad">
                                    <input type="hidden" id="idcurso" name="idcurso">
                                    <label for="nombre">Nombre(*):</label>
                                    <input class="form-control" type="text" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción(*):</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                    <button class="btn btn-danger" type="button" id="btnCancelar" onclick="limpiar();"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                </div>
                            </form>
                        </div>

                        <!-- Tabla para listar las actividades -->
                        <div class="panel-body table-responsive" id="listadoregistros">
                            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Proyecto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Proyecto</th>
                                        <th>Estado</th>
                                    </tr>
                                </tfoot>
                            </table>
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
<!-- Carga del script específico de la vista -->
<script src="scripts/actividad.js"></script>

<script>
    // Cargar los proyectos en el selector y listar las actividades correspondientes
    $(document).ready(function () {
        var idGrupo = $("#idgrupo").val(); // Obtener el ID del grupo desde el campo oculto

        // Cargar los proyectos para el grupo actual
        $.post("../ajax/cursos.php?op=selectCursos", { idgrupo: idGrupo }, function (r) {
            $("#curso").html(r);
            $('#curso').selectpicker('refresh');

            // Una vez cargados los proyectos, activar el cambio de proyecto
            $("#curso").change(function () {
                var idcurso = $("#curso").val(); // Obtener el ID del proyecto seleccionado
                $("#idcurso").val(idcurso); // Asignarlo al campo oculto del formulario
                listar(); // Listar las actividades correspondientes
            });

            // Si ya hay un proyecto seleccionado, listarlo automáticamente
            if ($("#curso").val()) {
                listar(); // Llamar a listar actividades con el proyecto preseleccionado
            }
        });
    });
</script>

<?php 
}
ob_end_flush();
?>
