<?php
require_once("database.php");

class CSV extends Database {
    public function exportCSV() {
        $fileName = "dades.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $fileName);

        $output = fopen('php://output', 'w');

        $conn = $this->connect();
        $sql = "SELECT * FROM artworks";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            $headers = array_keys($result[0]);
            fputcsv($output, $headers);

            foreach ($result as $row) {
                fputcsv($output, $row);
            }
        } else {
            echo "No data in the database";
        }

        fclose($output);
        exit;
    }
}
?>