<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$cedula_usr = $_SESSION['usr_cedula'];
$nombre = $_SESSION['usr_nombre'];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/css/styles.css">
    <script src="https://kit.fontawesome.com/0b325f17f1.js" crossorigin="anonymous"></script>

    <title>Joel Rodriguez - Analitikal</title>
</head>

<body>
    <header id="main-header">
        <div class="content">
            <div class="logo">ANALITIKAL</div>
            <nav>
                <ul>
                    <li><a href="/inicio/">Inicio</a></li>
                    <li><a href="/registro/">Registro</a></li>
                    <li><a href="/reportes/">Reportes</a></li>
                    <li><a href="#">Graficos</a></li>
                    <li><a href="/public/index.php?action=logout">Salir</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="background-image"></div>
    
