<div class="table-responsive">

    <div class="card">
        <div class="card-header text-center">
            <div class="">
                <h3>
                    <span class="badge text-dark" style="background-color:#F2E205">
                        <?php echo "PIs Baixados: " . count($dados_pi) . " | Inicio: " . implode("/", array_reverse(explode("-", $inputdataini))) . " | Fim: " . implode("/", array_reverse(explode("-", $inputdatafim))) . " | Empresa: " . $inputempresa; ?>
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
                    <th scope="col">Emissao</th>
                    <th scope="col">Observação</th>
                    <th scope="col">Valor Liquido</th>
                    <th scope="col">RPS</th>
                    <th scope="col">Nº NFSe</th>
                    <th scope="col">Tipo de Emissão</th>
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
                        <td scope="row"><?php echo $pi['id']; ?></td>
                        <td><?php foreach($tbpis as $pibaixado) if ($pibaixado['idpi'] == $pi['id']) : echo $pibaixado['nfpi']; endif;?></td>
                        <td scope="row"><?php echo $pi['emitido_por']; ?></td>
                        <td scope="row">

                            <form action="<?php echo base_url('/PI/desfasBaixa').'/'.$pi['id']; ?>" method="POST">

                                <input type="hidden" name="idpi" id="idpi" value="<?php echo $pi['id']; ?>">
                                <input type="hidden" name="numeropi" id="numeropi" value="<?php echo $pi['nr_pi']; ?>">
                                <input type="hidden" name="dataini" id="dataini" value="<?php echo $inputdataini; ?>">
                                <input type="hidden" name="datafim" id="datafim" value="<?php echo $inputdatafim; ?>">
                                <input type="hidden" name="empresapi" id="empresapi" value="<?php echo $inputempresa; ?>">
                                <input type="hidden" name="tppi" id="tppi" value="2">

                                <button type="submit" class="btn btn-danger btn-sm">                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                    </svg>
                                    Desfazer
                                </button>

                            </form>

                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

    </div>

</div>