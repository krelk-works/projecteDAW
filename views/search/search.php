<aside id="searchbar">
    <button class="accordion default_active">Cerca d'obres</button>
    <div class="panel">
        <form id="searchbarwrapper">
            <label for="artworksearch">Cercador</label>
            <input type="text" name="artworksearch" id="artworksearch" placeholder="Nom d'obra, autor, ubicació, estat...">
            <hr style="width: 100%; margin-top: 10px; margin-bottom: 5px;">
            <input type="checkbox" name="searchby" id="searchby" value="name"><label for="searchby" id="searchbylabel">Veure obras de baixa</label>
        </form>
    </div>

    <button class="accordion">Opcions</button>
    <div class="panel">
        <button id="new-artwork"><i class="fa-solid fa-plus"></i> Crear obra</button>
        <a href='?generatePDF=true' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar informe</button></a>
        <a href='?generateInvididualPDF=195' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar informe individual</button></a>
        <a href='?generateSimplePDF=195' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar informe simple</button></a>
    </div>
</aside>