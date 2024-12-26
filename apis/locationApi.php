<?php
    if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
        $response = [
            "status" => "error",
            "message" => "Not authorized."
        ];
        ob_clean();
        echo json_encode($response);
        exit();
    }

    include_once "../controllers/LocationController.php";
    $LocationController = new LocationController;
    $data = $LocationController->getLocationsJSON();
    ob_clean();
    echo $data;
?>