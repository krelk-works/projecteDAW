<?php
    if (isset($_GET['generatePDF'])) {
        require_once "controllers/PDFController.php";
    }
    // Set the session cookie to 1 hour.
    ini_set('session.gc_maxlifetime', 3600);

    // Each client should remember their session id for EXACTLY 1 hour
    session_set_cookie_params(3600);

    // Set a custom session name.
    session_name("MuseuApellesFenosa"); 

    // Start the session.
    session_start();
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    require_once "views/backup/backup.php";
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
                    $controller->login($_POST['username'], $_POST['password']);
                }
            }
        }
    ?>
</body>
</html>
