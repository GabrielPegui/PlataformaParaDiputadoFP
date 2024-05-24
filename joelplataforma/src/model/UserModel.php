<?php
// UsuarioModel.php
class UserModel
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db; // Asumiendo que $db es una conexión mysqli
    }

    public function userAuth($user, $password)
    {
        // Prepara la consulta SQL
        $stmt = $this->db->prepare("SELECT cedula, telefono, nombre, funcion, nom_funcion FROM miembros WHERE cedula = ? AND contrasena = ? LIMIT 1");


        // Vincula los parámetros a la consulta
        $stmt->bind_param("ss", $user, $password);

        // Ejecuta la consulta
        $stmt->execute();

        // Almacena el resultado para poder verificar si hay filas devueltas
        $stmt->store_result();

        // Verifica si se encontró el usuario
        if ($stmt->num_rows == 1) {
            // Usuario autenticado con éxito

            $cedula = '';
            $telefono = '';
            $nombre = '';
            $funcion = '';
            $nom_funcion = '';

            $stmt->bind_result($cedula, $telefono, $nombre, $funcion, $nom_funcion);
            $stmt->fetch(); // Cargar los datos en las variables $cedula y $pass
            
            return ['cedula' => $cedula, 'telefono' => $telefono, 'nombre' => $nombre, 'funcion'=> $funcion, 'nom_funcion'=> $nom_funcion];
        } else {
            // Autenticación fallida
            return false;
        }

        // Cierra el statement
        $stmt->close();
    }

    
}
