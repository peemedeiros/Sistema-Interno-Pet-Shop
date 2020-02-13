<?php

    if(isset($_GET['idproduto']) && isset($_GET['carrinho'])){

        require_once('conexao.php');
        $conexao = conexaoMysql();

        $produto = $_GET['idproduto'];
        $carrinho = $_GET['carrinho'];
        $saida_produto = 1;

        $sql = "INSERT INTO carrinho_produto (id_produto, id_carrinho, saida_produto)
        VALUES (".$produto.", ".$carrinho.",".$saida_produto.")";

        if(mysqli_query($conexao, $sql)){
            header('location:../compra.php?carrinho='.$carrinho);
        }

    }

?>