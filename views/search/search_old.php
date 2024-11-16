<aside id="searchbar">
    <form id="searchbarwrapper" action="<?= $_SERVER['PHP_SELF']; ?>?inici" method="GET">
        <h3>Filtre de busqueda</h3>
        <label for="search">Cerca</label>
        <input type="text" name="search" id="search" placeholder="Cerca" value="<?php if (isset($_GET['search']))
            echo $_GET['search']; ?>">
        <label for="author">Autor</label>
        <select name="author" id="author">
            <option value="tots">Tots</option>
            <?php
            $authorController = new AuthorController();
            $data = $authorController->getAuthors();
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
        <label for="location">Localització</label>
        <select name="location" id="location">
            <option value="totes">Totes</option>
            <?php
            $locationController = new LocationController();
            $data = $locationController->getLocations();
            foreach ($data as $location) {
                echo '<option value="' . $location['id'] . '"';
                // Verificar si el valor en $_GET['location'] coincide con la Location_ID
                if (isset($_GET['location']) && $_GET['location'] == $location['id']) {
                    echo ' selected';
                }
                echo '>' . $location['name'] . '</option>';
            }
            ?>
        </select>
        <label for="year">Any</label>
        <input type="number" name="year" id="year" min="1500" placeholder="Any">
        <label for="status">Estat</label>
        <select name="status" id="status">
        <option value="tots">Tots</option>
            <?php 
            $statusController = new StatusController();
            $data = $statusController->getStatus();
            foreach ($data as $status) {
                echo '<option value="' . $status['id'] . '"';
                // Verificar si el valor en $_GET['location'] coincide con la Location_ID
                if (isset($_GET['status']) && $_GET['status'] == $status['id']) {
                    echo ' selected';
                }
                echo '>' . $status['text'] . '</option>';
            }
            ?>
        </select>
        <button id="searcherButton" type="submit" class="search_button"><i class="fa-solid fa-magnifying-glass"></i>Cerca</button>
        <?php
        if ($_SESSION['role'] != "convidat") {
            echo '<button id="formGeneratePDFButton" type="button"><i class="fa-solid fa-download"></i>Descarregar informe</button>';
            echo '<a href="?page=artwork-create"><button id="createartwork" type="button"><i class="fa-solid fa-download"></i>Crear obra</button></a>';
        }
        ?>
        <button id="resetFilters" type="button" class="delete_button"><i class="fa-solid fa-eraser"></i>Resetejar filtres</button>
    </form>
</aside>