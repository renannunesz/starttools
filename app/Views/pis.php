<!DOCTYPE html>
<html lang="pt">

<head>

    <title>Start Tools</title>
    <link rel="icon" type="image/x-icon" href='<?php echo base_url() . "/assets/logo_tools.ico"; ?>'>

    <script>
        var time = new Date().getTime();
    </script>

    <!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="../assets/theme/vendor/bootstrap/css/bootstrap.min.css">

    <!-- Custom fonts for this template-->
    <link href="../assets/theme/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="../assets/theme/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/theme/css/sb-admin.css" rel="stylesheet">


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
                    <li class="breadcrumb-item active"> <?php echo $tipopi == '1' ? "Lançados" : "Baixados"; ?></li>
                </ol>

                <div class="d-flex justify-content-start">

                    <div class="w-100 m-2">

                        <div>

                            <h3 class="h3">Pedidos de Inserção - <?php echo $tipopi == '1' ? '<i class="fas fa-fw fa-pen"></i> Lançados' : '<i class="fas fa-fw fa-check-double"></i> Baixados'; ?></h3>

                            <hr>

                            <div id="cardfilter" class="p-1">

                                <?php

                                include 'card_filters.php';

                                include 'card_dados.php';

                                ?>

                            </div>

                            <div id="tbpis" class="pb-1 mb-1">

                                <?php $tipopi == '1' ? include 'table_lancados.php' : include 'table_baixados.php'; ?>

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
    <script src="../assets/theme/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/theme/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/theme/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="../assets/theme/vendor/chart.js/Chart.min.js"></script>
    <script src="../assets/theme/vendor/datatables/jquery.dataTables.js"></script>
    <script src="../assets/theme/vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/theme/js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="../assets/theme/js/demo/datatables-demo.js"></script>
    <script src="../assets/theme/js/demo/chart-area-demo.js"></script>

</body>

</html>

<script>
    function showLoad() {
        document.getElementById("carregando").style.display = "block";
    }

    $(document).ready(function() {

        time = (new Date().getTime()) - time;

        $('#carregando').delay(time).fadeOut("slow");

    });
</script>