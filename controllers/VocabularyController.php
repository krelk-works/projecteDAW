<?php
include_once("models/vocabulary.php");

class VocabularyController
{
    public function addEntry($text)
    {
        $entry = new Vocabulary();
        $data = $entry->addEntry($text);
        return $data;
    }
    public function getEntry()
    {
        $entry = new Vocabulary();
        $data = $entry->getEntry();
        return $data;
    }

    public function deleteEntry($id)
    {
        $entry = new Vocabulary();
        $data = $entry->deleteEntry($id);
        return $data;
    }

    public function editEntry($id, $text)
    {
        $entry = new Vocabulary();
        $data = $entry->editEntry($id, $text);
        return $data;
    }

    public function addCancelCause($text)
    {
        $cancelcauses = new Vocabulary();
        $data = $cancelcauses->addCancelCause($text);
        return $data;
    }

    public function getCancelCauses()
    {
        $cancelcauses = new Vocabulary();
        $data = $cancelcauses->getCancelCauses();
        return $data;
    }

    public function deleteCancelCause($id)
    {
        $cancelcauses = new Vocabulary();
        $data = $cancelcauses->deleteCancelCause($id);
        return $data;
    }

    public function editCancelCause($id, $text)
    {
        $cancelcauses = new Vocabulary();
        $data = $cancelcauses->editCancelCause($id, $text);
        return $data;
    }

    public function addConservationStatus($text)
    {
        $conservationstatus = new Vocabulary();
        $data = $conservationstatus->addConservationStatus($text);
        return $data;
    }

    public function getConservationStatuses()
    {
        $conservationstatus = new Vocabulary();
        $data = $conservationstatus->getConservationStatuses();
        return $data;
    }

    public function deleteConservationStatus($id)
    {
        $conservationstatus = new Vocabulary();
        $data = $conservationstatus->deleteConservationStatus($id);
        return $data;
    }

    public function editConservationStatus($id, $text)
    {
        $conservationstatus = new Vocabulary();
        $data = $conservationstatus->editConservationStatus($id, $text);
        return $data;
    }

    public function addDatation($text, $start_date, $end_date)
    {
        $datations = new Vocabulary();
        $data = $datations->addDatation($text, $start_date, $end_date);
        return $data;
    }

    public function getDatations()
    {
        $datations = new Vocabulary();
        $data = $datations->getDatations();
        return $data;
    }

    public function deleteDatation($id)
    {
        $datations = new Vocabulary();
        $data = $datations->deleteDatation($id);
        return $data;
    }

    public function editDatation($id, $text, $start_date, $end_date)
    {
        $datations = new Vocabulary();
        $data = $datations->editDatation($id, $text, $start_date, $end_date);
        return $data;
    }

    public function addExpositionType($text)
    {
        $expositiontypes = new Vocabulary();
        $data = $expositiontypes->addExpositionType($text);
        return $data;
    }

    public function getExpositionTypes()
    {
        $expositiontypes = new Vocabulary();
        $data = $expositiontypes->getExpositionTypes();
        return $data;
    }

    public function getExpositionID($expotype)
    {
        $expositiontypes = new Vocabulary();
        $data = $expositiontypes->getExpositionID($expotype);
        return $data;
    }

    public function deleteExpositionType($id)
    {
        $expositiontypes = new Vocabulary();
        $data = $expositiontypes->deleteExpositionType($id);
        return $data;
    }

    public function editExpositionType($id, $text)
    {
        $expositiontypes = new Vocabulary();
        $data = $expositiontypes->editExpositionType($id, $text);
        return $data;
    }

    public function addAuthor($name, $authorGetty)
    {
        $authors = new Vocabulary();
        $data = $authors->addAuthor($name, $authorGetty);
        return $data;
    }

    public function getAuthors()
    {
        $authors = new Vocabulary();
        $data = $authors->getAuthors();
        return $data;
    }

    public function deleteAuthor($id) {
        $authors = new Vocabulary();
        $data = $authors->deleteAuthor($id);
        return $data;
    }

    public function editAuthor($id, $name, $authorGetty)
    {
        $authors = new Vocabulary();
        $data = $authors->editAuthor($id, $name, $authorGetty);
        return $data;
    }

    public function addGenericClassification($text)
    {
        $authors = new Vocabulary();
        $data = $authors->addGenericClassification($text);
        return $data;
    }

    public function getGenericClassifications()
    {
        $genericclassifications = new Vocabulary();
        $data = $genericclassifications->getGenericClassifications();
        return $data;
    }

    public function deleteGenericClassification($id)
    {
        $genericclassifications = new Vocabulary();
        $data = $genericclassifications->deleteGenericClassification($id);
        return $data;
    }

    public function editGenericClassification($id, $text)
    {
        $genericclassifications = new Vocabulary();
        $data = $genericclassifications->editGenericClassification($id, $text);
        return $data;
    }

    public function addMaterial($text, $material_getty)
    {
        $materials = new Vocabulary();
        $data = $materials->addMaterial($text, $material_getty);
        return $data;
    }
    

    public function getMaterials()
    {
        $materials = new Vocabulary();
        $data = $materials->getMaterials();
        return $data;
    }

    public function deleteMaterial($id)
    {
        $materials = new Vocabulary();
        $data = $materials->deleteMaterial($id);
        return $data;
    }

    public function editMaterial($id, $text, $material_getty)
    {
        $materials = new Vocabulary();
        $data = $materials->editMaterial($id, $text, $material_getty);
        return $data;
    }

    public function addTecnique($text, $tecnique_getty)
    {
        $tecniques = new Vocabulary();
        $data = $tecniques->addTecnique($text, $tecnique_getty);
        return $data;
    }


    public function getTecniques()
    {
        $tecniques = new Vocabulary();
        $data = $tecniques->getTecniques();
        return $data;
    }

    public function deleteTecnique($id)
    {
        $tecniques = new Vocabulary();
        $data = $tecniques->deleteTecnique($id);
        return $data;
    }

    public function editTecnique($id, $text, $tecnique_getty)
    {
        $tecniques = new Vocabulary();
        $data = $tecniques->editTecnique($id, $text, $tecnique_getty);
        return $data;
    }

    public function addObject($text, $object_getty)
    {
        $objects = new Vocabulary();
        $data = $objects->addObject($text, $object_getty);
        return $data;
    }

    public function getObjects()
    {
        $objects = new Vocabulary();
        $data = $objects->getObjects();
        return $data;
    }

    public function deleteObject($id)
    {
        $objects = new Vocabulary();
        $data = $objects->deleteObject($id);
        return $data;
    }

    public function editObject($id, $text, $object_getty)
    {
        $objects = new Vocabulary();
        $data = $objects->editObject($id, $text, $object_getty);
        return $data;
    }

}
?>