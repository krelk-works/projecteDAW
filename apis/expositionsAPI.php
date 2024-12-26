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
    
    include_once("../models/exposition.php");
    if (isset($_GET['search'])) {
        $searchFilter = $_GET['search'];
        $model = new exposition();
        $data = $model->searchExposition($searchFilter);
        echo json_encode($data);
    }
?>