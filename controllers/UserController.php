<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include_once("models/user.php");

        class UserController{
            public function showLoginView() {
                require_once "views/login/login.php";
            }
        
            public function login($username, $password){
                $user = new User(); // Create a new user object.
                $user->login($username, $password); // Call the login method from the user object.
            }
        
            public function startSession($user){
                //echo var_dump($user);
        
                // Start web session.
                // Server should keep session data for AT LEAST 1 hour
        
                // Store user data in session variables.
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['firstname'] = $user->getFirstname();
                $_SESSION['lastname'] = $user->getLastname();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['profileimg'] = $user->getProfileimg();
                $_SESSION['role'] = $user->getRole();
        
                // Redirect user to the home page.
                echo "<meta http-equiv='refresh' content='0;url=index.php'>";
                
            }
        }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
