<?php
    require_once("database.php");
    class Exposition extends Database {

        public function getActiveExpositions() {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT start_date, end_date, name, expositionlocation, text, expositions.id
            FROM expositions
            INNER JOIN expositiontypes ON expositions.expositiontype = expositiontypes.id
            WHERE end_date > CURDATE()
            ORDER BY expositions.name ASC";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAllExpositions() {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT start_date, end_date, name, expositionlocation, text, expositions.id
            FROM expositions
            INNER JOIN expositiontypes ON expositions.expositiontype = expositiontypes.id
            ORDER BY expositions.name ASC";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getRelatedArtworks($id) {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT artworks.*
                FROM artworks
                INNER JOIN expositionsartworks ON artworks.id = expositionsartworks.artwork
                WHERE expositionsartworks.exposition = :id;
                ";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);

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

        public function uploadArtworkToExposition($IDs, $expoID) {
            $conn = $this->connect();
        
            $sql = "INSERT INTO expositionsartworks (exposition, artwork) VALUES (:expoID, :artworkID)";
            $stmt = $conn->prepare($sql);
        
            foreach ($IDs as $artworkID) {
                $stmt->bindParam(':expoID', $expoID);
                $stmt->bindParam(':artworkID', $artworkID);
                
                if (!$stmt->execute()) {
                    return false;
                }
            }
        
            return true;
        }

        public function deleteArtworkFromExposition($expoID, $artworkID) {
            $conn = $this->connect();
        
            $sql = "DELETE FROM expositionsartworks WHERE exposition = :expoID AND artwork = :artworkID";
            $stmt = $conn->prepare($sql);
        
            $stmt->bindParam(':expoID', $expoID);
            $stmt->bindParam(':artworkID', $artworkID);
                
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function searchExposition($search){
            $conn = $this->connect();

            $sql = "SELECT start_date, end_date, name, expositionlocation, text, expositions.id
            FROM expositions
            INNER JOIN expositiontypes ON expositions.expositiontype = expositiontypes.id
            WHERE expositions.name LIKE :search
            ORDER BY expositions.name ASC";

            $stmt = $conn->prepare($sql);
            $searchTerm = "%" . $search . "%";

            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getExpositionName($id) {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT name
            FROM expositions
            WHERE id = :id";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>