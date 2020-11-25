<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/UsuariosController.php");

use App\Controllers\UsuariosController;
use Carbon\Carbon; ?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE']  ?> | Editar Ciudad</title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar Nueva ciudad</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/Views/">BDobleA</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <?php if (!empty($_GET['respuesta'])) { ?>
                <?php if ($_GET['respuesta'] == "error") { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        Error al crear la ciudad: <?= ($_GET['mensaje']) ?? "" ?>
                    </div>
                <?php } ?>
            <?php } else if (empty($_GET['id'])) { ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    Faltan criterios de busqueda <?= ($_GET['mensaje']) ?? "" ?>
                </div>
            <?php } ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i>&nbsp; Información de la ciudad</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                            data-source="create.php" data-source-selector="#card-refresh-content"
                                            data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                            class="fas fa-expand"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <?php if (!empty($_GET["id"]) && isset($_GET["id"])) { ?>
                                <p>
                                <?php
                                $DataCiudad= CiudadController::searchForID($_GET["id"]);
                                if (!empty($DataCiudad)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" method="post" id="frmEditCiudad"
                                              name="frmEditUsuario"
                                              action="../../../app/Controllers/UsuariosController.php?action=edit">
                                            <input id="id" name="id" value="<?php echo $DataCiudad->getId(); ?>" hidden
                                                   required="required" type="text">

                                            <div class="form-group row">
                                                <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="nombres"
                                                           name="nombres" value="<?= $DataCiudad->getNombres(); ?>"
                                                           placeholder="Ingrese sus nombres">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="apellidos"
                                                           name="apellidos" value="<?= $DataUsuario->getApellidos(); ?>"
                                                           placeholder="Ingrese sus apellidos">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tipo_documento" class="col-sm-2 col-form-label">Tipo
                                                    Documento</label>
                                                <div class="col-sm-10">
                                                    <select id="tipo_documento" name="tipo_documento"
                                                            class="custom-select">
                                                        <option <?= ($DataUsuario->getTipoDocumento() == "C.C") ? "selected" : ""; ?>
                                                            value="C.C">Cedula de Ciudadania
                                                        </option>
                                                        <option <?= ($DataUsuario->getTipoDocumento() == "T.I") ? "selected" : ""; ?>
                                                            value="T.I">Tarjeta de Identidad
                                                        </option>
                                                        <option <?= ($DataUsuario->getTipoDocumento() == "R.C") ? "selected" : ""; ?>
                                                            value="R.C">Registro Civil
                                                        </option>
                                                        <option <?= ($DataUsuario->getTipoDocumento() == "Pasaporte") ? "selected" : ""; ?>
                                                            value="Pasaporte">Pasaporte
                                                        </option>
                                                        <option <?= ($DataUsuario->getTipoDocumento() == "C.E") ? "selected" : ""; ?>
                                                            value="C.E">Cedula de Extranjeria
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="documento" class="col-sm-2 col-form-label">Documento</label>
                                                <div class="col-sm-10">
                                                    <input required type="number" minlength="6" class="form-control"
                                                           id="documento" name="documento"
                                                           value="<?= $DataUsuario->getDocumento(); ?>"
                                                           placeholder="Ingrese su documento">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                                                <div class="col-sm-10">
                                                    <input required type="number" minlength="6" class="form-control"
                                                           id="telefono" name="telefono"
                                                           value="<?= $DataUsuario->getTelefono(); ?>"
                                                           placeholder="Ingrese su telefono">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="direccion" class="col-sm-2 col-form-label">Direccion</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="direccion"
                                                           name="direccion" value="<?= $DataUsuario->getDireccion(); ?>"
                                                           placeholder="Ingrese su direccion">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="fecha_nacimiento" class="col-sm-2 col-form-label">Fecha Nacimiento</label>
                                                <div class="col-sm-10">
                                                    <input required type="date" max="<?= Carbon::now()->subYear(12)->format('Y-m-d') ?>"
                                                           value="<?= $DataUsuario->getFechaNacimiento()->toDateString(); ?>" class="form-control" id="fecha_nacimiento"
                                                           name="fecha_nacimiento" placeholder="Ingrese su Fecha de Nacimiento">
                                                </div>
                                            </div>
                                            <?php if ($_SESSION['UserInSession']['rol'] == 'Administrador'){ ?>
                                                <div class="form-group row">
                                                    <label for="user" class="col-sm-2 col-form-label">Usuario</label>
                                                    <div class="col-sm-10">
                                                        <input required type="text" class="form-control" id="user" name="user" value="<?= $DataUsuario->getUser(); ?>" placeholder="Ingrese su Usuario">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                                    <div class="col-sm-10">
                                                        <input required type="password" class="form-control" id="password" name="password" value="<?= $DataUsuario->getPassword(); ?>" placeholder="Ingrese su Password">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="rol" class="col-sm-2 col-form-label">Rol</label>
                                                    <div class="col-sm-10">
                                                        <select id="rol" name="rol" class="custom-select">
                                                            <option <?= ($DataUsuario->getRol() == "Administrador") ? "selected" : ""; ?> value="Administrador">Administrador</option>
                                                            <option <?= ($DataUsuario->getRol() == "Empleado") ? "selected" : ""; ?> value="Empleado">Empleado</option>
                                                            <option <?= ($DataUsuario->getRol() == "Cliente") ? "selected" : ""; ?> value="Cliente">Cliente</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                    <div class="col-sm-10">
                                                        <select id="estado" name="estado" class="custom-select">
                                                            <option <?= ($DataUsuario->getEstado() == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                            <option <?= ($DataUsuario->getEstado() == "Inactivo") ? "selected" : ""; ?> value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <hr>
                                            <button type="submit" class="btn btn-info">Enviar</button>
                                            <a href="index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                                        </form>
                                    </div>
                                    <!-- /.card-body -->

                                <?php } else { ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                        No se encontro ningun registro con estos parametros de
                                        busqueda <?= ($_GET['mensaje']) ?? "" ?>
                                    </div>
                                <?php } ?>
                                </p>
                            <?php } ?>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require('../../partials/footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php require('../../partials/scripts.php'); ?>
</body>
</html>

