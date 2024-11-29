<?php
$isApiCalled = false;

$response = [];

// APIS
if (isset($_GET['location'])) {
    $isApiCalled = true;

    // Establecer el tipo de respuesta como JSON
    header("Content-Type: application/json");

    if ($_GET['location'] == "all") {
        // Nos aseguramos de cargar el modelo de Location
        include_once("../models/location.php");
        // ----------------------------------------------
        $location = new Location();
        $data=$location->getLocations();

        if (!empty($data)) {
            $data = json_encode($data);
        } else {
            $data = json_encode([]);
        }
        
        echo $data;
    }

    ob_clean();
}

// Add location to the database
// if (isset($_GET['add_location']) && ($_SESSION['role'] == 'admin' ) || ($_SESSION['role'] == 'tecnic')) {
if (isset($_GET['addlocation'])) {
    $isApiCalled = true;

    // Establecer el tipo de respuesta como JSON
    header("Content-Type: application/json");

    // Leer el cuerpo de la solicitud JSON
    $input = file_get_contents("php://input");

    // Recogemos los datos en bruto ya transformados a PHP
    $rawData = json_decode($input, true); // Decodificar a un array asociativo

    if (!empty($rawData)) {
        $parent = $rawData["parent"];
        $location_name = $rawData["name"];

        // Nos aseguramos de cargar el modelo de Location
        include_once("../models/location.php");

        // Crear la ubicacion en la base de datos
        $locationModel = new Location();

        try {
            $createdLocation = $locationModel->createLocation($location_name, $parent);
            if ($createdLocation) {
                $response = [
                    'status' => 'success',
                    'message' => 'Ubicació creada correctament.'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Error al crear la ubicació.'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'Error al crear la ubicació.'
            ];
        }

    }

    // Limpiar el búfer de salida para evitar datos adicionales
    ob_clean();
    echo json_encode($response);
}

// Mofidy location to the database
if (isset($_GET['modifylocation'])) {
    $isApiCalled = true;

    // Establecer el tipo de respuesta como JSON
    header("Content-Type: application/json");

    // Leer el cuerpo de la solicitud JSON
    $input = file_get_contents("php://input");

    // Recogemos los datos en bruto ya transformados a PHP
    $rawData = json_decode($input, true); // Decodificar a un array asociativo

    if (!empty($rawData)) {
        $id = $rawData["id"];
        $name = $rawData["name"];

        // Nos aseguramos de cargar el modelo de Location
        include_once("../models/location.php");

        // Crear la ubicacion en la base de datos
        $locationModel = new Location();

        try {
            $modifiedLocation = $locationModel->modifyLocation( $id, $name);
            if ($modifiedLocation) {
                $response = [
                    'status' => 'success',
                    'message' => 'Ubicació modificada correctament.'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Error al modificar la ubicació.'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'Error al modificar la ubicació.'
            ];
        }

    }

    // Limpiar el búfer de salida para evitar datos adicionales
    ob_clean();
    echo json_encode($response);
}

// Delete location to the database
if (isset($_GET['deletelocation'])) {
    $isApiCalled = true;

    // Establecer el tipo de respuesta como JSON
    header("Content-Type: application/json");

    // Leer el cuerpo de la solicitud JSON
    $input = file_get_contents("php://input");

    // Recogemos los datos en bruto ya transformados a PHP
    $rawData = json_decode($input, true); // Decodificar a un array asociativo

    if (!empty($rawData)) {
        $id = $rawData["id"];

        // Nos aseguramos de cargar el modelo de Location
        include_once("../models/location.php");

        // Crear la ubicacion en la base de datos
        $locationModel = new Location();

        try {
            $deletedLocation = $locationModel->deleteLocation($id);
            if ($deletedLocation) {
                $response = [
                    'status' => 'success',
                    'message' => 'Ubicació eliminada correctament.'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Error al eliminar la ubicació.'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'Error al eliminar la ubicació.'
            ];
        }

    }

    // Limpiar el búfer de salida para evitar datos adicionales
    ob_clean();
    echo json_encode($response);
}

// En caso de no ser una solicitud de api cargamos el modelo para el controlador
!$isApiCalled ? include_once("models/location.php") : exit();

class LocationController
{
    public function getLocations()
    {
        $location = new Location();
        $data = $location->getLocations();
        return $data;
    }

    public function createLocation($location_name, $parent)
    {
        $locationModel = new Location();
        return $locationModel->createLocation($location_name, $parent);
    }

    public function getTotalCount()
    {
        $location = new Location();
        $data = $location->getTotalCount();
        return $data;
    }

    public function getData($limit, $offset)
    {
        $location = new Location();
        $data = $location->getInfo($limit, $offset);
        return $data;
    }
    public function getLocationsJSON() 
    {
        $location = new Location();
        $data=$location->getLocationsJSON();
        return $data;
    }
}
?>