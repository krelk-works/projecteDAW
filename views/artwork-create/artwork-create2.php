<form action="add-artwork.php" method="POST" enctype="multipart/form-data" id="add-artwork-form">
    <div id="artwork-create-container">
        <div class="artwork-create-header">
            <h1><i class="fa-regular fa-bookmark"></i> <span id="artwork-page-title">Nova obra</span></h1>
            <hr>
        </div>
        <div class="artwork-create-box">
            <div class="artwork-create-box-header">
                <h3>Imatge principal</h3>
                <hr>
            </div>
            <div class="default-image-box">
                <img src="" alt="Imatge per defecte" style="display: none" id="defaultimagepreview">
                <button id="add-default-image">Afegir imatge</button>
                <input type="file" id="defaultimage" name="defaultimage" hidden="true" accept="image/png, image/jpeg, image/jpg, image/jfif">
                <!-- <button>Cambiar fotografia</button> -->
            </div>
            <div class="artwork-create-box-header">
                <h3>Identificació</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <label for="id_number">Número de registre</label>
                    <select name="id_letter" id="id_letter" class="custom-select-1">
                        <option value="">-</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                        <option value="e">E</option>
                        <option value="f">F</option>
                        <option value="g">G</option>
                        <option value="h">H</option>
                        <option value="i">I</option>
                        <option value="j">J</option>
                        <option value="k">K</option>
                        <option value="l">L</option>
                        <option value="m">M</option>
                        <option value="n">N</option>
                        <option value="o">O</option>
                        <option value="p">P</option>
                        <option value="q">Q</option>
                        <option value="r">R</option>
                        <option value="s">S</option>
                        <option value="t">T</option>
                        <option value="u">U</option>
                        <option value="v">V</option>
                        <option value="w">W</option>
                        <option value="x">X</option>
                        <option value="y">Y</option>
                        <option value="z">Z</option>
                    </select>
                    <input class="custom-number-imput-1" type="number" name="id_number" id="id_number"
                        placeholder="Identificador" max="99999" min="1" required>
                    <input class="custom-number-imput-2" type="number" name="id_sub_number" id="id_sub_number" placeholder="Sub">
                    <input class="custom-number-imput-3" type="text" name="" id="id_other" name="id_other"
                        placeholder="Altres idenfiticadors">
                </div>
                <div class="acb-element-1-2">
                    <label class="element-1-2" for="object_name">Nom objecte</label>
                    <label class="element-1-2" for="artwork_title">Títol</label>
                    <input type="text" class="element-1-2" id="object_name" name="object_name" placeholder="Nom objecte" capitalize>
                    <input type="text" class="element-1-2" placeholder="Títol" id="artwork_title" name="artwork_title" capitalize>
                </div>
                <div class="acb-element-1-1">
                    <label for="artwork_description">Descripció</label>
                    <textarea name="artwork_description" id="artwork_description" placeholder="Descripció" capitalize></textarea>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Camps Getty</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements"> 

                <div class="acb-element-1-2">
                    <label class="element-1-2" for="object_name">Nom objecte</label>
                    <label class="element-1-2" for="gc_object_name">Getty Nom d'Objecte <a href="https://www.getty.edu/research/tools/vocabularies/aat/index.html" target="_blank"><i class="fa-regular fa-share-from-square"></i></a></label>
                    <input type="text" class="element-1-2" id="object_name" name="object_name" placeholder="Nom objecte" capitalize>
                    <input type="number" class="element-1-2" placeholder="Codi Getty" id="gc_object_name" name="gc_object_name">
                </div>
                <div class="acb-element-1-2">
                    <label class="element-1-2" for="author_names">Autor</label>
                    <label class="element-1-2" for="gc_author_name">Getty Autor <a href="https://www.getty.edu/research/tools/vocabularies/ulan/" target="_blank"><i class="fa-regular fa-share-from-square"></i></a></label>
                    <select name="author_names" id="author_names" class="element-1-2">
                        <option value="">Carregant dades...</option>
                    </select>
                    <input type="number" class="element-1-2" placeholder="Codi Getty" id="gc_author_name" name="gc_author_name">
                </div>
                <div class="acb-element-1-2">
                    <label for="materials_list" class="element-1-2">Material</label>
                    <label for="gc_tecnique" class="element-1-2">Getty Material <a href="https://www.getty.edu/research/tools/vocabularies/aat/index.html" target="_blank"><i class="fa-regular fa-share-from-square"></i></a></label>
                    <select name="materials_list" id="materials_list" class="element-1-2">
                        <option value="">Carregant dades...</option>
                    </select>
                    <input type="number" class="element-1-2" placeholder="Codi Getty" id="gc_material" name="gc_material">
                </div>
                <div class="acb-element-1-2">
                    <label for="tecniques_list" class="element-1-2">Tecnica</label>
                    <label for="gc_tecnique" class="element-1-2">Getty Tècnica <a href="https://www.getty.edu/research/tools/vocabularies/aat/index.html" target="_blank"><i class="fa-regular fa-share-from-square"></i></a></label>
                        <select name="tecniques_list" id="tecniques_list" class="element-1-2">
                        <option value="">Carregant dades...</option>
                    </select>
                    <input type="number" class="element-1-2" placeholder="Codi Getty" id="gc_tecnique" name="gc_tecnique">
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Detalls de l'obra</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <!-- <label class="element-1-2" for="author_names">Autor</label> -->
                    <label class="element-1-1" for="datations_list">Datació</label>
                    <!-- <select name="author_names" id="author_names" class="element-1-2">
                        <option value="">Carregant dades...</option>
                    </select> -->
                    <select name="datations_list" id="datations_list" class="element-1-1">
                        <option value="">Carregant dades...</option>
                    </select>
                </div>
                <div class="acb-element-1-2">
                    <!-- <label class="element-1-2" for="register_date">Data del registre</label> -->
                    <label class="element-1-1" for="created_date">Data creació</label>
                    <!-- <input type="date" class="element-1-2" placeholder="Data del registre" id="register_date" name="register_date"> -->
                    <input type="date" class="element-1-1" placeholder="Data creació" id="created_date" name="created_date">
                </div>
                <div class="acb-element-1-1">
                    <label for="artwork_bibliography">Bibliografia</label>
                    <textarea name="artwork_bibliography" id="artwork_bibliography" placeholder="Bibliografia" capitalize></textarea>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Característiques de l'obra</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <label for="artwork_height" class="element-1-3">Alçada</label>
                    <label for="artwork_width" class="element-1-3">Amplada</label>
                    <label for="artwork_depth" class="element-1-3">Fons</label>
                    <input type="number" class="element-1-3" placeholder="Alçada (cm)" id="artwork_height" name="artwork_height">
                    <input type="number" class="element-1-3" placeholder="Amplada (cm)" id="artwork_width" name="artwork_width">
                    <input type="number" class="element-1-3" placeholder="Fons (cm)" id="artwork_depth" name="artwork_depth">
                </div>
                <div class="acb-element-1-2">
                    <label for="artwork_price" class="element-1-2">Cost</label>
                    <label for="artwork_quantity" class="element-1-2">Quantitat</label>
                    <input type="number" class="element-1-2" placeholder="Cost (eur)" id="artwork_price" name="artwork_price">
                    <input type="number" class="element-1-2" placeholder="Quantitat" id="artwork_quantity" name="artwork_quantity">
                </div>
                <div class="acb-element-1-2">
                    <label for="generic_classification" class="element-1-2">Classificació genèrica</label>
                    <label for="conservations_list" class="element-1-2">Estat de conservació</label>
                    <select name="generic_classification" id="generic_classification" class="element-1-2">
                        <option value="">Carregant dades...</option>
                    </select>
                    <select name="conservations_list" id="conservations_list" class="element-1-2">
                        <option value="">Carregant dades...</option>
                    </select>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Procedencia</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <label for="origin_museum" class="element-1-2">Nom museu</label>
                    <label for="origin_collection" class="element-1-2">Col·lecció de procedència</label>
                    <input type="text" class="element-1-2" placeholder="Nom del museu d'origen" id="origin_museum" name="origin_museum" capitalize>
                    <input type="text" class="element-1-2" placeholder="Col·lecció de procedència" id="origin_collection" name="origin_collection" capitalize>
                </div>
                <div class="acb-element-1-2">
                    <label for="origin_place" class="element-1-2">Lloc d'origen</label>
                    <label for="entry_type_list" class="element-1-2">Tipus d'ingrés</label>
                    <input type="text" class="element-1-2" placeholder="Lloc d'origen" id="origin_place" name="origin_place" capitalize>
                    <select name="entry_type_list" id="entry_type_list" class="element-1-2">
                        <option value="">Carregant dades...</option>
                    </select>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Ubicació</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <label for="locations_list" class="element-1-1">Ubicació</label>
                    <select name="locations_list" id="locations_list" class="element-1-1">
                        <option value="">Carregant dades...</option>
                    </select>
                </div>
                <div class="acb-element-1-2">
                    <label for="execution_place" class="element-1-1">Lloc d'execució</label>
                    <input type="text" class="element-1-1" placeholder="Lloc d'execució" id="execution_place" name="execution_place" capitalize>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Altres dades</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <label for="tirage" class="element-1-1">Tiratge</label>
                    <input type="text" class="element-1-1" placeholder="Tiratge" id="tirage" name="tirage">
                </div>
                <div class="acb-element-1-2">
                    <label for="cancel_causes_list" class="element-1-1">Causa de cancelació</label>
                    <select name="cancel_causes_list" id="cancel_causes_list" class="element-1-1">
                        <option value="">Carregant dades...</option>
                    </select>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Documents</h3>
                <hr>
            </div>
            <div class="artwork-create-box-multimedia">
                <!-- <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div> -->
                <div class="multimedia-add-content">
                    <button type="button" id="add_documents_button"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Imagtes adicionals</h3>
                <hr>
            </div>
            <div class="artwork-create-box-multimedia">
                <!-- <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>-->
                <div class="multimedia-add-content">
                    <button type="button"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Referències</h3>
                <hr>
            </div>
            <div class="artwork-create-box-multimedia">
                <!-- <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>-->
                <div class="multimedia-add-content">
                    <button type="button"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Historia</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-1">
                    <label for="artwork_history">Historia</label>
                    <textarea name="artwork_history" id="artwork_history" placeholder="Historia" capitalize></textarea>
                </div>
            </div>
            <div id="hidden_inputs">
                <!-- <input type="file" name="document_0" id="document_0" hidden> -->
            </div>
            <div class="create-artwork-button">
                <button type="submit">Crear obra</button>
            </div>
        </div>
    </div>
</form>
<script src="assets/js/add-artwork.js" defer></script>