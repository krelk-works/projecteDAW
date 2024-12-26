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

    include_once("../models/artwork.php");
    if (isset($_GET['search'])) {
        $searchFilter = $_GET['search'];
        $model = new artwork();
        $data = $model->searchCanceledArtwork($searchFilter);
        echo json_encode($data);
    }
?>