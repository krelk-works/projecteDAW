<?php
require_once("database.php");
require 'vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

class DOCX extends Database {
    public function exportDOCX() {

        $conn = $this->connect();
        $sql = "SELECT artworks.title, artworks.id_letter, artworks.id_num1, artworks.id_num2, 
        artworks.height, artworks.width, artworks.depth, authors.name
        FROM artworks
        INNER JOIN authors ON artworks.author = authors.id
        WHERE artworks.id = 342";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $filePath = __DIR__ . '/formulariprestec.docx';
        $newFilePath = __DIR__ .'/formulariprestec_printable.docx';
        $templateProcessor = new TemplateProcessor($filePath);
        $data = [
            'text1' => $result[0]['id_letter'] . $result[0]['id_num1'] . $result[0]['id_num2'],
            'text2' => $result[0]['title'],
            'text3' => $result[0]['name'],
            'text4' => $result[0]['height'] . "cm/" . $result[0]['width'] . "cm/" . $result[0]['depth'] . "cm",
            'text5' => 'Metal y madera',
            'text6' => 'Siglo XXI',
        ];

        foreach ($data as $placeholder => $value) {
            $templateProcessor->setValue($placeholder, $value);
        }

        $templateProcessor->saveAs($newFilePath);

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="formulariprestec_printable.docx"');
        header('Content-Length: ' . filesize($newFilePath));

        readfile($newFilePath);
        unlink($newFilePath);

        exit;
    }
}
?>