<?php
include_once("models/exposition.php");

class ExpositionController
{
    public function getActiveExpositions()
    {
        $exposition = new Exposition();
        $data = $exposition->getActiveExpositions();
        return $data;
    }

    public function getAllExpositions()
    {
        $exposition = new Exposition();
        $data = $exposition->getAllExpositions();
        return $data;
    }

    public function getRelatedArtworks($id)
    {
        $exposition = new Exposition();
        $data = $exposition->getRelatedArtworks($id);
        return $data;
    }

    public function createExposition($name, $expoloc, $expotype, $sd, $ed) {
        $exposition = new Exposition();
        $check = $exposition->createExposition($name, $expoloc, $expotype, $sd, $ed);
        return $check;
    }

    public function uploadArtworkToExposition($IDs, $expoID) {
        $exposition = new Exposition();
        $check = $exposition->uploadArtworkToExposition($IDs, $expoID);
        return $check;
    }

    public function deleteArtworkFromExposition ($expoID, $artworkID) {
        $exposition = new Exposition();
        $check = $exposition->deleteArtworkFromExposition($expoID, $artworkID);
        return $check;
    }
}
?>