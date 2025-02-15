<?php
    // CONSTANTS

    const HMTLDIR = __DIR__;

    const BACKUP_DIRECTORY = HMTLDIR.'/backups/';

    // Set the session cookie to 1 hour.
    ini_set('session.gc_maxlifetime', 3600);

    // Each client should remember their session id for EXACTLY 1 hour
    session_set_cookie_params(3600);

    // Set a custom session name.
    session_name("MuseuApellesFenosa"); 

    // Start the session.
    session_start();

        // Manejo de la acción 'save-movement'
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'save-movement') {
            require_once 'controllers/MovementsController.php';
            $controller = new MovementsController();
            $controller->editMovement();
            exit; // Asegúrate de detener el script después de procesar la solicitud
        }

    // Comprobamos si el usuario tiene permiso para descargar backups o generar PDFs
    if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
        // Check if the user wants to download a backup file and if the user is an admin
        if (isset($_GET['download_backup']) && $_SESSION['role'] == "admin") {
            $urlunformat = str_replace('%', ' ', $_GET['download_backup']);
            $filePath = BACKUP_DIRECTORY . $urlunformat;
        
            // Verifica si el archivo existe
            if (file_exists($filePath)) {
                // Establece las cabeceras para la descarga
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filePath));
        
                // Envía el archivo al navegador
                readfile($filePath);
        
                ob_clean();
                exit; // Termina el script después de la descarga
            }
        }
            
        // Check if the user wants to generate a PDF
        /*if (isset($_GET['generatePDF'])) {
            require_once "controllers/PDFController.php";
            $PDFController = new PDFController();
            return $PDFController->generatePDF();
        }
        else if (isset($_GET['generateInvididualPDF'])) {
            require_once "controllers/PDFController.php";
            $PDFController = new PDFController();
            return $PDFController->generateInvididualPDF($_GET['generateInvididualPDF']);
        }
        else if (isset($_GET['generateSimplePDF'])) {
            require_once "controllers/PDFController.php";
            $PDFController = new PDFController();
            return $PDFController->generateSimplePDF($_GET['generateSimplePDF']);
        }*/
        if (isset($_GET['generatePDF'])) {
            require_once "views/generatePDF/generatePDF.php";
        }
        else if (isset($_GET['generateIndividualPDF'])) {
            require_once "views/generatePDF/generateIndividualPDF.php";
        }
        else if (isset($_GET['generateSimplePDF'])) {
            require_once "views/generatePDF/generateSimplePDF.php";
        }
        else if (isset($_GET['generateCSV'])) {
            include_once("models/csv.php");
            $csvExport = new CSV();
            $csvExport->exportCSV();
        }
        else if (isset($_GET['generateDOCX'])) {
            include_once("models/docx.php");
            $docxExport = new DOCX();
            $docxExport->exportDOCX($_GET['generateDOCX']);
        }
    }
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <?php
        // Check if the user wants to logout
        if (isset($_GET['logout'])){
            session_unset();
            session_destroy();
            echo "<meta http-equiv='refresh' content='0;url=index.php'>";
        }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/fa.all.min.css">
    <link rel="stylesheet" href="assets/css/jstree.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- <link rel="stylesheet" href="assets/css/chosen.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- <script src="assets/js/chosen.jquery.min.js"></script> -->
    <script src="assets/js/duDatepicker.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/accordion-element.js" defer></script>
    <script src="assets/js/jstree.min.js" defer></script>
    <script src="assets/js/auto-capitalize.js" defer></script>

    

    <!--<script src="assets/js/main.js" defer></script>-->
    <title>Intranet - Apel·les Fenosa</title>
</head>
<body>
    <?php
        // Needed to include all classes created.
        require_once "autoload.php";

        // Check if the session is active and the user is logged in.
        if (session_status() != PHP_SESSION_NONE && isset($_SESSION['username'])) {
            if (!isset($_GET['generatePDF'])) {
                // Always include the navbar.
                require_once "views/navbar/navbar.php";
            }
            // Check what to load in the main content.
            if (isset($actualPage)) {
                switch ($actualPage) {
                    case 'inici':
                        require_once "views/search/search.php";
                        require_once "views/home-list/home-list.php";
                        break;
                    case 'usuaris':
                        require_once "views/create/create.php";
                        require_once "views/user-list/user-list.php";
                        break;
                    case 'localitzacions':
                        require_once "views/location-create/location-create.php";
                        require_once "views/location-list/location-list.php";
                        break;
                    case 'user-administration':
                        require_once "views/user-adiministration/user-administration-view.php";
                        break;
                    case 'backups':
                        require_once "views/backup-create/backup-create.php";
                        require_once "views/backup-list/backup-list.php";
                        break;
                    case 'artwork-create2':
                        require_once "views/artwork-create/artwork-create2.php";
                        break;
                    case 'artwork-update':
                        require_once "views/artwork-update/artwork-update.php";
                        break;
                    case 'artwork-view':
                        require_once "views/artwork-view/artwork-view.php";
                        break;
                    case 'vocabulari':
                        require_once "views/vocabulary/vocabulary.php";
                        break;
                    case 'artwork-administration':
                        require_once "views/artwork-administration/artwork-administration.php";
                        break;
                    case 'expositions':
                        require_once "views/exposition-aside/exposition-aside.php";
                        require_once "views/exposition/exposition.php";
                        break;
                    case 'exposition-administration':
                        require_once "views/add-artwork-to-exposition/add-artwork-to-exposition.php"; 
                        require_once "views/exposition-administration/exposition-administration.php";
                        break;
                    case 'moviments':
                        require_once "views/movement-create/movement-create.php";
                        require_once "views/movement-list/movement-list.php";
                        break;
                    case 'cancelacions':
                        require_once "views/cancelations-aside/cancelations-aside.php";
                        require_once "views/cancelations-list/cancelations-list.php";
                        break;
                    case 'restauracions':
                        require_once "views/restoration-aside/restoration-aside.php";
                        require_once "views/restoration-list/restoration-list.php";
                        break;
                    case 'restoration-create':
                        require_once "views/restoration-create/restoration-create.php";
                        break;
                }
            }
        }            
        // If the session is not active, then show the login view.
        else{
            if (!isset($_POST['username']) && !isset($_POST['password'])){
                $controller = new UserController();
                $controller->showLoginView();
            } else {
                if (isset($_POST['username']) && isset($_POST['password'])){
                    $controller = new UserController();
                    $isLoggedIn = $controller->login($_POST['username'], $_POST['password']);
                    
                    if (!$isLoggedIn) {
                        echo "<head><meta http-equiv='refresh' content='0;url=index.php?error-login'><head>";
                    }
                }
            }
        }
    ?>
</body>
</html>