<?php
include_once("../models/movements.php");
if (isset($_GET['search'])) {
    $searchFilter = $_GET['search'];
    $model = new Movement();
    $data = $model->searchMovements($searchFilter);

    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(array());
    }
    // echo json_encode($data);

    ob_clean();
}

if (isset($_GET['test'])) {
    echo "test-get DONE!";

    ob_clean();
}

if (isset($_GET['search-test'])) {
    $searchFilter = $_GET['search-test'];
    $model = new Movement();
    $data = $model->searchMovements($searchFilter);

    if ($data) {
        echo $data;
    } else {
        echo array();
    }
    // echo json_encode($data);

    ob_clean();
}
?>