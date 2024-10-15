<?php
    require_once("database.php");
    class Artwork extends Database {
        protected $id;
        protected $name;
        protected $author;

        public function __construct($id = null, $name = null, $author = null){
            $this->id = $id;
            $this->name = $name;
            $this->author = $author;
        }

        public function getname(){
            return $this->name;
        }

        public function getid(){
            return $this->id;
        }

        public function setname($name){
            $this->name = $name;
        }

        public function getInfo($limit, $offset, $filter = null) {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT artworks.id, artworks.name, artworks.creation_date, 
                           authors.author, conservationstatus.text, locations.name, images.URL
                    FROM artworks
                    INNER JOIN authors ON artworks.author = authors.id 
                    INNER JOIN locations ON artworks.location = locations.id
                    INNER JOIN images ON artworks.id = images.artwork
                    INNER JOIN conservationstatus ON artworks.onservation = conservationstatus.id";
        
            // If there are filters, start building the WHERE clause
            $conditions = [];
            
            if (!empty($filter) && is_array($filter)) {
                // Search filter
                if (!empty($filter['search'])) {
                    $conditions[] = "artworks.name LIKE :search";
                }
        
                // Author filter
                if (!empty($filter['author'])) {
                    $conditions[] = "authors.id = :author";
                }
        
                // Location filter
                if (!empty($filter['location'])) {
                    $conditions[] = "locations.id = :location";
                }
        
                // Year filter (exact year)
                if (!empty($filter['year'])) {
                    $conditions[] = "artworks.creation_date = :year";
                }
        
                // Status filter
                if (!empty($filter['status'])) {
                    $conditions[] = "conservationstatus.id= :status";
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
            //$stmt->execute();
        
            // Fetch the results
            //return $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        }
        

        public function getTotalCount($filter = null) {
            $conn = $this->connect();
            
            // Base SQL query to count the total number of artworkss
            $sql = "SELECT COUNT(*) FROM artworks
                    INNER JOIN authors ON artworks.author = authors.id
                    INNER JOIN locations ON artworks.location = locations.id";
        
            // If there are filters, start building the WHERE clause
            $conditions = [];
            
            if (!empty($filter) && is_array($filter)) {
                // Search filter
                if (!empty($filter['search'])) {
                    $conditions[] = "artworks.name LIKE :search";
                }
        
                // Author filter
                if (!empty($filter['author'])) {
                    $conditions[] = "authors.id = :author";
                }
        
                // Location filter
                if (!empty($filter['location'])) {
                    $conditions[] = "locations.id = :location";
                }
        
                // Year filter (exact year)
                if (!empty($filter['year'])) {
                    $conditions[] = "artworks.creation_date = :year";
                }
        
                // Status filter
                if (!empty($filter['status'])) {
                    $conditions[] = "artworks.conservationstatus = :status";
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
            "SELECT artworks.ID_char, artworks.ID_num1, artworks.ID_num2, artworks.name, 
            Description, Authors.author, artworks.Creation_date, artworks.Conservation_ID,
            artworks.Register_date, artworks.Amount, Images.URL, Material.text AS material
            FROM artworks 
            INNER JOIN Authors ON artworks.Author_ID = Authors.Author_ID
            INNER JOIN Images ON artworks.artworks_ID = Images.artworks_ID
            INNER JOIN Material ON artworks.Material_ID = Material.id";
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
                $pdf->Cell(0, 10, $row['name'], 0, 1);
                $pdf->SetFont('helvetica', '', 12);
                $pdf->Image($row['URL'], '', '', 80, 80, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
                $pdf->ln(85);
                $pdf->MultiCell(0, 10, " - ID: " . $ID, 0, 1);
                $pdf->MultiCell(0, 10, " - Foto: " . "http://localhost:8080/projecteDAW/".$row['URL'], 0, 1);
                $pdf->MultiCell(0, 10, " - Descripció: " . $row['Description'], 0, 1);
                $pdf->MultiCell(0, 10, " - Autor: " . $row['author'], 0, 1);
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