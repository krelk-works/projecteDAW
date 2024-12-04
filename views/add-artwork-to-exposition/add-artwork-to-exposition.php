<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recojer datos del formulario
    $IDs = $_POST['addArtwork'];
    $expoID = $_POST['expoID'];
    if ($IDs != []) {
        // enviar datos al controlador
        $expositionController = new ExpositionController();
        $check = $expositionController->uploadArtworkToExposition($IDs, $expoID);
        $check = (int)$check;
    }
    else {
        $check = 2;
    }
    //comprovar si ha funcionado
    if ($check == 2) {
        echo "
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Cap obra afegida',
                text: 'Has de escollir minim 1 obra per poder afegirles a l`exposició',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?page=exposition-administration&expoID=" . $_POST['expoID'] . "';
                }
            });
        </script>";
    }

    else if ($check == 1) {
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Obres afegides',
                text: 'Les obres s`han afegit exitosament',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?page=exposition-administration&expoID=" . $_POST['expoID'] . "';
                }
            });
        </script>";
    }
    
    else {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ha hagut un problema al afegir obres.',
                showConfirmButton: true,
                confirmButtonText: 'Intentar de nuevo'
            });
        </script>";
    }
}
?>
<aside id="createbar">
    <form id="createbarwrapper" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=exposition-administration&expoID=<?=$_GET['expoID'];?>" enctype="multipart/form-data">
        <h3>Afegir obres a l'exposició</h3>
        <input type="hidden" name="expoID" value="<?=$_GET['expoID'];?>">
        <select data-placeholder="Seleccionar obres" multiple class="chosen-select" id="artworks" name='addArtwork[]'>
            <?php
                $artworkController = new ArtworkController();
                $ID = $_GET['expoID'];
                $data = $artworkController->getArtworkList($ID);
                foreach ($data as $d) {
                    echo "<option value='".$d['id']."'>".$d['title']."</option>";
                }
            ?>
        </select>
        <button type="submit" id="addArtworksToExposition">Desar</button>
    </form>
</aside>
<script src="assets/js/add-artwork-to-exposition.js" defer></script>
