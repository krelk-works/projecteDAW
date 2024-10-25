<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'])) {
        // Recojer datos del formulario
        $name = $_POST['name'];
        $expoloc = $_POST['expoloc'];
        $vocabularyController = new VocabularyController();
        $expotype = $vocabularyController->getExpositionID($_POST['expotype']);
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        // comprovar si las fechas son validas y tienen sentido
        $currentDate = new DateTime();
        $currentDate = $currentDate->format('Y-m-d');
        if ($start_date > $currentDate && $end_date >= $start_date) {
            // enviar datos al controlador
            $expositionController = new ExpositionController();
            $check = $expositionController->createExposition($name, $expoloc, $expotype['id'], $start_date, $end_date);
        }
        else {
            $check = false;
        }
        // comprovar si ha funcionado
        if ($check) {
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Exposicio creada',
                    text: 'La exposicio sha creat correctament',
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'http://localhost:8080/projecteDAW/index.php?page=expositions';
                    }
                });
            </script>";
        } else {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha hagut un problema al crear la exposicio: comprova que les dates introduides siguin valides y toena a provar.',
                    showConfirmButton: true,
                    confirmButtonText: 'Tornar'
                });
            </script>";
        }
    }
    else {
        session_start();
        if (isset($_POST['toggleSwitch'])) {
            $_SESSION['expositionFilter'] = 1;
        } else {
            $_SESSION['expositionFilter'] = 0;
        }
    }
}
?>
<aside id="createbar">
    <form id="createbarwrapper" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=expositions" enctype="multipart/form-data">
        <h3>Crear noves exposicions</h3>
        <label for="name">Nom de l'exposició</label>
        <input type="text" name="name" id="name" placeholder="Introdueix el nom de l'exposició" required>
        <label for="expoloc">Lloc de l'exposició</label>
        <input type="text" name="expoloc" id="expoloc" placeholder="Introdueix el lloc de l'exposició" required>
        <label for="expotype">Tipus d'exposició</label>
        <select name="expotype" id="expotype" required>
        <?php
            $vocabularyController = new VocabularyController();
            $data = $vocabularyController->getExpositionTypes();
            foreach ($data as $d) {
                echo "<option value='".$d['text']."' id='expotype' name='expotype'>".$d['text']."</option>";
            }
        ?>
        </select>
        <label for="start_date">Data d'inici</label>
        <input type="date" name="start_date" id="start_date" required>
        <label for="end_date">Data de finalització</label>
        <input type="date" name="end_date" id="end_date" required>
        <button type="submit" id="createExpoButton">Crear exposició</button>
    </form>
    <form id="createbarwrapper" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=expositions&filter=exampleFilter" enctype="multipart/form-data">
        <h3>Filtre</h3>
        <label for="name">Mostra les exposicions que ja han acabat</label>
        <?php
            if ($_SESSION['expositionFilter'] == 1) {
                echo '<input type="checkbox" id="toggleSwitch" name="toggleSwitch" checked>';
            } else {
                echo '<input type="checkbox" id="toggleSwitch" name="toggleSwitch">';
            }
        ?>
        <button type="submit" id="filterExpoButton" value="Guardar">Filtra</button>
    </form>
</aside>
