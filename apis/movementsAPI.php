<?php
include_once("../models/movements.php");
if (isset($_GET['search'])) {
    $searchFilter = $_GET['search'];
    $model = new Movement();
    $data = $model->searchMovements($searchFilter);
    echo json_encode($data);

    ob_clean();
}
?>