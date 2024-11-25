<?php
    require_once("database.php");
    class User extends Database {
        private $username;
        private $password;
        private $first_name;
        private $last_name;
        private $email;
        private $profile_img;
        private $role;

        public function __construct($username = null, $password = null, $first_name = null, $last_name = null, $email = null, $profile_img = null, $role = null){
            $this->username = $username;
            $this->password = $password;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->email = $email;
            $this->profile_img = $profile_img;
            $this->role = $role;
        }
        
        public function getUsername(){
            return $this->username;
        }

        public function getFirst_name(){
            return $this->first_name;
        }

        public function getLast_name(){
            return $this->last_name;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getProfile_img(){
            return $this->profile_img;
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

        public function setFirst_name($first_name){
            $this->first_name = $first_name;
        }

        public function setLast_name($last_name){
            $this->last_name = $last_name;
        }

        public function setEmail($email){
            $this->email = $email;
        }

        public function setProfile_img($profile_img){
            $this->profile_img = $profile_img;
        }

        public function setRole($role){
            $this->role = $role;
        }

        public function update(){
            $conn = $this->connect();
            $sql = "UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, email = :email, profile_img = :profile_img WHERE username = :username";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
        
            // Linking parameters securely to avoid SQL injection
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':profile_img', $this->profile_img);
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
                    $this->first_name = $row['first_name'];
                    $this->last_name = $row['last_name'];
                    $this->email = $row['email'];
                    $this->profile_img = $row['profile_img'];
                    $this->role = $row['role'];
                    
                    // Send data to UserController to start the web session
                    $controller = new UserController();
                    $controller->startSession(new User($this->username, $this->password, $this->first_name, $this->last_name, $this->email, $this->profile_img, $this->role));
                    return true;
                    //$username, $password, $first_name, $last_name, $email, $profile_img, $role
                } else {
                    // TODO: Show error message user or password incorrect
                    return false;
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
            $sql = "SELECT * FROM users ORDER BY username ASC DESC LIMIT :limit OFFSET :offset";
        
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
            $sql = "INSERT INTO users (username, password, first_name, last_name, email, role, profile_img) 
                    VALUES (:username, :password, :first_name, :last_name, :email, :role, :profile_img)";
            
            // Preparar la consulta
            $stmt = $conn->prepare($sql);
            //echo ($sql);
            // Asignar los valores a los parámetros
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':profile_img', $this->profile_img);
            $stmt->bindParam(':role', $this->role);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        public function deleteUser($id){
            $conn = $this->connect();
            // Query to delete user
            $sql="DELETE FROM users WHERE id = :id";
            $stmt=$conn->prepare($sql);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }      
        public function getUserData($id){
            $conn=$this->connect();
            $sql="SELECT * FROM users WHERE id = :id ORDER BY username ASC";
            $stmt=$conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        }
        public function updateUser($id,$data){
            $conn=$this->connect();
            $sql="UPDATE users SET 
                username = :username,
                first_name = :first_name, 
                last_name = :last_name, 
                email = :email, 
                password = :password, 
                role = :role 
            WHERE id = :id";
            $stmt=$conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->bindParam(':role', $data['role']);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        public function getIdByUsername($username){
            $conn = $this->connect();
            $sql = "SELECT id FROM users WHERE username = :username ORDER BY username ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
        public function searchUser($searchfilter){
            $searchTerm="%{$searchfilter}%";

            $conn = $this->connect();
            $sql = "SELECT id, username,email, first_name, last_name, role, profile_img FROM users WHERE username LIKE :searchfilter OR role LIKE :searchfilter OR email LIKE :searchfilter ORDER BY username ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':searchfilter', $searchTerm);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
