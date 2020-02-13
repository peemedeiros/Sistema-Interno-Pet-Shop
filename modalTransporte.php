<?php

    require_once('bd/conexao.php');
    $conexao = conexaoMysql();

    $nome_cliente = (String)"";
    $telefone = (String)"";
    $celular = (String)"";
    $forma_pagamento = (String)"";
    $valor = (double) 0;
    $cep = (String)"";
    $logradouro = (String)"";
    $numero = (String)"";
    $bairro = (String) "";
    $cidade = (String) "";
    $estado = (String) "";
    $data_transporte = (String)"";
    $horario_transporte = (String)"";
    $situacao = (int) 0;

    if(isset($_POST['modo']))
    {
        if(strtoupper($_POST['modo']) == 'VISUALIZAR' )
        {
            $idTransporte = $_POST['id'];

           $sql = "SELECT transporte.*, forma_pagamento.nome AS pagamento FROM transporte INNER JOIN forma_pagamento 
           ON transporte.id_formapagamento = forma_pagamento.id WHERE transporte.id = ".$idTransporte;

           $select = mysqli_query($conexao, $sql);

           if($rsConsulta = mysqli_fetch_array($select))
           {

                $nome_cliente = $rsConsulta['nome_cliente'];
                $telefone = $rsConsulta['telefone'];
                $celular = $rsConsulta['celular'];
                $forma_pagamento = $rsConsulta['pagamento'];
                $valor = $rsConsulta['valor_transporte'];
                $valor_servicos = $rsConsulta['valor_servicos'];
                $cep = $rsConsulta['cep'];
                $logradouro = $rsConsulta['logradouro'];
                $numero = $rsConsulta['numero'];
                $bairro = $rsConsulta['bairro'];
                $cidade = $rsConsulta['cidade'];
                $estado = $rsConsulta['estado'];
                $data_transporte = $rsConsulta['data_transporte'];
                $horario_transporte = $rsConsulta['horario_transporte'];
                $situacao = $rsConsulta['situacao'];
                
           }
        }
    }

