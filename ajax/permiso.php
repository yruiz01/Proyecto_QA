<?php 
require_once "../modelos/Permiso.php";

$categoria = new Permiso();

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $categoria->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->Nombre_Permiso 
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
