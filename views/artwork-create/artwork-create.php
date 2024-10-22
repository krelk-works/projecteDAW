<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)) {
        $registre = $_POST['registre'];
        $objecte = $_POST['objecte'];
        $procedencia = $_POST['procedencia'];
        $mida = $_POST['mida'];
        $autor = $_POST['autor'];
        $titol = $_POST['titol'];
        $datacio = $_POST['datacio'];
        $ubicacio = $_POST['ubicacio'];
        $data_registre = $_POST['data-registre'];
        $nom_del_museu = $_POST['nom-del-museu'];
        $classificacio_generica = $_POST['classificacio-generica'];
        $mides_maximes = $_POST['mides-maximes'];
        $material = $_POST['material'];
        $baixa = $_POST['baixa'];
        $causa_baixa = $_POST['causa-baixa'];
        $data_baixa = $_POST['data-baixa'];
        $persona_baixa = $_POST['persona-baixa'];
        $altres_numeros = $_POST['altres-numeros'];
        $exemplars = $_POST['exemplars'];
        $data_ingres = $_POST['data-ingres'];
        $estat_conservacio = $_POST['estat-conservacio'];
        $valoracio = $_POST['valoracio'];
        $bibliografia = $_POST['bibliografia'];
        $descripcio = $_POST['descripcio'];
        $tecnica = $_POST['tecnica'];
        $anys = $_POST['anys'];
        $data_inici_ubicacio = $_POST['data-inici-ubicació'];
        $comentari = $_POST['comentari'];
        $forma_ingres = $_POST['forma-ingres'];
        $lloc_execucio = $_POST['lloc-execucio'];
        $lloc_procedencia = $_POST['lloc-procedencia'];
        $tiratge = $_POST['tiratge'];
        $codi_restauracio = $_POST['codi-restauracio'];
        $data_restauracio = $_POST['data-restauració'];
        $historia_objecte = $_POST['historia-objecte'];
        
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Obra Creada!',
                text: 'La obra se ha creado exitosamente.',
                showConfirmButton: true,
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'http://localhost:8080/projecteDAW/index.php?page=artwork-create'; 
                }
            });
        </script>";
        
        $artworkController = new ArtworkController();
        $createdArtwork = $artworkController->createArtwork($registre, $objecte, $procedencia, $mida, $autor, $titol, $datacio, $ubicacio,
        $data_registre, $nom_del_museu, $classificacio_generica, $mides_maximes, $material, $baixa, $causa_baixa, $data_baixa, $persona_baixa,
        $altres_numeros, $exemplars, $data_ingres, $estat_conservacio, $valoracio, $bibliografia, $descripcio,
        $tecnica, $anys, $data_inici_ubicacio, $comentari, $forma_ingres, $lloc_execucio, $lloc_procedencia, $tiratge, $codi_restauracio,
        $data_restauracio, $historia_objecte, $profileimg);

        if ($createdArtwork) {
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Obra Creada!',
                    text: 'La obra se ha creado exitosamente.',
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'http://localhost:8080/projecteDAW/index.php?page=artwork-create'; 
                    }
                });
            </script>";
        } else {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al crear la obra.',
                    showConfirmButton: true,
                    confirmButtonText: 'Intentar de nuevo'
                });
            </script>";
        }
    } else {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El formulario está vacío.',
                showConfirmButton: true,
                confirmButtonText: 'Intentar de nuevo'
            });
        </script>";
    }
}
?>


