
<main id="user-modify-wrapper">
    <header>Modificar usuari</header>
    <section>
        <div class="profile-img">
            <img src="assets/img/defaultprofile.png" alt="">
        </div>
        <div class="user-data">
            <?php
                

            ?>
            <label for="nom d'usuari">Nom d'usuari</label>
            <input type="text" name="nom d'usuari" id="">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="">
            <label for="cognoms">Cognoms</label>
            <input type="text" name="cognoms" id="">
            <label for="contraseña">Contrasenya</label>
            <input type="password" name="contrasenya" id="">
            <label for="rol">Rol</label>
            <select name="rol" id="status" class="custom_options">
                <option value="0">Admin</option>
                <option value="1">Tecnic</option>
                <option value="2">Convidat</option>
            </select>
            
        </div>
    </section>
    <footer>
        <button>Confirma</button>
        <button>Eliminar</button>
    </footer>
</main>