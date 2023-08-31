<!DOCTYPE html>
<html lang="pt">

<head>

    <title>Start Tools</title>
    <link rel="icon" type="image/x-icon" href='<?php echo base_url() . "/assets/logo_tools.ico"; ?>'>

    <!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="assets/theme/vendor/bootstrap/css/bootstrap.min.css">

    <!-- Custom fonts for this template-->
    <link href="assets/theme/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="assets/theme/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/theme/css/sb-admin.css" rel="stylesheet">


</head>

<body id="page-top">

    <?php include 'navbar.php'; ?>

    <div id="wrapper">

        <?php include 'sidebar.php'; ?>

        <div id="content-wrapper">

            <div class="container-fluid">

                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">P.I.s</a>
                    </li>
                    <li class="breadcrumb-item active"> Início </li>
                </ol>

                <div class="d-flex justify-content-start">

                    <div class="w-100 m-2">

                        <div>

                            <div id="" class="p-1">

                                <div class="row d-flex justify-content-center">

                                    <div class="col-xl-6 col-sm-6 mb-3">
                                        <div class="card text-white bg-primary o-hidden h-100">
                                            <div class="card-body">
                                                <div class="card-body-icon">
                                                    <i class="fas fa-fw fa-city"></i>
                                                </div>
                                                <div class="mr-5">
                                                    <h3> A. de O. Viana </h3>
                                                </div>
                                            </div>

                                            <div class="card text-dark">
                                                <div class="card-header">
                                                    <strong>Pedidos de Inserção</strong>
                                                </div>
                                                <div class="card-body">
                                                    <div class="alert alert-info" role="alert">
                                                        <a href='<?php echo base_url('/PI/pisLancados'); ?>' class="alert-link">Lançados: </a>. <?php echo count($pisLancados_adeo); ?>
                                                    </div>
                                                    <div class="alert alert-success" role="alert">
                                                        <a href='<?php echo base_url('/PI/pisBaixados'); ?>' class="alert-link">Baixados: </a>. <?php echo count($pisBaixados_adeo); ?>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="">Info: Dados atuais, com base na data de hoje, <?php echo date('d-m-Y'); ?>.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer text-white clearfix small z-1">
                                                <span class="float-left">
                                                    Dados Empresa
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-sm-6 mb-3">
                                        <div class="card text-white bg-warning o-hidden h-100">
                                            <div class="card-body">
                                                <div class="card-body-icon">
                                                    <i class="fas fa-fw fa-city"></i>
                                                </div>
                                                <div class="mr-5">
                                                    <h3> Parametro Agência de Noticias </h3>
                                                </div>
                                            </div>

                                            <div class="card text-dark">
                                                <div class="card-header">
                                                    <strong>Pedidos de Inserção</strong>
                                                </div>
                                                <div class="card-body">
                                                    <div class="alert alert-info" role="alert">
                                                        <a href='<?php echo base_url('/PI/pisLancados'); ?>' class="alert-link">Lançados: </a>. <?php echo count($pisLancados_parametro); ?>
                                                    </div>
                                                    <div class="alert alert-success" role="alert">
                                                        <a href='<?php echo base_url('/PI/pisBaixados'); ?>' class="alert-link">Baixados: </a>. <?php echo count($pisBaixados_parametro); ?>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="">Info: Dados atuais, com base na data de hoje, <?php echo date('d-m-Y'); ?>.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer text-white clearfix small z-1">
                                                <span class="float-left">
                                                    Dados Empresa
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <?php include 'footer.php'; ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Bootstrap core JavaScript-->
        <script src="assets/theme/vendor/jquery/jquery.min.js"></script>
        <script src="assets/theme/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="assets/theme/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Page level plugin JavaScript-->
        <script src="assets/theme/vendor/chart.js/Chart.min.js"></script>
        <script src="assets/theme/vendor/datatables/jquery.dataTables.js"></script>
        <script src="assets/theme/vendor/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="assets/theme/js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="assets/theme/js/demo/datatables-demo.js"></script>
        <script src="assets/theme/js/demo/chart-area-demo.js"></script>

</body>

</html>

<script>

</script>