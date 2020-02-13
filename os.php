<?php

require_once('bd/conexao.php');
$conexao = conexaoMysql();

$nome_cliente = (String)"";
$animal = (String)"";
$especie = (String)"";
$contato_cliente = (String)"";
$data_ordem = (String)"";
$horario_ordem = (String)"";
$obs = (String)"";
$transporte = (int)"";
$confirma_transporte = (String)"NÃO";
$confirma_pagamento = (String)"NÃO";
$forma_pagamento = (String)"";

$situacao = (String)"";
$situacao_pagamento = (int)"";
$total = (String)"";

//endereco
$cep = (String)"";
$logradouro = (String)"";
$numero = (String)"";
$bairro = (String)"";
$cidade = (String)"";
$uf = (String)"";

if(isset($_GET['idos'])){

    if($_GET['pagamento'] != 0){

        $sql = "select ordem_servico.*, animais.nome as animal, especies.nome as especie, forma_pagamento.nome as pagamento from ordem_servico
        inner join animais on ordem_servico.id_animal = animais.id inner join forma_pagamento on ordem_servico.id_formapagamento = 
        forma_pagamento.id inner join especies on animais.id_especie = especies.id where ordem_servico.id = ".$_GET['idos'];
        
    }else{

        $sql = "select ordem_servico.*, animais.nome as animal, especies.nome as especie from ordem_servico
        inner join animais on ordem_servico.id_animal = animais.id inner join especies on
        animais.id_especie = especies.id where ordem_servico.id = ".$_GET['idos'];
    }
    

    $select = mysqli_query($conexao, $sql);

    if($rsConsulta = mysqli_fetch_array($select)){

        $nome_cliente = $rsConsulta['nome_cliente'];
        $contato_cliente = $rsConsulta['contato_cliente'];
        $animal = $rsConsulta['animal'];
        $especie = $rsConsulta['especie'];
        
        $data_ordem = explode('-',$rsConsulta['data_ordem']);
        $data_ordem = $data_ordem[2]."/".$data_ordem[1]."/".$data_ordem[0];

        $horario_ordem = date_create($rsConsulta['horario_ordem']);
        $horaio_formatado = date_format($horario_ordem, "H:i");

        $obs = $rsConsulta['obs'];
        $transporte = $rsConsulta['transporte'];
        $situacao = $rsConsulta['situacao'];
        $situacao_pagamento = $rsConsulta['situacao_pagamento'];

        $total = number_format($rsConsulta['total'],2,',','.');

        if($transporte != 0){
            $cep = $rsConsulta['cep'];
            $logradouro = $rsConsulta['logradouro'];
            $numero = $rsConsulta['numero'];
            $bairro = $rsConsulta['bairro'];
            $cidade = $rsConsulta['cidade'];
            $uf = $rsConsulta['uf'];

            $confirma_transporte = "SIM";
        }
        if($situacao_pagamento != 0){
            $confirma_pagamento = "SIM";
            $forma_pagamento = $rsConsulta['pagamento'];
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
        <link rel="stylesheet" href="painel-produtos/css/reset.css">
        <link rel="stylesheet" href="css/ordem-servico.css">
        <script src="js/jquery.js"></script>
        <script>
           
            $(document).ready(function(){
                $('#imprimir').click(function(){
                    $(function(){
                        window.print();
                    });
                });
            });
        </script>
    </head>
    <body>
        <a href="home.php" target="_blank" class="voltar">
            <img src="icon/back.png" alt="back">
        </a>
        <div class="imprimir" id="imprimir">
            <img src="icon/printer.png" alt="back">
        </div>
        <div id="ordem-servico">
            <div class="container center">
                <div class="header">
                    <div class="logo">
                        <img src="img/August_logo.png" alt="logo">
                        <h6>CNPJ: 00000000000000</h6>
                    </div>
                    <div class="htitule">
                        ORDEM DE SERVIÇO
                    </div>
                </div>
                <div class="content">
                    <div class="linha ptop">
                        <div class="coluna-campo">
                            data
                        </div>
                        <div class="coluna-campo">
                            <?=$data_ordem?>
                        </div>
                        <div class="coluna-campo">
                            horario
                        </div>
                        <div class="coluna-campo">
                            <?=$horaio_formatado?>
                        </div>
                    </div>
                    <div class="linha cor justify-start">
                        <div class="coluna-campo ">
                            CLIENTE
                        </div>
                        <div class="coluna-campo justify-start ">
                            <?=$nome_cliente?>
                        </div>
                    </div>
                    <div class="linha justify-start">
                        <div class="coluna-campo">
                            contato
                        </div>
                        <div class="coluna-campo justify-start">
                            <?=$contato_cliente?>
                        </div>
                    </div>
                    <div class="linha cor">
                        <div class="coluna-campo">
                            animal
                        </div>
                        <div class="coluna-campo">
                            <?=$animal?>
                        </div>
                        
                        <div class="coluna-campo">
                            <?=$especie?>
                        </div>
                    </div>
                    <div class="linha ">
                        <div class="coluna-campo">
                            Solicitou Transporte
                        </div>
                        <div class="coluna-campo">
                            <?=$confirma_transporte?>
                        </div>
                    </div>
                    


                        <?php
                            if($transporte != 0){

                        ?>
                    <div class="linha-center cor">
                        <div class="coluna-titulo">
                            Endereço
                        </div>
                    </div>

                    <div class="linha-endereco">
                        <div class="coluna-titulo">
                            CEP: <?=$cep?>
                        </div>
                        <div class="coluna-titulo ">
                            RUA: <?=$logradouro?>
                        </div>
                        <div class="coluna-titulo ">
                            NUmero: <?=$numero?>
                        </div>
                    </div>

                    <div class="linha-endereco">
                        <div class="coluna-titulo">
                            Bairro: <?=$bairro?>
                        </div>
                        <div class="coluna-titulo ">
                            Cidade: <?=$cidade?>
                        </div>
                        <div class="coluna-titulo ">
                            UF: <?=$uf?>
                        </div>
                    </div>

                    <?php
                        }
                    ?>




                    <div class="linha cor">
                        <div class="coluna-campo">
                            PAGO
                        </div>
                        <div class="coluna-campo">
                            <?=$confirma_pagamento?>
                        </div>
                        
                    </div>
                    <div class="linha">
                        <div class="coluna-campo">
                            Forma pagamento
                        </div>
                        <div class="coluna-campo">
                            <?=$forma_pagamento?>
                        </div>
                    </div>
                    <div class="servicos">
                    
                        <div class="linha-servicos thead">

                            <div class="coluna-titulo">
                                SERVIÇO
                            </div>
                            <div class="coluna-titulo">
                                valor
                            </div>

                        </div>

                        <?php

                        
                        $sqlServicos = "select ordem_servico_servico.*, servicos.* from ordem_servico_servico 
                        inner join servicos on ordem_servico_servico.id_servico = servicos.id where 
                        ordem_servico_servico.id_ordem_servico = ".$_GET['idos'];
                        
                        $selectServicos = mysqli_query($conexao, $sqlServicos);

                        $i = 0;
                        $cor = (String)"";

                        while($rsServicos = mysqli_fetch_array($selectServicos)){
                            $i++;

                            if($i % 2 == 0)
                                $cor = "cor";
                            else
                                $cor = "";
                        ?>
                        <div class="linha-servicos <?=$cor?>">

                            <div class="coluna-titulo">
                                <?=$rsServicos['nome']?>
                            </div>
                            <div class="coluna-titulo">
                                R$ <?=number_format($rsServicos['preco'], 2, ',','.')?>
                            </div>

                        </div>
                        <?php
                        }
                        ?>





                        
                    </div>
                    <div class="linha thead">
                        <div class="coluna-campo">
                           
                           </div>
                        <div class="coluna-campo">
                           TOTAL 
                        </div>
                       
                        <div class="coluna-campo">
                           R$ <?=$total?>
                        </div>
                        <div class="coluna-campo">
                           
                        </div>
                    </div>
                    <div class="linha-center">
                        <div class="coluna-titulo">
                            observações
                        </div>
                    </div>
                    <div class="obs">
                        <p><?=$obs?></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>