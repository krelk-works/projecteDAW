<aside id="createbar">
    <form id="createbarwrapper" method="POST" action="<?=$_SERVER['PHP_SELF'];?>?page=localitzacions" enctype="multipart/form-data">
        <h3>Filtrar</h3>
        <label for="location_name">Nom de la obra</label>
        <input type="text" name="location_name" id="location_name" placeholder="Introdueix el nom de la obra" required>
        <button type="submit" id="createButton"><i class="fa-solid fa-user-plus"></i>Cerca</button>
    </form>
</aside>