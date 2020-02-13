<?php

require_once('../bd/conexao.php');
require_once('modulos/verificar-status.php');
    
$conexao = conexaoMysql();

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
    <body>
        <div class="painel-produtos">
            <?php
                require_once('modulos/menu.php');
            ?>
            <div class="auxiliar"></div>
            <div class="home-painel alturacentervh">
                <div class="container-cadastro-produto alturaPadrao  verde-bg">
                    <div class="linha verde-head">
                        <div>
                            <img src="img/online-store.png" alt="home">
                        </div>
                    </div>
                    <h3 class="titulo">
                        Cadastrar fornecedor
                    </h3>
                    <h2 class="empresa-nome">
                        Augusto's Pet
                    </h2>
                    <form action="../bd/inserir-conf.php" method="post" class="formulario-produto">
                        <div class="container-form">
                            <div class="linha-form">
                                <h4>
                                    Nome
                                </h4>
                                <input type="text" id="fornecedor-nome" name="txt-nome-fornecedor" value="">
                            </div>

                            <div class="linha-form">
                                <h4>
                                    CNPJ
                                </h4>
                                <input type="text" id="fornecedor-cnpj" name="txt-cnpj-fornecedor" value="">
                            </div>

                            <div class="linha-form">
                                <h4>
                                    Contato
                                </h4>
                                <input type="text" id="contato-fornecedor" name="txt-telefone-fornecedor" value="">
                            </div>

                            <div class="linha-form-botao">
                                <input type="submit" value="CADASTRAR" class="botao-produto verde-head" name="btn-fornecedor">
                            </div>
                        </div>
                        
                    </form>
                
                </div>
            </div>
        </div>
    </body>
</html>