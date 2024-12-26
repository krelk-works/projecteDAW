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

    if (isset($_GET['search'])) {
        header("Content-Type: application/json");
        include_once("../models/restoration.php");
        $searchFilter = $_GET['search'];
        $model = new Restoration();
        $data = $model->searchRestoration($searchFilter);
        echo json_encode($data);
    }
?>