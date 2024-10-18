<?php
    $vocabularyController = new VocabularyController();

    if (isset($_GET['delete_entry'])) {
        $vocabularyController->deleteEntry($_GET['delete_entry']);
    }

    if (isset($_GET['delete_cancelcause'])) {
        $vocabularyController->deleteCancelCause($_GET['delete_cancelcause']);
    }

    if (isset($_GET['delete_conservationstatus'])) {
        $vocabularyController->deleteConservationStatus($_GET['delete_conservationstatus']);
    }

    if (isset($_GET['delete_datation'])) {
        $vocabularyController->deleteDatation($_GET['delete_datation']);
    }

    if (isset($_GET['delete_expositiontype'])) {
        $vocabularyController->deleteExpositionType($_GET['delete_expositiontype']);
    }

    if (isset($_GET['delete_author'])) {
        $vocabularyController->deleteAuthor($_GET['delete_author']);
    }

    if (isset($_GET['delete_genericclassification'])) {
        $vocabularyController->deleteAuthor($_GET['delete_genericclassification']);
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
                <div class="mixed_inputs">
                    <input type="text">
                    <input type="text">
                    <input type="text">
                    <button>+</button>
                </div>
                <div class="mixed_headers">
                    <p>Detall</p>
                    <p>Data inici</p>
                    <p>Data fi</p>
                </div>
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
            <div class="vocabulary-item-simple ">
                <h4>Autorias</h4>
                <input type="text" placeholder="Nova autoría..." id="new_author_value">
                <button id="new_author">+</button>
                <div class="list-vocabulary-item-simple">
                    <?php
                        $authors = $vocabularyController->getAuthors();

                        foreach ($authors as $author) {
                            echo '<div class="item-vocabulary">
                                <p>' . $author['name'] . '</p>
                                <button class="delete_vocabulary_button author_delete_button" value="'.$author['id'].'"><i class="fa-solid fa-trash"></i></button>
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
                <h4>Clasificació generica</h4>
                <input type="text" placeholder="Nova clasificació generica..." id="new_genericclassifications_value">
                <button id="new_genericclassifications">+</button>
                <div class="list-vocabulary-item-simple">
                    <?php
                        $genericClassifications = $vocabularyController->getGenericClassifications();

                        foreach ($genericClassifications as $genericClassification) {
                            echo '<div class="item-vocabulary">
                                <p>' . $genericClassification['text'] . '</p>
                                <button class="delete_vocabulary_button genericclassifications_delete_button" value="'.$genericClassification['id'].'"><i class="fa-solid fa-trash"></i></button>
                            </div>';
                        }
                    ?>
                </div>
            </div>
            <div class="vocabulary-item-simple ">
                <h4>Materials</h4>
                <input type="text" placeholder="Nou material..." id="new_material_value">
                <button id="new_material">+</button>
                <div class="list-vocabulary-item-simple">
                    <?php
                        $materials = $vocabularyController->getMaterials();

                        foreach ($materials as $material) {
                            echo '<div class="item-vocabulary">
                                <p>' . $material['text'] . '</p>
                                <button class="delete_vocabulary_button material_delete_button" value="'.$material['id'].'"><i class="fa-solid fa-trash"></i></button>
                            </div>';
                        }
                    ?>
                </div>
            </div>
            <div class="vocabulary-item-simple ">
                <h4>Tecnica</h4>
                <input type="text" placeholder="Nova tecnica..." id="new_tecnique_value">
                <button id="new_tecnique">+</button>
                <div class="list-vocabulary-item-simple">
                    <?php
                        $tecniques = $vocabularyController->getTecniques();

                        foreach ($tecniques as $tecnique) {
                            echo '<div class="item-vocabulary">
                                <p>' . $tecnique['text'] . '</p>
                                <button class="delete_vocabulary_button tecnique_delete_button" value="'.$tecnique['id'].'"><i class="fa-solid fa-trash"></i></button>
                            </div>';
                        }
                    ?>
                </div>
            </div>
            <div class="vocabulary-item-simple ">
                <h4>Codi Getty</h4>
                <input type="text" placeholder="Nou codi Getty..." id="new_getty_value">
                <button id="new_getty">+</button>
                <div class="list-vocabulary-item-simple">
                    <?php
                        $gettycodes = $vocabularyController->getGettys();

                        foreach ($gettycodes as $gettycode) {
                            echo '<div class="item-vocabulary">
                                <p>' . $gettycode['text'] . '</p>
                                <button class="delete_vocabulary_button getty_delete_button" value="'.$gettycode['id'].'"><i class="fa-solid fa-trash"></i></button>
                            </div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>