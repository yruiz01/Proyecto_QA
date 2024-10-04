<?php
// Activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.html");
} else {

    require 'header.php';

    if ($_SESSION['escritorio'] == 1) {
        require_once "../modelos/Consultas.php";
        $consulta = new Consultas();

        // Obtener el total de beneficiarios
        $rsptav = $consulta->cantidadbeneficiarios();
        $regv = $rsptav->fetch_object();
        $totalbeneficiarios = $regv->total_beneficiarios;
        $cap_almacen = 3000;
?>

        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="panel-body">
                                
                                <?php
                                // Obtener la lista de comunidades
                                $rspta = $consulta->listarComunidades();  // Asumimos que el método de listar comunidades está implementado
                                $colores = array(
                                    "box box-success direct-chat direct-chat-success bg-green", 
                                    "box box-primary direct-chat direct-chat-primary bg-aqua", 
                                    "box box-warning direct-chat direct-chat-warning bg-yellow", 
                                    "box box-danger direct-chat direct-chat-danger bg-red"
                                );
                                
                                // Iterar sobre las comunidades
                                while ($reg = $rspta->fetch_object()) {
                                    $id_comunidad = $reg->Id_Comunidad;  // Cambiado a Id_Comunidad
                                    $nombre_comunidad = $reg->Nombre_Comunidad;  // Cambiado a Nombre_Comunidad
                                ?>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <!-- DIRECT CHAT SUCCESS -->
                                    <div class="<?php echo $colores[array_rand($colores)]; ?> collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><?php echo $nombre_comunidad; ?></h3>

                                            <div class="box-tools pull-right">
                                                <span data-toggle="tooltip" title="Cantidad de Beneficiarios" class="badge">
                                                  <?php
                                                  // Obtener la cantidad de beneficiarios por comunidad
                                                  $rsptag = $consulta->cantidadBeneficiariosPorComunidad($id_comunidad);
                                                  $regrupo = $rsptag->fetch_object();
                                                  echo $regrupo->total_beneficiarios;
                                                  ?>
                                                </span>
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->

                                        <div class="box-body" style="">
                                            <!-- Conversations are loaded here -->
                                            <div class="direct-chat-messages">
                                                <!-- Mostrar los beneficiarios -->
                                                <div class="direct-chat-msg">
                                                  <?php
                                                  // Mostrar las imágenes de los beneficiarios por comunidad
                                                  $rsptas = $consulta->listarBeneficiariosPorComunidad($id_comunidad);
                                                  while ($reg = $rsptas->fetch_object()) {
                                                      if (empty($reg->foto)) {
                                                          echo '<img class="img-circle" src="../files/articulos/anonymous.png" height="50px" width="50px">';
                                                      } else {
                                                          echo '<img class="img-circle" src="../files/articulos/' . $reg->foto . '" height="50px" width="50px">';
                                                      }
                                                  }
                                                  ?>
                                                </div>
                                            </div>
                                            <!--/.direct-chat-messages-->
                                        </div>
                                        <!-- /.box-body -->

                                        <div class="box-footer" style="">
                                            <a href="vista_comunidad.php?id_comunidad=<?php echo $id_comunidad; ?>" class="btn btn-default form-control">Ir... <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                        <!-- /.box-footer-->
                                    </div>
                                    <!--/.direct-chat -->
                                </div>

                                <?php } ?>
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
}

ob_end_flush();
?>
