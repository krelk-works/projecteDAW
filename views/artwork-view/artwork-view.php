<div id="artwork-view-container">
    <div id="artwork-view-header">
        <h3 id="artwork-title">Carregant dades...</h3>
    </div>
    <div id="artwork-view-body">
        <div class="artwork-view-subheader">
            <h4>Identificació</h4>
        </div>
        <div class="artwork-view-details">
            <p><span class="bold">Numero de registre:&nbsp;</span><span id="artwork-identifier">Carregant...</span></p>
            <!-- <p><span class="bold">Nom de l'objecte:&nbsp;</span><span id="artwork-object-name">Carregant...</span></p> -->
            <p><span class="bold">Descripció:&nbsp;</span><span id="artwork-description">Carregant...</span></p>
        </div>
        <div class="artwork-view-subheader">
            <h4>Detalls</h4>
        </div>
        <div class="artwork-view-details">
            <p class="half"><span class="bold">Autor:&nbsp;</span><span id="artwork-author">Carregant...</span></p>
            <p class="half"><span class="bold">Datació:&nbsp;</span><span id="artwork-datation">Carregant...</span></p>
            <p class="half"><span class="bold">Data registre:&nbsp;</span><span id="artwork-register-date">Carregant...</span></p>
            <p class="half"><span class="bold">Data creació:&nbsp;</span><span id="artwork-creation-date">Carregant...</span></p>
            <p><span class="bold">Bibliografia:&nbsp;</span><span id="artwork-bibliography">Carregant...</span></p>
        </div>
        <div class="artwork-view-subheader">
            <h4>Caracteristiques</h4>
        </div>
        <div class="artwork-view-details">
            <p class="half"><span class="bold">Material:&nbsp;</span><span id="artwork-material">Carregant...</span></p>
            <p class="half"><span class="bold">Tècnica:&nbsp;</span><span id="artwork-tecnique">Carregant...</span></p>
            <p class="half"><span class="bold">Classificació generica:&nbsp;</span><span id="artwork-generic-classification">Carregant...</span></p>
            <!-- <p class="half"><span class="bold">Codi material *Getty:&nbsp;</span><span id="artwork-code-material-getty">Carregant...</span></p> -->
            <p class="half"><span class="bold">Cost:&nbsp;</span><span id="artwork-price">Carregant...</span></p>
            <p class="half"><span class="bold">Quantitat:&nbsp;</span><span id="artwork-amount">Carregant...</span></p>
            <p class="half"><span class="bold">Mides:&nbsp;</span><span id="artwork-dimensions">Carregant...</span></p>
            <p class="half"><span class="bold">Conservació:&nbsp;</span><span id="artwork-conservation">Carregant...</span></p>
        </div>
        <div class="artwork-view-subheader">
            <h4>Procedencia</h4>
        </div>
        <div class="artwork-view-details">
            <p class="half"><span class="bold">Nom museu:&nbsp;</span><span id="artwork-museum-name">Carregant...</span></p>
            <p class="half"><span class="bold">Lloc d'origen:&nbsp;</span><span id="artwork-provenance-place">Carregant...</span></p>
            <p class="half"><span class="bold">Col·lecció de procedencia:&nbsp;</span><span id="artwork-provenance-collection">Carregant...</span></p>
            <p class="half"><span class="bold">Tipus d'ingrés:&nbsp;</span><span id="artwork-entry-type">Carregant...</span></p>
        </div>
        <div class="artwork-view-subheader">
            <h4>Ubicació</h4>
        </div>
        <div class="artwork-view-details">
            <p class="half"><span class="bold">Ubicació:&nbsp;</span><span id="artwork-location-name">Carregant...</span></p>
            <p class="half"><span class="bold">Lloc d'execució:&nbsp;</span><span id="artwork-execution-place">Carregant...</span></p>
        </div>
        <div class="artwork-view-subheader">
            <h4>Imatges</h4>
        </div>
        <div class="artwork-view-images">
            <!-- <div class="artwork-view-image">
                <img src="assets/img/defaultimageexample.png" alt="Imatge de l'obra de arte">
            </div> -->
        </div>
        <div class="artwork-view-subheader">
            <h4>Altres detalls</h4>
        </div>
        <div class="artwork-view-details">
            <p class="half"><span class="bold">Tiratge:&nbsp;</span><span id="artwork-tirage">Carregant...</span></p>
        </div>
        <div class="artwork-view-subheader">
            <h4>Gestió</h4>
        </div>
        <div class="artwork-view-details" style="gap: 20px;">
            <button id="movement_create">Crear moviment</button>
            <button id="edit_artwork">Editar obra</button>
            <a href="?generateDOCX=<?php echo $_GET['id']; ?>" target="_blank"><button>Descarregar formulari de prestec</button></a>
            <a href="?generateIndividualPDF=<?php echo $_GET['id']; ?>" target="_blank"><button>Generar informe de fitxa basica</button></a>
            <a href="?generateSimplePDF=<?php echo $_GET['id']; ?>" target="_blank"><button>Generar informe de fitxa general</button></a>
            <!--<a href="index.php?page=artwork-view&id=<?#php echo $_GET['id']; ?>&cancelArtwork=true" target="_blank"><button>Desactivar obra</button></a>-->
            <a href="#" id="cancelArtworkLink"><button>Desactivar obra</button></a>
        </div>
    </div>
    <div>
        <?php
        if ($_GET['cancelArtworkConfirmation']) {
            $artworkController = new ArtworkController();
            $confirmation = $artworkController->cancelArtwork((int)$_GET['canc'], $_GET['nom'], (int)$_GET['id'], $_GET['desc']);
            if (!$confirmation) {
                echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Obra cancelada',
                        text: 'Obra cancelada correctament.',
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php?page=cancelacions';
                        }
                    });
                </script>";
            } else {
                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No s'ha pogut cancelar la obra.',
                        showConfirmButton: true,
                        confirmButtonText: 'Tornar'
                    });
                </script>";
            }
        }
        ?>
    </div>
