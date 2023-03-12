<div class="card mt-10 ">

    <div class="card-header text-white" style="background-color:#F27F3D">
        <strong>P.I.s Lançados - Jornal Agora RN</strong>
    </div>

    <div class="card-body">
        <h5 class="card-title">Informe os filtros desejados:</h5>

        <form method="POST" action='<?php echo base_url('/PI/pisLancados'); ?>' name="formFiltros" id="formFiltros">

            <div class="row g-3 align-items-center mb-2">

                <div class="col-auto">
                    <label for="datainicio" class="col-form-label">Inicio:</label>
                </div>

                <div class="col-auto">
                    <input type="date" class="form-control" name="dataPIini" id="dataPIini" value="<?php echo isset($inputdataini) ? $inputdataini : date('Y-m-d'); ?>">
                </div>

                <div class="col-auto">
                    <label for="datafim" class="col-form-label">Fim:</label>
                </div>

                <div class="col-auto">
                    <input type="date" class="form-control" name="dataPIfim" id="dataPIfim" value="<?php echo isset($inputdatafim) ? $inputdatafim : date('Y-m-d'); ?>">
                </div>

                <div class="col-auto">
                    <label for="data" class="col-form-label">Empresa:</label>
                </div>

                <div class="col-auto">
                    <select class="form-select" name="empresaPI" id="empresaPI" required>
                        <option value="">-</option>
                        <option value="A. DE O. VIANA">A. de O. Viana</option>
                        <option value="PARAMETRO AGENCIA DE NOTICIAS">Parametro Agência de Noticias</option>
                    </select>
                </div>

                <div class="col-auto">

                    <input type="submit" value="Filtrar" name="filtrar" id="filtrar" onclick="showLoad()">

                </div>

                <div class="col-auto">

                    <a href='<?php echo base_url('/PI/expAthenas'); ?>'>

                        <button class="btn btn-danger" type="button">
                            Exportar para Athenas
                        </button>

                    </a>

                </div>

                <div class="col-auto" id="carregando" class="carregando">

                    <button class="btn btn-warning" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Carregando...
                    </button>

                </div>

            </div>

        </form>

    </div>

    <div class="card-footer text-muted">
        Tecnologia - G.MTDS
    </div>

</div>