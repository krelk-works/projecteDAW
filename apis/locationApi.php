<?php
    include_once "../controllers/LocationController.php";

    $LocationController = new LocationController;
    $data = $LocationController->getLocationsJSON();
    echo $data;
?>