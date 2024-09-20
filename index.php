<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[TITLE]</title>
</head>
<body>
    <?php
        // Needed to include all classes created.
        require_once "autoload.php";

        // Check if the user already login.
        if (isset($_GET['controller'])){
            $nameController = $_GET['controller']."Controller";
        }
        else{
            // Login controller triggered by default.
            $nameController = "LoginController";
        }

        // Check if the controller exists and we have an action to execute.
        if (class_exists($nameController) && isset($_GET['action'])){
            $controller = new $nameController(); 
            
            /*if(isset($_GET['action'])){
                $action = $_GET['action'];
            }
            else{
                $action ="mostrarTodos";
            }

            $controller->$action();*/
        }else{
        
            //echo "No existe el controlador";
        }
    ?>
</body>
</html>