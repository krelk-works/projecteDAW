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
}
?>