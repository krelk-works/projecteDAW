<?php
$isApiCalled = false;

// APIS
if (isset($_GET['location'])) {
    $isApiCalled = true;
    if ($_GET['location'] == "all") {
        // Nos aseguramos de cargar el modelo de Location
        include_once("../models/location.php");
        // ----------------------------------------------
        $location = new Location();
        $data=$location->getLocationsJSON();
        echo $data;
    }
}

// En caso de no ser una solicitud de api cargamos el modelo para el controlador
!$isApiCalled ? include_once("models/location.php") : exit();

class LocationController
{
    public function getLocations()
    {
        $location = new Location();
        $data = $location->getLocations();
        return $data;
    }

    public function createLocation($location_name, $parent)
    {
        $locationModel = new Location();
        return $locationModel->createLocation($location_name, $parent);
    }

    public function getTotalCount()
    {
        $location = new Location();
        $data = $location->getTotalCount();
        return $data;
    }

    public function getData($limit, $offset)
    {
        $location = new Location();
        $data = $location->getInfo($limit, $offset);
        return $data;
    }
    public function getLocationsJSON() 
    {
        $location = new Location();
        $data=$location->getLocationsJSON();
        return $data;
    }
}
?>