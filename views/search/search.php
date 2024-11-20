<aside id="searchbar">
    <button class="accordion default_active">Cerca d'obres</button>
    <div class="panel">
        <form id="searchbarwrapper">
            <label for="artworksearch">Cercador</label>
            <input type="text" name="artworksearch" id="artworksearch" placeholder="Nom d'obra, autor, ubicació, estat...">
            <!-- <select data-placeholder="Choose a country..." multiple class="chosen-select">
                <option>United States</option>
                <option>United Kingdom</option>
                <option>United Arab Emirates</option>
                <option>Uruguay</option>
                <option>Uzbekistan</option>
            </select> -->
            <hr>
            <input type="checkbox" name="searchby" id="searchby" value="name"><label for="searchby" id="searchbylabel">Veure obras cancel·lades</label>
        </form>
    </div>

    <button class="accordion">Opcions</button>
    <div class="panel">
        <button id="new-artwork"><i class="fa-solid fa-plus"></i> Crear obra</button>
        <a href='?generatePDF=true' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar informe</button></a>
        <a href='?generateInvididualPDF=342' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar informe individual</button></a>
        <a href='?generateSimplePDF=342' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar informe simple</button></a>
    </div>
</aside>