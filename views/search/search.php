<aside id="searchbar">
    <form id="searchbarwrapper">
        <h3>Filtre de busqueda</h3>
        <label for="search">Cerca</label>
        <input type="text" name="search" id="search" placeholder="Cerca">
        <label for="search">Autor</label>
        <select name="" id="author_select" class="custom_options">
            <option value="0" class="custom_option">Tots</option>
            <option value="1" class="custom_option">Apel·les Fenosa</option>
            <option value="2" class="custom_option">Autor 2</option>
            <option value="3" class="custom_option">Autor 3</option>
        </select>
        <label for="location">Localització</label>
        <select name="location" id="location" class="custom_options">
            <option value="0">Totes</option>
            <option value="1">Primera planta</option>
            <option value="2">Segona planta</option>
            <option value="3">Tercera planta</option>
        </select>
        <label for="year">Any</label>
        <input type="number" name="year" id="year" min="1500" placeholder="Any">
        <label for="status">Estat</label>
        <select name="status" id="status" class="custom_options">
            <option value="0">Tots</option>
            <option value="1">Museu</option>
            <option value="2">Altre museu</option>
            <option value="3">Confiscat</option>
        </select>
        <button id="searcherButton" type="submit">Cerca</button>
        <?php
            if ($_SESSION['role'] != "convidat") {
                echo 
                '<button id="formGeneratePDFButton" type="button">Descarregar informe</button>';
            }
        ?>
    </form>
    
    
    
    <?php
        /*
        if ($_SESSION['role'] != "convidat") {
            echo 
            '<form id="searchbarwrapper_" action="controllers/PDFController.php" method="POST" target="_blank">
                <button type="submit" id="searcherButton_">Descarregar informe</button>
            </form>';
        }*/

        //TODO: ESTO NO ESTA BIEN, DEBE LLAMAR AL MISMO INDEX.PHP NO A UNA PAGINA EXTERNA "controllers/PDFController.php"
    ?>
</aside>

