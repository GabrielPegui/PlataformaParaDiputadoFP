<?php 
$host = '74.208.237.100';
$user = 'joel_analitikal';
$pass = 'Rj%qk0172';
$base_de_datos = 'analitikal';

/* echo $host;
echo $user;
echo $contrasenia;
echo $base_de_datos;
exit; */
$db = new mysqli($host, $user, $pass, $base_de_datos);
if ($db->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
return $db;