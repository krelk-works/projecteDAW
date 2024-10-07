<?php 
/*
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
                echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
                - Se permiten archivos .gif, .jpg, .png. y de 2MB como máximo.</b></div>';
            } else {
                // Si la imagen es correcta en tamaño y tipo
                // Se intenta subir al servidor
                if (move_uploaded_file($temp, 'assets/img/'.$archivo)) {
                    // Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                } else {
                    // Si no se ha podido subir la imagen, mostramos un mensaje de error
                    echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                }
            }
        }
    }

    // Verificar si el usuario fue creado correctamente
    if ($createdUser) {
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Backup Creat!',
                text: 'El backup s'ha creat exitosament.',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'http://localhost:8080/projecteDAW/index.php?page=backups'; // Redirige a la lista de usuarios
                }
            });
        </script>";
    } else {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al crear el usuario.',
                showConfirmButton: true,
                confirmButtonText: 'Intentar de nuevo'
            });
        </script>";
    }
}
*/
?>
<aside id="createbar">
    <form id="createbarwrapper" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=backups" enctype="multipart/form-data">
        <h3>Creació de backups</h3>
        <label for="username">Nom</label>
        <input type="text" name="backupname" id="backupname" placeholder="Introdueix el nom de la backup" required>

        <button type="submit" id="createButton"><i class="fa-solid fa-user-plus"></i>Crear</button>
    </form>
</aside>
