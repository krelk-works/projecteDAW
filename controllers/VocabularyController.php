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

    public function addDatation($text)
    {
        $datations = new Vocabulary();
        $data = $datations->addDatation($text);
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

    public function deleteExpositionType($id)
    {
        $expositiontypes = new Vocabulary();
        $data = $expositiontypes->deleteExpositionType($id);
        return $data;
    }

    public function addAuthor($name)
    {
        $authors = new Vocabulary();
        $data = $authors->addAuthor($name);
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

    public function addMaterial($text)
    {
        $materials = new Vocabulary();
        $data = $materials->addMaterial($text);
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

    public function addTecnique($text)
    {
        $tecniques = new Vocabulary();
        $data = $tecniques->addTecnique($text);
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

    public function addGetty($text)
    {
        $getty = new Vocabulary();
        $data = $getty->addGetty($text);
        return $data;
    }

    public function getGettys()
    {
        $getty = new Vocabulary();
        $data = $getty->getGettys();
        return $data;
    }

    public function deleteGetty($id)
    {
        $getty = new Vocabulary();
        $data = $getty->deleteGetty($id);
        return $data;
    }

    public function addGettyTecnique($text)
    {
        $gettytecnique = new Vocabulary();
        $data = $gettytecnique->addGettyTecnique($text);
        return $data;
    }

    public function getGettyTecniques()
    {
        $gettytecnique = new Vocabulary();
        $data = $gettytecnique->getGettyTecniques();
        return $data;
    }

    public function deleteGettyTecnique($id)
    {
        $gettytecnique = new Vocabulary();
        $data = $gettytecnique->deleteGettyTecnique($id);
        return $data;
    }
}
?>