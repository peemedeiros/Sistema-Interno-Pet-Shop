<?php

    require_once('bd/conexao.php');
    $conexao = conexaoMysql();

    $idcliente=(String)"";

    if(isset($_GET['idcliente'])){
        $idcliente = $_GET['idcliente'];
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>SIAP</title>
        <link rel="stylesheet" href="css/styles.css">
        <script src="js/jquery.js"></script>
        <script src="painel-produtos/js/toggle-menu.js"></script>
    </head>
    <body>
    <div class="pagina-inicial-atendimento">
            <?php
                require_once('./modulo/menu.php');
            ?>
            
            <div class="container-compra azul-marinho txt-black">

            
                <div class="compra">
                    
                    <div class="compra-col">
                    <h1 class="titulo">
                        Produtos
                    </h1>
                    
                            <div class="adicionar-produtos">

                                <div class="pesquisar-produto">
                                    <div class="linha">
                                        <h6>Nome</h6>
                                        <form action="bd/pesquisar-nome.php" method="post">
                                            <input type="text" name="pesquisar-produto" class="input-produto">
                                            <input type="text" name="idcarrinho" value="<?=$_GET['carrinho']?>" class="displayNone">
                                            <input type="text" name="idcliente" value="<?=$_GET['idcliente']?>" class="displayNone">
                                            <button type="submit" name="btn-pesquisar-nome" class="btn-filtro">

                                            </button>
                                        </form>

                                        <h6>codigo</h6>

                                        <input type="text" name="pesquisar-produto" class="input-produto-codigo">
                                        <button type="submit" class="btn-filtro">

                                        </button>
                                    </div>

                                    <div class="linha">
                                        <h6>Categoria</h6>
                                        <select name="slt-categoria-compra" class="input-produto">
                                            <option value="">categoria</option>
                                        </select>
                                        <button type="submit" class="btn-filtro">

                                        </button>
                                    </div>
                                </div>
                                <div class="tabela-produtos-compra">
                                    <div class="tabela-produtos-compra">
                                    
                                        <div class="thead-linha">
                                            
                                            <div class="thead-coluna">
                                                Cód.
                                            </div>
                                            <div class="thead-coluna">
                                                Nome
                                            </div>
                                            <div class="thead-coluna">
                                                Preço
                                            </div>
                                            <div class="coluna-tabela-compra-add">
                                                
                                            </div>
                                            
                                        </div>

                                        <?php

                                            $count = (int)1;
                                            $cor = (String)"";

                                            if(!isset($_GET['produto']))
                                                $sql = " select * from produtos where ativado = 1 and quantidade > 0 ";
                                            else
                                                $sql = " select * from produtos where ativado = 1 and nome LIKE '%".$_GET['produto']."%' ";


                                            $select = mysqli_query($conexao, $sql);

                                            while($rsProdutos = mysqli_fetch_array($select)){

                                                $count +=1;

                                                if($count % 2 == 0)
                                                    $cor = "cor";
                                                else
                                                    $cor = "";

                                        ?>
                                        <div class="linha-tabela-compra <?=$cor?>">
                                            <div class="coluna-tabela-compra">
                                                <?=$rsProdutos['id']?>
                                            </div>
                                            <div class="coluna-tabela-compra">
                                                <?=$rsProdutos['nome']?>
                                            </div>
                                            <div class="coluna-tabela-compra">
                                                R$ <?=$rsProdutos['preco']?>
                                            </div>
                                            <div class="coluna-tabela-compra-add">
                                                <button >
                                                    <a href="bd/atualizar-carrinho.php?idproduto=<?=$rsProdutos['id']?>&carrinho=<?=$_GET['carrinho']?>&preco=<?=$rsProdutos['preco']?>&modo=inserir&idcliente=<?=$_GET['idcliente']?>">
                                                        +
                                                    </a>
                                                </button>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                       
                                    </div>  
                                </div>
                                
                            </div>
                        

                    
                    </div>



                    <div class="compra-col-1">
                        <h1 class="titulo">
                            Pedido
                        </h1>
                        <div class="pedido">
                           
                            <div class="tabela-pedidos">

                            

                                <div class="thead-linha">
                                    <div class="thead-coluna-quatidade">
                                        Qtd.
                                    </div>
                                    <div class="thead-coluna">
                                        Nome
                                    </div>
                                    <div class="thead-coluna">
                                        Preço
                                    </div>
                                    <div class="thead-coluna-quatidade">
                                        Opções
                                    </div>
                                    
                                </div>
                           
                                <div id="tabela-compra">


                                <?php
                            
                                if(isset($_GET['carrinho'])){

                                    $sql = "SELECT produtos.*, carrinho_produto.*
                                    FROM produtos INNER JOIN carrinho_produto ON
                                    produtos.id = carrinho_produto.id_produto WHERE
                                    carrinho_produto.id_carrinho = ".$_GET['carrinho'];

                                    $select = mysqli_query($conexao, $sql);

                                    while($rsCarrinho = mysqli_fetch_array($select)){

                                    
                                
                                ?>

                                    <div class="linha-tabela-compra">
                                        <div class="thead-coluna-quatidade-linha">
                                            <button>
                                                <a href="bd/atualizar-carrinho.php?idproduto=<?=$rsCarrinho['id']?>&carrinho=<?=$_GET['carrinho']?>&preco=<?=$rsCarrinho['preco']?>&modo=aumentar&idcliente=<?=$_GET['idcliente']?>">
                                                    +
                                                </a>
                                            </button>
                                                <?=$rsCarrinho['saida_produto']?>
                                            <button>
                                               <a href="bd/atualizar-carrinho.php?idproduto=<?=$rsCarrinho['id']?>&carrinho=<?=$_GET['carrinho']?>&preco=<?=$rsCarrinho['preco']?>&modo=diminuir&idcliente=<?=$_GET['idcliente']?>">
                                                    -
                                                </a>
                                            </button>
                                        </div>
                                        <div class="coluna-tabela-compra">
                                            <?=$rsCarrinho['nome']?>
                                        </div>
                                        <div class="coluna-tabela-compra">
                                            R$ <?=$rsCarrinho['saida_preco']?>
                                        </div>
                                        <div class="thead-coluna-quatidade">
                                            <a href="bd/atualizar-carrinho.php?carrinho=<?=$_GET['carrinho']?>&idproduto=<?=$rsCarrinho['id']?>&modo=excluir&idcliente=<?=$_GET['idcliente']?>">
                                                <img src="./icon/cancel.png" alt="delete">
                                            </a>
                                        </div>
                                        
                                    </div>
                                <?php
                                    }
                                    
                                }
                                ?>
                                </div>

                                

                                <div class="linhaTotal ">
                                    <h4>TOTAL</h4>
                                    <?php
                                        
                                        $valores = array ();

                                        $sqlPreco = "SELECT carrinho_produto.saida_preco FROM carrinho_produto
                                        WHERE carrinho_produto.id_carrinho =".$_GET['carrinho'];

                                        $select = mysqli_query($conexao, $sqlPreco);

                                        while($rsPreco = mysqli_fetch_array($select)){
                                            array_push($valores, $rsPreco['saida_preco']);
                                        }

                                        $totalAPagar = array_sum($valores);

                                    ?>
                                    <h4 id="precoTotal">
                                        R$<?=number_format($totalAPagar,2,',','.')?>
                                    </h4>
                                    
                                
                                </div>
                            </div>
                        </div>
                        <div class="resumo-pedido">
                            <button type="submit" class="botao">
                               <a href="bd/realizarcompra.php?carrinho=<?=$_GET['carrinho']?>&idcliente=<?=$idcliente?>">
                                    COMPRAR
                               </a> 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>