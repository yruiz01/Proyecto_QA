<?php 
//incluir la conexión de base de datos
require "../config/Conexion.php";

class Comunidad {

    // Implementamos nuestro constructor
    public function __construct() {}

    // Método para insertar un registro de comunidad
    public function insertar($nombre, $fecha_creacion) {
        $sql = "INSERT INTO comunidad (nombre, fecha_creacion, estado) 
                VALUES ('$nombre', '$fecha_creacion', '1')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un registro de comunidad
    public function editar($id_comunidad, $nombre, $descripcion, $localizacion) {
        $sql = "UPDATE comunidad
                SET nombre = '$nombre'
                WHERE id_comunidad = '$id_comunidad'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar una comunidad
    public function desactivar($id_comunidad) {
        $sql = "UPDATE comunidad SET estado = '0' WHERE id_comunidad = '$id_comunidad'";
        return ejecutarConsulta($sql);
    }

    // Método para activar una comunidad
    public function activar($id_comunidad) {
        $sql = "UPDATE comunidad SET estado = '1' WHERE id_comunidad = '$id_comunidad'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar los datos de una comunidad específica
    public function mostrar($id_comunidad) {
        $sql = "SELECT * FROM comunidad WHERE id_comunidad = '$id_comunidad'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Listar todas las comunidades
    public function listar() {
        $sql = "SELECT * FROM comunidad";
        return ejecutarConsulta($sql);
    }

    // Listar solo las comunidades activas
    public function listarActivas() {
        $sql = "SELECT * FROM comunidad WHERE estado = '1'";
        return ejecutarConsulta($sql);
    }
}
?>
