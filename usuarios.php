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
        <link rel="stylesheet" href="painel-produtos/css/painel.css">
        <link rel="stylesheet" href="painel-produtos/css/reset.css">
        <script src="js/jquery.js"></script>
        <script src="painel-produtos/js/toggle-menu.js"></script>
        <title>SIAP</title>
        <script>
            
        </script>
    </head>
    <body>
        <div class="painel-produtos">
            <?php
                require_once('modulo/menu.php');
            ?>
            <div class="auxiliar"></div>
            <div class="home-painel ">
                <div class="container-cadastro-produto gray-bg">
                    <div class="linha gray-head">
                        <div>
                            <img src="icon/user.png" alt="home">
                        </div>
                    </div>
                    <h3 class="titulo">
                        Usuarios
                    </h3>
                    <h2 class="empresa-nome">
                        Augusto's Pet
                    </h2>
                   
                        <div class="tabela">
                            <div class="linha-head gray">
                                <div class="coluna-head">
                                    Nome
                                </div>
                                <div class="coluna-head">
                                    Login
                                </div>
                                <div class="coluna-head">
                                    Opções
                                </div>
                            </div>
                            <?php
                            
                            $sql = "SELECT * FROM usuarios";

                            $select = mysqli_query($conexao, $sql);

                            while($rsConsulta = mysqli_fetch_array($select)){
                                
                            
                            ?>

                            <div class="linha-tabela">
                                <div class="coluna-tabela">
                                   <?=$rsConsulta['nome']?>
                                </div>
                                <div class="coluna-tabela">
                                    <?=$rsConsulta['username']?>
                                </div>
                                <div class="coluna-tabela">
                                    <a onclick="return confirm('Deseja realmente excluir esse usuario?')" href="bd/deletar.php?modo=deletarusuario&id=<?=$rsConsulta['id']?>">
                                        <img src="painel-produtos/img/cancel2.png" alt="delete">
                                    </a>
                                    
                                    <a href="criar-usuario.php?modo=editar&id=<?=$rsConsulta['id']?>">
                                        <img src="painel-produtos/img/edit.png" alt="editar">
                                    </a>
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