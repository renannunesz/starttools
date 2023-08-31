<!DOCTYPE html>
<html lang="pt">

<head>

    <title>Start Tools</title>
    <link rel="icon" type="image/x-icon" href='<?php

                                                use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

                                                echo base_url() . "/assets/logo_tools.ico"; ?>'>

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
                    <li class="breadcrumb-item active"> Comissões </li>
                </ol>

                <div class="d-flex justify-content-start">

                    <div class="w-100 m-2">

                        <div>

                            <h3 class="h3">Pedidos de Inserção - <i class="fas fa-fw fa-file-invoice-dollar"></i> Comissões </h3>

                            <hr>

                            <div id="cardfilter" class="p-1">

                                <div class="card mt-10">

                                    <div class="card-header text-white" style="background-color:#F27F3D">
                                        <strong>P.I.s Comissões - Jornal Agora RN</strong>
                                    </div>

                                    <div class="card-body">

                                        <form method="POST" action='<?php echo base_url('/PI/pisComissoes'); ?>' name="formFiltros" id="formFiltros">

                                            <div class="row g-3 align-items-center mb-2">

                                                <div class="col">
                                                    <label for="datainicio" class="col-form-label">Inicio:</label>
                                                    <input type="date" class="form-control" name="dataPIini" id="dataPIini" value="<?php echo isset($inputdataini) ? $inputdataini : date('Y-m-d'); ?>">
                                                </div>

                                                <div class="col">
                                                    <label for="datafim" class="col-form-label">Fim:</label>
                                                    <input type="date" class="form-control" name="dataPIfim" id="dataPIfim" value="<?php echo isset($inputdatafim) ? $inputdatafim : date('Y-m-d'); ?>">
                                                </div>

                                                <div class="col">
                                                    <label for="data" class="col-form-label">Empresa:</label>
                                                    <select class="custom-select" aria-label="Default select example" name="empresaPI" id="empresaPI" required>
                                                        <option value="">-</option>
                                                        <option value=2>A. de O. Viana</option>
                                                        <option value=1>Parametro Agência de Noticias</option>
                                                    </select>
                                                </div>

                                                <div class="col">
                                                    <div class="row">
                                                        <label for="data" class="col-form-label">Opções:</label>
                                                    </div>
                                                    <div class="row">
                                                        <div>
                                                            <button class="btn btn-sm btn-primary" type="submit" value="Filtrar" name="filtrar" id="filtrar" onclick="showLoad()">
                                                                <i class="fas fa-fw fa-search"></i>
                                                                <span>Buscar</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </form>

                                        <div class="">
                                            <a href='<?php echo base_url('/PI/expComissoes'); ?>'>
                                                <button class="btn btn-sm btn-success" type="submit" value="Filtrar" name="filtrar" id="filtrar" onclick="showLoad()">
                                                    <i class="fas fa-fw fa-file-excel"></i>
                                                    <span>Exportar</span>
                                                </button>
                                            </a>
                                        </div>

                                    </div>

                                </div>

                                <div class="mt-3">

                                    <!-- Icon Cards-->
                                    <?php $inputempresa == 1 ? $nomeEmpresa = "Parâmetro" : $nomeEmpresa = "A. de O. Viana"; ?>
                                    <div class="row">

                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <div class="card text-white bg-primary o-hidden h-100">
                                                <div class="card-body">
                                                    <div class="card-body-icon">
                                                        <i class="fas fa-fw fa-city"></i>
                                                    </div>
                                                    <div class="mr-5">
                                                        <h3><?php echo $nomeEmpresa; ?></h3>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-white clearfix small z-1">
                                                    <span class="float-left">
                                                        <?php echo count($dados_pi) . " PIs "; ?>
                                                        <?php echo " Inicio: " . implode("/", array_reverse(explode("-", $inputdataini))) . " Fim: " . implode("/", array_reverse(explode("-", $inputdatafim))); ?>
                                                        <?php echo " Total Liq: " . number_format($vl_total, 2, ',', '.'); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <div class="card text-white bg-warning o-hidden h-100">
                                                <div class="card-body">
                                                    <div class="card-body-icon">
                                                        <i class="fas fa-fw fa-hand-holding-usd"></i>
                                                    </div>
                                                    <div class="mr-5">
                                                        <h3><?php echo number_format($vca_total, 2, ',', '.') . " R$"; ?></h3>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-white clearfix small z-1">
                                                    <span class="float-left">Comissão Agência</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <div class="card text-white bg-success o-hidden h-100">
                                                <div class="card-body">
                                                    <div class="card-body-icon">
                                                        <i class="fas fa-fw fa-file-invoice-dollar"></i>
                                                    </div>
                                                    <div class="mr-5">
                                                        <h3><?php echo number_format($vcr_total, 2, ',', '.') . " R$"; ?></h3>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-white clearfix small z-1">
                                                    <span class="float-left">Comissão Representante</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <div class="card text-white bg-info o-hidden h-100">
                                                <div class="card-body">
                                                    <div class="card-body-icon">
                                                        <i class="fas fa-fw fa-comment-dollar"></i>
                                                    </div>
                                                    <div class="mr-5">
                                                        <h3><?php echo number_format($vcv_total, 2, ',', '.') . " R$"; ?></h3>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-white clearfix small z-1">
                                                    <span class="float-left">Comissão Vendedor</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div id="tbpis" class="pb-1 mb-1">

                                <div class="table-responsive">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" name='grid_comissoes'>

                                        <thead class="text-bg-secondary align-middle ">
                                            <tr>
                                                <th scope="col">PI</th>
                                                <th scope="col">Venda</th>
                                                <th scope="col">Liberação</th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Vendedor</th>
                                                <th scope="col">Valor Liquido</th>
                                                <th scope="col">Comissão Agência</th>
                                                <th scope="col">Comissão Representante</th>
                                                <th scope="col">Comissão Vendedor</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-group-divider">

                                            <?php foreach ($dados_pi as $pi) : ?>

                                                <tr>
                                                    <td scope="row"><?php echo $pi['nr_pi']; ?></td>
                                                    <td scope="row"><?php echo $pi['data_da_venda']; ?></td>
                                                    <td scope="row"><?php echo $pi['data_liberacao']; ?></td>
                                                    <td scope="row"><?php echo $pi['cliente']; ?></td>
                                                    <td scope="row"><?php echo $pi['vendedor']; ?></td>
                                                    <td scope="row"><?php echo $pi['valor_liquido']; ?></td>
                                                    <td scope="row"><?php echo $pi['comissao_agencia']; ?></td>
                                                    <td scope="row"><?php echo $pi['comissao_representante']; ?></td>
                                                    <td scope="row"><?php echo $pi['comissao_vendedor']; ?></td>
                                                </tr>

                                            <?php endforeach; ?>

                                        </tbody>

                                    </table>

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