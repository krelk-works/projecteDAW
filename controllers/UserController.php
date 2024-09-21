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
        //echo "<br> Profile IMG: ".$user->getProfileimg();
        //echo "<br>Session started";
        //echo "<br>Username: ".$_SESSION['username'];
        //echo "<br>Logout: <a href='?logout'><button>Logout</button></a>";

        // Redirect to the home page.
        //header("Location: index.php?page=home");

        require_once "views/navbar/navbar.php";
        //echo "<h1>Benvingut ".$_SESSION['username']."</h1>";

        //echo '<pre>';
            //var_dump($_SESSION);
        //echo '</pre>';  


        //echo "<h1>Benvingut ".$user->getUsername()."</h1>";
        //echo "<br><a href='index.php'>Tornar a la pàgina principal</a>";
        //echo "<br>The username session is: ".$_SESSION['username'];
    }
}
?>