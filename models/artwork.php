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

        public function getInfo($limit, $offset, $filter = null) {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT Artwork.Artwork_ID, Artwork.Artwork_name, Artwork.Creation_date, 
                           Authors.Author_name, Estatdeconservacio.text, Locations.Location_name, Images.URL
                    FROM Artwork
                    INNER JOIN Authors ON Artwork.Author_ID = Authors.Author_ID 
                    INNER JOIN Locations ON Artwork.Location_ID = Locations.Location_ID
                    INNER JOIN Images ON Artwork.Artwork_ID = Images.Artwork_ID
                    INNER JOIN Estatdeconservacio ON Artwork.Conservation_ID = Estatdeconservacio.id";
        
            // If there are filters, start building the WHERE clause
            $conditions = [];
            
            if (!empty($filter) && is_array($filter)) {
                // Search filter
                if (!empty($filter['search'])) {
                    $conditions[] = "Artwork.Artwork_name LIKE :search";
                }
        
                // Author filter
                if (!empty($filter['author'])) {
                    $conditions[] = "Authors.Author_ID = :author";
                }
        
                // Location filter
                if (!empty($filter['location'])) {
                    $conditions[] = "Locations.Location_ID = :location";
                }
        
                // Year filter (exact year)
                if (!empty($filter['year'])) {
                    $conditions[] = "Artwork.Creation_date = :year";
                }
        
                // Status filter
                if (!empty($filter['status'])) {
                    $conditions[] = "Estatdeconservacio.id= :status";
                }
            }
        
            // If there are any conditions, append them to the SQL query
            if (count($conditions) > 0) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
        
            // Add LIMIT and OFFSET for pagination
            $sql .= " LIMIT :limit OFFSET :offset";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
            
            // Bind the filters
            if (!empty($filter['search'])) {
                $searchTerm = "%" . $filter['search'] . "%";
                $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            }
            if (!empty($filter['author'])) {
                $stmt->bindParam(':author', $filter['author'], PDO::PARAM_INT);
            }
            if (!empty($filter['location'])) {
                $stmt->bindParam(':location', $filter['location'], PDO::PARAM_INT);
            }
            if (!empty($filter['year'])) {
                $stmt->bindParam(':year', $filter['year'], PDO::PARAM_INT);
            }
            if (!empty($filter['status'])) {
                $stmt->bindParam(':status', $filter['status'], PDO::PARAM_INT);
            }
        
            // Bind limit and offset
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
            // Execute the query
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        

        public function getTotalCount($filter = null) {
            $conn = $this->connect();
            
            // Base SQL query to count the total number of artworks
            $sql = "SELECT COUNT(*) FROM Artwork
                    INNER JOIN Authors ON Artwork.Author_ID = Authors.Author_ID
                    INNER JOIN Locations ON Artwork.Location_ID = Locations.Location_ID";
        
            // If there are filters, start building the WHERE clause
            $conditions = [];
            
            if (!empty($filter) && is_array($filter)) {
                // Search filter
                if (!empty($filter['search'])) {
                    $conditions[] = "Artwork.Artwork_name LIKE :search";
                }
        
                // Author filter
                if (!empty($filter['author'])) {
                    $conditions[] = "Authors.Author_ID = :author";
                }
        
                // Location filter
                if (!empty($filter['location'])) {
                    $conditions[] = "Locations.Location_ID = :location";
                }
        
                // Year filter (exact year)
                if (!empty($filter['year'])) {
                    $conditions[] = "Artwork.Creation_date = :year";
                }
        
                // Status filter
                if (!empty($filter['status'])) {
                    $conditions[] = "Artwork.Conservation_ID = :status";
                }
            }
        
            // If there are any conditions, append them to the SQL query
            if (count($conditions) > 0) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
        
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
            
            // Bind the filters
            if (!empty($filter['search'])) {
                $searchTerm = "%" . $filter['search'] . "%";
                $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            }
            if (!empty($filter['author'])) {
                $stmt->bindParam(':author', $filter['author'], PDO::PARAM_INT);
            }
            if (!empty($filter['location'])) {
                $stmt->bindParam(':location', $filter['location'], PDO::PARAM_INT);
            }
            if (!empty($filter['year'])) {
                $stmt->bindParam(':year', $filter['year'], PDO::PARAM_INT);
            }
            if (!empty($filter['status'])) {
                $stmt->bindParam(':status', $filter['status'], PDO::PARAM_INT);
            }
        
            // Execute the query
            $stmt->execute();
        
            // Fetch the count result
            return $stmt->fetchColumn();
        }
        

        public function generatePDF() {
            // Get the data to generate the PDF file
            $conn = $this->connect();
            $sql = 
            "SELECT Artwork.ID_char, Artwork.ID_num1, Artwork.ID_num2, Artwork.Artwork_name, 
            Description, Authors.Author_name, Artwork.Creation_date, Artwork.Conservation_ID,
            Artwork.Register_date, Artwork.Amount, Images.URL, Material.text AS material
            FROM Artwork 
            INNER JOIN Authors ON Artwork.Author_ID = Authors.Author_ID
            INNER JOIN Images ON Artwork.Artwork_ID = Images.Artwork_ID
            INNER JOIN Material ON Artwork.Material_ID = Material.id";
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
                $pdf->MultiCell(0, 10, " - Autor: " . $row['Author_name'], 0, 1);
                $pdf->MultiCell(0, 10, " - Data de registre: " . $row['Register_date'], 0, 1);
                $pdf->MultiCell(0, 10, " - Any de creació: " . $row['Creation_date'], 0, 1);
                $pdf->MultiCell(0, 10, " - Conservació: " . $row['Conservation'], 0, 1);
                $pdf->MultiCell(0, 10, " - Material: " . $row['material'], 0, 1);
                $pdf->MultiCell(0, 10, " - Quantitat: " . $row['Amount'], 0, 1);
                $pdf->AddPage();
            }

            return $pdf;
        }
    }
?>