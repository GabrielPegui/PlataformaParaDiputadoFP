<?php
include_once __DIR__ . '/../../includes/menu.php';
include_once __DIR__ . '/../../config/connection.php';

?>

<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($cedula_usr) && !empty($cedula_usr)) {

    $usr_funcion = $_SESSION['usr_funcion'];
    $usr_nom_funcion = $_SESSION['usr_nom_funcion'];

    if ($usr_funcion == 1) {
        $funcion_reg = 'Enlace';
        $funcion_id_reg = 2;
    } else if ($usr_funcion == 2) {
        $funcion_reg = 'Coordinador';
        $funcion_id_reg = 3;

    } else {
        echo '<script>';
        echo 'alert("No tiene acceso a esta sección de la página");';
        echo 'window.location.href = "/inicio/";';
        echo '</script>';
    }
    $query_padron_disp = "SELECT * FROM miembros WHERE cedula_enlace = ?";
    $stmt = $db->prepare($query_padron_disp);

    if ($stmt === false) {
        // Manejar error de preparación
        exit('Error preparando la consulta: ' . htmlspecialchars($db->error));
    }

    $stmt->bind_param("s", $cedula_usr);

    if (!$stmt->execute()) {
        // Manejar error de ejecución
        exit('Error ejecutando la consulta: ' . htmlspecialchars($stmt->error));
    }

    $result_padron_disp = $stmt->get_result(); // Obtener el resultado de la ejecución
    $num_padron_disp = $result_padron_disp->num_rows; // Contar las filas del resultado
} else {
    header('location: /');
}

?>

<style>
    .custom-container {
        max-width: 80%;
        /* Adjust the width as per your requirements */
        margin: 0 auto;
        /* Center the container horizontally */
    }
