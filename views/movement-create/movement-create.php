
<aside id="createbar">
    <form id="createbarwrapper" action="<?= $_SERVER['PHP_SELF']; ?>" method="GET">
        <h3>Creació de moviments</h3>
        <label for="backupname">Nom</label>
        <input type="text" name="backupname" id="backupname" placeholder="Nom del moviment">
        <input type="hidden" name="page" value="backups">
        <button type="submit" id="createBackupButton"><i class="fa-solid fa-user-plus"></i>Crear</button>
    </form>
</aside>