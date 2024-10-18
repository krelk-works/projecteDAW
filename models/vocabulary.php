<?php
    require_once("database.php");
    class Vocabulary extends Database {

        public function addEntry($text)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO entry (text) VALUES (:text)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':text', $text);

            // Execute the statement
            return $stmt->execute();
        }
        public function getEntry()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM entry";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteEntry($id)
        {
            $conn = $this->connect();
            $sql = "DELETE FROM entry WHERE id = :id";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':id', $id);

            // Execute the statement
            return $stmt->execute();
        }

        public function addCancelCause($text)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO cancelcauses (text) VALUES (:text)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':text', $text);

            // Execute the statement
            return $stmt->execute();
        }

        public function getCancelCauses()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM cancelcauses";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteCancelCause($id)
        {
            $conn = $this->connect();
            $sql = "DELETE FROM cancelcauses WHERE id = :id";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':id', $id);

            // Execute the statement
            return $stmt->execute();
        }

        public function addConservationStatus($text)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO conservationstatus (text) VALUES (:text)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':text', $text);

            // Execute the statement
            return $stmt->execute();
        }

        public function getConservationStatuses()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM conservationstatus";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteConservationStatus($id)
        {
            $conn = $this->connect();
            $sql = "DELETE FROM conservationstatus WHERE id = :id";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':id', $id);

            // Execute the statement
            return $stmt->execute();
        }

        public function addDatation($text)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO datations (text) VALUES (:text)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':text', $text);

            // Execute the statement
            return $stmt->execute();
        }

        public function getDatations()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM datations";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteDatation($id)
        {
            $conn = $this->connect();
            $sql = "DELETE FROM datations WHERE id = :id";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':id', $id);

            // Execute the statement
            return $stmt->execute();
        }

        public function addExpositionType($text)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO expositiontypes (text) VALUES (:text)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':text', $text);

            // Execute the statement
            return $stmt->execute();
        }

        public function getExpositionTypes()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM expositiontypes";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteExpositionType($id)
        {
            $conn = $this->connect();
            $sql = "DELETE FROM expositiontypes WHERE id = :id";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':id', $id);

            // Execute the statement
            return $stmt->execute();
        }
    }
?>