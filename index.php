<?php
define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');
include(root . 'includes/head.php');
include(root . 'includes/funciones.php');
?>

<body onload="cargarDatos()">
    <section class="body">

        <!-- start: header -->
        <?php include(root . 'includes/menu_usuario.php'); ?>
        <!-- end: header -->

        <div class="inner-wrapper">
            <!-- start: sidebar -->
            <?php include(root . 'includes/side_bar.php'); ?>
            <!-- end: sidebar -->

            <section role="main" class="content-body">
                <header class="page-header">
                    <h2>Escritorio</h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="index.php">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li><span>Escritorio</span></li>
                        </ol>

                        <a class="sidebar-right-toggle" data-open="sidebar-right"></a>
                    </div>
                    <div class="col-lg-12" id="info"></div>
                </header>
                <?php if ($_SESSION['MS_USER_ROL_ID'] == 1) { ?>
                    <!-- INICIO SECCION REPORTES-->
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-primary">
                                                <i class="fa fa-bar-chart"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">Reportes</h4>
                                            </div>
                                            <div class="summary-footer">
                                                <a href = "reporte.php" class="btn btn-info">VER</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>                
                    <!-- FIN SECCION REPORTES-->

                    <!-- start: page -->
                    <div class="row">
                        <div class="row">
                            <!-- INICIO SECCION PEDIDOS-->
                            <section class="panel col-md-6 panel-collapsed">
                                <header class="panel-heading ">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action" data-toggle = "modal" data-target = "#modal_agregarPedido"><i class="fa fa-plus"></i></a>
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>

                                    <h2 class="panel-title">Trabajos pendientes</h2>
                                </header>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-none">
                                            <tbody>
                                            <div id="verPedido"></div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                        
                                <?php
                                include(root . 'includes/pedido/entregarPedidoForm.php');
                                include(root . 'includes/pedido/crearPedidoForm.php');
                                include(root . 'includes/pedido/modificarPedidoForm.php');
                                ?>
                            </section>
                            <!-- INICIO SECCION CLIENTES-->
                            <section class="panel col-md-6 panel-collapsed">
                                <header class="panel-heading ">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action" data-toggle = "modal" data-target = "#modal_agregarCliente"><i class="fa fa-plus"></i></a>
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>

                                    <h2 class="panel-title">Clientes</h2>
                                </header>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-none">
                                            <tbody>
                                            <div id="verCliente"></div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                include(root . 'includes/cliente/crearClienteForm.php');
                                include(root . 'includes/cliente/modificarClienteForm.php');
                                include(root . 'includes/cliente/eliminarClienteForm.php');
                                ?>
                            </section>
                            <!-- FIN SECCION CLIENTES-->
                        </div>
                        <!-- FIN SECCION PEDIDOS-->

                        <!-- INICIO SECCION PRODUCTO-->
                        <div class="row">

                            <!-- INICIO SECCION FUNCIONARIOS-->
                            <section class="panel col-md-6 panel-collapsed">
                                <header class="panel-heading ">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>

                                    <h2 class="panel-title">Funcionarios</h2>
                                </header>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-none">
                                            <tbody>
                                            <div id="verFuncionario"></div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                            <!-- FIN SECCION FUNCIONARIOS-->

                            <section class = "panel col-md-6 panel-collapsed">
                                <header class = "panel-heading ">
                                    <div class = "panel-actions">
                                        <a href="#" class="panel-action panel-action" data-toggle = "modal" data-target = "#agregarProducto"><i class="fa fa-plus"></i></a>
                                        <a href = "#" class = "panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>
                                    <h2 class = "panel-title">Productos</h2>
                                </header>
                                <div class = "panel-body">
                                    <div class = "table-responsive">
                                        <table class = "table table-striped mb-none">
                                            <tbody>
                                            <div id="verProducto"></div> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                include(root . 'includes/producto/crearProductoForm.php');
                                include(root . 'includes/producto/modificarProductoForm.php');
                                include(root . 'includes/producto/eliminarProductoForm.php');
                                ?>
                            </section>
                            <!-- FIN SECCION PRODUCTO-->
                        </div>

                        <div class="row">

                            <!-- INICIO SECCION MARCAS-->
                            <section class = "panel col-md-6 panel-collapsed">
                                <header class = "panel-heading ">
                                    <div class = "panel-actions">
                                        <a href="#" class="panel-action panel-action" data-toggle = "modal" data-target = "#modal_agregarMarca"><i class="fa fa-plus"></i></a>
                                        <a href = "#" class = "panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>
                                    <h2 class = "panel-title">Marcas</h2>
                                </header>
                                <div class = "panel-body">
                                    <div class = "table-responsive">
                                        <table class = "table table-striped mb-none">
                                            <tbody>
                                            <div id="verMarca"></div> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                include(root . 'includes/producto/marca/crearMarcaForm.php');
                                include(root . 'includes/producto/marca/modificarMarcaForm.php');
                                include(root . 'includes/producto/marca/eliminarMarcaForm.php');
                                ?>
                            </section>
                            <!-- FIN SECCION MARCAS-->

                            <!-- INICIO SECCION CATEGORIAS-->
                            <section class = "panel col-md-6 panel-collapsed">
                                <header class = "panel-heading ">
                                    <div class = "panel-actions">
                                        <a href="#" class="panel-action panel-action" data-toggle = "modal" data-target = "#modal_agregarCategoria"><i class="fa fa-plus"></i></a>
                                        <a href = "#" class = "panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>
                                    <h2 class = "panel-title">Categorías</h2>
                                </header>
                                <div class = "panel-body">
                                    <div class = "table-responsive">
                                        <table class = "table table-striped mb-none">
                                            <tbody>
                                            <div id="verCategoria"></div> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                include(root . 'includes/producto/categoria/crearCategoriaForm.php');
                                include(root . 'includes/producto/categoria/modificarCategoriaForm.php');
                                include(root . 'includes/producto/categoria/eliminarCategoriaForm.php');
                                ?>
                            </section>
                            <!-- FIN SECCION CATEGORIAS-->
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="row">
                            <!-- INICIO SECCION PEDIDOS-->
                            <br>
                            <section class="panel col-md-12">
                                <header class="panel-heading ">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action" data-toggle = "modal" data-target = "#modal_agregarPedido"><i class="fa fa-plus"></i></a>
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>

                                    <h2 class="panel-title">Trabajos pendientes</h2>
                                </header>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-none">
                                            <tbody>
                                            <div id="verPedido"></div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                        
                                <?php
                                include(root . 'includes/pedido/crearPedidoForm.php');
                                include(root . 'includes/pedido/modificarPedidoForm.php');
                                include(root . 'includes/pedido/eliminarPedidoForm.php');
                                ?>
                            </section>
                            <!-- INICIO SECCION CLIENTES-->
                            <section class="panel col-md-12">
                                <header class="panel-heading ">
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action" data-toggle = "modal" data-target = "#modal_agregarCliente"><i class="fa fa-plus"></i></a>
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                    </div>

                                    <h2 class="panel-title">Clientes</h2>
                                </header>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-none">
                                            <tbody>
                                            <div id="verCliente"></div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                include(root . 'includes/cliente/crearClienteForm.php');
                                include(root . 'includes/cliente/modificarClienteForm.php');
                                include(root . 'includes/cliente/eliminarClienteForm.php');
                                ?>
                            </section>
                            <!-- FIN SECCION CLIENTES-->
                        </div>
                        <!-- FIN SECCION PEDIDOS-->

                    </div>
                <?php } ?>
            </section>
        </div>

    </section>
    <?php include(root . 'includes/footer.php'); ?>