<?php
$isApiCalled = false;

// APIS
if (isset($_GET['getArtworksAtLocations'])) {
    // Declaramos que la API ha sido llamada para evitar usar resto del Controlador.
    $isApiCalled = true;

    // Establecer el tipo de respuesta como JSON
    header("Content-Type: application/json");

    // Variable de respuesta
    $response = [];

    // Leer el cuerpo de la solicitud JSON
    $input = file_get_contents("php://input");
    // Recogemos los datos en bruto ya transformados a PHP
    $rawData = json_decode($input, true); // Decodificar a un array asociativo

    // Si hay datos en el rawData los procesamos
    if (!empty($rawData)) {
        // Recogemos la lista de Localizaciones de la cual queremos obtener obras
        $locationsOfArtworks = $rawData["currentLocation"];
        // Tranformamos la lista de array de numeros a string para posterior busqueda SQL.
        $idsOnString = implode(",", $locationsOfArtworks);
        // Importamos el modelo de obra de arte para obtener obras según localización
        include_once("../models/artwork.php");
        // Declaramos el modelo que usaremos.
        $model = new Artwork();
        // Obtenemos los datos de las obras en las localizaciones correspondientes.
        $artworksCallback = $model->getArtowrksByLocations($idsOnString);
        // Configuramos los datos de la respuesta
        $response = [
            "status" => "success",
            "message" => $artworksCallback,
        ];
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

if (isset($_GET['getNextId'])) {
    // Declaramos que la API ha sido llamada para evitar usar resto del Controlador.
    $isApiCalled = true;

    // Establecer el tipo de respuesta como JSON
    header("Content-Type: application/json");

    // Leer el cuerpo de la solicitud JSON
    $input = file_get_contents("php://input");

    // Recogemos los datos en bruto ya transformados a PHP
    $rawData = json_decode($input, true); // Decodificar a un array asociativo

    // Importamos el modelo de obra de arte para obtener obras según localización
    include_once("../models/artwork.php");

    // Variable de respuesta
    $response = [];

    // Si hay datos en el rawData los procesamos
    if (!empty($rawData)) {
        // Recogemos la lista de Localizaciones de la cual queremos obtener obras
        $letter = $rawData["letter"];

        // Importamos el modelo de obra para buscar la siguiente ID según la letra
        $model = new Artwork();

        // Obtenemos la siguiente ID según la letra
        $nextIdCallback = $model->getLastIdByLetter($letter);

        if ($nextIdCallback === false) {
            $response = [
                "status" => "error",
                "message" => "Ha ocurrido un error al obtener la siguiente ID."
            ];
        } else {
            $response = [
                "status" => "success",
                "message" => $nextIdCallback,
            ];
        }
    }

    // Limpiar el búfer de salida para evitar datos adicionales
    ob_clean();
    echo json_encode($response);
}

if (isset($_GET['isIdentifiersValid'])) {
    // Declaramos que la API ha sido llamada para evitar usar resto del Controlador.
    $isApiCalled = true;

    // Establecer el tipo de respuesta como JSON
    header("Content-Type: application/json");

    // Leer el cuerpo de la solicitud JSON
    $input = file_get_contents("php://input");

    // Recogemos los datos en bruto ya transformados a PHP
    $rawData = json_decode($input, true); // Decodificar a un array asociativo

    // Variable de respuesta
    $response = [];

    // Si hay datos en el rawData los procesamos
    if (!empty($rawData)) {
        // Recogemos la lista de Localizaciones de la cual queremos obtener obras
        $letter = $rawData["letter"];
        $number = $rawData["number"];
        $subnumber = $rawData["subnumber"];

        // Importamos el modelo de obra para buscar la siguiente ID según la letra
        include_once("../models/artwork.php");

        $model = new Artwork();

        // Verificamos si el conjunto de identificadores es válido
        $isValid = $model->isIdentifiersValid($letter, $number, $subnumber);

        if ($isValid === false) {
            $response = [
                "status" => "error",
                "message" => "El conjunto de identificadores no es válido."
            ];
        } else {
            $response = [
                "status" => "success",
                "message" => "El conjunto de identificadores es válido."
            ];
        }
    }

    // Limpiar el búfer de salida para evitar datos adicionales
    ob_clean();
    echo json_encode($response);
}

if (isset($_GET['getFormData'])) {
    // Declaramos que la API ha sido llamada para evitar usar resto del Controlador.
    $isApiCalled = true;

    // Establecer el tipo de respuesta como JSON
    header("Content-Type: application/json");

    // Importamos el modelo de obra de arte para obtener obras según localización
    include_once("../models/artwork.php");

    // Variable de respuesta
    $response = [];

    // Importamos el modelo de obra para buscar la siguiente ID según la letra
    $model = new Artwork();

    // Obtenemos los datos que se necesitan para el formulario
    $formData = $model->getFormData();

    if ($formData === false) {
        $response = [
            "status" => "error",
            "message" => "Ha ocurrido un error al obtener los datos del formulario."
        ];
    } else {
        $response = [
            "status" => "success",
            "message" => $formData,
        ];
    }

    // Limpiar el búfer de salida para evitar datos adicionales
    ob_clean();
    echo json_encode($response);
}

// En caso de no ser una solicitud de api cargamos el modelo para el controlador
!$isApiCalled ? include_once("models/artwork.php") : exit();

class ArtworkController
{

    public function getNextIdNum1()
    {
        // Crear una nueva instancia de Artwork (suponiendo que tu modelo se llama Artwork)
        $artwork = new Artwork();

        // Llamar al método en el modelo para obtener el siguiente ID
        $data = $artwork->getNextIdNum1();

        return $data;
    }



    public function getData($limit, $offset, $filter = null)
    {
        $artwork = new Artwork(); // Create a new user object.
        //$artwork->getInfo($Artwork_name); // Call the login method from the user object.
        $data = $artwork->getInfo($limit, $offset, $filter);
        return $data;
    }

    public function getLastIdByLetter($letter)
    {
        $artwork = new Artwork(); // Create a new user object.
        $data = $artwork->getLastIdByLetter($letter);
        return $data;
    }

    public function getTotalCount($filter = null)
    {
        $artwork = new Artwork(); // Create a new user object.
        $data = $artwork->getTotalCount($filter);
        return $data;
    }

    public function updateIdLetter()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_letter'])) {
            $idLetter = $_POST['id_letter'];

            // Simplemente devolvemos el id_letter recibido en la respuesta
            echo json_encode(['success' => true, 'id_letter' => $idLetter]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se recibió el ID Letter correctamente.']);
        }
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
        $tecniquegetty,
        $image
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
            $tecniquegetty,
            $image
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