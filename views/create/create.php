<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $profileimg = 'assets/img/'.$_FILES['profileimg']['name'];

    // Crear el usuario en la base de datos
    $userController = new UserController();
    $createdUser = $userController->createUser($username, $password, $firstname, $lastname, $email, $profileimg, $role);

    // Comprobar si se ha subido la imagen
    if (isset($_FILES['profileimg'])) {
        // Recogemos el archivo enviado por el formulario
        $archivo = $_FILES['profileimg']['name'];
        // Si el archivo contiene algo
        if (isset($archivo) && $archivo != "") {
            // Obtenemos algunos datos sobre el archivo
            $tipo = $_FILES['profileimg']['type'];
            $tamano = $_FILES['profileimg']['size'];
            $temp = $_FILES['profileimg']['tmp_name'];
            // Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
                echo '<div><b>Error. La extension o el tamaño de los archivos no es correcta.<br/>
                - Se permiten archivos .gif, .jpg, .png. y de 2MB como maximo.</b></div>';
            } else {
                // Si la imagen es correcta en tamaño y tipo
                // Se intenta subir al servidor
                if (move_uploaded_file($temp, 'assets/img/'.$archivo)) {
                    // Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                    chmod('assets/img/'.$archivo, 0777);
                } else {
                    // Si no se ha podido subir la imagen, mostramos un mensaje de error
                    echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                }
            }
        }
    }
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
        <input type="file" name="profileimg" id="profileimg" required>
        <button type="submit" id="searcherButton">Crear</button>
    </form>
</aside>
