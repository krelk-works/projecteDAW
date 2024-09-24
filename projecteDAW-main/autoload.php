<?php
    function autoloader($nombreClase){
        include "controllers/$nombreClase.php";
    }
    spl_autoload_register("autoloader");
?>
