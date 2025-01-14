<?php

if (isset($_GET['restore'])) {
    header('Content-Type: application/json');
    include_once("../models/backup.php");
    $request = file_get_contents('php://input');
    $data = json_decode($request, true); // Decodifica a un array asociativo
    $file = $data['file'];
    $reponse = [];
    if (!empty($file)) {
        $model = new backup();
        $result = $model->restore($file);
        if ($result) {
            $response['status'] = "success";
        } else {
            $response['status'] = "error";
        }
    }
    ob_clean();
    echo json_encode($response);
}