<?php
// Incluir la conexión de base de datos
require "../config/Conexion.php";

class Beneficiario {

    // Implementamos nuestro constructor
    public function __construct() {}

    // Método para insertar un nuevo registro en beneficiarios
    public function insertar($image, $name, $lastname, $email, $address, $phone, $c1_fullname, $c1_address, $c1_phone, $c1_note, $user_id, $team_id, $dpi, $ocupacion, $edad, $hijos, $genero, $funcion) {
        $sql = "INSERT INTO beneficiarios (foto, Nombre_Completo, Correo, Direccion, Telefono, dpi, ocupacion, edad, No_Hijos, genero, funcion, Estado, Id_Usuario)
                VALUES ('$image', '$name $lastname', '$email', '$address', '$phone', '$dpi', '$ocupacion', '$edad', '$hijos', '$genero', '$funcion', 'Activo', '$user_id')";
        
        $idbeneficiario_new = ejecutarConsulta_retornarID($sql);
        $sw = true;

        // Si existe una tabla de asignación entre beneficiarios y equipos
        $sql_detalle = "INSERT INTO beneficiario_team (Id_Beneficiario, team_id) VALUES('$idbeneficiario_new', '$team_id')";
        ejecutarConsulta($sql_detalle) or $sw = false;

        return $sw;
    }

    // Método para editar un registro
    public function editar($id, $image, $name, $lastname, $email, $address, $phone, $c1_fullname, $c1_address, $c1_phone, $c1_note, $user_id, $team_id, $dpi, $ocupacion, $edad, $hijos, $genero, $funcion) {
        $sql = "UPDATE beneficiarios SET foto='$image', Nombre_Completo='$name $lastname', Correo='$email', Direccion='$address', Telefono='$phone', dpi='$dpi', ocupacion='$ocupacion', edad='$edad', No_Hijos='$hijos', genero='$genero', funcion='$funcion'
                WHERE Id_Beneficiario='$id'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar un registro
    public function desactivar($id) {
        $sql = "UPDATE beneficiarios SET Estado='Inactivo' WHERE Id_Beneficiario='$id'";
        return ejecutarConsulta($sql);
    }

    // Método para activar un registro
    public function activar($id) {
        $sql = "UPDATE beneficiarios SET Estado='Activo' WHERE Id_Beneficiario='$id'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar los detalles de un beneficiario
    public function mostrar($id) {
        $sql = "SELECT Id_Beneficiario, foto, Nombre_Completo, Correo, Direccion, Telefono, dpi, ocupacion, edad, No_Hijos, genero, funcion 
                FROM beneficiarios WHERE Id_Beneficiario='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Listar los beneficiarios asignados a un equipo
    public function listar($user_id, $team_id) {
        $sql = "SELECT a.Id_Beneficiario, a.foto, a.Nombre_Completo, a.Correo, a.Direccion, a.Telefono, a.dpi, a.ocupacion, a.edad, a.No_Hijos, a.genero, a.funcion, a.Estado, a.Id_Usuario 
                FROM beneficiarios a 
                INNER JOIN beneficiario_team alt ON a.Id_Beneficiario = alt.Id_Beneficiario 
                WHERE a.Estado = 'Activo' AND a.Id_Usuario = '$user_id' AND alt.team_id = '$team_id' 
                ORDER BY a.Id_Beneficiario DESC";
        return ejecutarConsulta($sql);
    }

    // Verificar si un beneficiario ya está asignado a un equipo
    public function verficar_beneficiario($user_id, $team_id) {
        $sql = "SELECT * FROM beneficiarios a 
                INNER JOIN beneficiario_team alt ON a.Id_Beneficiario = alt.Id_Beneficiario 
                WHERE a.Estado = 'Activo' AND a.Id_Usuario = '$user_id' AND alt.team_id = '$team_id' 
                ORDER BY a.Id_Beneficiario DESC";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Listar beneficiarios para calificaciones (relacionado con equipos)
    public function listar_calif($user_id, $team_id) {
        $sql = "SELECT a.Id_Beneficiario, a.foto, a.Nombre_Completo, a.Correo, a.Direccion, a.Telefono, a.dpi, a.ocupacion, a.edad, a.No_Hijos, a.genero, a.funcion, a.Estado, a.Id_Usuario 
                FROM beneficiarios a 
                INNER JOIN beneficiario_team alt ON a.Id_Beneficiario = alt.Id_Beneficiario 
                WHERE a.Estado = 'Activo' AND a.Id_Usuario = '$user_id' AND alt.team_id = '$team_id' 
                ORDER BY a.Id_Beneficiario DESC";
        return ejecutarConsulta($sql);
    }
}
?>
