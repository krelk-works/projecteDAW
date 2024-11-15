<?php
    require_once 'vendor/autoload.php';
    class PDFController {
        public function generatePDF() {
            require_once "models/artwork.php";
            $artwork = new Artwork();
            $pdf = $artwork->generatePDF();
            $pdf->output('llistat_complet_obres.pdf');
        }

        public function generateInvididualPDF($id) {
            require_once "models/artwork.php";
            $artwork = new Artwork();
            $pdf = $artwork->generateInvididualPDF($id);
            $pdf->output('informacio_individual_obres.pdf');
        }
    }
?>