<?php
include_once("models/artwork.php");

class ArtworkController
{

    public function getData($limit, $offset, $filter = null)
    {
        $artwork = new Artwork(); // Create a new user object.
        //$artwork->getInfo($Artwork_name); // Call the login method from the user object.
        $data = $artwork->getInfo($limit, $offset, $filter);
        return $data;
    }

    public function getTotalCount($filter = null)
    {
        $artwork = new Artwork(); // Create a new user object.
        $data = $artwork->getTotalCount($filter);
        return $data;
    }

    public function createArtwork($nom_del_museu, $id_letter, $id_num1, $id_num2, $objecte, $descripcio,
    $procedencia, $data_registre, $creation_date, $height, $width, $depth, $titol, $originplace, $executionplace, $tiratge, $altres_numeros,
    $cost, $amount, $historia_objecte, $ubicacio, $autor, $material, /*$exposition, $cancel,*/ $causa_baixa, $estat_conservacio, $datacio, $entry, 
    $expositiontype, $classificacio_generica, $materialgettycode, $tecniquegetty){
        $artwork = new Artwork();
        $data = $artwork->createArtwork($nom_del_museu, $id_letter, $id_num1, $id_num2, $objecte, $descripcio,
        $procedencia, $data_registre, $creation_date, $height, $width, $depth, $titol, $originplace, $executionplace, $tiratge, $altres_numeros,
        $cost, $amount, $historia_objecte, $ubicacio, $autor, $material, /*$exposition, $cancel,*/ $causa_baixa, $estat_conservacio, $datacio, $entry, 
        $expositiontype, $classificacio_generica, $materialgettycode, $tecniquegetty);
        return $data;
    }

    public function getArtworkData($id){
        $artwork = new Artwork();
        $data = $artwork->getArtworkData($id);
        return $data;
    }

    public function updateArtwork($id, $artwork_data){
        $artwork = new Artwork();
        $confirmation = $artwork->updateArtwork($id,$artwork_data);
        return $confirmation;
    }

    public function searchArtwork($searchFilter){
        $artwork = new Artwork();
        $data = $artwork->searchArtwork($searchFilter);
        return $data;
    }

    public function getArtworkList($ID){
        $artwork = new Artwork();
        $data = $artwork->getArtworkList($ID);
        return $data;
    }
}
?>

