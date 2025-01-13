<?php
    const API_KEY = "a0cae8cf-4b15-4887-8b82-1499fd283396";

    if (isset($_GET['api_key'])) {
        if ($_GET['api_key'] != API_KEY) {
            header("HTTP/1.1 401 Unauthorized");
            ob_clean();
            echo "HTTP/1.1 401 Unauthorized";
            exit;
        }
    }

    if (isset($_GET['search'])) {
        // Establecer el tipo de respuesta como JSON
        header("Content-Type: application/json");

        include_once("../models/movements.php");

        // Default response
        $response = [
            "status" => "error",
            "message" => "Ha ocurrido un error en la solicitud de obras por localización."
        ];

        $searchFilter = $_GET['search'];
        $model = new Movement();
        $data = $model->searchMovements($searchFilter);

        ob_clean();

        if ($data) {
            $response = [
                "status" => "success",
                "message" => "Movimientos obtenidos correctamente.",
                "search" => $searchFilter,
                "movements" => $data
            ];
            echo(json_encode($response));
        } else {
            echo(json_encode($response));
        }    
    }
?>