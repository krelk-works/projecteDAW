<main id="user-modify-wrapper">
    <header>Modificar usuari</header>
    <section>
            <?php
                $controller=new UserController();
                $id = intval($_GET['userID']);
                $data = $controller->getUserData($id);
                echo '
                <div class="profile-img">
                    <img src="'. $data['profileimg'] .'" alt="" class="profile">
                </div>
                <div class="user-data">
                    <label for="nom usuari">Nom usuari</label>
                    <input type="text" name="nom usuari" id="" value=" ' . $data['username'] .' ">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="" value=" ' . $data['firstname'] .' ">
                    <label for="cognoms">Cognoms</label>
                    <input type="text" name="cognoms" id="" value=" ' . $data['lastname'] .' ">
                    <label for="email">email</label>
                    <input type="email" name="email" id="" value=" ' . $data['email'] .' ">
                    <label for="contraseña">Contrasenya</label>
                    <input type="password" name="contrasenya" id="" value=" ' . $data['password'] .' ">
                    <label for="rol">Rol</label>
                    <select name="rol" id="status" class="custom_options" value=" ' . $data['role'] . ' ">
                    
                        <option value="admin" '.($data['role']=='admin'?'selected':'') .'>Admin</option>
                        <option value="tecnic" '.($data['role']=='tecnic'?'selected':'') .'>Tecnic</option>
                        <option value="convidat" '.($data['role']=='convidat'?'selected':'') .'>Convidat</option>
                    </select>
                </div>
                ';
            ?>
    </section>
    <footer>
        <button>Confirma</button>
    </footer>
</main>