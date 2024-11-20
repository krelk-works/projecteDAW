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
            $sql = "SELECT *
            FROM movements
            INNER JOIN artworks ON movements.artwork = artworks.id
            WHERE artworks.id = :artwork
            AND movements.end_date IS NOT NULL
            AND (
                movements.start_date <= :ed 
                AND movements.end_date >= :sd
            );";

            $stmt->bindParam(':artwork', $artwork);
            
            $stmt = $conn->prepare($sql);

            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                $sql = "INSERT INTO movements (start_date, end_date, place, artwork) 
                        VALUES (:sd, :ed, :place, :artwork)";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':sd', $sd);
                $stmt->bindParam(':ed', $ed);
                $stmt->bindParam(':place', $place);
                $stmt->bindParam(':artwork', $artwork);
                
                if ($stmt->execute()) {
                    return "s'ha registrat el moviment correctament";
                } else {
                    return "hi ha hagut un error desconegut";
                }
            }
            else {
                return "error: ya hi ha algun moviment registrat d'aquesta obra en el rang de dates que has introduit";
            }
        }


    }
?>