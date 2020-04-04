<?php

    require_once('bd/conexao.php');
    $conexao = conexaoMysql();

    $nome = (String)"";
    $contato = (String)"";
    $animal = (String)"";
    $link = (String)"";
    $action = (String)"";

    $cep = (String)"";
    $logradouro = (String)"";
    $numero = (String)"";
    $bairro = (String)"";
    $cidade = (String)"";
    $uf = (string)"";

    $adicionar = (String) "Adicionar animal";


    if(isset($_GET['idcliente'])){

        $link = (String)"cadastro-animal.php?idcliente=".$_GET['idcliente'];
        $action = "bd/cadastrar-ordem-servico.php?idcliente=".$_GET['idcliente'];
        
        $sql = "SELECT * FROM clientes WHERE id = ".$_GET['idcliente'];

        $select = mysqli_query($conexao, $sql);

        if($rsConsulta = mysqli_fetch_array($select)){
            $nome = $rsConsulta['nome'];
            $contato = $rsConsulta['celular'];

            //endereco cliente
            $cep = $rsConsulta['cep'];
            $logradouro = $rsConsulta['logradouro'];
            $bairro = $rsConsulta['bairro'];
            $cidade = $rsConsulta['cidade'];
            $estado = $rsConsulta['estado'];
            $numero = $rsConsulta['numero'];
        }
    }else{

        $sql = "SELECT * FROM ordem_servico ORDER BY id DESC LIMIT 1";

        $select = mysqli_query($conexao, $sql);

        if($rsConsulta = mysqli_fetch_array($select)){
            $idos = $rsConsulta['id'];

            $sql = "select ordem_servico.*, animais.* from ordem_servico inner join animais on 
            ordem_servico.id_animal = animais.id where ordem_servico.id = ".$idos;

            $selectOrdemAnimal = mysqli_query($conexao, $sql);

            if($rsConsultaAnimal = mysqli_fetch_array($selectOrdemAnimal)){

                if($rsConsultaAnimal['id_animal'] != ""){
                    $adicionar = "Mudar";
                }

                $nome = $rsConsultaAnimal['nome_dono'];
                $contato = $rsConsultaAnimal['contato_dono'];

            }
        }
            

        $link = (String)"cadastro-animal.php?idos=".$idos;
        $action = "bd/cadastrar-ordem-servico.php";

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
        <script src="js/modulo.js"></script>
        <script>
            $(document).ready(function(){
                
                $('#transporteSim').click(function(){
                    $('#endereco-os').css({
                        display:'block',
                        
                    });
                    $('.ativar').attr('required', 'required');
                });
                $('#transporteNao').click(function(){
                    $('#endereco-os').css({
                        display:'none',
                       
                    });
                    $('.ativar').removeAttr('required');
                });
                var count = 0;
                $('#confirmButton').click(function (){
                    count ++;
                    if(count > 1){
                        $(this).css('pointer-events', 'none');
                        $(this).css({'cursor':'no-drop'});
                        return false;
                    }
                })
            });
        </script>
    </head>
    <body>

        <div class="pagina-inicial-transporte">
            <div class="formulario-agendamento-servico">
                <div class="progresso">
                    <div class="step step-complete">
                        1
                    </div>
                    <div class="line-step">

                    </div>
                    <div class="step">
                        2
                    </div>
                    
                </div>
                <form action="<?=$action?>" method="POST" class="cadastrar-ordem-servico" id="formOS">
                    <div class="linha-tabela-orderm">
                        <div class="coluna-tabela-ordem-nome">
                            Animal
                        </div>
                        <div class="coluna-tabela-ordem">
                                <?php
                                    if(isset($_GET['idcliente'])){
                                ?>
                            <select name="slt-animal" id="select-ordem-animal" required>
                                <option value="">Selecione o animal</option>

                                
                                <?php        
                                        $sqlAnimais = " SELECT animais.* FROM animais WHERE animais.ativado = 1 AND animais.id_dono = ".$_GET['idcliente'];

                                        $selectAnimais = mysqli_query($conexao, $sqlAnimais);

                                        while($rsAnimais = mysqli_fetch_array($selectAnimais))
                                        {
                                ?>
                                <option value="<?=$rsAnimais['id']?>"><?=$rsAnimais['nome']?></option>
                                <?php

                                        }
                                    }elseif(isset($_GET['idos'])){
                                        $sqlAnimais = "SELECT ordem_servico.*, animais.nome FROM ordem_servico
                                            INNER JOIN animais ON ordem_servico.id_animal = animais.id WHERE ordem_servico.id =".$_GET['idos'];
                                        
                                        $selectAnimais = mysqli_query($conexao, $sqlAnimais);

                                        if($rsAnimais = mysqli_fetch_array($selectAnimais)){
                                            $animal = $rsAnimais['nome'];
                                        }
                                ?>
                                <input type="text" value="<?=$animal?>" readonly id="">
                                <?php
                                    }else{
                                ?>
                                    <select name="" id="" required >
                                        <option value="" required >Escolha um animal</option>
                                    </select>
                                <?php
                                    }
                                ?>





                            </select>
                            <a href="<?=$link?>"><?=$adicionar?></a>
                        </div>
                    </div>



                    <div class="linha-tabela-orderm margem-bottom-pequena">
                        <div class="coluna-tabela-ordem-nome">
                            Nome do cliente
                        </div>
                        <div class="coluna-tabela-ordem">
                            <input type="text" name="txt-nome-ordem" onkeypress="return validarEntrada(event,'numeric');" value="<?=$nome?>" class='input-ordem'>
                        </div>
                    </div>

                    <div class="linha-tabela-orderm">
                        <div class="coluna-tabela-ordem-nome">
                            Telefone para contato
                        </div>
                        <div class="coluna-tabela-ordem">
                            <input type="text" name="txt-contato-ordem" onkeypress="return mascaraFone(this,event);" value="<?=$contato?>" class="input-ordem">
                        </div>
                    </div>

                    

                    <div class="linha-tabela-orderm ">
                        <div class="coluna-tabela-ordem-nome">
                            Solicitar retorno via Taxi Dog
                        </div>
                        <div class="coluna-tabela-ordem">
                            Sim<input type="radio" value="1" name="rdoTaxiDog" id="transporteSim" required>
                            Não<input type="radio" value="0" name="rdoTaxiDog" id="transporteNao" required>
                        </div>
                    </div>
                    <div id="endereco-os">
                        <div class="linha-endereco-os">
                            <div class="coluna-endereco-os-nome">
                                CEP
                            </div>
                            <div class="coluna-endereco-os flex-justify-start">
                                <input type="text" name="txt-cep-ordem" onkeypress="return mascaraCep(this,event);" value="<?=$cep?>" class="ativar larguraPequeno border-radius-pequena">
                            </div>
                        </div>
                        <div class="linha-endereco-os">
                            <div class="coluna-endereco-os-nome">
                                Rua
                            </div>
                            <div class="coluna-endereco-os flex-justify-start">
                                <input type="text" name="txt-logradouro-ordem" value="<?=$logradouro?>" class="ativar larguraPequeno border-radius-pequena">
                            </div>
                        </div>
                        <div class="linha-endereco-os">
                            <div class="coluna-endereco-os-nome">
                                Numero
                            </div>
                            <div class="coluna-endereco-os flex-justify-start">
                                <input type="text" name="txt-numero-ordem" onkeypress="return validarEntrada(event,'string');" value="<?=$numero?>" class="ativar larguraMini border-radius-pequena">
                            </div>
                        </div>
                        <div class="linha-endereco-os">
                            <div class="coluna-endereco-os-nome">
                                Bairro
                            </div>
                            <div class="coluna-endereco-os flex-justify-start">
                                <input type="text" name="txt-bairro-ordem" value="<?=$bairro?>" class="ativar larguraPequeno border-radius-pequena">
                            </div>
                        </div>
                        <div class="linha-endereco-os">
                            <div class="coluna-endereco-os-nome">
                                Cidade
                            </div>
                            <div class="coluna-endereco-os flex-justify-start">
                                <input type="text" name="txt-cidade-ordem" value="<?=$cidade?>" class="ativar larguraPequeno border-radius-pequena">
                            </div>
                        </div>
                        <div class="linha-endereco-os">
                            <div class="coluna-endereco-os-nome">
                                UF
                            </div>
                            <div class="coluna-endereco-os flex-justify-start">
                                <input type="text" name="txt-uf-ordem" value="<?=$estado?>" class="ativar larguraPequeno border-radius-pequena">
                            </div>
                        </div>
                        <div class="linha-endereco-os">
                            <div class="coluna-endereco-os-nome font-pequena">
                                VALOR TRANSPORTE
                            </div>
                            <div class="coluna-endereco-os flex-justify-start">
                                <input type="text" name="txt-valor-transporte" value="" class="ativar larguraMini border-radius-pequena">
                            </div>
                        </div>
                    </div>
                    
                    <h5 class="texto-center">Selecione os serviços</h5>
                    <hr>

                    <!-- servicos vindos do banco de dados -->
                    <div class="tabela-servicos-ordem">

                    <?php
                    
                        $sqlServicos = "SELECT * FROM servicos WHERE ativado = 1";

                        $selectServicos = mysqli_query($conexao, $sqlServicos);

                        while($rsServicos = mysqli_fetch_array($selectServicos))
                        {

                    ?>



                        <div class="linha-tabela-servicos">
                            <div class="coluna-ordem-servico">
                                <input type="checkbox" name="checklist[]" value="<?=$rsServicos['id']?>" class="checkbox-ordem">
                            </div>
                            <div class="coluna-tabela-servicos">
                                <?=$rsServicos['nome']?>
                            </div>
                            <div class="coluna-tabela-servico-preco">
                                R$ <?=number_format($rsServicos['preco'], 2, ',', '.')?>
                            </div>
                        </div>
                    <?php

                        }

                    ?>
                        <!-- *************************** -->
                    </div>
                    <hr>
                    <div class="linha-tabela-orderm margem-top-pequena margem-bottom-pequena">
                        <div class="coluna-tabela-ordem-nome">
                            Observações
                        </div>
                        <div class="coluna-tabela-ordem">
                            <textarea name="txt-obs-ordem" id="descricao-obs"></textarea>
                        </div>
                    </div>



                    <div class="linha-tabela-servicos">
                        <button id="confirmButton" type="submit" name="btn-cadastrar-ordem" class="botao center">
                            
                            CONFIRMAR
                            <div class='buttonActionCancel'> 
                            
                            </div>
                        </button>
                    </div>  
                </form>
            

            </div>
        </div>
    </body>
</html>