<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homolog - API</title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/favicon.ico') ?>">
</head>

<body>

    <!--
    <table>
        <thead>
            <tr>
                <th>data_da_venda</th>
                <th>nr_pi</th>
                <th>cliente</th>
                <th>seguimento</th>
                <th>canal_com</th>
                <th>empresa_prestadora</th>
                <th>tipo_publicacao</th>
                <th>agencia</th>
                <th>representante</th>
                <th>vendedor</th>
                <th>valor_bruto</th>
                <th>valor_liquido</th>
                <th>tipo_de_fatura</th>
                <th>pagamento</th>
                <th>comissao_agencia</th>
                <th>comissao_representante</th>
                <th>comissao_vendedor</th>
                <th>descricao_servico</th>
                <th>banco</th>
                <th>agencia_bancaria</th>
                <th>numero_da_conta</th>
                <th>empresa_prestadora_cnpj</th>
                <th>cliente_cnpj</th>
                <th>emitido_por</th>
                <th>periodo_veiculacao</th>
            </tr>
        </thead>
        <tbody>
            <?php //foreach($dados_pi as $pi): ?>
            <tr>                
                <td><?php  //echo $pi['data_da_venda']?></td>
                <td><?php  //echo $pi['nr_pi']; ?></td>
                <td><?php  //echo $pi['cliente']; ?></td>
                <td><?php  //echo $pi['seguimento']; ?></td>
                <td><?php  //echo $pi['canal_com']; ?></td>
                <td><?php  //echo $pi['empresa_prestadora']; ?></td>
                <td><?php  //echo $pi['tipo_publicacao']; ?></td>
                <td><?php  //echo $pi['agencia']; ?></td>
                <td><?php  //echo $pi['representante']; ?></td>
                <td><?php  //echo $pi['vendedor']; ?></td>
                <td><?php  //echo $pi['valor_bruto']; ?></td>
                <td><?php  //echo $pi['valor_liquido']; ?></td>
                <td><?php  //echo $pi['tipo_de_fatura']; ?></td>
                <td><?php  //echo $pi['pagamento']; ?></td>
                <td><?php  //echo $pi['comissao_agencia']; ?></td>
                <td><?php  //echo $pi['comissao_representante']; ?></td>
                <td><?php  //echo $pi['comissao_vendedor']; ?></td>
                <td><?php  //echo $pi['descricao_servico']; ?></td>
                <td><?php  //echo $pi['banco']; ?></td>
                <td><?php  //echo $pi['agencia_bancaria']; ?></td>
                <td><?php  //echo $pi['numero_da_conta']; ?></td>
                <td><?php  //echo $pi['empresa_prestadora_cnpj']; ?></td>
                <td><?php  //echo $pi['cliente_cnpj']; ?></td>
                <td><?php  //echo $pi['emitido_por']; ?></td>
                <td><?php  //echo $pi['periodo_veiculacao'][0]['periodo_ate']; ?></td>
            </tr>
            <?php  //endforeach; ?>
        </tbody>
    </table>
    -->

    <pre>
        <?php

            var_dump($dados_pi);        
            
        ?>
    </pre>

</body>

</html>