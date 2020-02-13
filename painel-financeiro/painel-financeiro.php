<?php
require_once('modulos/verificar-status.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/painel.css">
        <link rel="stylesheet" href="css/reset.css">
        <script src="js/jquery.js"></script>
        <script src="js/toggle-menu.js"></script>
        <title>.::SIAP-PRODUTOS::.</title>

    </head>
    <body style="background-image:url('img/background-home.jpg');
                 background-size:cover;" >
        <div id="painel-produtos "  >
            <?php
                require_once('modulos/menu.php');
            ?>
            <div class="auxiliar"></div>
            <div class="home-painel ">
                <div class="container-welcome white">
                    <div class="linha orange">
                        <div>
                            <img src="../icon/money.png" alt="home">
                        </div>
                    </div>
                    <h3 class="titulo">
                        Bem vindo ao seu caixa
                    </h3>
                    <h2 class="empresa-nome">
                        Augusto's Pet
                    </h2>
                    <p>
                        Neste painel você terá um resumo de como andam seus negócios.                 
                    </p>
                    <p>
                        
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>