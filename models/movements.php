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
            $sql = "INSERT INTO movements (start_date, end_date, place, artwork) 
                    VALUES (:sd, :ed, :place, :artwork)";
            
            // Preparar la consulta
            $stmt = $conn->prepare($sql);
            //echo ($sql);
            // Asignar los valores a los parámetros
            $stmt->bindParam(':sd', $sd);
            $stmt->bindParam(':ed', $ed);
            $stmt->bindParam(':place', $place);
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