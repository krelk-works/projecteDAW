<?php
        if (isset($_GET['confirm'])) {
            echo "
            <script>
                Swal.fire({
                    title: 'Eliminar Obra',
                    text: 'Estàs segur que vols eliminar l\'obra d\'aquesta exposicio?',
                    showCancelButton: true,
                    cancelButtonText: 'Tornar',
                    showConfirmButton: true,
                    confirmButtonText: 'Estic segur'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir al controlador, pasando el id de la obra en el GET
                        window.location.href = 'index.php?page=exposition-administration&expoID=" . urlencode($_GET['expoID']) . "&confirmedArtworkID=" . urlencode($_GET['artworkID']) . "';
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = 'index.php?page=exposition-administration&expoID=" . urlencode($_GET['expoID']) . "'; // Redirige a la lista de obras-exposiciones
                    }
                });
            </script>";
        }

        if ($_GET['confirmedArtworkID']) {
            $expositionController = new ExpositionController();
            $confirmation = $expositionController->deleteArtworkFromExposition((int)$_GET['expoID'], (int)$_GET['confirmedArtworkID']);
            if ($confirmation) {
                echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Obra eliminada',
                        text: 'L\'obra s\'ha elimiat correctament.',
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php?page=exposition-administration&expoID=" . urlencode($_GET['expoID']) . "';'; // Redirige a la lista de obras-exposiciones
                        }
                    });
                </script>";
            } else {
                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No hem pogut eliminar la obra.',
                        showConfirmButton: true,
                        confirmButtonText: 'Tornar'
                    });
                </script>";
            }
        }
?>
<main class="list-wrapper">
<h2>
    <?php
        $id = $_GET['expoID'];
        $ExpositionController = new ExpositionController();
        $expositionName = $ExpositionController->getExpositionName($id);
        echo $expositionName['name'];
    ?>
</h2>


    <div class="list-container list-container-javascript">
        <div class="list-header list-header-exposition-admin">
            <a href="">
                <h4>Imatge d'obra</h4>
            </a>
            <a href="">
                <h4>Nom d'obra</h4>
            </a>
            <a href="">
                <h4>Data</h4>
            </a>
            <a href="">
                <h4>Opcions</h4>
            </a>
        </div>
        <?php
            $id = $_GET['expoID'];
            $ExpositionController = new ExpositionController();
            $expoData = $ExpositionController->getRelatedArtworks($id);
            foreach ($expoData as $data) {
                echo '<div class="list-item list-item-exposition-admin">
                    <img src="' . $data['image'] . '" alt="' . $data['name'] . '">
                    <h3>' . $data['title'] . '</h3>
                    <p>' . $data['register_date'] . '</p>
                    <a href="?page=exposition-administration&expoID=' . $id . '&confirm=true&artworkID=' . $data['id'] . '"><button class="action_button delete_button">Eliminar</button></a>
                </div>';
            }
        ?>
    </div>
</main>