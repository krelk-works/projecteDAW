<?php
    require_once("database.php");
    class Author extends Database {
        public function getAuthors() {
            $conn = $this->connect();
            $sql = "SELECT Author_ID, Author_name FROM Authors";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>