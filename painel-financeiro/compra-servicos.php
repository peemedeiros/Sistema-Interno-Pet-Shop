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
                    <form action="compra-servicos.php?modo=periodo" method="post" class="pesquisa-periodo">
                        <h6>periodo inicial</h6>
                        <input type="date" name="data-inicio" value="<?=$data_inicial?>" class="periodo-compra" required>

                        <h6>periodo final</h6>
                        <input type="date" name="data-final" value="<?=$data_final?>" class="periodo-compra" required>

                        <input name="btn-periodo" type="submit" value="Filtrar" class="botao-periodo">
                    </form>
                    <form action="compra-servicos.php?modo=dia" method="post" class="dia-compra">
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
                                Valor Total <img src="../icon/coin.png" alt="lucro">
                            </div>
                            
                            <div class="coluna-tabela white-text largura-pequena">
                                Detalhes
                            </div>
                        </div>
                        <?php

                            if(isset($_POST['btn-periodo'])){

                                $data_inicio = $_POST['data-inicio'];
                                $data_final = $_POST['data-final'];

                                $sql = "SELECT ordem_servico.*, forma_pagamento.nome AS pagamento FROM ordem_servico
                                    INNER JOIN forma_pagamento ON ordem_servico.id_formapagamento = forma_pagamento.id
                                    WHERE ordem_servico.data_ordem BETWEEN '".$data_inicial."' AND '".$data_final."'";

                            }elseif(isset($_POST['btn-dia'])){

                                $data_especifica = $_POST['data-especifica'];

                                $sql = "SELECT ordem_servico.*, forma_pagamento.nome AS pagamento FROM ordem_servico
                                    INNER JOIN forma_pagamento ON ordem_servico.id_formapagamento = forma_pagamento.id
                                    WHERE ordem_servico.data_ordem = '".$data_especifica."'";

                            }else{

                                $sql = "SELECT ordem_servico.*, forma_pagamento.nome AS pagamento FROM ordem_servico
                                    INNER JOIN forma_pagamento ON ordem_servico.id_formapagamento = forma_pagamento.id";

                            }

                            

                            $select = mysqli_query($conexao, $sql);
                            
                            $i = (int) 0;
                            $zebrado = (String) 'zebrar';
                            $arrayTotal = array ();


                            while( $rsConsulta = mysqli_fetch_array($select) ){

                                $data = explode('-', $rsConsulta['data_ordem']);
                                $data = $data[2]."/".$data[1]."/".$data[0];

                                $hora = explode(':', $rsConsulta['horario_ordem']);
                                $hora = $hora[0].":".$hora[1];

                                $i++;

                                if($i % 2 == 0)
                                    $zebrado = '';
                                else
                                    $zebrado = 'zebrar';

                            array_push($arrayTotal, $rsConsulta['total']+$rsConsulta['valor_transporte']);


                        ?>

                        <div class="linha-tabela black-text <?=$zebrado?>">
                            <div class="coluna-tabela largura-pequena">
                                <?=$data?>
                            </div>
                            <div class="coluna-tabela largura-pequena">
                                <?=$hora?>
                            </div>
                            <div class="coluna-tabela">
                                <?=$rsConsulta['nome_cliente']?>
                            </div>
                            <div class="coluna-tabela ">
                                <?=$rsConsulta['pagamento']?>
                            </div>
                            <div class="coluna-tabela largura-pequena">
                                R$ <?=number_format($rsConsulta['total']+$rsConsulta['valor_transporte'],2,',','.')?>
                            </div>
                            <div class="coluna-tabela largura-pequena">
                                <a target="_blank" href="../os.php?idos=<?=$rsConsulta['id']?>&pagamento=<?=$rsConsulta['id_formapagamento']?>">
                                    <img src="../icon/lupa.png" class="transporteInfo" alt="visualizar">
                                </a>
                            </div>
                        </div>

                        <?php

                            }
                            $totalEmServicos = array_sum($arrayTotal);
                        
                        ?>
                        <div id="total-servicos">
                            Total serviços: <?=number_format($totalEmServicos,2,',','.')?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>