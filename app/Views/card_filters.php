<div class="card mt-10 ">

    <div class="card-header text-white" style="background-color:#F27F3D">
        <strong>P.I.s Lançados - Jornal Agora RN</strong>
    </div>

    <div class="card-body">
        <h5 class="card-title">Informe os filtros desejados:</h5>

        <form method="POST" action='<?php echo $tipopi == '1' ? base_url('/PI/pisLancados') : base_url('/PI/pisBaixados'); ?>' name="formFiltros" id="formFiltros">

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
                        <option value=2>A. de O. Viana</option>
                        <option value=1>Parametro Agência de Noticias</option>
                    </select>
                </div>

                <div class="col-auto">

                    <button class="btn btn-primary" type="submit" value="Filtrar" name="filtrar" id="filtrar" onclick="showLoad()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                        Buscar
                    </button>

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
        Start.Tools - G.MTDS
    </div>

</div>