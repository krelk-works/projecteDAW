<?php
    require_once 'vendor/autoload.php';
    class PDFController {
        public function generatePDF() {
            require_once "models/artwork.php";
            $artwork = new Artwork();
            return $artwork->generatePDF();
        }

        public function generateIndividualPDF($id) {
            require_once "models/artwork.php";
            $artwork = new Artwork();
            return $artwork->generateIndividualPDF($id);
        }

        public function generateSimplePDF($id) {
            require_once "models/artwork.php";
            $artwork = new Artwork();
            return $artwork->generateSimplePDF($id);
        }
    }
?>