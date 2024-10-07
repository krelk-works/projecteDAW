<?php
include_once("models/location.php");

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
}
?>