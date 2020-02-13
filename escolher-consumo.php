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
                <a href="consumir.php?idcliente=">
                    <img src="icon/shopping-bag.png" alt="transporte">
                </a>
                <div class="legenda-baixo">
                    COMPRAR PRODUTOS
                </div>
            </div>

            <div class="cadastrar-transporte">
                <a href="bd/ordem-servico.php">
                    <img src="icon/pet.png" alt="transporte">
                </a>
                <div class="legenda-baixo">
                    CONSUMIR SERVIÇOS
                </div>
            </div>
        </div>
    </body>
</html>