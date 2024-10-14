<?php
$controller = new UserController();

$data = [];


if(isset($_GET['userID']) && !isset($_POST['id'])){
    $data = $controller->getUserData($_GET['userID']);
} else if ($_POST['id']) {
    $data = [
        'username'   => $_POST['username'],
        'firstname'  => $_POST['firstname'],
        'lastname'   => $_POST['lastname'],
        'email'      => $_POST['email'],
        'password'   => $_POST['password'],
        'role'       => $_POST['role'],
        'id'         => $_POST['id'],
        'profileimg' => $_POST['profileimg']
    ];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //llamar funcion upadte user
    $confirmation = $controller->updateUser((int)$data['id'],$data);
}
?>

<main id="user-modify-wrapper">
    <header>Modificar usuari</header>
    <form action="<?=$_SERVER['PHP_SELF'];?>?page=user-administration&userID=<?php echo $_GET["userID"]; ?>" method="POST">
        <section>
            <?php
                //Auto completa los datos del formulario con
                echo '
                <div class="profile-img">
                    <img src="'. $data['profileimg'] .'" alt="" class="profile">
                </div>
                <div class="user-data">
                    <label for="nom usuari">Nom usuari</label>
                    <input type="text" name="username" value="' . $data['username'] .'">
                    <label for="nom">Nom</label>
                    <input type="text" name="firstname" value="' . $data['firstname'] .'">
                    <label for="cognoms">Cognoms</label>
                    <input type="text" name="lastname" value="' . $data['lastname'] .'">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="' . $data['email'] .'">
                    <label for="contraseña">Contrasenya</label>
                    <input type="password" name="password" value="' . $data['password'] .'">
                    <label for="rol">Rol</label>
                    <select name="role" id="status" class="custom_options">
                        <option value="admin" '.($data['role']=='admin'?'selected':'') .'>Admin</option>
                        <option value="tecnic" '.($data['role']=='tecnic'?'selected':'') .'>Tecnic</option>
                        <option value="convidat" '.($data['role']=='convidat'?'selected':'') .'>Convidat</option>
                    </select>
                    <input type="hidden" value="'.$_GET["userID"].'" name="id">
                    <input type="hidden" value="'.$data['profileimg'].'" name="profileimg">
                </div>
                ';
            ?>
        </section>
    <footer>
        <button type="submit" id="submit">Confirma</button>
        </form>
    </footer>
</main>

<?php

if ($confirmation){
    //echo "<script> alert('Usuario actualizado');</script>";

    echo '<head><script defer>
        Swal.fire({
            title: "Enviat!",
            text: "S\'ha actualitzat correctament!",
            icon: "success"       

        }).then(() => {
            location.href = "?page=usuaris";
        });
        </script></head>
    ';
    echo "
    
    <script>
        const button = document.getElementById('submit')
        button.addEventListener('click',function(){
           
            
        })
        <head><meta http-equiv='refresh' content='0;url=index.php?page=usuaris'></head>
    </script>";
}

?>
