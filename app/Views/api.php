<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.5/css/buttons.dataTables.min.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js"></script>


    <title>API - Agora RN</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">

    <script>
        var time = new Date().getTime();
    </script>

</head>

<body>

    <div style="background-color:#01403A">

        <div class="container-sm pt-5 pb-3">

            <div class="card mt-10 ">

                <div class="card-header text-white" style="background-color:#03A64A">
                    <strong>Exportação de P.I. - Jornal Agora RN</strong>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Informe os filtros desejados:</h5>

                    <form method="POST" action='<?php echo base_url('/PI/index'); ?>' name="formFiltros" id="formFiltros">

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

                            <div class="col-auto" id="carregando" class="carregando">

                                <button class="btn btn-success" type="button" disabled>
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

        </div>

    </div>

    <div class="table-responsive">

        <div class="card">
            <div class="card-header text-center">
                <h2>
                    <span class="badge bg-warning text-dark">
                        <?php echo "Número de PIs: " . count($dados_pi) . " | Inicio: " . implode("/", array_reverse(explode("-", $inputdataini))) . " | Fim: " . implode("/", array_reverse(explode("-", $inputdatafim))) . " | Empresa: " . $inputempresa; ?>
                    </span>
                </h2>
            </div>
        </div>

        <div class="table-wrapper-scroll-y my-custom-scrollbar">

            <table class="table table-striped table-sm compact hover" id='tab_dados_pi' name='grid_pi'>
                <thead class="table-success align-middle">
                    <tr>
                        <th scope="col">Cliente</th>
                        <th scope="col">CNPJ/CPF</th>
                        <th scope="col">Registro</th>
                        <th scope="col">Observação</th>
                        <th scope="col">Valor Liquido</th>
                        <th scope="col">Cod. Serviço</th>
                        <th scope="col">Cod. Municipio</th>
                        <th scope="col">Num. NF (RPS)</th>
                        <th scope="col">Cod. Produto</th>
                        <th scope="col">Forma de Pagamento</th>
                        <th scope="col">Tipo de Emissão</th>
                        <th scope="col">Status NF</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">

                    <?php foreach ($dados_pi as $pi) : ?>

                        <tr>
                            <td scope="row"><?php echo $pi['cliente']; ?></td>
                            <td scope="row"><?php echo $pi['cliente_cnpj']; ?></td>
                            <td scope="row"><?php echo $pi['data_da_venda']; ?></td>
                            <td scope="row"><?php echo empty($pi['periodo_veiculacao']) == true ? "SEM DATA VEICULAÇÃO" : 'TIPO DE PUBLICAÇÃO: ' . $pi['tipo_publicacao_pi'] . " - " . $pi['descricao_servico'] . ' - DATA VEICULAÇÃO: ' . date('d/m/Y', strtotime(end($pi['periodo_veiculacao'])['periodo_ate'])) . ' PI: ' . $pi['nr_pi']; ?></td>
                            <td scope="row"><?php echo str_replace(".", "", $pi['valor_liquido']); ?></td>
                            <td scope="row"><?php echo '1007'; ?></td>
                            <td scope="row"><?php echo '2408102'; ?></td>
                            <td scope="row"><?php echo $pi['id']; ?></td>
                            <td scope="row"><?php echo $pi['empresa_prestadora'] == "PARAMETRO AGENCIA DE NOTICIAS" ? '356028' : '354932'; ?></td>
                            <td scope="row"><?php echo '8'; ?></td>
                            <td scope="row"><?php echo $pi['emitido_por']; ?></td>
                            <td scope="row">

                                <form action="<?php echo base_url('/PI/gravaStatus'); ?>" method="POST">

                                    <input type="hidden" name="idpi" id="idpi" value="<?php echo $pi['id']; ?>">
                                    <input type="hidden" name="numeropi" id="numeropi" value="<?php echo $pi['nr_pi']; ?>">

                                    <div class="col px-0" title="gravar">
                                        <button class="btn btn-warning btn-sm" value="1">
                                            Nota Emitida
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-lg" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M4.475 5.458c-.284 0-.514-.237-.47-.517C4.28 3.24 5.576 2 7.825 2c2.25 0 3.767 1.36 3.767 3.215 0 1.344-.665 2.288-1.79 2.973-1.1.659-1.414 1.118-1.414 2.01v.03a.5.5 0 0 1-.5.5h-.77a.5.5 0 0 1-.5-.495l-.003-.2c-.043-1.221.477-2.001 1.645-2.712 1.03-.632 1.397-1.135 1.397-2.028 0-.979-.758-1.698-1.926-1.698-1.009 0-1.71.529-1.938 1.402-.066.254-.278.461-.54.461h-.777ZM7.496 14c.622 0 1.095-.474 1.095-1.09 0-.618-.473-1.092-1.095-1.092-.606 0-1.087.474-1.087 1.091S6.89 14 7.496 14Z" />
                                            </svg>
                                        </button>
                                    </div>

                                </form>

                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>

</html>

<script>
    function showLoad() {
        document.getElementById("carregando").style.display = "block";
    }

    $(document).ready(function() {

        $('#tab_dados_pi').DataTable({
            "pageLength": 100,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
            },
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
            ],
            language: {
                decimal: ',',
                thousands: '.',
            },
        });

        time = (new Date().getTime()) - time;

        $('#carregando').delay(time).fadeOut("slow");

    });
</script>