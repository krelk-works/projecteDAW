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
        if ($end_date >= $start_date) {
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
                        window.location.href = 'index.php?page=expositions';
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
        if (isset($_POST['toggleSwitch']) && $_POST['toggleSwitch'] == 'on') {
            $_SESSION['expositionFilter'] = 1;
        } else {
            $_SESSION['expositionFilter'] = 0;
        }
    }
}
?>
<aside id="createbar">
    <button class="accordion default_active">Cercador d'exposicions</button>
    <div class="panel">
        <form id="searchbarwrapper" method="POST">
            <label for="expositionsearch">Cercador</label>
            <input type="text" name="expositionsearch" id="expositionsearch" placeholder="Nom de la exposició..." autocomplete="true">
            <hr style="width: 100%; margin-top: 10px; margin-bottom: 5px;">
            <input type="checkbox" name="searchby" id="searchby" value="name"><label for="searchby" id="searchbylabel">Veure exposicions finalitzades</label>
        </form>
    </div>
    
    <button class="accordion">Creació d'exposicions</button>
    <div class="panel">
        <form id="createbarwrapper" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=expositions" enctype="multipart/form-data">
            <label for="name">Nom de l'exposició</label>
            <input type="text" name="name" id="name" placeholder="Introdueix el nom de l'exposició" required autocomplete="true" capitalize>
            <label for="expoloc">Lloc de l'exposició</label>
            <input type="text" name="expoloc" id="expoloc" placeholder="Introdueix el lloc de l'exposició" required capitalize>
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
    </div>
</aside>