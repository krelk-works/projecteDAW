<?php
    class Database{
        public function connect(){
            $servername = "srv1271.hstgr.io";
            $dbname= "u411677469_db";
            $username = "u411677469_fenosa";
            $password = "f3n0s42025Z";
            try {
                // Test connection 

                

                // New connection to the database with PDO object.
                $this->db = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
                // Set the PDO error mode to exception.
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->db;
            } catch(PDOException $e) {
                // echo "<br><h1>Error a la base de dades -> </h1><br><br><br>".$e;
                return false;
            }
        }
    }
?>