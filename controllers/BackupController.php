<?php
include_once("models/backup.php");
class BackupController
{
    function human_filesize($bytes, $decimals = 2)
    {
        $factor = floor((strlen($bytes) - 1) / 3);
        if ($factor > 0)
            $sz = 'KMGT';
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
    }

    public function getTotalCount()
    {
        // Get the list of files in the directory and remove the '.' and '..' entries
        $scanned_directory = array_diff(scandir(BACKUP_DIRECTORY), array('..', '.'));
        return count($scanned_directory);
    }

    public function getBackups($limit, $offset)
    {
        // Inicializa el array de backups
        $backups = array();

        // Obtén la lista de archivos en el directorio, eliminando los '.' y '..'
        $scanned_directory = array_diff(scandir(BACKUP_DIRECTORY), array('..', '.'));

        // Ordena los archivos por fecha de modificación (opcional)
        usort($scanned_directory, function ($a, $b) {
            return filemtime(BACKUP_DIRECTORY . $b) - filemtime(BACKUP_DIRECTORY . $a);
        });

        // Aplica la paginación utilizando array_slice
        $paginated_files = array_slice($scanned_directory, $offset, $limit);

        // Itera sobre la lista paginada de archivos
        foreach ($paginated_files as $key => $filename) {
            $file_size = self::human_filesize(filesize(BACKUP_DIRECTORY . $filename));
            $file_creation_date = date("F d Y H:i:s.", filemtime(BACKUP_DIRECTORY . $filename));

            // Verifica que el tamaño y la fecha sean válidos
            if ($file_size && $file_creation_date) {
                $backups[] = array(
                    'id' => $key + $offset,  // ID único basado en la posición actual
                    'filename' => $filename, // Nombre del archivo
                    'filesize' => $file_size, // Tamaño en formato legible
                    'created' => $file_creation_date // Fecha de creación/modificación
                );
            }
        }

        return $backups;
    }


    public function removeBackup($filename = null)
    {
        if ($filename) {
            $file_path = BACKUP_DIRECTORY . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
                return true;
            }
        }
        return false;
    }

    public function create($filename = null)
    {
        $backupModel = new Backup();
        $created = $backupModel->create($filename);
        return $created;
    }
}
?>