</style>
<div class="d-flex mt-3 pt-3">
    <div class="container custom-container">
        <div class="row mt-4 mb-4">
            <div class="row">
                <h1 class="col-lg-9 text-center text-white" id="title-padron">Registro de <?php echo $funcion_reg ?></h1>
                

                <div class="col-lg-1 justify-content-center align-items-center" id="num-afil-container">
                    <h3 class="badge" id="num-afil">
                        <?php if (isset($num_padron_disp))
                            echo $num_padron_disp ?>
                            <span style="font-size: 16px; font-weight: 400;"> reg.</span>

                        </h3>
                    </div>
                </div>
                <div class="card text-bg-dark border-light mt-4">
                    <div class="card-body">
                        <div class="container">
                            <form action="/public/index.php?action=adduser" method="post"
                                class="row my-3 bg-dark text-white" id="form-pad-comp">
                                <div class="col-md-3 form-group">
                                    <input type="text" class="form-control bg-transparent text-white" id="cedula"
                                        name="cedula" placeholder="Cedula del <?php echo $funcion_reg ?>" required>
                                    <input type="hidden" name="cedula-enlace" value="<?php echo $cedula_usr ?>">
                                </div>
                                <div class="col-md-3 form-group">
                                    <input type="text" class="form-control bg-transparent text-white" id="telefono"
                                        name="telefono" placeholder="Telefono del <?php echo $funcion_reg ?>" required>
                                </div>
                                <div class="col-md-3 form-group">
                                    <input type="text" class="form-control bg-transparent text-white" name="funcion"
                                        value="<?php echo isset($funcion_reg) && !empty($funcion_reg) ? $funcion_reg : '' ?>"
                                    placeholder="Funcion del Usuario" required readonly>
                                    <input type="hidden" name="id-funcion" value="<?php echo isset($funcion_id_reg) && !empty($funcion_id_reg) ? $funcion_id_reg : '' ?>">
                            </div>
                            <div class="col-md-1 form-group align-items-center">
                                <button type="submit" class="btn btn-success" name="save-afil"
                                    id="save-afil">Agregar</button>
                            </div>
                        </form>

                    </div>


                </div>
            </div>
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="mt-5 alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show"
                    role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?php echo $_SESSION['message'] ?>
                    <?php
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                    ?>
                </div>
            <?php } ?>
            <div class="table-responsive mt-5">
                <table class="table table-bordered table-dark">
                    <thead class="">
                        <tr>
                            <th>Foto </th>
                            <th>Cedula</th>
                            <th>Nombre Completo</th>
                            <th>Telefono</th>
                            <!-- <th>Correo</th> -->
                            <th>Sector</th>
                            <th>Recinto</th>
                            <th>Colegio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php
                        while ($row_padron_disp = mysqli_fetch_array($result_padron_disp)) {
                            $pconcurrencia = 1 * 16.67;
                            ?>
                            <form action="" method="post">
                                <tr>
                                    <td class="">
                                        Sin Dato
                                        <?php

                                        /* $cedula_foto_demar = $row_padron_disp['cedula_afil'];
                                        if (file_exists('img_temp/' . $cedula_foto_demar . '.jpg')) {
                                            echo '<img src="img_temp/' . $cedula_foto_demar . '.jpg" alt="Imagen" width="100px" height="100px" style="border-radius: 50%;">';
                                            //exit;
                                        } else {
                                            //$cedula_foto = $row_foto['cedula-afil'];
                                            $query_foto_demar = "SELECT * FROM  fuerzapueblo.dbo.FOTOS_FP_FP where cedula='$cedula_foto_demar'";
                                            
                                            $result_demar_foto = odbc_exec($conn, $query_foto_demar);
                                            // Paso 1: Recuperar los datos de la imagen desde la base de datos
                                            $imageData1 = odbc_result($result_demar_foto, "Imagen", );
                                            $imagecedula = odbc_result($result_demar_foto, "cedula", ); // Suponiendo que $row_padron_disp es el resultado de tu consulta
                                            // Paso 2: Convertir los datos binarios a un formato de imagen
                                            $image1 = imagecreatefromstring($imageData1);

                                            // Paso 3: Guardar la imagen en el sistema de archivos
                                            $imagePath1 = 'img_temp/' . $imagecedula . '.jpg'; // Especifica la ruta y el nombre de archivo deseados
                                            imagejpeg($image1, $imagePath1);

                                            // Paso 4: Mostrar la imagen en HTML
                                            echo '<img src="' . $imagePath1 . '" alt="Imagen" width="100px" height="100px" style="border-radius: 50%;">';
                                            //exit;
                                        } */
                                        ?>
                                    </td>
                                    <td class="text-white">
                                        <?php echo isset($row_padron_disp['cedula']) && !empty($row_padron_disp['cedula']) ? $row_padron_disp['cedula'] : 'Sin datos'; ?>
                                        <input type="hidden" name="cedula">
                                    </td>
                                    <td><span style="color: green; font-weight: 600;">
                                            <?php echo isset($row_padron_disp['nombre']) && !empty($row_padron_disp['nombre']) ? $row_padron_disp['nombre'] : 'Sin datos';
                                            echo " " . (isset($row_padron_disp['apellido']) && !empty($row_padron_disp['apellido']) ? $row_padron_disp['apellido'] : 'Sin datos'); ?>
                                        </span> <br><br>Concurrencia <br>P-2012 P-2016 P-2020 2012 2016 2020
                                        <?php echo isset($pconcurrencia) ? $pconcurrencia : 'Sin dato' . '%' ?>
                                    </td>
                                    <td>
                                        <?php echo isset($row_padron_disp['telefono']) && !empty($row_padron_disp['telefono']) ? $row_padron_disp['telefono'] : 'Sin datos'; ?>
                                    </td>
                                    <!-- <td><?php echo $row_padron_disp['correo']; ?></td> -->
                                    <td>
                                        <?php echo isset($row_padron_disp['sector']) && !empty($row_padron_disp['sector']) ? $row_padron_disp['sector'] : 'Sin datos'; ?>
                                    </td>
                                    <td>
                                        <?php echo isset($row_padron_disp['descrip_recinto']) && !empty($row_padron_disp['descrip_recinto']) ? $row_padron_disp['descrip_recinto'] : 'Sin datos' ?>
                                    </td>
                                    <td>
                                        <?php echo isset($row_padron_disp['cod_colegio']) && !empty($row_padron_disp['cod_colegio']) ? $row_padron_disp['cod_colegio'] : 'Sin datos' ?>
                                    </td>
                                    <td>
                                        <a href="/edit-registro?cedula=<?php echo $row_padron_disp['cedula'] . '&telefono=' . $row_padron_disp['telefono'] ?>"
                                            class="btn btn-success mb-2" style=""> <i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="/public/index.php?action=deluser&cedula=<?php echo $row_padron_disp['cedula'] ?>"
                                            class="btn btn-danger mb-2" style=""><i
                                                class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            </form>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>


<?php include_once __DIR__ . '/../../includes/footer.php' ?>