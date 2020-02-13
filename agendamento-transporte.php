<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>SIAP</title>
        <link rel="stylesheet" href="css/styles.css">
        <script src="js/jquery.js"></script>
        <script src="painel-produtos/js/toggle-menu.js"></script>
    </head>
    <body>
    <?php
        require_once('modulo/menu.php');
    ?>
        <div class="pagina-inicial-transporte">
            <div class="cadastrar-transporte">
                <a href="cadastro-transporte.php">
                    <img src="icon/add-transport.png" alt="transporte">
                </a>
                <div class="legenda-baixo">
                    AGENDAR TRANSPORTE
                </div>
            </div>

            <div class="cadastrar-transporte">
                <a href="consultar-transporte.php">
                    <img src="icon/transport-stats.png" alt="transporte">
                </a>
                <div class="legenda-baixo">
                    CONSULTAR TRANSPORTE
                </div>
            </div>
        </div>
    </body>
</html>