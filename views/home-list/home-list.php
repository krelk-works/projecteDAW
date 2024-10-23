<?php

$searchTriggered = isset($_GET['search']) || isset($_GET['author']) || isset($_GET['location']) || isset($_GET['year']) || isset($_GET['conservationstatus']);
$searchFilter = null;
$urlsearchparams = '';

if ($searchTriggered) {
    $searchFilter = [
        'search' => null,
        'author' => null,
        'location' => null,
        'year' => null,
        'conservationstatus' => null
    ];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];

        if (!empty($search)) {
            /* Debugging */
            //echo "<script>console.log('searchTriggered: " . $search . "');</script>";
            /* --- */
            $searchFilter['search'] = $search;
        }
    }

    if (isset($_GET['author'])) {
        $author = $_GET['author'];
        if (!empty($author) && $author != "tots") {
            /* Debugging */
            //echo "<script>console.log('author: " . $author . "');</script>";
            /* --- */
            $searchFilter['author'] = $author;
        }
    }

    if (isset($_GET['location'])) {
        $location = $_GET['location'];
        if (!empty($location) && $location != "totes") {
            /* Debugging */
            //echo "<script>console.log('location: " . $location . "');</script>";
            /* --- */
            $searchFilter['location'] = $location;
        }
    }

    if (isset($_GET['year'])) {
        $year = $_GET['year'];

        if (!empty($year)) {
            /* Debugging */
            //echo "<script>console.log('year: " . $year . "');</script>";
            /* --- */
            $searchFilter['year'] = $year;
        }
    }

    if (isset($_GET['conservationstatus'])) {
        $conservationstatus = $_GET['conservationstatus'];

        if (!empty($conservationstatus) && $conservationstatus != "tots") {
            /* Debugging */
            //echo "<script>console.log('conservationstatus: " . $conservationstatus . "');</script>";
            /* --- */
            $searchFilter['conservationstatus'] = $conservationstatus;
        }
    }

    // Build the URL search params
    foreach ($searchFilter as $key => $value) {
        if (!empty($value)) {
            $urlsearchparams .= '&' . $key . '=' . $value;
        }
    }
}
?>

<main class="list-wrapper">
    <div class="list-container">
        <div class="list-header">
            <a href="">
                <h4>Nom</h4>
            </a>
            <a href="">
                <h4>Autor</h4>
            </a>
            <a href="">
                <h4>Ubicació</h4>
            </a>
            <a href="">
                <h4>Data</h4>
            </a>
            <a href="">
                <h4>Estat</h4>
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
            echo '<div class="list-item">
                <img src="' . $artwork['URL'] . '" alt="' . $artwork['artwork_name'] . ' ' . $artwork['author_name'] . '">
                <a href="?page=artwork-administration&artworkID=' . $artwork['id'] . '"><h3>' . $artwork['artwork_name'] . '</h3>                </a>
                <p><i class="fa-solid fa-user"></i>' . $artwork['author_name'] . '</p>
                <p><i class="fa-solid fa-location-dot"></i>' . $artwork['location_name'] . '</p>
                <p><i class="fa-solid fa-bookmark"></i>' . $artwork['creation_date'] . '</p>
                <p><i class="fa-regular fa-clipboard"></i>' . $artwork['text'] . '</p>
            </div>';
            //var_dump($artwork);
        }
        ?>
    </div>
    <div class="list-pagination">
        <?php
        // CALCULATE TOTAL PAGES
        $totalPages = (int) ceil($totalArtworks / $limit);

        // CSS VARS
        $disabledClass = 'pagination_disabled';
        $currentPaginationClass = 'current_pagination';

        // BOOLEAN VARS
        $isForwardDisabled = ($currentPagePagination >= $totalPages) ? true : false;
        $isBackwardDisabled = ($currentPagePagination <= 1) ? true : false;

        function getPaginationFilter()
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
        
        //echo '<script>console.log("currentFilter: ' . $currentFilter . '")</script>';
        
        // FIRST PAGE BUTTON "<<"
        $firstPageURL = '?pagination=1' . $currentFilter; // Concatenar los filtros a la URL
        if ($currentPagePagination > 1) {
            echo '<button class="list-pagination-page" onclick="location.href=\'' . $firstPageURL . '\';"><<</button>';
        } else {
            echo '<button class="list-pagination-page ' . $disabledClass . '" disabled><<</button>';
        }

        // PAGINATION BACK BUTTON "<"
        $previousPageURL = '?pagination=' . (($currentPagePagination > 1) ? ($currentPagePagination - 1) : 1) . $currentFilter; // Concatenar los filtros
        if ($isBackwardDisabled) {
            echo '<button class="list-pagination-control ' . $disabledClass . '"><</button>';
        } else {
            echo '<button class="list-pagination-control" onclick="location.href=\'' . $previousPageURL . '\';"><</button>';
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
                $pageURL = '?pagination=' . $i . $currentFilter; // Concatenar los filtros a la URL de cada página
                echo '<button class="list-pagination-page" onclick="location.href=\'' . $pageURL . '\';">' . $i . '</button>';
            }
        }


        // Show "..." after the last visible page if not at the end
        if ($endPage < $totalPages) {
            echo '<button class="list-pagination-control pagination_dots" disabled>...</button>';
        }

        // PAGINATION NEXT BUTTON ">"
        $nextPageURL = '?pagination=' . (($currentPagePagination < $totalPages) ? ($currentPagePagination + 1) : $totalPages) . $currentFilter; // Concatenar los filtros a la URL
        if ($isForwardDisabled) {
            echo '<button class="list-pagination-control ' . $disabledClass . '">></button>';
        } else {
            echo '<button class="list-pagination-control" onclick="location.href=\'' . $nextPageURL . '\';">></button>';
        }


        // PAGINATION LAST PAGE BUTTON ">>"
        $lastPageURL = '?pagination=' . $totalPages . $currentFilter; // Concatenar los filtros a la URL
        
        if ($currentPagePagination < $totalPages) {
            echo '<button class="list-pagination-page" onclick="location.href=\'' . $lastPageURL . '\';">>></button>';
        } else {
            echo '<button class="list-pagination-page ' . $disabledClass . '" disabled>>></button>';
        }

        ?>
    </div>
</main>