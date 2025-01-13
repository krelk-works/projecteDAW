<?php
include_once("models/restoration.php");

class RestorationController
{
    public function getAllRestorations()
    {
        $restoration = new Restoration();
        $data = $restoration->getAllRestorations();
        return $data;
    }

    public function createRestoration($code, $start_date, $end_date, $comment, $authorised_worker_name, $artwork) {
        $restoration = new Restoration();
        $data = $restoration->createRestoration($code, $start_date, $end_date, $comment, $authorised_worker_name, $artwork);
        return $data;
    }
}
?>