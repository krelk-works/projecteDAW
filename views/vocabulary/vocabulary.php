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
        $vocabularyController->deleteGenericClassification($_GET['delete_genericclassification']);
    }

    if (isset($_GET['delete_material'])) {
        $vocabularyController->deleteMaterial($_GET['delete_material']);
    }

    if (isset($_GET['delete_tecnique'])) {
        $vocabularyController->deleteTecnique($_GET['delete_tecnique']);
    }

    if (isset($_GET['delete_getty'])) {
        $vocabularyController->deleteGetty($_GET['delete_getty']);
    }

    if (isset($_GET['delete_object'])) {
        $vocabularyController->deleteObject($_GET['delete_object']);
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

    if (isset($_GET['add_datation']) && isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $vocabularyController->addDatation($_GET['add_datation'], $_GET['start_date'], $_GET['end_date']);
    }

    if (isset($_GET['add_expositiontype'])) {
        $vocabularyController->addExpositionType($_GET['add_expositiontype']);
    }

    if (isset($_GET['add_author']) && isset($_GET['add_author_getty'])) {
        $vocabularyController->addAuthor($_GET['add_author' ], $_GET['add_author_getty']);
    }

    if (isset($_GET['add_genericclassification'])) {
        $vocabularyController->addGenericClassification($_GET['add_genericclassification']);
    }

    if (isset($_GET['add_material']) && isset($_GET['add_material_getty'])) {
        $vocabularyController->addMaterial($_GET['add_material'], $_GET['add_material_getty']);
    }    
    

    if (isset($_GET['add_tecnique']) && isset($_GET['add_tecnique_getty'])) {
        $vocabularyController->addTecnique($_GET['add_tecnique'], $_GET['add_tecnique_getty']);
    }

    if (isset($_GET['add_object']) && isset($_GET['add_object_getty'])) {
        $vocabularyController->addObject($_GET['add_object'], $_GET['add_object_getty']);
    }



    if (isset($_GET['edit_entry']) && isset($_GET['edit_entry_text'])) {
        $id = intval($_GET['edit_entry']);
        $text = trim($_GET['edit_entry_text']);
    
        if (!empty($id) && !empty($text)) {
            $result = $vocabularyController->editEntry($id, $text);
        } 
    }
    
    if (isset($_GET['edit_cancelcause']) && isset($_GET['edit_cancelcause_text'])) {
        $id = intval($_GET['edit_cancelcause']);
        $text = trim($_GET['edit_cancelcause_text']);
    
        if (!empty($id) && !empty($text)) {
            $result = $vocabularyController->editCancelCause($id, $text);
        } 
    }

    if (isset($_GET['edit_conservationstatus']) && isset($_GET['edit_conservationstatus_text'])) {
        $id = intval($_GET['edit_conservationstatus']);
        $text = trim($_GET['edit_conservationstatus_text']);
    
        if (!empty($id) && !empty($text)) {
            $result = $vocabularyController->editConservationStatus($id, $text);
        } 
    }

    if (isset($_GET['edit_datation']) && isset($_GET['edit_datation_text']) && isset($_GET['edit_datation_start_date']) && isset($_GET['edit_datation_end_date'])) {
        $id = intval($_GET['edit_datation']);
        $text = trim($_GET['edit_datation_text']);
        $start_date = trim($_GET['edit_datation_start_date']);
        $end_date = trim($_GET['edit_datation_end_date']);
    
        if (!empty($id) && !empty($text) && !empty($start_date) && !empty($end_date)) {
            $result = $vocabularyController->editDatation($id, $text, $start_date, $end_date);
        } 
    }

    if (isset($_GET['edit_expositiontype']) && isset($_GET['edit_expositiontype_text'])) {
        $id = intval($_GET['edit_expositiontype']);
        $text = trim($_GET['edit_expositiontype_text']);
    
        if (!empty($id) && !empty($text)) {
            $result = $vocabularyController->editExpositionType($id, $text);
        } 
    }

    if (isset($_GET['edit_author']) && isset($_GET['edit_author_text']) && isset($_GET['edit_author_getty'])) {
        $id = intval($_GET['edit_author']);
        $text = trim($_GET['edit_author_text']);
        $getty = trim($_GET['edit_author_getty']);
    
        if (!empty($id) && !empty($text)) {
            $result = $vocabularyController->editAuthor($id, $text, $getty);
        } 
    }

    if (isset($_GET['edit_genericclassification']) && isset($_GET['edit_genericclassification_text'])) {
        $id = intval($_GET['edit_genericclassification']);
        $text = trim($_GET['edit_genericclassification_text']);
    
        if (!empty($id) && !empty($text)) {
            $result = $vocabularyController->editGenericClassification($id, $text);
        } 
    }

    if (isset($_GET['edit_material']) && isset($_GET['edit_material_text']) && isset($_GET['edit_material_getty'])) {
        $id = intval($_GET['edit_material']);
        $text = trim($_GET['edit_material_text']);
        $getty = trim($_GET['edit_material_getty']);
    
        if (!empty($id) && !empty($text)) {
            $result = $vocabularyController->editMaterial($id, $text, $getty);
        } 
    }

    if (isset($_GET['edit_tecnique']) && isset($_GET['edit_tecnique_text']) && isset($_GET['edit_tecnique_getty'])) {
        $id = intval($_GET['edit_tecnique']);
        $text = trim($_GET['edit_tecnique_text']);
        $getty = trim($_GET['edit_tecnique_getty']);
    
        if (!empty($id) && !empty($text)) {
            $result = $vocabularyController->editTecnique($id, $text, $getty);
        } 
    }

    if (isset($_GET['edit_object']) && isset($_GET['edit_object_text']) && isset($_GET['edit_object_getty'])) {
        $id = intval($_GET['edit_object']);
        $text = trim($_GET['edit_object_text']);
        $getty = trim($_GET['edit_object_getty']);
    
        if (!empty($id) && !empty($text)) {
            $result = $vocabularyController->editObject($id, $text, $getty);
        } 
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
                <input type="text" placeholder="Nova forma d'ingrés..." id="new_entry_type_value" maxlength="30" capitalize>
                <button id="new_entry_type">+</button>
                <div class="list-vocabulary-item-simple">
                    <?php
                    $entryTypes = $vocabularyController->getEntry();

                    foreach ($entryTypes as $entry) {
                        if ($entry['id'] != "0"){
                            echo '<div class="item-vocabulary">
                            <p>' . $entry['text'] . '</p>
                            <button class="edit_vocabulary_button entry_edit_button" value="'.$entry['id'].'"><i class="fa-solid fa-edit"></i></button>
                            <button class="delete_vocabulary_button entry_delete_button" value="'.$entry['id'].'"><i class="fa-solid fa-trash"></i></button>
                            </div>';
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="vocabulary-item-simple ">
                <h4>Causa de baixa</h4>
                <input type="text" placeholder="Nova causa de baixa..." id="new_cancelcause_value" maxlength="30" capitalize>
                <button id="new_cancelcause">+</button>
                <div class="list-vocabulary-item-simple">

                    <?php
                    $cancelCauses = $vocabularyController->getCancelCauses();

                    foreach ($cancelCauses as $cancelcause) {
                        if ($cancelcause['id'] != "0"){
                            echo '<div class="item-vocabulary">
                                <p>' . $cancelcause['text'] . '</p>
                                <button class="edit_vocabulary_button cancelcause_edit_button" value="'.$cancelcause['id'].'"><i class="fa-solid fa-edit"></i></button>
                                <button class="delete_vocabulary_button cancelcause_delete_button" value="'.$cancelcause['id'].'"><i class="fa-solid fa-trash"></i></button>
                            </div>';
                        }
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
                <input type="text" placeholder="Nou estat de conservació..." id="new_conservationstatus_value" maxlength="30" capitalize>
                <button id="new_conservationstatus">+</button>
                <div class="list-vocabulary-item-simple">
                <?php
                    $conversvationStatuses = $vocabularyController->getConservationStatuses();
                    
                    foreach ($conversvationStatuses as $conservationStatus) {
                        if ($conservationStatus['id'] != "0"){
                            echo '<div class="item-vocabulary">
                                <p>' . $conservationStatus['text'] . '</p>
                                <button class="edit_vocabulary_button conservationstatus_edit_button" value="'.$conservationStatus['id'].'"><i class="fa-solid fa-edit"></i></button>
                                <button class="delete_vocabulary_button conservationstatus_delete_button" value="'.$conservationStatus['id'].'"><i class="fa-solid fa-trash"></i></button>
                            </div>';
                        }
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
            <input type="text" id="new_datation_value" capitalize>
            <input type="text" id="new_datation_value1">
            <input type="text" id="new_datation_value2">
            <button id="new_datation">+</button>
        </div>
        <div class="mixed_headers">
            <p>Datacio</p>
            <p>Data inici</p>
            <p>Data fi</p>
        </div>
        <div class="list-vocabulary-item-composed">
            <?php
                $datations = $vocabularyController->getDatations();

                foreach ($datations as $datation) {
                    if ($datation['id'] != "0"){
                        echo '<div class="item-vocabulary">
                            <p>' . $datation['text'] . '</p>
                            <p>' . $datation['start_date'] . '</p>
                            <p>' . $datation['end_date'] . '</p>
                            <button class="edit_vocabulary_button datation_edit_button" value="'.$datation['id'].'"><i class="fa-solid fa-edit"></i></button>
                            <button class="delete_vocabulary_button datation_delete_button" value="'.$datation['id'].'"><i class="fa-solid fa-trash"></i></button>
                        </div>';
                    }
                }
            ?>
        </div>
    </div>
            <div class="vocabulary-item-simple ">
                <h4>Tipus d'exposició</h4>
                <input type="text" placeholder="Nou tipus d'exposició..." id="new_expositiontype_value" maxlength="30" capitalize>
                <button id="new_expositiontype">+</button>
                <div class="list-vocabulary-item-simple">
                    <?php
                        $expositionTypes = $vocabularyController->getExpositionTypes();

                        foreach ($expositionTypes as $expositionType) {
                            if ($expositionType['id'] != "0"){
                                echo '<div class="item-vocabulary">
                                    <p>' . $expositionType['text'] . '</p>
                                    <button class="edit_vocabulary_button expositiontypes_edit_button" value="'.$expositionType['id'].'"><i class="fa-solid fa-edit"></i></button>
                                    <button class="delete_vocabulary_button expositiontypes_delete_button" value="'.$expositionType['id'].'"><i class="fa-solid fa-trash"></i></button>
                                </div>';
                            }
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
            <div class="vocabulary-item-double">
                <h4>Autories</h4>
                <div class="mixed_inputs_double">
                    <input type="text" placeholder="Nova autoría..." id="new_author_value" maxlength="30" capitalize>
                    <input type="text" placeholder="Nou codi Getty..." id="new_author_getty" maxlength="30" capitalize>
                    <button id="new_author">+</button>
                 </div>
                <div class="list-vocabulary-item-double">
                    <?php
                        $authors = $vocabularyController->getAuthors();

                        foreach ($authors as $author) {
                            if ($author['id'] != "0"){
                                echo '<div class="item-vocabulary">
                                    <p>' . $author['name'] . '</p>
                                    <p>' . $author['getty'] . '</p>
                                    <button class="edit_vocabulary_button author_edit_button" value="'.$author['id'].'"><i class="fa-solid fa-edit"></i></button>
                                    <button class="delete_vocabulary_button author_delete_button" value="'.$author['id'].'"><i class="fa-solid fa-trash"></i></button>
                                </div>';
                            }
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
                <div class="vocabulary-item-double">
                    <h4>Materials</h4>
                    <div class="mixed_inputs_double">
                        <input type="text" id="new_material_value" placeholder="Nou material...">
                        <input type="text" id="new_material_getty" placeholder="Nou codi Getty...">
                        <button id="new_material">+</button>
                    </div>
                    <div class="list-vocabulary-item-double">
                        <?php
                            $materials = $vocabularyController->getMaterials();

                            foreach ($materials as $material) {
                                if ($material['id'] != "0"){
                                    echo '<div class="item-vocabulary">
                                        <p>' . $material['text'] . '</p>
                                        <p>' . $material['getty'] . '</p>
                                        <button class="edit_vocabulary_button material_edit_button" value="' . $material['id'] . '"><i class="fa-solid fa-edit"></i></button>
                                        <button class="delete_vocabulary_button material_delete_button" value="' . $material['id'] . '"><i class="fa-solid fa-trash"></i></button>
                                    </div>';
                                }
                            }
                        ?>
                    </div>
                </div>

            <div class="vocabulary-item-double ">
                <h4>Tecnica</h4>
                <div class="mixed_inputs_double">
                    <input type="text" placeholder="Nova tecnica..." id="new_tecnique_value" maxlength="30">
                    <input type="text" placeholder="Nou codi Getty..." id="new_tecnique_getty" maxlength="30">
                    <button id="new_tecnique">+</button>
                </div>
                <div class="list-vocabulary-item-double">
                    <?php
                        $tecniques = $vocabularyController->getTecniques();

                        foreach ($tecniques as $tecnique) {
                            if ($tecnique['id'] != "0"){
                                echo '<div class="item-vocabulary">
                                    <p>' . $tecnique['text'] . '</p>
                                    <p>' . $tecnique['getty'] . '</p>
                                    <button class="edit_vocabulary_button tecnique_edit_button" value="'.$tecnique['id'].'"><i class="fa-solid fa-edit"></i></button>
                                    <button class="delete_vocabulary_button tecnique_delete_button" value="'.$tecnique['id'].'"><i class="fa-solid fa-trash"></i></button>
                                </div>';
                            }
                        }
                    ?>
                </div>
            </div>

            <div class="vocabulary-item-double ">
                <h4>Objecte</h4>
                <div class="mixed_inputs_double">
                    <input type="text" placeholder="Nou objecte..." id="new_object_value" maxlength="30">
                    <input type="text" placeholder="Nou codi Getty..." id="new_object_getty" maxlength="30">
                    <button id="new_object">+</button>
                </div>
                <div class="list-vocabulary-item-double">
                    <?php
                        $objects = $vocabularyController->getObjects();

                        foreach ($objects as $object) {
                            if ($object['id'] != "0"){
                                echo '<div class="item-vocabulary">
                                    <p>' . $object['text'] . '</p>
                                    <p>' . $object['getty'] . '</p>
                                    <button class="edit_vocabulary_button object_edit_button" value="'.$object['id'].'"><i class="fa-solid fa-edit"></i></button>
                                    <button class="delete_vocabulary_button object_delete_button" value="'.$object['id'].'"><i class="fa-solid fa-trash"></i></button>
                                </div>';
                            }
                        }
                    ?>
                </div>
            </div>

            <div class="vocabulary-item-simple ">
                <h4>Clasificació generica</h4>
                <input type="text" placeholder="Nova clasificació generica..." id="new_genericclassifications_value" maxlength="30" capitalize>
                <button id="new_genericclassifications">+</button>
                <div class="list-vocabulary-item-simple">
                    <?php
                        $genericClassifications = $vocabularyController->getGenericClassifications();

                        foreach ($genericClassifications as $genericClassification) {
                            if ($genericClassification['id'] != "0"){
                                echo '<div class="item-vocabulary">
                                    <p>' . $genericClassification['text'] . '</p>
                                    <button class="edit_vocabulary_button genericclassifications_edit_button" value="'.$genericClassification['id'].'"><i class="fa-solid fa-edit"></i></button>
                                    <button class="delete_vocabulary_button genericclassifications_delete_button" value="'.$genericClassification['id'].'"><i class="fa-solid fa-trash"></i></button>
                                </div>';
                            }
                        }
                    ?>
                </div>
            </div>
            <!-- <div class="vocabulary-item-simple ">
                <h4>Codi Getty</h4>
                <input type="text" placeholder="Nou codi Getty..." id="new_getty_value" maxlength="30">
                <button id="new_getty">+</button>
                <div class="list-vocabulary-item-simple">
                    <?php
                        // $gettycodes = $vocabularyController->getGettys();

                        // foreach ($gettycodes as $gettycode) {
                        //     echo '<div class="item-vocabulary">
                        //         <p>' . $gettycode['code'] . '</p>
                        //         <button class="edit_vocabulary_button getty_edit_button" value="'.$gettycode['id'].'"><i class="fa-solid fa-edit"></i></button>
                        //         <button class="delete_vocabulary_button getty_delete_button" value="'.$gettycode['id'].'"><i class="fa-solid fa-trash"></i></button>
                        //     </div>';
                        // }
                    ?>
                </div>
            </div> -->
        </div>
    </div>
</div>
<script src="assets/js/vocabulary.js" defer></script>