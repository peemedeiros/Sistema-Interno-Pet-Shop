<?php

    require_once('bd/conexao.php');
    $conexao = conexaoMysql();

    if(isset($_GET['idos'])){

    
        $sql = "SELECT ordem_servico.*, animais.nome AS animal, especies.nome AS especie FROM ordem_servico
        INNER JOIN animais ON ordem_servico.id_animal = animais.id INNER JOIN especies ON animais.id_especie = especies.id
        WHERE ordem_servico.id =".$_GET['idos'];

        $select = mysqli_query($conexao, $sql);

        if($rsConsulta = mysqli_fetch_array($select)){

            $nome_cliente = $rsConsulta['nome_cliente'];
            $contato_cliente = $rsConsulta['contato_cliente'];

            $animal = $rsConsulta['animal'];
            $especie = $rsConsulta['especie'];

            $data_ordem = explode('-', $rsConsulta['data_ordem']);
            $data_ordem = $data_ordem[2]."/".$data_ordem[1]."/".$data_ordem[0];
            
            $horario_ordem = date_create($rsConsulta['horario_ordem']);

            $obs = $rsConsulta['obs'];
            $transporte = $rsConsulta['transporte'];
            $situacao = $rsConsulta['situacao'];

            if($transporte != 0){

                // listar informacoes sobre endereco se for optado por taxi dog
                $cep = $rsConsulta['cep'];
                $logradouro = $rsConsulta['logradouro'];
                $bairro = $rsConsulta['bairro'];
                $cidade = $rsConsulta['cidade'];
                $uf = $rsConsulta['uf'];
                $numero = $rsConsulta['numero'];
                $valor_transporte = $rsConsulta['valor_transporte'];
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
        <title>SIAP</title>
        <link rel="stylesheet" href="css/styles.css">
        <script src="js/jquery.js"></script>
        <script src="painel-produtos/js/toggle-menu.js"></script>
        <script>
            $(document).ready(function(){
                $('#pagarSim').click(function(){
                    $('#linha-tabela-orderm-pay').css({
                        visibility:'visible',
                        opacity:'1'
                    });
                    $('#slt-formapagamento').attr('required','required');
                });

                $('#pagarNao').click(function(){
                    $('#linha-tabela-orderm-pay').css({
                        visibility:'hidden',
                        opacity:'0'
                    });
                    $('#slt-formapagamento').removeAttr('required');
                });
                $('#progresso-barra').css({
                    width:'100%'
                })
                $('#step').css({
                    backgroundColor:'rgb(34, 184, 42)',
                })
            });
        </script>
    </head>
    <body>

        <div class="pagina-inicial-transporte">
            <form class="formulario-agendamento-servico" method="POST" action="bd/confirmar-os.php?idos=<?=$_GET['idos']?>&transporte=<?=$transporte?>">
                <div class="progresso">
                    <div class="step step-complete">
                        1
                    </div>
                    <div class="line-step">
                        <div id="progresso-barra"></div>
                    </div>
                    <div class="step" id="step">
                        2
                    </div>

                </div>

                <div class="confirmar-informacoes-os">

                    <h3 class="texto-center margem-bottom-pequena">Confirmação dos dados</h3>

                    <div class="linha-tabela-orderm texto-center">
                        <div class="coluna-tabela-ordem">
                            NOME DO CLIENTE: <h4><?=$nome_cliente?></h4>
                        </div>
                    </div>
                    <div class="linha-tabela-orderm texto-center">
                        <div class="coluna-tabela-ordem">
                            TELEFONE PARA CONTATO: <h4><?=$contato_cliente?></h4>
                        </div>
                    </div>
                    <div class="linha-tabela-orderm texto-center">
                        <div class="coluna-tabela-ordem">
                            ANIMAL: <h4><?=$animal?></h4>
                        </div>

                        <div class="coluna-tabela-ordem">
                            ESPÉCIE: <h4><?=$especie?></h4>
                        </div>
                    </div>

                    <div class="linha-tabela-orderm texto-center">
                        <div class="coluna-tabela-ordem">
                            Data: <h4><?=$data_ordem?></h4>
                        </div>

                        <div class="coluna-tabela-ordem">
                            Horário: <h4><?=date_format($horario_ordem, "H:i")?></h4>
                        </div>
                    </div>

                    <?php
                    
                        if($transporte != 0){

                    ?>
                    <div class="linha-tabela-orderm texto-center">
                        <div class="coluna-tabela-ordem">
                            CEP:  <h4><?=$cep?></h4>
                        </div>

                        <div class="coluna-tabela-ordem">
                            Bairro: <h4><?=$bairro?></h4>
                        </div>
                    </div>

                    <div class="linha-tabela-orderm texto-center">
                    <div class="coluna-tabela-ordem">
                            Rua: <h4><?=$logradouro?></h4>
                        </div>

                        <div class="coluna-tabela-ordem">
                            Numero: <h4><?=$numero?></h4>
                        </div>
                    </div>

                    <div class="linha-tabela-orderm texto-center">

                        <div class="coluna-tabela-ordem">
                            Cidade: <h4><?=$cidade?></h4>
                        </div>
                        <div class="coluna-tabela-ordem">
                            UF: <h4><?=$uf?></h4>
                        </div>
                    </div>

                    <?php
                        }
                    ?>

                    <div class="linha-tabela-orderm texto-center">
                        <div class="coluna-tabela-ordem">
                            Realizar pagamento adiantado?
                            SIM<input type="radio" value="1" name="rdoPagar" id="pagarSim">
                            NÃO<input type="radio" value = "0" name="rdoPagar" id="pagarNao">
                        </div>
                    </div>

                    <div id="linha-tabela-orderm-pay">
                        <div class="coluna-tabela-ordem">
                            <select name="slt-formapagamento" id="slt-formapagamento">

                                <option value="">Selecione forma de pagamento</option>

                                <?php
                                    $sqlPagamento = "SELECT * FROM forma_pagamento";
                                    $selectPagamento = mysqli_query($conexao, $sqlPagamento);

                                    while($rsPagamento = mysqli_fetch_array($selectPagamento)){

                                ?>
                                 <option value="<?=$rsPagamento['id']?>"><?=$rsPagamento['nome']?></option>
                                 <?php

                                    }

                                 ?>

                            </select>
                            <img src="icon/visa.png" alt="card">
                            <img src="icon/mastercard.png" alt="card">
                            <img src="icon/money.png" alt="card">
                        </div>
                    </div>
                </div>
                <div class="servicos-escolhidos">
                    <div class="linha-servicos-escolhidos azul-marinho">
                        <div class="coluna-servicos-escolhidos">
                            SERVIÇO
                        </div>
                        <div class="coluna-servicos-escolhidos">
                            VALOR
                        </div>
                    </div>

                    <?php

                        $sqlServicos = "SELECT ordem_servico_servico.*, servicos.* FROM ordem_servico_servico
                        INNER JOIN servicos ON ordem_servico_servico.id_servico = servicos.id WHERE ordem_servico_servico.id_ordem_servico =".$_GET['idos'];

                        $selectServicos = mysqli_query($conexao, $sqlServicos);

                        $total = array();
                        $i = 0;
                        $cor = (String) "";

                        while($rsServico = mysqli_fetch_array($selectServicos)){
                            array_push($total, $rsServico['preco']);
                            $i++;

                            if($i % 2 == 0)
                                $cor = (String) "cor";
                            else
                                $cor = (String) "";

                    ?>
                    <div class="linha-servicos-escolhidos <?=$cor?>">
                        <div class="coluna-servicos-escolhidos">
                            <?=$rsServico['nome']?>
                        </div>
                        <div class="coluna-servicos-escolhidos">
                            R$ <?=number_format($rsServico['preco'], 2, ',', '.')?>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>


                <?php
                    if($transporte != 0){
                ?>

                <div class="linha-servicos-escolhidos azul-marinho ">
                    <div class="coluna-servicos-escolhidos">
                       
                    </div>
                    <div class="coluna-servicos-escolhidos flex-justify-start">
                        Valor transporte: +R$
                        <h5><?=number_format($valor_transporte, 2, ',', '.')?></h5>
                    </div>
                </div>

                <?php
                    }
                ?>




                <div class="linha-servicos-escolhidos azul-marinho">
                    <div class="coluna-servicos-escolhidos">
                       
                    </div>
                    <div class="coluna-servicos-escolhidos bold flex-justify-start">

                        <?php
                            if($transporte != 0){
                        ?>
                        
                        TOTAL: R$ 
                        <input type="text" name="txt-valor-total" value="<?=number_format(array_sum($total)+$valor_transporte, 2, ',', '.')?>" id="valor-ordem" readonly>

                        <?php
                            }else{
                        ?>

                        TOTAL: R$
                        <input type="text" name="txt-valor-total" value="<?=number_format(array_sum($total), 2, ',', '.')?>" id="valor-ordem" readonly>

                        <?php
                            }
                        ?>
                        
                    
                    
                    
                    </div>
                </div>

                <div class="linha-servicos-escolhidos">
                    <div class="coluna-servicos-escolhidos">
                        <button class="botao">
                            <a href="consumir-servicos.php?idcliente=<?=$_GET['idcliente']?>">
                                VOLTAR
                            </a>
                        </button>
                        <button type="submit" class="botao" name="btn-confirmar-os">
                            CONFIRMAR
                        </button>
                    </div>
                </div>
                
            </form>
        </div>

    </body>
</html>