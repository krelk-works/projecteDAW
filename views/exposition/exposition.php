<main class="list-wrapper">
    <div class="list-container">
        <div class="list-header list-header-expositions">
            <a href="">
                <h4>Nom exposició</h4>
            </a>
            <a href="">
                <h4>Data d'inici</h4>
            </a>
            <a href="">
                <h4>Data de finalització</h4>
            </a>
            <a href="">
                <h4>Lloc exposició</h4>
            </a>
            <a href="">
                <h4>Tipus exposició</h4>
            </a>
        </div>
        <?php
        $ExpositionController = new ExpositionController();
        $expoData = $ExpositionController->getActiveExpositions();
        foreach ($expoData as $exposition) {
            echo '<div class="list-item list-item-expositions">
                    <h3> <i class="fa-solid fa-landmark"></i> ' . $exposition['name'] . '</h3>
                    <p>' . $exposition['start_date'] . '</p>
                    <p>' . $exposition['end_date'] . '</p>
                    <p>' . $exposition['expositionlocation'] . '</p>
                    <p>' . $exposition['text'] . '</p></div>';
        }
        ?>
    </div>
</main>