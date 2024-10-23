<?php
    require_once("database.php");
    class Exposition extends Database {

        public function getActiveExpositions() {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT start_date, end_date, name, expositionlocation, text
            FROM expositions
            INNER JOIN expositiontypes ON expositions.expositiontype = expositiontypes.id
            WHERE end_date > CURDATE()";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAllExpositions() {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT start_date, end_date, name, expositionlocation, text
            FROM expositions
            INNER JOIN expositiontypes ON expositions.expositiontype = expositiontypes.id";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function createExposition($name, $expoloc, $expotype, $sd, $ed) {
            $conn = $this->connect();
            $sql = "INSERT INTO expositions (name, expositionlocation, expositiontype, start_date, end_date) 
                    VALUES (:name, :expoloc, :expotype, :sd, :ed)";
            
            // Preparar la consulta
            $stmt = $conn->prepare($sql);
            //echo ($sql);
            // Asignar los valores a los parámetros
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':expoloc', $expoloc);
            $stmt->bindParam(':expotype', $expotype);
            $stmt->bindParam(':sd', $sd);
            $stmt->bindParam(':ed', $ed);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
?>