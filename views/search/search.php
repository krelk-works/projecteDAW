<aside id="searchbar">
    <button class="accordion default_active">Cerca d'obres</button>
    <div class="panel" id="filters">
        <form id="searchbarwrapper">
            <label for="artworksearch">Cercador</label>
            <input type="text" name="artworksearch" id="artworksearch"
                placeholder="Nom d'obra, autor, ubicació, estat...">
            <p>Registre</p>
                <input type="text" placeholder="Nº de registre" id="register_identifier" name="register_identifier">
            <p>Autor</p>
            <select data-placeholder="Seleccionar autor/s" multiple class="chosen-select" id="authors" name="authors">
            </select>
            <p>Tecnica</p>
            <select data-placeholder="Seleccionar material/s" multiple class="chosen-select" id="tecniques" name="tecniques">
            </select>
            <p>Material</p>
            <select data-placeholder="Seleccionar material/s" multiple class="chosen-select" id="materials" name="materials">
            </select>
            <p>Rang de dates de creació</p>
            <input type="text" name="daterange" id="daterange" placeholder="Rang de dates de creació" spellcheck="false">
            <p>Estat de conservació</p>
            <select data-placeholder="Seleccionar estat/s" multiple class="chosen-select" id="conservationstatus" name="conservationstatus">
            </select>
            <button class="delete_filters">Esborrar filtres</button>
            <hr>
            <input type="checkbox" name="searchby" id="searchby" value="name"><label for="searchby"
                id="searchbylabel">Veure obres eliminades</label>
        </form>
    </div>

    <button class="accordion">Opcions</button>
    <div class="panel">
        <button id="new-artwork"><i class="fa-solid fa-plus"></i> Crear obra</button>
        <a href='?generatePDF=true' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar llibre-registre</button></a>
        <button id="generatePDFfilter"><i class="fa-regular fa-file-pdf"></i>Generar llibre-registre amb filtres</button>
        <a href='?generateInvididualPDF=342' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar informe de fitxa basica</button></a>
        <a href='?generateSimplePDF=342' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar informe de fitxa general</button></a>
    </div>
</aside>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" defer></script>