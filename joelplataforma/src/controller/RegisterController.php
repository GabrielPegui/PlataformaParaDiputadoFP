<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../model/RegUserModel.php';

class RegUserController
{
    private $userModel;

    public function __construct($db, $conn)
    {
        $this->userModel = new Registro($db, $conn);
    }

    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //info formulario registro padron
            $cedula = $_POST['cedula'];
            $cedulaEnlace = $_POST['cedula-enlace'];
            $telefono = $_POST['telefono'];
            $funcion = $_POST['funcion'] ?? '';
            $idFuncion = $_POST['id-funcion'] ?? '';

            // Asume validación de datos aquí...

            $resultado = $this->userModel->addMiembro($cedula, $telefono, $funcion, $idFuncion, $cedulaEnlace);

            // Redireccionar y manejar la respuesta
            if ($resultado) {
                // Lógica para manejar un inicio de sesión exitoso
                $_SESSION['message_type'] = 'success';
                $_SESSION['message'] = 'Agregado';
                header('Location: /registro/');
                exit;
            } else {
                // Lógica para manejar un fallo en el inicio de sesión
                $_SESSION['message'] = 'No Agregado';
                $_SESSION['message_type'] = 'warning';
                header('Location: /registro/'); // Asegúrate de que esta es la ruta correcta
                exit;
            }
        }
    }

    public function editUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cedula = $_POST['cedula-afil'];
            $telefono = $_POST['tel-afil'];
            $correo = $_POST['correo-afil'];

            $resultado = $this->userModel->editMiembro($cedula, $telefono);

            if ($resultado) {
                // Lógica para manejar un inicio de sesión exitoso
                $_SESSION['message_type'] = 'success';
                $_SESSION['message'] = 'Editado';
                header('Location: /registro/');
                exit;
            } else {
                $_SESSION['message'] = 'Error en la edicion';
                $_SESSION['message_type'] = 'warning';
                header('Location: /registro/');
                exit;
            }
        }
    }

    public function delUser($cedula)
    {
        $resultado = $this->userModel->delMiembro($cedula);

        if ($resultado) {
            // Lógica para manejar un inicio de sesión exitoso
            $_SESSION['message_type'] = 'warning';
            $_SESSION['message'] = 'Eliminado';
            header('Location: /registro/');
            exit;
        }
    }
}