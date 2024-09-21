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
            <a href="index.php" style="<?php echo (!isset($actualPage) || $actualPage == "inici") ? "border-bottom: 2px solid #007bff;" : ""; ?>">Inici</a>
        </li>
        <li>
            <a href="?page=usuaris" style="<?php echo $actualPage == "usuaris" ? "border-bottom: 2px solid #007bff;" : "" ?>">Usuaris</a>
        </li>
        <li>
            <a href="?page=localitzacions" style="<?php echo $actualPage == "localitzacions" ? "border-bottom: 2px solid #007bff;" : "" ?>">Localitzacions</a>
        </li>
        <li>
            <a href="?page=backups" style="<?php echo $actualPage == "backups" ? "border-bottom: 2px solid #007bff;" : "" ?>">Backups</a>
        </li>
    </ul>
    <!-- Profile picture -->
    <div id="profile">
        <div id="profileName">
            <p><?php echo $_SESSION['firstname']." ".$_SESSION['lastname'] ?></p>
        </div>

        <div id="profileIconAandOptions">
            <img id="profileButton" src="<?php echo $_SESSION['profileimg'] ?>" width="30" height="30" class="" alt="Profile icon">
            <i class="fa-solid fa-gear" id="profileSettings"></i>
            <i class="fa-solid fa-right-from-bracket" id="logoutButton"></i>
        </div>
    </div>
</nav>