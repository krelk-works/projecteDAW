<?php
    require_once '../assets/libraries/TCPDF-main/tcpdf.php';
    if ($_SESSION['role'] != "convidat") {
        require_once "../models/artwork.php";
        $artwork = new Artwork();
        $pdf = $artwork->generatePDF();
        $pdf->Output('informe.pdf', 'I');
    }
?>