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

    
}
?>