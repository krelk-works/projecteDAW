
<?php 
// Needed to include all classes created.
require_once "autoload.php";

echo "<h1>Artwork Create Required</h1><br><br>";
var_dump($_POST);
var_dump($_FILES);

// Ruta de destino donde se guardará la imagen
$uploadDir = '/var/www/html/projecteDAW/uploads/';

// Verifica si se envió el formulario y si la imagen principal está presente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['defaultimage'])) {
    $mainImage = $_FILES['defaultimage'];
    uploadMainImage($mainImage, $uploadDir);
}

// Función para subir la imagen principal con un nombre único basado en timestamp
function uploadMainImage($image, $uploadDir) {
    // Asigna un nombre único usando timestamp y extensión del archivo original
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $fileName = time() . "_" . rand(1000, 9999) . ".$extension";
    $destination = $uploadDir . $fileName;

    // Mueve el archivo al destino final
    move_uploaded_file($image['tmp_name'], $destination);
}
?>