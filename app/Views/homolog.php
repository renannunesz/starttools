<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homolog - API</title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/favicon.ico') ?>">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <!-- DevExtreme theme -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.4/css/dx.light.css">

    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/22.2.4/js/dx.all.js"></script>

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
            <?php //foreach($dados_pi as $pi): 
            ?>
            <tr>                
                <td><?php  //echo $pi['data_da_venda']
                    ?></td>
                <td><?php  //echo $pi['nr_pi']; 
                    ?></td>
                <td><?php  //echo $pi['cliente']; 
                    ?></td>
                <td><?php  //echo $pi['seguimento']; 
                    ?></td>
                <td><?php  //echo $pi['canal_com']; 
                    ?></td>
                <td><?php  //echo $pi['empresa_prestadora']; 
                    ?></td>
                <td><?php  //echo $pi['tipo_publicacao']; 
                    ?></td>
                <td><?php  //echo $pi['agencia']; 
                    ?></td>
                <td><?php  //echo $pi['representante']; 
                    ?></td>
                <td><?php  //echo $pi['vendedor']; 
                    ?></td>
                <td><?php  //echo $pi['valor_bruto']; 
                    ?></td>
                <td><?php  //echo $pi['valor_liquido']; 
                    ?></td>
                <td><?php  //echo $pi['tipo_de_fatura']; 
                    ?></td>
                <td><?php  //echo $pi['pagamento']; 
                    ?></td>
                <td><?php  //echo $pi['comissao_agencia']; 
                    ?></td>
                <td><?php  //echo $pi['comissao_representante']; 
                    ?></td>
                <td><?php  //echo $pi['comissao_vendedor']; 
                    ?></td>
                <td><?php  //echo $pi['descricao_servico']; 
                    ?></td>
                <td><?php  //echo $pi['banco']; 
                    ?></td>
                <td><?php  //echo $pi['agencia_bancaria']; 
                    ?></td>
                <td><?php  //echo $pi['numero_da_conta']; 
                    ?></td>
                <td><?php  //echo $pi['empresa_prestadora_cnpj']; 
                    ?></td>
                <td><?php  //echo $pi['cliente_cnpj']; 
                    ?></td>
                <td><?php  //echo $pi['emitido_por']; 
                    ?></td>
                <td><?php  //echo $pi['periodo_veiculacao'][0]['periodo_ate']; 
                    ?></td>
            </tr>
            <?php  //endforeach; 
            ?>
        </tbody>
    </table>
    -->

    <form action='<?php echo base_url('/PI/homologAPI'); ?>' method="post">
        Inicio:
        <input type="date" name="dtinihomolog" id="dtinihomolog">
        Fim:
        <input type="date" name="dtfimhomolog" id="dtfimhomolog">
        Empresa:
        <select name="empresahomolog" id="empresahomolog">
            <option value=2>A. de O. Viana</option>
            <option value=1>Parametro Agência de Noticias</option>
        </select>
        <input type="submit" value="Buscar">
    </form>

    <div id="tbgrid" style="width: 100%;">

    </div>

    <div class="tbhomolog">
        <pre>
            <?php var_dump($dados_pi); 
            ?>
        </pre>
    </div>

</body>

</html>

<!-- JS Code -->
<script type="text/javascript">
    const settings = {
        "async": true,
        "crossDomain": true,
        "url": "https://agorarn.datavence.com.br/api/private/faturamentosLiberados?empresa_prestadora=1&data_inicio=2023-03-20&data_fim=2023-03-31",
        "method": "POST",
        "headers": {
            "Authorization": "Basic 408fb3e9b90a4c59b34628b3b80fbe64",
            "Content-Type": "application/x-www-form-urlencoded"
        },
        "data": {}
    };

    $.ajax(settings).done(function(response) {
        console.log(response);
    });

    $(document).ready(function() {

        $.ajax(settings).done(function(response) {
            var dados = response;
        });

        $("#tbgrid").dxDataGrid({
            dataSource: dados,
            paging: {
                pageSize: 10
            },
            allowColumnReordering: true,
            allowColumnResizing: true,
            filterRow: {
                visible: true
            },
            selection: {
                mode: "multiple"
            },
            groupPanel: {
                visible: true
            },
            export: {
                enabled: true,
                allowExportSelectedData: true,
            }
        })

    })
</script>