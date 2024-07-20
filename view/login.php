<?php include('header.php'); ?>

<div class="container">
    <div class="main">
        <!-- Login Form -->
        <div id="login-form">
            <form action="../controller/validar.php" method="post">
                <div class="input-container">
                    <input type="text" id="usuario" name="usuario" placeholder=" Usuario" required>
                </div>
                <div class="input-container">
                    <input type="password" id="password" name="password" placeholder=" Contraseña" required>
                </div>
                <button class="boton-login" type="submit">Login</button>
                <button type="button" class="btn-registrar" onclick="showRegister()">Registrar</button>
            </form>
        </div>

       
        <div id="register-form" style="display: none;">
            <form action="../controller/controller_register.php" method="POST">
                <div class="input-container">
                    <input type="text" placeholder="Nombre de usuario" name="usuario_re" required>
                </div>
                <div class="input-container">
                    <input type="password" placeholder="Contraseña" name="password_re" required>
                </div>
                <button class="boton-registrar" type="submit">Registrarse</button>
                <button type="button" class="btn-login" onclick="showLogin()">< Login</button>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
function showRegister() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
}

function showLogin() {
    document.getElementById('register-form').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';
}
</script>
