<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $profileimg = 'assets/img/'.$_FILES['profileimg']['name'];

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
            } else {
                // Si la imagen es correcta en tamaño y tipo
                // Se intenta subir al servidor
                if (move_uploaded_file($temp, 'assets/img/'.$archivo)) {
                    // Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                        // Crear el usuario en la base de datos
                    $userController = new UserController();
                    $createdUser = $userController->createUser($username, $password, $firstname, $lastname, $email, $profileimg, $role);
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
                title: '¡Usuario Creado!',
                text: 'El usuario se ha creado exitosamente.',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'http://localhost:8080/projecteDAW/index.php?page=usuaris'; // Redirige a la lista de usuarios
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
?>

<aside id="createbar">
    <form id="searchbarwrapper" action="<?= $_SERVER['PHP_SELF']; ?>?inici" method="GET">
        <h3>Filtre de busqueda</h3>
        <label for="search">Cerca</label>
        <input type="text" name="search" id="search" placeholder="Cerca" value="<?php if (isset($_GET['search']))
            echo $_GET['search']; ?>">
        <label for="role">Rol</label>
        <select name="role" id="role">
            <option value="admin">Admin</option>
            <option value="tecnic">Tecnic</option>
            <option value="convidat">Convidat</option>
        </select>

        <button id="searcherButton" type="submit" class="search_button"><i class="fa-solid fa-magnifying-glass"></i>Cerca</button>
    
        <button id="resetFilters" type="button" class="delete_button"><i class="fa-solid fa-eraser"></i>Resetejar filtres</button>
        <!--
        <button id="searcherButton" type="button" class="search_button" onclick="redirectToSearchUser()">
            <i class="fa-solid fa-magnifying-glass"></i>Cambiar a creacion
        </button>
-->
    </form>
    <form id="createbarwrapper" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=usuaris" enctype="multipart/form-data">
        <h3>Creació d'usuaris</h3>
        <label for="username">Nom d'usuari</label>
        <input type="text" name="username" id="username" placeholder="Introdueix el nom" maxlength="30" required>
        
        <label for="password">Contrasenya</label>
        <input type="password" name="password" id="password" placeholder="Introdueix la contrasenya" maxlength="30" required>
        
        <label for="firstname">Nom</label>
        <input type="firstname" name="firstname" id="firstname" placeholder="Introdueix el nom" maxlength="30" required>

        <label for="lastname">Cognom</label>
        <input type="lastname" name="lastname" id="lastname" placeholder="Introdueix el cognom" maxlength="30" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Introdueix l'email" maxlength="30" required>

        <label for="role">Rol</label>
        <select name="role" id="role" required>
            <option value="admin">admin</option>
            <option value="tecnic">tecnic</option>
            <option value="convidat">convidat</option>
        </select>
        
        <label for="profileimg">Foto</label>
        <input type="file" name="profileimg" id="profileimg" required>
        <button type="submit" id="createButton"><i class="fa-solid fa-user-plus"></i>Crear</button>
        <!--<button id="searcherButton" type="button" class="search_button" onclick="redirectToSearchUser()">
            <i class="fa-solid fa-magnifying-glass"></i>Cambiar a filtrado
        </button>-->

        <script>
// Función para redirigir a la vista de search-user
function redirectToSearchUser() {
    window.location.href = 'http://localhost:8080/projecteDAW/index.php?page=usuarisfilter'; // Cambia la URL según sea necesario
}
</script>

    </form>
</aside>
