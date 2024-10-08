<main id="user-modify-wrapper">
    <header>Modificar usuari</header>
    <form action="" method="POST">
            <section>
            <?php
                $controller = new UserController();
                $id = intval($_GET['userID']);
                $data = $controller->getUserData($id);
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Almacenar los datos en un array asociativo
    $user_data = [
        'username'   => $_POST['username'],
        'firstname'  => $_POST['firstname'],
        'lastname'   => $_POST['lastname'],
        'email'      => $_POST['email'],
        'password'   => $_POST['password'],
        'role'       => $_POST['role']
    ];
    //llamar funcion upadte user
    $controller->updateUser($id,$user_data);
}   
?>
<script>
    const button = document.getElementById('submit')
    button.addEventListener('click',function(){
        this.disabled=true
        this.innerText='Enviant...'
    })
</script>