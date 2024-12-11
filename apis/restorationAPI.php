<?php
include_once("../models/restoration.php");
if (isset($_GET['search'])) {
    $searchFilter = $_GET['search'];
    $model = new Restoration();
    $data = $model->searchRestoration($searchFilter);
    echo json_encode($data);
}
?>