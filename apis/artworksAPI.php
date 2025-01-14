<?php
    const API_KEY = "a0cae8cf-4b15-4887-8b82-1499fd283396";

    // if (isset($_GET['api_key'])) {
    //     if ($_GET['api_key'] != API_KEY) {
    //         header("HTTP/1.1 401 Unauthorized");
    //         ob_clean();
    //         echo "HTTP/1.1 401 Unauthorized";
    //         exit;
    //     }
    // }

    if (isset($_GET['search'])) {
        header('Content-Type: application/json');
        include_once("../models/artwork.php");
        $searchFilter = $_GET['search'];
        $model = new artwork();
        $data = $model->searchArtwork($searchFilter);
        ob_clean();
        echo json_encode($data);
    }

    // if (isset($_GET['remfile'])) {
    //     header('Content-Type: application/json');
    //     include_once("../models/artwork.php");
    //     // Captura la solicitud JSON
    //     $request = file_get_contents('php://input');
    //     $data = json_decode($request, true); // Decodifica a un array asociativo
    //     $image = $data['image'];
    //     // echo $image;
    //     $reponse = [];
    //     if (!empty($image)) {
    //         $model = new artwork();
    //         $result = $model->removeFile($image);
    //         if ($result) {
    //             $response['status'] = "success";
    //         } else {
    //             $response['status'] = "error";
    //         }
    //     } else {
    //         $response['status'] = "error";
    //     }
    //     ob_clean();
    //     echo json_encode($response);
    // }

    if (isset($_GET['updateArtwork'])) {
        header('Content-Type: application/json');
        include_once("../models/artwork.php");
        $request = file_get_contents('php://input');
        $data = json_decode($request, true); // Decodifica a un array asociativo
        $artworkUpdated = $data['artwork'];
        $artworkId = $data['id'];
        $reponse = [];
        if (!empty($artworkUpdated)) {
            $model = new artwork();
            $result = $model->updateArtwork_($artworkId, $artworkUpdated);
            if ($result) {
                $response['status'] = "success";
            } else {
                $response['status'] = "error";
            }
        }
        ob_clean();
        echo json_encode($response);
    }

    if (isset($_GET['additionalimages'])) {
        header('Content-Type: application/json');
        include_once("../models/artwork.php");
        $request = file_get_contents('php://input');
        $data = json_decode($request, true); // Decodifica a un array asociativo
        $artworkId = $data['id'];
        $reponse = [];
        if (!empty($artworkId)) {
            $model = new artwork();
            $result = $model->getAdditionalImages($artworkId);
            if ($result) {
                $response['status'] = "success";
                $response['data'] = $result;
            } else {
                $response['status'] = "error";
            }
        }
        ob_clean();
        echo json_encode($response);
    }

    if (isset($_GET['artworkdocuments'])) {
        header('Content-Type: application/json');
        include_once("../models/artwork.php");
        $request = file_get_contents('php://input');
        $data = json_decode($request, true); // Decodifica a un array asociativo
        $artworkId = $data['id'];
        $reponse = [];
        if (!empty($artworkId)) {
            $model = new artwork();
            $result = $model->getArtworkDocuments($artworkId);
            if ($result) {
                $response['status'] = "success";
                $response['data'] = $result;
            } else {
                $response['status'] = "error";
            }
        }
        ob_clean();
        echo json_encode($response);
    }

    if (isset($_GET['artworkrefs'])) {
        header('Content-Type: application/json');
        include_once("../models/artwork.php");
        $request = file_get_contents('php://input');
        $data = json_decode($request, true); // Decodifica a un array asociativo
        $artworkId = $data['id'];
        $reponse = [];
        if (!empty($artworkId)) {
            $model = new artwork();
            $result = $model->getReferences($artworkId);
            if ($result) {
                $response['status'] = "success";
                $response['data'] = $result;
            } else {
                $response['status'] = "error";
            }
        }
        ob_clean();
        echo json_encode($response);
    }

    
?>