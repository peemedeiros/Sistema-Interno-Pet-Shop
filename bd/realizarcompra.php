<?php

$nomeCliente = (String)"Cliente não cadastrado";

$totalAPagar = (Double)0;

$idCarrinho = $_GET['carrinho'];

    if(isset($_GET['carrinho'])){

        require_once('conexao.php');
        $conexao = conexaoMysql();

        if($_GET['idcliente'] != ""){

            $sql = "SELECT carrinho_temporario.id_cliente, clientes.*, clientes.id AS idcliente FROM carrinho_temporario
            INNER JOIN clientes ON carrinho_temporario.id_cliente = clientes.id WHERE
            carrinho_temporario.id = ".$idCarrinho;

            $select = mysqli_query($conexao, $sql);

            if($rsConsulta = mysqli_fetch_array($select)){

                $nomeCliente = $rsConsulta['nome'];
            
                $idCliente = $rsConsulta['idcliente'];

                $valorTotal = array();

                $sql = "SELECT * FROM carrinho_produto WHERE id_carrinho = ".$idCarrinho;

                $select = mysqli_query($conexao, $sql);
                
                while($rsConsulta = mysqli_fetch_array($select))
                {
                    array_push($valorTotal, $rsConsulta['saida_preco']);
                }

                $totalAPagar = array_sum($valorTotal);

            }

        }else{

            $valorTotal = array();

            $sql = "SELECT * FROM carrinho_produto WHERE id_carrinho = ".$idCarrinho;

            $select = mysqli_query($conexao, $sql);
            
            while($rsConsulta = mysqli_fetch_array($select))
            {
                array_push($valorTotal, $rsConsulta['saida_preco']);
            }

            $totalAPagar = array_sum($valorTotal);

        }

    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../css/styles.css">
        <title>Augusto's Pet</title>
    </head>
    <body>
        <div class="pagina-inicial-compra">
            <div class="container-realizar-compra">
                <form  action="cadastrar-compra.php?carrinho=<?=$idCarrinho?>&idcliente=<?=$_GET['idcliente']?>" method="POST" class="main-compra">
                    <h1 class="titulo texto-center">
                        Confirmar Compra
                    </h1>
                    <hr>
                    <div class="linha-realizar-compra">
                        <div class="coluna-realizar-compra-head">
                            CLIENTE:
                            <label for="nome-cliente-compra"><?=$nomeCliente?></label>
                            <input value="<?=$_GET['idcliente']?>" type="text" name="idcliente" class="compra-nome-head" id="nome-cliente-compra" readonly>
                        </div>
                        <div class="coluna-realizar-compra-head-valor">
                            Total a pagar:
                            <h4>R$</h4><input value="<?=number_format($totalAPagar,2,',','.')?>" type="text" name="precototal" class="compra-nome-head-valor" readonly>
                            
                        </div>
                        <div class="coluna-realizar-compra">
                            
                            <select name="slt-pagamento" id="forma-pagamento" required>
                                <option value="">SELECIONE FORMA DE PAGAMENTO</option>
                                <?php
                                    $sql = "SELECT * FROM forma_pagamento";
                                    $select = mysqli_query($conexao, $sql);
                                    while($rsConsulta = mysqli_fetch_array($select))
                                    {
                                ?>
                                <option value="<?=$rsConsulta['id']?>"><?=$rsConsulta['nome']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="tabela-confimacao-compra center">
                        <div class="linha-confirmacao-compra-head">
                            <div class="coluna-confirmacao-compra-head">
                                NOME
                            </div>
                            <div class="coluna-confirmacao-compra-head">
                                QUANTIDADE
                            </div>
                            <div class="coluna-confirmacao-compra-head">
                                PREÇO
                            </div>
                            <div class="coluna-confirmacao-compra-head">
                                VISUALIZAR
                            </div>
                        </div>

                        <?php
                            require_once('conexao.php');
                            $conexao = conexaoMysql();
                            $count = (int)0;
                            $cor = (String)"";

                            $sql = "SELECT carrinho_produto.*, produtos.nome FROM carrinho_produto
                            INNER JOIN produtos ON carrinho_produto.id_produto = produtos.id
                            WHERE carrinho_produto.id_carrinho =".$idCarrinho;

                            $select = mysqli_query($conexao, $sql);

                            while($rsConsulta = mysqli_fetch_array($select))
                            {
                            
                        ?>

                        <div class="linha-confirmacao-compra">
                            <div class="coluna-confirmacao-compra">
                                <input value="<?=$rsConsulta['nome']?>" type="text" name="txt-nome" class="compra-nome" readonly>
                            </div>
                            <div class="coluna-confirmacao-compra">
                                <input value="<?=$rsConsulta['saida_produto']?>" type="text" name="txt-nome" class="compra-nome" readonly>
                            </div>
                            <div class="coluna-confirmacao-compra">
                                <input value="<?=number_format($rsConsulta['saida_preco'], 2, ',',' . ');?>" type="text" name="txt-nome" class="compra-nome" readonly>
                            </div>
                            <div class="coluna-confirmacao-compra">
                                <a href="">
                                    <img src="../icon/lupa.png" alt="delete">
                                </a>
                            </div>
                        </div>
                        <?php
                        
                            }
                        
                        ?>
                    </div>

                    
                    <div class="linha">
                        <button class="botao">
                            <a href="../compra.php?carrinho=<?=$idCarrinho?>&idcliente=<?=$idCliente?>">
                                VOLTAR
                            </a>
                        </button>
                        <input type="submit" value="CONFIRMAR" name="btn-cadastrar-compra" class="botao texto-center">
                    </div>
                    
                </form>
            </div>
        </div>
    </body>
</html>