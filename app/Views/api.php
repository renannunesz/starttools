<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>API - Agora RN</title>
    <link rel="icon" type="image/x-icon" href="../../assets/favicon.ico">
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

                    <form method="GET" action="<?php base_url('PI/filtros');?>" name="formFiltros" id="formFiltros">

                        <div class="row g-3 align-items-center mb-2">

                            <div class="col-auto">
                                <label for="data" class="col-form-label">Data:</label>
                            </div>
                            <div class="col-auto">
                                <input type="date" class="form-control" name="dataPI" id="dataPI">
                            </div>

                            <div class="col-auto">
                                <label for="data" class="col-form-label">Tipo Emissão:</label>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" name="tpemissaoPI" id="tpemissaoPI">
                                    <option selected>-</option>
                                    <option value="RECIBO">Recibo</option>
                                    <option value="NOTA FISCAL">Nota Fiscal</option>
                                </select>
                            </div>

                            <div class="col-auto">
                                <label for="data" class="col-form-label">Empresa:</label>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" name="empresaPI" id="empresaPI" required>
                                    <option value="">-</option>
                                    <option value="A. DE O. VIANA – (GRUPO AGORA/RN)">A. de O. Viana</option>
                                    <option value="PARAMETRO AGENCIA DE NOTICIAS">Parametro Agência de Noticias </option>
                                </select>
                            </div>

                            <div class="col-auto">
                                
                                <input type="submit" value="Teste Post" name="filtrar" id="filtrar">
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
        <form method="POST" action="public/PI/export" name="formTab" id="formTab">

            <div class="card">
                <div class="card-header">
                    <strong>Dados Pedidos</strong>
                    <button type="submit" name="salvar" id="salvar" class="btn btn-success btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                        </svg>
                        Salvar
                    </button>
                </div>
            </div>

            <table class="table table-striped table-sm" id='tab_dados_pi'>
                <thead class="table-success align-middle">
                    <tr>
                        <th scope="col">Cliente/Fornecedor</th>
                        <th scope="col">CNPJ/CPF</th>
                        <th scope="col">Registro</th>
                        <th scope="col">Obs</th>
                        <th scope="col">Valor Liquido</th>
                        <th scope="col">Cod. Serviço</th>
                        <th scope="col">Cod. Mun. Prestador</th>
                        <th scope="col">Num. NF</th>
                        <th scope="col">Cod. Produto</th>
                        <th scope="col">Forma de Pagamento</th>
                        <th scope="col">Emissão</th>
                        <th scope="col">Veiculação</th>
                        <th scope="col">Empresa</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">

                <?php foreach($dados_pi as $pi): ?>
                    <tr>
                        <td scope="row"><?php echo $pi['cliente']; ?></td>
                        <td scope="row"><?php echo $pi['cliente_cnpj']; ?></td>
                        <td scope="row"><?php echo $pi['data_da_venda']; ?></td>
                        <td scope="row"><?php echo $pi['descricao_servico']; ?></td>
                        <td scope="row"><?php echo $pi['valor_liquido']; ?></td>
                        <td scope="row"><?php echo '3501'; ?></td>
                        <td scope="row"><?php echo '2408102'; ?></td>
                        <td scope="row"><?php echo '1'; ?></td>
                        <td scope="row"><?php echo '354932'; ?></td>
                        <td scope="row"><?php echo '8'; ?></td>
                        <td scope="row"><?php echo $pi['emitido_por']; ?></td>
                        <td scope="row"><?php echo end($pi['periodo_veiculacao'])['periodo_ate']; ?></td>
                        <td scope="row"><?php echo $pi['empresa_prestadora']; ?></td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>

            <input type="hidden" name="inp_h_tabdados" id="inp_h_tabdados" />

        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#salvar').click(function() {
            var conteudo_tab = '<table>';
            conteudo_tab += $('#tab_dados_pi').html();
            conteudo_tab += '</table>';
            $('#inp_h_tabdados').val(conteudo_tab);
            $('#tab_pi').submit();
        });
    });
</script>