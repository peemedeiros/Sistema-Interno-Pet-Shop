<?php

    require_once('bd/conexao.php');
    $conexao = conexaoMysql();

    if(isset($_GET['modo']))
        if(strtoupper($_GET['modo']) == 'CLOSE')
            echo("<script>window.close();</script>");
    
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
            $('#imprimir').click(function(){   
                window.open('modalCompras.php', '_blank');
            });

        </script>
    </head>
    <body>
    <div>
    <div id="container-modal-compras">
        <div id="modal-compras">
        
            
        </div>
    </div>
    </div>
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
            <div class="container-compra">
                
                <?php

                    $sql = "SELECT * FROM clientes WHERE id =".$_GET['idcliente'];
                    $select = mysqli_query($conexao, $sql);
                    $rsCliente = mysqli_fetch_array($select);
                    
                
                ?>
                <div class="conteudo-cliente">
                    <div class="informacoes-cliente">
                        <div class="linha-painel-cliente">
                            <div class="info-cliente-item">
                                <img class="avatar" src="icon/avatar/<?=$rsCliente['avatar']?>" alt="avatar">
                                <input type="text" value="<?=$rsCliente['nome']?> - <?=$rsCliente['email']?>" id="nome-cliente" readonly>
                                <hr>
                                <h3>Endereço</h3>
                                <h5>CEP: <?=$rsCliente['cep']?> </h5> <h5><?=$rsCliente['logradouro']?> - nº<?=$rsCliente['numero']?></h5>
                                <h5><?=$rsCliente['bairro']?></h5>
                                <h5><?=$rsCliente['cidade']?> - <?=$rsCliente['estado']?></h5>
                                <hr>
                        
                                <button class="botao-pequeno">
                                    <a href="cadastrar-cliente.php?idcliente=<?=$_GET['idcliente']?>&modo=editar">
                                        EDITAR
                                    </a>
                                </button>

                                <button class="botao-medio">
                                    <?php
                                        if(isset($_GET['modo'])){
                                    ?>

                                    <a href="cadastro-animal.php?idcliente=<?=$rsCliente['id']?>&modo=<?=$_GET['modo']?>">
                                        NOVO ANIMAL
                                    </a>

                                    <?php
                                        }else{
                                    ?>
                                    <a href="cadastro-animal.php?idcliente=<?=$rsCliente['id']?>">
                                        NOVO ANIMAL
                                    </a>
                                    <?php
                                        }
                                    ?>
                                </button>
                            </div>
                            
                        </div>

                        <h1 class="texto-center">COMPRAS DO CLIENTE</h1>
                        <div class="info-cliente-compras">

                            <div class="tabela-compra">
                                    <div class="thead-linha">
                                    
                                        <div class="thead-coluna">
                                            Data
                                        </div>

                                        <div class="thead-coluna">
                                            Valor da compra
                                        </div>
                                       
                                        <div class="thead-coluna">
                                            Visualizar
                                        </div>
                                        
                                    </div>

                                    <?php
                                        $count = 0;
                                        $cor = "cor-linha";
                                        $sqlCompra = "SELECT * FROM compra where id_cliente = ".$_GET['idcliente'];
                                        $selectCompras = mysqli_query($conexao, $sqlCompra);

                                        while($rsCompras = mysqli_fetch_array($selectCompras))
                                        {
                                            $count++;

                                            if($count % 2 != 0)
                                            {
                                                $cor = "";
                                            }else
                                            {
                                                $cor = "cor";
                                            }
                                            
                                            $data_compra = explode('-', $rsCompras['data_compra']);
                                            $data_compra = $data_compra[2]."/".$data_compra[1]."/".$data_compra[0];

                                        
                                            // $data_hora_compra = $hora_compra[1]."/".$data_compra[1]."/".$data_compra[0];

                                    ?>
                                        
                                    <div class="linha-tabela-compra <?=$cor?>">
                                        <div class="coluna-tabela-compra">
                                            <?=$data_compra?>
                                        </div>

                                        <div class="coluna-tabela-compra">
                                            R$ <?=number_format($rsCompras['preco_total'],2, ',' , '.')?>
                                        </div>
                                        
                                        <div class="coluna-tabela-compra">
                                            <a target="_blank" href="modalCompras.php?idcompra=<?=$rsCompras['id']?>&idcliente=<?=$_GET['idcliente']?>" id="imprimir">
                                                <img src="./icon/lupa.png" alt="read" class="detalhes-compra">
                                            </a>
                                        </div>
                                    </div>
                                    <?php

                                        }
                                    
                                    ?>
                            </div> 
                            
                            
                        </div>
                        <div class="numero-compras">
                            Compras: <?=$count?>
                        </div>

                        <div class="numero-compras">
                            <a href="bd/matarSessoes.php">
                                SAIR
                            </a>
                        </div>
                        
                    </div>

                    <div class="animais-cliente texto-center">
                        <div class="consumir">
                            <button class="botao">
                                <a href="consumir.php?idcliente=<?=$_GET['idcliente']?>">
                                    COMPRAR PRODUTOS
                                </a>
                            </button>

                            <button class="botao">
                                <a href="bd/ordem-servico.php?idcliente=<?=$_GET['idcliente']?>">
                                    CONSUMIR SERVIÇOS
                                </a>
                            </button>
                            
                            
                        </div>
                        <h1 class="texto-center">ANIMAIS CADASTRADOS</h1>

                        <div class="tabela-compra">
                            
                            <div class="thead-linha">
                                
                                <div class="thead-coluna">
                                    Nome
                                </div>
                                <div class="thead-coluna">
                                    Espécie
                                </div>
                                <div class="thead-coluna">
                                    Opções
                                </div>
                                
                            </div>
                            <?php
                                $count = (int) 0;

                                $sql = "select animais.*, especies.nome as especie from
                                animais inner join especies on animais.id_especie = especies.id where animais.id_dono = ".$_GET['idcliente']." and animais.ativado = 1";
                                
                                
                                $select = mysqli_query($conexao, $sql);

                                while($rsConsulta = mysqli_fetch_array($select)){
                                    $count +=1;

                                    if($count % 2 == 0)
                                        $cor = "cor";
                                    else
                                        $cor = "";

                                
                            ?>
                            <div class="linha-tabela-compra <?=$cor?>">
                                <div class="coluna-tabela-compra">
                                    <?=$rsConsulta['nome']?>
                                </div>
                                <div class="coluna-tabela-compra">
                                    <?=$rsConsulta['especie']?>
                                </div>
                                <div class="coluna-tabela-compra">
                                    <a href="bd/deletar.php?modo=deletaranimal&id=<?=$rsConsulta['id']?>&idcliente=<?=$_GET['idcliente']?>">
                                        <img src="./icon/cancel.png" alt="delete">
                                    </a>
                                    
                                </div>
                            </div>
                            <?php
                                }
                            ?>


                                
                              
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>