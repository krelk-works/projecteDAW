<main class="list-wrapper">
    <div class="list-container list-container-javascript">
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
        $backups = $backupController->getBackups();



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
<script src="assets/js/backup.js" defer></script>