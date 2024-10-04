<?php
require "../config/Conexion.php";

class Proyecto {
    // Método para insertar un proyecto
    public function insertar($nombre, $descripcion, $fecha_inicio, $fecha_fin, $archivo_pdf) {
        $sql = "INSERT INTO proyectos (nombre, descripcion, fecha_inicio, fecha_fin, archivo_pdf)
                VALUES ('$nombre', '$descripcion', '$fecha_inicio', '$fecha_fin', '$archivo_pdf')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un proyecto
    public function editar($idproyecto, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $archivo_pdf) {
        $sql = "UPDATE proyectos SET nombre='$nombre', descripcion='$descripcion', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', archivo_pdf='$archivo_pdf'
                WHERE idproyecto='$idproyecto'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar los datos de un proyecto
    public function mostrar($idproyecto) {
        $sql = "SELECT * FROM proyectos WHERE idproyecto='$idproyecto'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los proyectos
    public function listar() {
        $sql = "SELECT * FROM proyectos";
        return ejecutarConsulta($sql);
    }

    // Método para eliminar un proyecto (desactivar)
    public function desactivar($idproyecto) {
        $sql = "UPDATE proyectos SET estado='0' WHERE idproyecto='$idproyecto'";
        return ejecutarConsulta($sql);
    }

    // Método para activar un proyecto
    public function activar($idproyecto) {
        $sql = "UPDATE proyectos SET estado='1' WHERE idproyecto='$idproyecto'";
        return ejecutarConsulta($sql);
    }

    // Método para eliminar un proyecto permanentemente
    public function eliminar($idproyecto) {
        $sql = "DELETE FROM proyectos WHERE idproyecto='$idproyecto'";
        return ejecutarConsulta($sql);
    }
}
?>
