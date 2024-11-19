<?php
include_once("models/movements.php");

class MovementsController
{

    public function getAllMovements()
    {
        $movement = new Movement();
        $data = $movement->getAllMovements();
        return $data;
    }

    public function createMovement() {
        $movement = new Movement();
        $check = $movement->createMovement($sd, $ed, $place, $artwork);
        return $check;
    }
}
?>