<div class="table-responsive">

        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" name='grid_pi'>

            <thead class="text-bg-secondary align-middle ">
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
                        <td scope="row"><?php echo $pi['tipo_de_fatura'] == "BRUTO C/ CLIENTE" ? str_replace(".", "", $pi['valor_bruto']) : str_replace(".", "", $pi['valor_liquido']); ?></td>
                        <td scope="row"><?php echo $pi['id_pi']; ?></td>
                        <td scope="row"><?php echo $pi['emitido_por']; ?></td>
                        <td scope="row"><?php echo implode("/", array_reverse(explode("-", $pi['data_vencimento']))); ?></td>
                        <td scope="row"><?php echo $pi['forma_pagamento']; ?></td>
                        <td scope="row">

                            <form action="<?php echo base_url('/PI/gravaStatus'); ?>" method="POST">

                                <input type="hidden" name="idpi" id="idpi" value="<?php echo $pi['id_pi']; ?>">
                                <input type="hidden" name="numeropi" id="numeropi" value="<?php echo $pi['nr_pi']; ?>">
                                <input type="hidden" name="dataini" id="dataini" value="<?php echo $inputdataini; ?>">
                                <input type="hidden" name="datafim" id="datafim" value="<?php echo $inputdatafim; ?>">
                                <input type="hidden" name="empresapi" id="empresapi" value="<?php echo $inputempresa; ?>">
                                <input type="hidden" name="tppi" id="tppi" value="1">

                                <!-- Button trigger modal -->
                                
                                <button alt="Baixar PI" type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#finalizarModal-<?php echo $pi['id_pi']; ?>">
                                    <i class="fas fa-fw fa-check"></i>                        
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="finalizarModal-<?php echo $pi['id_pi']; ?>" aria-labelledby="finalizarModalLabel" aria-hidden="true">
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