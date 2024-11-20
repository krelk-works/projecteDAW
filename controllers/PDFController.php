<?php
    require_once 'vendor/autoload.php';
    class PDFController {
        public function generatePDF() {
            require_once "models/artwork.php";
            $artwork = new Artwork();
            return $artwork->generatePDF();
        }

        public function generateInvididualPDF($id) {
            require_once "models/artwork.php";
            $artwork = new Artwork();
            return $artwork->generateInvididualPDF($id);
        }

        public function generateSimplePDF($id) {
            require_once "models/artwork.php";
            $artwork = new Artwork();
            return $artwork->generateSimplePDF($id);
        }
    }
?>