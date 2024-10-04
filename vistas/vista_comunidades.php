<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {

require 'header.php';
if ($_SESSION['comunidades'] == 1) {

    $id_comunidad = $_GET['id_comunidad'];

    require_once "../modelos/Comunidades.php";
    $comunidades = new Comunidades();
    $rspta = $comunidades->mostrar_comunidad($id_comunidad); 
    $reg = $rspta->fetch_object();
    $nombre_comunidad = $reg->nombre;

 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">  
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Comunidad: <?php echo $nombre_comunidad; ?> <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i class="fa fa-plus-circle"></i>Agregar Beneficiario</button>  </h1>
   <a id="btnasistencia" href="asistencia.php?id_comunidad=<?php echo $id_comunidad; ?>" class="btn btn-warning"><i class='fa fa-check'></i> Asistencia a Actividades</a>
  <a  id="btnconducta" href="conducta.php?id_comunidad=<?php echo $id_comunidad; ?>" class="btn btn-primary"><i class='fa fa-smile-o'></i> Estado</a>
  <a id="btncalificaciones" href="calificaciones.php?id_comunidad=<?php echo $id_comunidad; ?>" class="btn btn-danger"><i class='fa fa-tasks'></i> Beneficios</a>
  <a id="btncursos" href="cursos.php?id_comunidad=<?php echo $id_comunidad; ?>" class="btn btn-primary"><i class='fa fa-th-large'></i> Proyectos</a>
  <a  id="btnlistas" href="listasis.php?id_comunidad=<?php echo $id_comunidad; ?>" class="btn btn-info"><i class='fa fa-th-list'></i> Listas</a>

  <div class="box-tools pull-right">
    <a id="btncomunidades" href="escritorio.php"><button class="btn btn-info"><i class='fa fa-th-large'></i> Comunidades</button></a>
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Opciones</th>
      <th>Imagen</th>
      <th>Nombre</th>
      <th>Apellidos</th>
      <th>Telefono</th>
      <th>Dirección</th>
      <th>Email</th>
      <!-- Nuevos campos -->
      <th>DPI</th>
      <th>Ocupación</th>
      <th>Edad</th>
      <th>Hijos</th>
      <th>Género</th>
      <th>Función</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Opciones</th>
      <th>Imagen</th>
      <th>Nombre</th>
      <th>Apellidos</th>
      <th>Telefono</th>
      <th>Dirección</th>
      <th>Email</th>
      <!-- Nuevos campos -->
      <th>DPI</th>
      <th>Ocupación</th>
      <th>Edad</th>
      <th>Hijos</th>
      <th>Género</th>
      <th>Función</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Nombres(*):</label>
      <input type="hidden" id="id_comunidad" name="id_comunidad" value="<?php echo $_GET["id_comunidad"];?>">
      <input class="form-control" type="hidden" name="idbeneficiario" id="idbeneficiario">
      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Apellidos(*):</label>
      <input class="form-control" type="text" name="apellidos" id="apellidos" maxlength="100" placeholder="Apellidos" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Dirección(*)</label>
      <input class="form-control" type="text" name="direccion" id="direccion" placeholder="Dirección" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Email(*)</label>
      <input class="form-control" type="email" name="email" id="email" maxlength="256" placeholder="ejemplo@ejemplo.com">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Teléfono(*)</label>
      <input class="form-control" type="text" name="telefono" id="telefono" placeholder="Teléfono" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Imagen:</label>
      <input class="form-control" type="file" name="imagen" id="imagen">
      <input type="hidden" name="imagenactual" id="imagenactual">
      <img src="" alt="" width="150px" height="120" id="imagenmuestra">
    </div>
    
    <!-- Nuevos campos -->
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">DPI:</label>
      <input class="form-control" type="text" name="dpi" id="dpi" maxlength="13" placeholder="DPI" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Ocupación:</label>
      <input class="form-control" type="text" name="ocupacion" id="ocupacion" maxlength="100" placeholder="Ocupación" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Edad:</label>
      <input class="form-control" type="number" name="edad" id="edad" placeholder="Edad" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Hijos:</label>
      <input class="form-control" type="number" name="hijos" id="hijos" placeholder="Número de hijos">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Género:</label>
      <select class="form-control" name="genero" id="genero">
        <option value="Masculino">Masculino</option>
        <option value="Femenino">Femenino</option>
      </select>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
    <label for="funcion">Función:</label>
    <select name="funcion" id="funcion" class="form-control" required>
        <option value="Socio">Socio</option>
        <option value="Participante">Participante</option>
        <option value="Guia">Guía</option>
    </select>
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
require 'footer.php'
?>
<script src="scripts/vista_comunidades.js"></script>

<?php 
}
ob_end_flush();
?>
