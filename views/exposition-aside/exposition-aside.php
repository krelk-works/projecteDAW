<aside id="createbar">
    <form id="createbarwrapper" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=localitzacions" enctype="multipart/form-data">
        <h3>Filtrar</h3>
        <label for="location_name">Nom de l'exposicio</label>
        <input type="text" name="location_name" id="location_name" placeholder="Introdueix el nom de l'exposició" required>
        <button type="submit" id="createButton"><i class="fa-solid fa-user-plus"></i>Cerca</button>
        <button type="submit" id="createButton"><i class="fa-solid fa-user-plus"></i>Crear exposició</button>
    </form>
</aside>