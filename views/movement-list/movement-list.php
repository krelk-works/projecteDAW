<?php
    $movements = new MovementsController();
    $data = $movements->getAllMovements();
    print_r($data);
?>