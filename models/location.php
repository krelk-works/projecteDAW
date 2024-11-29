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

            try {
                // Execute the statement
                $stmt->execute();
                
                // Fetch the results
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                return false;
            }
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
            try {
                // Ejecutar la consulta
                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        }
        public function modifyLocation($id, $name) {
            $conn = $this->connect();
            // Query para modificar una ubicacion
            $sql = "UPDATE locations SET name = :name WHERE id = :id";
            
            // Preparar la consulta
            $stmt = $conn->prepare($sql);
            // Asignar los valores a los parámetros
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':id', $id);
            try {
                // Ejecutar la consulta
                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        }

        public function deleteLocation($id) {
            $conn = $this->connect();
        
            try {
                // Verificar si hay más de una ubicación en la tabla
                $sqlCountLocations = "SELECT COUNT(*) AS total FROM locations";
                $stmt = $conn->prepare($sqlCountLocations);
                $stmt->execute();
                $totalLocations = $stmt->fetchColumn();
        
                if ($totalLocations <= 1) {
                    // Si solo hay una ubicación, no permitir eliminarla
                    return false;
                }
        
                // Iniciar una transacción para garantizar la consistencia
                $conn->beginTransaction();
        
                // 1. Obtener la ID más baja de la tabla locations donde parent sea NULL
                $sqlGetLowestParentId = "SELECT MIN(id) AS min_id FROM locations WHERE parent IS NULL OR parent = ''";
                $stmt = $conn->prepare($sqlGetLowestParentId);
                $stmt->execute();
                $lowestParentId = $stmt->fetchColumn();
        
                if (!$lowestParentId) {
                    return false;
                    // throw new Exception("No se encontró ninguna ubicación raíz para asignar.");
                }
        
                // 2. Actualizar los artworks que tienen la ubicación a eliminar
                $sqlUpdateArtworks = "UPDATE artworks SET location = :newLocation WHERE location = :oldLocation";
                $stmt = $conn->prepare($sqlUpdateArtworks);
                $stmt->bindParam(':newLocation', $lowestParentId);
                $stmt->bindParam(':oldLocation', $id);
                $stmt->execute();
        
                // 3. Eliminar la ubicación de la tabla locations
                $sqlDeleteLocation = "DELETE FROM locations WHERE id = :id";
                $stmt = $conn->prepare($sqlDeleteLocation);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
        
                // Confirmar la transacción
                $conn->commit();
                return true;
            } catch (Exception $e) {
                // Revertir los cambios en caso de error
                $conn->rollBack();
                // error_log("Error al eliminar la ubicación: " . $e->getMessage());
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

        // public function getLocations(){
        //     $conn = $this->connect();

        //     // SQL Query
        //     $sql = "SELECT * FROM locations";

        //     // Prepare the SQL statement
        //     $stmt = $conn->prepare($sql);

        //     // Execute the statement
        //     $stmt->execute();

        //     // Fetch the results
        //     return $stmt->fetchAll(PDO::FETCH_ASSOC);

        //     // Comentario para el pusheo
        // }
    }
?>