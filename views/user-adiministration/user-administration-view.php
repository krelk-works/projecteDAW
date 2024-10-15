<?php
$controller = new UserController();

$data = [];


if(isset($_GET['userID']) && !isset($_POST['id'])){
    $data = $controller->getUserData($_GET['userID']);
} else if ($_POST['id']) {
    $data = [
        'username'    => $_POST['username'],
        'first_name'  => $_POST['first_name'],
        'last_name'   => $_POST['last_name'],
        'email'       => $_POST['email'],
        'password'    => $_POST['password'],
        'role'        => $_POST['role'],
        'id'          => $_POST['id'],
        'profile_img' => $_POST['profile_img']
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
                    <img src="'. $data['profile_img'] .'" alt="" class="profile">
                </div>
                <div class="user-data">
                    <label for="nom usuari">Nom usuari</label>
                    <input type="text" name="username" value="' . $data['username'] .'">
                    <label for="nom">Nom</label>
                    <input type="text" name="first_name" value="' . $data['first_name'] .'">
                    <label for="cognoms">Cognoms</label>
                    <input type="text" name="last_name" value="' . $data['last_name'] .'">
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
                    <input type="hidden" value="'.$data['profile_img'].'" name="profileimg">
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
            window.location.href = "?page=usuaris";
        });
        </script></head>
    ';
}

?>
