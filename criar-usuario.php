<?php
    require_once('bd/conexao.php');
    require_once('modulo/verificar-status-user.php');
    
    $conexao = conexaoMysql();

    $nome = (String) "";
    $login = (String) "";
    $botao = (String) "CADASTRAR";

    if(isset($_GET['modo'])){
        if(strtoupper($_GET['modo']) == "EDITAR"){

            $sql = "SELECT * FROM usuarios WHERE id = ".$_GET['id'];

            $select = mysqli_query($conexao, $sql);

            if($rsEditar = mysqli_fetch_array($select)){
                
                $_SESSION['id'] = $rsEditar['id'];
                
                $nome = $rsEditar['nome'];
                $login = $rsEditar['username'];
                $botao = "EDITAR";

            }
        }
    }
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
            
            <div class="logout topminor">
                <a href="home.php">
                    <img src="icon/back.png" alt="">
                </a>
            </div>
            <div class="logout">
                <a href="bd/logout.php">
                    <img src="icon/logout.png" alt="">
                </a>
            </div>
            <div class="auxiliar"></div>
            <div class="home-painel ">
                <div class="container-cadastro-produto altura-pequena gray-bg margem-bottom-media">
                    <div class="linha gray-head">
                        <div>
                            <img src="icon/user.png" alt="home">
                        </div>
                    </div>
                    <h3 class="titulo">
                        Cadastrar novo usuario
                    </h3>
                    <h2 class="empresa-nome">
                        Augusto's Pet
                    </h2>
                    <form action="bd/cadastrar-usuario.php" method="post" class="formulario-produto borda-none">
                    <div class="container-form gray-bg">
                            <div class="linha-form">
                                <h4>
                                    Nome
                                </h4>
                                <input type="text" class="cadastro-cliente" name="txt-nome-usuario" value="<?=$nome?>" required>
                            </div>

                            <div class="linha-form">
                                <h4>
                                    Login
                                </h4>
                                <input type="text" class="cadastro-cliente" name="txt-login" value="<?=$login?>" required>
                            </div>

                            <div class="linha-form">
                                <h4>
                                    Senha
                                </h4>
                                <input type="password" class="cadastro-cliente" name="txt-senha" value="" required>
                            </div>


                            <div class="linha-form-botao ">
                                <input type="submit" value="<?=$botao?>" class="botao-produto gray-head black-text sombra-leve" name="btn-cadastrar-usuario">
                            </div>
                        </div>
                        
                        
                    </form>
                </div>
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