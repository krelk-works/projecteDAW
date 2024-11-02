<?php
$isApiCalled = false;

// APIS
// Establecer el tipo de respuesta como JSON
header("Content-Type: application/json");

// Leer el cuerpo de la solicitud JSON
$input = file_get_contents("php://input");
$data = json_decode($input, true); // Decodificar a un array asociativo

// Verificar si currentLocation está presente en los datos
if (isset($data['currentLocation'])) {
    include_once("../models/artwork.php");
    $currentLocations = $data['currentLocation'];
    $model = new Artwork();
    //$data = $model->getArtowrksByLocations($currentLocations);
    $isApiCalled = true;
    
    // Procesar $currentLocation según tus necesidades
    $response = [
        "status" => "success",
        "message" => "currentLocation received",
        "receivedData" => $currentLocation,
        "data" => $data,
    ];
} else {
    // Responder con un error si no se encuentra currentLocation
    $response = [
        "status" => "error",
        "message" => "currentLocation not provided"
    ];
}

// Limpiar el búfer de salida para evitar datos adicionales
ob_clean();
echo json_encode($response);

// En caso de no ser una solicitud de api cargamos el modelo para el controlador
!$isApiCalled ? include_once("models/artwork.php") : exit();

class ArtworkController
{

    public function getData($limit, $offset, $filter = null)
    {
        $artwork = new Artwork(); // Create a new user object.
        //$artwork->getInfo($Artwork_name); // Call the login method from the user object.
        $data = $artwork->getInfo($limit, $offset, $filter);
        return $data;
    }

    public function getTotalCount($filter = null)
    {
        $artwork = new Artwork(); // Create a new user object.
        $data = $artwork->getTotalCount($filter);
        return $data;
    }

    public function createArtwork(
        $nom_del_museu,
        $id_letter,
        $id_num1,
        $id_num2,
        $objecte,
        $descripcio,
        $procedencia,
        $data_registre,
        $creation_date,
        $height,
        $width,
        $depth,
        $titol,
        $originplace,
        $executionplace,
        $tiratge,
        $altres_numeros,
        $cost,
        $amount,
        $historia_objecte,
        $ubicacio,
        $autor,
        $material, /*$exposition, $cancel,*/
        $causa_baixa,
        $estat_conservacio,
        $datacio,
        $entry,
        $expositiontype,
        $classificacio_generica,
        $materialgettycode,
        $tecniquegetty
    ) {
        $artwork = new Artwork();
        $data = $artwork->createArtwork(
            $nom_del_museu,
            $id_letter,
            $id_num1,
            $id_num2,
            $objecte,
            $descripcio,
            $procedencia,
            $data_registre,
            $creation_date,
            $height,
            $width,
            $depth,
            $titol,
            $originplace,
            $executionplace,
            $tiratge,
            $altres_numeros,
            $cost,
            $amount,
            $historia_objecte,
            $ubicacio,
            $autor,
            $material, /*$exposition, $cancel,*/
            $causa_baixa,
            $estat_conservacio,
            $datacio,
            $entry,
            $expositiontype,
            $classificacio_generica,
            $materialgettycode,
            $tecniquegetty
        );
        return $data;
    }

    public function getArtworkData($id)
    {
        $artwork = new Artwork();
        $data = $artwork->getArtworkData($id);
        return $data;
    }

    public function updateArtwork($id, $artwork_data)
    {
        $artwork = new Artwork();
        $confirmation = $artwork->updateArtwork($id, $artwork_data);
        return $confirmation;
    }

    public function searchArtwork($searchFilter)
    {
        $artwork = new Artwork();
        $data = $artwork->searchArtwork($searchFilter);
        return $data;
    }

    public function getArtworkList($ID)
    {
        $artwork = new Artwork();
        $data = $artwork->getArtworkList($ID);
        return $data;
    }
}
?>