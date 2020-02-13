<?php
    require_once('conexao.php');
    $conexao = conexaoMysql();

    $idtransporte = $_POST['idtransporte'];

    if(isset($_POST['btn-finalizar']))
    {
        $sql = "UPDATE transporte SET situacao = 2 WHERE id = ".$idtransporte;

        if(mysqli_query($conexao, $sql))
        {
            header('location: ../consultar-transporte.php');
        }else
        {
            echo($sql);
        }
    }elseif(isset($_POST['btn-cancelar']))
    {
        $sql = "UPDATE transporte SET situacao = 0 WHERE id = ".$idtransporte;

        if(mysqli_query($conexao, $sql))
        {
            header('location: ../consultar-transporte.php');
        }else
        {
            echo($sql);
        }

    }elseif(isset($_POST['btn-acaminho']))
    {
        $sql = "UPDATE transporte SET situacao = 3 WHERE id = ".$idtransporte;

        if(mysqli_query($conexao, $sql))
        {
            header('location: ../consultar-transporte.php');
        }else
        {
            echo($sql);
        }
    }elseif(isset($_POST['btn-pagar']))
    {

        $forma_pagamento = $_POST['slt-os-pagamento'];

        $sql = "UPDATE ordem_servico SET situacao_pagamento = 1, id_formapagamento = ".$forma_pagamento." WHERE id = ".$_GET['idos'];

        if(mysqli_query($conexao, $sql))
            header('location: ../monitoramento.php');
        else
            echo('erro ao finalizar a OS');

    }elseif(isset($_POST['btn-concluir']))
    {

        $sql = "UPDATE ordem_servico SET situacao = 'F' WHERE id = ".$_GET['idos'];

        if(mysqli_query($conexao, $sql))
            header('location: ../monitoramento.php');
        else
            echo('erro ao finalizar a OS');

    }elseif(isset($_POST['btn-finalizar-transporte'])){

        $sql = "UPDATE transporte SET situacao = 5 WHERE id = ".$idtransporte;

        if(mysqli_query($conexao, $sql))
        {
            header('location: ../consultar-transporte.php');
        }else
        {
            echo($sql);
        }

    }elseif(isset($_POST['btn-fechar'])){

        $sql = "UPDATE ordem_servico SET situacao = 'C' WHERE id = ".$_GET['idos'];

        if(mysqli_query($conexao, $sql))
            header('location: ../monitoramento.php');
        else
            echo('erro ao finalizar a OS');

    }
    

?>