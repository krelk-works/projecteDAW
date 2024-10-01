<?php
    require_once("database.php");
    class Artwork extends Database {
        protected $ArtworkID;
        protected $Artwork_name;
        protected $Author_name;

        public function __construct($ArtworkID = null, $Artwork_name = null, $Author_name = null){
            $this->ArtworkID = $ArtworkID;
            $this->Artwork_name = $Artwork_name;
            $this->Author_name = $Author_name;
        }

        public function getArtwork_name(){
            return $this->Artwork_name;
        }

        public function getArtworkID(){
            return $this->ArtworkID;
        }

        public function setArtwork_name($Artwork_name){
            $this->Artwork_name = $Artwork_name;
        }

        /*
        public function getInfo(){
            $conn = $this->connect();
            $sql = "SELECT Artwork.Artwork_ID, Artwork.Artwork_name, Artwork.Creation_date , Author.Author_name, Location.Location_name, Images.URL
             FROM Artwork 
             INNER JOIN Author ON Artwork.Author_ID = Author.Author_ID 
             INNER JOIN Location ON Artwork.Location_ID = Location.Location_ID
             INNER JOIN Images ON Artwork.Artwork_ID = Images.Artwork_ID";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
        
            // Execute the statement
            $stmt->execute();
        
            // Fetch the user
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $row;
        }*/

        

        public function getInfo($limit, $offset) {
            $conn = $this->connect();
            $sql = "SELECT Artwork.Artwork_ID, Artwork.Artwork_name, Artwork.Creation_date, 
                           Author.Author_name, Location.Location_name, Images.URL
                    FROM Artwork 
                    INNER JOIN Author ON Artwork.Author_ID = Author.Author_ID 
                    INNER JOIN Location ON Artwork.Location_ID = Location.Location_ID
                    INNER JOIN Images ON Artwork.Artwork_ID = Images.Artwork_ID
                    LIMIT :limit OFFSET :offset";
        
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
        
            // Bind parameters
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
            // Execute the statement
            $stmt->execute();
        
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getTotalCount() {
            $conn = $this->connect();
            $sql = "SELECT COUNT(*) FROM Artwork";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
    }
?>