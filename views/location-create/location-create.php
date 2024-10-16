<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recojer datos del formulario
    $location_name = $_POST['location_name'];
    if (isset($_POST['location']) && is_numeric($_POST['location'])) {
        $parent = $_POST['location'];
    } else {
        $parent = null;
    }

    // Crear la ubicacion en la base de datos
    $locationController = new LocationController();
    $createdLocation = $locationController->createLocation($location_name, $parent);
}
?>

<aside id="createbar">
    <form id="createbarwrapper" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=localitzacions" enctype="multipart/form-data">
        <h3>Creació d'ubicacions</h3>
        <label for="location_name">Nom de la ubicació</label>
        <input type="text" name="location_name" id="location_name" placeholder="Introdueix el nom de la ubicació" required>
        <label for="location">Localització pare</label>
        <select name="location" id="location" class="custom_options">
            <option value="sense">sense</option>
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
        <button type="submit" id="createButton"><i class="fa-solid fa-user-plus"></i>Crear</button>
    </form>
</aside>