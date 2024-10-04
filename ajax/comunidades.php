<?php 
require_once "../modelos/Comunidades.php";
if (strlen(session_id()) < 1) 
    session_start();

$comunidades = new Comunidades();

$id_comunidad = isset($_POST["id_comunidad"]) ? limpiarCadena($_POST["id_comunidad"]) : "";
$nombre_comunidad = isset($_POST["nombre_comunidad"]) ? limpiarCadena($_POST["nombre_comunidad"]) : "";
$fecha_creacion = isset($_POST["fecha_creacion"]) ? limpiarCadena($_POST["fecha_creacion"]) : "";
$estado = isset($_POST["estado"]) ? limpiarCadena($_POST["estado"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($id_comunidad)) {
            $rspta = $comunidades->insertar($nombre_comunidad, $fecha_creacion, $estado);
            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        } else {
            $rspta = $comunidades->editar($id_comunidad, $nombre_comunidad, $fecha_creacion, $estado);
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        }
        break;
    
    case 'desactivar':
        $rspta = $comunidades->desactivar($id_comunidad);
        echo $rspta ? "Comunidad desactivada correctamente" : "No se pudo desactivar la comunidad";
        break;

    case 'activar':
        $rspta = $comunidades->activar($id_comunidad);
        echo $rspta ? "Comunidad activada correctamente" : "No se pudo activar la comunidad";
        break;

    case 'mostrar':
        $rspta = $comunidades->mostrar($id_comunidad);
        echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $comunidades->listar();
            $data = array();
        
            while ($reg = $rspta->fetch_object()) {
                // Verifica si realmente el valor de Estado es 1
                var_dump($reg); // Para depurar y ver el contenido de $reg
                $data[] = array(
                    "0" => '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->Id_Comunidad . ')"><i class="fa fa-pencil"></i></button>' . 
                           '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->Id_Comunidad . ')"><i class="fa fa-close"></i></button>',
                    "1" => $reg->Nombre_Comunidad,
                    "2" => $reg->Fecha_Creacion,
                    "3" => ($reg->Estado == 1) ? '<span class="label bg-green">Activo</span>' : '<span class="label bg-red">Inactivo</span>'
                );
            }
        
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
            break;
}
?>
