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
            <div class="formulario-agendamento">
                <div class="progresso">
                    <div class="step step-complete">
                        <img src="icon/icon.svg" alt="confirm">
                    </div>
                    <div class="line-step step-complete">

                    </div>
                    <div class="step step-complete">
                        <img src="icon/icon.svg" alt="confirm">
                    </div>
                    <div class="line-step step-complete">

                    </div>
                    <div class="step step-complete">
                        <img src="icon/icon.svg" alt="confirm">
                    </div>
                </div>
                <div class="busca-cliente-done">
                    <h1>TRANSPORTE AGENDADO!</h1>
                    <button class="botao">VISUALIZAR</button>
                </div>

            </div>
        </div>
    </body>
</html>