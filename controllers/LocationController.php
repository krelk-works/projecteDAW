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
}
?>