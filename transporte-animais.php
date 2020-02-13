<?php

    require_once('bd/conexao.php');
    $conexao = conexaoMysql();

    $nomeCliente = (String)"Cliente não cadastrado";
    $displayNone =(String)"";
    $alturaMedia = (String)"";
    $idTransporte = (int)0;
    $tabelaColuna = (String) "Adicionar";
    

    if(isset($_GET['idcliente'])){

        $sql = "SELECT * FROM clientes WHERE id = ".$_GET['idcliente'];
        $select = mysqli_query($conexao, $sql);
        $rsConsulta = mysqli_fetch_array($select);

        $nomeCliente = $rsConsulta['nome'];

    }else{

        $tabelaColuna = "Espécie";

        $sql = "SELECT * FROM transporte ORDER BY id DESC LIMIT 1";
        $select = mysqli_query($conexao, $sql);
        if($rsConsulta = mysqli_fetch_array($select)){
            $idTransporte = $rsConsulta['id'];
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
                    <div class="line-step">
                        <div id="progresso-barra"></div>
                    </div>
                    <div class="step    " id="step">
                        2
                    </div>
                    <div class="line-step">
            
                    </div>
                    <div class="step">
                        3
                    </div>
                </div>
                <div class="busca-cliente">
                    <form action="bd/cadastro-de-transporte.php" method="POST" class="selecionar-animais">

                        <div class="linha">
                            <label for="cliente-transporte"><?=$nomeCliente?></label>
                            <input type="text" value="<?=$_GET['idcliente']?>" name="cliente-transporte" id="cliente-transporte">
                        </div>
                        <?php
                            
                        // if(!isset($_GET['idcliente']))
                        // {
                        //     $displayNone = "displayNone";
                        //     $alturaMedia = "alturaMedia";
                        // }
                        ?>
                       

                        <div class="animais-para-transporte ">
                            <?php
                            
                            if(isset($_GET['idcliente']) || isset($_GET['idtransporte']))
                            {

                           
                            
                            ?>
                            <div class="azul-marinho">
                                <div class="td-animal">
                                    Nome do animal
                                </div>

                                <?php
                                    if(isset($_GET['idcliente'])){
                                ?>
                                <div class="td-animal">
                                    Especie
                                </div>
                                <?php
                                    }
                                ?>
                                
                                <div class="td-animal">
                                    <?=$tabelaColuna?>
                                </div>
                            </div>

                            <?php
                                if(isset($_GET['idcliente']))
                                {

                                    $sql = "SELECT animais.nome AS animal, animais.id AS idanimal, clientes.nome, especies.nome AS especie FROM animais
                                            INNER JOIN clientes ON animais.id_dono = clientes.id INNER JOIN especies ON animais.id_especie = especies.id
                                            WHERE clientes.id = ".$_GET['idcliente'];
                                    
                                    $select = mysqli_query($conexao, $sql);

                                    while($rsConsulta = mysqli_fetch_array($select)){

                                
                            ?>
                                <div>
                                    <div class="td-animal">
                                        <?=$rsConsulta['animal']?>
                                    </div>

                                    
                                    <div class="td-animal">
                                        <?=$rsConsulta['especie']?>
                                    </div>
                                   
                                    
                                    <div class="td-animal">
                                        <input type="checkbox" value="<?=$rsConsulta['idanimal']?>" name="checklist[]" class="selecionar-animal">
                                    </div>
                                </div>
                            <?php
                            
                                    }
                                }
                                elseif(isset($_GET['idtransporte']))
                                {

                                    $sql = "select transporte_animal.*, animais.*, animais.nome as cachorro, especies.nome from transporte_animal 
                                    inner join animais on transporte_animal.id_animal = animais.id
                                    inner join especies on animais.id_especie = especies.id where transporte_animal.id_transporte = ".$_GET['idtransporte'];
                                    
                                    $select = mysqli_query($conexao, $sql);

                                    while($rsConsulta = mysqli_fetch_array($select))
                                    {
                            
                            ?>
                                    <div>
                                        <div class="td-animal">
                                            <?=$rsConsulta['cachorro']?>
                                        </div>
                                        
                                        <div class="td-animal">
                                            <?=$rsConsulta['nome']?>
                                        </div>
                                    </div>
                                    <?php
                                    
                                    }

                                }
                            }
                            
                            ?>
                        </div>

                        <div class="adicionar-servico <?=$alturaMedia?>">
                            <div class="azul-marinho">
                                <div class="td-animal">
                                    Serviços
                                </div>

                                <div class="td-animal">
                                    Valor
                                </div>
                                
                                <div class="td-animal">
                                    Adicionar
                                </div>
                            </div>


                            <?php
                                $sqlServico = "SELECT * FROM servicos";

                                $selectServico = mysqli_query($conexao, $sqlServico);

                                while($rsServico = mysqli_fetch_array($selectServico))
                                {

                                
                            ?>
                            <div>
                                <div class="td-animal">
                                    <?=$rsServico['nome']?>
                                </div>

                                <div class="td-animal">
                                    R$ <?=number_format($rsServico['preco'], 2 , ',', '.')?>
                                </div>
                                
                                <div class="td-animal">
                                    <input type="checkbox" value="<?=$rsServico['id']?>" name="checklistservico[]" class="selecionar-animal">
                                </div>
                            </div>
                            <?php
                            
                                }
                            
                            ?>
                        </div>

                        <div class="linha">
                            <button class="botao">
                                <a href="cadastro-transporte.php">
                                    <img src="icon/back.png" alt="voltar">
                                    VOLTAR
                                </a> 
                            </button>

                            
                            
                            <?php
                                if(isset($_GET['idcliente']))
                                {

                                
                            ?>
                            <button class="botao">
                                <a target="_blank" href="cadastro-animal.php?idcliente=<?=$_GET['idcliente']?>&modo=transporte">
                                    <img src="icon/dog.png" alt="animal">
                                    ADICIONAR ANIMAL
                                </a> 
                            </button>
                            <?php
                                }else{
                                    ?>

                            <button class="botao">
                                <a href="cadastro-animal.php?idtransporte=<?=$idTransporte?>">
                                    <img src="icon/dog.png" alt="cadastrarAnimal">
                                    ADICIONAR ANIMAL
                                </a> 
                            </button>
                            <?php
                                }
                            ?>


                            <button type="submit" name="btn-cadastrar-transporte" class="botao">
                                
                                    <img src="icon/check.png" alt="voltar">
                                    CONFIRMAR
                                
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </body>
</html>