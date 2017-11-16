<?php
define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');
include(root . 'includes/head.php');
include(root . 'includes/funciones.php');
?>

<body>
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

                <!-- start: page -->
                <div class="row">
                    <!-- INICIO SECCION REPORTE-->
                    <section class="panel">
                        <header class="panel-heading ">
                            <div class="panel-actions">
                            </div>
                            <h2 class="panel-title">Reportes</h2>
                        </header>
                        <div class="panel-body">
                            <?php include(root . 'includes/reporte/verReporteForm.php'); ?>
                            <div class="table-responsive">                                
                                <div id="verReporte"></div>
                            </div>
                        </div>
                    </section>
                    <!-- FIN SECCION REPORTE-->
                </div>
                <!-- end: page -->
            </section>
        </div>

    </section>
    <?php include(root . 'includes/footer.php'); ?>