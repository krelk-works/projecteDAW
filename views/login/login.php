<?php
    // Check if the user wants to login.
    if (isset($_POST['username']) && isset($_POST['password'])){
        $controller = new UserController();
        $controller->login($_POST['username'], $_POST['password']);
    }
?>

<div id="login_wrapper">
    <div class="login-container">
        <div class="image-container">
            <img src="assets/img/login-screen.png" alt="Apel·les Fenosa">
        </div>
        <div class="login-form">
            <img src="assets/img/logo.png" alt="Museu Apel·les Fenosa" class="logo">
            <!--<h2>INTRANET</h2>-->
            <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                <div class="input-group">
                    <label for="username">
                        <i class="fas fa-user"></i>
                    </label>
                    <input type="text" id="username" name="username" placeholder="Usuari" required>
                </div>
                <div class="input-group">
                    <label for="password">
                        <i class="fas fa-lock"></i>
                    </label>
                    <input type="password" id="password" name="password" placeholder="Contrasenya" required>
                </div>
                <?php
                    
                    if (isset($_GET['error-login'])){
                        echo '<p class="retry-login-text">* Usuari o contrasenya incorrectes.</p>';
                    }
                ?>
                
                <!--<a href="#" class="forgot-password">He oblidat la meva contrasenya</a>-->
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
        
    </div>
</div>
