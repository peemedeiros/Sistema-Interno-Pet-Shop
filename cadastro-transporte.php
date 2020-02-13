<?php

    require_once('bd/conexao.php');
    $conexao = conexaoMysql();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>SIAP</title>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/materialize.css">
        <script src="js/jquery.js"></script>
        <script src="painel-produtos/js/toggle-menu.js"></script>
        <script src="js/modulo.js"></script>
        <script>
            $(document).ready(function(){
                $('#step').css({
                    backgroundColor:'rgb(34, 184, 42)',
                })
            })
        </script>
    </head>
    <body>
    <?php
        require_once('modulo/menu.php');
    ?>
        <div class="pagina-inicial-transporte">
            <div class="formulario-agendamento">
                <div class="progresso">
                    <div class="step" id="step">
                        1
                    </div>
                    <div class="line-step">

                    </div>
                    <div class="step">
                        2
                    </div>
                    <div class="line-step">

                    </div>
                    <div class="step">
                        3
                    </div>
                </div>
                <div class="busca-cliente">
                    <div class="busca-cpf-cliente">
                        <h5>Já é cliente cadastrado?</h5>
                        <form class="caixa-cpf" method="POST" action="bd/autenticacao-transporte.php">
                            <div class="input-field col s12">
                                <input id="cpf_cliente" onkeypress="return mascaraFone(this,event);" type="text" class="validate" name="txtcpf-agendamento">
                                <label for="cpf_cliente">TELEFONE/CELULAR</label>
                                
                            </div>
                            
                            <button name="btn-confirmar" type="submit" class="waves-effect waves-light btn indigo darken-1 text-white">
                                    CONFIRMAR
                            </button>
                            
                        </form>
                        <a href="cadastrar-cliente.php" class="waves-effect waves-light btn green darken-1 text-white margem-baixo-pequena">
                            CADASTRAR CLIENTE
                        </a>
                        <form method="POST" action="bd/autenticacao-transporte.php">
                            <button href="confirmar-transporte.php" submit="submit" name="btn-sem-cadastro" class="waves-effect waves-light btn green darken-1 text-white">
                                AGENDAR SEM CADASTRO
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <script src="js/materialize.min.js"></script>
        <script>
            $(document).ready(function() {
                M.updateTextFields();
            });
        </script>
    </body>
</html>