<?php
    require_once "controllers/PDFController.php";
    $PDFController = new PDFController();
    $data = $PDFController->generateSimplePDF($_GET['generateSimplePDF']);

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
                max-width: 250px;
                max-height: 250px;
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
        $htmlContent .= '<h1>' . $artwork['title'] . '</h1>';
        $htmlContent .= '<table class="head" style="width: 100%;">';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td><img src="' . $artwork['image'] . '" alt="text" style="width: 100%;"></td>';
        $htmlContent .= '<td style="width: 825px;"><h2>Identificacio<hr>ID: ' . $artwork['id_letter'] . $artwork['id_num1'] . '.' . $artwork['id_num2'] . '<br>Nom d\'obra: ' . $artwork['name'] . '<br>Titol: ' . $artwork['title'] . '<br>Autor: ' . $artwork['author'] . '</h2></td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '</table>';

        $htmlContent .= '<h2 style="margin-top: 20px;">Detalls de l\'obra</h2><hr>';
        $htmlContent .= '<table class="body" style="width: 100%;">';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;">Datació: ' . $artwork['datation'] . '</td>';
        $htmlContent .= '<td>Classificació genérica: ' . $artwork['genericclassification'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;"> Mides máximes(cm): ' . $artwork['height'] . '</td>';
        $htmlContent .= '<td>Estat de conservacio: ' . $artwork['conservationstatus'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;"> Material: ' . $artwork['material'] . '</td>';
        $htmlContent .= '<td>Valoració económica: ' . $artwork['cost'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '<tr>';
        $htmlContent .= '<td style="width: 500px;"> Procedencia: ' . $artwork['provenancecollection'] . '</td>';
        $htmlContent .= '<td>Data de register: ' . $artwork['register_date'] . '</td>';
        $htmlContent .= '</tr>';
        $htmlContent .= '</table>';
    }
    
    $htmlContent .= '
    </body>
    </html>';
    

    $html2pdf->writeHTML($htmlContent);

    $html2pdf->output('dades_simples.pdf', 'I');
?>