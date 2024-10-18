<?php
    require_once("database.php");
    class Exposition extends Database {

        public function getActiveExpositions() {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT * 
            FROM expositions 
            INNER JOIN artworks ON artworks.exposition = expositions.id
            INNER JOIN images ON artworks.id = images.artwork
            WHERE end_date > CURDATE()";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAllExpositions() {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT * 
            FROM expositions 
            INNER JOIN artwork ON artwork.exposition = expositions.id";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
        
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
    }
?>