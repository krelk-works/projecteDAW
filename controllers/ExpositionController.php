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

    public function createExposition($name, $expoloc, $expotype, $sd, $ed) {
        $exposition = new Exposition();
        $check = $exposition->createExposition($name, $expoloc, $expotype, $sd, $ed);
        return $check;
    }
}
?>