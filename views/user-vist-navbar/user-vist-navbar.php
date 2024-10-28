<?php
session_start();
$controller = new UserController();

// Si la sesión contiene datos del usuario, los usa para completar el formulario
$data = [
    'username'    => $_SESSION['username'] ?? '',
    'first_name'  => $_SESSION['first_name'] ?? '',
    'last_name'   => $_SESSION['last_name'] ?? '',
    'email'       => $_SESSION['email'] ?? '',
    'role'        => $_SESSION['role'] ?? '',
    'profile_img' => $_SESSION['profile_img'] ?? 'default_profile.png'
];

// Si el formulario fue enviado, se actualizan los datos del usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'username'    => $_POST['username'],
        'first_name'  => $_POST['first_name'],
        'last_name'   => $_POST['last_name'],
        'email'       => $_POST['email'],
        'role'        => $_POST['role'],
        'profile_img' => $_POST['profile_img']
    ];

    $confirmation = $controller->updateUser((int)$data['id'], $data);
}
?>

<main id="user-modify-wrapper">
    <header>Modificar usuari</header>
    <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
        <section>
            <?php
                echo '
                <div class="profile-img">
                    <img src="'. $data['profile_img'] .'" alt="" class="profile">
                </div>
                <div class="user-data">
                    <label for="nom usuari">Nom usuari</label>
                    <input type="text" name="username" value="' . $data['username'] .'" required>
                    <label for="nom">Nom</label>
                    <input type="text" name="first_name" value="' . $data['first_name'] .'" required>
                    <label for="cognoms">Cognoms</label>
                    <input type="text" name="last_name" value="' . $data['last_name'] .'" required>
                    <label for="email">Email</label>
                    <input type="email" name="email" value="' . $data['email'] .'" required>
                    <label for="contraseña">Contrasenya</label>
                    <input type="password" name="password" placeholder="Introduce una nueva contraseña">
                    <label for="rol">Rol</label>
                    <select name="role" id="status" class="custom_options">
                        <option value="admin" '.($data['role']=='admin'?'selected':'') .'>Admin</option>
                        <option value="tecnic" '.($data['role']=='tecnic'?'selected':'') .'>Tecnic</option>
                        <option value="convidat" '.($data['role']=='convidat'?'selected':'') .'>Convidat</option>
                    </select>
                    <input type="hidden" name="profile_img" value="'.$data['profile_img'].'">
                </div>
                ';
            ?>
        </section>
        <footer>
            <button type="submit" id="submit">Confirma</button>
        </footer>
    </form>
</main>

<?php
if ($confirmation){
    echo '<script defer>
        Swal.fire({
            title: "Enviat!",
            text: "S\'ha actualitzat correctament!",
            icon: "success"       
        }).then(() => {
            window.location.href = "?page=usuaris";
        });
    </script>';
}
?>
