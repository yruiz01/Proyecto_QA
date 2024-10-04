<?php 
session_start();
require_once "../modelos/Usuario.php";

$usuario = new Usuario();

$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre_usuario = isset($_POST["nombre_usuario"]) ? limpiarCadena($_POST["nombre_usuario"]) : "";
$correo = isset($_POST["correo"]) ? limpiarCadena($_POST["correo"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$rol = isset($_POST["rol"]) ? limpiarCadena($_POST["rol"]) : "";
$tipo_usuario = isset($_POST["tipo_usuario"]) ? limpiarCadena($_POST["tipo_usuario"]) : "";
$password = isset($_POST["password"]) ? limpiarCadena($_POST["password"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$estado = isset($_POST["estado"]) ? limpiarCadena($_POST["estado"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':

        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
            }
        }

        // Hash SHA256 para la contraseña
        $clavehash = hash("SHA256", $password);

        if (empty($idusuario)) {
            $rspta = $usuario->insertar($nombre_usuario, $correo, $telefono, $rol, $tipo_usuario, $clavehash, $imagen, $estado);
            echo $rspta ? "Usuario registrado correctamente" : "No se pudo registrar el usuario";
        } else {
            $rspta = $usuario->editar($idusuario, $nombre_usuario, $correo, $telefono, $rol, $tipo_usuario, $imagen, $estado);
            echo $rspta ? "Usuario actualizado correctamente" : "No se pudo actualizar el usuario";
        }
    break;

    case 'desactivar':
        $rspta = $usuario->desactivar($idusuario);
        echo $rspta ? "Usuario desactivado correctamente" : "No se pudo desactivar el usuario";
    break;

    case 'activar':
        $rspta = $usuario->activar($idusuario);
        echo $rspta ? "Usuario activado correctamente" : "No se pudo activar el usuario";
    break;

    case 'mostrar':
        $rspta = $usuario->mostrar($idusuario);
        echo json_encode($rspta);
    break;

    case 'editar_clave':
        $clavehash = hash("SHA256", $password);
        $rspta = $usuario->editar_clave($idusuario, $clavehash);
        echo $rspta ? "Contraseña actualizada correctamente" : "No se pudo actualizar la contraseña";
    break;

    case 'listar':
        $rspta = $usuario->listar();
        $data = Array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => ($reg->Estado == 'Activo') ? 
                    '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->Id_Usuario . ')"><i class="fa fa-pencil"></i></button>' . ' ' . 
                    '<button class="btn btn-info btn-xs" onclick="mostrar_clave(' . $reg->Id_Usuario . ')"><i class="fa fa-key"></i></button>' . ' ' . 
                    '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->Id_Usuario . ')"><i class="fa fa-close"></i></button>' : 
                    '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->Id_Usuario . ')"><i class="fa fa-pencil"></i></button>' . ' ' . 
                    '<button class="btn btn-info btn-xs" onclick="mostrar_clave(' . $reg->Id_Usuario . ')"><i class="fa fa-key"></i></button>' . ' ' . 
                    '<button class="btn btn-primary btn-xs" onclick="activar(' . $reg->Id_Usuario . ')"><i class="fa fa-check"></i></button>',
                "1" => $reg->Nombre_Usuario,
                "2" => $reg->Correo,
                "3" => $reg->Telefono,
                "4" => $reg->Rol,
                "5" => $reg->tipo_usuario,
                "6" => "<img src='../files/usuarios/" . $reg->Imagen . "' height='50px' width='50px'>",
                "7" => ($reg->Estado == 'Activo') ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
            );
        }

        $results = array(
            "sEcho" => 1, // Info para datatables
            "iTotalRecords" => count($data), // Total de registros
            "iTotalDisplayRecords" => count($data), // Total de registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
    break;
    
    case 'verificar':
        // Validar si el usuario tiene acceso al sistema
        $nombre_usuario = $_POST['nombre_usuario'];
        $password = $_POST['password'];
    
        // Consulta para verificar usuario y contraseña
        $rspta = $usuario->verificar($nombre_usuario, $password);
        $fetch = $rspta->fetch_object();
    
        if (isset($fetch)) {
            // Declaramos las variables de sesión
            $_SESSION['idusuario'] = $fetch->Id_Usuario;
            $_SESSION['nombre'] = $fetch->Nombre_Usuario;
            $_SESSION['imagen'] = $fetch->Imagen;
            $_SESSION['correo'] = $fetch->Correo;
            $_SESSION['rol'] = $fetch->Rol;
    
            // Definir permisos por ejemplo por rol
            $_SESSION['escritorio'] = 1;  
            $_SESSION['comunidades'] = 1; 
            $_SESSION['acceso'] = 1;
            $_SESSION['actividades'] = 1;

        } else {
            // Si no se encuentra el usuario o contraseña incorrecta, no se definen las variables de sesión
            $_SESSION['escritorio'] = 0;
            $_SESSION['comunidades'] = 0;
            $_SESSION['acceso'] = 0;
            $_SESSION['actividades'] = 0;
        }
        echo json_encode($fetch);
    break;
    
}
?>
