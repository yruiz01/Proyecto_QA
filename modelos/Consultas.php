<?php 
// Incluir la conexión a la base de datos
require "../config/Conexion.php";

class Consultas {

    // Implementamos el constructor
    public function __construct() {}

    // Método para listar todas las comunidades
    public function listarComunidades() {
        $sql = "SELECT Id_Comunidad, Nombre_Comunidad FROM comunidad ORDER BY Id_Comunidad DESC";
        return ejecutarConsulta($sql);
    }

    // Método para obtener la cantidad de beneficiarios en una comunidad
    public function cantidadBeneficiariosPorComunidad($id_comunidad) {
        $sql = "SELECT COUNT(*) AS total_beneficiarios FROM beneficiarios WHERE Id_Comunidad = '$id_comunidad'";
        return ejecutarConsulta($sql);
    }

    // Método para listar beneficiarios por comunidad
    public function listarBeneficiariosPorComunidad($id_comunidad) {
        $sql = "SELECT Nombre_Completo, foto FROM beneficiarios WHERE Id_Comunidad = '$id_comunidad'";
        return ejecutarConsulta($sql);
    }

    // Cantidad total de beneficiarios
    public function cantidadbeneficiarios() {
        $sql = "SELECT COUNT(*) AS total_beneficiarios FROM beneficiarios";
        return ejecutarConsulta($sql);
    }
}
?>
