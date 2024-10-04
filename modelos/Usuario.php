<?php
require "../config/Conexion.php";

class Usuario {
    // Constructor vacío
    public function __construct() {}

    // Método para verificar si el usuario existe en la base de datos
    public function verificar($nombre_usuario, $clavehash) {
        $sql = "SELECT Id_Usuario, Nombre_Usuario, Correo, Rol, Tipo_Usuario, Imagen 
                FROM usuarios 
                WHERE Nombre_Usuario='$nombre_usuario' 
                AND Password='$clavehash' 
                AND Estado='Activo'";
        return ejecutarConsulta($sql);
    }

    // Método para obtener los permisos de un rol
    public function obtenerPermisosPorRol($rol) {
        $sql = "SELECT p.Nombre_Permiso 
                FROM rol_permiso rp 
                JOIN permisos p ON rp.Id_Permiso = p.Id_Permiso 
                WHERE rp.Id_Rol = '$rol'";
        return ejecutarConsulta($sql);
    }

    // Método para insertar un nuevo usuario
    public function insertar($nombre_usuario, $correo, $telefono, $rol, $tipo_usuario, $password, $imagen, $estado) {
        $sql = "INSERT INTO usuarios (Nombre_Usuario, Correo, Telefono, Rol, Tipo_Usuario, Password, Estado, Fecha_Creacion, Ultimo_Ingreso, Imagen) 
                VALUES ('$nombre_usuario', '$correo', '$telefono', '$rol', '$tipo_usuario', '$password', 
                        '$estado', CURDATE(), NULL, '$imagen')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un usuario existente
    public function editar($idusuario, $nombre_usuario, $correo, $telefono, $rol, $tipo_usuario, $imagen, $estado) {
        $sql = "UPDATE usuarios 
                SET Nombre_Usuario='$nombre_usuario', Correo='$correo', Telefono='$telefono', 
                    Rol='$rol', Tipo_Usuario='$tipo_usuario', Imagen='$imagen', Estado='$estado' 
                WHERE Id_Usuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    // Método para editar la contraseña de un usuario
    public function editar_clave($idusuario, $password) {
        $sql = "UPDATE usuarios SET Password='$password' WHERE Id_Usuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar un usuario (cambiar su estado a "Inactivo")
    public function desactivar($idusuario) {
        $sql = "UPDATE usuarios SET Estado='Inactivo' WHERE Id_Usuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    // Método para activar un usuario (cambiar su estado a "Activo")
    public function activar($idusuario) {
        $sql = "UPDATE usuarios SET Estado='Activo' WHERE Id_Usuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar los datos de un usuario específico
    public function mostrar($idusuario) {
        $sql = "SELECT * FROM usuarios WHERE Id_Usuario='$idusuario'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los usuarios
    public function listar() {
        $sql = "SELECT * FROM usuarios";
        return ejecutarConsulta($sql);
    }
}
?>
