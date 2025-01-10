<?php
    require_once("database.php");
    class Author extends Database {
        public function getAuthors() {
            $conn = $this->connect();
            $sql = "SELECT id, name FROM authors";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();

            $conn = null;
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>