<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)) {
        $nom_del_museu = $_POST['nom-del-museu'];
        $id_letter = $_POST['id_letter'];
        $id_num1 = $_POST['id_num1'];
        $id_num2 = $_POST['id_num2'];
        $objecte = $_POST['objecte'];
        $descripcio = $_POST['descripcio'];
        $procedencia = $_POST['procedencia'];
        $data_registre = $_POST['data-registre'];
        $creation_date = $_POST['creation_date'];
        $height = $_POST['height'];
        $width = $_POST['width'];
        $depth = $_POST['depth'];
        $titol = $_POST['titol'];
        $originplace = $_POST['originplace'];
        $executionplace = $_POST['executionplace'];
        $tiratge = $_POST['tiratge'];
        $altres_numeros = $_POST['altres-numeros'];
        $cost = $_POST['cost'];
        $amount = $_POST['amount'];
        $historia_objecte = $_POST['historia-objecte'];
        $ubicacio = $_POST['ubicacio'];
        $autor = $_POST['autor'];
        $material = $_POST['material'];
        //$exposition = $_POST['exposition'];
        //$cancel = $_POST['cancel'];
        $causa_baixa = $_POST['causa-baixa'];
        $estat_conservacio = $_POST['estat-conservacio'];
        $datacio = $_POST['datacio'];
        $entry = $_POST['entry'];
        $expositiontype = $_POST['expositiontype'];
        $classificacio_generica = $_POST['classificacio-generica'];
        $materialgettycode = $_POST['materialgettycode'];
        $tecniquegetty = $_POST['tecniquegetty'];
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/img/';
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageName = basename($_FILES['image']['name']);
            $imagePath = $uploadDir . $imageName;

            // Mover el archivo cargado al directorio de destino
            if (move_uploaded_file($imageTmpName, $imagePath)) {
                //echo "Imagen subida con éxito.";
                // Aquí puedes guardar la ruta de la imagen en la base de datos, si es necesario
            } else {
                echo "Error al subir la imagen.";
            }
        } else {
            echo "No se ha seleccionado ninguna imagen o hubo un error al subirla.";
        }
        $image = $imagePath;
        $artworkController = new ArtworkController();
        $createdArtwork = $artworkController->createArtwork($nom_del_museu, $id_letter, $id_num1, $id_num2, $objecte, $descripcio,
        $procedencia, $data_registre, $creation_date, $height, $width, $depth, $titol, $originplace, $executionplace, $tiratge, $altres_numeros,
        $cost, $amount, $historia_objecte, $ubicacio, $autor, $material, /*$exposition, $cancel, */$causa_baixa, $estat_conservacio, $datacio, $entry, 
        $expositiontype, $classificacio_generica, $materialgettycode, $tecniquegetty, $image);
        var_dump($createdArtwork);
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
                        window.location.href = 'index.php?'; 
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
        <form class="artwork-create-form" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=artwork-create" enctype="multipart/form-data">
            <div class="form-left">
                <h2>Creacion de obras</h2>

                <h3>Identificacio de l'obra</h3><br>

                <label for="id-letter">ID Letter</label>
                <input type="text" id="id_letter" name="id_letter" maxlength="1" pattern="[A-Z]" placeholder="No seleccionat" oninput="checkIdLetter()">

                <label for="id-num1">ID Num1</label>
                <input type="number" id="id_num1" name="id_num1" min="10001" max="99999" value="<?php
                    //if (isset($_GET['id_letter'])) {
                    //    $artworkController = new ArtworkController();
                    //    $data = $artworkController->getLastIdByLetter($_GET['id_letter']);
                    //    echo $data;
                    //}
                    //else {

                    $artworkController = new ArtworkController();
                    $data = $artworkController->getNextIdNum1();
                    echo $data;
                ?>" placeholder="No seleccionat" required>

                <label for="id-num2">ID Num2</label>
                <input type="number" id="id_num2" name="id_num2" min="0" max="99" placeholder="No seleccionat" required>

                <label for="objecte">Nom objecte</label>
                <input type="text" name="objecte" placeholder="No seleccionat" required>

                <label for="titol">Titol</label>
                <input type="text" name="titol" placeholder="No seleccionat">
                <br><br>
                <h3>Informació de l'obra</h3><br>

                <label for="autor">Autor</label>
                <select name="autor" class="custom_options" required>
                <option value="" disabled selected>Selecciona una opción</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getAuthors();
                    foreach ($data as $author) {
                        echo '<option value="' . $author['id'] . '"';
                        if (isset($_GET['author']) && $_GET['author'] == $author['id']) {
                            echo ' selected';
                        }
                        echo '>' . $author['name'] . '</option>';
                    }
                    ?>
                </select>

                <label for="data-registre">Data registre YYYY/MM/DD</label>
                <input type="text" name="data-registre" placeholder="No seleccionat" required>

                <label for="data-registre">Data de creació YYYY/MM/DD</label>
                <input type="text" name="creation_date" placeholder="No seleccionat" required>

                <label for="datacio">Datació</label>
                <select name="datacio" class="custom_options" required>
                <option value="" disabled selected>Selecciona una opción</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getDatations();
                    foreach ($data as $datation) {
                        echo '<option value="' . $datation['id'] . '"';
                        if (isset($_GET['datation']) && $_GET['datation'] == $datation['id']) {
                            echo ' selected';
                        }
                        echo '>' . $datation['text'] . '</option>';
                    }
                    ?>
                </select>

                <label for="descripcio">Descripció</label>
                <input type="text" name="descripcio" placeholder="No seleccionat">
                <br><br>
                <h3>Caracteristiques de l'obra</h3><br>

                <label for="mida">Alçada</label>
                <input type="number" name="height" placeholder="No seleccionat">

                <label for="mida">Amplada</label>
                <input type="number" name="width" placeholder="No seleccionat">

                <label for="mida">Profunditat</label>
                <input type="number" name="depth" placeholder="No seleccionat">

                <label for="valoracio">Cost</label>
                <input type="number" name="cost" placeholder="No seleccionat" required>

                <label for="exemplars">Quantitat</label>
                <input type="number" name="amount" placeholder="No seleccionat" required>

                <label for="material">Material</label>
                <select name="material" class="custom_options">
                <option value="" disabled selected>Selecciona una opción</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getMaterials();
                    foreach ($data as $material) {
                        echo '<option value="' . $material['id'] . '"';
                        if (isset($_GET['material']) && $_GET['material'] == $material['id']) {
                            echo ' selected';
                        }
                        echo '>' . $material['text'] . '</option>';
                    }
                    ?>

                </select>
                <label for="classificacio-generica">Classificació genèrica</label>
                <select name="classificacio-generica" class="custom_options">
                <option value="" disabled selected>Selecciona una opción</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getGenericClassifications();
                    foreach ($data as $generic) {
                        echo '<option value="' . $generic['id'] . '"';
                        if (isset($_GET['generic']) && $_GET['generic'] == $generic['id']) {
                            echo ' selected';
                        }
                        echo '>' . $generic['text'] . '</option>';
                    }
                    ?>
                </select>

                <label for="estat-conservacio">Estat de conservació</label>
                <select name="estat-conservacio" class="custom_options" required>
                <option value="" disabled selected>Selecciona una opción</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getConservationStatuses();
                    foreach ($data as $status) {
                        echo '<option value="' . $status['id'] . '"';
                        if (isset($_GET['status']) && $_GET['status'] == $status['id']) {
                            echo ' selected';
                        }
                        echo '>' . $status['text'] . '</option>';
                    }
                    ?>
                </select>

                <label for="material-getty-code">Codi de material (Getty)</label>
                <select name="materialgettycode" class="custom_options">
                <option value="" disabled selected>Selecciona una opción</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getGettys();
                    foreach ($data as $getty) {
                        echo '<option value="' . $getty['id'] . '"';
                        if (isset($_GET['getty']) && $_GET['getty'] == $getty['id']) {
                            echo ' selected';
                        }
                        echo '>' . $getty['text'] . '</option>';
                    }
                    ?>

                </select>

                <label for="tecnique-getty">Material (Getty)</label>
                <select name="tecniquegetty" class="custom_options">
                <option value="" disabled selected>Selecciona una opción</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getGettyTecniques();
                    foreach ($data as $gettytecnique) {
                        echo '<option value="' . $gettytecnique['id'] . '"';
                        if (isset($_GET['gettytecnique']) && $_GET['gettytecnique'] == $gettytecnique['id']) {
                            echo ' selected';
                        }
                        echo '>' . $gettytecnique['text'] . '</option>';
                    }
                    ?>

                </select>

            


        

            </div>

            <div class="form-right">

            <br><br>
                <h3>Procedencia de l'obra</h3><br>

                <label for="nom-del-museu">Nom del museu</label>
                <input type="text" name="nom-del-museu" placeholder="No seleccionat">

                <label for="procedencia">Col·lecció de procedència</label>
                <input type="text" name="procedencia" placeholder="No seleccionat">

                <label for="lloc-procedencia">Lloc d'origen</label>
                <input type="text" name="originplace" placeholder="No seleccionat">

                <label for="entry">Tipus d'ingres</label></label>
                <select name="entry" class="custom_options" required>
                <option value="" disabled selected>Selecciona una opción</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getEntry();
                    foreach ($data as $entry) {
                        echo '<option value="' . $entry['id'] . '"';
                        if (isset($_GET['entry']) && $_GET['entry'] == $entry['id']) {
                            echo ' selected';
                        }
                        echo '>' . $entry['text'] . '</option>';
                    }
                    ?>
                </select>
                
                <br><br>
                <h3>Ubicacio de l'obra</h3><br>
                <label for="ubicacio">Ubicació</label>
                <select name="ubicacio" class="custom_options" required>
                <option value="" disabled selected>Selecciona una opción</option>

                    <?php
                    $locationController = new LocationController();
                    $data = $locationController->getLocations();
                    foreach ($data as $location) {
                        echo '<option value="' . $location['id'] . '"';
                        if (isset($_GET['location']) && $_GET['location'] == $location['id']) {
                            echo ' selected';
                        }
                        echo '>' . $location['name'] . '</option>';
                    }
                    ?>
                </select>
            <label for="lloc-execucio">Lloc d'execució</label>
                <input type="text" name="executionplace" placeholder="No seleccionat">

                <label for="tipus-exposicio">Tipus d'exposició</label>
                <select name="expositiontype" class="custom_options">
                <option value="" disabled selected>Selecciona una opción</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getExpositionTypes();
                    foreach ($data as $expositiontype) {
                        echo '<option value="' . $expositiontype['id'] . '"';
                        if (isset($_GET['expositiontype']) && $_GET['expositiontype'] == $expositiontype['id']) {
                            echo ' selected';
                        }
                        echo '>' . $expositiontype['text'] . '</option>';
                    }
                    ?>
                </select>

                <br><br>
                <h3>Altres dades</h3><br>
                

                <label for="tiratge">Tiratge</label>
                <input type="text" name="tiratge" placeholder="No seleccionat">

                <label for="altres-numeros">Altres números d'identificació</label>
                <input type="number" name="altres-numeros" placeholder="No seleccionat">
                
                <label for="historia-objecte">Història</label>
                <input type="text" name="historia-objecte" placeholder="No seleccionat">

                


                <!-- <label for="exposicio">Exposició</label>
                <select name="exposition" class="custom_options">
                    <option placeholder="tots">Tots</option>
                    <?php
                    /*
                    $expositionController = new ExpositionController();
                    $data = $expositionController->getActiveExpositions();
                    foreach ($data as $exposition) {
                        echo '<option value="' . $exposition['id'] . '"';
                        if (isset($_GET['exposition']) && $_GET['exposition'] == $exposition['id']) {
                            echo ' selected';
                        }
                        echo '>' . $exposition['name'] . '</option>';
                    }
                        */
                    ?>

                </select>-->
                <!--
                <label for="baixa">Cancel·lació</label>
                <input type="text" name="cancel" placeholder="No seleccionat">
                -->
                <label for="causa-baixa">Causa de cancel·lació</label>
                <select name="causa-baixa" class="custom_options">
                <option value="" disabled selected>Selecciona una opción</option>
                    <?php
                    $vocabularyController = new VocabularyController();
                    $data = $vocabularyController->getCancelCauses();
                    foreach ($data as $cause) {
                        echo '<option value="' . $cause['id'] . '"';
                        if (isset($_GET['cause']) && $_GET['cause'] == $cause['id']) {
                            echo ' selected';
                        }
                        echo '>' . $cause['text'] . '</option>';
                    }
                    ?>
                </select>




            

        


                <div class="images">
                    <div class="image-preview">
                        <img src="assets/img/messi.jpg" alt="Imagen 1">
                        <img src="assets/img/bicho.png" alt="Imagen 2">
                    </div>
                    <label for="image">Subir Imagen</label>
                        <input type="file" name="image" accept="image/*" required>
                </div>

                <button type="submit" class="submit-btn">Crear obra</button>
            </div>
        </form>
    </div>
</div>


<script>
    function checkIdLetter() {
        const idLetterValue = document.getElementById("id_letter").value;
        console.log("Valor de id_letter:", idLetterValue);
    }
</script>