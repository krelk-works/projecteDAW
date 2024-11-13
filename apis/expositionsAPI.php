<?php
include_once("../models/exposition.php");
if (isset($_GET['search'])) {
    $searchFilter = $_GET['search'];
    $model = new exposition();
    $data = $model->searchExposition($searchFilter);
    echo json_encode($data);
}
?>