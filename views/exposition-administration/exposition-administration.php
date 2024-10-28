<main class="list-wrapper">
    <div class="list-container">
        <div class="list-header list-header-exposition-admin">
            <a href="">
                <h4>Imatge d'obra</h4>
            </a>
            <a href="">
                <h4>Nom d'obra</h4>
            </a>
            <a href="">
                <h4>Data</h4>
            </a>
        </div>
        <?php
            $id = $_GET['expoID'];
            $ExpositionController = new ExpositionController();
            $expoData = $ExpositionController->getRelatedArtworks($id);
            foreach ($expoData as $data) {
                echo '<div class="list-item list-item-exposition-admin">
                    <img src="' . $data['URL'] . '" alt="' . $data['name'] . '">
                    <h3>' . $data['name'] . '</h3>
                    <p>' . $data['register_date'] . '</p>
                </div>';
            }
        ?>
    </div>
</main>