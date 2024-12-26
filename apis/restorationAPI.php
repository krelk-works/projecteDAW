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

    include_once("../models/restoration.php");
    if (isset($_GET['search'])) {
        $searchFilter = $_GET['search'];
        $model = new Restoration();
        $data = $model->searchRestoration($searchFilter);
        echo json_encode($data);
    }
?>