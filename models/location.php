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
            $sql = "SELECT * FROM locations";

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
            $sql = "INSERT INTO locations (name, parent) VALUES (:location_name, :parent)";
            
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

        public function getTotalCount() {
            $conn = $this->connect();
            
            // Base SQL query to count the total number of locations
            $sql = "SELECT COUNT(*) FROM locations";
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the count result
            return $stmt->fetchColumn();
        }

        public function getInfo($limit, $offset) {
            $conn = $this->connect();
            
            // Base SQL query
            $sql = "SELECT L1.name AS pare, L2.name AS fill 
            FROM locations AS L1
            RIGHT JOIN locations AS L2 ON L1.id = L2.parent";
        
            // Add LIMIT and OFFSET for pagination
            $sql .= " LIMIT :limit OFFSET :offset";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
        
            // Bind limit and offset
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
            // Execute the query
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>