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
        
        public function isIdentifiersValid($letter, $number, $subnumber): bool {

            // Conectar a la base de datos
            $conn = $this->connect();
        
            // Construir la consulta SQL de forma dinámica
            $sql = "SELECT COUNT(*) AS total FROM artworks WHERE id_num1 = :number";
            $params = [':number' => $number];
        
            // Añadir condiciones solo si los parámetros no están vacíos
            if (!empty($letter)) {
                $sql .= " AND id_letter = :letter";
                $params[':letter'] = $letter;
            }
            if (!empty($subnumber)) {
                $sql .= " AND id_num2 = :subnumber";
                $params[':subnumber'] = $subnumber;
            }
        
            // Preparar la consulta
            $stmt = $conn->prepare($sql);
        
            // Asignar los valores de los parámetros que están definidos
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
        
            // Ejecuta la consulta y verifica el resultado
            if ($stmt->execute()) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['total'] == 0;
            } else {
                return false; // Manejo de error en caso de fallo en la consulta
            }
        }

        public function getFormData() {
            $conn = $this->connect();
            
            $sql = "SELECT * FROM authors";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            $sql = "SELECT * FROM locations";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            $sql = "SELECT * FROM materials";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            $sql = "SELECT * FROM conservationstatus";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $conservationstatus = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Datations
            $sql = "SELECT * FROM datations";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $datations = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Generic classifications
            $sql = "SELECT * FROM genericclassifications";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $classifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Tecniques
            $sql = "SELECT * FROM tecniques";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $tecniques = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Material Getty Codes
            $sql = "SELECT * FROM materialgettycodes";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $materialgettycodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Material Getty
            $sql = "SELECT * FROM materialgetty";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $materialgetty = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Entry types
            $sql = "SELECT * FROM entry";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $entry = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Cancel causes
            $sql = "SELECT * FROM cancelcauses";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $cancelcauses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            return [
                'authors' => $authors,
                'locations' => $locations,
                'materials' => $materials,
                'conservationstatus' => $conservationstatus,
                'datations' => $datations,
                'classifications' => $classifications,
                'tecniques' => $tecniques,
                'materialgettycodes' => $materialgettycodes,
                'materialgetty' => $materialgetty,
                'entry' => $entry,
                'cancelcauses' => $cancelcauses
            ];
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
            $sql = "SELECT artworks.id, artworks.name AS artwork_name, artworks.creation_date, artworks.image as artwork_image, authors.name AS author_name, conservationstatus.text, locations.name AS location_name, images.URL
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

        public function getLastIdByLetter($letter = null) {
            $conn = $this->connect();
            $sql = "";
            if ($letter) {
                $sql = "SELECT id_num1 FROM artworks WHERE id_letter = :letter ORDER BY id_num1 DESC LIMIT 1";
            } else {
                $sql = "SELECT id_num1 FROM artworks WHERE NOT id_letter ORDER BY id_num1 DESC LIMIT 1";
            }
            $stmt = $conn->prepare($sql);
            if ($letter) {
                $stmt->bindParam(':letter', $letter, PDO::PARAM_STR);
            }
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id_num1'];
        }

        public function generatePDF() {
            require_once 'vendor/autoload.php';
        
            $conn = $this->connect();
            $sql = "SELECT artworks.id, artworks.name, artworks.creation_date, artworks.image,
                    artworks.description, authors.name AS author, artworks.id_letter, artworks.id_num1,
                    artworks.id_num2, genericclassifications.text AS genericclassification, artworks.provenancecollection,
                    artworks.height, artworks.title, materials.text AS material, tecniques.text AS tecnique, datations.start_date,
                    datations.end_date, datations.text AS datation
                    FROM artworks
                    INNER JOIN authors ON artworks.author = authors.id
                    INNER JOIN genericclassifications ON artworks.genericclassification = genericclassifications.id
                    INNER JOIN materials ON artworks.material = materials.id
                    INNER JOIN tecniques ON artworks.tecnique = tecniques.id
                    INNER JOIN datations ON artworks.datation = datations.id";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A3', 'es');
        
            $htmlContent = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        text-align: center;
                    }
                    .header {tecnique
                        padding-top: 20px;
                        padding-bottom: 20px;
                        width: 100%;
                        max-width: 630px;
                        margin: 0 auto;
                        text-align: center;
                    }
                    h2 {
                        margin: 0;
                        padding: 0;
                        font-size: 18px;
                        text-align: center;
                    }
                    img {
                        max-width: 150px;
                        max-height: 150px;
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
                </style>
            </head>
            <body>';
            
            foreach ($data as $artwork) {
                $htmlContent .= '<div class="header">';
                $htmlContent .= '<img src="' . $artwork['image'] . '" alt=""><br>';
                $htmlContent .= '<h2><i>identificador: ' . $artwork['id_letter'] . $artwork['id_num1'] . '.' . $artwork['id_num2'] . '</i><br>';
                $htmlContent .= '<strong>nom d\'obra: ' . $artwork['name'] . '</strong><br>';
                $htmlContent .= '<b>autor: ' . $artwork['author'] . '</b><br>';
                $htmlContent .= '<b>data de creacio: ' . $artwork['creation_date'] . '</b></h2>';
                $htmlContent .= '</div>';
                $htmlContent .= '<div class="main">';
                $htmlContent .= '<table border="1">';
                $htmlContent .= '<tr>';
                $htmlContent .= '<td class="label">descripció</td>';
                $htmlContent .= '<td class="value">' . $artwork['description'] . '</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr>';
                $htmlContent .= '<td class="label">classificació genérica</td>';
                $htmlContent .= '<td class="value">' . $artwork['genericclassification'] . '</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr>';
                $htmlContent .= '<td class="label">colecció de procedencia</td>';
                $htmlContent .= '<td class="value">' . $artwork['provenancecollection'] . '</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr>';
                $htmlContent .= '<td class="label">mides maximes (cm)</td>';
                $htmlContent .= '<td class="value">' . $artwork['height'] . '</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr>';
                $htmlContent .= '<td class="label">material</td>';
                $htmlContent .= '<td class="value">' . $artwork['material'] . '</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr>';
                $htmlContent .= '<td class="label">técnica</td>';
                $htmlContent .= '<td class="value">' . $artwork['tecnique'] . '</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr>';
                $htmlContent .= '<td class="label">title</td>';
                $htmlContent .= '<td class="value">' . $artwork['title'] . '</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr>';
                $htmlContent .= '<td class="label">data d\'inici</td>';
                $htmlContent .= '<td class="value">' . $artwork['start_date'] . '</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr>';
                $htmlContent .= '<td class="label">data fi</td>';
                $htmlContent .= '<td class="value">' . $artwork['end_date'] . '</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr>';
                $htmlContent .= '<td class="label">datacio</td>';
                $htmlContent .= '<td class="value">' . $artwork['datation'] . '</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '</table>';
                $htmlContent .= '</div>';
            }
            
            $htmlContent .= '
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