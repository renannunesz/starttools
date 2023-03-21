<div class="table-responsive">

    <div class="card">

        <div class="card-header text-center">            
            <div class="">
                <h3>
                    <span class="badge text-dark" style="background-color:#F2E205">
                        <?php echo "PIs Lançados: " . count($dados_pi) . " | Inicio: " . implode("/", array_reverse(explode("-", $inputdataini))) . " | Fim: " . implode("/", array_reverse(explode("-", $inputdatafim))) . " | Empresa: " . $inputempresa; ?>
                    </span>
                </h3>
            </div>
            <div class="d-flex justify-content-end">
                <form action='<?php echo base_url('/PI/expAthenas'); ?>' method="post">

                    <input type="hidden" name="dataini" id="dataini" value="<?php echo $inputdataini; ?>">
                    <input type="hidden" name="datafim" id="datafim" value="<?php echo $inputdatafim; ?>">
                    <input type="hidden" name="empresapi" id="empresapi" value="<?php echo $inputempresa; ?>">

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                            </svg>
                            Exportar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="table-wrapper-scroll-y my-custom-scrollbar pb-1 pt-1 mb-1">

        <table class="table table-striped table-sm compact hover" id='tab_dados_pi' name='grid_pi'>
            <thead class="text-bg-secondary align-middle">
                <tr>
                    <th scope="col">PI</th>
                    <th scope="col">Cliente</th>
                    <th scope="col" style="width: 10%">CNPJ/CPF</th>
                    <th scope="col">Registro</th>
                    <th scope="col">Emissão</th>
                    <th scope="col">Observação</th>
                    <th scope="col">Valor</th>
                    <th scope="col">RPS</th>
                    <th scope="col">Tipo de Emissão</th>
                    <th scope="col">Data Vencimento</th>
                    <th scope="col">Forma PG</th>
                    <th scope="col" style="width: 6%">Opções</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">

                <?php foreach ($dados_pi as $pi) : ?>

                    <tr>
                        <td scope="row"><?php echo $pi['nr_pi']; ?></td>
                        <td scope="row"><?php echo $pi['cliente']; ?></td>
                        <td scope="row"><?php echo $pi['cliente_cnpj']; ?></td>
                        <td scope="row"><?php echo $pi['data_da_venda']; ?></td>
                        <td scope="row"><?php echo $pi['data_liberacao']; ?></td>
                        <td scope="row"><?php echo empty($pi['periodo_veiculacao']) == true ? "SEM DATA VEICULAÇÃO" : 'TIPO DE PUBLICAÇÃO: ' . $pi['tipo_publicacao_pi'] . " - " . $pi['descricao_servico'] . ' - DATA VEICULAÇÃO: ' . date('d/m/Y', strtotime(end($pi['periodo_veiculacao'])['periodo_ate'])); ?></td>
                        <td scope="row"><?php echo $pi['tipo_de_fatura'] == "BRUTO C/ CLIENTE" ? str_replace(".", "", $pi['valor_bruto']) : str_replace(".", "", $pi['valor_liquido']) ; ?></td>
                        <td scope="row"><?php echo $pi['id']; ?></td>
                        <td scope="row"><?php echo $pi['emitido_por']; ?></td>
                        <td scope="row"><?php echo implode("/", array_reverse(explode("-", $pi['data_vencimento']))); ?></td>
                        <td scope="row"><?php echo $pi['forma_pagamento']; ?></td>
                        <td scope="row">

                            <form action="<?php echo base_url('/PI/gravaStatus'); ?>" method="POST">

                                <input type="hidden" name="idpi" id="idpi" value="<?php echo $pi['id']; ?>">
                                <input type="hidden" name="numeropi" id="numeropi" value="<?php echo $pi['nr_pi']; ?>">
                                <input type="hidden" name="dataini" id="dataini" value="<?php echo $inputdataini; ?>">
                                <input type="hidden" name="datafim" id="datafim" value="<?php echo $inputdatafim; ?>">
                                <input type="hidden" name="empresapi" id="empresapi" value="<?php echo $inputempresa; ?>">
                                <input type="hidden" name="tppi" id="tppi" value="1">

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#finalizarModal-<?php echo $pi['id']; ?>">                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                    </svg>
                                    Finalizar
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="finalizarModal-<?php echo $pi['id']; ?>" aria-labelledby="finalizarModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="finalizarModalLabel">Finalizar P.I. - <?php echo $pi['nr_pi']; ?></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="container-fluid">

                                                    <div class="row">

                                                        <div class="input-group mb-3">
                                                            <label class="input-group-text">Data:</label>
                                                            <input type="date" class="form-control" name="datanfpi" id="datanfpi" required>
                                                        </div>

                                                    </div>

                                                    <div class="row">

                                                        <div class="input-group mb-3">
                                                            <label class="input-group-text">Numero NF:</label>
                                                            <input type="text" class="form-control" name="nfpi" id="nfpi" required>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

    </div>

</div>