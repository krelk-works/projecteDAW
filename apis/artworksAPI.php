<?php
include_once("../models/artwork.php");
if (isset($_GET['search'])) {
    $searchFilter = $_GET['search'];
    $model = new artwork();
    $data = $model->searchArtwork($searchFilter);
    echo json_encode($data);
}
?>