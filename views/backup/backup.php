<main class="list-wrapper">
    <div class="list-container">
<div class="progress-bar-container">
    <?php  
        $ds = disk_total_space(".");
        $dsFree = disk_free_space(".");
        $dsTotal = (int)(($dsFree / $ds) * 100);
    ?>
    <p class="aroundText">0%</p>
    <div class="progress-bar-gradient">
        <div class="progress-bar" style="width: 0%;">
            <p class="progressStatus">
                <?php echo $dsTotal?>%
            </p>
        </div>
    </div>
    <p class="aroundText">100%</p>
</div>

        <div class="list-header list-item-header-backup">
            <a href="">
                <h4>Nom</h4>
            </a>
            <a href="">
                <h4>Creació</h4>
            </a>
            <a href="">
                <h4>Mida</h4>
            </a>
            <a href="">
                <h4>Descarregar</h4>
            </a>
            <a href="">
                <h4>Eliminar</h4>
            </a>
        </div>
        <?php
        $UserController = new UserController();
        $totalUsers = $UserController->getTotalCount();
        $limit = 8; // Número máximo de usuarios por página
        $currentPagePagination = isset($_GET['pagination']) ? (int) $_GET['pagination'] : 1;
        $offset = ($currentPagePagination - 1) * $limit;
        $data = $UserController->getUsers($limit, $offset);
        foreach ($data as $user) {
            echo '<div class="list-item list-item-backup">
                    <img src="' . $user['profileimg'] . '" alt="' . $user['firstname'] . ' ' . $user['lastname'] . '" class="rounded-profile-images">
                    <h3>' . $user['firstname'] . ' ' . $user['lastname'] . '</h3>
                    <p> <i class="fa-solid fa-user"></i> ' . $user['email'] . '</p>
                    <p> <i class="fa-solid fa-bookmark"></i> ' . $user['role'] . '</p>
                    <a href="?page=user-administration"><button class="action_button"><i class="fa-solid fa-download"></i>Descarregar</button></a>
                    <a href="?page=user-administration"><button class="action_button delete_button"><i class="fa-solid fa-user-minus"></i>Eliminar</button></a>
            </div>';
        }
        ?>
    </div>
    <div class="list-pagination">
        <?php
        // CALCULATE TOTAL PAGES
        $totalPages = (int) ceil($totalUsers / $limit);

        // CSS VARS
        $disabledClass = 'pagination_disabled';
        $currentPaginationClass = 'current_pagination';

        // BOOLEAN VARS
        $isForwardDisabled = ($currentPagePagination >= $totalPages) ? true : false;
        $isBackwardDisabled = ($currentPagePagination <= 1) ? true : false;

        // FIRST PAGE BUTTON "<<"
        if ($currentPagePagination > 1) {
            echo '<button class="list-pagination-page" onclick="location.href=\'?page=usuaris&pagination=1\';"><<</button>';
        } else {
            echo '<button class="list-pagination-page ' . $disabledClass . '" disabled><<</button>';
        }

        // PAGINATION BACK BUTTON "<"
        if ($isBackwardDisabled) {
            echo '<button class="list-pagination-control ' . $disabledClass . '"><</button>';
        } else {
            echo '<button class="list-pagination-control" onclick="location.href=\'?page=usuaris&pagination=' . (($currentPagePagination > 1) ? ($currentPagePagination - 1) : 1) . '\';"><</button>';
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
                echo '<button class="list-pagination-page" onclick="location.href=\'?page=usuaris&pagination=' . $i . '\'">' . $i . '</button>';
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
            echo '<button class="list-pagination-control" onclick="location.href=\'?page=usuaris&pagination=' . (($currentPagePagination <= $totalPages) ? ($currentPagePagination + 1) : $totalPages) . '\';">></button>';
        }

        // LAST PAGE BUTTON ">>"
        if ($currentPagePagination < $totalPages) {
            echo '<button class="list-pagination-page" onclick="location.href=\'?page=usuaris&pagination=' . $totalPages . '\';">>></button>';
        } else {
            echo '<button class="list-pagination-page ' . $disabledClass . '" disabled>>></button>';
        }
        ?>
    </div>

</main>
<script defer>
var i = 0;
move();
function move() {
    var elem = document.getElementsByClassName("progress-bar")[0]; // Accede al primer (y único) elemento con esta clase
    
    setTimeout(() => {
        elem.style.width = "<?php echo $dsTotal ?>%";
    }, 200);
}
</script>