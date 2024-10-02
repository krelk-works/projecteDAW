<?php
        include_once("models/artwork.php");

        class ArtworkController{

            public function getData($limit, $offset){
                $artwork = new Artwork(); // Create a new user object.
                //$artwork->getInfo($Artwork_name); // Call the login method from the user object.
                $data = $artwork->getInfo($limit, $offset);
                return $data;
            }

            public function getTotalCount(){
                $artwork = new Artwork(); // Create a new user object.
                $data = $artwork->getTotalCount();
                return $data;
            }
        }
    ?>