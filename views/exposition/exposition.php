<main class="list-wrapper">
    <div class="list-container">
        <div class="list-header">
            <a href="">
                <h4>Nom</h4>
            </a>
            <a href="">
                <h4>Ubicació</h4>
            </a>
            <a href="">
                <h4>Esta expuesto?</h4>
            </a>
        </div>
        <?php
        $ArtworkController = new ArtworkController();
        $totalArtworks = $ArtworkController->getTotalCount($searchFilter);
        $limit = 8; // Número máximo de obras por página
        $currentPagePagination = isset($_GET['pagination']) ? (int) $_GET['pagination'] : 1;
        $offset = ($currentPagePagination - 1) * $limit;
        $data = $ArtworkController->getData($limit, $offset, $searchFilter);
        
        foreach ($data as $artwork) {
            $randomNumber = mt_rand(0, mt_getrandmax()) / mt_getrandmax(); // BORRAR ESTO CUANDO SE IMPLEMENTE EL MODELO
            echo '<div class="list-item list-item-expositions">
                <img src="' . $artwork['URL'] . '" alt="' . $artwork['artwork_name'] . ' ' . $artwork['author_name'] . '">
                <a href="?page=artwork-administration&artworkID=' . $artwork['id'] . '"><h3>' . $artwork['artwork_name'] . '</h3>                </a>
                <p><i class="fa-solid fa-location-dot"></i>' . $artwork['location_name'] . '</p>';
                if ($randomNumber >= 0.5) { // para simular distintos estados de exposicion. BORRAR CUANDO SE IMPLEMENTE EL MODELO
                    echo '<p><i class="fa-solid"></i>' . 'si' . '</p>';
                }
                else {
                    echo '<p><i class="fa-solid"></i>' . 'no' . '</p>';
                }
            echo '</div>';
            //var_dump($artwork);
        }
        ?>
    </div>
</main>