<?php
require "../config/Conexion.php";

class Actividad {

    // Constructor vacío
    public function __construct() {
    }

    // Método para insertar una nueva actividad
    public function insertar($nombre, $descripcion, $block_id) {
        $sql = "INSERT INTO actividad (nombre, descripcion, block_id) 
                VALUES ('$nombre', '$descripcion', '$block_id')";
        return ejecutarConsulta($sql);
    }

    // Método para editar una actividad existente
    public function editar($id_actividad, $nombre, $descripcion, $block_id) {
        $sql = "UPDATE actividad 
                SET nombre='$nombre', descripcion='$descripcion', block_id='$block_id' 
                WHERE id_actividad='$id_actividad'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar los detalles de una actividad específica
    public function mostrar($id_actividad) {
        $sql = "SELECT * FROM actividad WHERE id_actividad='$id_actividad'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar actividades por `block_id`
    public function listar($block_id) {
        // Retirar cualquier echo o var_dump para evitar alterar la respuesta JSON
        $sql = "SELECT id_actividad, nombre, descripcion, block_id, is_active
                FROM actividad
                WHERE block_id = '$block_id'";
        return ejecutarConsulta($sql);
    }    
    
    // Método para desactivar una actividad
    public function desactivar($id_actividad) {
        $sql = "UPDATE actividad SET is_active='0' WHERE id_actividad='$id_actividad'";
        return ejecutarConsulta($sql);
    }

    // Método para activar una actividad desactivada
    public function activar($id_actividad) {
        $sql = "UPDATE actividad SET is_active='1' WHERE id_actividad='$id_actividad'";
        return ejecutarConsulta($sql);
    }
}
?>
