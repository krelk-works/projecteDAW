<?php

    ini_set('session.gc_maxlifetime', 3600);

    // Each client should remember their session id for EXACTLY 1 hour
    session_set_cookie_params(3600);

    // Set a custom session name.
    session_name("MuseuApellesFenosa"); 

    // Start the session.
    session_start();

    // Check if the user wants to logout.
    if (isset($_GET['logout'])){
        session_unset();
        session_destroy();
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/general.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/search.css">
    <link rel="stylesheet" href="assets/css/home-list.css">
    <script src="assets/js/main.js" defer></script>
    <title>Intranet - Apel·les Fenosa</title>
</head>
<body>
    
    <?php
        // Needed to include all classes created.
        require_once "autoload.php";
        /*
        if (!is_writable(session_save_path())) {
            echo 'Session path "'.session_save_path().'" is not writable for PHP!'; 
            die();
        }
        */

        // Check if the session is active and the user is logged in.
        if (session_status() != PHP_SESSION_NONE && isset($_SESSION['username'])) {
            // Always include the navbar.
            require_once "views/navbar/navbar.php";
            //echo "<h1>Benvingut ".$_SESSION['username']."</h1>";

            // Check what to load in the main content.
            if (isset($actualPage)) {
                if ($actualPage == "inici") {
                    require_once "views/search/search.php";
                    require_once "views/home-list/home-list.php";
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
            if (isset($_POST['username']) && isset($_POST['password'])){
                $controller = new UserController();
                $controller->login($_POST['username'], $_POST['password']);
            } else {
                $controller = new UserController();
                $controller->showLoginView();
            }
        }
    ?>
</body>
</html>