<div class="container-create">
    <div class="artwork-create-container">
        <form class="artwork-create-form" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=artwork-create" enctype="multipart/form-data" >
            <div class="form-left">
                <label for="registre">Nº Registre</label>
                <input type="text" name="registre" placeholder="No seleccionat">

                <label for="objecte">Nom objecte</label>
                <input type="text" name="objecte" placeholder="No seleccionat">

                <label for="procedencia">Col·lecció de procedència</label>
                <input type="text" name="procedencia" placeholder="No seleccionat">

                <label for="mida">Mida</label>
                <input type="text" name="mida" placeholder="No seleccionat">

                <label for="autor">Autor</label>
                <select name="autor" class="custom_options">
                <option placeholder="tots">Tots</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getAuthors();
                    foreach ($data as $author) {
                        echo '<option value="' . $author['id'] . '"';
                        // Verificar si el autor está seleccionado
                        if (isset($_GET['author']) && $_GET['author'] == $author['id']) {
                            echo ' selected';
                        }
                        echo '>' . $author['name'] . '</option>';
                    }
                    ?>
                </select>

                <label for="titol">Titol</label>
                <select name="titol" class="custom_options">
                    <option placeholder="No seleccionat">No seleccionat</option>
                </select>

                <label for="datacio">Datació</label>
                <select name="datacio" class="custom_options">
                <option placeholder="tots">Tots</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getDatations();
                    foreach ($data as $datation) {
                        echo '<option value="' . $datation['id'] . '"';
                        // Verificar si el autor está seleccionado
                        if (isset($_GET['datation']) && $_GET['datation'] == $datation['id']) {
                            echo ' selected';
                        }
                        echo '>' . $datation['text'] . '</option>';
                    }
                    ?>
                </select>
                <label for="ubicacio">Ubicació</label>
                <select name="ubicacio" class="custom_options">
                <option placeholder="tots">Tots</option>
                    <?php
                    $locationController = new LocationController();
                    $data = $locationController->getLocations();
                    foreach ($data as $location) {
                        echo '<option value="' . $location['id'] . '"';
                        // Verificar si el autor está seleccionado
                        if (isset($_GET['location']) && $_GET['location'] == $location['id']) {
                            echo ' selected';
                        }
                        echo '>' . $location['name'] . '</option>';
                    }
                    ?>
                </select>
                <label for="data-registre">Data registre</label>
                <input type="text" name="data-registre" placeholder="No seleccionat">

                <label for="data-registre">Nom del museu</label>
                <input type="text" name="nom-del-museu" placeholder="No seleccionat">

                <label for="data-registre">Classificació generica</label>
                <select name="classificacio-generica" class="custom_options">
                <option placeholder="tots">Tots</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getGenericClassifications();
                    foreach ($data as $generic) {
                        echo '<option value="' . $generic['id'] . '"';
                        // Verificar si el autor está seleccionado
                        if (isset($_GET['generic']) && $_GET['generic'] == $generic['id']) {
                            echo ' selected';
                        }
                        echo '>' . $generic['text'] . '</option>';
                    }
                    ?>
                </select>

                <label for="data-registre">Mides maximes</label>
                <input type="text" name="mides-maximes" placeholder="No seleccionat">

                <label for="data-registre">Material</label>
                <select name="material" class="custom_options">
                <option placeholder="tots">Tots</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getMaterials();
                    foreach ($data as $material) {
                        echo '<option value="' . $material['id'] . '"';
                        // Verificar si el autor está seleccionado
                        if (isset($_GET['material']) && $_GET['material'] == $material['id']) {
                            echo ' selected';
                        }
                        echo '>' . $material['text'] . '</option>';
                    }
                    ?>
                </select>

                <label for="data-registre">Baixa</label>
                <input type="text" name="baixa" placeholder="No seleccionat">

                
                <label for="data-registre">Causa baixa</label>
                <select name="causa-baixa" class="custom_options">
                <option placeholder="tots">Tots</option>
                <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getCancelCauses();
                    foreach ($data as $cause) {
                        echo '<option value="' . $cause['id'] . '"';
                        // Verificar si el autor está seleccionado
                        if (isset($_GET['cause']) && $_GET['cause'] == $cause['id']) {
                            echo ' selected';
                        }
                        echo '>' . $cause['text'] . '</option>';
                    }
                    ?>
                </select>

                <label for="data-registre">Data de baixa</label>
                <input type="text" name="data-baixa" placeholder="No seleccionat">


                <label for="data-registre">Persona autoritzada baixa</label>
                <input type="text" name="persona-baixa" placeholder="No seleccionat">

                <label for="data-registre">Altres numeros d'identificacio</label>
                <input type="text" name="altres-numeros" placeholder="No seleccionat">




            </div>

            <div class="form-right">

                <label for="exemplars">Nombre d'exemplars</label>
                <input type="text" name="exemplars" placeholder="No seleccionat">

                <label for="data-ingres">Data d'ingres</label>
                <input type="text" name="data-ingres" placeholder="No seleccionat">

                <label for="estat-conservacio">Estat de conservació</label>
                <select name="estat-conservacio" class="custom_options">
                <option placeholder="tots">Tots</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getConservationStatuses();
                    foreach ($data as $status) {
                        echo '<option value="' . $status['id'] . '"';
                        // Verificar si el autor está seleccionado
                        if (isset($_GET['status']) && $_GET['status'] == $status['id']) {
                            echo ' selected';
                        }
                        echo '>' . $status['text'] . '</option>';
                    }
                    ?>
                </select>

                <label for="valoracio">Valoració econòmica</label>
                <input type="text" name="valoracio" placeholder="No seleccionat">

                <label for="bibliografia">Bibliografia</label>
                <input type="text" name="bibliografia" placeholder="No seleccionat">

                <label for="descripcio">Descripció</label>
                <input type="text" name="descripcio" placeholder="No seleccionat">

                <label for="data-registre">Tecnica</label>
                <select name="tecnica" class="custom_options">
                <option placeholder="tots">Tots</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getTecniques();
                    foreach ($data as $tecnica) {
                        echo '<option value="' . $tecnica['id'] . '"';
                        // Verificar si el autor está seleccionado
                        if (isset($_GET['tecnica']) && $_GET['tecnica'] == $tecnica['id']) {
                            echo ' selected';
                        }
                        echo '>' . $tecnica['text'] . '</option>';
                    }
                    ?>
                </select>

                <label for="data-registre">Anys inicias-finals</label>
                <input type="text" name="anys" placeholder="No seleccionat">

                <label for="data-registre">Data inici fi ubicació</label>
                <input type="text" name="data-inici-ubicació" placeholder="No seleccionat">

                <label for="data-registre">Comentari</label>
                <input type="text" name="data-inici-ubicació" placeholder="No seleccionat">

                <label for="data-registre">Forma d'ingres</label>
                <select name="forma-ingres" class="custom_options">
                <option placeholder="tots">Tots</option>
                <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getEntry();
                    foreach ($data as $entry) {
                        echo '<option value="' . $entry['id'] . '"';
                        // Verificar si el autor está seleccionado
                        if (isset($_GET['entry']) && $_GET['entry'] == $entry['id']) {
                            echo ' selected';
                        }
                        echo '>' . $entry['text'] . '</option>';
                    }
                    ?>
                </select>
                
                <label for="data-registre">Lloc d'execucio</label>
                <input type="text" name="lloc-execucio" placeholder="No seleccionat">
                
                <label for="data-registre">Lloc de procedencia</label>
                <input type="text" name="lloc-procedencia" placeholder="No seleccionat">

                <label for="data-registre">Nº tiratge</label>
                <input type="text" name="tiratge" placeholder="No seleccionat">

                <label for="data-registre">Codi restauració</label>
                <input type="text" name="codi-restauracio" placeholder="No seleccionat">

                <label for="data-registre">Data inici fi restauració</label>
                <input type="text" name="data-restauració" placeholder="No seleccionat">

                <label for="data-registre">Historia de l'objecte</label>
                <input type="text" name="historia-objecte" placeholder="No seleccionat">

                <label for="data-registre">Getty</label>
                <select name="getty" class="custom_options">
                <option placeholder="tots">Tots</option>
                <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getGettys();
                    foreach ($data as $getty) {
                        echo '<option value="' . $getty['id'] . '"';
                        // Verificar si el autor está seleccionado
                        if (isset($_GET['getty']) && $_GET['getty'] == $getty['id']) {
                            echo ' selected';
                        }
                        echo '>' . $entry['text'] . '</option>';
                    }
                    ?>
                </select>

                <div class="images">
                    <div class="image-preview">
                        <img src="assets/img/messi.jpg" alt="Imagen 1">
                        <img src="assets/img/bicho.png" alt="Imagen 2">
                    </div>
                    <button type="button" class="add-image-btn">+</button>
                </div>

                <button type="submit" class="submit-btn">Crear obra</button>
                
            </div>
        </form>
    </div>
</div>
