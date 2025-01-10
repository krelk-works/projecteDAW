<?php
    require_once("database.php");
    class Status extends Database {
        private $status_name;
    
        public function __construct($status_name = null){
            $this->status_name = $status_name;
        }

        public function getStatus_name(){
            return $this->status_name;
        }

        public function setStatus_name($status_name){
            $this->status_name = $status_name;
        }

        public function getStatus() {
            $conn = $this->connect();
            $sql = "SELECT * FROM conservationstatus";

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