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
    
    include_once("../models/user.php");
    if (isset($_GET['search'])) {
        $searchFilter = $_GET['search'];
        $model = new user();
        $data = $model->searchUser($searchFilter);
        echo json_encode($data);
    }
?>