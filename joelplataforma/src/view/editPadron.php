<?php
if (isset($_GET['cedula']) && isset($_GET['telefono'])) {
    $cedulaAfil = $_GET['cedula'];
    $telefono = $_GET['telefono'];

}

include_once __DIR__ . '/../../includes/menu.php';

?>

<div id="page-wrapper">
    <div class="container-fluid">
        
        <div class="card text-bg-dark border-light my-5 mx-auto" style="width:30rem">
            <div class="card-body p-5">
                <form action="/public/index.php?action=editpc" class="" method="post">
                    <div class="mb-3">
                        <h2>Editar afiliado</h2>
                    </div>
                    <div class="mb-3">
                        <div class=""><input type="text" class="form-control bg-transparent text-white" id="cedula-afil"
                                name="cedula-afil" placeholder="Cedula del afiliado" value="<?php if (isset($cedulaAfil))
                                    echo $cedulaAfil; ?>" readonly></div>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control bg-transparent text-white" id="tel-afil" name="tel-afil"
                            placeholder="Telefono del afiliado" value="<?php if (isset($cedulaAfil))
                                echo $telefono; ?>">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control bg-transparent text-white" id="" name="correo-afil" placeholder="Correo del afiliado">
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-primary btn-block" name="edit-afil">Editar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>