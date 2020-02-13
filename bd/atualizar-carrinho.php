<?php
    if(isset($_GET['modo'])){

        $saida_produto = 1;

        if(strtoupper($_GET['modo']) == 'EXCLUIR'){
            require_once('conexao.php');
            $conexao = conexaoMysql();

            $idProduto = $_GET['idproduto'];
            $idCarrinho = $_GET['carrinho'];
            $idCliente = $_GET['idcliente'];
            

            $sql = "DELETE FROM carrinho_produto WHERE id_produto =".$idProduto." AND id_carrinho = ".$idCarrinho;

            if(mysqli_query($conexao, $sql)){
                mysqli_close($conexao);
                header('location: ../compra.php?carrinho='.$idCarrinho.'&idcliente='.$_GET['idcliente']);
            }
        }elseif(strtoupper($_GET['modo']) == 'INSERIR'){
            require_once('conexao.php');
            $conexao = conexaoMysql();

            $idProduto = $_GET['idproduto'];
            $idCarrinho = $_GET['carrinho'];
            $idCliente = $_GET['idcliente'];
            $preco = $_GET['preco'];

            $sqlValidacao = "SELECT * FROM carrinho_produto WHERE id_produto = ".$idProduto." AND id_carrinho = ".$idCarrinho;

            $selectValidacao = mysqli_query($conexao, $sqlValidacao);

            if($rsValidacao = mysqli_fetch_array($selectValidacao)){

                if($rsValidacao['id_produto'] == $idProduto){

                    $sql = "UPDATE carrinho_produto SET saida_produto = saida_produto + 1 WHERE
                    id_produto =".$idProduto." AND id_carrinho = ".$idCarrinho;

                    if(mysqli_query($conexao, $sql)){

                        $sqlPreco = "UPDATE carrinho_produto SET saida_preco =".$preco." * saida_produto WHERE
                        id_produto =".$idProduto." AND id_carrinho = ".$idCarrinho;

                        if(mysqli_query($conexao, $sqlPreco)){
                            
                            header('location: ../compra.php?carrinho='.$idCarrinho.'&idcliente='.$idCliente);
                        }else{
                            header('location: ../erro.php');
                        }

                    }
                }else{
                    
                    $sql = "INSERT INTO carrinho_produto (id_produto, id_carrinho, saida_produto,saida_preco)
                    VALUES (".$idProduto.", ".$idCarrinho.",".$saida_produto.",".$preco.")";

                    if(mysqli_query($conexao, $sql)){
                        
                        header('location:../compra.php?carrinho='.$idCarrinho.'&idcliente='.$idCliente);
                    }else{
                        header('location: ../erro.php');
                    }

                }
            }else{
                $sql = "INSERT INTO carrinho_produto (id_produto, id_carrinho, saida_produto,saida_preco)
                VALUES (".$idProduto.", ".$idCarrinho.",".$saida_produto.",".$preco.")";

                if(mysqli_query($conexao, $sql)){
                    
                    header('location:../compra.php?carrinho='.$idCarrinho.'&idcliente='.$idCliente);
                }else{
                    header('location: ../erro.php');
                }
            }
            
            
        }elseif(strtoupper($_GET['modo']) == 'AUMENTAR'){
            require_once('conexao.php');
            $conexao = conexaoMysql();

            $idProduto = $_GET['idproduto'];
            $idCarrinho = $_GET['carrinho'];
            $idCliente = $_GET['idcliente'];
            $preco = $_GET['preco'];

            $sql = "UPDATE carrinho_produto SET saida_produto = saida_produto + 1 WHERE
            id_produto =".$idProduto." AND id_carrinho = ".$idCarrinho;

            if(mysqli_query($conexao, $sql)){

                $sqlPreco = "UPDATE carrinho_produto SET saida_preco = ".$preco." * saida_produto WHERE
                id_produto =".$idProduto." AND id_carrinho = ".$idCarrinho;

                if(mysqli_query($conexao, $sqlPreco)){
                    header('location: ../compra.php?carrinho='.$idCarrinho.'&idcliente='.$idCliente);
                }
            }else{
                echo($sql);
            }
        }elseif(strtoupper($_GET['modo']) == 'DIMINUIR'){
            require_once('conexao.php');
            $conexao = conexaoMysql();

            $idProduto = $_GET['idproduto'];
            $idCarrinho = $_GET['carrinho'];
            $idCliente = $_GET['idcliente'];
            $preco = $_GET['preco'];

            $sql = "UPDATE carrinho_produto SET saida_produto = saida_produto - 1 WHERE
            id_produto = ".$idProduto." AND id_carrinho = ".$idCarrinho;

            if(mysqli_query($conexao, $sql)){

                $sqlverificar = "SELECT * FROM carrinho_produto WHERE id_produto = ".$idProduto." AND id_carrinho = ".$idCarrinho;

                $select = mysqli_query($conexao, $sqlverificar);

                $rsConsulta = mysqli_fetch_array($select);

                if($rsConsulta['saida_produto'] <= 0 ){

                    $sql = "DELETE FROM carrinho_produto WHERE id_produto =".$idProduto." AND id_carrinho = ".$idCarrinho;

                    if(mysqli_query($conexao, $sql)){
                        
                        header('location: ../compra.php?carrinho='.$idCarrinho.'&idcliente='.$idCliente);
                    }

                }else{

                    $sqlPreco = "UPDATE carrinho_produto SET saida_preco = saida_preco - ".$preco." WHERE
                    id_produto =".$idProduto." AND id_carrinho = ".$idCarrinho;

                    if(mysqli_query($conexao, $sqlPreco)){
                        mysqli_close($conexao);
                        header('location: ../compra.php?carrinho='.$idCarrinho.'&idcliente='.$idCliente);
                    }
                }
            }else{
                echo($sql);
            }
        }elseif(strtoupper($_GET['modo']) == 'INSERIRSERVICO'){
            require_once('conexao.php');
            $conexao = conexaoMysql();

            $idServico = $_GET['idservico'];
            $idCarrinho = $_GET['carrinho'];
            $preco_servico = $_GET['preco'];

            $sqlServico = "INSERT INTO carrinho_servico (id_servico, id_carrinho, saida_preco) VALUES
            (".$idServico.",".$idCarrinho.",".$preco_servico.")";

            if(mysqli_query($conexao, $sqlServico)){
                header('location: ../compra.php?carrinho='.$idCarrinho.'&idcliente='.$idCliente);
            }else{
                echo($sqlServico);
            }



        }elseif(strtoupper($_GET['modo']) == 'EXCLUIRSERVICO'){
            require_once('conexao.php');
            $conexao = conexaoMysql();

            $idServico = $_GET['idservico'];
            $idCarrinho = $_GET['carrinho'];

            $sql = "DELETE FROM carrinho_servico WHERE id_servico =".$idServico." AND id_carrinho = ".$idCarrinho;

            if(mysqli_query($conexao, $sql)){
                mysqli_close($conexao);
                header('location: ../compra.php?carrinho='.$idCarrinho);
            }
        }
    }

?>