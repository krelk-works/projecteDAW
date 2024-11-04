<?php
// Web locations
// inici -> Home
// usuaris -> Users
// localitzacions -> Locations
// backups -> Backups
$actualPage = "";
if (isset($_GET['page'])) {
    $actualPage = $_GET['page'];
} else {
    $actualPage = "inici";
}
?>

<head>
    <script src="assets/js/navbar.js" defer></script>
</head>
<header>
    <nav id="navbar">
        <!-- Logo -->
        <a href="index.php" id="logo-link">
            <div class="navideño">
                <img class="navidad" src="assets/img/navidaa.gif" alt="Navidad">
                <!--<img class="navidad2" src="assets/img/navidaa.gif" alt="Navidad">-->
            </div>
            <img src="assets/img/logo.png" width="30" height="30" alt="Logo">
        </a>
        <!-- Navigation menú -->
        <ul>
            <li>
                <a href="index.php"
                    style="<?php echo (!isset($actualPage) || $actualPage == "inici") ? "border-bottom: 2px solid #007bff;" : ""; ?>">Inici</a>
            </li>

            <?php
            // If the user is admin, show the following options
            
            if ($_SESSION['role'] != "convidat") {

                // Variables to change the style of the selected option
                $expositionManagementStyle = $actualPage == "expositions" ? "border-bottom: 2px solid #007bff;" : "";
                $userManagementStyle = $actualPage == "usuaris" ? "border-bottom: 2px solid #007bff;" : "";
                $locationManagementStyle = $actualPage == "localitzacions" ? "border-bottom: 2px solid #007bff;" : "";
                $vocabularyManagementStyle = $actualPage == "vocabulari" ? "border-bottom: 2px solid #007bff;" : "";
                $backupManagementStyle = $actualPage == "backups" ? "border-bottom: 2px solid #007bff;" : "";

                // Exposition management
                echo "<li>";
                echo "<a href='?page=expositions' style='$expositionManagementStyle'>Exposicions</a>";
                echo "</li>";

                

                if ($_SESSION['role'] == "admin") {
                    // User management
                    echo "<li>";
                    echo "<a href='?page=usuaris' style='$userManagementStyle'>Usuaris</a>";
                    echo "</li>";

                    // Location management
                    echo "<li>";
                    echo "<a href='?page=localitzacions' style='$locationManagementStyle'>Localitzacions</a>";
                    echo "</li>";
                
                    // Vocabulary management
                    echo "<li>";
                    echo "<a href='?page=vocabulari' style='$vocabularyManagementStyle'>Vocabularis</a>";
                    echo "</li>";

                    // Backup management
                    echo "<li>";
                    echo "<a href='?page=backups' style='$backupManagementStyle'>Backups</a>";
                    echo "</li>";
                }
            }
            ?>
        </ul>
        <!-- Profile icon & drop down menu -->
        <div id="profile">
            <div class="profile-section">
                <div class="profile-image-container">
                    <img src="<?php echo $_SESSION['profile_img']; ?>" alt="Foto de perfil" class="profile-image">
                </div>
                <div class="menu-button-container">
                    <button class="menu-button" onclick="toggleMenu()">☰</button>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <?php



                        echo "<a href='?page=user-administration&userID=" . $_SESSION['id'] . "'><i class='fa-solid fa-user'></i>" . $_SESSION['username'] . "</a>";
                        ?>
                        <a href="#" id="logoutButton"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>