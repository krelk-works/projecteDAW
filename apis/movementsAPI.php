<?php
include_once("../models/movements.php");
if (isset($_GET['search'])) {
    $searchFilter = $_GET['search'];
    $model = new movements();
    $data = $model->searchMovement($searchFilter);
    echo json_encode($data);
}
?>