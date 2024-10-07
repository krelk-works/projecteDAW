<?php
    require_once("database.php");
    class User extends Database {
        private $username;
        private $password;
        private $firstname;
        private $lastname;
        private $email;
        private $profileimg;
        private $role;

        public function __construct($username = null, $password = null, $firstname = null, $lastname = null, $email = null, $profileimg = null, $role = null){
            $this->username = $username;
            $this->password = $password;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->email = $email;
            $this->profileimg = $profileimg;
            $this->role = $role;
        }
        
        public function getUsername(){
            return $this->username;
        }

        public function getFirstname(){
            return $this->firstname;
        }

        public function getLastname(){
            return $this->lastname;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getProfileimg(){
            return $this->profileimg;
        }

        public function getRole(){
            return $this->role;
        }

        public function setUsername($username){
            $this->username = $username;
        }

        public function setPassword($password){
            $this->password = $password;
        }

        public function setFirstname($firstname){
            $this->firstname = $firstname;
        }

        public function setLastname($lastname){
            $this->lastname = $lastname;
        }

        public function setEmail($email){
            $this->email = $email;
        }

        public function setProfileimg($profileimg){
            $this->profileimg = $profileimg;
        }

        public function setRole($role){
            $this->role = $role;
        }

        public function update(){
            $conn = $this->connect();
            $sql = "UPDATE users SET username = :username, firstname = :firstname, lastname = :lastname, email = :email, profileimg = :profileimg WHERE username = :username";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
        
            // Linking parameters securely to avoid SQL injection
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':profileimg', $this->profileimg);
            $stmt->bindParam(':role', $this->role);
        
            // Execute the statement
            $stmt->execute();
        }

        public function login($username, $password){
            $conn = $this->connect();
            $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
        
            // Linking parameters securely to avoid SQL injection
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
        
            // Execute the statement
            $stmt->execute();
        
            // Fetch the user
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // If the query returns a row then...
            if ($row) {
                if ($password == $row['password']) {
                    // Set the user data
                    $this->username = $row['username'];
                    $this->firstname = $row['firstname'];
                    $this->lastname = $row['lastname'];
                    $this->email = $row['email'];
                    $this->profileimg = $row['profileimg'];
                    $this->role = $row['role'];
                    
                    // Send data to UserController to start the web session
                    $controller = new UserController();
                    $controller->startSession(new User($this->username, $this->password, $this->firstname, $this->lastname, $this->email, $this->profileimg, $this->role));
                    //$username, $password, $firstname, $lastname, $email, $profileimg, $role
                } else {
                    // TODO: Show error message user or password incorrect
                }
            }
        }/*
        public function getUsers($limit, $offset){
            $conn = $this->connect();
            $sql = "SELECT * FROM users";
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($row){
                return $row;
            }
        
        }  */ 

        public function getUsers($limit, $offset) {
            $conn = $this->connect();
            $sql = "SELECT * FROM users ORDER BY id DESC LIMIT :limit OFFSET :offset";
        
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
            $sql = "SELECT COUNT(*) FROM users";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        public function createUser() {
            $conn = $this->connect();
            // Query para insertar un nuevo usuario
            $sql = "INSERT INTO users (username, password, firstname, lastname, email, role, profileimg) 
                    VALUES (:username, :password, :firstname, :lastname, :email, :role, :profileimg)";
            
            // Preparar la consulta
            $stmt = $conn->prepare($sql);
            //echo ($sql);
            // Asignar los valores a los parámetros
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':profileimg', $this->profileimg);
            $stmt->bindParam(':role', $this->role);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        public function deleteUser($username){
            $conn = $this->connect();
            // Query to delete user
            $sql="DELETE FROM users WHERE :username";
            $stmt=$conn->prepare($sql);
            $stmt->bindParam(':username', $this->username);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }      
        public function getUserData($id){
            $conn=$this->connect();
            $sql="SELECT * FROM users WHERE :id";
            $stmt=$conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
            //return $stmt->fetch(PDO::FETCH_ASSOC);       
        }
    }
?>