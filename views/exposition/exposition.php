<main class="list-wrapper">
    <div class="list-container">
        <div class="list-header">
            <a href="">
                <h4>Nom obra</h4>
            </a>
            <a href="">
                <h4>Data d'inici</h4>
            </a>
            <a href="">
                <h4>Data de finalització</h4>
            </a>
        </div>
        <?php
        $ExpositionController = new ExpositionController();
        $expoData = $ExpositionController->getActiveExpositions();
        foreach ($expoData as $exposition) {
            echo '<div class="list-item list-item-expositions">
                <img src="' . $exposition['URL'] . '" alt="' . $exposition['name'] . '">
                <a href="?page=artwork-administration&artworkID=' . $exposition['id'] . '"><h3>' . $exposition['name'] . '</h3></a>
                <p><i class="fa-solid fa-location-dot"></i>' . $exposition['start_date'] . '</p>
                <p><i class="fa-solid fa-location-dot"></i>' . $exposition['end_date'] . '</p>';
            //var_dump($exposition);
        }
        ?>
    </div>
</main>