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
                    <label>Número de registre</label>
                    <select name="" id="id_letter" class="custom-select-1">
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
                    <label class="element-1-2">Nom objecte</label>
                    <label class="element-1-2">Títol</label>
                    <input type="text" class="element-1-2" placeholder="Nom objecte">
                    <input type="text" class="element-1-2" placeholder="Títol" id="artwork_title">
                </div>
                <div class="acb-element-1-1">
                    <label>Descripció</label>
                    <textarea name="" id="" cols="30" rows="10" placeholder="Descripció"></textarea>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Detalls de l'obra</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <label class="element-1-2">Autor</label>
                    <label class="element-1-2">Datació</label>
                    <select name="" id="" class="element-1-2">
                        <option value="">Sense especificar</option>
                    </select>
                    <select name="" id="" class="element-1-2">
                        <option value="">Sense especificar</option>
                    </select>
                </div>
                <div class="acb-element-1-2">
                    <label class="element-1-2">Data del registre</label>
                    <label class="element-1-2">Data creació</label>
                    <input type="date" class="element-1-2" placeholder="Data del registre">
                    <input type="date" class="element-1-2" placeholder="Data creació">
                </div>
                <div class="acb-element-1-1">
                    <label>Bibliografia</label>
                    <textarea name="" id="" cols="30" rows="10" placeholder="Bibliografia"></textarea>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Característiques de l'obra</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <label for="" class="element-1-3">Alçada</label>
                    <label for="" class="element-1-3">Amplada</label>
                    <label for="" class="element-1-3">Fons</label>
                    <input type="number" class="element-1-3" placeholder="Alçada (cm)">
                    <input type="number" class="element-1-3" placeholder="Amplada (cm)">
                    <input type="number" class="element-1-3" placeholder="Fons (cm)">
                </div>
                <div class="acb-element-1-2">
                    <label for="" class="element-1-3">Cost</label>
                    <label for="" class="element-1-3">Quantitat</label>
                    <label for="" class="element-1-3">Material</label>
                    <input type="number" class="element-1-3" placeholder="Cost (eur)">
                    <input type="number" class="element-1-3" placeholder="Quantitat">
                    <select name="" id="" class="element-1-3">
                        <option value="">Sense especificar</option>
                    </select>
                </div>
                <div class="acb-element-1-2">
                    <label for="" class="element-1-3">Classificació genèrica</label>
                    <label for="" class="element-1-3">Tecnica</label>
                    <label for="" class="element-1-3">Estat de conservació</label>
                    <select name="" id="" class="element-1-3">
                        <option value="">Sense especificar</option>
                    </select>
                    <select name="" id="" class="element-1-3">
                        <option value="">Sense especificar</option>
                    </select>
                    <select name="" id="" class="element-1-3">
                        <option value="">Sense especificar</option>
                    </select>
                </div>
                <div class="acb-element-1-2">
                    <label for="" class="element-1-2">Codi de material (Getty)</label>
                    <label for="" class="element-1-2">Material (Getty)</label>
                    <select name="" id="" class="element-1-2">
                        <option value="">Sense especificar</option>
                    </select>
                    <select name="" id="" class="element-1-2">
                        <option value="">Sense especificar</option>
                    </select>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Procedencia</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <label for="" class="element-1-2">Nom museu</label>
                    <label for="" class="element-1-2">Col·lecció de procedència</label>
                    <input type="text" class="element-1-2" placeholder="Nom del museu d'origen">
                    <input type="text" class="element-1-2" placeholder="Col·lecció de procedència">
                </div>
                <div class="acb-element-1-2">
                    <label for="" class="element-1-2">Lloc d'origen</label>
                    <label for="" class="element-1-2">Tipus d'ingrés</label>
                    <input type="text" class="element-1-2" placeholder="Lloc d'origen">
                    <select name="" id="" class="element-1-2">
                        <option value="">Sense especificar</option>
                    </select>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Ubicació</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <label for="" class="element-1-1">Ubicació</label>
                    <select name="" id="" class="element-1-1">
                        <option value="">Sense especificar</option>
                    </select>
                </div>
                <div class="acb-element-1-2">
                    <label for="" class="element-1-1">Lloc d'execució</label>
                    <input type="text" class="element-1-1" placeholder="Lloc d'execució">
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Altres dades</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-2">
                    <label for="" class="element-1-1">Tiratge</label>
                    <input type="text" class="element-1-1" placeholder="Tiratge">
                </div>
                <div class="acb-element-1-2">
                    <label for="" class="element-1-1">Causa de cancelació</label>
                    <select name="" id="" class="element-1-1">
                        <option value="">Sense especificar</option>
                    </select>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Documents</h3>
                <hr>
            </div>
            <div class="artwork-create-box-multimedia">
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
                </div>
                <div class="multimedia-content">
                    <img src="assets/img/defaultimageexample.png" alt="">
                </div>
                <div class="multimedia-add-content">
                    <button><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <div class="artwork-create-box-header">
                <h3>Historia</h3>
                <hr>
            </div>
            <div class="artwork-create-box-elements">
                <div class="acb-element-1-1">
                    <label>Historia</label>
                    <textarea name="" id="" cols="30" rows="10" placeholder="Historia"></textarea>
                </div>
            </div>
            <div class="create-artwork-button">
                <button type="submit">Crear obra</button>
            </div>
        </div>
    </div>
</form>
<script src="assets/js/add-artwork.js"></script>