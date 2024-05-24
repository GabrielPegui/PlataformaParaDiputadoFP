<?php
include_once __DIR__ . '/../../includes/menu.php';
include_once __DIR__ . '/../../config/connection.php';

?>

<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="d-flex gap-5 justify-content-center mx-5 my-5">
    <div class="card text-bg-dark border-light" style="width: 18rem;">
        <div class="card-header">
            Electorales
        </div>
        <ul class="list-group list-group-flush text-bg-dark">
            <li class="list-group-item"><a href="/public/reportes/Analitikal C3 -1.pdf" target="_blank">Recintos por sector</a></li>
            <li class="list-group-item"><a href="/public/reportes/Analitikal c3 -2.pdf" target="_blank">Votantes por recinto</a></li>
            <li class="list-group-item"><a href="/public/reportes/Primeros Votantes C3.pdf" target="_blank">Nuevos Votantes</a></li>
        </ul>
    </div>

    <div class="card text-bg-success border-light" style="width: 18rem;">
        <div class="card-header">
            Dirigentes
        </div>
        <ul class="list-group list-group-flush text-bg-dark">
            <li class="list-group-item"><a href="/public/reportes/rpt_CG.php" target="_blank">Coordinadores General</a></li>
            <li class="list-group-item"><a href="/public/reportes/rpt_enlace_deadmin.php" target="_blank">Enlaces en General</a></li>
            <li class="list-group-item"><a href="/public/reportes/rpt_enlace_sector.php" target="_blank">Enlaces por Sector</a></li>
          
        </ul>
    </div>

    <div class="card text-bg-danger border-light" style="width: 18rem;">
        <div class="card-header">
            Simpatizantes
        </div>
        <ul class="list-group list-group-flush text-bg-dark">
            <li class="list-group-item"><a href="/public/reportes/rpt_enlaces_personal.php" target="_blank">Mis Enlaces</a></li>
            <li class="list-group-item"><a href="/public/reportes/rpt_coordinadores.php" target="_blank"> Mis Coordinadores</a></li>
            <li class="list-group-item"><a href="/public/reportes/rpt_simpatizantes.php" target="_blank"> Mis Simpatizantes</a></li>
        </ul>
    </div>

    <div class="card text-bg-secondary border-light" style="width: 18rem;">
        <div class="card-header">
            Estadisticas
        </div>
        <ul class="list-group list-group-flush text-bg-dark">
            <li class="list-group-item">Avance por Colegio</li>
            <li class="list-group-item">Avance por Recinto</li>
            <li class="list-group-item">PadronJCE</li>
        </ul>
    </div>
</div>