<?php
// LoginController.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../../config/connection.php'; // Incluye el archivo de configuración de la base de datos

class LoginController {
    private $model;

    public function __construct($db) {
        $this->model = new UserModel($db); // Pasando la conexión PDO al modelo
    }

    public function index() {
        header('Location: /');
        exit;
    }

    public function login() {
        $user = $_POST['user'];
        $password = $_POST['password'];

        // Intenta autenticar al usuario
        $resultado = $this->model->userAuth($user, $password);

        
        // Dependiendo del resultado, rediriges o muestras un error
        if ($resultado) {
            // Lógica para manejar un inicio de sesión exitoso
            
            $_SESSION['usr_cedula'] = $resultado['cedula'];
            $_SESSION['usr_nombre'] = $resultado['nombre'];
            $_SESSION['usr_tel'] = $resultado['telefono'];
            $_SESSION['usr_funcion'] = $resultado['funcion'];
            $_SESSION['usr_nom_funcion'] = $resultado['nom_funcion'];
            
            header('Location: /inicio/'); // Ajusta la ruta según sea necesario
            exit;
        } else {
            // Lógica para manejar un fallo en el inicio de sesión
            header('Location: /');
            exit;
        }
    }

    public function logout() {
        // Inicia la sesión para poder limpiarla
        session_start();

        // Elimina todas las variables de sesión
        $_SESSION = array();

        // Destruye la sesión
        session_destroy();

        // Redirige al usuario a la página de inicio de sesión o a la página principal
        header("Location: /");
        exit;
    }
}
