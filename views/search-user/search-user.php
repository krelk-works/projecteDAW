<aside id="searchbar">
    <form id="searchbarwrapper" action="<?= $_SERVER['PHP_SELF']; ?>?inici" method="GET">
        <h3>Filtre de busqueda</h3>
        <label for="search">Cerca</label>
        <input type="text" name="search" id="search" placeholder="Cerca" value="<?php if (isset($_GET['search']))
            echo $_GET['search']; ?>">
        <label for="role">Rol</label>
        <select name="role" id="role">
            <option value="admin">Admin</option>
            <option value="tecnic">Tecnic</option>
            <option value="convidat">Convidat</option>
        </select>

        <button id="searcherButton" type="submit" class="search_button"><i class="fa-solid fa-magnifying-glass"></i>Cerca</button>
    
        <button id="resetFilters" type="button" class="delete_button"><i class="fa-solid fa-eraser"></i>Resetejar filtres</button>

        <button id="searcherButton" type="button" class="search_button" onclick="redirectToSearchUser()">
            <i class="fa-solid fa-magnifying-glass"></i>Cambiar a creacion
        </button>

        <script>
// Función para redirigir a la vista de search-user
function redirectToSearchUser() {
    window.location.href = 'http://localhost:8080/projecteDAW/index.php?page=usuaris'; // Cambia la URL según sea necesario
}
</script>

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