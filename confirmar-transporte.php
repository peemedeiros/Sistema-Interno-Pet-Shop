<?php
    require_once('bd/conexao.php');
    $conexao = conexaoMysql();

    $nome = (String)"";
    $telefone = (String)"";
    $celular = (String)"";
    $cep = (String)"";
    $rua = (String)"";
    $numero = (String)"";
    $bairro = (String)"";
    $cidade = (String)"";
    $estado = (String)"";
    $totalServicos = array();
    $valor = (double)0;
    

    if(isset($_GET['idcliente']) && isset($_GET['idtransporte'])){
        if($_GET['idcliente'] != ""){

            $sql = "SELECT * FROM clientes WHERE id = ".$_GET['idcliente'];
            $select = mysqli_query($conexao, $sql);

            if($rsConsulta = mysqli_fetch_array($select)){
                //informações do cliente

                $nome = $rsConsulta['nome'];
                $telefone = $rsConsulta['telefone'];
                $celular = $rsConsulta['celular'];
                
                //endereço

                $cep = $rsConsulta['cep'];
                $rua = $rsConsulta['logradouro'];
                $numero = $rsConsulta['numero'];
                $bairro = $rsConsulta['bairro'];
                $cidade = $rsConsulta['cidade'];
                $estado = $rsConsulta['estado'];
            }
        }else{

            $sql = "SELECT transporte_animal.*, animais.nome_dono AS nomedono, animais.contato_dono AS contatodono
            FROM transporte_animal INNER JOIN animais ON transporte_animal.id_animal = animais.id WHERE transporte_animal.id_transporte = ".$_GET['idtransporte'];

            $select = mysqli_query($conexao, $sql);

            if($rsConsulta = mysqli_fetch_array($select)){

                $nome = $rsConsulta['nomedono'];
                $celular = $rsConsulta['contatodono'];

            }
        }
    }

    $sqlValor = "SELECT servicos.preco, transporte_servico.* FROM servicos 
    INNER JOIN transporte_servico ON servicos.id = transporte_servico.id_servico
    WHERE transporte_servico.id_transporte = ".$_GET['idtransporte'];

    $selectValor = mysqli_query($conexao, $sqlValor);

    while($rsValor = mysqli_fetch_array($selectValor)){
        array_push($totalServicos, $rsValor['preco']);
    }

    $valor = number_format(array_sum($totalServicos), 2 , ',' , '.');



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
        <script src="js/modulo.js"></script>
        <script>
            $(document).ready(function(){
                var auxiliar = true;
                $('#dia-atual-transporte').on('click', function(){
                    if(auxiliar == true){
                        $('#data-transporte').prop('disabled', true);
                        auxiliar =  false;
                    }else{
                        $('#data-transporte').prop('disabled', false);
                        auxiliar =  true;
                    }
                    
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
    <?php
        require_once('modulo/menu.php');
    ?>
        <div class="pagina-inicial-transporte">
            <div class="formulario-agendamento">
                <div class="progresso">
                    <div class="step step-complete">
                        1
                    </div>
                    <div class="line-step step-complete">

                    </div>
                    <div class="step step-complete">
                        2
                    </div>
                    <div class="line-step">
                        <div class="line-step">
                            <div id="progresso-barra"></div>
                        </div>
                    </div>
                    <div class="step" id="step">
                        3
                    </div>
                </div>
                <div class="busca-cliente">
                    <form action="bd/transporte-cadastrado.php" method="POST" class="selecionar-animais">
                        <div class="linha">
                            <h5>Nome<input type="text" name="txt-transporte-cliente" onkeypress="return validarEntrada(event,'numeric');" value="<?=$nome?>" class="nome-cliente-transporte"></h5>
                            <h5>Contato<input type="text" name="txt-transporte-celular" onkeypress="return mascaraFone(this,event);" value="<?=$celular?>" class="nome-cliente-transporte"></h5>
                            <h6><input type="text" name="idtransporte" value="<?=$_GET['idtransporte']?>" class="idtransporte"></h6>
                        </div>
                        <hr>
                        <div class="linha">
                            <h4>Valor do Transporte:
                                R$ <input type="text"  name="valorTransport" id="valorTransporte">
                            </h4>
                            <h4>Valor total dos serviços
                                R$ <input type="text" name="valorServicos" value="<?=number_format(array_sum($totalServicos),2,',','.')?>" id="valorTotalTransporte" readonly>
                            </h4>
                            
                        </div>
                        <div class="linha">
                            <h4>DATA
                                <input type="date" name="dataTransporte" id="data-transporte">
                                <input type="checkbox" name="dataAtual" value="ativado" id="dia-atual-transporte">Para hoje
                            </h4>

                            <h4>HORARIO
                                 <input type="time" name="horarioTransporte" id="horario-transporte">
                            </h4>
                            
                        </div>
                        <hr>
                        <div class="linha">
                            <!-- <h6>Forma de pagamento </h6> -->
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
                            <div>
                                <img src="icon/visa.png" alt="cartao">
                                <img src="icon/mastercard.png" alt="cartao">
                                <img src="icon/money.png" alt="cartao">
                            </div>
                        </div>
                        <hr>    
                        <div class="linha">
                            <h5>CEP <input type="text" name="txt-transporte-cep" onkeypress="return mascaraCep(this,event);"  value="<?=$cep?>" class="nome-cliente-transporte" id="cep"></h5>
                            <h5>Rua <input type="text" name="txt-transporte-rua" value="<?=$rua?>" class="nome-cliente-transporte" id="logradouro"></h5>
                            <h5>Numero <input type="text" name="txt-transporte-numero" onkeypress="return validarEntrada(event,'string');" value="<?=$numero?>" class="nome-cliente-transporte"></h5>
                        </div>   
                        <hr>
                        <div class="linha">
                            <h5>Bairro <input type="text" name="txt-transporte-bairro" value="<?=$bairro?>" class="nome-cliente-transporte" id="bairro"></h5>
                            <h5>Cidade <input type="text" name="txt-transporte-cidade" value="<?=$cidade?>" class="nome-cliente-transporte" id="cidade"></h5>
                            <h5>Estado <input type="text" name="txt-transporte-estado" value="<?=$estado?>" class="nome-cliente-transporte" id="estado"></h5>
                        </div> 
                        <div class="linha">
                            <button class="botao">
                                <a href="transporte-animais.php">
                                    <img src="icon/back.png" alt="voltar">
                                    VOLTAR
                                </a>
                            </button>
                            
                            <button type="submit" name="btn-confirmar-transporte" class="botao">
                                
                                    <img src="icon/check.png" alt="voltar">
                                    CONFIRMAR
                                
                            </button>
                        </div>            
                    </form>
                    
                </div>
                
            </div>
        </div>
        <script src="js/cep.js"></script>
    </body>
</html>