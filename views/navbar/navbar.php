<?php
    // Web locations
    // inici -> Home
    // usuaris -> Users
    // localitzacions -> Locations
    // backups -> Backups
    $actualPage = "";
    if (isset($_GET['page'])){
        $actualPage = $_GET['page'];
    } else {
        $actualPage = "inici";
    }
?>

<nav id="navbar">
    <!-- Logo -->
    <a href="" id="logo-link">
        <img src="assets/img/logo.png" width="30" height="30" alt="Logo">
    </a>
    <!-- Navigation menú -->
    <ul>
        <li>
            <a href="index.php" style="<?php echo (!isset($actualPage) || $actualPage == "inici") ? "font-weight: 500;" : ""; ?>">Inici</a>
        </li>
        <li>
            <a href="?page=usuaris" style="<?php echo $actualPage == "usuaris" ? "font-weight: 500;" : "" ?>">Usuaris</a>
        </li>
        <li>
            <a href="?page=localitzacions" style="<?php echo $actualPage == "localitzacions" ? "font-weight: 500;" : "" ?>">Localitzacions</a>
        </li>
        <li>
            <a href="?page=backups" style="<?php echo $actualPage == "backups" ? "font-weight: 500;" : "" ?>">Backups</a>
        </li>
    </ul>
    <!-- Profile picture -->
    <div id="profile">
        <img id="profileButton" src="<?php echo $_SESSION['profileimg'] ?>" width="30" height="30" class="" alt="Profile icon">
    </div>
</nav>