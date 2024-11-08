<?php
include_once("../models/user.php");
if (isset($_GET['search'])) {
    $searchFilter = $_GET['search'];
    $model = new user();
    $data = $model->searchUser($searchFilter);
    echo json_encode($data);
}
?>