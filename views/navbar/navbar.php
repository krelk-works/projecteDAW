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
            <img src="assets/img/logo.png" width="30" height="30" alt="Logo">
        </a>
        <!-- Navigation menú -->
        <ul>
            <li>
                <a href="index.php" style="<?php echo (!isset($actualPage) || $actualPage == "inici" || $actualPage == "artwork-view" || $actualPage == "artwork-create2") ? "border-bottom: 2px solid #007bff;" : ""; ?>">Inici</a>
            </li>

            <?php
            // If the user is admin, show the following options
            
            if ($_SESSION['role'] != "convidat") {

                // Variables to change the style of the selected option
                $expositionManagementStyle = $actualPage == "expositions" || $actualPage == "exposition-administration" ? "border-bottom: 2px solid #007bff;" : "";
                $userManagementStyle = $actualPage == "usuaris" ? "border-bottom: 2px solid #007bff;" : "";
                $locationManagementStyle = $actualPage == "localitzacions" ? "border-bottom: 2px solid #007bff;" : "";
                $vocabularyManagementStyle = $actualPage == "vocabulari" ? "border-bottom: 2px solid #007bff;" : "";
                $dropdownManagementStyle = $actualPage == "moviments" || $actualPage == "cancelacions" || $actualPage == "restauracions" ? "border-bottom: 2px solid #007bff;" : "";
                $movimentManagementStyle = $actualPage == "moviments" ? "border-bottom: 2px solid #007bff;" : "";
                $backupManagementStyle = $actualPage == "backups" ? "border-bottom: 2px solid #007bff;" : "";
                $cancelationManagementStyle = $actualPage == "cancelacions" ? "border-bottom: 2px solid #007bff;" : "";
                $restaurationManagementStyle = $actualPage == "restauracions" ? "border-bottom: 2px solid #007bff;" : "";

                // Exposition management
                echo "<li>";
                echo "<a href='?page=expositions' style='$expositionManagementStyle'>Exposicions</a>";
                echo "</li>";
                
                // Location management
                echo "<li>";
                echo "<a href='?page=localitzacions' style='$locationManagementStyle'>Ubicacions</a>";
                echo "</li>";
                
                echo "<li class='dropdown1'>";
                echo "<a href='#' class='dropdown-toggle1' style='$dropdownManagementStyle'>Gestio</a>";
                echo "<ul class='dropdown-menu1'>";
                echo "<li><a href='?page=moviments' style='$movimentManagementStyle'>Moviments</a></li>";
                echo "<li><a href='?page=cancelacions' style='$cancelationManagementStyle'>Baixes</a></li>";
                echo "<li><a href='?page=restauracions' style='$restaurationManagementStyle'>Restauracions</a></li>";
                echo "</ul>";
                echo "</li>";
                

                if ($_SESSION['role'] == "admin") {
                    // User management

                    echo "<li><a href='?page=vocabulari' style='$vocabularyManagementStyle'>Vocabularis</a></li>";

                    echo "<li>";
                    echo "<a href='?page=usuaris' style='$userManagementStyle'>Usuaris</a>";
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



                        ?>
                        <a href="#" id="logoutButton"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>