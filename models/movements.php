<?php
    require_once("database.php");
    class Movement extends Database {

        public function getAllMovements() {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT movements.*, artworks.title
            FROM movements
            INNER JOIN artworks ON movements.artwork = artworks.id
            ORDER BY artworks.title ASC";
            
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
        
        public function editMovement($id, $sd, $ed, $place) {
            $conn = $this->connect();
            $sql = "UPDATE movements
                    SET start_date = :sd, end_date = :ed, place = :place
                    WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':sd', $sd);
            $stmt->bindParam(':ed', $ed);
            $stmt->bindParam(':place', $place);        
            return $stmt->execute(); // Retorna true o false
        }

        public function deleteMovement($id) {
            $conn = $this->connect();
            $sql = "DELETE FROM movements WHERE id = :id";
            try {
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute(); // Retorna true o false
                $filasAfectadas = $stmt->rowCount();
                return $filasAfectadas > 0;
            } catch (PDOException $e) {
                return false;
            }
        }
        
    }
?>