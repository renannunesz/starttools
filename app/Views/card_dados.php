<div class="mt-3">

    <div class="mt-3">

        <!-- Icon Cards-->
        <?php $inputempresa == 1 ? $nomeEmpresa = "Parâmetro" : $nomeEmpresa = "A. de O. Viana"; ?>
        <div class="row d-flex justify-content-center">

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-info o-hidden h-100">
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
                            Empresa
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-info o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-calendar-alt"></i>
                        </div>
                        <div class="mr-5">
                            <h4><?php echo " Inicio: " . implode("/", array_reverse(explode("-", $inputdataini))) . "<br> Fim: " . implode("/", array_reverse(explode("-", $inputdatafim))); ?> </h4>
                        </div>
                    </div>
                    <div class="card-footer text-white clearfix small z-1">
                        <span class="float-left">Periodo</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-info o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-clipboard-list"></i>
                        </div>
                        <div class="mr-5">
                            <h3><?php echo count($dados_pi) . " PIs "; ?></h3>
                        </div>
                    </div>
                    <div class="card-footer text-white clearfix small z-1">
                        <span class="float-left">Pedidos Lançados</span>
                    </div>
                </div>
            </div>


        </div>

    </div>

</div>