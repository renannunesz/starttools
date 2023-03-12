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


    <title>Start Tools</title>
    <link rel="icon" type="image/x-icon" href='<?php echo base_url()."/assets/favicon_start.ico"; ?>' >

    <script>
        var time = new Date().getTime();
    </script>

</head>

<body>

    <?php require 'vendor/autoload.php'; ?>

    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-2">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img src='<?php echo base_url()."/assets/ico_startbi.png"; ?>' alt="" width="32" height="32" class="rounded-circle me-2">
            <span class="fs-4">Start.Tools</span>
        </a>
    </nav>

    <div class="container-fluid ">
        <div class="row">

            <nav class="col-md-2 d-none d-md-block bg-light sidebar " style="width: 200px;">

                <?php include 'side_menu.php'; ?>

            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Pedidos de Inserção - <?php echo uri_string() == "PI/pisLancados" ? "Lançados" : "Baixados"; ?></h1>
                </div>

                <div id="cardfilter" class="p-1">

                    <?php include 'card_filters.php'; ?>

                </div>

                <div id="tbpis">

                    <?php include 'table_pis.php'; ?>

                </div>

            </main>
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
            }
        });

        time = (new Date().getTime()) - time;

        $('#carregando').delay(time).fadeOut("slow");

    });
</script>