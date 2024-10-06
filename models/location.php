<?php
    require_once("database.php");
    class Location extends Database {
        public function getLocations() {
            $conn = $this->connect();
            $sql = "SELECT * FROM Locations";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>