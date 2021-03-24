<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/ProductosController.php");

use App\Controllers\CategoriasController;
use App\Controllers\ProductosController;
use App\Models\GeneralFunctions;
use App\Models\Productos;
use Carbon\Carbon;

$nameModel = "Detalleventa";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Editar <?= $nameModel ?></title>
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
                        <h1>Editar <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Editar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensajes de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <?= (empty($_GET['id'])) ? GeneralFunctions::getAlertDialog('error', 'Faltan Criterios de Búsqueda') : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-box"></i>&nbsp; Información del detalle de la  venta<?= $nameModel ?></h3>
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
                                $DataDetalleVenta= ProductosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataDetalleVenta DetalleVenta */
                                if (!empty($DataDetalleVenta)) {
                                    ?>
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form class="form-horizontal" method="post" id="frmEdit<?= $nameModel ?>"
                                              name="frmEdit<?= $nameModel ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $DataDetalleVenta->getId(); ?>"
                                                   hidden required="required" type="text">
                                            <div class="form-group row">
                                                <label for="id_venta" class="col-sm-2 col-form-label">id_venta</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="id_venta"
                                                           name="nombre" value="<?= $DataDetalleVenta->getid_detalle_venta(); ?>"
                                                           placeholder="Ingrese el id de la venta">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="cantidad" class="col-sm-2 col-form-label">cantidad</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="cantidad"
                                                           name="cantidad" value="<?= $DataDetalleVenta->getcantidad(); ?>"
                                                           placeholder="Ingrese la cantidad">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="producto_id" class="col-sm-2 col-form-label">producto_id</label>
                                                <div class="col-sm-10">
                                                    <input required type="number" min="1" step="0.1" class="form-control" id="producto_id" name="producto_id"
                                                           value="<?= $DataDetalleVenta->getproducto_id(); ?>" placeholder="Ingrese el producto id ">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="venta_id" class="col-sm-2 col-form-label">venta_id</label>
                                                <div class="col-sm-10">
                                                    <input required type="number" min="1" step="0.1" class="form-control" id="venta_id" name="venta_id"
                                                           value="<?= $DataDetalleVenta->getventa_id(); ?>" placeholder="Ingrese el id de la venta ">

                                                </div>

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
