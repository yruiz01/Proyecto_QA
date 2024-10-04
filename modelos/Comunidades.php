<?php 
// Incluir la conexión de base de datos
require "../config/Conexion.php";

class Comunidades {

    // Implementamos nuestro constructor
    public function __construct() {}

    // Método para insertar un nuevo registro con el estado 'activo' por defecto
    public function insertar($nombre_comunidad, $fecha_creacion) {
        $estado = '1'; // Definir el estado como 'activo' por defecto
        $sql = "INSERT INTO comunidad (Nombre_Comunidad, Fecha_Creacion, Estado) 
                VALUES ('$nombre_comunidad', '$fecha_creacion', '$estado')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un registro existente
    public function editar($id_comunidad, $nombre_comunidad, $estado) {
        $sql = "UPDATE comunidad
                SET Nombre_Comunidad='$nombre_comunidad', Estado='$estado' 
                WHERE Id_Comunidad='$id_comunidad'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar una comunidad (cambiar el estado a inactivo)
    public function desactivar($id_comunidad) {
        $sql = "UPDATE comunidad SET Estado='0' WHERE Id_Comunidad='$id_comunidad'";
        return ejecutarConsulta($sql);
    }

    // Método para activar una comunidad (cambiar el estado a activo)
    public function activar($id_comunidad) {
        $sql = "UPDATE comunidad SET Estado='1' WHERE Id_Comunidad='$id_comunidad'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar un registro en particular
    public function mostrar($id_comunidad) {
        $sql = "SELECT * FROM comunidad WHERE Id_Comunidad='$id_comunidad'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todas las comunidades
    public function listar() {
        $sql = "SELECT * FROM comunidad ORDER BY Id_Comunidad DESC";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar detalles de la comunidad
    public function mostrar_comunidad($id_comunidad) {
        $sql = "SELECT Id_Comunidad, Nombre_Comunidad, Estado 
                FROM comunidad 
                WHERE Id_Comunidad='$id_comunidad'";
        return ejecutarConsulta($sql);
    }
}
?>
