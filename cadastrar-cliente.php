<?php

require_once('bd/conexao.php');
$conexao = conexaoMysql();
$botao = "CADASTRAR";
$checkM = "";
$checkF = "";
$checkO = "";

$nome = (String)"";
$cpf = (String)"";
$telefone = (String)"";
$celular = (String)"";
$email = (String)"";

$cep = (String)"";
$logradouro = (String)"";
$bairro = (String)"";
$cidade = (String)"";
$estado = (String)"";
$numero = (String)"";



if(isset($_GET['modo'])){
    if(strtoupper($_GET['modo']) == "EDITAR"){

        session_start();

        $_SESSION['id'] = $_GET['idcliente'];

        $sql = "SELECT * FROM clientes WHERE id = ".$_GET['idcliente'];
        
        $select = mysqli_query($conexao, $sql);

        if($rsConsulta = mysqli_fetch_array($select)){
            $nome = $rsConsulta['nome'];
            $cpf = $rsConsulta['cpf'];
            $telefone = $rsConsulta['telefone'];
            $celular = $rsConsulta['celular'];
            $email = $rsConsulta['email'];

            $sexo = $rsConsulta['sexo'];
            if(strtoupper($sexo) == "M")
                $checkM = "checked";
            elseif(strtoupper($sexo) == "F")
                $checkF = "checked";
            else
                $checkO = "checked";

            $cep = $rsConsulta['cep'];
            $logradouro = $rsConsulta['logradouro'];
            $bairro = $rsConsulta['bairro'];
            $cidade = $rsConsulta['cidade'];
            $estado = $rsConsulta['estado'];
            $numero = $rsConsulta['numero'];

            $botao = "EDITAR";
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
        <script src="js/modulo.js"></script>
    </head>
    <body>
    <div class="pagina-inicial-atendimento">
            <?php
                require_once('./modulo/menu.php');
            ?>
            <div class="help">
                <img src="./icon/question.png" alt="ask">
                <div class="devContato">
                    <div>
                        <p>Dúvidas? Entre em contato com o Dev.</p>
                        <br>
                        <p>555-123</p>
                    </div>
                </div>       
            </div>
            <div class="container-atendimento">

            
                <form class="cadastro-cliente" method="POST" action="bd/inserirCliente.php">
                    
                    <div class="cadastro-cliente-col">
                    <h1 class="titulo">
                        CADASTRAR NOVO CLIENTE
                        <h6 class="legenda">Itens marcados com ' <span class="obrigatorio">*</span> ' são obrigatórios</h6>
                    </h1>

                        <div class="text-input">
                            <h6>
                                Nome <span class="obrigatorio">*</span>
                            </h6>
                            <input type="text" name="txt-cliente-nome" onkeypress="return validarEntrada(event,'numeric');" value="<?=$nome?>" class="input-cliente">
                        </div>

                        <div class="text-input">
                            <h6>
                                TELEFONE/CELULAR PARA CADASTRO <span class="obrigatorio">*</span>
                            </h6>
                            <input type="text" placeholder="Ex (11) 999999999" name="txt-cliente-celular" onkeypress="return mascaraFone(this,event);" value="<?=$celular?>" id="telefone-cliente" class="input-cliente">
                        </div>

                        <div class="text-input">
                            <h6>
                                INSTAGRAM
                            </h6>
                            <input type="text" placeholder="@exemplo" name="txt-cliente-email" value="<?=$email?>" class="input-cliente">
                        </div>
                        <h6>Sexo <span class="obrigatorio">*</span></h6>
                        <div class="text-input-sexo">
                        
                            Masculino<input value="M" type="radio" name="rdSexo" class="radio-option" <?=$checkM?>>
                            Feminino<input value="F" type="radio" name="rdSexo" class="radio-option" <?=$checkF?>>
                            Outros<input  Value="O" type="radio" name="rdSexo" class="radio-option" <?=$checkO?>>

                        </div>

                        <div id="separador-linha"></div>


                        <h4>ENDEREÇO <span class="obrigatorio">*</span></h4>
                        <div class="text-input-row bg-unset w100 flex-justify-content-center">
                            <div class="coluna-txt-input">
                                CEP
                            </div>
                            <div class="coluna-txt-input">
                                <input type="text" name="txt-cliente-cep" onkeypress="return mascaraCep(this,event);" value="<?=$cep?>" class="input-cliente-rua" id="cep">
                            </div>
                            
                        </div>

                        <div class="text-input-row bg-unset w100 flex-justify-content-center">
                            
                            <div class="coluna-txt-input">
                                Logradouro
                            </div>
                            <div class="coluna-txt-input">
                                <input type="text" name="txt-cliente-logradouro" value="<?=$logradouro?>" class="input-cliente-rua" id="logradouro">
                            </div>
                            
                        </div>

                        <div class="text-input-row bg-unset w100 flex-justify-content-center">
                            <div class="coluna-txt-input">
                                numero
                            </div>

                            <div class="coluna-txt-input">
                            <input type="text" name="txt-cliente-numero" onkeypress="return validarEntrada(event,'string');" value="<?=$numero?>" class="input-cliente-rua">    
                            </div>
                            
                        </div>


                        <div class="text-input-row bg-unset w100 flex-justify-content-center">
                            <div class="coluna-txt-input">
                                Bairro
                            </div>

                            <div class="coluna-txt-input">
                                <input type="text" name="txt-cliente-bairro" value="<?=$bairro?>" class="input-cliente-rua" id="bairro">
                            </div>
                            
                        </div>

                        <div class="text-input-row bg-unset w100 flex-justify-content-center">
                            
                            <div class="coluna-txt-input">
                                Cidade
                            </div>

                            <div class="coluna-txt-input">
                                <input type="text" name="txt-cliente-cidade" value="<?=$cidade?>" class="input-cliente-rua" id="cidade">
                            </div>
                            
                        </div>

                        <div class="text-input-row bg-unset w100 flex-justify-content-center">
                            
                            <div class="coluna-txt-input">
                                Estado
                            </div>

                            <div class="coluna-txt-input">
                                <input type="text" name="txt-cliente-estado" value="<?=$estado?>" class="input-cliente-estado" id="estado">
                            </div>
                            
                        </div>


                        <div class="text-input">
                            <input type="submit" name="btn-cadastrar-cliente" class="botao" value="<?=$botao?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="js/cep.js"></script>
    </body>
</html>