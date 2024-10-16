<?php
include_once("models/status.php");

class StatusController
{
    public function getStatus()
    {
        $status = new Status();
        $data = $status->getStatus();
        return $data;
    }

}
?>