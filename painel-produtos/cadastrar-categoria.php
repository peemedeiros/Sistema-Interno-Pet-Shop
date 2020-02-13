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
    <body>
        <div id="painel-produtos">
            <?php
                require_once('modulos/menu.php');
            ?>
            <div class="auxiliar"></div>
            <div class="home-painel">
                <div class="container-welcome">
                    <div class="linha">
                        <div>
                            <img src="img/box.png" alt="home">
                        </div>
                    </div>
                    <h3 class="titulo">
                        CADASTRE NOVAS CATEGORIAS
                    </h3>
                    <h2 class="empresa-nome">
                        Augusto's Pet
                    </h2>
                    <form action="../bd/inserir-conf.php" method="post" class="categoria">
                        <h6>CATEGORIA</h6>
                        <input type="text" name="txt-cadastro-categoria" id="txt-cat">
                        <button type="submit" class="botao-produto" name="btn-categoria">
                            CADASTRAR
                        </button>
                    </form>
                    

                </div>

                <div class="container-welcome-1">
                    <div class="linha">
                        
                    </div>
                    <h3 class="titulo">
                        CATEGORIAS CADASTRADAS
                    </h3>
                    <h2 class="empresa-nome">
                        Augusto's Pet
                    </h2>
                    <div class="tabela-categoria">
                        <!-- HEADER TABLE -->
                        <div class="linha-categoria roxo">
                            <div class="coluna-categoria">
                                NOME
                            </div>
                            <div class="coluna-categoria">
                                DELETAR
                            </div>
                        </div>


                        <?php
                            require_once('../bd/conexao.php');
                            $conexao = conexaoMysql();

                            $sql = "SELECT * FROM categoria";
                            $select = mysqli_query($conexao, $sql);

                            $i = 0;
                            $class="";

                            while($rsConsulta = mysqli_fetch_array($select)){
                                $i++;
                                if( $i % 2 == 0 ){
                                    $class = "white";
                                }else{
                                    $class = "";
                                }
                        ?>
                        <!-- Linhas trazidas do banco de dados -->
                        <div class="linha-categoria <?=$class?>">
                            <div class="coluna-categoria">
                                <?=$rsConsulta['nome']?>
                            </div>
                            <div class="coluna-categoria">
                                <img src="../icon/cancel.png" alt="deletar">
                            </div>
                        </div>

                        <?php
                            }
                        ?>


                    </div>
                    
                    

                </div>
            </div>
        </div>
    </body>
</html>