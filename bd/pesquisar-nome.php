<?php
require_once('conexao.php');
$conexao = conexaoMysql();

if(isset($_POST['btn-pesquisar-nome'])){

    $palavra = $_POST['pesquisar-produto'];
    $idcarrinho = $_POST['idcarrinho'];
    $idcliente = $_POST['idcliente'];

    header('location: ../compra.php?carrinho='.$idcarrinho.'&idcliente='.$idcliente.'&produto='.$palavra);

}

?>