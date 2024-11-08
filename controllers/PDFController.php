<?php
    require_once 'vendor/autoload.php';
    if ($_SESSION['role'] != "convidat") {
        require_once "models/artwork.php";
        $artwork = new Artwork();
        $pdf = $artwork->generatePDF();
        $pdf->output('llistat_complet_obres.pdf');
    }
?>