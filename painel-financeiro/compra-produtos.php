<?php
    require_once('../bd/conexao.php');
    require_once('modulos/verificar-status.php');

    $conexao = conexaoMysql();

    $data_inicial = (String) "";
    $data_final = (String)"";
    $dia = (String)"";


    if(isset($_GET['modo'])){
        if(strtoupper($_GET['modo']) == "PERIODO"){

            $data_inicial = $_POST['data-inicio'];
            $data_final = $_POST['data-final'];

        }elseif(strtoupper($_GET['modo']) == "DIA"){

            $dia = $_POST['data-especifica'];

        }
    }

    
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
    <body style="background-image:url('img/background-home.jpg');
                 background-size:cover;" >
        <div id="painel-produtos">
            <?php
                require_once('modulos/menu.php');
            ?>
            <div class="auxiliar"></div>
            <div class="home-painel ">
                <div class="pesquisar-produto">
                    <form action="compra-produtos.php?modo=periodo" method="post" class="pesquisa-periodo">
                        <h6>periodo inicial</h6>
                        <input type="date" name="data-inicio" value="<?=$data_inicial?>" class="periodo-compra" required>

                        <h6>periodo final</h6>
                        <input type="date" name="data-final" value="<?=$data_final?>" class="periodo-compra" required>

                        <input name="btn-periodo" type="submit" value="Filtrar" class="botao-periodo">
                    </form>
                    <form action="compra-produtos.php?modo=dia" method="post" class="dia-compra">
                        <h6>Selecionar dia específico</h6>
                        <input type="date" name="data-especifica" value="<?=$dia?>" class="periodo-compra">
                        <input type="submit" name="btn-dia" value="Filtrar" class="botao-dia">
                    </form>

                    
                </div>
                <div class="container-welcome mtop-50 white largura-grande altura-grande">
                    <div class="linha orange">
                        <div>
                            <img src="../icon/money.png" alt="home">
                        </div>
                        
                    </div>
                    <div class="tabela largura-grande">

                        <div class="linha-head azul-compra">
                            <div class="coluna-tabela  white-text largura-pequena">
                                Data
                            </div>
                            <div class="coluna-tabela white-text largura-pequena">
                                Horario
                            </div>
                            <div class="coluna-tabela white-text">
                                Cliente
                            </div>
                            <div class="coluna-tabela white-text">
                                Forma de pagamento
                            </div>
                            <div class="coluna-tabela white-text largura-pequena">
                                Valor venda <img src="../icon/coin.png" alt="lucro">
                            </div>
                            <div class="coluna-tabela white-text  largura-pequena">
                                Lucro <img src="../icon/up.png" alt="lucro">
                            </div>
                            <div class="coluna-tabela white-text largura-pequena">
                                Detalhes
                            </div>
                        </div>
                        <?php

                            if(isset($_POST['btn-periodo'])){
                                
                                $data_inicio = $_POST['data-inicio'];
                                $data_final = $_POST['data-final'];

                                $sql = "SELECT compra.*, clientes.nome AS cliente, forma_pagamento.nome AS pagamento FROM compra LEFT JOIN clientes
                                        ON compra.id_cliente = clientes.id INNER JOIN forma_pagamento ON compra.id_formapagamento =
                                        forma_pagamento.id WHERE compra.data_compra BETWEEN '".$data_inicio."' AND '".$data_final."';";

                            }elseif(isset($_POST['btn-dia'])){

                                $data_especifica = $_POST['data-especifica'];

                                $sql = "SELECT compra.*, clientes.nome AS cliente, forma_pagamento.nome AS pagamento FROM compra LEFT JOIN clientes
                                        ON compra.id_cliente = clientes.id INNER JOIN forma_pagamento ON compra.id_formapagamento =
                                        forma_pagamento.id WHERE compra.data_compra = '".$data_especifica."'";
                                
                            }else{
                                $sql = "SELECT compra.*, clientes.nome AS cliente, forma_pagamento.nome AS pagamento FROM compra LEFT JOIN clientes
                                        ON compra.id_cliente = clientes.id INNER JOIN forma_pagamento ON compra.id_formapagamento =
                                        forma_pagamento.id";
                            }
                        
                            

                            // $sql = "SELECT * FROM compra";

                            $select = mysqli_query($conexao, $sql);
                            
                            $i = (int) 0;
                            $zebrado = (String) 'zebrar';
                            $arrayTotal = array ();
                            $arrayLucro = array ();

                            while( $rsConsulta = mysqli_fetch_array($select) ){

                                array_push($arrayTotal, $rsConsulta['preco_total'] );

                                $data = explode('-', $rsConsulta['data_compra']);
                                $data = $data[2]."/".$data[1]."/".$data[0];

                                $hora = explode(':', $rsConsulta['horario_compra']);
                                $hora = $hora[0].":".$hora[1];

                                $i++;

                                if($i % 2 == 0)
                                    $zebrado = '';
                                else
                                    $zebrado = 'zebrar';


                                if($rsConsulta['cliente'] == ""){

                                    $rsConsulta['cliente'] = "Cliente não cadastrado";

                                }

                                $sqlProduto = " SELECT carrinho_produto.*, produtos.* FROM carrinho_produto INNER JOIN produtos ON carrinho_produto.id_produto
                                = produtos.id WHERE carrinho_produto.id_carrinho = ".$rsConsulta['id_carrinho'];

                                $selectProduto = mysqli_query($conexao, $sqlProduto);

                                while($rsProdutos = mysqli_fetch_array($selectProduto)){

                                    $lucro = $rsProdutos['saida_produto'] * $rsProdutos['preco_compra'];

                                }

                                array_push($arrayLucro, $lucro);


                                $totalLucro = $rsConsulta['preco_total'] - $lucro;
                                


                        ?>

                        <div class="linha-tabela black-text <?=$zebrado?>">
                            <div class="coluna-tabela largura-pequena">
                                <?=$data?>
                            </div>
                            <div class="coluna-tabela largura-pequena">
                                <?=$hora?>
                            </div>
                            <div class="coluna-tabela">
                                <?=$rsConsulta['cliente']?>
                            </div>
                            <div class="coluna-tabela ">
                                <?=$rsConsulta['pagamento']?>
                            </div>
                            <div class="coluna-tabela largura-pequena">
                                R$ <?=number_format($rsConsulta['preco_total'],2,',','.')?>
                            </div>
                            <div class="coluna-tabela largura-pequena">
                                R$ <?=number_format($totalLucro,2,",",".")?>
                            </div>
                            <div class="coluna-tabela largura-pequena">
                                <a target="_blank" href="../modalCompras.php?idcompra=<?=$rsConsulta['id']?>&idcliente=<?=$rsConsulta['id_cliente']?>" id="imprimir">
                                    <img src="../icon/lupa.png" alt="detalhes">
                                </a>
                            </div>
                        </div>




                        <?php

                            }
                            $totalEmVendas = array_sum($arrayTotal);
                            $totalEmLucro = array_sum($arrayLucro);
                        
                        ?>
                        <div id="total-entradas">
                            Total vendas: <?=number_format($totalEmVendas,2,',','.')?>
                        </div>
                        <div id="lucroTotal">
                            Lucro total: <?=number_format($totalEmLucro,2,',','.')?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>