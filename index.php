<?php
    // CONSTANTS

    const HMTLDIR = __DIR__;

    const HOST = "";

    const BACKUP_DIRECTORY = '/var/www/html/backups/';

    // Check if the user wants to download a backup
    if (isset($_GET['download_backup'])) {
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
    
            //exit; // Termina el script después de la descarga
        }
    }

    // Set the session cookie to 1 hour.
    ini_set('session.gc_maxlifetime', 3600);

    // Each client should remember their session id for EXACTLY 1 hour
    session_set_cookie_params(3600);

    // Set a custom session name.
    session_name("MuseuApellesFenosa"); 

    // Start the session.
    session_start();
        
    // Check if the user wants to generate a PDF
    if (isset($_GET['generatePDF'])) {
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
    }
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <?php
        if (isset($_GET['logout'])){
            session_unset();
            session_destroy();
            echo "<meta http-equiv='refresh' content='0;url=index.php'>";
        }

        // RELOAD WEB PAGE FOR DEVELOPEMENT PURPOSES
        //echo "<meta http-equiv='refresh' content='2;url=index.php'>";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="assets/js/backup.js" defer></script>
    <script src="assets/js/vocabulary.js" defer></script>
    <script src="assets/js/artworksearcher.js" defer></script>
    <script src="assets/js/expositionsearcher.js" defer></script>
    <script src="assets/js/usersearcher.js" defer></script>
    <script src="assets/js/accordion-element.js" defer></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/fa.all.min.css">
   <!--<link rel="stylesheet" href="assets/css/main.css">-->    
    <link rel="stylesheet" href="assets/css/general.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/search.css">
    <link rel="stylesheet" href="assets/css/lists.css">
    <link rel="stylesheet" href="assets/css/create.css">
    <link rel="stylesheet" href="assets/css/backup.css">
    <link rel="stylesheet" href="assets/css/user-administration.css">
    <link rel="stylesheet" href="assets/css/locations.css">
    <link rel="stylesheet" href="assets/css/artwork-create.css">
    <link rel="stylesheet" href="assets/css/artwork-create2.css">
    <link rel="stylesheet" href="assets/css/vocabulary.css">
    <link rel="stylesheet" href="assets/css/exposition-list.css">
    <link rel="stylesheet" href="assets/css/create-exposition.css">
    <link rel="stylesheet" href="assets/css/exposition-administration.css">
    <link rel="stylesheet" href="assets/css/add-artwork-to-exposition.css">
    <link rel="stylesheet" href="assets/css/artwork-administration.css">

    <!--<script src="assets/js/main.js" defer></script>-->
    <title>Intranet - Apel·les Fenosa</title>
</head>
<body>
    <?php
        // Needed to include all classes created.
        require_once "autoload.php";
        /*Username
        if (!is_writable(session_save_path())) {
            echo 'Session path "'.session_save_path().'" is not writable for PHP!'; 
            die();
        }
        */


        // Check if the user wants to logout.
        // Check if the session is active and the user is logged in.
        if (session_status() != PHP_SESSION_NONE && isset($_SESSION['username'])) {
            if (!isset($_GET['generatePDF'])) {
                // Always include the navbar.
                require_once "views/navbar/navbar.php";
            }
            //echo "<h1>Benvingut ".$_SESSION['username']."</h1>";
            // Check what to load in the main content.
            if (isset($actualPage)) {
                if ($actualPage == "inici") {
                    require_once "views/search/search.php";
                    require_once "views/home-list/home-list.php";
                }
                else if ($actualPage == "usuaris") {
                    require_once "views/create/create.php";
                    require_once "views/user-list/user-list.php";
                }
                else if ($actualPage == "localitzacions") {
                    require_once "views/location-create/location-create.php";
                    require_once "views/location-list/location-list.php";
                }
                else if($actualPage=="user-administration"){
                    require_once "views/user-adiministration/user-administration-view.php";
                }
                else if ($actualPage == "usuarisfilter") {
                    require_once "views/search-user/search-user.php";
                    require_once "views/user-list/user-list.php";
                }
                else if ($actualPage == "backups") {
                    require_once "views/backup-create/backup-create.php";
                    require_once "views/backup-list/backup-list.php";
                }
                else if ($actualPage == "artwork-create") {
                    require_once "views/artwork-create/artwork-create.php";
                }
                else if ($actualPage == "artwork-create2") {
                    require_once "views/artwork-create/artwork-create2.php";
                }
                else if ($actualPage == "vocabulari") {
                    require_once "views/vocabulary/vocabulary.php";
                }
                else if ($actualPage == "artwork-administration") {
                    require_once "views/artwork-administration/artwork-administration.php";
                }
                else if ($actualPage == "expositions") {
                    require_once "views/exposition-aside/exposition-aside.php";
                    require_once "views/exposition/exposition.php";
                }
                else if ($actualPage == "exposition-administration") {
                    require_once "views/add-artwork-to-exposition/add-artwork-to-exposition.php"; 
                    require_once "views/exposition-administration/exposition-administration.php";
                }
            }

            
            if (isset($_GET['controller'])){
                // TODO
            }
            else{
                // TODO
            }

            // Check if the controller exists and we have an action to execute.
            //if (class_exists($nameController) && isset($_GET['action'])){
                // TODO
            //}else{
                // TODO
            //}
        }
        // If the session is not active, then show the login view.
        else{
            if (!isset($_POST['username']) && !isset($_POST['password'])){
                //new UserController().showLoginView();
                $controller = new UserController();
                $controller->showLoginView();
            } else {
                if (isset($_POST['username']) && isset($_POST['password'])){
                    $controller = new UserController();
                    $isLoggedIn = $controller->login($_POST['username'], $_POST['password']);
                    
                    if (!($isLoggedIn)) {
                        echo "<head><meta http-equiv='refresh' content='0;url=index.php?error-login'><head>";
                    }
                }
            }
        }
    ?>
</body>
</html>
