<?php
include_once("../models/movements.php");

if (isset($_GET['search'])) {
    // Establecer el tipo de respuesta como JSON
    header("Content-Type: application/json");

    // Default response
    $response = [
        "status" => "error",
        "message" => "Ha ocurrido un error en la solicitud de obras por localización."
    ];

    $searchFilter = $_GET['search-test'];
    $model = new Movement();
    $data = $model->searchMovements($searchFilter);

    ob_clean();

    if ($data) {
        $response = [
            "status" => "success",
            "message" => "Movimientos obtenidos correctamente.",
            "data" => $data
        ];
        echo(json_encode($response));
    } else {
        echo(json_encode($response));
    }    
}
?>