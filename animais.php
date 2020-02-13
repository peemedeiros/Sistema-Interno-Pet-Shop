<?php
    require_once('bd/conexao.php');
    $conexao = conexaoMysql();
    $nomeAnimal = (String)"";
    $nomeDono = (String)"";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/styles.css">
        <title>SIAP</title>
        <script src="js/jquery.js"></script>
        <script src="painel-produtos/js/toggle-menu.js"></script>
    </head>
    <body>
        <div class="pagina-inicial">
            <?php
                require_once('./modulo/menu.php');
            ?>
            <div class="help">
                <img src="./icon/question.png" alt="ask">
                <div class="devContato">
                    <div>
                        <p>Dúvidas? Entre em contato com o Dev.</p>
                        <br>
                        <p>(11)95881 - 9879</p>
                    </div>
                </div>       
            </div>
            <div class="container">
                <?php
                    require_once('modulo/header.php');
                ?>
                <form action="animais.php" method="get" class="filtros center">
                    <h1 class="titulo texto-center">
                        animais de clientes cadastrados
                    </h1>
                    <div class="filtro-linha">
                        <div class="input-txt-layout2">
                            Pesquise por animal
                            <input type="text" name="nome-animal" class="input-txt border-radius">
                            <button type="submit" name="btn-pesquisar-animal" class="btn-filtro">

                            </button>
                        </div>

                        <div class="input-txt-layout2">
                            Pesquise por dono
                            <input type="text" name="nome-dono" class="input-txt border-radius">
                            <button type="submit" name="btn-pesquisar-dono" class="btn-filtro">

                            </button>
                        </div>
                    </div>
                    <div class="filtro-linha">
                        <div class="input-txt-layout2">
                            filtrar por espécies
                            <select name="slt-categorias" id="categorigas" class="select">
                                <option value="">
                                    Selecione espécie
                                </option>
                                <?php

                                    $sql = "select * from especies where ativado = 1";
                                    $select = mysqli_query($conexao, $sql);
                                    while($rsEspecie = mysqli_fetch_array($select)){
                                ?>
                                <option value="<?=$rsEspecie['id']?>">
                                    <?=$rsEspecie['nome']?>
                                </option>
                                <?php
                                    }   
                                ?>
                            </select>
                            <button type="submit" name="btn-pesquisar-especie" class="btn-filtro">

                            </button>
                        </div>
                    </div>
                </form>

                <div class="tabela-de-exibicao center">
                    <div class="tabela-cabecalho">
                        <!-- CABEÇALHO DA TABELA -->
                        <div class="tabela-coluna texto-center">
                            Nome do animal
                        </div>
                        <div class="tabela-coluna texto-center">
                            Nome do dono
                        </div>
                        <div class="tabela-coluna texto-center">
                            Espécie
                        </div>
                        
                        <div class="tabela-coluna texto-center">
                            Opções
                        </div>
                    </div>
                    <!-- REGISTROS VINDOS DO BANCO -->

                    <!-- PAREI A EDIÇÃO DO CODIGO AQUI, PRECISO RELACIONAR OS ANIMAIS CADASTRADOS
                        AOS CLIENTES CADASTRADOS -->

                        <?php
                            $count = (int)0;
                            $cor =(String)"";

                            if(isset($_GET['btn-pesquisar-animal'])){

                                $nomeAnimal = $_GET['nome-animal'];

                                $sql = "select animais.*,clientes.nome as dono,especies.nome as especie from animais inner join clientes
                                on animais.id_dono = clientes.id inner join especies on animais.id_especie = especies.id where animais.ativado = 1 
                                and animais.nome like '%".$nomeAnimal."%'";

                            }
                            elseif(isset($_GET['btn-pesquisar-dono'])){

                                $nomeDono = $_GET['nome-dono'];

                                $sql = "select animais.*,clientes.nome as dono,especies.nome as especie from animais inner join clientes
                                on animais.id_dono = clientes.id inner join especies on animais.id_especie = especies.id where animais.ativado = 1 
                                and clientes.nome like '%".$nomeDono."%'";
                            }
                            elseif(isset($_GET['slt-categorias'])){

                                $especie = $_GET['slt-categorias'];

                                if($especie){
                                    $sql = "select animais.*,clientes.nome as dono,especies.nome as especie from animais inner join clientes
                                    on animais.id_dono = clientes.id inner join especies on animais.id_especie = especies.id where animais.ativado = 1
                                    and animais.id_especie =".$especie;
                                }else{
                                    $sql = "select animais.*,clientes.nome as dono,especies.nome as especie from animais inner join clientes
                                    on animais.id_dono = clientes.id inner join especies on animais.id_especie = especies.id where animais.ativado = 1";
                                }
                                
                            }
                            else{
                                $sql = "select animais.*,clientes.nome as dono,especies.nome as especie from animais inner join clientes
                                on animais.id_dono = clientes.id inner join especies on animais.id_especie = especies.id where animais.ativado = 1";
                            }
                            
                            

                            $select = mysqli_query($conexao, $sql);

                            while($rsConsulta = mysqli_fetch_array($select)){
                                $count +=1;

                                if($count % 2 == 0)
                                    $cor = "cor";
                                else
                                    $cor = "";
                        ?>
                    <div class="tabela-linha altura-tabela-clientes <?=$cor?>">
                        <div class="tabela-coluna texto-center">
                            <?=$rsConsulta['nome']?>   
                        </div>
                        <div class="tabela-coluna texto-center">
                            <?=$rsConsulta['dono']?> 
                        </div>
                        <div class="tabela-coluna texto-center">
                            <?=$rsConsulta['especie']?> 
                        </div>
                        
                        <div class="tabela-coluna texto-center">
                            <a onclick="return confirm('tem certeza que deseja deletar esse registro?'); " href="bd/deletar.php?modo=deletaranimal&id=<?=$rsConsulta['id']?>">
                                <img src="./icon/cancel.png" alt="delete">
                            </a>
                            <a href="">
                                <img src="./icon/lupa.png" alt="editar">
                            </a>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>