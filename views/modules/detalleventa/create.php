<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Controllers\ProductosController;
use App\Controllers\UsuariosController;
use App\Controllers\VentasController;
use App\Models\DetalleVentas;
use App\Models\GeneralFunctions;
use Carbon\Carbon;

$nameModel = "DetalleVenta";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;
?>

<?php
$dataVenta = null;
if (!empty($_GET['id'])) {
    $dataDetalleVenta = VentasController::searchForID(["id" => $_GET['id']]);
    if ($dataVenta->getestado() != "En progreso"){
        header('Location: index.php?respuesta=warning&mensaje=La venta ya ha finalizado');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Crear <?= $nameModel ?></title>
    <?php require("../../partials/head_imports.php"); ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-responsive/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-buttons/css/buttons.bootstrap4.css">
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Generar Mensaje de alerta -->
        <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Crear una nueva venta<?= $nameModel ?></h1>
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
            <div class="container-fluid">
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> &nbsp; Información del detalle de la venta
                                    <?= $nameModel ?></h3>
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

                            <div class="card-body">
                                <form class="form-horizontal" method="post" id="frmCreate<?= $nameModel ?>" name="frmCreate<?= $nameModel ?>"
                                      action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=create">
                                    <div class="form-group row">
                                        <label for="cliente_id" class="col-sm-4 col-form-label">Cliente</label>
                                        <div class="col-sm-8">
                                            <?= UsuariosController::selectUsuario(false,
                                                true,
                                                'cliente_id',
                                                'cliente_id',
                                                (!empty($dataDetalleVenta)) ? $dataDetalleVenta->getCliente()->getId() : '',
                                                'form-control select2bs4 select2-info',
                                                "rol = 'Cliente' and estado = 'Activo'")
                                            ?>
                                            <span class="text-info"><a href="../usuarios/create.php">Crear Cliente</a></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="empleado_id" class="col-sm-4 col-form-label">Empleado</label>
                                        <div class="col-sm-8">
                                            <?= UsuariosController::selectUsuario(false,
                                                true,
                                                'empleado_id',
                                                'empleado_id',
                                                (!empty($dataVenta)) ? $dataVenta->getEmpleado()->getId() : '',
                                                'form-control select2bs4 select2-info',
                                                "rol = 'Empleado' and estado = 'Activo'")
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($dataDetalleVenta)) {
                                        ?>
                                        <div class="form-group row">
                                            <label for="numero_serie" class="col-sm-4 col-form-label">Id_detalle_venta
                                                </label>
                                            <div class="col-sm-8">
                                                <?= $dataDetalleVenta->getid_detalle_venta() ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="numero" class="col-sm-4 col-form-label">cantidad
                                                </label>
                                            <div class="col-sm-8">
                                                <?= $dataVenta->getcantidad() ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="numero_serie" class="col-sm-4 col-form-label">Producto_id</label>
                                            <div class="col-sm-8">
                                                <?= $dataDetalleVenta->getproducto_id() ?>
                                            </div>
                                        </div>
                                    <div class="form-group row">
                                        <label for="numero_serie" class="col-sm-4 col-form-label">venta_id</label>
                                        <div class="col-sm-8">
                                            <?= $dataDetalleVenta->getventa_id() ?>
                                        </div>


                                    <?php } ?>
                                    <hr>
                                    <button type="submit" class="btn btn-info">Enviar</button>
                                    <a href="index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-8">
                        <div class="card card-lightblue">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-parachute-box"></i> &nbsp; DetalleVenta</h3>
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

                            <div class="card-body">
                                <?php if (!empty($_GET['id'])) { ?>
                                    <div class="row">
                                        <div class="col-auto mr-auto"></div>
                                        <div class="col-auto">
                                            <a role="button" href="#" data-toggle="modal" data-target="#modal-add-producto"
                                               class="btn btn-primary float-right"
                                               style="margin-right: 5px;">
                                                <i class="fas fa-plus"></i> Añadir detalle de venta
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col">
                                        <table id="tblVenta"
                                               class="datatable table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>id_detalle_venta</th>
                                                <th>cantidad</th>
                                                <th>producto_id</th>
                                                <th>venta_id</th>

                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (!empty($_GET['id'])) {
                                                $arrDetalleVenta = Venta::search("SELECT * FROM weber.venta WHERE venta_id = ".$_GET['id']);
                                                if(count($arrVenta) > 0) {
                                                    /* @var $arrDetalleVentas Venta[] */
                                                    foreach ($arrDetalleVentas as $Venta) {
                                                        ?>
                                                        <tr>
                                                            <td><?= $DetalleVenta->getid_detalle_venta(); ?></td>
                                                            <td><?= $DetalleVenta->getcantidad()->getcantidad(); ?></td>
                                                            <td><?= $Detalleventa->getproducto_id(); ?></td>
                                                            <td><?= $DetalleVenta->getventa_id(); ?></td>

                                                            <td>
                                                                <a href="edit.php?id=<?php echo $DetalleVenta->getId(); ?>"
                                                                   type="button" data-toggle="tooltip" title="Actualizar"
                                                                   class="btn docs-tooltip btn-primary btn-xs"><i
                                                                            class="fa fa-edit"></i></a>
                                                                <a href="show.php?id=<?php echo $DetalleVenta->getId(); ?>"
                                                                   type="button" data-toggle="tooltip" title="Ver"
                                                                   class="btn docs-tooltip btn-warning btn-xs"><i
                                                                            class="fa fa-eye"></i></a>
                                                                <a type="button"
                                                                   href="../../../app/Controllers/ProductosController.php?action=inactivate&Id=<?php echo $detalleVenta->getId(); ?>"
                                                                   data-toggle="tooltip" title="Eliminar"
                                                                   class="btn docs-tooltip btn-danger btn-xs"><i
                                                                            class="fa fa-times-circle"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                }
                                            }?>

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>id_detalle_venta</th>
                                                <th>cantidad</th>
                                                <th>producto_id</th>
                                                <th>venta_id</th>



                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <div id="modals">
        <div class="modal fade" id="modal-add-producto">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Producto a Venta</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="../../../app/Controllers/MainController.php?controller=DetalleVentas&action=create" method="post">
                        <div class="modal-body">
                            <?php //var_dump($dataVenta); ?>
                            <input id="ventas_id" name="ventas_id" value="<?= !empty($dataDetalleVenta) ? $dataDetalleVenta->getId() : ''; ?>" hidden
                                   required="required" type="text">
                            <div class="form-group row">
                                <label for="venta_id" class="col-sm-4 col-form-label">Detalleventa</label>
                                <div class="col-sm-8">
                                    <?= ProductosController::selectProducto(false,
                                        true,
                                        'producto_id',
                                        'producto_id',
                                        '',
                                        'form-control select2bs4 select2-info',
                                        "estado = 'Activo'")
                                    ?>
                                    <div id="divResultProducto">
                                        <span class="text-muted">Precio Base: </span> <span id="spPrecio"></span>,
                                        <span class="text-muted">Precio Venta: </span> <span id="spPrecioVenta"></span>,
                                        <span class="text-muted">Stock: </span> <span id="spStock"></span>.
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_detalle_venta" class="col-sm-4 col-form-label">id_detalle_venta</label>
                                <div class="col-sm-8">
                                    <input required type="number" min="1" class="form-control" step="1" id="id_detalle_venta" name="id_detalle_venta"
                                           placeholder="Ingrese el detalle de la venta">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cantidad" class="col-sm-4 col-form-label">cantidad</label>
                                <div class="col-sm-8">
                                    <input required readonly type="number" min="1" class="form-control" id="cantidad" name="cantidad"
                                           placeholder="0.0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="producto_id" class="col-sm-4 col-form-label">producto_id</label>
                                <div class="col-sm-8">
                                    <input required readonly type="number" min="1" class="form-control" id="producto_id" name="producto_id"
                                           placeholder="0.0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="venta_id" class="col-sm-4 col-form-label">venta_id</label>
                            <div class="col-sm-8">
                                <input required readonly type="number" min="1" class="form-control" id="venta_id" name="venta_id"
                                       placeholder="0.0">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

    <?php require('../../partials/footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php require('../../partials/scripts.php'); ?>
<!-- Scripts requeridos para las datatables -->
<?php require('../../partials/datatables_scripts.php'); ?>

<script>

    $(function () {

        $("#divResultDetalleVenta").hide();

        $('#id_detalle_venta').on('select2:select', function (e) {
            var dataSelect = e.params.data;
            var dataProducto = null;
            if(dataSelect.id !== ""){
                $.post("../../../app/Controllers/MainController.php?controller=Productos&action=searchForID",
                    {
                        id: dataSelect.id,
                        request: 'ajax'
                    }, "json"
                )
                .done(function( resultDetalleVenta ) {
                    dataDetalleVenta = resultDetalleVenta;
                })
                .fail(function(err) {
                    console.log( "Error al realizar la consulta"+err );
                })
                .always(function() {
                    updateDataDetalleVenta(dataDetalleVenta);
                });
            }else{
                updateDataDetalleVenta(dataDetalleVenta);
            }
        });

        function updateDataProducto(dataDetalleVenta){
            if(dataDetalleVenta !== null){
                $("#divid_detalle_venta").slideDown();
                $("#spcantidad").html("$"+dataDetalleVenta.cantidad);
                $("#sproducto_id").html("$"+dataDetalleVenta.producto_id);
                $("#venta_id").html(dataDetalleVenta.venta_id+" Unidad(es)");


                ;
            }else{
                $("#divid_detalle_venta").slideUp();
                $("#spcantidad").html("");
                $("#spproducto_id").html("");
                $("#spventa_id").html("");

               ');
            }
        }

        $( "#id_detalle_venta" ).on( "change keyup focusout", function() {
            $("#cantidad").val($( "#producto_id" ).val() *  $("#venta_id").val());
        });

    });
</script>


</body>
</html>
