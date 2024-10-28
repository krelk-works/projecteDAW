<?php 

$controller = new ArtworkController();
$data = [];

if (isset($_GET['artworkID'])) {
    $data = $controller->getArtworkData((int)$_GET['artworkID']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //llamar funcion upadte user
    $confirmation = $controller->updateArtwork((int)$data['id'],$data);
}

?>


<div class="container-create">
    <div class="artwork-create-container">
        <form class="artwork-create-form" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=artwork-administration&artworkId=<?php echo $_GET["artworkId"]; ?>" enctype="multipart/form-data">
            <div class="form-left">
                <h2>Creacion de obras</h2>

                <?php 

                    echo '
                        <label for="nom-del-museu">Nom del museu</label>
                        <input type="text" name="nom-del-museu" placeholder="No seleccionat" value="'.$data['museumname'].'">
                    ';

                    echo '
                        <label for="id-letter">ID Letter</label>
                        <input type="text" id="id_letter" name="id_letter" maxlength="1" pattern="[A-Z]" placeholder="No seleccionat" required value="'.$data['id_letter'].'">
                    ';

                    echo '
                        <label for="id-num1">ID Num1</label>
                        <input type="number" id="id_num1" name="id_num1" min="0" max="9" placeholder="No seleccionat" required value="'.$data['id_num1'].'">
                    ';

                    echo '
                        <label for="id-num2">ID Num2</label>
                        <input type="number" id="id_num2" name="id_num2" min="0" max="9" placeholder="No seleccionat" required value="'.$data['id_num2'].'">
                    ';

                    echo '
                        <label for="objecte">Nom objecte</label>
                        <input type="text" name="objecte" placeholder="No seleccionat" required value="'.$data['name'].'">
                    ';

                    echo '
                        <label for="descripcio">Descripció</label>
                        <input type="text" name="descripcio" placeholder="No seleccionat" value="'.$data['description'].'">
                    ';

                    echo '
                        <label for="procedencia">Col·lecció de procedència</label>
                        <input type="text" name="procedencia" placeholder="No seleccionat" value="'.$data['provenancecollection'].'">
                    ';

                    echo '
                        <label for="data-registre">Data registre YYYY/MM/DD</label>
                        <input type="text" name="data-registre" placeholder="No seleccionat" required value="'.$data['register_date'].'">
                    ';

                    echo '
                        <label for="data-registre">Data de creació YYYY/MM/DD</label>
                        <input type="text" name="creation_date" placeholder="No seleccionat" required value="'.$data['creation_date'].'">
                    ';

                    echo '
                        <label for="mida">Alçada</label>
                        <input type="number" name="height" placeholder="No seleccionat" value="'.$data['height'].'">
                    ';

                    echo '
                        <label for="mida">Amplada</label>
                        <input type="number" name="width" placeholder="No seleccionat" value="'.$data['width'].'">
                    ';

                    echo '
                        <label for="mida">Profunditat</label>
                        <input type="number" name="depth" placeholder="No seleccionat" value="'.$data['depth'].'">
                    ';

                    echo '
                        <label for="titol">Titol</label>
                        <input type="text" name="titol" placeholder="No seleccionat" value="'.$data['title'].'">
                    ';

                    echo '
                        <label for="lloc-procedencia">Lloc d\'origen</label>
                        <input type="text" name="originplace" placeholder="No seleccionat" value="'.$data['originplace'].'">
                    ';

                    echo '
                        <label for="lloc-execucio">Lloc d\'execució</label>
                        <input type="text" name="executionplace" placeholder="No seleccionat" value="'.$data['executionplace'].'">
                    ';

                    echo '
                        <label for="tiratge">Tiratge</label>
                        <input type="text" name="tiratge" placeholder="No seleccionat" value="'.$data['tirage'].'">
                    ';

                    echo '
                        <label for="altres-numeros">Altres números d\'identificació</label>
                        <input type="number" name="altres-numeros" placeholder="No seleccionat" value="'.$data['otheridnumbers'].'">
                    ';

                    echo '
                        <label for="valoracio">Cost</label>
                        <input type="number" name="cost" placeholder="No seleccionat" required value="'.$data['cost'].'">
                    ';
                ?>

            </div>

            <div class="form-right">
                <?php
                    echo '
                        <label for="exemplars">Quantitat</label>
                        <input type="number" name="amount" placeholder="No seleccionat" required value="'.$data['amount'].'">
                    ';

                    echo '
                        <label for="historia-objecte">Història</label>
                        <input type="text" name="historia-objecte" placeholder="No seleccionat" value="'.$data['history'].'">
                    ';

                    echo '
                        <label for="ubicacio">Ubicació</label>
                        <select name="ubicacio" class="custom_options" required>
                            <option selected > </option>
                    ';
                    $locationController = new LocationController();
                    $locations = $locationController->getLocations();
                    foreach ($locations as $location) {
                        echo '<option value="' . $data['location'] . '"';
                        if (isset($data['ubicacio']) && $data['ubicacio'] == $location['id']) {
                            echo ' selected';
                        }
                        echo '>' . $location['name'] . '</option>';
                    }
                    echo '</select>';

                    echo '
                        <label for="autor">Autor</label>
                        <select name="autor" class="custom_options" required>
                            <option disabled></option>
                    ';
                    $vocabularyController = new VocabularyController();
                    $authors = $vocabularyController->getAuthors();
                    foreach ($authors as $author) {
                        echo '<option value="' . $data['name'] . '"';
                        if (isset($data['autor']) && $data['autor'] == $author['id']) {
                            echo ' selected';
                        }
                        echo '>' . $author['name'] . '</option>';
                    }
                    echo '</select>';

                    echo '
                        <label for="material">Material</label>
                        <select name="material" class="custom_options">
                            <option value="" disabled selected>Selecciona una opción</option>
                    ';
                    $materials = $vocabularyController->getMaterials();
                    foreach ($materials as $material) {
                        echo '<option value="' . $material['id'] . '"';
                        if (isset($data['material']) && $data['material'] == $material['id']) {
                            echo ' selected';
                        }
                        echo '>' . $material['text'] . '</option>';
                    }
                    echo '</select>';

                    echo '
                        <label for="causa-baixa">Causa de cancel·lació</label>
                        <select name="causa-baixa" class="custom_options">
                            <option value="" disabled selected>Selecciona una opción</option>
                    ';
                    $causes = $vocabularyController->getCancelCauses();
                    foreach ($causes as $cause) {
                        echo '<option value="' . $cause['id'] . '"';
                        if (isset($data['causa-baixa']) && $data['causa-baixa'] == $cause['id']) {
                            echo ' selected';
                        }
                        echo '>' . $cause['text'] . '</option>';
                    }
                    echo '</select>';

                    echo '
                        <label for="estat-conservacio">Estat de conservació</label>
                        <select name="estat-conservacio" class="custom_options" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                    ';
                    $statuses = $vocabularyController->getConservationStatuses();
                    foreach ($statuses as $status) {
                        echo '<option value="' . $status['id'] . '"';
                        if (isset($data['estat-conservacio']) && $data['estat-conservacio'] == $status['id']) {
                            echo ' selected';
                        }
                        echo '>' . $status['text'] . '</option>';
                    }
                    echo '</select>';

                    echo '
                        <label for="datacio">Datació</label>
                        <select name="datacio" class="custom_options" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                    ';
                    $datations = $vocabularyController->getDatations();
                    foreach ($datations as $datation) {
                        echo '<option value="' . $datation['id'] . '"';
                        if (isset($data['datacio']) && $data['datacio'] == $datation['id']) {
                            echo ' selected';
                        }
                        echo '>' . $datation['text'] . '</option>';
                    }
                    echo '</select>';

                    echo '
                        <label for="entry">Tipus d\'ingres</label>
                        <select name="entry" class="custom_options" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                    ';
                    $entries = $vocabularyController->getEntry();
                    foreach ($entries as $entry) {
                        echo '<option value="' . $entry['id'] . '"';
                        if (isset($data['entry']) && $data['entry'] == $entry['id']) {
                            echo ' selected';
                        }
                        echo '>' . $entry['text'] . '</option>';
                    }
                    echo '</select>';

                    echo '
                        <label for="tipus-exposicio">Tipus d\'exposició</label>
                        <select name="expositiontype" class="custom_options">
                            <option value="" disabled selected>Selecciona una opción</option>
                    ';
                    $expositiontypes = $vocabularyController->getExpositionTypes();
                    foreach ($expositiontypes as $expositiontype) {
                        echo '<option value="' . $expositiontype['id'] . '"';
                        if (isset($data['expositiontype']) && $data['expositiontype'] == $expositiontype['id']) {
                            echo ' selected';
                        }
                        echo '>' . $expositiontype['text'] . '</option>';
                    }
                    echo '</select>';

                    echo '
                        <label for="classificacio-generica">Classificació genèrica</label>
                        <select name="classificacio-generica" class="custom_options">
                            <option value="" disabled selected>Selecciona una opción</option>
                    ';
                    $generics = $vocabularyController->getGenericClassifications();
                    foreach ($generics as $generic) {
                        echo '<option value="' . $generic['id'] . '"';
                        if (isset($data['classificacio-generica']) && $data['classificacio-generica'] == $generic['id']) {
                            echo ' selected';
                        }
                        echo '>' . $generic['text'] . '</option>';
                    }
                    echo '</select>';

                    echo '
                        <label for="material-getty-code">Codi de material (Getty)</label>
                        <select name="materialgettycode" class="custom_options">
                            <option value="" disabled selected>Selecciona una opción</option>
                    ';
                    $gettycodes = $vocabularyController->getGettyCodes();
                    foreach ($gettycodes as $getty) {
                        echo '<option value="' . $getty['id'] . '"';
                        if (isset($data['materialgettycode']) && $data['materialgettycode'] == $getty['id']) {
                            echo ' selected';
                        }
                        echo '>' . $getty['text'] . '</option>';
                    }
                    echo '</select>';

                    echo '
                        <label for="tecnique-getty">Material (Getty)</label>
                        <select name="tecniquegetty" class="custom_options">
                            <option value="" disabled selected>Selecciona una opción</option>
                    ';
                    $gettytecniques = $vocabularyController->getGettyTecniques();
                    foreach ($gettytecniques as $gettytecnique) {
                        echo '<option value="' . $gettytecnique['id'] . '"';
                        if (isset($data['tecniquegetty']) && $data['tecniquegetty'] == $gettytecnique['id']) {
                            echo ' selected';
                        }
                        echo '>' . $gettytecnique['text'] . '</option>';
                    }
                    echo '</select>';
                ?>

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