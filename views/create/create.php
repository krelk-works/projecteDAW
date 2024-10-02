<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            $userController = new UserController();
            $createdUser=$userController->createUser($username, $password, $firstname, $lastname, $email, $filePath, $role);
            #if ($createdUser){
            #    echo ("Se ha creado correctamente");
            #}
            #else {
            #    echo ("Error");
            #}
            // Verificar si se subió un archivo y moverlo a la carpeta de imágenes
            #if (isset($_FILES['profileimg']) && $_FILES['profileimg']['error'] === 0) {
             #   $imgName = $_FILES['profileimg']['name'];
              #  $imgTmpPath = $_FILES['profileimg']['tmp_name'];
               # $imgSize = $_FILES['profileimg']['size'];
                #$imgType = $_FILES['profileimg']['type'];

                // Definir el directorio de subida
             #   $uploadDir = 'assets/img/';
              #  $filePath = $uploadDir . basename($imgName);

                // Mover el archivo subido al directorio de destino
               # if (move_uploaded_file($imgTmpPath, $filePath)) {
                    // Crear instancia del modelo Create y pasar la ruta de la imagen
                #    $createModel = new Create($username, $password, $firstname, $lastname, $email, $filePath, $role);

                    // Llamar al método para insertar el usuario
                 #   if ($createModel->createUser()) {
                        // Redireccionar a la lista de usuarios
                  #      header("Location: http://localhost:8080/projecteDAW/index.php?page=usuaris");
                   #     exit();
                    #} else {
                     #   echo "Error al crear el usuario.";
                    #}
                #} else {
                 #   echo "Error al subir la imagen.";
               # }
            #} else {
             #   echo "Por favor, sube una imagen válida.";
            #}
        }

?>
<aside id="searchbar">
    <form id="searchbarwrapper" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=usuaris" enctype="multipart/form-data">
        <h3>Creació d'usuaris</h3>
        <label for="username">Nom d'usuari</label>
        <input type="text" name="username" id="username" placeholder="Introdueix el nom" required>
        
        <label for="password">Contrasenya</label>
        <input type="password" name="password" id="password" placeholder="Introdueix la contrasenya" required>
        
        <label for="firstname">Nom</label>
        <input type="firstname" name="firstname" id="firstname" placeholder="Introdueix el nom" required>

        <label for="lastname">Cognom</label>
        <input type="lastname" name="lastname" id="lastname" placeholder="Introdueix el cognom" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Introdueix l'email" required>

        <label for="role">Rol</label>
        <select name="role" id="role" required>
            <option value="admin">admin</option>
            <option value="tecnic">tecnic</option>
            <option value="convidat">convidat</option>
        </select>
        
        <label for="profileimg">Foto</label>
        <input type="file" name="profileimg" id="profileimg" accept="image/*" required>
        
        <button type="submit" id="searcherButton">Crear</button>
    </form>
</aside>
