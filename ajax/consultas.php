<?php 
require_once "../modelos/Consultas.php";
if (strlen(session_id()) < 1) 
    session_start();

$consulta = new Consultas();

$user_id = $_SESSION["idusuario"];

switch ($_GET["op"]) {
    case 'lista_asistencia':
        $fecha_inicio = $_REQUEST["fecha_inicio"];
        $fecha_fin = $_REQUEST["fecha_fin"];
        $team_id = $_REQUEST["idgrupo"];

        $range = 0;
        if ($fecha_inicio <= $fecha_fin) {
            $range = ((strtotime($fecha_fin) - strtotime($fecha_inicio)) + (24 * 60 * 60)) / (24 * 60 * 60);
            if ($range > 31) {
                echo "<p class='alert alert-warning'>El Rango Máximo es 31 Días.</p>";
                exit(0);
            }
        } else {
            echo "<p class='alert alert-danger'>Rango Inválido</p>";
            exit(0);
        }

        require_once "../modelos/Beneficiarios.php";
        $beneficiario = new Beneficiarios();
        $rsptav = $beneficiario->verificar_beneficiario($user_id, $team_id);

        if (!empty($rsptav)) {
            // Si hay beneficiarios
            ?>
            <table id="dataw" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th>Nombre</th>
                    <?php for ($i = 0; $i < $range; $i++) { ?>
                        <th>
                            <?php echo date("d-M", strtotime($fecha_inicio) + ($i * (24 * 60 * 60))); ?>
                        </th>
                    <?php } ?>
                </thead>
                <?php
                $rspta = $beneficiario->listar_calif($user_id, $team_id);
                while ($reg = $rspta->fetch_object()) {
                    ?>
                    <tr>
                        <td style="width:250px;"><?php echo $reg->Nombre_Completo; ?></td>
                        <?php 
                        for ($i = 0; $i < $range; $i++) {
                            $date_at = date("Y-m-d", strtotime($fecha_inicio) + ($i * (24 * 60 * 60)));
                            $asist = $consulta->listar_asistencia($reg->Id_Beneficiario, $team_id, $date_at);
                            $regc = $asist->fetch_object();
                            ?> 
                            <td>
                            <?php
                            if ($regc != null) {
                                if ($regc->kind_id == 1) { echo "<strong>A</strong>"; }
                                else if ($regc->kind_id == 2) { echo "<strong>T</strong>"; }
                                else if ($regc->kind_id == 3) { echo "<strong>F</strong>"; }
                                else if ($regc->kind_id == 4) { echo "<strong>P</strong>"; }
                            }   
                            ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
            <?php
        } else {
            echo "<p class='alert alert-danger'>No hay Beneficiarios</p>";
        }
        ?>
        <script type="text/javascript">         
            tabla = $('#dataw').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ]
            });
        </script>
        <?php
    break;

    case 'lista_comportamiento':
        $fecha_inicio = $_REQUEST["fecha_inicioc"];
        $fecha_fin = $_REQUEST["fecha_finc"];
        $team_id = $_REQUEST["idgrupo"];

        $range = 0;
        if ($fecha_inicio <= $fecha_fin) {
            $range = ((strtotime($fecha_fin) - strtotime($fecha_inicio)) + (24 * 60 * 60)) / (24 * 60 * 60);
            if ($range > 31) {
                echo "<p class='alert alert-warning'>El Rango Máximo es 31 Días.</p>";
                exit(0);
            }
        } else {
            echo "<p class='alert alert-danger'>Rango Inválido</p>";
            exit(0);
        }

        require_once "../modelos/Beneficiarios.php";
        $beneficiario = new Beneficiarios();
        $rsptav = $beneficiario->verificar_beneficiario($user_id, $team_id);

        if (!empty($rsptav)) {
            // Si hay beneficiarios
            ?>
            <table id="dataco" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th>Nombre</th>
                    <?php for ($i = 0; $i < $range; $i++) { ?>
                        <th>
                            <?php echo date("d-M", strtotime($fecha_inicio) + ($i * (24 * 60 * 60))); ?>
                        </th>
                    <?php } ?>
                </thead>
                <?php
                $rspta = $beneficiario->listar_calif($user_id, $team_id);
                while ($reg = $rspta->fetch_object()) {
                    ?>
                    <tr>
                        <td style="width:250px;"><?php echo $reg->Nombre_Completo; ?></td>
                        <?php 
                        for ($i = 0; $i < $range; $i++) {
                            $date_at = date("Y-m-d", strtotime($fecha_inicio) + ($i * (24 * 60 * 60)));
                            $asist = $consulta->listar_comportamiento($reg->Id_Beneficiario, $team_id, $date_at);
                            $regc = $asist->fetch_object();
                            ?> 
                            <td>
                            <?php
                            if ($regc != null) {
                                if ($regc->kind_id == 1) { echo "<strong>N</strong>"; }
                                else if ($regc->kind_id == 2) { echo "<strong>B</strong>"; }
                                else if ($regc->kind_id == 3) { echo "<strong>E</strong>"; }
                                else if ($regc->kind_id == 4) { echo "<strong>M</strong>"; }
                                else if ($regc->kind_id == 5) { echo "<strong>MM</strong>"; }
                            }   
                            ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
            <?php
        } else {
            echo "<p class='alert alert-danger'>No hay Beneficiarios</p>";
        }
        ?>
        <script type="text/javascript">         
            tabla = $('#dataco').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ]
            });
        </script>
        <?php
    break;

    case 'listar_calificacion':
        require_once "../modelos/Beneficiarios.php";
        $beneficiario = new Beneficiarios();
        $team_id = $_REQUEST["idgrupo"];
        $rsptav = $beneficiario->verificar_beneficiario($user_id, $team_id);

        require_once "../modelos/Cursos.php";
        $cursos = new Cursos();
        $rsptac = $cursos->listar($team_id);

        if (!empty($rsptav)) {
            // Si hay beneficiarios
            ?>
            <table id="dataca" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th>Nombre</th>
                    <?php
                    // OBTENEMOS LOS DATOS DEL CURSO
                    while ($reg = $rsptac->fetch_object()) {
                        echo '<th>' . $reg->Nombre_Curso . '</th>';
                    } ?>
                </thead>
                <?php
                // OBTENEMOS LOS DATOS DEL BENEFICIARIO
                $rspta = $beneficiario->listar_calif($user_id, $team_id);
                while ($reg = $rspta->fetch_object()) {
                    ?>
                    <tr>
                        <td><?php echo $reg->Nombre_Completo; ?></td>

                        <?php
                        // OBTENEMOS EL ID DEL CURSO
                        $rsptacurso = $cursos->listar($team_id);
                        while ($regc = $rsptacurso->fetch_object()) {
                            $idcurso = $regc->Id_Curso;
                            $idbeneficiario = $reg->Id_Beneficiario; 

                            // OBTENEMOS LAS NOTAS ENVIANDO LOS PARÁMETROS ($idcurso Y $idbeneficiario)
                            require_once "../modelos/Calificaciones.php";
                            $calificaciones = new Calificaciones();
                            $rsptacalif = $calificaciones->listar_calificacion($idbeneficiario, $idcurso);
                            $regn = $rsptacalif->fetch_object(); ?>
                            <td><?php if ($regn != null) { echo $regn->val; } ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
            <?php
        } else {
            echo "<p class='alert alert-danger'>No hay Beneficiarios</p>";
        }
        ?>
        <script type="text/javascript">         
            tabla = $('#dataca').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ]
            });
        </script>
        <?php
    break;
}
?>
