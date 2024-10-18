<?php
    $vocabularyController = new VocabularyController();

    if (isset($_GET['delete_entry'])) {
        $vocabularyController->deleteEntry($_GET['delete_entry']);
    }

    if (isset($_GET['delete_cancelcause'])) {
        $vocabularyController->deleteCancelCause($_GET['delete_cancelcause']);
    }

    if (isset($_GET['delete_conservationstatus'])) {
        $vocabularyController->deleteConservationStatus($_GET['delete_cancelcause']);
    }

    if (isset($_GET['delete_datation'])) {
        $vocabularyController->deleteDatation($_GET['delete_datation']);
    }

    if (isset($_GET['delete_expositiontype'])) {
        $vocabularyController->deleteExpositionType($_GET['delete_expositiontype']);
    }

    if (isset($_GET['add_entry'])) {
        $vocabularyController->addEntry($_GET['add_entry']);
    }

    if (isset($_GET['add_cancelcause'])) {
        $vocabularyController->addCancelCause($_GET['add_cancelcause']);
    }

    if (isset($_GET['add_conservationstatus'])) {
        $vocabularyController->addConservationStatus($_GET['add_conservationstatus']);
    }

    if (isset($_GET['add_datation'])) {
        $vocabularyController->addDatation($_GET['add_datation']);
    }

    if (isset($_GET['add_expositiontype'])) {
        $vocabularyController->addExpositionType($_GET['add_expositiontype']);
    }
?>

<div id="vocabulary-wrapper">
    <div id="vocabulary-container">
        <div id="vocabulary-header">
            <h2>Gestío de vocabularis</h2>
            <hr>
        </div>
        <div id="vocabulary-items">
            <div class="vocabulary-item-simple ">
                <h4>Forma d'ingrés</h4>
                <input type="text" placeholder="Nova forma d'ingrés..." id="new_entry_type_value">
                <button id="new_entry_type">+</button>
                <div class="list-vocabulary-item-simple">
                    <?php



                    $entryTypes = $vocabularyController->getEntry();

                    foreach ($entryTypes as $entry) {
                        echo '<div class="item-vocabulary">
                            <p>' . $entry['text'] . '</p>
                            <button class="delete_vocabulary_button entry_delete_button" value="'.$entry['id'].'"><i class="fa-solid fa-trash"></i></button>
                        </div>';
                    }

                    ?>
                    <!--<div class="item-vocabulary">
                        <p>Opcio 1</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 2</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 3</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 4</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 5</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>-->
                </div>
            </div>

            <div class="vocabulary-item-simple ">
                <h4>Causa de baixa</h4>
                <input type="text" placeholder="Nova causa de baixa..." id="new_cancelcause_value">
                <button id="new_cancelcause">+</button>
                <div class="list-vocabulary-item-simple">

                    <?php
                    $cancelCauses = $vocabularyController->getCancelCauses();

                    foreach ($cancelCauses as $cancelcause) {
                        echo '<div class="item-vocabulary">
                            <p>' . $cancelcause['text'] . '</p>
                            <button class="delete_vocabulary_button cancelcause_delete_button" value="'.$cancelcause['id'].'"><i class="fa-solid fa-trash"></i></button>
                        </div>';
                    }
                    ?>
                    <!--<div class="item-vocabulary">
                        <p>Opcio 1</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 2</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 3</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 4</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 5</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 6</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 7</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>-->
                </div>
            </div>

            <div class="vocabulary-item-simple ">
                <h4>Estat de conservació</h4>
                <input type="text" placeholder="Nou estat de conservació..." id="new_conservationstatus_value">
                <button id="new_conservationstatus">+</button>
                <div class="list-vocabulary-item-simple">
                <?php
                    $conversvationStatuses = $vocabularyController->getConservationStatuses();

                    foreach ($conversvationStatuses as $conservationStatus) {
                        echo '<div class="item-vocabulary">
                            <p>' . $conservationStatus['text'] . '</p>
                            <button class="delete_vocabulary_button conservationstatus_delete_button" value="'.$conservationStatus['id'].'"><i class="fa-solid fa-trash"></i></button>
                        </div>';
                    }
                    ?>
                    <!--<div class="item-vocabulary">
                        <p>Opcio 1</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 2</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 3</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 4</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 5</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>-->
                </div>
            </div>
            
            <div class="vocabulary-item-composed ">
                <h4>Datació</h4>
            </div>
            <div class="vocabulary-item-simple ">
                <h4>Tipus d'exposició</h4>
                <input type="text" placeholder="Nou tipus d'exposició..." id="new_expositiontype_value">
                <button id="new_expositiontype">+</button>
                <div class="list-vocabulary-item-simple">
                    <?php
                        $expositionTypes = $vocabularyController->getExpositionTypes();

                        foreach ($expositionTypes as $expositionType) {
                            echo '<div class="item-vocabulary">
                                <p>' . $expositionType['text'] . '</p>
                                <button class="delete_vocabulary_button expositiontypes_delete_button" value="'.$expositionType['id'].'"><i class="fa-solid fa-trash"></i></button>
                            </div>';
                        }
                    ?>
                    <!--<div class="item-vocabulary">
                        <p>Opcio 1</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 2</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 3</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 4</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 5</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 6</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-vocabulary">
                        <p>Opcio 7</p>
                        <button class="delete_vocabulary_button"><i class="fa-solid fa-trash"></i></button>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>