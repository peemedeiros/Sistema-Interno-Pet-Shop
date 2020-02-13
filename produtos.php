<?php
    require_once('bd/conexao.php');
    $conexao = conexaoMysql();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/styles.css">
    <title>
        Augusto's Pet
    </title>
    <script src="js/jquery.js"></script>
    <script src="painel-produtos/js/toggle-menu.js"></script>
    <script>
        $(document).ready(function(){
            //aplica um evento de mudança quando a imagem é selecionada.
            $('#upload-img').change(function(){
                //retornando um objeto com varios atributos, o 'files' é o atributo em que se encontra o arquivo selecionado
                const file =$(this)[0].files[0];
                //ira executar a leitura do arquivo selecionado
                console.log(file);
                
                const fileReader = new FileReader();
                //aplicará a function de adicionar um atributo SRC na tag IMG com o retorno da função readAsDataURL()
                fileReader.onloadend = function(){
                    $('#preview-img').attr('src',fileReader.result);
                }
                //lê o arquivo do tipo FILE e converte para uma URL
                fileReader.readAsDataURL(file);
            });
        });
    </script>
</head>
    <body>
        <div class="pagina-inicial">
            <?php
                require_once('./modulo/menu.php');
            ?>
            <div class="container">
                <?php
                    require_once('modulo/header.php');
                ?>
                <div class="filtros center">
                    <h1 class="titulo texto-center">
                        Painel de produtos
                    </h1>
                    <div class="filtro-linha">
                        <div class="input-txt-layout2">
                            Pesquise produto por nome:
                            <input type="text" class="input-txt border-radius">
                            <button type="submit" class="btn-filtro">

                            </button>
                        </div>

                        <div class="input-txt-layout2">
                            Pesquise produto por código:
                            <input type="text" class="input-txt-medio border-radius">
                            <button type="submit" class="btn-filtro">

                            </button>
                        </div>
                    </div>
                    <div class="filtro-linha">
                        <div class="input-txt-layout2">
                            Pesquise produto por categoria:
                            <select name="slt-categorias" id="categorigas" class="select">
                                <option value="">
                                    Selecione categoria
                                </option>
                            </select>
                            <button type="submit" class="btn-filtro">

                            </button>
                        </div>
                    </div>
                </div>
                <div class="tabela-de-exibicao center">
                    <div class="tabela-cabecalho">
                        <div class="tabela-coluna texto-center">
                            Código
                        </div>
                        <div class="tabela-coluna texto-center">
                            Produto
                        </div>
                        <div class="tabela-coluna texto-center">
                            Preço
                        </div>
                        <div class="tabela-coluna texto-center">
                            Quantidade
                        </div>
                        <div class="tabela-coluna texto-center">
                            Opções
                        </div>
                    </div>

                    <?php
                        $count = (int)1;
                        $cor = (String)"";
                        $sql = "select * from produtos";
                        $select = mysqli_query($conexao, $sql);

                        while($rsProdutos = mysqli_fetch_array($select)){

                            $count +=1;

                            if($count % 2 == 0)
                                $cor = "cor-linha";
                            else
                                $cor = "";
                    ?>
                    <div class="tabela-linha <?=$cor?>">
                        <div class="tabela-coluna texto-center">
                            <?=$rsProdutos['id']?>
                        </div>
                        <div class="tabela-coluna texto-center">
                            <?=$rsProdutos['nome']?>
                        </div>
                        <div class="tabela-coluna texto-center">
                            R$ <?=$rsProdutos['preco']?>
                        </div>
                        <div class="tabela-coluna texto-center">
                            <?=$rsProdutos['quantidade']?>
                        </div>
                        <div class="tabela-coluna texto-center">
                           <a onclick="return confirm('tem certeza que deseja deletar esse registro?'); " href="bd/deletar.php?modo=deletarproduto&id=<?=$rsProdutos['id']?>">
                                <img src="./icon/cancel.png" alt="delete">
                            </a>

                            <a href="#">
                                <img src="./icon/edit.png" alt="editar">
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
                <h1 class="titulo texto-center">
                    cadastre um novo produto
                </h1>
                <form action="bd/inserirProduto.php" method="post" enctype="multipart/form-data" class="formulario-produto center">
                    <div class="form-column">
                        <div class="form-linha">
                            <div class="form-colula">
                                <h2 class="campo">Nome do produto</h2>
                            </div>
                            <div class="form-colula">
                                <input type="text" value="" name="txt-nome-produto" class="form-input">
                            </div>
                        </div>

                        <div class="form-linha">
                            <div class="form-colula">
                                <h2 class="campo">Preço</h2>
                            </div>
                            <div class="form-colula">
                                <input type="text" value="" name="txt-preco-produo" class="form-input-pequeno"> R$
                            </div>
                        </div>
                        
                        <div class="form-linha">
                            <div class="form-colula">
                                <h2 class="campo">Quantidade</h2>
                            </div>
                            <div class="form-colula">
                                <input type="number" value="" name="quantidade-produto" class="form-input-pequeno">
                            </div>
                        </div>
                        <div class="form-linha">
                            <div class="form-colula">
                                <h2 class="campo">Fornecedor</h2>
                            </div>
                            <div class="form-colula">
                                <select name="slt-fornecedor" id="fornecedor">
                                    <option value=""> Selecione um fornecedor</option>
                                    <?php
                                    
                                        $sql = "select * from fornecedores";
                                        $select = mysqli_query($conexao, $sql);

                                        while($rsConsulta = mysqli_fetch_array($select)){
                                    
                                    ?>
                                    <option value="<?=$rsConsulta['id']?>"><?=$rsConsulta['nome']?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-linha">
                            <div class="form-colula">
                                <h2 class="campo">Categoria</h2>
                            </div>
                            <div class="form-colula">
                                <select name="slt-categoria" id="form-categoria">
                                    <option value=""> Selecione uma categoria</option>
                                    <?php
                                    
                                        $sql = "select * from categoria";
                                        $select = mysqli_query($conexao, $sql);

                                        while($rsConsulta = mysqli_fetch_array($select)){
                                    
                                    ?>
                                    <option value="<?=$rsConsulta['id']?>"><?=$rsConsulta['nome']?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-linha">
                            <div class="form-colula">
                                <input value="CADASTRAR" type="submit" class="botao-cadastrar" name="btn-cadastrar-produto">
                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-column">
                        <label id="thumbnail">
                            <input type="file" name="flefoto" id="upload-img">
                            <img src="./icon/camera.svg" alt="camera" id="preview-img">
                        </label>
                    </div>
                </form>
                
                
            </div>
        </div>
    </body>
</html>