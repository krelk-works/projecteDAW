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
    <button class="accordion default_active">Arbre d'ubicacions</button>
    <div class="panel panel-tree">
        <div id="jstree"><div class="loader-container"><div class="loader"></div></div></div>
    </div>
    <!-- Menú contextual personalizado para tecnicos y administradores -->
    <?php 
        if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'tecnic') {
            echo '<ul id="context-menu" class="context-menu">
                <li id="add-location">Afegir ubicació</li>
                <li id="modify-location">Modificar ubicació</li>
                <li id="delete-location">Esborrar ubicació</li>
            </ul>';
        }
    ?>
    <div class="animated-ratoli">
        <img src="assets/img/ratoli.png" alt="Imagen animada" />
        <p>Feu clic dret per veure opcions</p>
    </div>
</aside>