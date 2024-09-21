<?php
    require_once("database.php");
    class User extends Database {
        private $username;
        private $firstname;
        private $lastname;
        private $email;
        private $profileimg;
        private $role;

        public function __construct($username = null, $firstname = null, $lastname = null, $email = null, $profileimg = null, $role = null){
            $this->username = $username;
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
                    $controller->startSession(new User($this->username, $this->firstname, $this->lastname, $this->email, $this->profileimg, $this->role));
                } else {
                    // TODO: Show error message user or password incorrect
                }
            }
        }
        
    }
?>