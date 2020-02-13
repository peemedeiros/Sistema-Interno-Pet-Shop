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
        <div id="painel-produtos">
            <?php
                require_once('modulos/menu.php');
            ?>
            <div class="auxiliar"></div>
            <div class="home-painel">
                <div class="container-visualizar verde-bg">
                    <div class="linha verde-head">
                        <div>
                            <img src="img/online-store.png" alt="home">
                        </div>
                    </div>
                    <h3 class="titulo">
                        FORNECEDORES
                    </h3>
                    <h2 class="empresa-nome">
                        Augusto's Pet
                    </h2>
                    <div class="tabela">
                        <div class="linha-head verde-head">
                            <div class="coluna-head">
                                Nome
                            </div>
                            <div class="coluna-head">
                                CNPJ
                            </div>
                            <div class="coluna-head">
                                Contato
                            </div>
                            <div class="coluna-head">
                                Opções
                            </div>
                        </div>

                        <?php
                            $count = (int)0;
                            $cor = "";
                            $atencao = "";
                            $sql="SELECT * FROM fornecedores";

                            $select = mysqli_query($conexao, $sql);

                            while($rsConsulta = mysqli_fetch_array($select)){
                            $count ++; 
                            if($count % 2 == 0){

                                $cor = "verde-bg";
                                
                            }else{

                                $cor = "";

                            }

                            
                            
                        ?>

                        <div class="linha-tabela <?=$cor?>">
                            <div class="coluna-tabela">
                                <?=$rsConsulta['nome']?>
                            </div>
                            <div class="coluna-tabela">
                                <?=$rsConsulta['cnpj']?>
                            </div>
                            <div class="coluna-tabela">
                                <?=$rsConsulta['telefone']?>
                            </div>
                            
                            <div class="coluna-tabela">
                                <a href="../bd/deletar.php?modo=deletarservico&id=<?=$rsConsulta['id']?>">
                                    <img src="img/cancel2.png" alt="delete">
                                </a>
                                
                                    <img src="img/search2.png" alt="buscar" class="visualizar" onclick="visualizarDados(<?=$rsConsulta['id']?>);">
                                
                                <a href="cadastrar-servicos.php?modo=editar&id=<?=$rsConsulta['id']?>">
                                    <img src="img/edit.png" alt="editar">
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