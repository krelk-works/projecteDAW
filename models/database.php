<?php
    class Database{
        public function connect(){
            $servername = "bbyirnoypbjzxaryzns9-mysql.services.clever-cloud.com";
            $dbname= "bbyirnoypbjzxaryzns9";
            $username = "ujthole5uvbkxwxc";
            $password = "IYMr7GQwI6KWjKaoAhzn";
            try {
                // New connection to the database with PDO object.
                $this->db = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
                // Set the PDO error mode to exception.
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->db;
            } catch(PDOException $e) {
                //echo "<br><h1>Error a la base de dades -> </h1><br><br><br>".$e;
            }
        }
    }
?>