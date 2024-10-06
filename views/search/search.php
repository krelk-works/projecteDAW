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
                echo '<option value="' . $author['Author_ID'] . '"';
                // Verificar si el autor está seleccionado
                if (isset($_GET['author']) && $_GET['author'] == $author['Author_ID']) {
                    echo ' selected';
                }
                echo '>' . $author['Author_name'] . '</option>';
            }
            ?>
        </select>
        <label for="location">Localització</label>
        <select name="location" id="location" class="custom_options">
            <option value="totes">Totes</option>
            <?php
            $locationController = new LocationController();
            $data = $locationController->getLocations();
            foreach ($data as $location) {
                echo '<option value="' . $location['Location_ID'] . '"';
                // Verificar si el valor en $_GET['location'] coincide con la Location_ID
                if (isset($_GET['location']) && $_GET['location'] == $location['Location_ID']) {
                    echo ' selected';
                }
                echo '>' . $location['Location_name'] . '</option>';
            }
            ?>
        </select>
        <label for="year">Any</label>
        <input type="number" name="year" id="year" min="1500" placeholder="Any">
        <label for="status">Estat</label>
        <select name="status" id="status" class="custom_options">
            <option value="tots">Tots</option>
            <option value="museu">Museu</option>
            <option value="altremuseu">Altre museu</option>
            <option value="confiscat">Confiscat</option>
        </select>
        <button id="searcherButton" type="submit" class="search_button"><i class="fa-solid fa-magnifying-glass"></i>Cerca</button>
        <?php
        if ($_SESSION['role'] != "convidat") {
            echo '<button id="formGeneratePDFButton" type="button"><i class="fa-solid fa-download"></i>Descarregar informe</button>';
        }
        ?>
        <button id="resetFilters" type="button" class="delete_button"><i class="fa-solid fa-eraser"></i>Resetejar filtres</button>
    </form>
</aside>