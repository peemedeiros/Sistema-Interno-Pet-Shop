<?php
    require_once('../bd/conexao.php');
    $conexao = conexaoMysql();
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
            <div class="home-painel ">
                <div class="container-visualizar vermelho-bg">
                    <div class="linha vermelho">
                        <div>
                            <img src="img/box.png" alt="home">
                        </div>
                    </div>
                    <h3 class="titulo">
                        Produtos em falta
                    </h3>
                    <h2 class="empresa-nome">
                        Augusto's Pet
                    </h2>
                    <div class="tabela">
                        <div class="linha-head vermelho-head">
                            <div class="coluna-head">
                                Cód
                            </div>
                            <div class="coluna-head">
                                Nome
                            </div>
                            <div class="coluna-head">
                                Preço
                            </div>
                            <div class="coluna-head">
                                Quantidade
                            </div>
                            <div class="coluna-head">
                                Categoria
                            </div>
                            <div class="coluna-head">
                                Opções
                            </div>
                        </div>

                        <?php
                            $count = (int)0;
                            $cor = "";
                            $sql="SELECT produtos.*, categoria.nome AS categoria FROM produtos
                            INNER JOIN categoria ON produtos.id_categoria = categoria.id WHERE produtos.quantidade <= 3 AND produtos.ativado = 1
                             ORDER BY produtos.id ASC";

                            $select = mysqli_query($conexao, $sql);

                            while($rsConsulta = mysqli_fetch_array($select)){
                            $count ++; 
                            if($count % 2 == 0){
                                $cor = "vermelho-bg";
                            }else{
                                $cor = "";
                            }
                            
                        ?>

                        <div class="linha-tabela <?=$cor?>">
                            <div class="coluna-tabela">
                                <?=$rsConsulta['id']?>
                            </div>
                            <div class="coluna-tabela">
                                <?=$rsConsulta['nome']?>
                            </div>
                            <div class="coluna-tabela">
                                R$<?=number_format($rsConsulta['preco'],2,",",".")?>
                            </div>
                            <div class="coluna-tabela">
                                <?=$rsConsulta['quantidade']?>
                            </div>
                            <div class="coluna-tabela">
                                <?=$rsConsulta['categoria']?>
                            </div>
                            <div class="coluna-tabela">
                                
                                <img src="img/search2.png" alt="buscar" class="visualizar" onclick="visualizarDados(<?=$rsConsulta['id']?>);">
                                
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