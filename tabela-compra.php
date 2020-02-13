


<?php

require_once('bd/conexao.php');
$conexao = conexaoMysql();

$saida_produto = (int)1;
$valorTotal =(int)0;

if(isset($_POST['modo'])){
    if(strtoupper($_POST['modo']) == "VISUALIZAR"){
        session_start();

        $id = $_POST['id'];
        $carrinho = $_POST['carrinho'];
        
        $sqlBuy = "INSERT INTO carrinho_produto (id_produto, id_carrinho, saida_produto)
        VALUES (".$id.", ".$carrinho.",".$saida_produto.")";

        if(mysqli_query($conexao, $sqlBuy))
        {

            $sqlPreco = "SELECT carrinho_produto.*, produtos.preco FROM carrinho_produto
            INNER JOIN produtos ON carrinho_produto.id_produto = produtos.id
            WHERE carrinho_produto.id_carrinho = ".$carrinho;

            $selectPreco = mysqli_query($conexao, $sqlPreco);

            while($rsPreco = mysqli_fetch_array($selectPreco))
            {
                $valorTotal += $rsPreco['preco'];
            }

            $update_valor = "UPDATE carrinho_temporario SET preco_temp =".$valorTotal;

            if(mysqli_query($conexao, $update_valor))
            {

                $sql = "SELECT produtos.nome AS produto, produtos.id, produtos.preco ,carrinho_produto.* FROM produtos
                INNER JOIN carrinho_produto ON produtos.id = carrinho_produto.id_produto
                WHERE carrinho_produto.id_carrinho = ".$carrinho;

                $select = mysqli_query($conexao, $sql);
            ?>     
            <?php
                while($rsConsulta = mysqli_fetch_array($select))
                {
                    ?>
                        <div class="linha-tabela-compra">
                            <div class="thead-coluna-quatidade-linha">
                                <button>+</button>
                                1
                                <button>-</button>
                            </div>
                            
                            <div class="coluna-tabela-compra">
                                <?=$rsConsulta['produto']?>
                            </div>
                            <div class="coluna-tabela-compra">
                                R$<?=$rsConsulta['preco']?>
                            </div>
                            <div class="thead-coluna-quatidade">
                                <a href="bd/atualizar-carrinho.php?carrinho=<?=$carrinho?>&idproduto=<?=$rsConsulta['id']?>&modo=excluir">
                                    <img src="./icon/cancel.png" alt="delete">
                                </a>
                            </div>
                        </div>
                        

                    <?php
                }


            }else{
                echo($update_valor);
            }

        }else{
            echo("NAO INSERIO NO CARRINHO_PRODUTO");
            echo($sqlBuy);
        }

    }
}
?>  
<div class="linhaTotal">
    <h4>TOTAL</h4>
    <h4><?=$valorTotal?></h4>
</div>


