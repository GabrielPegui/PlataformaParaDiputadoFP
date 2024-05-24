<?php
class Miembro
{
    private $db;
    private $conn;


    public function __construct($db, $conn)
    {
        $this->db = $db;
        $this->conn = $conn;
    }

    public function addMiembroPc($cedulaAfil, $telefono, $correo, $direccion, $cedula_usr)
    {
        $query_cedula_dup = "SELECT * FROM padron_compromiso WHERE cedula_afil = ?";
        $stmt = $this->db->prepare($query_cedula_dup);

        if ($stmt === false) {
            // Manejar error de preparación
            exit('Error preparando la consulta: ' . htmlspecialchars($this->db->error));
        }

        $stmt->bind_param("s", $cedulaAfil);

        if (!$stmt->execute()) {
            // Manejar error de ejecución
            exit('Error ejecutando la consulta: ' . htmlspecialchars($stmt->error));
        }

        $result_cedula_dup = $stmt->get_result(); // Obtener el resultado de la ejecución
        $num_cedula_dup = $result_cedula_dup->num_rows; // Contar las filas del resultado

        if ($num_cedula_dup > 0) {

            header("location: /inicio/");

        } else {

            // Verificar cedula en el padron de la junta y busqueda de informacion
            $query_padron = "select * from fuerzapueblo.dbo.PADRON WHERE cedula='$cedulaAfil'";
            $result_padron = odbc_exec($this->conn, $query_padron);
            if (!$result_padron) {
                die("Error en la consulta: " . odbc_errormsg());
            }

            if (odbc_num_rows($result_padron) > 0) {

                if ($row = odbc_fetch_array($result_padron)) {

                    $cedula = $row['Cedula'];
                    $nombre = $row['nombres'];
                    $idColegio = $row['IdColegio'];
                    $apllido1 = $row['apellido1'];
                    $apllido2 = $row['apellido2'];
                    $apellComp = $apllido1 . ' ' . $apllido2;
                    $sexo = $row['IdSexo'];
                    $fechaNac = $row['FechaNacimiento'];

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
                            //exit('' . $municipio . '');

                            if ($circ === '01' || $municipio === 223) {
                                $sql = "INSERT INTO padron_compromiso (cedula, cedula_afil, nombre, apellido, fecha_nacimiento, sexo, telefono_afil, correo_afil, municipio, id_municipio, circunscripcion_id, cod_recinto, cod_colegio, direccion, descrip_recinto, id_sector, sector) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmt = $this->db->prepare($sql);
                                $stmt->bind_param("sssssssssssssssss", $cedula_usr, $cedulaAfil, $nombre, $apellComp, $fechaNac, $sexo, $telefono, $correo, $municipio, $idMunicipio, $circ, $recinto, $colegio, $direccion, $desc_recinto, $codSector, $sector);
                                return $stmt->execute();
                            } else {
                                $_SESSION['message'] = 'La persona que intenta agragar no pertenece a la Circunscripcion 3 del Distrito Nacional';
                                $_SESSION['message_type'] = 'danger';
                                header("location: /inicio/");
                                exit;
                            }
                        }
                    }



                } else {
                    header("location: /inicio/");

                }

            } else {
                header("location: /inicio/");
            }

        }

    }

    public function delMiembroPc($cedula)
    {
        $query = "DELETE FROM padron_compromiso WHERE cedula_afil= ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $cedula);
        
        return $stmt->execute();

    }

    public function editMiembroPc($cedula, $telefono, $correo) {
        $query = "UPDATE padron_compromiso SET telefono_afil = ? WHERE cedula= ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $telefono, $cedula);
        
        return $stmt->execute();
    }
}
