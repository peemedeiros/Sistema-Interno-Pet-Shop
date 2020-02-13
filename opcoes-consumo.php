<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/styles.css">
        <title>Augusto's Pet</title>
        <script src="js/jquery.js"></script>
        <script src="painel-produtos/js/toggle-menu.js"></script>
    </head>
    <body>
        <div class="pagina-inicial">
            <?php
                require_once('./modulo/menu.php');
            ?>
            <div class="help">
                <img src="./icon/question.png" alt="ask">
                <div class="devContato">
                    <div>
                        <p>Dúvidas? Entre em contato com o Dev.</p>
                        <br>
                        <p>555-123</p>
                    </div>
                </div>       
            </div>
            <div class="container-home">
                <div class="main">
                    <?php
                        require_once('modulo/header.php');
                    ?>
                    <div class="conteudo-home">
                        <h2 class="texto-center margem-top-pequena">SELECIONE O TIPO DE SERVIÇO</h2>
                        <div class="opcoes-consumo">
                            <div class="tipo-de-servico">
                                <img src="icon/shopping-bag.png" alt="comprar">
                                <div class="legenda-consumo">
                                    CONSUMIR PRODUTOS
                                </div>
                            </div>

                            <div class="tipo-de-servico">
                                <img src="icon/car.png" alt="comprar">
                                <div class="legenda-consumo">
                                    TRANSPORTE
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>