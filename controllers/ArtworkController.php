<?php
include_once("models/artwork.php");

class ArtworkController
{

    public function getData($limit, $offset, $filter = null)
    {
        $artwork = new Artwork(); // Create a new user object.
        //$artwork->getInfo($Artwork_name); // Call the login method from the user object.
        $data = $artwork->getInfo($limit, $offset, $filter);
        return $data;
    }

    public function getTotalCount($filter = null)
    {
        $artwork = new Artwork(); // Create a new user object.
        $data = $artwork->getTotalCount($filter);
        return $data;
    }
}
?>