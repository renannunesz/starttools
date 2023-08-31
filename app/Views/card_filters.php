<div class="card mt-10">

    <div class="card-header text-white" style="background-color:#F27F3D">
        <strong>P.I.s Lançados - Jornal Agora RN</strong>
    </div>

    <div class="card-body">
        <h5 class="card-title">Informe os filtros desejados:</h5>

        <form method="POST" action='<?php echo $tipopi == '1' ? base_url('/PI/pisLancados') : base_url('/PI/pisBaixados'); ?>' name="formFiltros" id="formFiltros">

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

                <div class="col-auto" id="carregando" class="carregando">

                    <button class="btn btn-warning" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Carregando...
                    </button>

                </div>

            </div>

        </form>

        <div class="">
            <form action='<?php echo base_url('/PI/expAthenas'); ?>' method="post">

                <input type="hidden" name="dataini" id="dataini" value="<?php echo $inputdataini; ?>">
                <input type="hidden" name="datafim" id="datafim" value="<?php echo $inputdatafim; ?>">
                <input type="hidden" name="empresapi" id="empresapi" value="<?php echo $inputempresa; ?>">

                <div class="">
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="fas fa-fw fa-file-excel"></i>
                        <span>Exportar</span>
                    </button>
                </div>
            </form>
        </div>

    </div>


</div>