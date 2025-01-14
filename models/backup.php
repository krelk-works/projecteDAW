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
        $servername = "srv1271.hstgr.io";
        $dbname = "u411677469_db";
        $username = "u411677469_fenosa";
        $password = "f3n0s42025Z";

        // Nombre del archivo de copia de seguridad con fecha y hora actual
        $date = new DateTime();
        $currentDate = $date->format('dmYHis');
        $backupFileName = $name ? self::formatName($name) . '.sql' : 'backup' . $currentDate . '.sql';
        $backupFilePath = BACKUP_DIRECTORY . $backupFileName; // Ruta del archivo SQL

        // Comando mysqldump para realizar la copia de seguridad
        $command = "mysqldump --host=$servername --user=$username --password=$password --databases $dbname > $backupFilePath";

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
    public function restore($zipFileName)
    {
        // Variables de conexión que ya están en la clase Database
        $servername = "srv1271.hstgr.io";
        $dbname = "u411677469_db";
        $username = "u411677469_fenosa";
        $password = "f3n0s42025Z";

        // Directorio donde se encuentran los backups
        $backupDirectory = "/var/www/html/backups/";

        // Ruta completa del archivo ZIP
        $zipFilePath = $backupDirectory . $zipFileName;

        // Verificar si el archivo ZIP existe
        if (!file_exists($zipFilePath)) {
            return false; // Archivo ZIP no encontrado
        }

        // Extraer el archivo ZIP
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath) === TRUE) {
            // Extraer el contenido del archivo ZIP
            $extractedPath = $backupDirectory; // Extraer en el mismo directorio
            $zip->extractTo($extractedPath);
            $zip->close();
        } else {
            return false; // Error al abrir el archivo ZIP
        }

        // Obtener el nombre del archivo .sql (se asume que hay un solo archivo en el ZIP)
        $sqlFileName = pathinfo($zipFileName, PATHINFO_FILENAME) . '.sql';
        $sqlFilePath = $extractedPath . $sqlFileName;

        // Verificar si el archivo .sql existe después de extraerlo
        if (!file_exists($sqlFilePath)) {
            return false; // Archivo .sql no encontrado
        }

        // Comando para restaurar la base de datos
        $command = "mysql --host=$servername --user=$username --password=$password $dbname < $sqlFilePath";

        // Ejecutar el comando
        system($command, $output);

        // Eliminar el archivo .sql después de restaurar
        unlink($sqlFilePath);

        // Verificar si la restauración fue exitosa
        if ($output === 0) {
            return true; // Restauración exitosa
        } else {
            return false; // Error al restaurar
        }
    }

}
?>
