<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/public/css/styles.css">
    <title>Analitikal - Inicio</title>
</head>

<body>
    <div class="container" id= "container-login">
    <img class="" id="front-img-login" src="/public/img/logo-juliana.png" alt="" width="250px">
        <div class="form-container" style="min-width: 400px">
            <form method="post" id ="form-login" action="/public/index.php?action=login">
                <h1>Inicio de sesión</h1>
                <div class="input-container">
                    <input type="text" id="user" name="user" placeholder="Ingresa tu correo electrónico">
                </div>
                <div class="input-container">
                    <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña">
                </div>
                <button type="submit">Iniciar sesión</button>

                <div class="forgot-pass">
                    <a href="#">Olvide mi contraseña</a>
                </div>
            </form>
        </div>
        <!-- <div class="image-container">
            
        </div> -->
    </div>
</body>

</html>