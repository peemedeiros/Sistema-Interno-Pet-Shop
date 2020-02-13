<?php
if(isset($_SESSION)){
    session_destroy();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/materialize.css">
        <link rel="stylesheet" href="css/styles.css">
        <title>SIAP</title>
        <script src="js/jquery.js"></script>
        <script src="painel-produtos/js/toggle-menu.js"></script>
        <script src="js/modulo.js"></script>
    </head>
    <body>
        <div class="pagina-inicial-atendimento">
            <?php
                require_once('./modulo/menu.php');
            ?>
            <div class="help">
                <img src="./icon/question.png" alt="ask">
                <div class="devContato">
                    <div>
                        <p>Dúvidas? Entre em contato com o Dev.</p>
                        <br>
                        <p>(11)95881 - 9879</p>
                    </div>
                </div>       
            </div>
            <div class="container-atendimento">
            
                <div class="filtros center">
                    <div class="cliente-cadastrado">
                        <form method="post" action="bd/autenticacao.php" class="cpf-cliente">
                            <h1 class="titulo texto-center">
                                como podemos ajudar hoje?
                            </h1>
                            <h6 class="texto-center">JA É CLIENTE CADASTRADO?</h6>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="last_name" onkeypress="return mascaraFone(this,event);" type="text" class="validate" name="txtcelular">
                                    <label for="last_name">TELEFONE/CELULAR</label>
                                </div>
                                <button name="btn-autenticar" type="submit" class="waves-effect waves-light btn indigo darken-1 text-white">Entrar</button>
                            </div>
                            <div class="sign-up indigo darken-1">
                                <h6 class="texto-center">
                                    <a href="cadastrar-cliente.php">
                                        Cadastrar novo cliente
                                    </a>
                                </h6>
                                <h6 class="texto-center">
                                    <a href="escolher-consumo.php">
                                        Entrar sem cadastrar
                                    </a>
                                </h6>
                            </div>
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