<?php
    require_once("database.php");
    class Restoration extends Database {

        public function getAllRestorations() {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT restorations.*, artworks.title, artworks.image, artworks.id_letter, artworks.id_num1, artworks.id_num2
            FROM restorations
            INNER JOIN artworks ON restorations.artwork = artworks.id
            ORDER BY artworks.title ASC";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function searchRestoration($search){
            $conn = $this->connect();

            $sql = "SELECT restorations.*, artworks.title, artworks.image, artworks.id_letter, artworks.id_num1, artworks.id_num2
            FROM restorations
            INNER JOIN artworks ON restorations.artwork = artworks.id
            WHERE artworks.title LIKE :search OR restorations.code LIKE :search OR authorised_worker_name LIKE :search
            ORDER BY artworks.title ASC";

            $stmt = $conn->prepare($sql);
            $searchTerm = "%" . $search . "%";

            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function createRestoration($code, $start_date, $end_date, $comment, $authorised_worker_name, $artwork) {
            $conn = $this->connect();
            $sql = "INSERT INTO restorations (code, start_date, end_date, comment, authorised_worker_name, artwork) 
                    VALUES (:code, :start_date, :end_date, :comment, :authorised_worker_name, :artwork)";
            
            // Preparar la consulta
            $stmt = $conn->prepare($sql);
            //echo ($sql);
            // Asignar los valores a los parámetros
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->bindParam(':comment', $comment);
            $stmt->bindParam(':authorised_worker_name', $authorised_worker_name);
            $stmt->bindParam(':artwork', $artwork);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
?>