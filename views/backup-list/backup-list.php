<main class="list-wrapper">
    <div class="list-container">
        <div class="progress-bar-container">
            <?php
            $ds = disk_total_space(".");
            $dsFree = disk_free_space(".");
            $dsTotal = (int) (($dsFree / $ds) * 100);
            ?>
            <p class="aroundText">0%</p>
            <div class="progress-bar-gradient">
                <div class="progress-bar" style="width: 0%;">
                    <p class="progressStatus">
                        <?php echo $dsTotal ?>%
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
        // Include the BackupController
        $backupController = new BackupController();
        $totalBackups = $backupController->getTotalCount();
        $limit = 8; // Número máximo de usuarios por página
        $currentPagePagination = isset($_GET['pagination']) ? (int) $_GET['pagination'] : 1;
        $offset = ($currentPagePagination - 1) * $limit;
        $backups = $backupController->getBackups($limit, $offset);

        // Prevent to see a blank page when there are no backups on pagination
        $futurePagination = ((count($backups) - 1) > 0) ? $currentPagePagination : $currentPagePagination - 1;

        foreach ($backups as $backup) {
            $urlformat = str_replace(' ', '%', $backup['filename']);
            echo '<div class="list-item list-item-backup">
                <img src="https://cdn0.iconfinder.com/data/icons/HDRV/512/Green_Backup.png" alt="Copia de seguridad ' . $backup['filename'] . '" class="rounded-profile-images">
                <h3 class="list-item-backup-filename">' . $backup['filename'] . '</h3>
                <p> <i class="fa-solid fa-calendar-days"></i> ' . $backup['created'] . '</p>
                <p> <i class="fa-solid fa-hard-drive"></i> ' . $backup['filesize'] . '</p>
                <a href="?page=backups&download_backup='.$urlformat.'&pagination='.$currentPagePagination.'" class=""><button class="action_button"><i class="fa-solid fa-download"></i>Descargar</button></a>
                <a href="?page=backups&delete_file='.$urlformat.'&pagination='.$currentPagePagination.'" class="delete_backup_button" topagination="'.$futurePagination.'"><button class="action_button delete_button"><i class="fa-solid fa-trash"></i>Eliminar</button></a>
            </div>';
        }
        ?>
    </div>
    <div class="list-pagination">
        <?php
        // CALCULATE TOTAL PAGES
        $totalPages = (int) ceil($totalBackups / $limit);

        // CSS VARS
        $disabledClass = 'pagination_disabled';
        $currentPaginationClass = 'current_pagination';

        // BOOLEAN VARS
        $isForwardDisabled = ($currentPagePagination >= $totalPages) ? true : false;
        $isBackwardDisabled = ($currentPagePagination <= 1) ? true : false;

        // FIRST PAGE BUTTON "<<"
        if ($currentPagePagination > 1) {
            echo '<button class="list-pagination-page" onclick="location.href=\'?page=backups&pagination=1\';"><<</button>';
        } else {
            echo '<button class="list-pagination-page ' . $disabledClass . '" disabled><<</button>';
        }

        // PAGINATION BACK BUTTON "<"
        if ($isBackwardDisabled) {
            echo '<button class="list-pagination-control ' . $disabledClass . '"><</button>';
        } else {
            echo '<button class="list-pagination-control" onclick="location.href=\'?page=backups&pagination=' . (($currentPagePagination > 1) ? ($currentPagePagination - 1) : 1) . '\';"><</button>';
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
                echo '<button class="list-pagination-page" onclick="location.href=\'?page=backups&pagination=' . $i . '\'">' . $i . '</button>';
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
            echo '<button class="list-pagination-control" onclick="location.href=\'?page=backups&pagination=' . (($currentPagePagination <= $totalPages) ? ($currentPagePagination + 1) : $totalPages) . '\';">></button>';
        }

        // LAST PAGE BUTTON ">>"
        if ($currentPagePagination < $totalPages) {
            echo '<button class="list-pagination-page" onclick="location.href=\'?page=backups&pagination=' . $totalPages . '\';">>></button>';
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