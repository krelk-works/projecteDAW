<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include_once("models/artwork.php");

        class ArtworkController{
            public function showData() {
                require_once "views/home-list/home-list.php";
            }
        
            public function getData(){
                $artwork = new Artwork(); // Create a new user object.
                //$artwork->getInfo($Artwork_name); // Call the login method from the user object.
                $data = $artwork->getInfo();
                return $data;
            }
        }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>