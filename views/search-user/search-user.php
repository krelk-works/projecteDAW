<aside id="searchbar">
  <form id="searchbarwrapper" action="<?= $_SERVER['PHP_SELF']; ?>?inici" method="GET">
    <h3>Filtre de busqueda</h3>
    <label for="search">Cerca</label>
    <input type="text" name="search" id="search" placeholder="Cerca">
  </form>


  <div class="accordion">
    <div class="accordion-item">
      <button class="accordion-header">Sección 1</button>
      <div class="accordion-content">
        <p>Contenido de la sección 1</p>
      </div>
    </div>

    <div class="accordion-item">
      <button class="accordion-header">Sección 2</button>
      <div class="accordion-content">
        <p>Contenido de la sección 2</p>
      </div>
    </div>

    <div class="accordion-item">
      <button class="accordion-header">Sección 3</button>
      <div class="accordion-content">
        <p>Contenido de la sección 3</p>
      </div>
    </div>
  </div>

</aside>