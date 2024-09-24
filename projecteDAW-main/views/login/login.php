<div id="login_wrapper">
    <div class="login-container">
        <div class="login-form">
            <img src="assets/img/logo.png" alt="Museu Apel·les Fenosa" class="logo">
            <h2>INTRANET</h2>
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
                <a href="#" class="forgot-password">He oblidat la meva contrasenya</a>
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
        <div class="image-container">
            <img src="assets/img/login-screen.png" alt="Apel·les Fenosa">
        </div>
    </div>
</div>
