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

    <div class="tbhomolog">
        <pre>
            <?php dd($dados_pi); ?>
        </pre>
    </div>

</body>

</html>
