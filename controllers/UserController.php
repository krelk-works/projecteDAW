<?php
include_once("models/user.php");

class UserController
{
    public function showLoginView()
    {
        require_once "views/login/login.php";
    }

    public function login($username, $password)
    {
        $user = new User(); // Create a new user object.
        $user->login($username, $password); // Call the login method from the user object.
    }

    public function startSession($user)
    {
        // Store user data in session variables.
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['firstname'] = $user->getFirstname();
        $_SESSION['lastname'] = $user->getLastname();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['profileimg'] = $user->getProfileimg();
        $_SESSION['role'] = $user->getRole();

        // Redirect user to the home page.
        echo "<head><meta http-equiv='refresh' content='0;url=index.php'></head>";
    }

    public function createUser($username, $password, $firstname, $lastname, $email, $profileimg, $role)
    {
        $userModel = new User($username, $password, $firstname, $lastname, $email, $profileimg, $role);
        return $userModel->createUser();
    }

    public function getUsers($limit, $offset)
    {
        $user = new User();
        return $user->getUsers($limit, $offset);
    }

    public function getTotalCount()
    {
        $user = new User(); // Create a new user object.
        $data = $user->getTotalCount();
        return $data;
    }
    public function deleteUser($id){
        $user = new User();
        $data = $user->deleteUser($id);
        return $data;
    }
    public function getUserData($id){
        $user = new User();
        $data = $user->getUserData($id);
        return $data;
    }
    public function updateUser($id, $data){
        $user = new User();
        $data = $user->deleteUser($id);
        return $data;
    }
}
?>