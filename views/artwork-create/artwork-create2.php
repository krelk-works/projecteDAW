<form action="">
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
                <input type="file" id="defaultimage" hidden="true" accept="image/png, image/jpeg, image/jpg">
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
                    <input class="custom-number-imput-1" type="number" name="" id="id_number"
                        placeholder="Identificador" max="99999" min="10000">
                    <input class="custom-number-imput-2" type="number" name="" id="id_sub_number" placeholder="Sub">
                    <input class="custom-number-imput-3" type="text" name="" id="id_other"
                        placeholder="Altres idenfiticadors">
                </div>
                <div class="acb-element-1-2">
                    <label class="element-1-2" for="object_name">Nom objecte</label>
                    <label class="element-1-2" for="artwork_title">Títol</label>
                    <input type="text" class="element-1-2" id="object_name" placeholder="Nom objecte">
                    <input type="text" class="element-1-2" placeholder="Títol" id="artwork_title">
                </div>
                <div class="acb-element-1-1">
                    <label for="artwork_description">Descripció</label>
                    <textarea name="artwork_description" id="artwork_description" placeholder="Descripció"></textarea>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Detalls de l'obra</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <label class="element-1-2" for="author_names">Autor</label>
                    <label class="element-1-2" for="datations_list">Datació</label>
                    <select name="author_names" id="author_names" class="element-1-2">
                        <option value="">Carregant dades...</option>
                    </select>
                    <select name="datations_list" id="datations_list" class="element-1-2">
                        <option value="">Carregant dades...</option>
                    </select>
                </div>
                <div class="acb-element-1-2">
                    <label class="element-1-2" for="register_date">Data del registre</label>
                    <label class="element-1-2" for="created_date">Data creació</label>
                    <input type="date" class="element-1-2" placeholder="Data del registre" id="register_date" name="register_date">
                    <input type="date" class="element-1-2" placeholder="Data creació" id="created_date" name="created_date">
                </div>
                <div class="acb-element-1-1">
                    <label for="artwork_bibliography">Bibliografia</label>
                    <textarea name="artwork_bibliography" id="artwork_bibliography" placeholder="Bibliografia"></textarea>
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
                    <label for="artwork_price" class="element-1-3">Cost</label>
                    <label for="artwork_quantity" class="element-1-3">Quantitat</label>
                    <label for="materials_list" class="element-1-3">Material</label>
                    <input type="number" class="element-1-3" placeholder="Cost (eur)" id="artwork_price" name="artwork_price">
                    <input type="number" class="element-1-3" placeholder="Quantitat" id="artwork_quantity" name="artwork_quantity">
                    <select name="materials_list" id="materials_list" class="element-1-3">
                        <option value="">Carregant dades...</option>
                    </select>
                </div>
                <div class="acb-element-1-2">
                    <label for="generic_classification" class="element-1-3">Classificació genèrica</label>
                    <label for="tecniques_list" class="element-1-3">Tecnica</label>
                    <label for="conservations_list" class="element-1-3">Estat de conservació</label>
                    <select name="generic_classification" id="generic_classification" class="element-1-3">
                        <option value="">Carregant dades...</option>
                    </select>
                    <select name="tecniques_list" id="tecniques_list" class="element-1-3">
                        <option value="">Carregant dades...</option>
                    </select>
                    <select name="conservations_list" id="conservations_list" class="element-1-3">
                        <option value="">Carregant dades...</option>
                    </select>
                </div>
                <div class="acb-element-1-2">
                    <label for="getty_material_codes_list" class="element-1-2">Codi de material (Getty)</label>
                    <label for="getty_material_list" class="element-1-2">Material (Getty)</label>
                    <select name="getty_material_codes_list" id="getty_material_codes_list" name="getty_material_codes_list" class="element-1-2">
                        <option value="">Carregant dades...</option>
                    </select>
                    <select name="getty_material_list" id="getty_material_list" name="getty_material_list" class="element-1-2">
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
                    <input type="text" class="element-1-2" placeholder="Nom del museu d'origen" id="origin_museum" name="origin_museum">
                    <input type="text" class="element-1-2" placeholder="Col·lecció de procedència" id="origin_collection" name="origin_collection">
                </div>
                <div class="acb-element-1-2">
                    <label for="origin_place" class="element-1-2">Lloc d'origen</label>
                    <label for="entry_type_list" class="element-1-2">Tipus d'ingrés</label>
                    <input type="text" class="element-1-2" placeholder="Lloc d'origen" id="origin_place" name="origin_place">
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
                    <input type="text" class="element-1-1" placeholder="Lloc d'execució" id="execution_place" name="execution_place">
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
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div> -->
                <div class="multimedia-add-content">
                    <button type="button"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Imagtes adicionals</h3>
                <hr>
            </div>
            <div class="artwork-create-box-multimedia">
                <!-- <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div> -->
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
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div> -->
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
                    <textarea name="artwork_history" id="artwork_history" placeholder="Historia"></textarea>
                </div>
            </div>
            <div class="create-artwork-button">
                <button type="submit">Crear obra</button>
            </div>
        </div>
    </div>
</form>
<script src="assets/js/add-artwork.js" defer></script>