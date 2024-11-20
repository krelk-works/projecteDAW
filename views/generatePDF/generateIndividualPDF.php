<?php
    require_once "controllers/PDFController.php";
    $PDFController = new PDFController();
    $data = $PDFController->generateInvididualPDF($_GET['generateInvididualPDF']);

    $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A3', 'es');
        
    $htmlContent = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            * {
                color: rgb(50, 50, 50);
                font-size: 18px;
            }
            body {
                font-family: Arial, sans-serif;
                text-align: center;
            }
            .header {
                padding-top: 20px;
                padding-bottom: 20px;
                width: 100%;
                max-width: 630px;
                margin: 0 auto;
                text-align: center;
            }
            h1 {
                font-size: 30px;
            }
            h2 {
                margin: 0;
                padding: 0;
                font-size: 18px;
                font-weight: normal;
            }
            img {
                max-width: 160px;
                max-height: 160px;
            }
            .main {
                width: 100%;
                max-width: 630px;
                margin: 0 auto;
                text-align: left;
            }
            table {
                width: 100%;
                margin: 10px 0;
                border-collapse: collapse;
                align-items: center;
                justify-content: center;
            }
            tr {
                align-items: center;
                justify-content: center;
            }
            td {
                font-size: 18px;
            }
            .label, .value {
                font-size: 14px;
                padding: 5px;
                vertical-align: top;
                align-items: center;
                justify-content: center;
            }
            .label {
                width: 50%;
                font-weight: bold;
                text-align: left;
            }
            .value {
                width: 50%;
                text-align: left;
            }
            .page-break { page-break-before: always; }
        </style>
    </head>
    <body>';
    
    foreach ($data as $artwork) {
        $htmlContent .= '<table class="head" style="width: 100%;">';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 950px;"><h1>' . $artwork['title'] . '</h1></td>';
        $htmlContent .= '<td><img src="assets/img/logo.jpg" width="100" height="70" alt="Logo"></td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '</table>';
        $htmlContent .= '<table class="head" style="width: 100%;">';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 915px; vertical-align: top;"><h2><strong>Registre: </strong><hr>ID: ' . $artwork['id_letter'] . str_pad($artwork['id_num1'], 5, "0", STR_PAD_LEFT) . '.' . str_pad($artwork['id_num2'], 2, "0", STR_PAD_LEFT) . '<br>Nom d\'obra: ' . $artwork['name'] . '<br>Titol: ' . $artwork['title'] . '</h2></td>';
        $htmlContent .= '<td><img src="' . $artwork['image'] . '" alt="text" style="width: 100%;"></td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '</table>';

        $htmlContent .= '<h2 style="margin-top: 20px;"><strong>Detalls de l\'obra</strong></h2><hr>';
        $htmlContent .= '<table class="body" style="width: 100%;">';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;">Autor: ' . $artwork['author'] . '</td>';
        $htmlContent .= '<td>Data de creació: ' . $artwork['creation_date'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;"> Datació: ' . $artwork['datation'] . '</td>';
        $htmlContent .= '<td>Data de registre: ' . $artwork['register_date'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '</table>';

        $htmlContent .= '<table class="body" style="width: 100%;">';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td>Descripció: ' . $artwork['description'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '</table>';

        $htmlContent .= '<h2 style="margin-top: 20px;"><strong>Caracteristiques d\'obra</strong></h2><hr>';
        $htmlContent .= '<table class="body" style="width: 100%;">';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;">Altura: ' . $artwork['height'] . 'cm</td>';
        $htmlContent .= '<td>Preu: ' . $artwork['cost'] . '€</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;">Amplada: ' . $artwork['width'] . 'cm</td>';
        $htmlContent .= '<td>Quantitat: 1' . $artwork['amount'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;">Profunditat: ' . $artwork['depth'] . 'cm</td>';
        $htmlContent .= '<td>Material principal: ' . $artwork['material'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;">Classificació genèrica: ' . $artwork['genericclassification'] . '</td>';
        $htmlContent .= '<td>Tècnica: ' . $artwork['tecnique'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;">Codi getty material: ' . $artwork['materialgettycode'] . '</td>';
        $htmlContent .= '<td>Estat de conservació: ' . $artwork['conservationstatus'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '</table>';

        $htmlContent .= '<h2 style="margin-top: 20px;"><strong>Provenença</strong></h2><hr>';
        $htmlContent .= '<table class="body" style="width: 100%;">';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;">Nom del museu: ' . $artwork['museumname'] . '</td>';
        $htmlContent .= '<td>Col·leció de provenença: ' . $artwork['provenancecollection'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;">Lloc d\'origen: ' . $artwork['originplace'] . '</td>';
        $htmlContent .= '<td>Metode d\'entrada: ' . $artwork['entry'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '</table>';

        $htmlContent .= '<h2 style="margin-top: 20px;"><strong>Ubicació</strong></h2><hr>';
        $htmlContent .= '<table class="body" style="width: 100%;">';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;">Ubicació: ' . $artwork['location'] . '</td>';
        $htmlContent .= '<td>Lloc d\'execució: ' . $artwork['executionplace'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;">Triatge: ' . $artwork['triage'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '</table>';

        $htmlContent .= '<h2 style="margin-top: 20px;"><strong>Altres dades</strong></h2><hr>';
        $htmlContent .= '<table class="body" style="width: 100%;">';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td>Historia: ' . $artwork['history'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '</table>';
    }
    
    $htmlContent .= '
    </body>
    </html>';
    

    $html2pdf->writeHTML($htmlContent);

    $html2pdf->output('dades_individuals.pdf', 'I');
?>