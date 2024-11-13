<?php
// Needed to include all classes created.
require_once "autoload.php";

echo "<h1>Artwork Create Required</h1><br><br>";
// echo "<br><h1>INPUTS: </h1><br>";
//var_dump($_POST);

// foreach ($_POST as $key => $value) {
//     echo "<span>[$key] => $value</span><br>";
// }

//echo "<br><h1>FILES: </h1><br><br>";
//var_dump($_FILES);


// Ruta de destino donde se guardará la imagen
$uploadDir = '/var/www/html/projecteDAW/uploads/';

// Arrays para almacenar solo los nombres de archivos de documentos e imágenes adicionales
$documents = [];
$additionalImages = [];

// Array para almacenar las referencias
$references = [];

// Función para subir cualquier tipo de archivo con un nombre único basado en timestamp
function uploadFile($file, $uploadDir)
{
    // Asigna un nombre único usando timestamp y extensión del archivo original
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = time() . "_" . rand(1000, 9999) . ".$extension";
    $destination = $uploadDir . $fileName;

    // Mueve el archivo al destino final
    move_uploaded_file($file['tmp_name'], $destination);
    return $fileName;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $files = $_FILES;
    $inputs = $_POST;

    if (!empty($files)) {
        // Subimos la imagen principal
        $mainImage = $_FILES['defaultimage'];
        $mainImageName = uploadFile($mainImage, $uploadDir);

        // Clasificar los archivos en documentos e imágenes adicionales
        foreach ($files as $key => $file) {
            if (strpos($key, 'document_') === 0 && !empty($file['name'])) {
                // Si la clave comienza con "document_", y el nombre no está vacío subimos el documento
                $documents[] = uploadFile($file, $uploadDir);
            } elseif (strpos($key, 'additional_image_') === 0 && !empty($file['name'])) {
                // Si la clave comienza con "additional_image_", es una imagen adicional
                $additionalImages[] = uploadFile($file, $uploadDir);
            }
        }
    }

    if (!empty($inputs)) {
        // Recorre los elementos en $data y clasifica los que tienen 'reference_name_' o 'reference_url_'
        foreach ($inputs as $key => $value) {
            // Verifica si la clave corresponde a un nombre de referencia
            if (preg_match('/^reference_name_(\d+)$/', $key, $matches)) {
                // Captura el número de la referencia
                $index = $matches[1];
                // Guarda el nombre en el índice correspondiente del array de referencias
                $references[$index]['name'] = $value;
            }
            // Verifica si la clave corresponde a una URL de referencia
            elseif (preg_match('/^reference_url_(\d+)$/', $key, $matches)) {
                // Captura el número de la referencia
                $index = $matches[1];
                // Guarda la URL en el índice correspondiente del array de referencias
                $references[$index]['url'] = $value;
            }
        }
        // Reindexa el array de referencias para que sea numérico consecutivo
        $references = array_values($references);

        var_dump($references);

        // Ahora viene lo shido.. U.U'

        $sqlfields = [];

        // Asignamos los valores de los campos sql con el mismo nombre de la base de datos para evitar errores
        if ($inputs['id_letter'] != "") {
            $sqlfields['id_letter'] = strtoupper($inputs['id_letter']);
        }
        $sqlfields['id_num1'] = $inputs['id_number'];
        if ($inputs['id_sub_number'] != "") {
            $sqlfields['id_num2'] = $inputs['id_sub_number'];
        }
        $sqlfields['name'] = $inputs['object_name'];
        $sqlfields['description'] = $inputs['artwork_description'];
        $sqlfields['provenancecollection'] = $inputs['origin_collection'];
        $sqlfields['register_date'] = $inputs['register_date'];
        $sqlfields['creation_date'] = $inputs['created_date'];
        $sqlfields['height'] = $inputs['artwork_height'];
        $sqlfields['width'] = $inputs['artwork_width'];
        $sqlfields['depth'] = $inputs['artwork_depth'];
        $sqlfields['title'] = $inputs['artwork_title'];
        $sqlfields['originplace'] = $inputs['origin_place'];
        $sqlfields['executionplace'] = $inputs['execution_place'];
        $sqlfields['triage'] = $inputs['tirage'];
        $sqlfileds['otheridnumbers'] = $inputs['id_other'];
        $sqlfields['cost'] = $inputs['artwork_price'];
        $sqlfields['amount'] = $inputs['artwork_quantity'];
        $sqlfields['history'] = $inputs['artwork_history'];
        $sqlfields['location'] = $inputs['locations_list'];
        $sqlfields['author'] = $inputs['author_names'];
        $sqlfields['material'] = $inputs['materials_list'];
        //$sqlfields['cancelcause'] = $inputs['cancel_cause_list'];
        $sqlfields['conservationstatus'] = $inputs['conservations_list'];
        $sqlfields['datation'] = $inputs['datations_list'];
        $sqlfields['entry'] = $inputs['entry_type_list'];
        $sqlfields['genericclassification'] = $inputs['generic_classification'];
        $sqlfields['materialgettycode'] = $inputs['getty_material_codes_list'];
        $sqlfields['tecnique'] = $inputs['tecniques_list'];
        $sqlfields['image'] = "uploads/".$mainImageName;

        $controller = new ArtworkController();
        $saved = $controller->addNewArtwork($sqlfields, $documents, $additionalImages, $references);

        if ($saved) {
            echo "<h1>Artwork saved successfully!</h1>";
            echo $saved;
        } else {
            echo "<h1>There was an error saving the artwork</h1>";
        }
    }
}

?>