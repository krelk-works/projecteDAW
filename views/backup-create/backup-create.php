<?php

if (isset($_GET['backupname'])) {
    //echo "Hola Backup";
    //echo "<script>alert('Petición de backup: ".$_GET['backupname']."')</script>";
    $filename = !empty($_GET['backupname']) ? str_replace('%', ' ', $_GET['backupname']) : null;
    $backupController = new BackupController();
    $createdBackup = $backupController->create($filename);
    if ($createdBackup) {
        echo "
        <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Backup Creat!',
                    html: `El backup <strong>" . $createdBackup . "</strong> s'ha generat correctament.`,
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
            };
        </script>";
    } else {
        echo "
        <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: `Hi ha hagut un problema en la creació del Backup.`,
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
            };
        </script>";
    }
}

if (isset($_GET['delete_file']) && isset($_GET['confirmed'])) {
    $backupController = new BackupController();
    $urlunformat = str_replace('%', ' ', $_GET['delete_file']);
    $deletedBackup = $backupController->removeBackup($urlunformat);
    if ($deletedBackup) {
        echo "
        <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Backup Eliminat!',
                    html: `El backup <strong>" . $urlunformat . "</strong> s'ha eliminat exitosament.`,
                    timer: 1800,
                    showConfirmButton: false
                });
            };
        </script>";
    } else {
        echo "
        <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al eliminar el backup.',
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
            };
        </script>";
    }
} elseif (isset($_GET['delete_file']) && !isset($_GET['confirmed'])) {
    $urlunformat = str_replace('%', ' ', $_GET['delete_file']);
    echo "
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Eliminar Backup',
            html: `Estàs segur que vols eliminar el backup <strong>" . $urlunformat . "</strong>?`,
            showCancelButton: true,
            cancelButtonText: 'No',
            showConfirmButton: true,
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result.isConfirmed) {
                delete_backup_button = document.querySelector('.delete_backup_button');
                delete_backup_button_topagination = delete_backup_button.getAttribute('topagination');
                window.location.href = 'index.php?page=backups&delete_file=".$urlunformat."&confirmed&pagination='+delete_backup_button_topagination;
            }
        });
    </script>";
}
?>

<aside id="createbar">
    <form id="createbarwrapper" action="<?= $_SERVER['PHP_SELF']; ?>" method="GET">
        <h3>Creació de backups</h3>
        <label for="backupname">Nom</label>
        <input type="text" name="backupname" id="backupname" placeholder="(Opcional) Nom de la backup">
        <input type="hidden" name="page" value="backups">
        <button type="submit" id="createBackupButton"><i class="fa-solid fa-user-plus"></i>Crear</button>
    </form>
</aside>