?>
<div class="conteudo-modal-transporte">
    <div class="linha">
        <h2>INFORMAÇÕES DO AGENDAMENTO</h2>
    </div>
    <div class="tabela-transporte-info">
        <div class="linha-transporte-info">
            <div class="coluna-transporte-info">
                Nome do cliente 
            </div>
            <div class="coluna-transporte-info-item">
                <?=$nome_cliente?>
            </div>
        </div>

        <div class="linha-transporte-info">
            <div class="coluna-transporte-info">
                Celular
            </div>
            <div class="coluna-transporte-info-item">
                <?=$celular?>
            </div>
        </div>

        <div class="linha-transporte-info">
            <div class="coluna-transporte-info">
                Forma de pagamento
            </div>
            <div class="coluna-transporte-info-item">
                <?=$forma_pagamento?>
            </div>
        </div>

        <div class="linha-transporte-info">
            <div class="coluna-transporte-info">
                Total
            </div>
            <div class="coluna-transporte-info-item">
                R$<?=number_format($valor_servicos,2,',','.')?> + Transporte R$<?=number_format($valor, 2 ,',','.')?>
            </div>
        </div>
        
        <div class="linha-transporte-info azul-claro flex-justify-content-center margem-baixo-pequena">
            <div class="coluna-transporte-info bold ">
                ENDERECO
            </div>
        </div>

        <div class="linha-transporte-info">
            <div class="coluna-transporte-info">
                CEP:<input type="text" name="cep" class="input-transporte" value="<?=$cep?>" readonly>
            </div>
            <div class="coluna-transporte-info">
                Rua: <input type="text" name="rua" class="input-transporte" value="<?=$logradouro?>" readonly>
            </div>
            <div class="coluna-transporte-info">
                Bairro: <input type="text" name="bairro" class="input-transporte" value="<?=$bairro?>" readonly>
            </div>
        </div>

        <div class="linha-transporte-info">
            <div class="coluna-transporte-info">
                Cidade:<input type="text" name="cep" class="input-transporte" value="<?=$cidade?>" readonly>
            </div>
            <div class="coluna-transporte-info">
                UF: <input type="text" name="rua" class="input-transporte" value="<?=$estado?>" readonly>
            </div>
        </div>
        
        <div class="linha-transporte-info azul-claro flex-justify-content-center margem-baixo-pequena">
            <div class="coluna-transporte-info bold">
                ANIMAIS E SERVIÇOS
            </div>
        </div>
        <div class="caixa-animais-transporte">
            <table id="tabela-transporte-animais">
                <div class="linha-animais-transporte ">
                    <div class="coluna-animais-transporte azul-marinho">Nome</div>
                    <div class="coluna-animais-transporte azul-marinho">Especie</div>
                </div>
                <?php
                    $count = 0;
                    $cor = (String)"";

                    $sqlTransporte = "SELECT transporte_animal.*, animais.nome, animais.id_especie,
                    especies.nome AS especieNome FROM transporte_animal
                    INNER JOIN animais ON transporte_animal.id_animal = animais.id
                    INNER JOIN especies ON animais.id_especie = especies.id 
                    WHERE transporte_animal.id_transporte = ".$idTransporte;
                    
                    $selectTransporte = mysqli_query($conexao, $sqlTransporte);

                    while($rsAnimais = mysqli_fetch_array($selectTransporte))
                    {
                        $count++;

                        if($count % 2 == 0)
                        {
                            $cor = "cor";
                        }else
                        {
                            $cor = "";
                        }
                ?>

                <div class="linha-animais-transporte <?=$cor?>">
                    <div class="coluna-animais-transporte"><?=$rsAnimais['nome']?></div>
                    <div class="coluna-animais-transporte"><?=$rsAnimais['especieNome']?></div>
                </div>

                <?php
                    }
                ?>
            </table>
            <table id="tabela-transporte-animais">
                <div class="linha-animais-transporte ">
                    <div class="coluna-animais-transporte azul-marinho">Serviços</div>
                </div>
                <?php
                    $sqlServicos = "SELECT servicos.*, transporte_servico.* FROM servicos 
                    INNER JOIN transporte_servico ON servicos.id = transporte_servico.id_servico
                    WHERE transporte_servico.id_transporte = ".$idTransporte;
                    
                    $selectServicos = mysqli_query($conexao, $sqlServicos);

                    while($rsServico = mysqli_fetch_array($selectServicos)){
                ?>
                <div class="linha-animais-transporte ">
                    <div class="coluna-animais-transporte"><?=$rsServico['nome']?></div>
                </div>
                <?php
                    }
                ?>
            </table>
        </div>
        <div class="caixa-atualizacao-status">
            <?php
                if($situacao == 1)
                {

            ?>
            <h3 class="texto-center">Aceite ou cancele esse agendamento</h3>
            <form action="bd/atualizar-status.php" method="post">
                <input type="text" name="idtransporte" value="<?=$idTransporte?>" id="transporte-id">
                <button class="botao" type="submit" name="btn-finalizar">
                    CONFIRMAR <img src="icon/verificado.png" alt="finalizar">
                </button>
                <button class="botao" type="submit" name="btn-cancelar">
                    CANCELAR <img src="icon/cancelado.png" alt="finalizar">
                </button>
            </form>
            <?php
                }elseif($situacao == 0){

            ?>
            <div class="status-transporte texto-center vermelho">
                serviço cancelado <img src="icon/cancelado.png" alt="cancelado">
            </div>
            <?php

                }elseif($situacao == 2)
                {

            ?>
            <div class="status-transporte texto-center verde">
                
                CONFIRMADO

            </div>
            <form action="bd/atualizar-status.php" method="POST">
                <input type="text" name="idtransporte" value="<?=$idTransporte?>" id="transporte-id">
                <button class="botao-status" type="submit" name="btn-acaminho">
                    <img src="icon/acaminho.png" alt="finalizar" class="img-status "> A CAMINHO DO CLIENTE
                </button>
            </form>
            <?php
                }elseif($situacao == 3)
                {
            ?>
            <div class="status-transporte texto-center verde">
                
                CONFIRMADO

            </div>

            <form action="bd/transporte-ordem-servico.php?idtransporte=<?=$idTransporte?>" method="POST">
                <button class="botao-status" type="submit" name="btn-nopet">
                    <img src="icon/nopet.png" alt="finalizar" class="img-status "> NO PETSHOP
                </button>
            </form>


            <?php
                }elseif($situacao == 4)
                {
            ?>

            <div class="status-transporte texto-center azul-marinho">
                
                Conclua a O.S para finalizar

            </div>
            <form action="bd/atualizar-status.php" method="POST">
            <input type="text" name="idtransporte" value="<?=$idTransporte?>" id="transporte-id">
                <button class="botao-status" type="submit" name="btn-finalizar-transporte">
                    <img src="icon/verificado.png" alt="finalizar" class="img-status "> FINALIZAR
                </button>
            </form>


            <?php
                }elseif($situacao == 5){
            ?>
            <div class="status-transporte texto-center verde">
                
                Finalizado

            </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>