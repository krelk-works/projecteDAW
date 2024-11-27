<?php
include_once("../models/artwork.php");
if (isset($_GET['search'])) {
    $searchFilter = $_GET['search'];
    $model = new artwork();
    $data = $model->searchCanceledArtwork($searchFilter);
    echo json_encode($data);
}
?>