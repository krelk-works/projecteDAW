<?php
    require_once("database.php");
    class Movement extends Database {

        public function getAllMovements() {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT movements.*, artworks.name
            FROM movements
            INNER JOIN artworks ON movements.artwork = artworks.id";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function createMovements($sd, $ed, $place, $artwork) {
            $conn = $this->connect();
        
            /*$sql = "SELECT COUNT(*) as overlapping_movements
                    FROM movements
                    WHERE artwork = :artwork
                      AND end_date IS NOT NULL
                      AND (start_date <= :ed AND end_date >= :sd)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':artwork', $artwork);
            $stmt->bindParam(':sd', $sd);
            $stmt->bindParam(':ed', $ed);
            
            $stmt->execute();

            $overlappingMovements = $stmt->fetchColumn();
        
            if ($overlappingMovements > 0) {
                return 2;
            }*/
            
            $sql = "INSERT INTO movements (start_date, end_date, place, artwork) 
                    VALUES (:sd, :ed, :place, :artwork)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':sd', $sd);
            $stmt->bindParam(':ed', $ed);
            $stmt->bindParam(':place', $place);
            $stmt->bindParam(':artwork', $artwork);
        
            if ($stmt->execute()) {
                return 0;
            } else {
                return 1;
            }
        }        

    }
?>