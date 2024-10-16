<?php
require_once("database.php");

class Backup extends Database {

    public function formatName($name) {
        // Eliminar espacios al inicio y al final
        $name = trim($name);
    
        // Reemplazar múltiples espacios consecutivos por un solo guion
        $name = preg_replace('/\s+/', '-', $name);
    
        // Convertir a minúsculas
        $name = strtolower($name);
    
        // Retornar el nombre formateado
        return $name;
    }
    public function create($name = null) {
        // Variables de conexión que ya están en la clase Database
        $servername = "bbyirnoypbjzxaryzns9-mysql.services.clever-cloud.com";
        $dbname = "bbyirnoypbjzxaryzns9";
        $username = "ujthole5uvbkxwxc";
        $password = "IYMr7GQwI6KWjKaoAhzn";

        // Nombre del archivo de copia de seguridad con fecha y hora actual
        $date = new DateTime();
        $currentDate = $date->format('dmYHis');
        $backupFileName = $name ? self::formatName($name) . '.sql' : 'backup' . $currentDate . '.sql';
        $backupFilePath = BACKUP_DIRECTORY . $backupFileName; // Ruta del archivo SQL

        // Comando mysqldump para realizar la copia de seguridad
        $command = "mysqldump --host=$servername --user=$username --password=$password $dbname > $backupFilePath";

        // Ejecutar el comando
        system($command, $output);

        // Comprobar si se ha creado la copia de seguridad
        if ($output === 0) {

            // Ahora comprimimos el archivo .sql en un .zip
            $zip = new ZipArchive();
            //$zipFileName = 'backup_' . $currentDate . '.zip'; // Nombre del archivo ZIP
            $zipFileName = $name ? self::formatName($name) . '.zip' : 'backup' . $currentDate . '.zip'; // Nombre del archivo ZIP
            $zipFilePath = BACKUP_DIRECTORY . $zipFileName; // Ruta del archivo ZIP

            if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
                // Añadir el archivo SQL al archivo ZIP
                $zip->addFile($backupFilePath, $backupFileName);
                $zip->close();

                // Eliminar el archivo SQL original después de comprimirlo
                unlink($backupFilePath);

                return $zipFileName;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>
