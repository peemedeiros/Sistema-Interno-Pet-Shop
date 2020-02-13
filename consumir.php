<?php
require_once('bd/conexao.php');
$conexao = conexaoMysql();

if(isset($_GET['idcliente'])){

    $idCliente = $_GET['idcliente'];

    $precoTemp = (double)0;

    if($idCliente != ""){

        $sql = "INSERT INTO carrinho_temporario (id_cliente, preco_temp)
        VALUES(".$idCliente.",".$precoTemp.")";

    }else{

        $sql = "INSERT INTO carrinho_temporario (preco_temp)
        VALUES(".$precoTemp.")";

    }
    
    if(mysqli_query($conexao, $sql)){

        $sqlCarrinho = "SELECT id FROM carrinho_temporario ORDER BY id DESC LIMIT 1";

        $select = mysqli_query($conexao, $sqlCarrinho);

        if($rsCarrinho = mysqli_fetch_array($select)){

            if(isset($idCliente))
                header('location: compra.php?carrinho='.$rsCarrinho['id'].'&idcliente='.$idCliente);
            else
                header('location: compra.php?carrinho='.$rsCarrinho['id'].'&idcliente=');
            
        }
    }
}

?>