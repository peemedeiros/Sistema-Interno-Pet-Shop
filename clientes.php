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
        <link rel="stylesheet" href="css/styles.css">
        <title>SIAP</title>
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
            <div class="container">
                <?php
                    require_once('modulo/header.php');
                ?>
                <div class="filtros center">
                    <h1 class="titulo texto-center">
                        Painel de clientes
                    </h1>
                    <div class="filtro-linha">
                        <form action="clientes.php" method="get"  class="input-txt-layout2">
                            Pesquisar por nome
                            <input type="text" name="txt-nome" class="input-txt border-radius">
                            <button type="submit" name="btn-pesquisar" class="btn-filtro">

                            </button>
                        </form>
                    </div>
                </div>

                <div class="tabela-de-exibicao center">
                    <div class="tabela-cabecalho">
                        <!-- CABEÇALHO DA TABELA -->
                        <div class="tabela-coluna texto-center">
                            Nome
                        </div>
                        <div class="tabela-coluna texto-center">
                            Instagram
                        </div>
                        <div class="tabela-coluna texto-center">
                            Telefone/Celular
                        </div>                        
                    </div>
                    <!-- REGISTROS VINDOS DO BANCO -->

                    <?php

                    if(isset($_GET['btn-pesquisar'])){
                        $pesquisado = $_GET['txt-nome'];

                        $sql = "select * from clientes where nome like '%".$pesquisado."%'";
                    }else
                        $sql = "select * from clientes";
                    

                    $count = (int) 1;
                    $cor = (String)"";

                    $select = mysqli_query($conexao, $sql);
                    
                    while($rsConsulta = mysqli_fetch_array($select))
                    {
                        $count += 1;

                        if($count % 2 == 0){
                            $cor = "cor-linha";
                        }else{
                            $cor = "";
                        }
                    ?>
                    <div class="tabela-linha altura-tabela-clientes <?=$cor?>">
                        <div class="tabela-coluna texto-center">
                            <?=$rsConsulta['nome']?>   
                        </div>

                        <div class="tabela-coluna texto-center">
                            <?=$rsConsulta['email']?>   
                        </div>


                        <div class="tabela-coluna texto-center">
                            <?=$rsConsulta['celular']?>
                        </div>
                    </div>

                    <?php

                    }

                    ?>

                    
                </div>
            </div>
        </div>
    </body>
</html>