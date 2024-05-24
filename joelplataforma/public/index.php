<?php
// index.php modificado para manejar acciones
require_once '../src/Controller/LoginController.php';
require_once '../src/Controller/PcController.php';
require_once '../src/Controller/RegisterController.php';
require_once __DIR__ . '/../config/connection.php'; // Incluye el archivo de configuración de la base de datos
require_once __DIR__ . '/../config/connodbc.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['action']) && $_GET['action'] == 'login') {
    $controller = new LoginController($db);
    $controller->login();
} elseif (isset($_GET['action']) && $_GET['action'] == 'addpc') {
    $controller = new MiembroPcController($db, $conn);
    $controller->addPc();
} elseif (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $controller = new LoginController($db);
    $controller->logout();
} elseif (isset($_GET['action']) && $_GET['action'] == 'delpc') {
    $cedula = $_GET['cedula'];
    $controller = new MiembroPcController($db, $conn);
    $controller->delPc($cedula);
} elseif (isset($_GET['action']) && $_GET['action'] == 'editpc') {
    
    $controller = new MiembroPcController($db, $conn);
    $controller->editPc();
} elseif (isset($_GET['action']) && $_GET['action'] == 'adduser') {
    
    $controller = new RegUserController($db, $conn);
    $controller->addUser();
} elseif (isset($_GET['action']) && $_GET['action'] == 'deluser') {
    $cedula = $_GET['cedula'];
    
    $controller = new RegUserController($db, $conn);
    $controller->delUser($cedula);
} elseif (isset($_GET['action']) && $_GET['action'] == 'edituser') {
    
    $controller = new RegUserController($db, $conn);
    $controller->editUser();
}
 else {
    $controller = new LoginController($db);
    $controller->index();
}
