<main class="list-wrapper">
    <div class="list-container list-container-javascript">
        
    </div>
    <div>
        <?php
        if (isset($_GET['confirm'])) {
            echo "
            <script>
                Swal.fire({
                    title: 'Eliminar Usuari',
                    text: 'Estàs segur que vols eliminar l\'usuari?',
                    showCancelButton: true,
                    cancelButtonText: 'Tornar',
                    showConfirmButton: true,
                    confirmButtonText: 'Estic segur'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir al controlador, pasando el id del usuario en el GET
                        window.location.href = 'http://localhost:8080/projecteDAW/index.php?page=usuaris&confirmedUserID=" . urlencode($_GET['userID']) . "';
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = 'http://localhost:8080/projecteDAW/index.php?page=usuaris'; // Redirige a la lista de usuarios
                    }
                });
            </script>";
        }

        if ($_GET['confirmedUserID']) {
            $userController = new UserController();
            $confirmation = $userController->deleteUser((int)$_GET['confirmedUserID']);
            if ($confirmation) {
                echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuari eliminat',
                        text: 'Usuari eliminat correctament.',
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
                        text: 'No hem pogut eliminar el usuari.',
                        showConfirmButton: true,
                        confirmButtonText: 'Tornar'
                    });
                </script>";
            }
        }
        ?>
    </div>
</main>