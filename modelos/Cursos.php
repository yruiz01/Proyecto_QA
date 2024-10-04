<?php
require "../config/Conexion.php";

class Cursos {

    // Constructor
    public function __construct() {}

    // Método para insertar registros
    public function insertar($name, $team_id, $descripcion, $fecha_inicio, $fecha_fin, $fecha_alerta, $estado_alerta, $responsable, $contribucion_proyecto, $archivo_pdf){
        $sql = "INSERT INTO block (name, team_id, descripcion, fecha_inicio, fecha_fin, fecha_alerta, estado_alerta, responsable, contribucion_proyecto, archivo_pdf, is_active) 
                VALUES ('$name', '$team_id', '$descripcion', '$fecha_inicio', '$fecha_fin', '$fecha_alerta', '$estado_alerta', '$responsable', '$contribucion_proyecto', '$archivo_pdf', '1')";
        return ejecutarConsulta($sql);
    }

    // Método para editar registros
    public function editar($id, $name, $team_id, $descripcion, $fecha_inicio, $fecha_fin, $fecha_alerta, $estado_alerta, $responsable, $contribucion_proyecto, $archivo_pdf){
        $sql = "UPDATE block SET 
            name = '$name', 
            team_id = '$team_id', 
            descripcion = '$descripcion', 
            fecha_inicio = '$fecha_inicio', 
            fecha_fin = '$fecha_fin', 
            fecha_alerta = '$fecha_alerta', 
            estado_alerta = '$estado_alerta', 
            responsable = '$responsable', 
            contribucion_proyecto = '$contribucion_proyecto', 
            archivo_pdf = '$archivo_pdf'
        WHERE id = '$id'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar registros (poner is_active en 0)
    public function desactivar($id){
        $sql = "UPDATE block SET is_active='0' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Método para activar registros (poner is_active en 1)
    public function activar($id){
        $sql = "UPDATE block SET is_active='1' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar un registro
    public function mostrar($id){
        $sql = "SELECT * FROM block WHERE id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar registros por grupo
    public function listar($team_id){
        // Traer todos los registros sin filtrar por estado
        $sql = "SELECT id, name, team_id, descripcion, fecha_inicio, fecha_fin, is_active, fecha_alerta, estado_alerta, responsable, contribucion_proyecto, archivo_pdf 
                FROM block WHERE team_id='$team_id'";
        return ejecutarConsulta($sql);
    }
}
?>
