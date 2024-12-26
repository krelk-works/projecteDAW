<?php
    const API_KEY = "a0cae8cf-4b15-4887-8b82-1499fd283396";

    if (isset($_GET['api_key'])) {
        if ($_GET['api_key'] != API_KEY) {
            header("HTTP/1.1 401 Unauthorized");
            ob_clean();
            echo "HTTP/1.1 401 Unauthorized";
            exit;
        }
    }

    header('Content-Type: application/json');
    include_once "../controllers/LocationController.php";
    $LocationController = new LocationController;
    $data = $LocationController->getLocationsJSON();
    ob_clean();
    echo $data;
?>