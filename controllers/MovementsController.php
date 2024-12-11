<?php
$isApiCalled = false;

// APIS
if (isset($_GET['movement'])) {
    $isApiCalled = true;

    // Variable de respuesta
    $response = [
        "status" => "error",
        "message" => "Ha ocurrido un error en la solicitud de obras por localización."
    ];

    include_once("../models/movements.php");
    
    
    

    // Leer el cuerpo de la solicitud JSON
    $input = file_get_contents("php://input");
    // Recogemos los datos en bruto ya transformados a PHP
    $rawData = json_decode($input, true); // Decodificar a un array asociativo

    if (!empty($rawData)) {
        $startDate = $rawData["start_date"];
        $endDate = $rawData["end_date"];
        $place = $rawData["place"];
        $artwork = $rawData["artwork"];

        // Importamos el modelo de obra de arte para obtener obras según localización
        include_once("../models/movements.php");
        $model = new Movement();
        
        // Obtenemos los datos de las obras en las localizaciones correspondientes.
        $movementCallback = $model->createMovements($startDate, $endDate, $place, $artwork);
        // Configuramos los datos de la respuesta

        if ($movementCallback == 0) {
            $response = [
                "status" => "success",
                "message" => "Movimiento creado correctamente."
            ];
        } else if ($movementCallback == 1) {
            $response = [
                "status" => "success",
                "message" => "Error al crear el movimiento."
            ];
        } else if ($movementCallback == 2) {
            $response = [
                "status" => "error",
                "message" => "Ya existe un movimiento en las fechas indicadas."
            ];
        }
    } else {
        $response = [
            "status" => "error",
            "message" => "Ha ocurrido un error en la solicitud de obras por localización."
        ];
    }

    // Limpiar el búfer de salida para evitar datos adicionales
    ob_clean();
    echo json_encode($response);
}

if (isset($_GET['editMovement'])) {
    $isApiCalled = true;

    // Variable de respuesta
    $response = [
        "status" => "error",
        "message" => "Ha ocurrido un error en la modificación del movimiento."
    ];

    include_once("../models/movements.php");
    
    
    

    // Leer el cuerpo de la solicitud JSON
    $input = file_get_contents("php://input");
    // Recogemos los datos en bruto ya transformados a PHP
    $rawData = json_decode($input, true); // Decodificar a un array asociativo

    if (!empty($rawData)) {
        $id = $rawData["id"];
        $startDate = $rawData["start_date"];
        $endDate = $rawData["end_date"];
        $place = $rawData["place"];

        // Importamos el modelo de obra de arte para obtener obras según localización
        include_once("../models/movements.php");
        $model = new Movement();
        
        // Obtenemos los datos de las obras en las localizaciones correspondientes.
        $movementCallback = $model->editMovement($id, $startDate, $endDate, $place);
        // Configuramos los datos de la respuesta

        if ($movementCallback) {
            $response = [
                "status" => "success",
                "message" => "Movimiento editado correctamente."
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "Error al editar el movimiento."
            ];
        }
    } else {
        $response = [
            "status" => "error",
            "message" => "Ha ocurrido un error en la solicitud modificación de movimiento."
        ];
    }

    // Limpiar el búfer de salida para evitar datos adicionales
    ob_clean();
    echo json_encode($response);
}

// En caso de no ser una solicitud API, cargamos el modelo localmente
!$isApiCalled ? include_once("models/movements.php") : exit();

class MovementsController
{
    public function getAllMovements()
    {
        $movement = new Movement();
        $data = $movement->getAllMovements();
        return $data;
    }

    public function createMovement($sd, $ed, $place, $artwork)
    {
        $movement = new Movement();
        $check = $movement->createMovements($sd, $ed, $place, $artwork);
        return $check;
    }

    public function createMovementHandler()
    {
        // Validar que los datos necesarios están presentes
        $requiredFields = ['start_date', 'end_date', 'place', 'artwork'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                echo json_encode(['status' => 'error', 'message' => "El campo {$field} es obligatorio."]);
                return;
            }
        }

        $sd = $_POST['start_date'];
        $ed = $_POST['end_date'];
        $place = $_POST['place'];
        $artwork = $_POST['artwork'];

        $movement = new Movement();
        $check = $movement->createMovements($sd, $ed, $place, $artwork);

        if ($check) {
            echo json_encode(['status' => 'success', 'message' => 'Movimiento creado correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al crear el movimiento.']);
        }
    }

    public function editMovement() {
        header('Content-Type: application/json');

        $requiredFields = ['id', 'start_date', 'end_date', 'place'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                echo json_encode(['success' => false, 'message' => "El campo {$field} es obligatorio."]);
                return;
            }
        }

        $id = $_POST['id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $place = $_POST['place'];

        require_once 'models/Movement.php';
        $movement = new Movement();
        $result = $movement->editMovement($id, $start_date, $end_date, $place);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Movimiento editado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al editar el movimiento.']);
        }
    }
    
    
}
?>