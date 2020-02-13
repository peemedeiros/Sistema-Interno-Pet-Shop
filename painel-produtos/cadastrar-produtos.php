<?php
require_once('../bd/conexao.php');
require_once('modulos/verificar-status.php');
    
$conexao = conexaoMysql();

$nome = (String)"";
$preco = (String)"";
$valorCompra = (String)"";
$quantidade = (String)"";
$imagem = (String)"";
$categoria = (String)"Selecione categoria";
$fornecedor =(String)"Selecione fornecedor";
$botao = (String)"CADASTRAR";
$descricao = (String)"";

if(isset($_GET['modo'])){
    if(strtoupper($_GET['modo']) == 'EDITAR'){
        session_start();
        
        $id = $_GET['id'];

        $_SESSION['id']=$id;

        $sql="SELECT produtos.*, fornecedores.nome AS fornecedor, categoria.nome AS categoria
        FROM produtos INNER JOIN fornecedores ON produtos.id_fornecedor = fornecedores.id
        INNER JOIN categoria ON produtos.id_categoria = categoria.id WHERE produtos.id = ".$id;

        $selectProdutos = mysqli_query($conexao, $sql);

        $rsProduto = mysqli_fetch_array($selectProdutos);

        $nome = $rsProduto['nome'];

        $preco = explode(".", $rsProduto['preco']);
        $preco = $preco[0].",".$preco[1];

        $valorCompra = explode(".", $rsProduto['preco_compra']);
        $valorCompra = $valorCompra[0].",".$valorCompra[1];

        $quantidade = $rsProduto['quantidade'];
        $imagem = $rsProduto['imagem'];
        $id_cat = $rsProduto['id_categoria'];
        $id_forn = $rsProduto['id_fornecedor'];
        $categoria = $rsProduto['categoria'];
        $fornecedor = $rsProduto['fornecedor'];
        $botao = "EDITAR";
        $descricao = $rsProduto['descricao'];

    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/painel.css">
        <link rel="stylesheet" href="css/reset.css">
        <script src="js/jquery.js"></script>
        <script src="js/toggle-menu.js"></script>
        <title>.::SIAP-PRODUTOS::.</title>
        <script src="../js/jquery.js"></script>
        <script>
            
        </script>
    </head>
    <body>
        <div class="painel-produtos">
            <?php
                require_once('modulos/menu.php');
            ?>
            <div class="auxiliar"></div>
            <div class="home-painel">
                <div class="container-cadastro-produto">
                    <div class="linha">
                        <div>
                            <img src="img/box.png" alt="home">
                        </div>
                    </div>
                    <h3 class="titulo">
                        Cadastrar produto
                    </h3>
                    <h2 class="empresa-nome">
                        Augusto's Pet
                    </h2>
                    <form action="../bd/inserirProduto.php" enctype="multipart/form-data" method="post" class="formulario-produto">
                        <div class="container-form">
                            <div class="linha-form">
                                <h4>
                                    Nome
                                </h4>
                                <input type="text" id="produto-nome" name="txt-nome-produto" value="<?=$nome?>">
                            </div>

                            <div class="linha-form">
                                <h4>
                                    Preço de Venda
                                </h4>
                                <input type="text" id="produto-preco" name="txt-preco-produo" value="<?=$preco?>">
                            </div>

                            <div class="linha-form">
                                <h4>
                                    Preço de Compra
                                </h4>
                                <input type="text" id="produto-preco-compra" name="txt-preco-produto-compra" value="<?=$valorCompra?>">
                            </div>

                            <div class="linha-form">
                                <h4>
                                    Quantidade
                                </h4>
                                <input type="number" id="produto-quantidade" name="quantidade-produto" value="<?=$quantidade?>">
                            </div>

                            <div class="linha-form">
                                <h4>
                                    Fornecedor
                                </h4>
                                <select name="slt-fornecedor" id="produto-fornecedor">
                                    <option value="<?=$id_forn?>"> <?=$fornecedor?></option>
                                    <?php
                                    
                                        $sqlFornecedor = "SELECT * FROM fornecedores";
                                        $selectFornecedor = mysqli_query($conexao, $sqlFornecedor);

                                        while($rsFornecedor = mysqli_fetch_array($selectFornecedor)){
                                    
                                    ?>
                                    <option value="<?=$rsFornecedor['id']?>"><?=$rsFornecedor['nome']?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="linha-form">
                                <h4>
                                    Categoria
                                </h4>
                                <select name="slt-categoria" id="produto-categoria">
                                    <option value="<?=$id_cat?>"> <?=$categoria?></option>
                                    <?php
                                        $sqlCategoria = "SELECT * FROM categoria";

                                        $selectCategoria = mysqli_query($conexao, $sqlCategoria);

                                        while($rsCategoria = mysqli_fetch_array($selectCategoria)){

                                    
                                    ?>
                                    <option value="<?=$rsCategoria['id']?>"><?=$rsCategoria['nome']?></option>

                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="linha-form-txtarea">
                                <h4>
                                    Descrição
                                </h4>
                                <textarea type="text" id="servico-desc" name="txt-desc-servico"><?=$descricao?></textarea>
                            </div>

                            <div class="linha-form-botao">
                                <input type="submit" value="<?=$botao?>" class="botao-produto" name="btn-cadastrar-produto">
                            </div>
                        </div>
                        <label for="imagem-produto" class="imagem-produto">
                            <?php
                                if(isset($_GET['modo'])){
                                    if(strtoupper($_GET['modo']) == "EDITAR"){
                            ?>
                                <img alt="preview" id="preview-img" src="../bd/arquivos/<?=$imagem?>">
                            <?php
                                    }
                            ?>
                            <?php
                                }else{
                             ?>
                                <img alt="preview" id="preview-img" src="img/camera.png"> 
                            <?php
                                }
                            ?>
                            <input type="file" name="flefoto" id="imagem-produto">
                        </label>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                //aplica um evento de mudança quando a imagem é selecionada.
                $('#imagem-produto').change(function(){
                    //retornando um objeto com varios atributos, o 'files' é o atributo em que se encontra o arquivo selecionado
                    const file =$(this)[0].files[0];
                    //ira executar a leitura do arquivo selecionado
    
                    const fileReader = new FileReader();
                    //aplicará a function de adicionar um atributo SRC na tag IMG com o retorno da função readAsDataURL()
                    fileReader.onloadend = function(){
                        $('#preview-img').attr('src',fileReader.result);
                        $('#preview-img').css({
                            display:'block'
                        });
                    }
                    //lê o arquivo do tipo FILE e converte para uma URL
                    fileReader.readAsDataURL(file);
                });
            });
        </script>
    </body>
</html>