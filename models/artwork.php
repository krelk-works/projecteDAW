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


        public function getNextIdNum1() {
            // Conectar a la base de datos
            $conn = $this->connect();
            
            // Consulta para obtener el valor máximo de `id_num1`
            $sql = "SELECT MAX(id_num1) AS max_id FROM artworks";
            $stmt = $conn->prepare($sql);
            
            // Ejecuta la consulta y verifica el resultado
            if ($stmt->execute()) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Si no hay registros, empieza en 10001; si los hay, retorna el siguiente valor de `id_num1`
                return isset($row['max_id']) && $row['max_id'] !== null ? $row['max_id'] + 1 : 10001;
            } else {
                return false; // Manejo de error en caso de fallo en la consulta
            }
        }
        
        


        public function getInfo($limit, $offset, $filter = null) {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT artworks.id, artworks.name AS artwork_name, artworks.creation_date, authors.name AS author_name, conservationstatus.text, locations.name AS location_name, artworks.image AS artwork_image
                    FROM artworks
                    INNER JOIN authors ON artworks.author = authors.id
                    INNER JOIN locations ON artworks.location = locations.id
                    INNER JOIN conservationstatus ON artworks.conservationstatus = conservationstatus.id
                    ";
        
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

        public function getArtowrksByLocations($locations) {
            $conn = $this->connect();

            // Base SQL query
            $sql = "SELECT artworks.id, artworks.name AS artwork_name, artworks.creation_date, authors.name AS author_name, conservationstatus.text, locations.name AS location_name, images.URL
                    FROM artworks
                    INNER JOIN authors ON artworks.author = authors.id
                    INNER JOIN locations ON artworks.location = locations.id
                    INNER JOIN images ON artworks.id = images.artwork
                    INNER JOIN conservationstatus ON artworks.conservationstatus = conservationstatus.id
                    WHERE artworks.location IN (" . $locations . ") ORDER BY locations.name ASC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getArtworkList($ID) {
            $conn = $this->connect();
            
            $sql = "SELECT artworks.name, artworks.id
                    FROM artworks
                    LEFT JOIN expositionsartworks ON artworks.id = expositionsartworks.artwork 
                    AND expositionsartworks.exposition =". $ID ."
                    WHERE expositionsartworks.artwork IS NULL";

            $stmt = $conn->prepare($sql);

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

        
        public function createArtwork($nom_del_museu, $id_letter, $id_num1, $id_num2, $objecte, $descripcio,
        $procedencia, $data_registre, $creation_date, $height, $width, $depth, $titol, $originplace, $executionplace, $tiratge, $altres_numeros,
        $cost, $amount, $historia_objecte, $ubicacio, $autor, $material, /*$exposition, $cancel,*/ $causa_baixa, $estat_conservacio, $datacio, $entry, 
        $expositiontype, $classificacio_generica, $materialgettycode, $tecniquegetty, $image) {
            $conn = $this->connect();
            $sql = "INSERT INTO artworks (museumname, id_letter, id_num1, id_num2, name, description, provenancecollection, register_date, creation_date, 
            height, width, depth, title, originplace, executionplace, triage, otheridnumbers, cost, amount, history, location, author, material,/* exposition,
            cancel, */cancelcause, conservationstatus, datation, entry, expositiontype, genericclassification, materialgettycode, movement, restoration, 
            tecnique, tecniquegettycode, image) VALUES (:museumname, :id_letter, :id_num1, :id_num2, :name, :description, :provenancecollection, :register_date,
            :creation_date, :height, :width, :depth, :title, :originplace, :executionplace, :triage, :otheridnumbers, :cost, :amount, :history, :location,
            :author, :material, /*:exposition, :cancel,*/ :cancelcause, :conservationstatus, :datation, :entry, :expositiontype, :genericclassification,
            :materialgettycode, :movement, :restoration, :tecnique, :tecniquegettycode, :image)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':museumname', $nom_del_museu, PDO::PARAM_STR);
            $stmt->bindParam(':id_letter', $id_letter, PDO::PARAM_STR);
            $stmt->bindParam(':id_num1', $id_num1, PDO::PARAM_INT);
            $stmt->bindParam(':id_num2', $id_num2, PDO::PARAM_INT);
            $stmt->bindParam(':name', $objecte, PDO::PARAM_STR);
            $stmt->bindParam(':description', $descripcio, PDO::PARAM_STR);
            $stmt->bindParam(':provenancecollection', $procedencia, PDO::PARAM_STR);
            $stmt->bindParam(':register_date', $data_registre, PDO::PARAM_STR);
            $stmt->bindParam(':creation_date', $creation_date, PDO::PARAM_STR);
            $stmt->bindParam(':height', $height, PDO::PARAM_INT);
            $stmt->bindParam(':width', $width, PDO::PARAM_INT);
            $stmt->bindParam(':depth', $depth, PDO::PARAM_INT);
            $stmt->bindParam(':title', $titol, PDO::PARAM_STR);
            $stmt->bindParam(':originplace', $originplace, PDO::PARAM_STR);
            $stmt->bindParam(':executionplace', $executionplace, PDO::PARAM_STR);
            $stmt->bindParam(':triage', $tiratge, PDO::PARAM_STR);
            $stmt->bindParam(':otheridnumbers', $altres_numeros, PDO::PARAM_STR);
            $stmt->bindParam(':cost', $cost, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
            $stmt->bindParam(':history', $historia_objecte, PDO::PARAM_STR);
            $stmt->bindParam(':location', $ubicacio, PDO::PARAM_INT);
            $stmt->bindParam(':author', $autor, PDO::PARAM_INT);
            $stmt->bindParam(':material', $material, PDO::PARAM_INT);
            //$stmt->bindParam(':exposition', $exposition, PDO::PARAM_INT);
            //$stmt->bindParam(':cancel', $cancel, PDO::PARAM_INT);
            $stmt->bindParam(':cancelcause', $causa_baixa, PDO::PARAM_INT);
            $stmt->bindParam(':conservationstatus', $estat_conservacio, PDO::PARAM_INT);
            $stmt->bindParam(':datation', $datacio, PDO::PARAM_STR);
            $stmt->bindParam(':entry', $entry, PDO::PARAM_STR);
            $stmt->bindParam(':expositiontype', $expositiontype, PDO::PARAM_INT);
            $stmt->bindParam(':genericclassification', $classificacio_generica, PDO::PARAM_INT);
            $stmt->bindParam(':materialgettycode', $materialgettycode, PDO::PARAM_INT);
            $stmt->bindParam(':movement', $movement, PDO::PARAM_STR);
            $stmt->bindParam(':restoration', $restoration, PDO::PARAM_STR);
            $stmt->bindParam(':tecnique', $tecnique, PDO::PARAM_STR);
            $stmt->bindParam(':tecniquegettycode', $tecniquegettycode, PDO::PARAM_INT);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();

        }

        public function getArtworkData($id){
            $id = (int)$id;
            $conn=$this->connect();
            $sql="SELECT * FROM artworks WHERE id = :id";
            $stmt=$conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        }

        public function updateArtwork($id,$data){
            $conn=$this->connect();
            $sql="UPDATE artworks SET 
            museumname = :museumname,
            id_letter = :id_letter,
            id_num1 = :id_num1,
            id_num2 = :id_num2,
            name = :name,
            description = :description,
            provenancecollection = :provenancecollection,
            register_date = :register_date,
            creation_date = :creation_date,
            height = :height,
            width = :width,
            depth = :depth,
            title = :title,
            originplace = :originplace,
            executionplace = :executionplace,
            triage = :triage,
            otheridnumbers = :otheridnumbers,
            cost = :cost,
            amount = :amount,
            history = :history,
            location = :location,
            author = :author,
            material = :material,
            cancelcause = :cancelcause,
            conservationstatus = :conservationstatus,
            datation = :datation,
            entry = :entry,
            expositiontype = :expositiontype,
            genericclassification = :genericclassification,
            materialgettycode = :materialgettycode,
            tecniquegettycode = :tecniquegettycode
            WHERE id = :id";
            $stmt=$conn->prepare($sql);
            $stmt->bindParam(':museumname', $data['museumname'], PDO::PARAM_STR);
            $stmt->bindParam(':id_letter', $data['id_letter'], PDO::PARAM_STR);
            $stmt->bindParam(':id_num1', $data['id_num1'], PDO::PARAM_INT);
            $stmt->bindParam(':id_num2', $data['id_num2'], PDO::PARAM_INT);
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(':provenancecollection', $data['provenancecollection'], PDO::PARAM_STR);
            $stmt->bindParam(':register_date', $data['register_date'], PDO::PARAM_STR);
            $stmt->bindParam(':creation_date', $data['creation_date'], PDO::PARAM_STR);
            $stmt->bindParam(':height', $data['height'], PDO::PARAM_INT);
            $stmt->bindParam(':width', $data['width'], PDO::PARAM_INT);
            $stmt->bindParam(':depth', $data['depth'], PDO::PARAM_INT);
            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':originplace', $data['originplace'], PDO::PARAM_STR);
            $stmt->bindParam(':executionplace', $data['executionplace'], PDO::PARAM_STR);
            $stmt->bindParam(':triage', $data['triage'], PDO::PARAM_STR);
            $stmt->bindParam(':otheridnumbers', $data['otheridnumbers'], PDO::PARAM_STR);
            $stmt->bindParam(':cost', $data['cost'], PDO::PARAM_STR);
            $stmt->bindParam(':amount', $data['amount'], PDO::PARAM_INT);
            $stmt->bindParam(':history', $data['history'], PDO::PARAM_STR);
            $stmt->bindParam(':location', $data['location'], PDO::PARAM_INT);
            $stmt->bindParam(':author', $data['author'], PDO::PARAM_INT);
            $stmt->bindParam(':material', $data['material'], PDO::PARAM_INT);
            $stmt->bindParam(':cancelcause', $data['cancelcause'], PDO::PARAM_INT);
            $stmt->bindParam(':conservationstatus', $data['conservationstatus'], PDO::PARAM_INT);
            $stmt->bindParam(':datation', $data['datation'], PDO::PARAM_STR);
            $stmt->bindParam(':entry', $data['entry'], PDO::PARAM_STR);
            $stmt->bindParam(':expositiontype', $data['expositiontype'], PDO::PARAM_INT);
            $stmt->bindParam(':genericclassification', $data['genericclassification'], PDO::PARAM_INT);
            $stmt->bindParam(':materialgettycode', $data['materialgettycode'], PDO::PARAM_INT);
            $stmt->bindParam(':tecniquegettycode', $data['tecniquegettycode'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function getLastIdByLetter($letter) {
            $conn = $this->connect();
            $sql = "SELECT id_num1 FROM artworks WHERE id_letter = :letter ORDER BY id_num1 DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':letter', $letter, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id_num1'];
        }

        public function generatePDF() {
            require_once 'vendor/autoload.php';
        
            $conn = $this->connect();
            $sql = "SELECT *
                    FROM artworks";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Obtener todos los resultados
        
            $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'es');
            
            $htmlContent = '
            <html>
                <head>
                </head>
                <body>
                    <h1>Informe d\'obres</h1>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Data de creació</th>
                            </tr>
                        </thead>
                        <tbody>';
            
            foreach ($data as $artwork) {
                $htmlContent .= '
                <tr>
                    <td>' . $artwork["id_letter"] . $artwork["id_num1"] . $artwork["id_num2"] . '</td>
                    <td>' . $artwork["name"] . '</td>
                    <td>' . $artwork["creation_date"] . '</td>
                </tr>';
            }
        
            $htmlContent .= '
                        </tbody>
                    </table>
                </body>
            </html>';
        
            $html2pdf->writeHTML($htmlContent);
        
            return $html2pdf;
        }        

        public function searchArtwork($search){
            $conn = $this->connect();
            $sql = "SELECT artworks.id, artworks.name AS artwork_name, artworks.creation_date, artworks.cancelcause AS artwork_cancelcause, authors.name AS author_name, conservationstatus.text, locations.name AS location_name, artworks.image AS artwork_image
                    FROM artworks
                    INNER JOIN authors ON artworks.author = authors.id
                    INNER JOIN locations ON artworks.location = locations.id
                    INNER JOIN conservationstatus ON artworks.conservationstatus = conservationstatus.id
                    WHERE artworks.name LIKE :search OR authors.name LIKE :search OR locations.name LIKE :search OR conservationstatus.text LIKE :search";
            $stmt = $conn->prepare($sql);
            $searchTerm = "%" . $search . "%";
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>