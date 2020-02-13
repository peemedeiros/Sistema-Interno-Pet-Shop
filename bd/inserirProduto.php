<?php
session_start();
if(isset($_POST['btn-cadastrar-produto'])){
    
    require_once('conexao.php');
    $conexao = conexaoMysql();

    $nome = $_POST['txt-nome-produto'];
    
    $preco = explode(",", $_POST['txt-preco-produo']);
    $preco = $preco[0].".".$preco[1];

    $precoCompra = explode(",", $_POST['txt-preco-produto-compra']);
    $precoCompra = $precoCompra[0].".".$precoCompra[1];

    $quantidade = $_POST['quantidade-produto'];
    $categoria = $_POST['slt-categoria'];
    $fornecedor = $_POST['slt-fornecedor'];
    $descricao = $_POST['txt-desc-servico'];

    if($_FILES['flefoto']['size'] > 0 && $_FILES['flefoto']['type'] != ""){
        
        $arquivo_size = $_FILES['flefoto']['size'];

        $tamanho_arquivo = round($arquivo_size / 1024);

        $arquivos_permitidos = array("image/jpeg", "image/jpg", "image/png");

        $ext_arquivo = $_FILES['flefoto']['type'];
        if(in_array($ext_arquivo, $arquivos_permitidos)){

            if($tamanho_arquivo < 2048){

                $nome_arquivo = pathinfo($_FILES['flefoto']['name'], PATHINFO_FILENAME);

                $ext = pathinfo($_FILES['flefoto']['name'], PATHINFO_EXTENSION);

                $nome_arquivo_cripty = md5(uniqid(time()).$nome_arquivo);
                
                $foto = $nome_arquivo_cripty.".".$ext;

                $arquivo_temp = $_FILES['flefoto']['tmp_name'];

                $diretorio = "arquivos".DIRECTORY_SEPARATOR;

                if(move_uploaded_file($arquivo_temp, $diretorio.$foto)){

                    if(strtoupper($_POST['btn-cadastrar-produto']) == "CADASTRAR"){

                        $sql = "insert into produtos (nome, preco, preco_compra, quantidade, imagem, descricao, id_categoria, id_fornecedor) values ('".$nome."','".$preco."', ".$precoCompra.", '".$quantidade."','".$foto."','".$descricao."','".$categoria."','".$fornecedor."')";

                        if(mysqli_query($conexao, $sql)){
                            
                            header('location:../painel-produtos/cadastrar-produtos.php');
                        }else{
                            echo ("erro ao executar o script");
                            echo($sql);
                        }

                    }elseif(strtoupper($_POST['btn-cadastrar-produto']) == "EDITAR"){
                        

                        // aqui vira o else if para a futura edição
                        $sql="update produtos set nome='".$nome."', preco=".$preco.", preco_compra=".$precoCompra.", quantidade=".$quantidade." , imagem='".$foto."', descricao='".$descricao."', id_categoria ='".$categoria."', id_fornecedor='".$fornecedor."' where id = ".$_SESSION['id'];

                        if(mysqli_query($conexao, $sql)){
                            header('location:../painel-produtos/visualizar-produtos.php');
                        }else{
                            echo ("erro ao executar o script2");
                        }
                    }
                }else{
                    echo(" nao foi possivel enviar o arquivo para o servidor ");
                }
            }else{
                echo(" Tamanho nao permitido");
            }
        }else{
            echo("Tipo nao permitido");
        }
    }elseif($_FILES['flefoto']['size'] == 0 && $_FILES['flefoto']['type'] == ""){
        if(strtoupper($_POST['btn-cadastrar-produto']) == "EDITAR"){

            $sql="update produtos set nome='".$nome."', preco=".$preco.", preco_compra=".$precoCompra.", quantidade=".$quantidade." , id_categoria ='".$categoria."', id_fornecedor='".$fornecedor."' where id=".$_SESSION['id'];

            if(mysqli_query($conexao, $sql)){
                header('location:../painel-produtos/visualizar-produtos.php');
            }else{
                echo ($sql);
            }
        }elseif(strtoupper($_POST['btn-cadastrar-produto']) == "CADASTRAR"){

            $sql = "insert into produtos (nome, preco, preco_compra, quantidade, descricao, id_categoria, id_fornecedor) values ('".$nome."','".$preco."',".$precoCompra.", '".$quantidade."', '".$descricao."' ,'".$categoria."','".$fornecedor."')";   

            if(mysqli_query($conexao, $sql)){
                header('location:../painel-produtos/visualizar-produtos.php');
            }else{
                echo("erro ao executar o script");
            }
        }
    }
}
?>