</div>


<script src="assets/js/artwork-view.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cancelArtworkLink').addEventListener('click', function (e) {
            e.preventDefault();

            // Obtenemos las opciones del select (generadas desde PHP al inicio)
            const optionsHtml = `<?php
                $artworkController = new ArtworkController();
                $data = $artworkController->getCancelCauseList();
                foreach ($data as $d) {
                    echo "<option value='".$d['id']."'>".$d['text']."</option>";
                }
            ?>`;

            Swal.fire({
                title: 'Introdueix els valors',
                html: `
                    <div>
                        <label for="nombre">Nom del treballador autoritzat:</label><br>
                        <input id="nombre" type="text" class="swal2-input" placeholder="Nom"><br>
                        <label for="canc">Motiu de baixa:</label><br>
                        <select id="canc" class="swal2-select">
                            <option value="" disabled selected>Selecciona un motiu</option>
                            ${optionsHtml}
                        </select><br>
                        <label for="desc">Descripció:</label><br>
                        <textarea id="desc" class="swal2-textarea" placeholder="Descripció"></textarea>
                    </div>
                `,
                focusConfirm: false,
                confirmButtonText: 'Guardar',
                preConfirm: () => {
                    // Recoger valores
                    const nombre = document.getElementById('nombre').value.trim();
                    const canc = document.getElementById('canc').value;
                    const desc = document.getElementById('desc').value.trim();

                    // Validar que todos los campos están completos
                    if (!nombre || !canc || !desc) {
                        Swal.showValidationMessage('Tots els camps són obligatoris.');
                        return false;
                    }

                    // Devolver los valores para procesarlos
                    return { nombre, canc, desc };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { nombre, canc, desc } = result.value;

                    // Construir la URL con los parámetros GET
                    const url = `index.php?page=artwork-view&cancelArtworkConfirmation=true&id=<?php echo $_GET['id']; ?>&nom=${encodeURIComponent(nombre)}&canc=${encodeURIComponent(canc)}&desc=${encodeURIComponent(desc)}`;

                    // Redirigir
                    window.location.href = url;
                }
            });
        });
    });
</script>