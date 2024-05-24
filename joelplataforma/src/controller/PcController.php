<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../model/Miembropc.php';

class MiembroPcController
{
    private $miembroModel;

    public function __construct($db, $conn)
    {
        $this->miembroModel = new Miembro($db, $conn);
    }

    public function addPc()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Info login del user
            $cedula_usr = $_SESSION['usr_cedula'];

            //info formulario registro padron
            $cedula = $_POST['cedula-afil'];
            $telefono = $_POST['tel-afil'];
            $correo = $_POST['correo-afil'] ?? '';
            $direccion = $_POST['text-direccion'] ?? '';

            // Asume validación de datos aquí...

            $resultado = $this->miembroModel->addMiembroPc($cedula, $telefono, $correo, $direccion, $cedula_usr, );

            // Redireccionar y manejar la respuesta
            if ($resultado) {
                // Lógica para manejar un inicio de sesión exitoso
                $_SESSION['message_type'] = 'success';
                $_SESSION['message'] = 'Agregado';
                header('Location: /inicio/');
                exit;
            } else {
                // Lógica para manejar un fallo en el inicio de sesión
                $_SESSION['message'] = 'No Agregado';
                $_SESSION['message_type'] = 'warning';
                header('Location: /inicio/'); // Asegúrate de que esta es la ruta correcta
                exit;
            }
        }
    }

    public function editPc()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cedula = $_POST['cedula-afil'];
            $telefono = $_POST['tel-afil'];
            $correo = $_POST['correo-afil'];

            $resultado = $this->miembroModel->editMiembroPc($cedula, $telefono, $correo);

            if ($resultado) {
                // Lógica para manejar un inicio de sesión exitoso
                $_SESSION['message_type'] = 'warning';
                $_SESSION['message'] = 'Editado';
                header('Location: /inicio/');
                exit;
            } else {
                $_SESSION['message'] = 'Error en la edicion';
                $_SESSION['message_type'] = 'success';
            }
        }
    }

    public function delPc($cedula)
    {
        $resultado = $this->miembroModel->delMiembroPc($cedula);

        if ($resultado) {
            // Lógica para manejar un inicio de sesión exitoso
            $_SESSION['message_type'] = 'warning';
            $_SESSION['message'] = 'Eliminado';
            header('Location: /inicio/');
            exit;
        }
    }
}
