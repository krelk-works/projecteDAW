<main id="home-list-wrapper">
    <div id="home-list-container">
        <?php
            $ArtworkController = new ArtworkController();
            $totalArtworks = $ArtworkController->getTotalCount();
            $limit = 10; // Número máximo de obras por página
            $currentPagePagination = isset($_GET['pagination']) ? (int)$_GET['pagination'] : 1;
            $offset = ($currentPagePagination - 1) * $limit;
            $data = $ArtworkController->getData($limit, $offset); // Asegúrate de modificar el método en el controlador
            foreach ($data as $artwork) {
                echo '<div class="home-list-item">
                    <div class="home-list-item-img">
                        <img src="' . $artwork['URL'] . '" alt="Obra 1">
                    </div>
                    <div class="home-list-item-info">
                        <h3>' . $artwork['Artwork_name'] . '</h3>
                        <p><i class="fa-solid fa-user"></i> ' . $artwork['Author_name'] . '</p>
                        <p><i class="fa-solid fa-location-dot"></i> ' . $artwork['Location_name'] . '</p>
                        <p><i class="fa-solid fa-bookmark"></i> ' . $artwork['Creation_date'] . '</p>
                        <p><i class="fa-regular fa-clipboard"></i> Museu</p>
                    </div>
                </div>';
            }
        ?>
    </div>
    <div id="home-list-pagination">
        <?php
            // CALCULATE TOTAL PAGES
            $totalPages = (int)ceil($totalArtworks / $limit);

            // CSS VARS
            $disabledClass = 'pagination_disabled';
            $currentPaginationClass = 'current_pagination';

            // BOOLEAN VARS
            $isForwardDisabled = ($currentPagePagination >= $totalPages) ? true : false;
            $isBackwardDisabled = ($currentPagePagination <= 1) ? true : false;

            // PAGINATION BACK BUTTON
            if ($isBackwardDisabled) {
                echo '<button id="home-list-pagination-previous" class="' . $disabledClass . '">Anterior</button>';
            } else {
                echo '<button id="home-list-pagination-previous" onclick="location.href=\'?pagination=' . (($currentPagePagination > 1) ? ($currentPagePagination - 1) : 1) . '\';">Anterior</button>';
            }
            
            // PAGINATION PAGES
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<button class="home-list-pagination-page ' . ($currentPagePagination == $i ? 'current_pagination' : '') . '" onclick="location.href=\'?pagination=' . $i . '\'">' . $i . '</button>';
            }  

            // PAGINATION NEXT BUTTON
            if ($isForwardDisabled) {
                echo '<button id="home-list-pagination-next" class="' . $disabledClass . '">Següent</button>';
            } else {
                echo '<button id="home-list-pagination-next" onclick="location.href=\'?pagination=' . (($currentPagePagination <= $totalPages) ? ($currentPagePagination + 1) : $totalPages) . '\';">Següent</button>';
            }
        ?>
    </div>
</main>
