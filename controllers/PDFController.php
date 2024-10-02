<?php
    require_once '../assets/libraries/TCPDF-main/tcpdf.php';
    if ($_SESSION['role'] != "convidat") {
        require_once "../models/artwork.php";
        $artwork = new Artwork();
        $pdf = $artwork->generatePDF();
        $pdf->Output('informe.pdf', 'I');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</body>
</html>