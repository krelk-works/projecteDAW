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
            echo '<div class="list-item list-item-expositions">
                <img src="' . $artwork['URL'] . '" alt="' . $artwork['artwork_name'] . ' ' . $artwork['author_name'] . '">
                <a href="?page=artwork-administration&artworkID=' . $artwork['id'] . '"><h3>' . $artwork['artwork_name'] . '</h3>                </a>
                <p><i class="fa-solid fa-location-dot"></i>' . $artwork['location_name'] . '</p>
                <p><i class="fa-solid"></i>' . 'si' . '</p>
            </div>';
            //var_dump($artwork);
        }
        ?>
    </div>
</main>