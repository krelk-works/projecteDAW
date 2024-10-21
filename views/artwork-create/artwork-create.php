<div class="container-create">
    <div class="artwork-create-container">
        <form action="" class="artwork-create-form">
            <div class="form-left">
                <label for="registre">Nº Registre</label>
                <input type="text" name="registre" value="No seleccionat">

                <label for="objecte">Nom objecte</label>
                <input type="text" name="objecte" value="No seleccionat">

                <label for="procedencia">Col·lecció de procedència</label>
                <input type="text" name="procedencia" value="No seleccionat">

                <label for="mida">Mida</label>
                <input type="text" name="mida" value="No seleccionat">

                <label for="autor">Autor</label>
                <select name="autor" class="custom_options">
                <option value="tots">Tots</option>
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
                    <option value="No seleccionat">No seleccionat</option>
                </select>

                <label for="datacio">Datació</label>
                <select name="datacio" class="custom_options">
                <option value="tots">Tots</option>
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
                <input type="text" name="ubicacio" value="No seleccionat">

                <label for="data-registre">Data registre</label>
                <input type="text" name="data-registre" value="No seleccionat">

                <label for="data-registre">Nom del museu</label>
                <input type="text" name="nom-del-museu" value="No seleccionat">

                <label for="data-registre">Classificació generica</label>
                <select name="classificacio-generica" class="custom_options">
                <option value="tots">Tots</option>
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
                <input type="text" name="mides-maximes" value="No seleccionat">

                <label for="data-registre">Material</label>
                <select name="material" class="custom_options">
                <option value="tots">Tots</option>
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
                <input type="text" name="baixa" value="No seleccionat">

                
                <label for="data-registre">Causa baixa</label>
                <input type="text" name="causa-baixa" value="No seleccionat">


                <label for="data-registre">Data de baixa</label>
                <input type="text" name="data-baixa" value="No seleccionat">


                <label for="data-registre">Persona autoritzada baixa</label>
                <input type="text" name="persona-baixa" value="No seleccionat">

                <label for="data-registre">Altres numeros d'identificacio</label>
                <input type="text" name="altres-numeros" value="No seleccionat">

                <label for="data-registre">Exposició</label>
                <select name="exposicio" class="custom_options">
                <option value="tots">Tots</option>
                    <?php
                    $expositionController = new ExpositionController();
                    $data = $expositionController->getActiveExpositions();
                    foreach ($data as $exposition) {
                        echo '<option value="' . $exposition['id'] . '"';
                        // Verificar si el autor está seleccionado
                        if (isset($_GET['exposition']) && $_GET['exposition'] == $exposition['id']) {
                            echo ' selected';
                        }
                        echo '>' . $exposition['name'] . '</option>';
                    }
                    ?>
                </select>

                <label for="data-registre">Data inici fi exposicio</label>
                <input type="text" name="data-exposicio" value="No seleccionat">
            </div>

            <div class="form-right">

                <label for="exemplars">Nombre d'exemplars</label>
                <input type="text" name="exemplars" value="No seleccionat">

                <label for="data-ingres">Data d'ingres</label>
                <input type="text" name="data-ingres" value="No seleccionat">

                <label for="estat-conservacio">Estat de conservació</label>
                <select name="estat-conservacio" class="custom_options">
                <option value="tots">Tots</option>
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
                <input type="text" name="valoracio" value="No seleccionat">

                <label for="bibliografia">Bibliografia</label>
                <input type="text" name="bibliografia" value="No seleccionat">

                <label for="descripcio">Descripció</label>
                <input type="text" name="descripcio" value="No seleccionat">

                <label for="data-registre">Tecnica</label>
                <select name="tecnica" class="custom_options">
                <option value="tots">Tots</option>
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
                <input type="text" name="anys" value="No seleccionat">

                <label for="data-registre">Data inici fi ubicació</label>
                <input type="text" name="data-inici-ubicació" value="No seleccionat">

                <label for="data-registre">Comentari</label>
                <input type="text" name="data-inici-ubicació" value="No seleccionat">

                <label for="data-registre">Forma d'ingres</label>
                <input type="text" name="forma-ingres" value="No seleccionat">
                
                <label for="data-registre">Lloc d'execucio</label>
                <input type="text" name="lloc-execucio" value="No seleccionat">
                
                <label for="data-registre">Lloc de procedencia</label>
                <input type="text" name="lloc-procedencia" value="No seleccionat">

                <label for="data-registre">Nº tiratge</label>
                <input type="text" name="tiratge" value="No seleccionat">

                <label for="data-registre">Codi restauració</label>
                <input type="text" name="codi-restauracio" value="No seleccionat">

                <label for="data-registre">Data inici fi restauració</label>
                <input type="text" name="data-restauració" value="No seleccionat">

                <label for="data-registre">Historia de l'objecte</label>
                <input type="text" name="historia-objecte" value="No seleccionat">
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
