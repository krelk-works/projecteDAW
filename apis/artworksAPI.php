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
        header('Content-Type: application/json');
        include_once("../models/artwork.php");
        $searchFilter = $_GET['search'];
        $model = new artwork();
        $data = $model->searchArtwork($searchFilter);
        ob_clean();
        echo json_encode($data);
    }

    if (isset($_GET['remfile'])) {
        header('Content-Type: application/json');
        include_once("../models/artwork.php");
        $file = $_GET['remfile'];
        $model = new artwork();
        $result = $model->removeFile($file);
        $reponse = [];
        if ($result) {
            $response['status'] = "success";
        } else {
            $response['status'] = "error";
        }
        ob_clean();
        echo json_encode($response);
    }

    
?>