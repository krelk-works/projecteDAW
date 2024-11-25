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
            $sql = "SELECT * FROM entry ORDER BY entry.text";

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
            $sql = "SELECT * FROM cancelcauses ORDER BY cancelcauses.text";

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
            $sql = "SELECT * FROM conservationstatus ORDER BY conservationstatus.text";

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

        public function addDatation($text, $start_date, $end_date)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO datations (text, start_date, end_date) VALUES (:text, :start_date, :end_date)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);

            // Execute the statement
            return $stmt->execute();
        }

        public function getDatations()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM datations ORDER BY datations.text";

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
            $sql = "SELECT * FROM expositiontypes ORDER BY expositiontypes.text";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getExpositionID($expotype)
        {
            $conn = $this->connect();
            $sql = "SELECT id FROM expositiontypes WHERE text ='" . $expotype . "'";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetch(PDO::FETCH_ASSOC);
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

        public function addAuthor($name)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO authors (name) VALUES (:name)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':name', $name);

            // Execute the statement
            return $stmt->execute();
        }

        public function getAuthors()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM authors ORDER BY authors.name";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteAuthor($id) {
            $conn = $this->connect();
            $sql = "DELETE FROM authors WHERE id = :id";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':id', $id);

            // Execute the statement
            return $stmt->execute();
        }

        public function addGenericClassification($text)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO genericclassifications (text) VALUES (:text)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':text', $text);

            // Execute the statement
            return $stmt->execute();
        }

        public function getGenericClassifications()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM genericclassifications ORDER BY genericclassifications.text";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteGenericClassification($id)
        {
            $conn = $this->connect();
            $sql = "DELETE FROM genericclassifications WHERE id = :id";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':id', $id);

            // Execute the statement
            return $stmt->execute();
        }

        public function addMaterial($text)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO materials (text) VALUES (:text)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':text', $text);

            // Execute the statement
            return $stmt->execute();
        }

        public function getMaterials()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM materials ORDER BY materials.text";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteMaterial($id)
        {
            $conn = $this->connect();
            $sql = "DELETE FROM materials WHERE id = :id";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':id', $id);

            // Execute the statement
            return $stmt->execute();
        }

        public function addTecnique($text)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO tecniques (text) VALUES (:text)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':text', $text);

            // Execute the statement
            return $stmt->execute();
        }

        public function getTecniques()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM tecniques ORDER BY tecniques.text";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteTecnique($id)
        {
            $conn = $this->connect();
            $sql = "DELETE FROM tecniques WHERE id = :id";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':id', $id);

            // Execute the statement
            return $stmt->execute();
        }

        public function addGetty($text)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO materialgettycodes (text) VALUES (:text)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':text', $text);

            // Execute the statement
            return $stmt->execute();
        }

        public function getGettys()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM materialgettycodes ORDER BY materialgettycodes.text";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteGetty($id)
        {
            $conn = $this->connect();
            $sql = "DELETE FROM materialgettycodes WHERE id = :id";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':id', $id);

            // Execute the statement
            return $stmt->execute();
        }

        public function addGettyTecnique($text)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO tecniquegettycodes (text) VALUES (:text)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':text', $text);

            // Execute the statement
            return $stmt->execute();
        }

        public function getGettyTecniques()
        {
            $conn = $this->connect();
            $sql = "SELECT * FROM tecniquegettycodes";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteGettyTecnique($id)
        {
            $conn = $this->connect();
            $sql = "DELETE FROM tecniquegettycodes WHERE id = :id";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':id', $id);

            // Execute the statement
            return $stmt->execute();
        }
    }
?>