<main class="list-wrapper">
    <div class="list-container-locations">
        <div class="list-header-locations">
            <a href="">
                <h4>Nom</h4>
            </a>
            <a href="">
                <h4>Pare</h4>
            </a>
        </div>
        <?php
        $locationsController = new LocationController();

        $totalLocations = $locationsController->getTotalCount();
        $limit = 8; // Número máximo de obras por página
        $currentPagePagination = isset($_GET['pagination']) ? (int) $_GET['pagination'] : 1;
        $offset = ($currentPagePagination - 1) * $limit;
        $data = $locationsController->getData($limit, $offset);

        foreach ($data as $location) {
            if ($location['pare'] == null) {
                $location['pare'] = "Cap";
            }
            echo '<div class="list-item">
                <p><i class="fa-solid fa-location-dot"></i>' . $location['fill'] . '</p>
                <p><i class="fa-solid fa-location-dot"></i>' . $location['pare'] . '</p>
            </div>';
        }
        ?>
    </div>
    <div class="list-pagination">
        <?php
        // CALCULATE TOTAL PAGES
        $totalPages = (int) ceil($totalLocations / $limit);

        // CSS VARS
        $disabledClass = 'pagination_disabled';
        $currentPaginationClass = 'current_pagination';

        // BOOLEAN VARS
        $isForwardDisabled = ($currentPagePagination >= $totalPages) ? true : false;
        $isBackwardDisabled = ($currentPagePagination <= 1) ? true : false;

        /*function getPaginationFilter()
        {
            if (!empty($searchFilter)) {
                $filter = '';
                foreach ($searchFilter as $key => $value) {
                    if (!empty($value)) {
                        $filter .= '&' . $key . '=' . $value;
                    }
                }
                return $filter;
            }
        }

        $currentFilter = $urlsearchparams; // Obtener los filtros activos
        */
        //echo '<script>console.log("currentFilter: ' . $currentFilter . '")</script>';
        
        // FIRST PAGE BUTTON "<<"
        if ($currentPagePagination > 1) {
            echo '<button class="list-pagination-page" onclick="location.href=\'?page=localitzacions&pagination=1\';"><<</button>';
        } else {
            echo '<button class="list-pagination-page ' . $disabledClass . '" disabled><<</button>';
        }

        // PAGINATION BACK BUTTON "<"
        if ($isBackwardDisabled) {
            echo '<button class="list-pagination-control ' . $disabledClass . '"><</button>';
        } else {
            echo '<button class="list-pagination-control" onclick="location.href=\'?page=localitzacions&pagination=' . (($currentPagePagination > 1) ? ($currentPagePagination - 1) : 1) . '\';"><</button>';
        }

        // Determine the range of pages to show
        $visiblePages = 5; // Number of visible pages
        $startPage = max(1, $currentPagePagination - floor($visiblePages / 2));
        $endPage = min($totalPages, $startPage + $visiblePages - 1);

        // Adjust startPage if we're close to the end
        if ($endPage - $startPage < $visiblePages - 1) {
            $startPage = max(1, $endPage - $visiblePages + 1);
        }

        // Show "..." before the first visible page if not at the beginning
        if ($startPage > 1) {
            echo '<button class="list-pagination-control pagination_dots" disabled>...</button>';
        }

        // PAGINATION PAGES
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i == $currentPagePagination) {
                // Disable the button if it's the current page
                echo '<button class="list-pagination-page ' . $currentPaginationClass . ' ' . $disabledClass . '" disabled>' . $i . '</button>';
            } else {
                // Regular button if it's not the current page
                echo '<button class="list-pagination-page" onclick="location.href=\'?page=localitzacions&pagination=' . $i . '\'">' . $i . '</button>';
            }
        }


        // Show "..." after the last visible page if not at the end
        if ($endPage < $totalPages) {
            echo '<button class="list-pagination-control pagination_dots" disabled>...</button>';
        }

        // PAGINATION NEXT BUTTON ">"
        if ($isForwardDisabled) {
            echo '<button class="list-pagination-control ' . $disabledClass . '">></button>';
        } else {
            echo '<button class="list-pagination-control" onclick="location.href=\'?page=localitzacions&pagination=' . (($currentPagePagination <= $totalPages) ? ($currentPagePagination + 1) : $totalPages) . '\';">></button>';
        }

        // LAST PAGE BUTTON ">>"
        if ($currentPagePagination < $totalPages) {
            echo '<button class="list-pagination-page" onclick="location.href=\'?page=localitzacions&pagination=' . $totalPages . '\';">>></button>';
        } else {
            echo '<button class="list-pagination-page ' . $disabledClass . '" disabled>>></button>';
        }
        ?>
    </div>
</main>