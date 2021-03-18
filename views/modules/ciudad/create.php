<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Controllers\UsuariosController;
use App\Models\GeneralFunctions;
use Carbon\Carbon;

$nameModel = "Usuario";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Crear <?= $nameModel ?></title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>

  2
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Crear una nueva Ciudad <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Crear</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensaje de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información de la ciudad <?= $nameModel ?></h3>
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
                            <div class="card-body">
                                <!-- form start -->
                                <form class="form-horizontal" enctype="multipart/form-data" method="post" id="frmCreate<?= $nameModel ?>"
                                      name="frmCreate<?= $nameModel ?>"
                                      action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=create">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group row">
                                                <label for="id" class="col-sm-2 col-form-label">Id</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="id" name="id"
                                                           placeholder="Ingrese el Id" value="<?= $frmSession['id'] ?? '' ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label">Departamento</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="departamento"
                                                           name="departamento" placeholder="Ingrese el departamento"
                                                           value="<?= $frmSession['departamento'] ?? '' ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="nombre_ciudad" class="col-sm-2 col-form-label">Nombre Ciudad</label>
                                                <div class="col-sm-10">
                                                    <input required type="number" minlength="6" class="form-control"
                                                           id="nombre_ciudad" name="nombre_ciudad" placeholder="Ingrese el nombre de la ciudad"
                                                           value="<?= $frmSession['nombre_ciudad'] ?? '' ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="cod_dane" class="col-sm-2 col-form-label">Codigo Dane</label>
                                                <div class="col-sm-10">
                                                    <input required type="number" minlength="6" class="form-control"
                                                           id="cod_dane" name="cod_dane" placeholder="Ingrese Codigo Dane"
                                                           value="<?= $frmSession['cod_dane'] ?? '' ?>">
                                                </div>
                                            </div>


                                                <div class="form-group row">
                                                    <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                    <div class="col-sm-10">
                                                        <select required id="estado" name="estado" class="custom-select">
                                                            <option <?= ( !empty($frmSession['estado']) && $frmSession['estado'] == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                            <option <?= ( !empty($frmSession['estado']) && $frmSession['estado'] == "Inactivo") ? "selected" : ""; ?> value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="ciudad_id" class="col-sm-2 col-form-label">Ciudad</label>
                                                    <div class="col-sm-5">
                                                        <?= CiudadController::selectCiudad(false,
                                                            true,
                                                            'ciudad_id',
                                                            'ciudad_id',
                                                            '15', //Sogamoso
                                                            'form-control select2bs4 select2-info',
                                                            "estado = 'Activo'")
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-5 ">
                                                        <?= CiudadController::selectCiudad(false,
                                                            true,
                                                            'ciudad_id',
                                                            'ciudad_id',
                                                            (!empty($frmSession['ciudad_id'])) ? $frmSession['ciudad_id'] : '',
                                                            'form-control select2bs4 select2-info',
                                                            "ciudad_id = 15 and estado = 'Activo'")
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php  ?>
                                        </div>


                                    <hr>
                                    <button type="submit" class="btn btn-info">Enviar</button>
                                    <a href="index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                                    <!-- /.card-footer -->
                                </form>
                            </div>
                            <!-- /.card-body -->

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
<script>
    $(function() {
        $('#ciudad_id').on('change', function() {
            $.post("../../../app/Controllers/MainController.php?controller=Municipios&action=selectMunicipios", {
                isMultiple: false,
                isRequired: true,
                id: "ciudad_id",
                nombre: "ciudad_id",
                defaultValue: "",
                class: "form-control select2bs4 select2-info",
                where: "ciudad_id = "+$('#ciudad_id').val()+" and estado = 'Activo'",
                request: 'ajax'
            }, function(e) {
                if (e)
                    console.log(e);
                $("#ciudad_id").html(e).select2({ height: '100px'});
            });
        });
        $('.btn-file span').html('Seleccionar');
    });
</script>
</body>
</html>
