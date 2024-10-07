<?php
    require_once("database.php");
    class Location extends Database {
        private $location_name;
        private $parent_id;
    
        public function __construct($location_name = null, $parent_id = null){
            $this->location_name = $location_name;
            $this->parent_id = $parent_id;
        }

        public function getLocation_name(){
            return $this->location_name;
        }

        public function getParent_id(){
            return $this->parent_id;
        }

        public function setLocation_name($location_name){
            $this->location_name = $location_name;
        }

        public function setParentId($parent_id){
            $this->parent_id = $parent_id;
        }

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
        public function createLocation($location_name, $parent) {
            $conn = $this->connect();
            // Query para insertar una nueva ubicacion
            $sql = "INSERT INTO Locations (Location_name, Parent_ID) VALUES (:location_name, :parent)";
            
            // Preparar la consulta
            $stmt = $conn->prepare($sql);
            // Asignar los valores a los parámetros
            $stmt->bindParam(':location_name', $location_name);
            $stmt->bindParam(':parent', $parent);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
?>