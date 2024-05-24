<?php
//$url = str_replace('', '', $_SERVER['REQUEST_URI']);

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


switch ($url) {
    case '/':
        require __DIR__ . '/src/view/login.php';
        break;
    case '/inicio/':

        require __DIR__ . '/src/view/padroncomp.php';
        break;
    case '/registro/':
        require __DIR__ . '/src/view/registro.php';
        break;
    case '/reportes/':
        require __DIR__ . '/src/view/reportes.php';
        break;
    case '/edit-padron/':

        require __DIR__ . '/src/view/editPadron.php';
        break;
    case '/edit-registro':

        require __DIR__ . '/src/view/editRegistro.php';
        break;
    case '/juliana':

        require __DIR__ . '/src/view/login-juliana.php';
        break;
    case '/juliana-inicio':

        require __DIR__ . '/src/view/padroncomp-juliana.php';
        break;
    default:
        // Manejar error 404
        require __DIR__ . '/src/View/404.php';
        break;
}
