<aside id="searchbar">
    <button class="accordion default_active">Cerca d'obres</button>
    <div class="panel" id="filters">
        <form id="searchbarwrapper">
            <label for="artworksearch">Cercador</label>
            <input type="text" name="artworksearch" id="artworksearch"
                placeholder="Nom d'obra, autor, ubicació, estat...">
            <p>Registre</p>
                <input type="text">
            <p>Autor</p>
            <select data-placeholder="Seleccionar autor/s" multiple class="chosen-select no-transition">
                <option>Apel·les Fenosa</option>
                <option value="vincent_van_gogh">Vincent van Gogh</option>
                <option value="pablo_picasso">Pablo Picasso</option>
                <option value="leonardo_da_vinci">Leonardo da Vinci</option>
                <option value="claude_monet">Claude Monet</option>
                <option value="michelangelo">Michelangelo</option>
                <option value="rembrandt">Rembrandt</option>
                <option value="frida_kahlo">Frida Kahlo</option>
                <option value="salvador_dali">Salvador Dalí</option>
                <option value="georgia_okeeffe">Georgia O'Keeffe</option>
                <option value="gustav_klimt">Gustav Klimt</option>
                <option value="edvard_munch">Edvard Munch</option>
                <option value="henri_matisse">Henri Matisse</option>
                <option value="johannes_vermeer">Johannes Vermeer</option>
                <option value="andy_warhol">Andy Warhol</option>
                <option value="caravaggio">Caravaggio</option>
            </select>
            <p>Tecnica</p>
            <select data-placeholder="Seleccionar material/s" multiple class="chosen-select">
                <option value="oleo">Óleo</option>
                <option value="acrilico">Acrílico</option>
                <option value="carbon">Carbón</option>
                <option value="lapiz">Lápiz</option>
                <option value="acquerela">Acuarela</option>
                <option value="tinta">Tinta</option>
                <option value="madera">Madera</option>
                <option value="marmol">Mármol</option>
                <option value="bronce">Bronce</option>
                <option value="ceramica">Cerámica</option>
                <option value="papel">Papel</option>
                <option value="vidrio">Vidrio</option>
                <option value="textil">Textil</option>
                <option value="metal">Metal</option>
                <option value="fotografia">Fotografía</option>
                <option value="plastica">Plástica</option>
                <option value="digital">Digital</option>
                <option value="mixta">Técnica mixta</option>
            </select>
            <p>Material</p>
            <select data-placeholder="Seleccionar material/s" multiple class="chosen-select">
                <option value="oleo">Óleo</option>
                <option value="acrilico">Acrílico</option>
                <option value="carbon">Carbón</option>
                <option value="lapiz">Lápiz</option>
                <option value="acquerela">Acuarela</option>
                <option value="tinta">Tinta</option>
                <option value="madera">Madera</option>
                <option value="marmol">Mármol</option>
                <option value="bronce">Bronce</option>
                <option value="ceramica">Cerámica</option>
                <option value="papel">Papel</option>
                <option value="vidrio">Vidrio</option>
                <option value="textil">Textil</option>
                <option value="metal">Metal</option>
                <option value="fotografia">Fotografía</option>
                <option value="plastica">Plástica</option>
                <option value="digital">Digital</option>
                <option value="mixta">Técnica mixta</option>
            </select>
            <p>Rang de dates de creació</p>
            <input type="text" name="daterange" id="daterange" placeholder="Rang de dates de creació">

            <hr>
            <input type="checkbox" name="searchby" id="searchby" value="name"><label for="searchby"
                id="searchbylabel">Veure obras cancel·lades</label>
        </form>
    </div>

    <button class="accordion">Opcions</button>
    <div class="panel">
        <button id="new-artwork"><i class="fa-solid fa-plus"></i> Crear obra</button>
        <a href='?generatePDF=true' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar
                informe</button></a>
        <a href='?generateInvididualPDF=342' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar
                informe individual</button></a>
        <a href='?generateSimplePDF=342' target="_blank"><button><i class="fa-regular fa-file-pdf"></i>Generar informe
                simple</button></a>
    </div>
</aside>