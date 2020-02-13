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
        <script>
            //Jquery para abrir modal
            $(document).ready(function(){
                $('.visualizar').click(function(){
                    $('#container-modal').css({
                        visibility:'visible',
                        opacity:'1',
                        zIndex:'999'
                    });
                });
            });

            //Ajax para carregar informações do produto na modal
            function visualizarDados(idItem){
                $.ajax({
                    type:"POST",
                    url:"modalProdutos.php",
                    data:{
                        modo:'visualizar',
                        id:idItem
                    },
                    success: function(dados){
                        $('#modal').html(dados);
                    }
                });
            }
        </script>
    </head>
    <body>
        <div id="container-modal">
            <div id="modal">
            
                
            </div>
        </div>
        <div id="painel-produtos">
            <?php
                require_once('modulos/menu.php');
            ?>
            <div class="auxiliar"></div>
            <div class="home-painel">
                <div class="pesquisar-produto">
                    
                    <form action="visualizar-produtos.php">
                        <input type="text" name="txt-nome" id="pesquisa-produto-nome">
                        <input type="submit" name="btn-nome-produto" class="botao-pesquisar" value="BUSCAR">
                    </form>
                    <form action="visualizar-produtos.php" method="get">
                        <select name="stl-categoria" id="pesquisa-categoria">
                            <option value="">
                                Selecione uma categoria
                            </option>

                            <?php
                            
                            $sqlCategoria = "SELECT * FROM categoria";

                            $selectCategoria = mysqli_query($conexao, $sqlCategoria);

                            while($rsCategoria = mysqli_fetch_array($selectCategoria)){

                            ?>

                            <option value="<?=$rsCategoria['id']?>">
                                <?=$rsCategoria['nome']?>
                            </option>


                            <?php

                            }
                            
                            ?>


                        </select>
                        <input type="submit" name="btn-categoria"  class="botao-pesquisar" value="FILTRAR">


                    </form>
                </div>
                <div class="container-visualizar mtop-50">
                    <div class="linha">
                        <div>
                            <img src="img/box.png" alt="home">
                        </div>
                    </div>
                    <h3 class="titulo">
                        PRODUTOS
                    </h3>
                    <h2 class="empresa-nome">
                        Augusto's Pet
                    </h2>
                    <div class="tabela">
                        <div class="linha-head">
                            <div class="coluna-head largura-pequena">
                                Cód
                            </div>
                            <div class="coluna-head">
                                Nome
                            </div>
                            <div class="coluna-head">
                                Preço
                            </div>
                            <div class="coluna-head largura-pequena">
                                Quantidade
                            </div>
                            <div class="coluna-head">
                                Categoria
                            </div>
                            <div class="coluna-head largura-pequena">
                                Imagem
                            </div>
                            <div class="coluna-head">
                                Opções
                            </div>
                        </div>

                        <?php
                            $count = (int)0;
                            $cor = "";
                            $atencao = "";

                            if(isset($_GET['btn-nome-produto'])){
                                
                                $sql="SELECT produtos.*, categoria.nome AS categoria FROM produtos
                                INNER JOIN categoria ON produtos.id_categoria = categoria.id WHERE produtos.ativado = 1 AND produtos.nome 
                                LIKE '%".$_GET['txt-nome']."%'";

                            }elseif(isset($_GET['btn-categoria'])){

                                $sql="SELECT produtos.*, categoria.nome AS categoria FROM produtos
                                INNER JOIN categoria ON produtos.id_categoria = categoria.id WHERE produtos.ativado = 1 
                                AND categoria.id = ".$_GET['stl-categoria'];

                            }else{

                                $sql="SELECT produtos.*, categoria.nome AS categoria FROM produtos
                                INNER JOIN categoria ON produtos.id_categoria = categoria.id WHERE produtos.ativado = 1 ORDER BY produtos.id ASC
                                ";

                            }

                            $select = mysqli_query($conexao, $sql);

                            while($rsConsulta = mysqli_fetch_array($select)){
                            $count ++;
                            if($count % 2 == 0){
                                $cor = "cor";
                                
                                if($rsConsulta['quantidade'] <= 3){
                                    $atencao = "<img src='../icon/warning.png' alt='atencao'>";
                                }else{
                                    $atencao = "";
                                }

                            }else{
                                $cor = "";

                                if($rsConsulta['quantidade'] <= 3){
                                    $atencao = "<img src='../icon/warning.png' alt='atencao'>";
                                }else{
                                    $atencao = "";
                                }

                            }        
                            
                        ?>

                        <div class="linha-tabela alturaLinhaProduto <?=$cor?>">
                            <div class="coluna-tabela largura-pequena">
                                <?=$rsConsulta['id']?>
                            </div>
                            <div class="coluna-tabela">
                                <?=$rsConsulta['nome']?>
                            </div>
                            <div class="coluna-tabela">
                                R$<?=number_format($rsConsulta['preco'],2,",",".")?>
                            </div>
                            <div class="coluna-tabela largura-pequena">
                                <?=$rsConsulta['quantidade']?> <?=$atencao?>
                            </div>
                            <div class="coluna-tabela">
                                <?=$rsConsulta['categoria']?>
                            </div>
                            <div class="coluna-tabela largura-pequena">
                                <img src="../bd/arquivos/<?=$rsConsulta['imagem']?>" alt="foto-produto" class="foto-produto">
                            </div>
                            <div class="coluna-tabela">
                                <a onclick="return confirm('Deseja excluir esse produto')" href="../bd/deletar.php?modo=deletarproduto&id=<?=$rsConsulta['id']?>">
                                    <img src="img/cancel2.png" alt="delete">
                                </a>
                                
                                    <img src="img/search2.png" alt="buscar" class="visualizar" onclick="visualizarDados(<?=$rsConsulta['id']?>);">
                                
                                <a href="cadastrar-produtos.php?modo=editar&id=<?=$rsConsulta['id']?>">
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