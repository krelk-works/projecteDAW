<?php
    require_once("database.php");
    class Artwork extends Database {
        protected $ArtworkID;
        protected $Artwork_name;
        protected $Author_name;

        public function __construct($ArtworkID = null, $Artwork_name = null, $Author_name = null){
            $this->ArtworkID = $ArtworkID;
            $this->Artwork_name = $Artwork_name;
            $this->Author_name = $Author_name;
        }

        public function getArtwork_name(){
            return $this->Artwork_name;
        }

        public function getArtworkID(){
            return $this->ArtworkID;
        }

        public function setArtwork_name($Artwork_name){
            $this->Artwork_name = $Artwork_name;
        }

        /*
        public function getInfo(){
            $conn = $this->connect();
            $sql = "SELECT Artwork.Artwork_ID, Artwork.Artwork_name, Artwork.Creation_date , Author.Author_name, Location.Location_name, Images.URL
             FROM Artwork 
             INNER JOIN Author ON Artwork.Author_ID = Author.Author_ID 
             INNER JOIN Location ON Artwork.Location_ID = Location.Location_ID
             INNER JOIN Images ON Artwork.Artwork_ID = Images.Artwork_ID";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
        
            // Execute the statement
            $stmt->execute();
        
            // Fetch the user
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $row;
        }*/

        

        public function getInfo($limit, $offset) {
            $conn = $this->connect();
            $sql = "SELECT Artwork.Artwork_ID, Artwork.Artwork_name, Artwork.Creation_date, 
                           Author.Author_name, Location.Location_name, Images.URL
                    FROM Artwork 
                    INNER JOIN Author ON Artwork.Author_ID = Author.Author_ID 
                    INNER JOIN Location ON Artwork.Location_ID = Location.Location_ID
                    INNER JOIN Images ON Artwork.Artwork_ID = Images.Artwork_ID
                    LIMIT :limit OFFSET :offset";
        
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
        
            // Bind parameters
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getTotalCount() {
            $conn = $this->connect();
            $sql = "SELECT COUNT(*) FROM Artwork";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        public function generatePDF() {
            // Get the data to generate the PDF file
            $conn = $this->connect();
            $sql = 
            "SELECT Artwork.ID_char, Artwork.ID_num1, Artwork.ID_num2, Artwork.Artwork_name, 
            Artwork.Material, Description, Author.Author_name, Artwork.Creation_date, Artwork.Conservation,
            Artwork.Register_date, Artwork.Amount, Images.URL
            FROM Artwork 
            INNER JOIN Author ON Artwork.Author_ID = Author.Author_ID
            INNER JOIN Images ON Artwork.Artwork_ID = Images.Artwork_ID";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            // PDF base config
            $pdf = new TCPDF();
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Me');
            $pdf->SetTitle('Informe de fitxes');
            $pdf->SetSubject('');
            $pdf->SetKeywords('TCPDF, PDF, MySQL');

            // PDF styles
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage();
            $pdf->SetFont('helvetica','',25);
            $pdf->Cell(30, 20, "Informe de fitxes", 0, 1);

            // Insert data into PDF Format
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ID = $row['ID_char'].$row['ID_num1'].".".$row['ID_num2'];
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->Cell(0, 10, $row['Artwork_name'], 0, 1);
                $pdf->SetFont('helvetica', '', 12);
                $pdf->Image($row['URL'], '', '', 80, 80, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
                $pdf->ln(85);
                $pdf->MultiCell(0, 10, " - ID: " . $ID, 0, 1);
                $pdf->MultiCell(0, 10, " - Foto: " . "http://localhost:8080/projecteDAW/".$row['URL'], 0, 1);
                $pdf->MultiCell(0, 10, " - Descripció: " . $row['Description'], 0, 1);
                $pdf->MultiCell(0, 10, " - Material: " . $row['Material'], 0, 1);
                $pdf->MultiCell(0, 10, " - Autor: " . $row['Author_name'], 0, 1);
                $pdf->MultiCell(0, 10, " - Data de registre: " . $row['Register_date'], 0, 1);
                $pdf->MultiCell(0, 10, " - Any de creació: " . $row['Creation_date'], 0, 1);
                $pdf->MultiCell(0, 10, " - Conservació: " . $row['Conservation'], 0, 1);
                $pdf->MultiCell(0, 10, " - Quantitat: " . $row['Amount'], 0, 1);
                $pdf->AddPage();
            }

            return $pdf;
        }
    }
?>