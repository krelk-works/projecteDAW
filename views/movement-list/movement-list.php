<?php
    $movements = new MovementsController();
    $data = $movements->getAllMovements();
?>

<main class="list-wrapper-moviment">
    <div class="list-container-moviment list-container-javascript">
        <div class="list-header-moviment list-header-moviment-admin">
            <a href="">
                <h4>Títol</h4>
            </a>
            <a href="">
                <h4>Data inici</h4>
            </a>
            <a href="">
                <h4>Data finalització</h4>
            </a>
            <a href="">
                <h4>Destí del moviment</h4>
            </a>
        </div>
        <?php
            $MovementsController = new MovementsController();
            $datamov = $MovementsController->getAllMovements();
            foreach ($datamov as $data) {
                echo '<div class="list-item-moviment list-item-moviment-admin" 
                    onclick="showMovementDetails(\'' . $data['title'] . '\', \'' . $data['start_date'] . '\', \'' . $data['end_date'] . '\', \'' . $data['place'] . '\')">
                    <h3>' . $data['title'] . '</h3>
                    <p>' . $data['start_date'] . '</p>
                    <p>' . $data['end_date'] . '</p>
                    <p>' . $data['place'] . '</p>
                </div>';
            }
        ?>
    </div>
</main>

<script src="assets/js/movement.js" defer></script>