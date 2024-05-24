<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


class Registro
{
    private $db;
    private $conn;


    public function __construct($db, $conn)
    {
        $this->db = $db;
        $this->conn = $conn;
    }

    public function addMiembro($cedula, $telefono, $funcion, $idFuncion, $cedulaEnlace)
    {
        $query_cedula_dup = "SELECT * FROM miembros WHERE cedula = ?";
        $stmt = $this->db->prepare($query_cedula_dup);

        if ($stmt === false) {
            // Manejar error de preparación
            exit('Error preparando la consulta: ' . htmlspecialchars($this->db->error));
        }

        $stmt->bind_param("s", $cedula);

        if (!$stmt->execute()) {
            // Manejar error de ejecución
            exit('Error ejecutando la consulta: ' . htmlspecialchars($stmt->error));
        }

        $result_cedula_dup = $stmt->get_result(); // Obtener el resultado de la ejecución
        $num_cedula_dup = $result_cedula_dup->num_rows; // Contar las filas del resultado

        if ($num_cedula_dup > 0) {

            $_SESSION['message'] = 'La persona que intenta agragar ya ha sido registrada';
            $_SESSION['message_type'] = 'danger';
            header("location: /registro/");

        } else {

            // Verificar cedula en el padron de la junta y busqueda de informacion
            $query_registro = "select * from fuerzapueblo.dbo.PADRON WHERE cedula='$cedula'";
            $result_registro = odbc_exec($this->conn, $query_registro);
            if (!$result_registro) {
                die("Error en la consulta: " . odbc_errormsg());
            }

            if (odbc_num_rows($result_registro) > 0) {

                if ($row = odbc_fetch_array($result_registro)) {

                    $cedula = $row['Cedula'];
                    $nombre = $row['nombres'];
                    $idColegio = $row['IdColegio'];
                    $apllido1 = $row['apellido1'];
                    $apllido2 = $row['apellido2'];
                    $apellComp = $apllido1 . ' ' . $apllido2;
                    $sexo = $row['IdSexo'];
                    $fechaNac = $row['FechaNacimiento'];
                    $pass = substr($cedula, -4);

                    $query_padron_2 = "select * from fuerzapueblo.dbo.vwColegioCascada WHERE idcolegio = '$idColegio' ";
                    $result_padron_2 = odbc_exec($this->conn, $query_padron_2);
                    if (!$result_padron_2) {
                        die("Error en la consulta: " . odbc_errormsg());
                    }

                    if (odbc_num_rows($result_padron_2) > 0) {
                        if ($row_padron_2 = odbc_fetch_array($result_padron_2)) {
                            $municipio = $row_padron_2['DescripcionMunicipio'];
                            $idMunicipio = $row_padron_2['IdMunicipio'];
                            $circ = $row_padron_2['codigocircunscripcion'];
                            $codSector = $row_padron_2['CodigoSector'];
                            $sector = $row_padron_2['DescripcionSector'];
                            $recinto = $row_padron_2['IdRecinto'];
                            $desc_recinto = $row_padron_2['DescripcionRecinto'];
                            $colegio = $row_padron_2['CodigoColegio'];
                            //exit('' . $idMunicipio . $circ .'');

                            if ($circ === '01' || $municipio === 223) {

                                $sql = "INSERT INTO miembros (cedula, cedula_enlace, nombre, apellido, contrasena, fecha_nacimiento, sexo, telefono, funcion, nom_funcion, municipio, id_municipio, circunscripcion_id, cod_recinto, descrip_recinto, cod_colegio, id_sector, sector)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmt = $this->db->prepare($sql);
                                $stmt->bind_param("sssssssssssssssiss", $cedula, $cedulaEnlace, $nombre, $apellComp, $pass, $fechaNac, $sexo, $telefono, $idFuncion, $funcion, $municipio, $idMunicipio, $circ, $recinto, $desc_recinto, $colegio, $codSector, $sector);
                                return $stmt->execute();

                            } else {
                                $_SESSION['message'] = 'La persona que intenta agragar no pertenece a la Circunscripcion 3 del Distrito Nacional';
                                $_SESSION['message_type'] = 'danger';
                                header("location: /registro/");
                                exit;
                            }
                        }
                    } else {
                        $_SESSION['message'] = 'No Agregado';
                        $_SESSION['message_type'] = 'danger';
                        header("location: /registro/");
                        exit;
                    }


                } else {
                    $_SESSION['message'] = 'Ocurrio un error al buscar la información';
                    $_SESSION['message_type'] = 'warning';
                    header("location: /registro/");
                    exit;
                }

            } else {
                $_SESSION['message'] = 'La persona que intenta agragar NO aparece en el Padron Electoral';
                $_SESSION['message_type'] = 'warning';
                header("location: /registro/");
                exit;
            }

        }

    }

    public function delMiembro($cedula)
    {
        $query = "DELETE FROM miembros WHERE cedula = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $cedula);

        return $stmt->execute();

    }

    public function editMiembro($cedula, $telefono)
    {
        $query = "UPDATE miembros SET telefono = ? WHERE cedula= ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $telefono, $cedula);

        return $stmt->execute();
    }
}
